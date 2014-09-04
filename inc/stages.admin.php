<?
function el($l) {
	echo $l.'<br/>';
}
// register_count

$app->view->appendData(array(
	'register_count' => gl::$db->dessoc_reg->count(),
	'individual_questions' => gl::$db->dessoc_questions->where('individual=1')->count(),
	'need_moderate' => gl::$db->dessoc_questions->where('individual=1 AND aproved=0')->count(),
	'stage' => gl::$currentSoc['stage'],
	'hashes_count' => gl::$db->dessoc_hashes->where('dessoc_id='.CURRENT_SOC)->count(),
	'active_hashes_count' => gl::$db->dessoc_hashes->where('activate_at>0 AND dessoc_id='.CURRENT_SOC)->count(),
	'ended_hashes_count' => gl::$db->dessoc_hashes->where('all_done=1 AND dessoc_id='.CURRENT_SOC)->count(),
	'results_dended_count' => gl::$db->dessoc_reg->where('result_sended=1')->count(),
	));

function generateUniquePass() {
	$sym='abcdefghijklmnopqrstuvwxyz0123456789';
	$len=10;
	// $symAr=array();
	// $symLen=strlen($sym);
	$symAr=str_split($sym);
	// for($i=0;$i<$symLen;$i++) $symAr[]=$sym[$i];
	shuffle($symAr);
	$symAr=array_flip($symAr);
	$code=implode('',array_rand($symAr,$len));

	while(gl::$db->dessoc_hashes[array('passwrd'=>$code)]) {
		$code=implode('',array_rand($symAr,$len));
	}
	return $code;
}

if($app->request->isAjax()) {
	if(isset($_POST['a'])) {
		switch ($_POST['a']) {
			case 'value':
				# code...
				break;

			case 'nextStage':
					gl::$currentSoc['stage']=gl::$currentSoc['stage']+1;
					gl::$currentSoc->update();
				break;
			
			case 'sendHashes':
					$users=gl::$db->dessoc_reg->where('hash_sended=0')->order('RAND()')->limit(10);
					gl::$mail->Subject = 'DesSoc: Ваша персональная ссылка «'.gl::$currentSoc['name'].'»';
					foreach ($users as $id => $us) {
						$pass=generateUniquePass();

						gl::$mail->addAddress($us['email'],$us['nick']);

						gl::$mail->Body    = 'Ваша персональнальная уникальная ссылка для прохождения Анонимного опроса «'.gl::$currentSoc['name'].'»: <a href="http://dessoc.myexg.ru/stage3/in/'.$pass.'">http://dessoc.myexg.ru/stage3/in/'.$pass.'</a>';
						gl::$mail->AltBody = 'Ваша персональнальная уникальная ссылка для прохождения Анонимного опроса «'.gl::$currentSoc['name'].'»: http://dessoc.myexg.ru/stage3/in/'.$pass.' ';
						// var_dump(gl::$mail);
						# code...
						// echo $us['nick'].' <'.$us['email'].'> - '.$pass."\n";
						if(gl::$mail->send()) {
							gl::$db->dessoc_hashes->insert(array(
								'passwrd'=>$pass,
								'dessoc_id'=>CURRENT_SOC
								));
							$us['hash_sended']=1;
							$us->update();
						}

						gl::$mail->clearAddresses();
					}
					


				break;
			case 'sendResults':
					if(gl::$currentSoc['stage']==4) {
						$users=gl::$db->dessoc_reg->where('result_sended=0')->order('RAND()')->limit(10);
						$usersList=array();
						foreach ($users as $key => $value) {
							$usersList[]=$value['id'];
						}
						$normalQuestionDB=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'individual'=>0))->select('dessoc_questions_block.*, dessoc_questions.*')->order('dessoc_questions_block_id, dessoc_questions.id');
						$questions=array();
						$questionsList=array();
						foreach ($normalQuestionDB as $key => $row) {
							foreach ($row as $k => $v) {
								$questions[$key][$k]=$v;
							}
							$questions[$key]['answers']=unserialize($row['answers']);
							$questionsList[]=$row['id'];
						}
						$personalQuestionDB=gl::$db->dessoc_questions->where(array('dessoc_id'=>CURRENT_SOC,'individual'=>1,'dessoc_reg_id'=>$usersList,'aproved'=>'1'))->select('dessoc_questions_block.*, dessoc_questions.*')->order('dessoc_questions_block_id, dessoc_questions.id');
						$pquestions=array();
						foreach ($personalQuestionDB as $key => $row) {
							foreach ($row as $k => $v) {
								$pquestions[$row['dessoc_reg_id']][$key][$k]=$v;
							}
							$pquestions[$row['dessoc_reg_id']][$key]['answers']=unserialize($row['answers']);
							$questionsList[]=$row['id'];
						}
						// var_dump($pquestions);
						$answersDB=gl::$db->dessoc_answers->where(array('dessoc_reg_id'=>$usersList,'dessoc_questions_id'=>$questionsList))->group('dessoc_reg_id, dessoc_questions_id, answer')->select('dessoc_reg_id, dessoc_questions_id, answer, COUNT(id) as cnt');
						$answers=array();
						foreach ($answersDB as $key => $row) {
							$answers[$row['dessoc_reg_id']][$row['dessoc_questions_id']][$row['answer']]=$row['cnt'];
						}
						gl::$mail->Subject = 'DesSoc: Результаты опроса.';
						foreach ($users as $key => $us) {
							$app->view->setData(array(
								'questions' => (isset($pquestions[$us['id']])?array_merge($questions,$pquestions[$us['id']]):$questions),
								'answers' => $answers[$us['id']],
								'user' => $us,
								'dessoc' => gl::$currentSoc,
								'urlimage'=> (strlen($us['photo_link'])>0 && is_file(ROOT.$us['photo_link'])?'http://dessoc.myexg.ru'.$us['photo_link']:'')
							));
							// $app->response->headers->set('Content-Type', 'text/html; charset=UTF-8');
							$m=$app->view->render('mail_clean.tpl');

							// echo $m;
							gl::$mail->addAddress($us['email'],$us['nick']);
							// gl::$mail->addAddress('trijin@gmail.com',$us['nick']);
							gl::$mail->Body=$m;
							if(gl::$mail->send()) {
								$us['result_sended']=1;
								$us->update();
							}
							gl::$mail->clearAddresses();
						}
					}
				break;

			
			default:
				# code...
				break;
		}
		$app->response->headers->set('Content-Type', 'application/javascript');
		 ?>document.location.reload();<? 
	}
} else {
	$app->render('stages.admin.tpl');
}
?>