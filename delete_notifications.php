<?php
require('notifications.php');
require('../mysqli_connect.php');


$query2 = "DELETE FROM ibt_email_queue WHERE supplier_id = '$suppId'";
$res = @mysqli_query($dbc, $query2);

$query3 = "DELETE FROM iat_email_queue WHERE supplier_id = '$suppId'";
$res = @mysqli_query($dbc, $query3);

?>