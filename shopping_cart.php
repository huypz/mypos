<link rel="stylesheet" type="text/css" href="/css/table.css">
<?php
$page_title = 'Shopping Cart';
session_start();
include('includes/header.html');
require('../mysqli_connect.php');


if(isset($_SESSION['username']))
{
    echo '<div class="page-header"><h2>Current Shopping Cart for user: ' . $_SESSION['username'] . '</h2></div>';
    $id = $_SESSION['user_id'];
    $q = "SELECT p.name, p.price, i.quantity
        FROM shopping_carts AS s, items AS i, products AS p
        WHERE s.user_id=$id AND i.cart_id=s.cart_id AND p.id=i.product_id;";

    $r = @mysqli_query($dbc, $q);
    $num = mysqli_num_rows($r);

    if($num == 0)
    {
        echo '<div class="Cart-Empty"><p2>Your Shopping Cart Is Empty!</p2></div>';
    }
    else
    {
        $total = 0;
        echo '<p>Displaying ' . $num . ' items.</p><br>';
    echo '<table>
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">Quantity</th>
            <th align="left">Price</th> 
        </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $total += $row['price'];
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['quantity'] . '</td>
            <td align="left">$' . number_format($row['price'], 2) . '</td>
            </tr>';
    }
    echo '</tbody></table>';
    echo '<p class="total">Your current total is $'. number_format($total, 2) . ' </p>';
    echo "<br><div class='Check-Out'>
            <form action='' method = 'get' style='align-self: center;'>
                <input type = 'submit' name = 'check out' class = 'button' value = 'Check Out'/>
            </form>
        </div>";
    mysqli_free_result($r);
    }
}
else
{
    echo '<div class="page-header"><h2>Please log in to view your shopping cart!</h2></div>';
}

include('includes/footer.html');
?>