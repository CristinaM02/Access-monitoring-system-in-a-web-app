<?php
session_start();
require_once '../connection.php';

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "DELETE FROM users WHERE ID='$id'";

    if (mysqli_query($conn, $sql)) {
      echo "Record deleted successfully";
    } else {
      echo "Error deleting record: " . mysqli_error($conn);
    }
}
mysqli_close($conn);

?>