<?php
    require_once dirname(__FILE__).('/../DB/size/insert.php');

    $size_number = $_GET['size_number'];
    $inseam_number = $_GET['inseam'];

    $obInsert = new insert();
    $result = $obInsert->add_size($size_number,$inseam_number);

    echo json_encode($result);
?>
