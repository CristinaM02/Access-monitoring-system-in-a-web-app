<?php
session_start();
require_once '../connection.php';

if (isset($_POST["pgid"])) {
    $page_id = $_POST["pgid"];
    $url= filter_var($_POST['url'], FILTER_SANITIZE_URL);
    $user_id = $_SESSION["id"];
    $log = $_SESSION["log_id"];
    $sql = "INSERT INTO outlinks(PageID, Log_ID, URL, UserID) VALUES($page_id, $log, '$url', $user_id);";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      
      mysqli_close($conn);
    }
?>