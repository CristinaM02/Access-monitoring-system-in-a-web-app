<?php
session_start();
require '../auth/auth_functions.php';
require '../auth/security_functions.php';
require '../auth/datacheck.php';
require '../connection.php';


if(isset($_POST['update'])){
    
     $post_arr = array($_POST['title'], $_POST['description']);
     foreach ($post_arr as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
     }

     if (!verify_csrf_token()) {
        $_SESSION["STATUS"]["pagestatus"] = "Request could not be validated!";  
        unset($_SESSION['ERRORS']['pgimageerror']);
        unset($_SESSION['ERRORS']['pgtitleerror']);
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
     }

         $user_id = $_SESSION['id'];
         $title = $_POST['title'];
         $description = $_POST['description'];
         $pgid = $_POST['pgid'];
        
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
                            $_SESSION["ERRORS"]["pgimageerror"] = "The image size should be less than 10MB!";
                            unset($_SESSION["STATUS"]["pagestatus"]);
                            unset($_SESSION['ERRORS']['pgtitleerror']);
                            header("location:".$_SERVER['HTTP_REFERER']);
                            exit();
                        }
                    } else {
                        $_SESSION["ERRORS"]["pgimageerror"] = "Upload failed, please retry!";
                        unset($_SESSION["STATUS"]["pagestatus"]);
                        unset($_SESSION['ERRORS']['pgtitleerror']);
                        header("location:".$_SERVER['HTTP_REFERER']);
                        exit();
                    }
                } else {
                    $_SESSION["ERRORS"]["pgimageerror"] = "Invalid format; only .jpg, .jpeg, .png and .gif are allowed!";
                    unset($_SESSION["STATUS"]["pagestatus"]);
                    unset($_SESSION['ERRORS']['pgtitleerror']);
                    header("location:".$_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
          
         
         $sql_pg = "UPDATE pages SET Title = ?, Description = ?, LastModification = now(), ModifiedBy ='$user_id', CoverImage = ? WHERE ID = $pgid;";
         $stmt_pg = mysqli_stmt_init($conn);
         mysqli_stmt_prepare($stmt_pg, $sql_pg);
         mysqli_stmt_bind_param($stmt_pg, "sss", $title, $description, $FileNameNew);       
         mysqli_stmt_execute($stmt_pg);

         $sql = "INSERT INTO admin_session_logs (UserID, PageID, Log_ID, URI, Event_Description, Date) VALUES (?, ?, ?, ?, 'Page update', now());";
            $logid = $_SESSION['log_id'];
            $URI = 'http://localhost:8080/disertation-app/pages/user/page.php?id='.$pgid;
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iiis", $user_id, $pgid, $logid, $URI);       
            mysqli_stmt_execute($stmt);
         
            mysqli_close($conn);

            unset($_SESSION['STATUS']['pagestatus']);
            unset($_SESSION['ERRORS']['pgimageerror']);
            unset($_SESSION['ERRORS']['pgtitleerror']);
            header("location: ../../admin/managepage.php?id=".$pgid."&tabid=details");
            exit();

} else {
    if(empty($title)){
        $_SESSION['ERRORS']['pgtitleerror'] = 'Title cannot be empty!';
        unset($_SESSION['STATUS']['pagestatus']);
        unset($_SESSION['ERRORS']['pgimageerror']);
        header("Location: ../../../index.php");
        exit();
    }
}
}

else if(isset($_POST['update_content'])){
    $post_arr = array($_POST['contenttitle']);
    foreach ($post_arr as $key => $value) {
       $_POST[$key] = _cleaninjections(trim($value));
    }

    if (!verify_csrf_token()) {
       $_SESSION["STATUS"]["contentstatus"] = "Request could not be validated!";  
       unset($_SESSION['ERRORS']['contenttitle']);
       header("location:".$_SERVER['HTTP_REFERER']);
       exit();
    }
        $user_id = $_SESSION['id'];
        $pgid = $_POST['pgid'];
        $txt_title = $_POST['contenttitle'];

        if (!empty($txt_title)) {
            $txt_title = mysqli_real_escape_string($conn, $txt_title);

            if(isset($_POST['editor1'])){
                $txt_content = htmlentities(str_replace('<a','<a onclick="userpg_outlink(this.href)"',$_POST['editor1']));
                $sql = "UPDATE page_text SET LastModification = now(), ModifiedBy = ?, Text = ?, Title = ? WHERE PageID = $pgid;";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "iss", $user_id, $txt_content, $txt_title);     
                mysqli_stmt_execute($stmt);

            $sql = "INSERT INTO admin_session_logs (UserID, PageID, Log_ID, URI, Event_Description, Date) VALUES (?, ?, ?, ?, 'Content update', now());";
            $logid = $_SESSION['log_id'];
            $URI = 'http://localhost:8080/disertation-app/pages/user/page.php?id='.$pgid;
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iiis", $user_id, $pgid, $logid, $URI);       
            mysqli_stmt_execute($stmt);

            $sql_pg = "UPDATE pages SET LastModification = now(), ModifiedBy ='$user_id' WHERE ID = $pgid;";
            mysqli_query($conn, $sql_pg);

            mysqli_close($conn);

            unset($_SESSION["STATUS"]["contentstatus"]);
            unset($_SESSION['ERRORS']['contenttitle']);
            header("location: ../../admin/managepage.php?id=".$pgid."&tabid=content");
            exit();
             }
        }
        else {
            if(empty($txt_title)){
                $_SESSION['ERRORS']['contenttitle'] = 'Title cannot be empty!';
                unset($_SESSION["STATUS"]["contentstatus"]);
                header("Location: ../../../index.php");
                exit();
            }
        }

} else if(isset($_POST['addaccess']) && isset($_POST["addto"])){
         $pgid = $_POST['pgid'];
        $sql = "INSERT INTO accessrights (PageID, UserID) VALUES (?, ?)";
         $stmt = mysqli_stmt_init($conn);
         mysqli_stmt_prepare($stmt, $sql);     
        $to = $_POST["addto"];
        foreach ($to as $value) {
             mysqli_stmt_bind_param($stmt, "ii",  $pgid, $value);       
             mysqli_stmt_execute($stmt);
        }

        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
}  
else if(isset($_POST['removeaccess']) && isset($_POST["removeto"])){
    $pgid = $_POST['pgid'];
   $sql = "DELETE FROM accessrights WHERE PageID = ? AND UserID = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);     
   $to = $_POST["removeto"];
   foreach ($to as $value) {
        mysqli_stmt_bind_param($stmt, "ii",  $pgid, $value);       
        mysqli_stmt_execute($stmt);
   }

   header("location:".$_SERVER['HTTP_REFERER']);
   exit();
}


else {
    
    header("location:".$_SERVER['HTTP_REFERER']);
    exit();
}
?>