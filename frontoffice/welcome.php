<?php
require 'C:\xampp\htdocs\Motaz\Views\PHPMailer\class.phpmailer.php';
require 'C:\xampp\htdocs\Motaz\Views\PHPMailer\class.smtp.php';
require 'C:\xampp\htdocs\Motaz\Views\PHPMailer\PHPMailerAutoload.php';

if (isset($_GET['Email']) && isset($_GET['Nom'])) {
    $email = $_GET['Email'];
    $Nom = $_GET['Nom'];

    // Send the welcome email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'brahmi.motaz@gmail.com'; // Your Gmail address
    $mail->Password = 'ptcx lldh ewuo jpsv'; // The App Password you created in your Google account
    $mail->SMTPSecure = 'tls'; // Use TLS encryption
    $mail->Port = 587; // SMTP port for TLS

    // Enable SMTP debugging
    $mail->SMTPDebug = 0; 

    // Set up email content
    $mail->setFrom('brahmi.motaz@gmail.com', 'Welcome to Wajahni');
    $mail->addAddress($email); // Recipient's email
    $mail->Subject = 'Welcome to Wajahni';
    $mail->Body = "Hello $Nom,\n\nWelcome to Wajahni! We're excited to have you onboard.\n\nBest regards,\nThe Wajahni Team";

    // Send the email
    if ($mail->send()) {
        // Redirect to login.php after successful email sending
        header("Location: login.php");
        exit(); // Don't forget to call exit to stop further script execution
    } else {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Error: Missing user data.";
}
?>
