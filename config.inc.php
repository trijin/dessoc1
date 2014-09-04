<?
define('ROOT',dirname(__FILE__));
define('VINC_ROOT',dirname(dirname(__FILE__)));
define('CURRENT_SOC',1);
include(VINC_ROOT.'/vendor/autoload.php');

class gl {
	static $mail,$db,$pdo,$currentSoc;
}


$config=array(
	'db_host'=>'',
	'db_name'=>'db_name',
	'db_user'=>'db_user',
	'db_pass'=>'db_pass',
);

gl::$pdo=new PDO(
			"mysql:dbname=".$config['db_name'].(strlen($config['db_host'])>0?";host=".$config['db_host']:''),
			$config['db_user'],
			$config['db_pass'],
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);
// echo 'two';

gl::$db=new NotORM(gl::$pdo);

gl::$currentSoc=gl::$db->dessoc[CURRENT_SOC];

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.example.com';  // Specify main and backup SMTP servers
$mail->Port = 465;  // Specify main and backup SMTP servers
// $mail->SMTPDebug = 2;
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'dessoc@example.com';                 // SMTP username
$mail->Password = 'examplepass';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted// tls
$mail->setLanguage('ru', VINC_ROOT.'/vendor/phpmailer/phpmailer/language/');
$mail->CharSet='UTF-8';
$mail->WordWrap = 70;
$mail->isHTML(true);  
// $mail->AddCustomHeader ('Content-Type: text/html; charset="utf-8"');
// $mail->isMail();


$mail->From = 'dessoc@myexg.ru';
$mail->FromName = 'DespeRados Sociometry';

gl::$mail=&$mail;

session_start();

$app = new \Slim\Slim();

$app->container->singleton('log', function () {
	$log = new \Monolog\Logger('dessoc');
	$log->pushHandler(new \Monolog\Handler\StreamHandler('log/dessoc'.date('ymd').'.log', \Psr\Log\LogLevel::DEBUG));
	return $log;
});

$app->config(array(
	'debug'=>false,
	'view'=>new \Slim\Views\Twig(),
	'templates.path' => ROOT . '/tpl'
));

$app->view->parserOptions = array(
	'debug' => false,
	'charset' => 'utf-8',
	'cache' => ROOT . '/cache',
	'auto_reload' => true,
	'strict_variables' => true,
	// 'autoescape' => true
);
// error_reporting(E_ALL);
$app->view->parserExtensions = array(
	new \Slim\Views\TwigExtension(),
);
/*
$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');*/