<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['item_id'], $_POST['quantity'])) {
        require('../mysqli_connect.php');

        $q = "SELECT stock FROM products WHERE id={$_POST['item_id']}";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        if ($row['stock'] == 0) {
            echo 'OUT OF STOCK';
            mysqli_close($dbc);    
            exit(); 
        }
        session_start();
        if (isset($_SESSION['user_id'])) {
            $q = "SELECT cart_id FROM shopping_carts WHERE user_id={$_SESSION['user_id']}";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $cart_id = $row['cart_id'];   
            if ($_POST['quantity'] == 1) {
                $q = "INSERT INTO items (cart_id, product_id, quantity) 
                VALUES ($cart_id, {$_POST['item_id']}, {$_POST['quantity']})
                ON DUPLICATE KEY UPDATE quantity=(quantity+1)";
                $r = @mysqli_query($dbc, $q);
            }
            else if ($_POST['quantity'] == -1) {
                $q = "UPDATE items SET quantity = (quantity-1) 
                    WHERE cart_id=$cart_id AND product_id={$_POST['item_id']}";
                $r = @mysqli_query($dbc, $q);
                $q = "DELETE FROM items WHERE quantity=0 AND cart_id=$cart_id";
                $r = @mysqli_query($dbc, $q);
            }
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