<?php
    require_once dirname(__FILE__).('/../DB/cplan/select.php');

    $po = $_GET['po'];

    $obSelect = new select_cplan();
    $list = $obSelect->select_quantity_with_po_number_cplan($po);
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
