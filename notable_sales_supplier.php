<style>
.table-container {
    height: auto;
    max-height: 60%;
    overflow-y: scroll
}

table {
    width: 100%;
    border-spacing: 15px 1rem; border: 1px solid #ebebeb;
}
</style>
<link rel="stylesheet" type="text/css" href="/css/table.css">
<?php
session_start();
$page_title = "Sales";
include('includes/header.html');
require('../mysqli_connect.php');

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $query = "SELECT user_id FROM admins WHERE user_id = '$id'";
    $res = @mysqli_query($dbc, $query);
    $num2 = mysqli_num_rows($res);

    $query = "SELECT s.supplier_id FROM suppliers AS s WHERE s.user_id = '$id'";
    $res = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($res);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    if($num <= 0)
    {
        echo '<div class="Not A supplier"><h2>You are not a supplier!</h2></div>';
    }
    else if($num > 0 && $num2 != 1)
    {
        echo '<div class="notifications page-header"><h2>These are your sales!</h2></div>';
        $suppId = $row['supplier_id'];
        echo '<div class="Supplier"><p>Your current item info are listed below.</p></div><br>';
        echo '<div class="table-container">';
        echo '<table>
        <thead>
        <tr>
            <th align="left">ID</th>
            <th align="left">Name</th> 
            <th align="left">Stock</th> 
            <th align="left">Number of Sales</th>
        </tr>
        </thead>
        <tbody>';
        $query = "SELECT name, id, stock FROM products WHERE supplier_id = '$suppId'";
        $res = @mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
        {
            $prodID = $row['id'];
            $q = "SELECT num_sales FROM sales WHERE product_id = '$prodID'";
            $r = @mysqli_query($dbc, $q);
            $row2 = mysqli_fetch_array($r);
            echo '<tr>
                <td align="left">' . $row['id'] . '</td>
                <td align="left">' . $row['name'] . '</td>
                <td align="left">' . $row['stock'] . '</td>
                <td align="left">' . $row2['num_sales'] . '</td>
                </td>
                </tr>';
        }
        echo '</tbody></table></div>';
    }

    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $query = "SELECT user_id FROM admins WHERE user_id = '$id'";
        $res = @mysqli_query($dbc, $query);
        $num = mysqli_num_rows($res);
    }
    else
    {
        echo '<div class="page-header"><h1>You must be an admin to view this page!</h1></div>';
    }
    if($num > 0)
    {
        echo '<div class="notifications page-header"><h2>These are all users\' sales!</h2></div>';
        $q = "SELECT t.user_id, CONCAT(last_name, ', ', first_name) AS name, COUNT(t.user_id) AS num_transactions, 
        SUM(payment_amount) AS total_payments 
        FROM transactions AS t, users AS u 
        WHERE u.user_id=t.user_id 
        GROUP BY t.user_id";
        $r = @mysqli_query($dbc, $q);
        $num = mysqli_num_rows($r);
        if ($num > 0) {
            echo '<p>Displaying ' . $num . ' registered products.</p><br>';
            echo '<div class="table-container">';
            echo '<table>
                <thead>
                <tr>
                    <th align="left">ID</th>
                    <th align="left">Name</th>
                    <th align="left">Number of Transactions</th>
                    <th align="left">Total Payment</th>
                </tr>
                </thead>
                <tbody>';
            while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) 
            {
                echo '<tr>
                    <td align="left">' . $row['user_id'] . '</td>
                    <td align="left">' . $row['name'] . '</td>
                    <td align="left">' . $row['num_transactions'] . '</td>
                    <td align="left">$' . number_format( $row['total_payments'],2) . '</td>
                    </tr>';
            }
            echo '</tbody></table></div>';
            mysqli_free_result($r);
        }
        else 
        {
            echo '<p class="error">There are currently no registered products.</p>';
        }
    }
}
    

include('includes/footer.html');
?>