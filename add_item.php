<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['item_id'], $_POST['quantity'])) {
        require('../mysqli_connect.php');
        session_start();
        if (isset($_SESSION['user_id'])) {
            $q = "SELECT cart_id FROM shopping_carts WHERE user_id={$_SESSION['user_id']}";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $cart_id = $row['cart_id'];
            $q = "INSERT INTO items (cart_id, product_id, quantity) 
                VALUES ($cart_id, {$_POST['item_id']}, {$_POST['quantity']})";
            $r = @mysqli_query($dbc, $q);
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
}
?>