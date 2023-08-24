<?php

session_start();

require 'security_functions.php';
require 'auth_functions.php';
require '../connection.php';
check_logged_out();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../vendors/PHPMailer/src/Exception.php';
require '../../../vendors/PHPMailer/src/PHPMailer.php';
require '../../../vendors/PHPMailer/src/SMTP.php';


if (isset($_POST['resentsend'])) {

    /*
    * -------------------------------------------------------------------------------
    *   Securing against Header Injection
    * -------------------------------------------------------------------------------
    */

    foreach($_POST as $key => $value){

        $_POST[$key] = _cleaninjections(trim($value));
    }

    /*
    * -------------------------------------------------------------------------------
    *   Verifying CSRF token
    * -------------------------------------------------------------------------------
    */

    if (!verify_csrf_token()){

        $_SESSION['STATUS']['resentsend'] = 'Request could not be validated!';
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }


    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "http://localhost:8080/disertation-app/pages/forgotpass.php/?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = 'DATE_ADD(NOW(), INTERVAL 1 HOUR)';

    $email = $_POST['email'];

    $sql = "SELECT id FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0){

            $_SESSION['ERRORS']['emailerror'] = 'There is no account associated with this email!';
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
    }


    $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='password_reset';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }


    $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
            VALUES (?, 'password_reset', ?, ?, " . $expires . ");";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("location:".$_SERVER['HTTP_REFERER']);
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
    $subject = 'Reset Your Password';
    
    /*
    * -------------------------------------------------------------------------------
    *   Using email template
    * -------------------------------------------------------------------------------
    */

    $mail_variables = array();

    $mail_variables['email'] = $email;
    $mail_variables['url'] = $url;

    $message = file_get_contents("../../mail_reset_pass.php");

    foreach($mail_variables as $key => $value) {
        
        $message = str_replace('{{ '.$key.' }}', $value, $message);
    }

    $mail = new PHPMailer(true);

    try {

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
        echo 'Message has been sent';
    } 
    catch (Exception $e) {

        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }

    $_SESSION['STATUS']['resentsend'] = 'verification email sent!';
    header("location:".$_SERVER['HTTP_REFERER']);
    exit();
}
else {

    header("location:".$_SERVER['HTTP_REFERER']);
    exit();
}
