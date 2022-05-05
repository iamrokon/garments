<?php
    require_once dirname(__FILE__).('/../DB/po/insert.php');

    $po = $_GET['po_num'];

    $obInsert = new insert();
    $result = $obInsert->add_po_number($po);

    echo json_encode($result);
?>
