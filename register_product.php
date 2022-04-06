<?php
$page_title = 'Register Product';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('../mysqli_connect.php');

    $errors = [];
    
    if (empty($_POST['product_name'])) {
        $errors[] = 'Please enter the product name.';
    }
    else {
        $pn = mysqli_real_escape_string($dbc, trim($_POST['product_name']));
    }
    if (empty($_POST['category'])) {
        $errors[] = 'Please enter the product category.';
    }
    else {
        $cat = mysqli_real_escape_string($dbc, trim($_POST['category']));
    }
    if (empty($_POST['description'])) {
        $errors[] = 'Please enter the product description.';
    }
    else {
        $desc = mysqli_real_escape_string($dbc, trim($_POST['description']));
    }
    if (empty($_POST['supplier_id'])) {
        $errors[] = 'Please enter the supplier id.';
    }
    else {
        $sid = mysqli_real_escape_string($dbc, trim($_POST['supplier_id']));
    }

    if (empty($errors)) {
        $q = "INSERT INTO ingredients (name, category, description, stock, supplier_id)
            VALUES ('$pn', '$cat', '$desc', 1, '$sid')";
        $r = @mysqli_query($dbc, $q);

        if ($r) {
            echo '<h1>Thank you!</h1>
                <p>Product registration successful.</p>
                <p><br/></p>';
        }
        else {
            echo '<h1>System Error</h1>
                <p class="error">You could not be registered due to a system error. We apologize
                for any inconvenience.</p>';
            echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';
        }
        mysqli_close($dbc);
        include('includes/footer.html');
        exit();
    }
    else {
        echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
        echo '</p><p>Please try again.</p><p><br></p>';
    }
}

?>
<h1>Register Product</h1>
<form action="register_product.php" method="post">
    <p>Product Name: <input type="text" name="product_name" size="15" maxlength="50"
        value="<?php if (isset($_POST['product_name'])) echo $_POST['product_name']; ?>"></p>
    <p>Product Category: <input type="text" name="category" size="20" maxlength="60"
        value="<?php if (isset($_POST['category'])) echo $_POST['category']; ?>"></p>
    <p>Product Description: <input type="text" name="description" size="30" maxlength="255"
        value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>"></p>
    <p>Supplier ID: <input type="text" name="supplier_id" size="15" maxlength="40"
        value="<?php if (isset($_POST['supplier_id'])) echo $_POST['supplier_id']; ?>"></p>
    <p><input type="submit" name="submit" value="Register"/></p>
</form>
<?php
include('includes/footer.html');
?>
