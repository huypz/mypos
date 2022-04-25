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
$page_title = "Update Stock";
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
        echo '<div class="page-header"><h2>You are not a supplier!</h2></div>';
    }
    else if($num >= 0)
    {
        echo '<div class="page-header"><h2>Update Stock Info</h2></div>';
        $suppId = $row['supplier_id'];
        echo '<div class="Supplier"><p>Your current items for are listed below.</p></div><br>';
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
        $query = "SELECT name, id, stock FROM products WHERE supplier_id = '$suppId'";
        $res = @mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
        {
            echo '<tr>
                <td align="left">' . $row['name'] . '</td>
                <td align="left">' . $row['id'] . '</td>
                <td align="left">' . $row['stock'] . '</td>
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
}
else {
    echo '<div class="page-header"><h2>Only available to suppliers!</h2></div>';
}


include('includes/footer.html');
?>