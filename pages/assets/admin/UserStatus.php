<?php
session_start();
require_once '../connection.php';

if (isset($_POST["status"])) {
    $status = $_POST["status"];
    if ($status == 'Yes')
    $new_status = 'No';
    else $new_status = 'Yes';
    $id = $_POST["id"];
    $sql = "UPDATE users SET Is_Active='$new_status' WHERE ID='$id'";

    if (mysqli_query($conn, $sql)) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
}
mysqli_close($conn);

?>