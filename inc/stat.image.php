<?

// header("Content-type: image/png");
$app->response->headers->set('Content-Type', 'image/png');

$im = imagecreatetruecolor(350, 170);
$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$black = imagecolorallocate($im, 0, 0, 0);
imagefill($im,0,0,$white);
// Сделаем фон прозрачным
imagecolortransparent($im, $white);

$arr=array(
	'register_count' => gl::$db->dessoc_reg->count(),
	'individual_questions' => gl::$db->dessoc_questions->where('individual=1')->count(),
	'individual_questions_aproved' => gl::$db->dessoc_questions->where('individual=1 AND aproved=1')->count(),
	'stage' => gl::$currentSoc['stage'],
	'hashes_count' => gl::$db->dessoc_hashes->where('dessoc_id='.CURRENT_SOC)->count(),
	'active_hashes_count' => gl::$db->dessoc_hashes->where('activate_at>0 AND dessoc_id='.CURRENT_SOC)->count(),
	'accept_hashes_count' => gl::$db->dessoc_hashes->where('accept=1 AND dessoc_id='.CURRENT_SOC)->count(),
	'ended_hashes_count' => gl::$db->dessoc_hashes->where('all_done=1 AND dessoc_id='.CURRENT_SOC)->count(),
);
$arr2=array(
	'register_count' => 'Зарегистрировано',
	'individual_questions' => 'Индивидуальных вопросов',
	'individual_questions_aproved' => 'Индив-х вопросов одобрено',
	'stage' => 'Этап',
	'hashes_count' => 'Уникальных паролей',
	'active_hashes_count' => 'Из них активировано',
	'accept_hashes_count' => 'Приняли условия',
	'ended_hashes_count' => 'Закончили опрос',
);

/*
Зарегистрировано:
4
Индивидуальных вопросов:
3
Ждут модерации:
0
Этап:
3
Уникальных паролей:
4
Из них активировано:
4
Закончили опрос:
3
$d=imagettfbbox( float $size , float $angle , string $fontfile , string $text )
ключ	содержимое
0	нижний левый угол, X координата
1	нижний левый угол, Y координата
2	нижний правый угол, X координата
3	нижний правый угол, Y координата
4	верхний правый угол, X координата
5	верхний правый угол, Y координата
6	верхний левый угол, X координата
7	верхний левый угол, Y координата
*/

$i=0;
foreach ($arr2 as $key => $value) {
	$d=imagettfbbox( 14 , 0 , ROOT.'/fonts/Roboto-Bold.ttf' , $value.':' );
	$i++;
	$h=$d[1]-$d[7];
	$w=$d[4]-$d[6];
	imagettftext ( $im , 14 , 0 , 300-$w , 20*$i , $black , ROOT.'/fonts/Roboto-Bold.ttf' , $value.':' );
	imagettftext ( $im , 14 , 0 , 320 , 20*$i , $black , ROOT.'/fonts/Roboto-Light.ttf' , $arr[$key] );
}
/*

$d=imagettfbbox( 16 , 0 , ROOT.'/fonts/Roboto-Bold.ttf' , 'Зарегистрировано:' );
$h=$d[1]-$d[7];
$w=$d[4]-$d[6];
imagettftext ( $im , 16 , 0 , 300-$w , 20 , $black , ROOT.'/fonts/Roboto-Bold.ttf' , 'Зарегистрировано:' );
imagettftext ( $im , 16 , 0 , 300-$w , 20 , $black , ROOT.'/fonts/Roboto-Black.ttf' , $arr['register_count'] );


$d=imagettfbbox( 16 , 0 , ROOT.'/fonts/Roboto-Bold.ttf' , 'Зарегистрировано:' );
$h=$d[1]-$d[7];
$w=$d[4]-$d[6];
imagettftext ( $im , 16 , 0 , 300-$w , 20 , $black , ROOT.'/fonts/Roboto-Bold.ttf' , 'Зарегистрировано:' );
imagettftext ( $im , 16 , 0 , 300-$w , 20 , $black , ROOT.'/fonts/Roboto-Black.ttf' , $arr['register_count'] );



/*
// Нарисуем красный прямоугольник
imagefilledrectangle($im, 4, 4, 50, 25, $red);
$colorBackgr       = imageColorAllocate($image, 192, 192, 192);
$colorBlack       = imageColorAllocate($image, 192, 192, 192);
imageColorTransparent($image, $colorBackgr); */
imagePNG($im);
?>