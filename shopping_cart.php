<?php
session_start();
include('includes/header.html');
require('../mysqli_connect.php');


if(isset($_SESSION['username']))
{
    echo '<div class="page-header"><h2>Current Shopping Cart for user: ' . $_SESSION['username'] . '</h2></div>';
    $id = $_SESSION['user_id'];
    $q = "SELECT product_name, subtotal FROM shopping_carts WHERE user_id = $id";

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
    echo '<table width="60%">
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">Total</th> 
        </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $total += $row['subtotal'];
        echo '<tr>
            <td align="left">' . $row['product_name'] . '</td>
            <td align="left">' . $row['subtotal'] . '</td>
            </tr>';
    }
    echo '</tbody></table>';
    echo '<p class="total">Your current total is '. $total . ' </p>';
    echo "<div class='Check-Out'>
            <form action='' method = 'get' style='align-self: center;'>
                <input type = 'submit' name = 'check out' class = 'button' value = 'check out'/>
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