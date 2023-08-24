<?php
session_start();
require_once '../connection.php';

if (isset($_GET["pg_id"])) {
    $id = $_GET["pg_id"];
    $sdate = $_GET["sd"];
    $edate = $_GET["ed"];
    $sql = "SELECT URL, count(distinct UserID) as users, count(ID) as clicks FROM outlinks WHERE PageID = $id and date(Date) between '$sdate' AND '$edate' group by URL;";
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo '<table style="margin-left: 1.8rem; width:95%" class="table table-hover table-sm"><tbody><tr><td style="width: 31.5%;"><a href="'. $row['URL'] . '">'. substr($row['URL'], strpos($row['URL'], 'www.')).'</a></td><td style="width: 44.5%">'. $row['users'] .'</td><td>'. $row['clicks'] .'</td></tr></tbody></table>';
  }
} else {
  echo "0 results";
}
}
mysqli_close($conn);

?>