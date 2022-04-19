<?php
include('includes/header.html');
require('../mysqli_connect.php');

echo '<div class="page-header"><h1>Notable Statistics</h1></div>';

$query = "SELECT p.name, p.price, p.description, s.num_sales 
         FROM products AS p, sales AS s 
         WHERE s.product_id = p.id ORDER BY s.num_sales DESC";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are not notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p>Displaying the best selling products.</p><br>';
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
         WHERE s.product_id = p.id ORDER BY s.num_sales ASC";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are not notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><br><br>Displaying the worst selling products.</p><br>';
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
         WHERE s.product_id = p.id ORDER BY p.price ASC";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are not notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><br><br>Displaying the least expensive products.</p><br>';
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
         WHERE s.product_id = p.id ORDER BY p.price DESC";

$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
if($num <= 0)
{
    echo "There are not notable sales!";
}
else if($num > 0)
{
    $counter = 5;
    echo '<p><br><br>Displaying the most expensive products.</p><br>';
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