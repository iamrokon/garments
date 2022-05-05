<?php
    require_once dirname(__FILE__).('/../DB/unit/insert.php');

    $unit_name = $_GET['unit'];

    $obInsert = new insert();
    $result = $obInsert->add_unit_name($unit_name);

    echo json_encode($result);
?>
