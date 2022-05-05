<?php
    require_once dirname(__FILE__).('/../DB/section/select.php');

    $obSelect = new select_section();
    $list = $obSelect->select_all();
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
