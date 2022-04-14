<?php
require('../mysqli_connect.php');

if(isset($_GET['id']))
{
    $id = $_GET['id'];
}

$q = "SELECT p.id, p.name, p.category, p.stock, p.description, s.supplier_id, u.username
      FROM products AS p, suppliers AS s, users AS u
      WHERE p.supplier_id=s.supplier_id AND s.user_id = u.user_id AND p.id=$id;";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

$prodInfo = [
    "name" => $row['name'],
    "category" => $row['category'],
    "description" => $row['description'],
    "stock" => $row['stock'],
    "username" => $row['username'],
    "supplier_id" => $row['supplier_id'],
];

$page_title = ucwords($prodInfo['name']);
include('includes/header.html');

echo '<div class="page-header"><h1>' . ucwords($prodInfo['name']) . '</h1></div>';
if ($num > 0) {
    echo '<table width="60%">
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">Category</th>
            <th align="left">Description</th>
            <th align="left">Stock</th>
            <th align="left">Supplier</th>
            <th align="left">Supplier ID</th>
        </tr>
        </thead>
        <tbody>';
    echo '<tr>
        <td align="left">' . $row['name'] . '</td>
        <td align="left">' . $row['category'] . '</td>
        <td align="left">' . $row['description'] . '</td>
        <td align="left">' . $row['stock'] . '</td>
        <td align="left">' . $row['username'] . '</td>
        <td align="left">' . $row['supplier_id'] . '</td>
        </tr>';

    echo '</tbody></table>';
    mysqli_free_result($r);
} else {
    echo '<p class="error">This product does not exist.</p>';
}

mysqli_close($dbc);
include('includes/footer.html');
