<?php
    require_once dirname(__FILE__).('/../DB/item/select.php');

    $obSelect = new select_item();
    $list = $obSelect->select_all();
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
