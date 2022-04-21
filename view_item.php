<link rel="stylesheet" type="text/css" href="/css/table.css">
<script src="/js/products.js"></script>
<?php
session_start();
require('../mysqli_connect.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$q = "SELECT p.id, p.name, p.category, p.stock, p.price, p.description, s.supplier_id, u.username
      FROM products AS p, suppliers AS s, users AS u
      WHERE p.supplier_id=s.supplier_id AND s.user_id = u.user_id AND p.id=$id";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

$prodInfo = [
    "name" => $row['name'],
    "category" => $row['category'],
    "description" => $row['description'],
    "stock" => $row['stock'],
    "price" => $row['price'],
    "username" => $row['username'],
    "supplier_id" => $row['supplier_id'],
    "item_id" => $row['id']
];

$page_title = ucwords($prodInfo['name']);
include('includes/header.html');

echo '<div class="page-header"><h1 style="display: inline">Product ID: </h1><h1 id="prodId" style="display: inline">' . $prodInfo['item_id'] . '</h1></div>';
if ($num > 0) {
    echo '<table>
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">Category</th>
            <th align="left">Description</th>
            <th align="left">Stock</th>
            <th align="left">Price</th>
            <th align="left">Supplier</th>
            <th align="left">Supplier ID</th>
        </tr>
        </thead>
        <tbody>';
    echo '<tr>
        <td align="left" id="name">' . $row['name'] . '</td>
        <td align="left" id="category">' . $row['category'] . '</td>
        <td align="left" id="description">' . $row['description'] . '</td>
        <td align="left" id="stock">' . $row['stock'] . '</td>
        <td align="left" id="price">$' . number_format($row['price'], 2) . '</td>
        <td align="left" id="username">' . $row['username'] . '</td>
        <td align="left" id="supplier_id">' . $row['supplier_id'] . '</td>';
    if (isset($_SESSION['cart_id'])) {
        echo '<td class="add-item-td" align="left">';
        $q = "SELECT quantity FROM items WHERE cart_id={$_SESSION['cart_id']} AND product_id={$row['id']}";
        $r2 = @mysqli_query($dbc, $q);
        $num = mysqli_num_rows($r2);
        $row2 = mysqli_fetch_row($r2);
        if ($num > 0 && $row2[0] > 0) {
            echo '<div id="item-' . $row['id'] . '" class="add-item-container" 
                onClick="addItem(' . $row['id'] . ', ' . 0 . ', ' . $row2[0] . ');">
                    <span id="item-' . "{$row['id']}" . '-amt" style="width: 25px; text-align: center;">';
            echo "$row2[0]";
        } else {
            echo '
            <div id="item-' . $row['id'] . '" class="add-item-container" 
                onClick="addItem(' . $row['id'] . ');">
                <span>';
            echo 'ADD';
        }
        echo '
                    </span>
                </div>
            </td>';
    } else {
        echo '<td class="add-item-td" align="left">';
        echo '<div class="add-item-container" onClick="alert(`Please sign in to purchase items`);">
            <span>ADD</span>
            </div></td>';
    }
    echo '</tr>';

    echo '</tbody></table>';

    // create if user is admin check; below is edit button
    $cnum = 0;
    if (isset($_SESSION['user_id'])) {
        $usid = $_SESSION['user_id'];
        $query = "SELECT p.id FROM admins AS a, suppliers AS s, products AS p, users AS u WHERE s.user_id=$usid AND p.supplier_id=s.supplier_id AND p.id=$id";
        $res = @mysqli_query($dbc, $query);
        $cnum = mysqli_num_rows($res);
    }

    if ($cnum <= 0) {
        echo '<p style="float: right">Suppliers can edit their own products</p>';
    } else if ($cnum >= 0) {
        echo '<script type="text/javascript">';
        echo '
    var oItem = {
        name: document.getElementById("name").textContent,
        category: document.getElementById("category").textContent,
        description: document.getElementById("description").textContent,
        stock: document.getElementById("stock").textContent,
        price: document.getElementById("price").textContent,
        item_id: document.getElementById("prodId").textContent
    }
    ';
        echo '</script>';
        echo '<p id="editButton" style="float: right; margin: 5px 5px; cursor: pointer; color: #657ef8;" onclick="editClick(oItem)">Edit</p>';

        echo '<p id="cancelButton" style="float: right; display: none; margin: 5px 5px; cursor: pointer; color: #657ef8;" onclick="cancelClick(oItem)">Cancel</p>';
        echo '<p id="saveButton" style="float: right; display: none; margin: 5px 5px; cursor: pointer; color: #657ef8;" onclick="saveClick(oItem)">Save</p>';
    }

    mysqli_free_result($r);
} else {
    echo '<p class="error">This product does not exist.</p>';
}

mysqli_close($dbc);
include('includes/footer.html');
