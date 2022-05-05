<?php
    require_once dirname(__FILE__).('/../DB/hour/select.php');

    $obSelect = new select_hour();
    $list = $obSelect->select_all();
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
