<?php

function check_logged_in() {

    if (isset($_SESSION['auth'])){
        return true;
    }
    else {
        header("Location: ../../../index.php");
        exit();
    }
}

function check_logged_in_butnot_verified(){

    if (isset($_SESSION['auth'])){

        if ($_SESSION['auth'] == 'loggedin') {
    
            return true;
        }
        elseif ($_SESSION['auth'] == 'verified') {

            header("Location: ../home/");
            exit(); 
        }
    }
    else {

        header("Location: ../login/");
        exit();
    }
}

function check_logged_out() {

    if (!isset($_SESSION['auth'])){
        return true;
    }
    else {
        if($_SESSION['role'] == 'Admin'){
            header("Location: pages/admin/dashboard.php"); 
        }   
        else if($_SESSION['role'] == 'User'){
            header("Location: pages/user/home.php");
        } 
        exit();
    }
}

function check_verified() {

    if (isset($_SESSION['auth'])) {

        if ($_SESSION['auth'] == 'verified') {

            return true;
        }
        elseif ($_SESSION['auth'] == 'loggedin') {

            header("Location: ../verify/");
            exit(); 
        }
    }
    else {

        header("Location: ../login/");
        exit();
    }
}

function check_remember_me() {

    require 'pages/assets/connection.php';
    
    if (empty($_SESSION['auth']) && !empty($_COOKIE['rememberme'])) {
        
        list($selector, $validator) = explode(':', $_COOKIE['rememberme']);

        $sql = "SELECT * FROM auth_tokens WHERE auth_type='remember_me' AND selector=? AND expires_at >= NOW() LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            // SQL ERROR
            return false;
        }
        else {
            
            mysqli_stmt_bind_param($stmt, "s", $selector);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if (!($row = mysqli_fetch_assoc($results))) {

                // COOKIE VALIDATION FAILURE
                return false;
            }
            else {

                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['token']);

                if ($tokenCheck === false) {

                    // COOKIE VALIDATION FAILURE
                    return false;
                }
                else if ($tokenCheck === true) {

                    $email = $row['user_email'];
                    
                    return $email;
                }
            }
        }
    }
}
