<?

require('config.inc.php');


$app->response->headers->set('Content-Type', 'text/html; charset=utf-8');
$app->get(
	'/',
	function () use ($app) {
		$app->render('main.tpl');
	}
);
// if(gl::$currentSoc['stage']==1) {
$app->map('/stage1/relog/:h',function($h) use ($app){
	if(isset($h) && strlen($h)==32) {
		$user=gl::$db->dessoc_reg[array('hsh'=>$h)];
		if($user!==false && isset($user['id']) && (int)$user['id']>0) {
			setcookie ( 'ds_reg_id', (int)$user['id'], time()+60*60*24*90, '/stage1/', 'dessoc.myexg.ru', false ,true);
			$app->redirect('/stage1/');
			// header('Location: /stage1/');
		}
	}
	echo 'Auth false';
})->via('GET')->conditions(array('h' => '[0-9a-f]{32}'));

$app->map('/stage1/',function() use ($app){
	if($app->request->getPath()=='/stage1') {
		$app->redirect('/stage1/');
	}
	include('inc/stage1.php');
})->via('GET', 'POST');

$app->get('/stage1/pquestion',function() use ($app) {
	include('inc/pquestion.get.php');
});

$app->post('/stage1/pquestion',function() use ($app) {
	include('inc/pquestion.post.php');
});

$app->post('/stage1/showres',function() use ($app) {
	if(isset($_COOKIE['ds_reg_id'])) {
		$us=gl::$db->dessoc_reg[(int)$_COOKIE['ds_reg_id']];
		if($us) {
			$us['show_my_result']=(int)(!$us['show_my_result']);
			$us->update();
			$app->response->headers->set('Content-Type', 'application/javascript');
			 ?>document.location.reload();<? 
		} else {
			$app->response->headers->set('Content-Type', 'application/javascript');
			 ?>alert('Пользователь не найден');<? 
		}
	}
});

$app->get('/stage1/list',function() use ($app) {
	$users=gl::$db->dessoc_reg->order('name');
	$app->view->appendData(array('users' => $users,'ds'=>gl::$currentSoc));
	$app->render('stage1_list.tpl');
});
$app->group('/stage0',function() use ($app){
	//$_SERVER['PHP_AUTH_PW']
	function checkAdminAuth() {
		if(isset($_SESSION['BasicAuth']['DesSoc Stage0']) && $_SESSION['BasicAuth']['DesSoc Stage0']>0) {
			return true;
		}
		$row=gl::$db->dessoc_admins[array('nick'=>$_SERVER['PHP_AUTH_USER'],'pass'=>$_SERVER['PHP_AUTH_PW'],'status'=>1)];
		if($row && (int)$row['id']>0) {
			$_SESSION['BasicAuth']['DesSoc Stage0']=$row['id'];
			return true;
		} else {
			return false;
		}
	}
	if (isset($_SERVER['PHP_AUTH_USER']) && checkAdminAuth()) {
		$app->map('/questions',function() use ($app) {
			include('inc/question.admin.php');
		})->via('GET', 'POST');

		$app->map('/pquestions',function() use ($app) {
			include('inc/pquestion.admin.php');
		})->via('GET', 'POST');

		$app->map('/stages',function() use ($app) {
			include('inc/stages.admin.php');
		})->via('GET', 'POST');

		$app->map('/tests',function(){
			highlight_string(print_r(exif_read_data(ROOT.'/img/4601.orig.jpg'),true));
			$f=scandir(ROOT.'/img/');

			highlight_string(print_r($f,true));
			foreach ($f as $key => $value) {
				if(in_array($value, array('.','..'))) continue;
				echo '<img src="/img/'.$value.'"/><br/>';
			}
		})->via('GET','POST');

	} elseif(preg_match('#^/stage0#', $app->request->getPath())) {
		$app->response->headers->set('WWW-Authenticate', 'Basic realm="DesSoc Stage0"');
		$app->map('/(:q+)',function($q='') use ($app) {
			$app->view->appendData(array('centralMessage' => 'Требуется авторизация'));
			$app->render('main.tpl');
		})->via('GET', 'POST');
	}
});

$app->map('/stage3/',function() use ($app) {
	include('inc/stage3.php');
})->via('GET', 'POST');

