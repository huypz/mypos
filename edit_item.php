<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['item_id'])) {
        require('../mysqli_connect.php');

        $q = "SELECT p.name, p.category, p.description, p.stock, p.price FROM products AS p WHERE id={$_POST['item_id']}";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        /*if ($row['stock'] == 0) {
            echo 'OUT OF STOCK';
            mysqli_close($dbc);    
            exit(); 
        }*/
        session_start();
        if (isset($_SESSION['user_id'])) {
            $q = "SELECT a.admin_id, a.user_id, s.supplier_id, s.user_id, u.user_id
                FROM admins AS a, suppliers AS s, users AS u
                WHERE a.user_id={$_SESSION['user_id']} OR s.user_id={$_SESSION['user_id']}";

            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            $q = "UPDATE
                    products
                SET 
                    name = '{$_POST['name']}',
                    category = '{$_POST['category']}',
                    description = '{$_POST['description']}',
                    stock = {$_POST['stock']},
                    price = {$_POST['price']}                    
                WHERE
                    id = {$_POST['item_id']}
                    ";
            $r = @mysqli_query($dbc, $q);

            echo 'Product data successfully modified';
            mysqli_close($dbc);
            exit();
        } 
        else {
            echo 'Invalid user id';
        }
    } 
    else {
        echo 'Invalid item id';
    }
}
