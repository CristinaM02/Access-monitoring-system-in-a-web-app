<?php
session_start();
require '../connection.php';

if (isset($_POST["navigation"])) {
  $user_id = $_SESSION['id'];
  $page_id = $_POST["page_id"];
  $log_id = $_SESSION['log_id'];
  $total = $_POST["time_spent"];
    if($_POST["navigation"] == "navigate"){
    date_default_timezone_set('Europe/Bucharest');
    $start = $_POST["start_time"]/1000;
    $date = date('Y-m-d H:i:s',$start);
    $uri = $_POST["uri"];
    $sql = "INSERT INTO session_logs (UserID, PageID, Log_ID, URI, Event_Description, Start_Time, Time_spent) VALUES ($user_id, $page_id, $log_id, '$uri', 'Page visit', '$date', $total);";
    
    if (mysqli_query($conn, $sql)) {
      echo "Record inserted successfully";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }
  else if($_POST["navigation"] == "reload" || $_POST["navigation"] == "back_forward"){
    $sql = "SELECT ID, Time_spent from session_logs where UserID = $user_id AND PageID = $page_id AND Log_ID = $log_id order by ID desc LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $new_time = $row['Time_spent'] + $total;
    $record_id = $row['ID'];
    $sql_update = "UPDATE session_logs SET Time_spent = $new_time WHERE ID = $record_id;";

    if (mysqli_query($conn, $sql_update)) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }
 
}
mysqli_close($conn);

?>