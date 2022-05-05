<?php
    require_once dirname(__FILE__).('/../DB/style/select.php');

    $id = $_GET['id'];

    $obSelect = new select_style();
    $list = $obSelect->select_style_process_with_id($id);
    $listArray = array();

    while($row = $list->fetch_array(MYSQLI_ASSOC)) {
            $listArray[] = $row;
    }

    echo json_encode($listArray);
?>
