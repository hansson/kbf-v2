<?php
    include '../../db.php';
    $mysqli = getDBConnection("../../kbf.ini");
    $sql="SELECT * FROM `users` WHERE `group` = 1 ORDER BY `view_order`";
    $mysqli->real_query($sql);
    $result=$mysqli->use_result();
    while($row = $result->fetch_row()) {
        $row['5']
    }
    $mysqli->close();
?>