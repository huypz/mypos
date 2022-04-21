<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();
    require('../mysqli_connect.php');
    if (isset($_SESSION['cart_id'])) {
        $q = "SELECT SUM(quantity) FROM items WHERE cart_id={$_SESSION['cart_id']}";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_row($r);
        echo $row[0];
    }
    mysqli_close($dbc);    
    exit(); 
}
?>