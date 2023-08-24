<?php

session_start();
require 'auth_functions.php';
require 'security_functions.php';
require 'datacheck.php';
require '../connection.php';

check_logged_out();
if (isset($_POST['submit'])) {
    /*
     * -------------------------------------------------------------------------------
     *   Securing against Header Injection
     * -------------------------------------------------------------------------------
     */

    foreach ($_POST as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
    }

    /*
     * -------------------------------------------------------------------------------
     *   Verifying CSRF token
     * -------------------------------------------------------------------------------
     */

    if (!verify_csrf_token()) {
        $_SESSION["STATUS"]["signupstatus"] = "Request could not be validated!";
        unset($_SESSION['ERRORS']['usernameerror']);
        unset($_SESSION['ERRORS']['emailerror']);
        unset($_SESSION['ERRORS']['passworderror']);
        unset($_SESSION['ERRORS']['imageerror']);
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
    }
    // Verify if form values are not empty
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirmpassword)) {
        // clean the form data before sending to database
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);
        $confirmpassword = mysqli_real_escape_string($conn, $confirmpassword);
        // perform validation
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $_SESSION['ERRORS']['usernameerror'] = 'Only alphanumeric characters are allowed!';
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['emailerror']);
            unset($_SESSION['ERRORS']['passworderror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['ERRORS']['emailerror'] = 'The email format is invalid!';
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['usernameerror']);
            unset($_SESSION['ERRORS']['passworderror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        if (!availableUsername($conn, $username)) {
            $_SESSION["ERRORS"]["usernameerror"] = "This username is not available!";
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['emailerror']);
            unset($_SESSION['ERRORS']['passworderror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        if (!availableEmail($conn, $email)) {
            $_SESSION["ERRORS"]["emailerror"] = "There already exists an account associated with this email!";
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['usernameerror']);
            unset($_SESSION['ERRORS']['passworderror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        if ($password !== $confirmpassword) {
            $_SESSION["ERRORS"]["passworderror"] = "The passwords don't match!";
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['usernameerror']);
            unset($_SESSION['ERRORS']['emailerror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }

        /*
         * -------------------------------------------------------------------------------
         *   Image Upload
         * -------------------------------------------------------------------------------
         */

        $FileNameNew = "defaultUser.png";
        $file = $_FILES["avatar"];

        if (!empty($_FILES["avatar"]["name"])) {
            $fileName = $_FILES["avatar"]["name"];
            $fileTmpName = $_FILES["avatar"]["tmp_name"];
            $fileSize = $_FILES["avatar"]["size"];
            $fileError = $_FILES["avatar"]["error"];
            $fileType = $_FILES["avatar"]["type"];

            $fileExt = explode(".", $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = ["jpg", "jpeg", "png", "gif"];
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 10000000) {
                        $FileNameNew = uniqid("", true) . "." . $fileActualExt;
                        $fileDestination =
                            "../../../images/user_uploads/" . $FileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                    } else {
                        $_SESSION["ERRORS"]["imageerror"] = "The image size should be less than 10MB!";
                        unset($_SESSION["STATUS"]["signupstatus"]);
                        unset($_SESSION['ERRORS']['usernameerror']);
                        unset($_SESSION['ERRORS']['emailerror']);
                        unset($_SESSION["ERRORS"]["passworderror"]);
                        header("location:".$_SERVER['HTTP_REFERER']);
                        exit();
                    }
                } else {
                    $_SESSION["ERRORS"]["imageerror"] = "Upload failed, please retry!";
                    unset($_SESSION["STATUS"]["signupstatus"]);
                    unset($_SESSION['ERRORS']['usernameerror']);
                    unset($_SESSION['ERRORS']['emailerror']);
                    unset($_SESSION["ERRORS"]["passworderror"]);
                    header("location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            } else {
                $_SESSION["ERRORS"]["imageerror"] = "Invalid format; only .jpg, .jpeg, .png and .gif are allowed!";
                unset($_SESSION["STATUS"]["signupstatus"]);
                unset($_SESSION['ERRORS']['usernameerror']);
                unset($_SESSION['ERRORS']['emailerror']);
                unset($_SESSION["ERRORS"]["passworderror"]);
                header("location:".$_SERVER['HTTP_REFERER']);
                exit();
            }
        }
        /*
         * -------------------------------------------------------------------------------
         *   User Creation
         * -------------------------------------------------------------------------------
         */
        
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "insert into users(username, email, password, role, creationdate, image, is_active, is_verified) 
                values ('{$username}', '{$email}', '{$hashedPwd}', 'User', now(), '{$FileNameNew}', 'Yes', 'No')";
        $sqlQuery = mysqli_query($conn, $sql);
        if (!$sqlQuery) {
            die("MySQL query failed!" . mysqli_error($conn));
        } else {
            /*
             * -------------------------------------------------------------------------------
             *   Sending Verification Email for Account Activation
             * -------------------------------------------------------------------------------
             */

            require "sendverificationemail.php";
            $_SESSION["STATUS"]["loginstat"] = "Account created";
            header("location:../../../index.php");
            exit();
        }
    } else {
        if (empty($username)) {
            $_SESSION['ERRORS']['usernameerror'] = 'Username cannot be empty!';
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['emailerror']);
            unset($_SESSION['ERRORS']['passworderror']);
            unset($_SESSION['ERRORS']['imageerror']);
           header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($email)) {
            $_SESSION['ERRORS']['emailerror'] = 'Email cannot be empty!';
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['usernameerror']);
            unset($_SESSION['ERRORS']['passworderror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        if (empty($password) || empty($confirmpassword)) {
            $_SESSION["ERRORS"]["passworderror"] = "Password cannot be empty!";
            unset($_SESSION["STATUS"]["signupstatus"]);
            unset($_SESSION['ERRORS']['usernameerror']);
            unset($_SESSION['ERRORS']['emailerror']);
            unset($_SESSION['ERRORS']['imageerror']);
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
} else {
    
    header("location:".$_SERVER['HTTP_REFERER']);
    exit();
}
?>
