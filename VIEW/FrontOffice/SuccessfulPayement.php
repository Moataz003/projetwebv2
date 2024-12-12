<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\ProjetWeb\PHPMailer\Exception.php';
require 'C:\xampp\htdocs\ProjetWeb\PHPMailer\PHPMailer.php';
require 'C:\xampp\htdocs\ProjetWeb\PHPMailer\SMTP.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tgear2023@gmail.com';                     //SMTP username
    $mail->Password   = 'ivaebkwsahnsdhsf';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('tgear2023@gmail.com', 'LA LA');
    $mail->addAddress('fahd.bhm360@gmail.com', 'Fahd');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tiziwizou mech3aleni abdennour';
    $mail->Body    = 'Hello world ! <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}