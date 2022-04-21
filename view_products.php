<link rel="stylesheet" type="text/css" href="/css/table.css">
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/products.js"></script>
<?php
session_start();
$page_title = 'MY POS - Products';
include('includes/header.html');
echo '<div class="page-header"><h1>Registered Products</h1></div>';
require('../mysqli_connect.php');

$q = "SELECT p.id, p.name, p.category, p.stock, p.price, p.description, s.supplier_id, u.username
      FROM products AS p, suppliers AS s, users AS u
      WHERE p.supplier_id=s.supplier_id AND s.user_id = u.user_id;";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
if ($num > 0) {
    echo '<p>Displaying ' . $num . ' registered products.</p><br>';
    echo '<div class="table-container">';
    echo '<table>
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">Category</th>
            <th align="left" colspan="2">Description</th>
            <th align="left">Stock</th>
            <th align="left">Price</th>
            <th align="left">Supplier</th>
            <th align="left" colspan="3">Supplier ID</th>
        </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['category'] . '</td>
            <td align="left" colspan="2">' . $row['description'] . '</td>
            <td align="left">' . $row['stock'] . '</td>
            <td align="left">$' . number_format($row['price'], 2) . '</td>
            <td align="left">' . $row['username'] . '</td>
            <td align="left">' . $row['supplier_id'] . '</td>
            <td align="left">
                <div class="edit-item-container">
                    <a id="edit-item" href="view_item.php?id='. $row['id'] .'">
                    EDIT
                    </a>
                </div>
            </td>';
        if (isset($_SESSION['cart_id'])) {
            echo '<td class="add-item-td" align="left">';
            $q = "SELECT quantity FROM items WHERE cart_id={$_SESSION['cart_id']} AND product_id={$row['id']}";
            $r2 = @mysqli_query($dbc, $q);
            $num = mysqli_num_rows($r2);
            $row2 = mysqli_fetch_row($r2);
            if ($num > 0 && $row2[0] > 0) {
                echo '<div id="item-' . $row['id'] .'" class="add-item-container" 
                    onClick="addItem(' . $row['id'] . ', ' . 0 . ', '. $row2[0] . ');">
                        <span id="item-' . "{$row['id']}" . '-amt" style="width: 25px; text-align: center;">';
                echo "$row2[0]";
            }
            else {
                echo '
                <div id="item-' . $row['id'] .'" class="add-item-container" 
                    onClick="addItem(' . $row['id'] . ');">
                    <span>';
                echo 'ADD';
            }
            echo '
                        </span>
                    </div>
                </td>';
        }
        else {
            echo '<td class="add-item-td" align="left">';
            echo '<div class="add-item-container" onClick="alert(`Please sign in to purchase items`);">
                <span>ADD</span>
                </div></td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($r);
}
else {
    echo '<p class="error">There are currently no registered products.</p>';
}

mysqli_close($dbc);
include('includes/footer.html');
