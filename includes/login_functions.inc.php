<?php
function redirect_user($page = 'index.php') {
    $hostname = 'www.exsale.tech';
    $url = 'https:/' . $hostname . dirname ($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location $url");
    exit();
}

function check_login($dbc, $email='', $pass='') {
    $errors = [];
    if (empty($email)) {
        $errors[] = 'Please enter an email address.';
    }
    else {
        $e = mysqli_real_escape_string($dbc, trim($email));
    }
    if (empty($pass)) {
        $errors[] = 'Please enter a password.';
    }
    else {
        $p = mysqli_real_escape_string($dbc, trim($pass));
    }

    if (empty($errors)) {
        $q = "SELECT user_id, first_name
            FROM users
            WHERE email='$e' AND pass=SHA2('$p', 512)";
        $r = @mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return [true, $row];
        }
        else {
            $errors[] = 'The user/email and password combination you entered is incorrect.';
        }
    }
    return [false, $errors];
}
