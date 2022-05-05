<?php
    require_once dirname(__FILE__).('/../DB/operator/select.php');

    $line_id = $_GET['line'];

    $obSelect = new select_operator();
    $list = $obSelect->select_with_line_id($line_id);
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
