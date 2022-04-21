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
<?php
session_start();
include('includes/header.html');
require('../mysqli_connect.php');

echo '<div class="notifications"><h2>These are your notifications!</h2></div>';

$id = $_SESSION['user_id'];
$query = "SELECT s.supplier_id FROM suppliers AS s WHERE s.user_id = '$id'";
$res1 = @mysqli_query($dbc, $query);
$num1 = mysqli_num_rows($res1);
$row1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
$suppId = $row1['supplier_id'];

$query1 = "SELECT name, product_id FROM ibt_email_queue WHERE supplier_id = '$suppId'";
$res2 = @mysqli_query($dbc, $query1);
$num1 = mysqli_num_rows($res2);

if($num1 >= 1)
{
    echo '<div class="Supplier"><p>You have items that are under stocked!! Please deliver these items as soon as possible!</p></div><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">ID</th> 
        <th align="left">Stock</th> 
    </tr>
    </thead>
    <tbody>';

    $query = "SELECT p.name, p.id, p.stock, p.supplier_id, i.supplier_id, i.product_id
              FROM products AS p, ibt_email_queue As i
              WHERE p.supplier_id = '$suppId' AND p.supplier_id = i.supplier_id AND p.id = i.product_id ORDER BY p.id DESC";
    $res = @mysqli_query($dbc, $query);
    $prevId = 0;
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        if($row['id'] != $prevId)
        {
            echo '<tr>
                <td align="left">' . $row['name'] . '</td>
                <td align="left">' . $row['id'] . '</td>
                <td align="left">' . $row['stock'] . '</td>
                </td>
                </tr>';
            $prevId = $row['id'];
        }
    }
    echo '</tbody></table></div>';
}

$query1 = "SELECT name, product_id FROM iat_email_queue WHERE supplier_id = '$suppId'";
$res = @mysqli_query($dbc, $query1);
$num2 = mysqli_num_rows($res);


if($num2 > 0)
{
    echo '<div class="Supplier"><p>You have items that are over stocked! Please deliver less of these items next time!</p></div><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">ID</th> 
        <th align="left">Stock</th> 
    </tr>
    </thead>
    <tbody>';

    $query = "SELECT p.name, p.id, p.stock, p.supplier_id, i.supplier_id, i.product_id
              FROM products AS p, iat_email_queue As i
              WHERE p.supplier_id = '$suppId' AND p.supplier_id = i.supplier_id AND p.id = i.product_id ORDER BY p.id DESC";
    $res = @mysqli_query($dbc, $query);
    $prevId = 0;
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        if($row['id'] != $prevId)
        {
            echo '<tr>
                <td align="left">' . $row['name'] . '</td>
                <td align="left">' . $row['id'] . '</td>
                <td align="left">' . $row['stock'] . '</td>
                </td>
                </tr>';
            $prevId = $row['id'];
        }
            
    }
    echo '</tbody></table></div>';
}

$query1 = "SELECT payment_amount, transaction_date FROM transaction_email WHERE user_id = '$id'";
$res = @mysqli_query($dbc, $query1);
$num1 = mysqli_num_rows($res);
if($num2 > 0)
{
    echo '<div class="Supplier"><p>Here are your recent transactions!</p></div><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Date</th>
        <th align="left">payment_amount</th> 
    </tr>
    </thead>
    <tbody>';
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        echo '<tr>
            <td align="left">' . $row['transaction_date'] . '</td>
            <td align="left">' . $row['payment_amount'] . '</td>
            </td>
            </tr>';
    }
    echo '</tbody></table></div>';
}


echo '<p><a href="/delete_notifications.php"><button>Delete Notifications</button></a></p>';




include('includes/footer.html');
?>