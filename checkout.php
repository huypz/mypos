<?php
session_start();
$page_title = "Checkout";
include('includes/header.html');
require('../mysqli_connect.php');

$id = $_SESSION['user_id'];

$q = "SELECT p.name, p.price, i.quantity
        FROM shopping_carts AS s, items AS i, products AS p
        WHERE s.user_id=$id AND i.cart_id=s.cart_id AND p.id=i.product_id;";

$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
$total = 0;
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $total += $row['price'];
}

echo '<div class="page-header"><h2>Please Enter Payment Information</h2></div>';

echo '<form name = "form" method="post">
            <div class="Card-Number">
                <div class="input-container">
                    <input id="Card_Number" type="text" name="Card_Number" placeholder="Card Number" maxlength="64">
                    <input id="CSV_Number" type="text" name="CSV_Number" placeholder="CSV_Number" maxlength="64">
                    <input id="Address" type="text" name="Address" placeholder="Address" maxlength="64">
                    <input id="Zip_Code" type="text" name="Zip_Code" placeholder="Zip Code" maxlength="64">
                    <input id="City" type="text" name="City" placeholder="City" maxlength="64">
                    <input id="State" type="text" name="State" placeholder="State" maxlength="64">
                    <input type = "Submit" value = "Finish Check Out!">
                </div>
            </div>
        </form>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    if (empty($_POST['Card_Number'])) {
        $errors[] = 'Please Enter a Card Number!';
    }
    else
    {
        $Card_Number = mysqli_real_escape_string($dbc, trim($_POST['Card_Number']));
    }

    if (empty($_POST['CSV_Number'])) {
        $errors[] = 'Please Enter a CSV Number!';
    }
    else
    {
        $CSV_Number = mysqli_real_escape_string($dbc, trim($_POST['CSV_Number']));
    }
    if (empty($_POST['Address'])) {
        $errors[] = 'Please Enter a Address!';
    }
    else
    {
        $Address = mysqli_real_escape_string($dbc, trim($_POST['Address']));
    }
    if (empty($_POST['Zip_Code'])) {
        $errors[] = 'Please Enter a Zip_Code!';
    }
    else
    {
        $Zip_Code = mysqli_real_escape_string($dbc, trim($_POST['Zip_Code']));
    }
    if (empty($_POST['City'])) {
        $errors[] = 'Please Enter a City!';
    }
    else
    {
        $City = mysqli_real_escape_string($dbc, trim($_POST['City']));
    }
    if (empty($_POST['State'])) {
        $errors[] = 'Please Enter a State!';
    }
    else
    {
        $City_State = mysqli_real_escape_string($dbc, trim($_POST['State']));
    }

    if (empty($errors)) {
        $q = "SELECT p.id, p.stock, i.quantity
        FROM shopping_carts AS s, items AS i, products AS p
        WHERE s.user_id=$id AND i.cart_id=s.cart_id AND p.id=i.product_id";

        $res = @mysqli_query($dbc, $q);

        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
        {
            $CurrentStock = $row['stock'];
            $CurrentStock -= $row['quantity'];
            $pId = $row['id'];
            $q = "UPDATE products " . "SET stock = '$CurrentStock' " . "WHERE id = '$pId'";
            $r = @mysqli_query($dbc, $q);
        }   
        
        $query = "SELECT cart_id FROM shopping_carts WHERE user_id = $id";
        $r = @mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $cart_id = $row['cart_id'];

        $query = "INSERT INTO user_payment (card_number, description, payment_type, user_id) values ($Card_Number, 'TEST', 'Credit', $id)";
        $r = @mysqli_query($dbc, $query);

        $query = "INSERT INTO transactions (date, payment_amount, user_id) values (CURRENT_DATE(), $total, $id)";
        $r = @mysqli_query($dbc, $query);

        $query = "DELETE FROM items WHERE cart_id = $cart_id";
        $r = @mysqli_query($dbc, $query);
        $total = 0;
        echo '<script language="javascript">';
        echo 'alert("Purchase successful")';
        echo '</script>';
    }
    else {
        echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>\n";
        }
        echo '</p><p>Please try again.</p><p><br></p>';
    }
}

include('includes/footer.html');
?>