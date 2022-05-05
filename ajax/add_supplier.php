<?php
    require_once dirname(__FILE__).('/../DB/supplier/insert.php');

    $supplier_name = $_GET['supplier_name'];

    $obInsert = new insert();
    $result = $obInsert->add_supplier_name($supplier_name);

    echo json_encode($result);
?>
