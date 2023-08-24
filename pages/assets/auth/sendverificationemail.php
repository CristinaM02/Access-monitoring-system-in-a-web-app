<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../vendors/PHPMailer/src/Exception.php';
require '../../../vendors/PHPMailer/src/PHPMailer.php';
require '../../../vendors/PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "localhost:8080/disertation-app/pages/assets/auth/verify_mail.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = 'DATE_ADD(NOW(), INTERVAL 1 HOUR)';


    $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='account_verify';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }


    $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
            VALUES (?, 'account_verify', ?, ?, " . $expires . ");";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    }
    else {
        
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sss", $email, $selector, $hashedToken);
        mysqli_stmt_execute($stmt);
    }


    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    $to = $email;
    $subject = 'Verify Your Account';
    
    /*
    * -------------------------------------------------------------------------------
    *   Using email template
    * -------------------------------------------------------------------------------
    */

    $mail_variables = array();

    $mail_variables['email'] = $email;
    $mail_variables['url'] = $url;

    $message = file_get_contents("../../mail_verif_template.php");

    foreach($mail_variables as $key => $value) {
        
        $message = str_replace('{{ '.$key.' }}', $value, $message);
    }


    $mail = new PHPMailer(true);

    try {

      //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'MAIL';
        $mail->Password = 'PASS';
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465;

        $mail->setFrom('MAIL', 'Access Monitor');
        $mail->addAddress($to, 'Access Monitor');


        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent!';
    } 
    catch (Exception $e) {
        echo "Message could not be sent! Mailer Error: {$mail->ErrorInfo}";
        
    }

    /*
    * ------------------------------------------------------------
    *   Script Endpoint 
    * ------------------------------------------------------------
    */
}
else {

    header("Location: ../");
    exit();
}
