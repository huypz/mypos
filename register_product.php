<?php
session_start();
$page_title = 'Register Product';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('../mysqli_connect.php');

    $errors = [];
    
    if (empty($_POST['name'])) {
        $errors[] = 'Please enter the product name.';
    }
    else {
        $pn = mysqli_real_escape_string($dbc, trim($_POST['name']));
    }
    if (empty($_POST['category'])) {
        $errors[] = 'Please enter the product category.';
    }
    else {
        $cat = mysqli_real_escape_string($dbc, trim($_POST['category']));
    }
    if (empty($_POST['amount'])) {
        $errors[] = 'Please enter the product amount.';
    }
    else {
        $amt = mysqli_real_escape_string($dbc, trim($_POST['amount']));
    }
    if (empty($_POST['price'])) {
        $errors[] = 'Please enter the product price per unit.';
    }
    else {
        $price = mysqli_real_escape_string($dbc, trim($_POST['price']));
    }
    if (empty($_POST['description'])) {
        $errors[] = 'Please enter the product description.';
    }
    else {
        $desc = mysqli_real_escape_string($dbc, trim($_POST['description']));
    }

    if (isset($_SESSION['user_id'])) {
        $q = "SELECT supplier_id
            FROM suppliers 
            WHERE user_id={$_SESSION['user_id']}";
        $r = @mysqli_query($dbc, $q);
        if (mysqli_num_rows($r) > 0) {
            $sid = mysqli_fetch_row($r)[0];
        }
        else {
            $errors[] = 'Please sign up for a supplier account.';
        }
    }
    else {
        $errors[] = 'Please log in to register a product.';
    }

    if (empty($errors)) {
        $q = "INSERT INTO products (name, category, stock, description, supplier_id, price)
            VALUES ('$pn', '$cat', '$amt', '$desc', '$sid', '$price')";
        $r = @mysqli_query($dbc, $q);

        if ($r) {
            echo '<div class="page-header"><h1>Thank you!</h1></div>
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
<div class="page-header"><h1>Register Product</h1></div>
<form action="register_product.php" method="post">
    <p>Name: <input type="text" name="name" size="15" maxlength="50"
        value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"></p>
    <p>Category: <input type="text" name="category" size="20" maxlength="60"
        value="<?php if (isset($_POST['category'])) echo $_POST['category']; ?>"></p>
    <p>Amount: <input type="number" name="amount" min="1" max="9999"
        value="<?php if (isset($_POST['amount'])) echo $_POST['amount']; ?>"></p>
    <p>Price: <input type="number" name="price" min="0" max="999999999"
        value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>"></p>
    <p>Description: <input type="text" name="description" size="30" maxlength="255"
        value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>"></p>
    <p><input type="submit" name="submit" value="Register"/></p>
</form>
<?php
include('includes/footer.html');
?>