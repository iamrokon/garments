<?php
    require_once dirname(__FILE__).('/../DB/line/select.php');

    $obSelect = new select_line();
    $list = $obSelect->select_all();
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
