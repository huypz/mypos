<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['email'];
}
else {
    echo 'NOT FOUND';
}
?>