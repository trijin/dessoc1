<?
exit();
include('config.inc.php');



$mail->addAddress('trijin@gmail.com', 'Алексей trijin Телепченков');



$mail->Subject = 'DesSoc Тест';
$mail->Body    = 'сообщение с HTML <b>in bold!</b>';
$mail->AltBody = 'Сообщение без HTML';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}