$app->map('/stage3/in/:h',function($h) use ($app){
	if(isset($h) && strlen($h)>8) {
		$user=gl::$db->dessoc_hashes[array('passwrd'=>$h,'dessoc_id'=>CURRENT_SOC)];
		if($user!==false && isset($user['id']) && (int)$user['id']>0) {
			$_SESSION['s3_pass_id']=(int)$user['id'];
			$user['activate_at']=time();
			$user->update();
			// setcookie ( 's3_pass_id', (int)$user['id'], time()+60*60*24*90, '/stage3/', 'dessoc.myexg.ru', false ,true);
			$app->redirect('/stage3/');
			// header('Location: /stage1/');
		}
	}
	echo 'Auth false';
})->via('GET')->conditions(array('h' => '[0-9a-z]{8,}'));
$app->get('/statimg',function() use ($app){
	include('inc/stat.image.php');
});
$app->get('/stage4/show/:id',function($id) use ($app){
	if(gl::$currentSoc['stage']==4) {
		$us=gl::$db->dessoc_reg[(int)$id];
		if($us) {
			if($us['show_my_result']==1) {
				$normalQuestionDB=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'aproved'=>'1'))->where('individual=0 OR dessoc_reg_id='.(int)$id)->select('dessoc_questions_block.*, dessoc_questions.*')->order('individual, dessoc_questions_block_id, dessoc_questions.id');
				// var_dump((string)$normalQuestionDB);
				$questions=array();
				$questionsList=array();
				foreach ($normalQuestionDB as $key => $row) {
					foreach ($row as $k => $v) {
						$questions[$key][$k]=$v;
					}
					$questions[$key]['answers']=unserialize($row['answers']);
					$questionsList[]=$row['id'];
				}
				/*
				$personalQuestionDB=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'individual'=>1,'dessoc_reg_id'=>$usersList,'aproved'=>'1'))->select('dessoc_questions_block.*, dessoc_questions.*')->order('dessoc_questions_block_id, dessoc_questions.id');
				$pquestions=array();
				foreach ($personalQuestionDB as $key => $row) {
					foreach ($row as $k => $v) {
						$pquestions[$row['dessoc_reg_id']][$key][$k]=$v;
					}
					$pquestions[$row['dessoc_reg_id']][$key]['answers']=unserialize($row['answers']);
					$questionsList[]=$row['id'];
				}*/


				$answersDB=gl::$db->dessoc_answers->where(array('dessoc_reg_id'=>(int)$id,'dessoc_questions_id'=>$questionsList))->group('dessoc_reg_id, dessoc_questions_id, answer')->select('dessoc_reg_id, dessoc_questions_id, answer, COUNT(id) as cnt');
				$answers=array();
				foreach ($answersDB as $key => $row) {
					$answers[$row['dessoc_questions_id']][$row['answer']]=$row['cnt'];
				}
				$app->view->setData(array(
					'questions' => $questions, //(isset($pquestions[$us['id']])?array_merge($questions,$pquestions[$us['id']]):$questions),
					'answers' => $answers,
					'user' => $us,
					'dessoc' => gl::$currentSoc,
					'urlimage'=> (strlen($us['photo_link'])>0 && is_file(ROOT.$us['photo_link'])?'http://dessoc.myexg.ru'.$us['photo_link']:'')
				));
				$app->render('mail_show.tpl');
			} else {
				$errorText="Пользователь не открыл свою анкету";
			}
		} else {
			$errorText="пользователя не существует";
		}
	} else {
		$errorText="Ожидаем 4го этапа";
	}
	if(isset($errorText) && strlen($errorText)>0) {
		$app->view->appendData(array('centralMessage' => $errorText));
		$app->render('main.tpl');
	}
})->conditions(array('id' => '\d+'));
/*
$app->map('/stage3/test',function() use ($app) {
	$app->view->appendData(array(
		'dessoc' => gl::$currentSoc,
		));
	$app->render('accept.tpl');
})->via('GET', 'POST');
*/
if($app->request->isAjax()) {

	$app->post('/stage3/accept/:answer',function($answ) use ($app){
		$app->response->headers->set('Content-Type', 'application/javascript');
		if((int)$_SESSION['s3_pass_id']>0 && gl::$currentSoc['stage']==3) {
			$us=gl::$db->dessoc_hashes[(int)$_SESSION['s3_pass_id']];
			if($answ=='yes' && $_POST['accept']=='yes') {
				$us['accept']=1;
				$us->update();
				echo 'document.location.reload();';
			} elseif($answ=='no' && $_POST['accept']=='no') {
				$us['accept']=-1;
				$us->update();
				echo 'window.close();';
			}
		}
	})->conditions(array('answer' => '(yes|no){1}'));
	$app->post('/stage3/answ',function() use ($app){
		$app->response->headers->set('Content-Type', 'application/javascript');
		if((int)$_SESSION['s3_pass_id']>0 && gl::$currentSoc['stage']==3) {
			$asw=gl::$db->dessoc_answers[array(
				'dessoc_hashes_id'=>(int)$_SESSION['s3_pass_id'],
				'dessoc_questions_id'=>(int)$_POST['question'],
				'dessoc_reg_id'=>(int)$_POST['user'],
				)];
			if($asw) {
				if($asw['answer']!=$_POST['answerid']) {
					$asw['answer']=$_POST['answerid'];
					$asw->update();
				}
			} else {
				gl::$db->dessoc_answers->insert(array(
					'dessoc_hashes_id'=>(int)$_SESSION['s3_pass_id'],
					'dessoc_questions_id'=>(int)$_POST['question'],
					'dessoc_reg_id'=>(int)$_POST['user'],
					'answer'=>$_POST['answerid']
					));
			}
		} else {
			?>alert('Ошибка авторизации');<?
		}
	});
}
$app->run();


?>