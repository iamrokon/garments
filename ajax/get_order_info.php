<?php
    require_once dirname(__FILE__).('/../DB/order/select.php');

    $po = $_GET['id'];

    $obSelect = new select_order();
    $list = $obSelect->select_with_po($po);
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray[0]);
?>
