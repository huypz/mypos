<?php
include('includes/login_functions.inc.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    $url = BASE_URL . 'index.php';
    ob_end_clean();
    header("Location: $url");
    exit();
}
else {
    $_SESSION = [];
    session_destroy();
    setcookie(session_name(), '', time()-3600);
}
?>