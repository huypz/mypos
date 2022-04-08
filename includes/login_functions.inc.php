<?php
function redirect_user($page = 'index.php') {
    $hostname = 'localhost';
    $url = 'http://' . $hostname . dirname ($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}

function check_login($dbc, $user='', $pass='') {
    $errors = [];
    if (empty($user)) {
        $errors[] = 'Please enter a username/email.';
    }
    else {
        $u = mysqli_real_escape_string($dbc, trim($user));
    }
    if (empty($pass)) {
        $errors[] = 'Please enter a password.';
    }
    else {
        $p = mysqli_real_escape_string($dbc, trim($pass));
    }

    if (empty($errors)) {
        if (filter_var($u, FILTER_VALIDATE_EMAIL)) {
            $q = "SELECT user_id, username, email
                FROM users
                WHERE email='$u' AND pass=SHA2('$p', 512)";
        }
        else {
            $q = "SELECT user_id, username, email
                FROM users
                WHERE username='$u' AND pass=SHA2('$p', 512)";
        }
        $r = @mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return [true, $row];
        }
        else {
            $errors[] = 'The username/email and password combination is incorrect.';
        }
    }
    return [false, $errors];
}
