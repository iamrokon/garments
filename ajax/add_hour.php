<?php
    require_once dirname(__FILE__).('/../DB/hour/insert.php');

    $hour_name = $_GET['hour'];

    $obInsert = new insert();
    $result = $obInsert->add_hour_name($hour_name);

    echo json_encode($result);
?>
