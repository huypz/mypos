<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['user'], $_GET['password'])) {
        require('includes/login_functions.inc.php');
        require('../mysqli_connect.php');
        list($check, $data) = check_login($dbc, $_GET['user'], $_GET['password']);
        if ($check) {
            session_start();
            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            echo 'CORRECT';
            mysqli_close($dbc);    
            exit();
        }
        else {
            echo 'INCORRECT';
        }
    }
    else {
        echo 'INCOMPLETE';
    }
    mysqli_close($dbc);
}
?>