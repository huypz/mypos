<?php
session_start();
include('includes/header.html');
require('../mysqli_connect.php');

echo '<div class="page-header"><h2>Update Stock Info</h2></div>';
$id = $_SESSION['user_id'];
$query = "SELECT s.supplier_id FROM suppliers AS s WHERE s.user_id = '$id'";
$res = @mysqli_query($dbc, $query);
$num = mysqli_num_rows($res);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
if($num <= 0)
{
    echo '<div class="Not A supplier"><p2>You are not a supplier!</p2></div>';
}
else if($num >= 0)
{
    $suppId = $row['supplier_id'];
    echo '<div class="Supplier"><p2>Your current items for supplier ' . $suppId . ' are </p2></div>';
    echo '<div class="table-container">';
    echo '<table>
    <thead>
    <tr>
        <th align="left">Name</th>
        <th align="left">ID</th> 
    </tr>
    </thead>
    <tbody>';
    $query = "SELECT name, id FROM products WHERE supplier_id = '$suppId'";
    $res = @mysqli_query($dbc, $query);
    while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['id'] . '</td>
            </td>
            </tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($res);

    echo '<div class="Change-Stock"><p2><br><br>Please enter the Id of the product you wish to change</p2></div>';

    echo '<form name = "form" method="post">
            <div class="Card-Number">
                <div class="input-container">
                    <input id="product_id" type="text" name="product_id" placeholder="Product Id" maxlength="64">
                    <input id="New_Amount" type="text" name="New_Amount" placeholder="New Amount" maxlength="64">
                    <input type = "Submit" value = "Update Stock!">
                </div>
            </div>
    </form>';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = [];
        if (empty($_POST['product_id'])) {
            $errors[] = 'Please enter a valid product ID!';
        }
        else
        {
            $prodId = mysqli_real_escape_string($dbc, trim($_POST['product_id']));
        }
    
        if (empty($_POST['New_Amount'])) {
            $errors[] = 'Please enter a valid amount!';
        }
        else
        {
            $New_Amount = mysqli_real_escape_string($dbc, trim($_POST['New_Amount']));
        }

        if (empty($errors)) {
            $query = "UPDATE products SET stock = '$New_Amount' WHERE id = '$prodId'";
            $res = @mysqli_query($dbc, $query);
        }
        else
        {
            echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
            echo '</p><p>Please try again.</p><p><br></p>';
        }

    }
    

}













include('includes/footer.html');
?>