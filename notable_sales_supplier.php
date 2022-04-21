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
$page_title = "Sales";
session_start();
include('includes/header.html');
require('../mysqli_connect.php');

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $query = "SELECT s.supplier_id FROM suppliers AS s WHERE s.user_id = '$id'";
    $res = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($res);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    if($num <= 0)
    {
        echo '<div class="Not A supplier"><h2>You are not a supplier!</h2></div>';
    }
    else if($num >= 0)
    {
        echo '<div class="notifications page-header"><h2>These are your sales!</h2></div>';
        $suppId = $row['supplier_id'];
        echo '<div class="Supplier"><p>Your current item info are listed below.</p></div><br>';
        echo '<div class="table-container">';
        echo '<table>
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">ID</th> 
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
                <td align="left">' . $row['name'] . '</td>
                <td align="left">' . $row['id'] . '</td>
                <td align="left">' . $row['stock'] . '</td>
                <td align="left">' . $row2['num_sales'] . '</td>
                </td>
                </tr>';
        }
        echo '</tbody></table></div>';
    }
}
else {
    echo '<div class="notifications page-header"><h2>Only available to suppliers!</h2></div>';
}

include('includes/footer.html');
?>