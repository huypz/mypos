<?php
require('../mysqli_connect.php');

$q = "SELECT p.name, p.id
    FROM products AS p
    WHERE p.name LIKE '%{$_GET['input']}%' 
    ORDER BY
        CASE
            WHEN p.name LIKE '{$_GET['input']}' THEN 1
            WHEN p.name LIKE '{$_GET['input']}%' THEN 2
            WHEN p.name LIKE '%{$_GET['input']}' THEN 3
            ELSE 4
        END
    LIMIT 10";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
if ($num > 0) {
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<div class="autocomplete-item"> 
            <a href="view_item.php?id=' . $row['id'] . '">' . $row['name'] . '</a>' .
            '</div>';
    }
}
mysqli_close($dbc);
?>