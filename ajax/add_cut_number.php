<?php
    require_once dirname(__FILE__).('/../DB/cut_number/insert.php');

    $cut_number = $_GET['cut_number'];

    $obInsert = new insert();
    $result = $obInsert->add_cut_number($cut_number);

    echo json_encode($result);
?>
