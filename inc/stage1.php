<?
$salt='4$h5jmy2wfg9fERBdTZp7K#!drfycQvZOWPOWtHqDYSXIF1k!N';
// echo __LINE__.'<br/>';
	$app->view->appendData(array('headTitle' => 'Регистрация на DesСоцОпрос'));

if(isset($_COOKIE['ds_reg_id']) && (int)$_COOKIE['ds_reg_id']>0) {
	$us=gl::$db->dessoc_reg[$_COOKIE['ds_reg_id']];
	if(!$us) {
		setcookie ( 'ds_reg_id', '', -1000, '/stage1/', 'dessoc.myexg.ru', false ,true);
		$app->redirect('/stage1/');
	} else {
		// $app->view->appendData(array('headTitle' => 'Регистрация на DesСоцОпрос'));
		$app->view->appendData(array('user' => $us,'ds'=>gl::$currentSoc));
		$app->render('stage1_info.tpl');
	}
} elseif(isset($_POST['name']) && gl::$currentSoc['stage']==1) {
	$_SESSION['error']=array();
	if(strlen($_POST['name'])<5) {
		$_SESSION['error']['name']="Длина имени что-то коротковата";
	}
	if(strlen($_POST['nick'])<3) {
		$_SESSION['error']['nick']="Длина ника что-то коротковата";
	}
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['error']['email']="Ошибка е-мейла";
	}
	$img=false;
	if(isset($_POST['photo_link']) && strlen($_POST['photo_link'])>10) {
		// echo 'img1';
		$img=imagecreatefromstring(file_get_contents($_POST['photo_link']));
		if($img===false) {
			$_SESSION['error']['img_url']="Ошибка блин1";
		}

	} elseif($_FILES['photo_file'] && $_FILES['photo_file']['tmp_name']) {
		// echo 'img2';
		$img=imagecreatefromstring(file_get_contents($_FILES['photo_file']['tmp_name']));
		if($img===false) {
			$_SESSION['error']['img_url']="Ошибка блин2".$_FILES['photo_file']['tmp_name'];
		}
	}
	// var_dump($img);
	if($img!==false) {
		// echo 'img3';
		$w=imagesx($img);
		$h=imagesy($img);
		$img_url='/img/'.rand(1000,9999).'.jpg';
		$img_url_orig='/img/'.rand(1000,9999).'.orig.jpg';
		$imgFile=ROOT.$img_url;

		if(max($w,$h)>400) {
			if($w>$h) {
				$nw=400;
				$nh=round(400*$h/$w);
			} else {
				$nw=round(400*$w/$h);;
				$nh=400;
			}
			$thumb = imagecreatetruecolor($nw, $nh);
			imagecopyresized($thumb, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);

			imagejpeg($thumb,$imgFile,95);
			imagejpeg($img,$imgFile.'.orig',95);
		} elseif(min($w,$h)>100) {
			imagejpeg($img,$imgFile,95);
		}
		
	} else {
		// echo 'img4';
		$img_url='';
	}

	if(count($_SESSION['error'])==0) {
		// $hash=md5($salt)
		$arr=array(
			'name'=>trim(strip_tags($_POST['name'])),
			'nick'=>trim(strip_tags($_POST['nick'])),
			'email'=>trim(strip_tags($_POST['email'])),
			'photo_link'=>$img_url
			);
		$hash=md5($salt.$arr['email']);
		$arr['hsh']=$hash;
		// highlight_string(print_r($arr,true));
		$row=gl::$db->dessoc_reg->insert($arr);
		// highlight_string(print_r((array)$row,true));
		if((int)$row['id']>0) {
			setcookie ( 'ds_reg_id', (int)$row['id'], time()+60*60*24*90, '/stage1/', 'dessoc.myexg.ru', false ,true);
			gl::$mail->addAddress($_POST['email'],$_POST['nick']);



			gl::$mail->Subject = 'DesSoc: Регистрация на первый опрос';
			gl::$mail->Body    = 'Регистрация прошла успешно, если вы получили это письмо.<br/>Вы можете залогинится для изменений профиля используя <a href="http://dessoc.myexg.ru/stage1/relog/'.$hash.'">эту ссылку</a>';
			gl::$mail->AltBody = 'Регистрация прошла успешно, если вы получили это письмо.'."\n".'Вы можете залогинится для изменений профиля используя эту ссылку: http://dessoc.myexg.ru/stage1/relog/'.$hash.' ';
			gl::$mail->send();
		} else {
			$_SESSION['error']['register']="Регистрация не удалась. Возможно вы уже зарегистрированы.";
		}
	}
	// highlight_string(print_r($_POST,true));
	// highlight_string(print_r($_FILES,true));
	$app->redirect('/stage1/');
	// header('Location: /stage1/');
} elseif(gl::$currentSoc['stage']==1) {
	$error='';
	if(isset($_SESSION['error']) && count($_SESSION['error'])>0) {
		$error='<div style="color:red;"><b>'.implode("<br/>\n",$_SESSION['error']).'</b></div>';
	}
	$app->view->appendData(array('myerror' => $error));
	$app->render('stage1_reg.tpl');

} else {
	$app->view->appendData(array('centralMessage' => 'Регистрация закрыта'));
	$app->render('main.tpl');
}