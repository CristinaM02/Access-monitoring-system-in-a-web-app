<?php

session_start();
require 'auth_functions.php';
require 'security_functions.php';
require 'datacheck.php';
require '../connection.php';

if (isset($_POST['submitpass'])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
    }

    if (!verify_csrf_token()) {
        $_SESSION["STATUS"]["changepass"] = "Request could not be validated!";
        unset($_SESSION['ERRORS']['oldpassworderror']);
        unset($_SESSION['ERRORS']['newpassworderror']);
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
    // Verify if form values are not empty
    $oldpassword = $_POST["oldpassword"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    if (!empty($oldpassword) && !empty($password) && !empty($confirmpassword)) {
        // clean the form data before sending to database
        $oldpassword = mysqli_real_escape_string($conn, $oldpassword);
        $password = mysqli_real_escape_string($conn, $password);
        $confirmpassword = mysqli_real_escape_string($conn, $confirmpassword);
        // perform validation

        if ($password !== $confirmpassword) {
            $_SESSION["ERRORS"]["newpassworderror"] = "The passwords don't match!";
            unset($_SESSION['ERRORS']['oldpassworderror']);
            unset($_SESSION['ERRORS']['changepass']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }

        $uid = $_SESSION['id'];
        echo $uid;
        $sql = "SELECT Password FROM users where ID = $uid;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        echo $row['Password'];
         $pwdCheck = password_verify($oldpassword, $row['Password']);

        if ($pwdCheck == false) {
            $_SESSION['ERRORS']['oldpassworderror'] = "Wrong password!";
            unset($_SESSION['ERRORS']['newpassworderror']);
            unset($_SESSION["ERRORS"]["changepass"]);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        else{
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '{$hashedPwd}' where ID = $uid;";
        $sqlQuery = mysqli_query($conn, $sql);
        if (!$sqlQuery) {
            die("MySQL query failed!" . mysqli_error($conn));
        } else {
            unset($_SESSION['ERRORS']['oldpassworderror']);
            unset($_SESSION['ERRORS']['newpassworderror']);
            unset($_SESSION["ERRORS"]["changepass"]);
        header("location:".$_SERVER['HTTP_REFERER']);
        }
     } }else {
        if (empty($password) || empty($confirmpassword) || empty($oldpassword)) {
            $_SESSION["ERRORS"]["changepass"] = "Fields cannot be empty!";
            unset($_SESSION['ERRORS']['oldpassworderror']);
            unset($_SESSION['ERRORS']['newpassworderror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
    } 
} else {
    
    header("location:".$_SERVER['HTTP_REFERER']);
    exit();
} 
?>
