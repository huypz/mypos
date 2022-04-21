<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();
    require('../mysqli_connect.php');
    if (isset($_SESSION['cart_id'])) {
        $cid = $_SESSION['cart_id'];
        /*
        $q = "UPDATE items, products SET items.quantity=products.stock
            WHERE items.quantity>products.stock AND products.id=items.product_id";
        $r = @mysqli_query($dbc, $q);
        */
        $q = "DELETE items FROM items INNER JOIN products ON items.product_id=products.id WHERE products.stock=0 AND cart_id=$cid";
        $r = @mysqli_query($dbc, $q);
        $q = "SELECT SUM(quantity) FROM items WHERE cart_id=$cid";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_row($r);
        echo $row[0];
    }
    mysqli_close($dbc);    
    exit(); 
}
?>