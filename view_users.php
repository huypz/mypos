<link rel="stylesheet" type="text/css" href="/css/table.css">
<?php
$page_title = 'MY POS - Users';
session_start();
include('includes/header.html');
require('../mysqli_connect.php');

$num = 0;
if(isset($_SESSION['user_id']))
{
    $id = $_SESSION['user_id'];
    $query = "SELECT user_id FROM admins WHERE user_id = '$id'";
    $res = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($res);
}
if($num <= 0)
{
    echo '<div class="page-header"><h1>You must be an admin to view this page!</h1></div>';
}

if($num > 0)
{
    echo '<div class="page-header"><h1>Registered Users</h1></div>';
    $q = "SELECT user_id, CONCAT(last_name, ', ', first_name) AS name,
        email,
        DATE_FORMAT(registration_date, '%M %d %Y') AS dr
        FROM users
        ORDER BY registration_date ASC";
    $r = @mysqli_query($dbc, $q);
    $num = mysqli_num_rows($r);
    if ($num > 0) {
        echo '<p>There are currently ' . $num . ' registered users.</p><br>';
        echo '<div class="table-container">';
        echo '<table>
            <thead>
            <tr>
                <th align="left">ID</th>
                <th align="left">Name</th>
                <th align="left">Email</th>
                <th align="left">Date Registered</th>
                <th align="left">Is Supplier</th>
            </tr>
            </thead>
            <tbody>';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $q2 = "SELECT supplier_id FROM suppliers WHERE user_id={$row['user_id']}";
            $r2 = @mysqli_query($dbc, $q2);
            $num2 = mysqli_num_rows($r2);
            $is_supplier = $num2 > 0 ? "Yes" : "No";
            echo '<tr>
                <td align="left">' . $row['user_id'] . '</td>
                <td align="left">' . $row['name'] . '</td>
                <td align="left">' . $row['email'] . '</td>
                <td align="left">' . $row['dr'] . '</td>
                <td align="left">' . $is_supplier . '</td>
                </tr>';
        }
        echo '</tbody></table></div>';
        mysqli_free_result($r);
    }
    else {
        echo '<p class="error">There are currently no registered users.</p>';
    }
}
mysqli_close($dbc);
include('includes/footer.html');
?>