<style>
body {
    overflow: hidden !important;
}

.body {
    overflow: scroll !important;
}

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
$page_title = "Sales";
include('includes/header.html');
require('../mysqli_connect.php');

echo '<div class="page-header"><h1>Notable Statistics</h1></div>';

$query = "SELECT p.name, p.price, p.description, s.num_sales 
         FROM products AS p, sales AS s 
         WHERE s.product_id = p.id ORDER BY s.num_sales DESC
         LIMIT 10";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are no notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><strong>Displaying the 10 best selling products</strong>.</p><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">description</th>
        <th align="left">Price</th> 
        <th align="left">Number of Sales</th> 
    </tr>
    </thead>
    <tbody>';
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['description'] . '</td>
            <td align="left">$' . number_format($row['price'], 2) . '</td>
            <td align="left">' . $row['num_sales'] . '</td>
            </td>
            </tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($res);
}

$query = "SELECT p.name, p.price, p.description, s.num_sales 
         FROM products AS p, sales AS s 
         WHERE s.product_id = p.id ORDER BY s.num_sales ASC
         LIMIT 10";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are no notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><br><br><strong>Displaying the 10 worst selling products</strong>.</p><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">description</th>
        <th align="left">Price</th> 
        <th align="left">Number of Sales</th> 
    </tr>
    </thead>
    <tbody>';
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['description'] . '</td>
            <td align="left">$' . number_format($row['price'], 2) . '</td>
            <td align="left">' . $row['num_sales'] . '</td>
            </td>
            </tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($res);
}

$query = "SELECT p.name, p.price, p.description, s.num_sales 
         FROM products AS p, sales AS s 
         WHERE s.product_id = p.id ORDER BY p.price ASC
         LIMIT 10";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are no notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><br><br><strong>Displaying the 10 least expensive products</strong>.</p><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">description</th>
        <th align="left">Price</th> 
        <th align="left">Number of Sales</th> 
    </tr>
    </thead>
    <tbody>';
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['description'] . '</td>
            <td align="left">$' . number_format($row['price'], 2) . '</td>
            <td align="left">' . $row['num_sales'] . '</td>
            </td>
            </tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($res);
}

$query = "SELECT p.name, p.price, p.description, s.num_sales 
         FROM products AS p, sales AS s 
         WHERE s.product_id = p.id ORDER BY p.price DESC
         LIMIT 10";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are no notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><br><br><strong>Displaying the 10 most expensive products</strong>.</p><br>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">description</th>
        <th align="left">Price</th> 
        <th align="left">Number of Sales</th> 
    </tr>
    </thead>
    <tbody>';
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['description'] . '</td>
            <td align="left">$' . number_format($row['price'], 2) . '</td>
            <td align="left">' . $row['num_sales'] . '</td>
            </td>
            </tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($res);
}

include('includes/footer.html');
?>