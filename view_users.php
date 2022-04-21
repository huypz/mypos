<link rel="stylesheet" type="text/css" href="/css/table.css">
<?php
$page_title = 'MY POS - Users';
include('includes/header.html');
echo '<div class="page-header"><h1>Registered Users</h1></div>';
require('../mysqli_connect.php');

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
        </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr>
            <td align="left">' . $row['user_id'] . '</td>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['email'] . '</td>
            <td align="left">' . $row['dr'] . '</td>
            </tr>';
    }
    echo '</tbody></table></div>';
    mysqli_free_result($r);
}
else {
    echo '<p class="error">There are currently no registered users.</p>';
}

mysqli_close($dbc);
include('includes/footer.html');
?>