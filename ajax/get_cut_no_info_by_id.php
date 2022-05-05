<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $cut_no = $_GET['cut_no'];

    $obSelect = new select_cproduction();
    $result = $obSelect->select_cut_no_by_id($cut_no);
    // $listArray = array();
    //
    // while($row = $list->fetch_array(MYSQLI_ASSOC)) {
    //         $listArray[] = $row;
    // }

    //echo json_encode($listArray[0]);

    // $ob = new select_cproduction();
    // $result = $ob->select_child_id($bundle_tkt);

    echo json_encode(mysqli_fetch_assoc($result));
?>
