<?php
    require_once dirname(__FILE__).('/../DB/order/select.php');

    $order_id = $_GET['id'];

    $obSelect = new select_order();
    $list = $obSelect->select_unique_size_list_order($order_id);
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
