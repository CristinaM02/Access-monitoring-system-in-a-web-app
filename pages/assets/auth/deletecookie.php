<?php
if (isset($_COOKIE['rememberme'])) {
    unset($_COOKIE['rememberme']); 
    setcookie('rememberme', null, -1, '/'); 
    return true;
} else {
    return false;
}


session_start();

require '../connection.php';
require 'auth_functions.php';
check_logged_in();

$log_id = $_SESSION['log_id'];
$sql_log = "UPDATE login_logs SET Logout = now() WHERE ID = $log_id;";
$query = mysqli_query($conn, $sql_log);

if(!$query){
    die("SQL query failed: " . mysqli_error($conn));
 }

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.

header("Location: ../../../");
exit();

?>