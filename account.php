<?php
session_start();
include('includes/header.html');
require('../mysqli_connect.php');

echo '<div class="page-header"><h2>Account Information Page</h2></div>';

echo '<div class="New Adress"><p2>Enter a new user adress</p2></div>';

echo '<form name = "form" method="post">
            <div class="Card-Number">
                <div class="input-container">
                    <input id="New_Adress" type="text" name="New_Adress" placeholder="New Adress" maxlength="64">
                    <input id="New_City" type="text" name="New_City" placeholder="New City" maxlength="64">
                    <input id="New_State" type="text" name="New_State" placeholder="New State" maxlength="64">
                    <input id="New_Zipcode" type="text" name="New_Zipcode" placeholder="New Zipcode" maxlength="64">
                    <input id="New_Country" type="text" name="New_Country" placeholder="New Country" maxlength="64">
                    <input type = "Submit" value = "Update Adress!">
                </div>
            </div>
</form>';

echo '<br>';

echo '<div class="New Username"><p2>Enter a new user name</p2></div>';

echo '<form name = "form" method="post">
            <div class="Card-Number">
                <div class="input-container">
                    <input id="New_Username" type="text" name="New_Username" placeholder="New Username" maxlength="64">
                    <input type = "Submit" value = "Update Username!">
                </div>
            </div>
</form>';

echo '<br>';

$GetAdd = FALSE;
$GetUser = FALSE;

$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['New_Adress']) || empty($_POST['New_City']) || empty($_POST['New_State']) || empty($_POST['New_Zipcode']) || empty($_POST['New_Country'])) {
        $AddErrors[] = 'Please Enter an address!';
    }
    else
    {
        $Add = mysqli_real_escape_string($dbc, trim($_POST['New_Adress']));
        $City = mysqli_real_escape_string($dbc, trim($_POST['New_City']));
        $State = mysqli_real_escape_string($dbc, trim($_POST['New_State']));
        $Zip = mysqli_real_escape_string($dbc, trim($_POST['New_Zipcode']));
        $Country = mysqli_real_escape_string($dbc, trim($_POST['New_Country']));
        $GetAdd = TRUE;

        $query = "UPDATE users " . "SET street = '$Add', city = '$City', state = '$State', zip_code = '$Zip', country = '$Country' " . "WHERE user_id = '$id'";
        $r = @mysqli_query($dbc, $query);

    }
    if (empty($_POST['New_Username'])) {
        $UserErrors[] = 'Please Enter a username!';
    }
    else
    {
        $User = mysqli_real_escape_string($dbc, trim($_POST['New_Username']));
        $GetUser = TRUE;

        $query = "UPDATE users " . "SET username = '$User' " . "WHERE user_id = '$id'";
        $r = @mysqli_query($dbc, $query);
    }

    if (empty($AddErrors)) {
        echo '<div class="New Adress"><p2>Your new adress is ' . $Add . ' ' . $City . ' ' . $State . ' ' . $Zip . ' ' . $Country . '<br></p2></div>';
    }
    else if(!empty($AddErrors) && $GetUser == FALSE)
    {
        echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br>';
        foreach ($AddErrors as $msg) {
            echo " - $msg<br>\n";
        }
        echo '</p><p>Please try again.</p><p><br></p>';
    }
    if(empty($UserErrors))
    {
        echo '<div class="New Username"><p2>Your username is ' . $User . '<br></p2></div>';
    }
    else if(!empty($UserErrors) && $GetAdd == FALSE)
    {
        echo '<h1>Error!</h1>
            <p class="error">The following error(s) occurred:<br>';
        foreach ($UserErrors as $msg) {
            echo " - $msg<br>\n";
        }
        echo '</p><p>Please try again.</p><p><br></p>';
    }
}



include('includes/footer.html');
?>