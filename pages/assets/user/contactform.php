<?php

session_start();
require '../connection.php';

    date_default_timezone_set('Europe/Bucharest');
    $start = date('Y-m-d H:i:s', $_POST["start_time"]/1000);  
    $end = date('Y-m-d H:i:s', $_POST["time_spent"]/1000);
    $interaction = date('Y-m-d H:i:s', $_POST["f_interact"]/1000);
    $uid = $_SESSION['id'];
    $lid = $_SESSION['log_id'];
    $sub = $_POST['sub'];

    if($_POST["f_interact"] != 0) 
    $sql = "INSERT INTO forms(UserID, Log_ID, Form_name, Start_Time, First_interact, End_Time, Submited) values($uid, $lid, 'Contact us', '$start', '$interaction', '$end', '$sub');";
    else $sql = "INSERT INTO forms(UserID, Log_ID, Form_name, Start_Time, End_Time, Submited) values($uid, $lid, 'Contact us', '$start', '$end', '$sub');";
    $sqlQuery = mysqli_query($conn, $sql);
    if ($sqlQuery) {
        echo "Record inserted successfully";
        unset($_SESSION["STATUS"]["contactform"]);
        if($sub == 'Yes') $_SESSION["STATUS"]["contact"] = 1;
      } else {
        echo $_SESSION["STATUS"]["contactform"] = "Error while submiting the form!";
      }


mysqli_close($conn);
?>
