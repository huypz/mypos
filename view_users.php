<?php
$page_title = 'View Current Users';
include('includes/header.html');
echo '<h1>Registered Users</h1>';
require('../mysqli_connect.php');

$q = "SELECT CONCAT(last_name, ', ', first_name) AS name,
    DATE_FORMAT(registration_date, '%M %d %Y') AS dr
    FROM users
    ORDER BY registration_date ASC";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
if ($num > 0) {
    echo '<p>There are currently ' . $num . ' registered users</p>';
    echo '<table width="60%">
        <thead>
        <tr>
            <th align="left">Name</th>
            <th align="left">Date Registered</th>
        </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr>
            <td align="left">' . $row['name'] . '</td>
            <td align="left">' . $row['dr'] . '</td>
            </tr>';
    }
    echo '</tbody></table>';
    mysqli_free_result($r);
}
else {
    echo '<p class="error">There are currently no registered users.</p>';
}

mysqli_close($dbc);
include('includes/footer.html');
?>