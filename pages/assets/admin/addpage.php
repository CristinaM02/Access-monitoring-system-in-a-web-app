<?php
session_start();
require '../auth/auth_functions.php';
require '../auth/security_functions.php';
require '../auth/datacheck.php';
require '../connection.php';

if(isset($_POST['submit'])){
    

     $post_arr = array($_POST['title'], $_POST['description']);
     foreach ($post_arr as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
     }

     if (!verify_csrf_token()) {
        $_SESSION["STATUS"]["signupstatus"] = "Request could not be validated!";
        unset($_SESSION['ERRORS']['pagecover']);
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
     }

         $creator = $_SESSION['id'];
         $title = $_POST['title'];
         $description = $_POST['description'];
        
        if (!empty($title)) {
            // clean the form data before sending to database
            $title = mysqli_real_escape_string($conn, $title);

            $FileNameNew = "defaultPage.png";
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
                                "../../../images/pages/" . $FileNameNew;
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
          
         
         $sql_pg = "INSERT INTO pages (Title, Description, CreatedBy, LastModification, ModifiedBy, CoverImage) VALUES (?, ?, '$creator', now(), '$creator', ?);";
         $stmt_pg = mysqli_stmt_init($conn);
         mysqli_stmt_prepare($stmt_pg, $sql_pg);
         mysqli_stmt_bind_param($stmt_pg, "sss", $title, $description, $FileNameNew);       
         mysqli_stmt_execute($stmt_pg);

         $last_pg = mysqli_insert_id($conn);
         if(isset($_POST['editor1'])){
            $txt_content = htmlentities(str_replace('<a','<a onclick="userpg_outlink(this.href)"',$_POST['editor1']));
            $txt_title = $_POST['contenttitle'];
            $sql = "INSERT INTO page_text (PageID, CreatedBy, LastModification, ModifiedBy, Text, Title) VALUES (?, ?, now(), ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iiiss", $last_pg, $creator, $creator, $txt_content, $txt_title);       
            mysqli_stmt_execute($stmt);
         }

         $sql = "INSERT INTO admin_session_logs (UserID, PageID, Log_ID, URI, Event_Description, Date) VALUES (?, ?, ?, ?, 'Page creation', now());";
            $logid = $_SESSION['log_id'];
            $URI = 'http://localhost:8080/disertation-app/pages/user/page.php?id='.$last_pg;
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iiis", $creator, $last_pg, $logid, $URI);       
            mysqli_stmt_execute($stmt);
         
            if(isset($_POST["to"])){
                $sql = "INSERT INTO accessrights (PageID, UserID) VALUES (?, ?)";
                 $stmt = mysqli_stmt_init($conn);
                 mysqli_stmt_prepare($stmt, $sql);     
                $to = $_POST["to"];
                foreach ($to as $value) {
                     mysqli_stmt_bind_param($stmt, "ii", $last_pg, $value);       
                     mysqli_stmt_execute($stmt);
                 } 
                
    mysqli_close($conn);

            $_SESSION["STATUS"]["loginstatus"] = "Page created";
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
}
}
}
else {
    
    header("location:".$_SERVER['HTTP_REFERER']);
    exit();
}
?>