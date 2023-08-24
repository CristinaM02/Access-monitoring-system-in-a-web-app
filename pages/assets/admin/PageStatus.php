<?php
session_start();
require_once '../connection.php';

if (isset($_POST["pg_status"])) {
    $status = $_POST["pg_status"];
    if ($status == 'Active')
    $new_status = 'Inactive';
    else $new_status = 'Active';
    $id = $_POST["id"];
    $sql = "UPDATE pages SET Status='$new_status' WHERE ID='$id'";

    if (mysqli_query($conn, $sql)) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
}
mysqli_close($conn);

?>