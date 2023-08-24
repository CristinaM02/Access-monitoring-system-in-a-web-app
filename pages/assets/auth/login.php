<?php
    
   session_start();
   require 'auth_functions.php';
   require 'user_info.php';
   require 'security_functions.php';
   require '../connection.php';
   
    check_logged_out();

    if(isset($_POST['login'])) {

        foreach($_POST as $key => $value){

            $_POST[$key] = _cleaninjections(trim($value));
        }
    
        if (!verify_csrf_token()){
    
            $_SESSION['STATUS']['loginstatus'] = 'Request could not be validated!';
            unset($_SESSION['ERRORS']['wrongpassword']);
            unset($_SESSION['ERRORS']['nouser']);
            header("Location: ../../../index.php");
            exit();
        }

        $email_signin        = $_POST['email'];
        $password_signin     = $_POST['password'];
        // clean data 
        $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
        $pswd = mysqli_real_escape_string($conn, $password_signin);
        // Query if email exists in db
        $sql = "SELECT * From users WHERE email = '{$user_email}' ";
        $query = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($query);
        $stmt = mysqli_stmt_init($conn);
        $sql_log = "INSERT INTO login_logs(user_email, userid, ip, device, browser, os, country, countrycode, region, city, lat, lon, status, error) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_log = mysqli_stmt_init($conn);

        $user_info = json_decode (file_get_contents('http://ip-api.com/json/?fields=status,message,country,countryCode,regionName,city,lat,lon,mobile,query'),true);
        if($user_info && $user_info['status'] == 'success' && $user_info['mobile']) {$device = 'Mobile';} else {$device = 'Desktop';}
        $browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
        $os = oSVersion($_SERVER['HTTP_USER_AGENT']);

        // If query fails, show the reason 
        if(!$query || !mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_prepare($stmt_log, $sql_log)){
           die("SQL query failed: " . mysqli_error($conn));
        }

        if(!empty($email_signin) && !empty($password_signin)){
            // Check if email exist
            if($rowCount <= 0) {
                $status = "Error";
                $error = "Wrong email";
                $us_id = 0;
                mysqli_stmt_bind_param($stmt_log, "sissssssssssss", $user_email, $us_id, $user_info['query'], $device, $browser, 
                $os, $user_info['country'], $user_info['countryCode'], $user_info['regionName'], $user_info['city'], $user_info['lat'], $user_info['lon'], $status, $error);
                mysqli_stmt_execute($stmt_log);
                $_SESSION['ERRORS']['nouser'] = 'There is no account associated with this email!';
                unset($_SESSION['ERRORS']['wrongpassword']);
                unset($_SESSION['STATUS']['loginstatus']);
                header("Location: ../../../index.php");
                exit();
            } else {

                $row = mysqli_fetch_assoc($query);
                $user_ID = $row['ID'];
                // Verify password
                $pwdCheck = password_verify($pswd, $row['Password']);

                if ($pwdCheck == false) {

                $status = "Error";
                $error = "Wrong password";
                mysqli_stmt_bind_param($stmt_log, "sissssssssssss", $user_email, $user_ID, $user_info['query'], $device, $browser, 
                $os, $user_info['country'], $user_info['countryCode'], $user_info['regionName'], $user_info['city'], $user_info['lat'], $user_info['lon'], $status, $error);
                mysqli_stmt_execute($stmt_log);
                    $_SESSION['ERRORS']['wrongpassword'] = 'Invalid credentials!';
                    unset($_SESSION['ERRORS']['nouser']);
                    unset($_SESSION['STATUS']['loginstatus']);
                    header("Location: ../../../index.php");
                    exit();
                } 
                else if ($pwdCheck == true) {
                
                    if($row['Role'] == 'Admin'){
                        $status = "Success";
                        $error = NULL;
                        mysqli_stmt_bind_param($stmt_log, "sissssssssssss", $user_email, $user_ID, $user_info['query'], $device, $browser, 
                        $os, $user_info['country'], $user_info['countryCode'], $user_info['regionName'], $user_info['city'], $user_info['lat'], $user_info['lon'], $status, $error);
                        mysqli_stmt_execute($stmt_log);
                        $_SESSION['id'] = $row['ID'];
                        $_SESSION['auth'] = 'loggedin';
                        $_SESSION['image'] = $row['Image'];
                        $_SESSION['role'] = $row['Role'];
                        $_SESSION['username'] = $row['Username'];
                        $_SESSION['email'] = $row['Email'];
                        $_SESSION['log_id'] = mysqli_insert_id($conn); //last log inserted
                        $sql = "UPDATE users SET LastLogin=now() WHERE ID=$user_ID;";
                        mysqli_query($conn, $sql);
                        unset($_SESSION['ERRORS']);
                        unset($_SESSION['STATUS']);
                        header("Location: ../../admin/dashboard.php"); 
                    }    
                    else if($row['Role'] == 'User'){         
                     // Allow only verified user
                   if($row['Is_Active'] == 'Yes') {
                   $status = "Success";
                   $error = NULL;
                   mysqli_stmt_bind_param($stmt_log, "sissssssssssss", $user_email, $user_ID, $user_info['query'], $device, $browser, 
                   $os, $user_info['country'], $user_info['countryCode'], $user_info['regionName'], $user_info['city'], $user_info['lat'], $user_info['lon'], $status, $error);
                   mysqli_stmt_execute($stmt_log);     
                       $_SESSION['id'] = $row['ID'];
                       $_SESSION['auth'] = 'loggedin';
                       $_SESSION['image'] = $row['Image'];
                       $_SESSION['role'] = $row['Role'];
                       $_SESSION['username'] = $row['Username'];
                       $_SESSION['email'] = $row['Email'];
                       $_SESSION['log_id'] = mysqli_insert_id($conn); //last log inserted
                       $sql = "UPDATE users SET LastLogin=now() WHERE ID=$user_ID;";
                        mysqli_query($conn, $sql);   
                        unset($_SESSION['ERRORS']);
                        unset($_SESSION['STATUS']);
                       header("Location: ../../user/home.php"); 
    
                } else {
                    $status = "Error";
                    $error = "Account disabled";
                    mysqli_stmt_bind_param($stmt_log, "sissssssssssss", $user_email, $user_ID, $user_info['query'], $device, $browser, 
                    $os, $user_info['country'], $user_info['countryCode'], $user_info['regionName'], $user_info['city'], $user_info['lat'], $user_info['lon'], $status, $error);
                    mysqli_stmt_execute($stmt_log);
                     $_SESSION['STATUS']['loginstatus']='Your account has been disabled by an admin!';
                     unset($_SESSION['ERRORS']['nouser']);
                     unset($_SESSION['ERRORS']['wrongpassword']);
                     header("Location: ../../../index.php");
                    exit();
                }
            }
              /*
                    * -------------------------------------------------------------------------------
                    *   Setting rememberme cookie
                    * -------------------------------------------------------------------------------
                    */
            if (isset($_POST['rememberme'])){

                $selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);

                $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='remember_me';";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {

                    header("Location: ../");
                    exit();
                }
                else {

                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
                    mysqli_stmt_execute($stmt);
                }

                setcookie(
                    'rememberme',
                    $selector.':'.bin2hex($token),
                    time() + (86400*30),
                    '/',
                    NULL,
                    false, // TLS-only
                    true  // http-only
                );

                $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
                        VALUES (?, 'remember_me', ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {

                    header("Location: ../");
                    exit();
                }
                else {
                    
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    $exp = date('Y-m-d\TH:i:s', time() + (86400*30));
                    mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['email'], $selector, $hashedToken, $exp);
                    mysqli_stmt_execute($stmt);
                }
            }

            }
            }
        }
    
            else {
            if(empty($email_signin)){
                $_SESSION['ERRORS']['nouser'] = 'Email cannot be empty!';
                unset($_SESSION['ERRORS']['wrongpassword']);
                unset($_SESSION['STATUS']['loginstatus']);
                header("Location: ../../../index.php");
                exit();
            }
            
            if(empty($password_signin)){
                $_SESSION['ERRORS']['wrongpassword'] = 'Password cannot be empty!';
                unset($_SESSION['ERRORS']['nouser']);
                unset($_SESSION['STATUS']['loginstatus']);
                header("Location: ../../../index.php");
                exit();
            }            
            }
     }
    
    else {
        header("Location: ../../../index.php");
        exit();
    }

    mysqli_close($conn);
?>