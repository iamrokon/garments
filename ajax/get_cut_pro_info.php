<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $cut_no = $_GET['cut_no'];
    $po = $_GET['po'];

    $obSelect = new select_cproduction();
    $result = $obSelect->select_with_po_cut_no($cut_no,$po);
    // $listArray = array();
    //
    // while($row = $list->fetch_array(MYSQLI_ASSOC)) {
    //         $listArray[] = $row;
    // }

    //echo json_encode($listArray[0]);

    // $ob = new select_cproduction();
    // $result = $ob->select_child_id($bundle_tkt);
    $resultInfo = mysqli_fetch_assoc($result);
    if($resultInfo){
      echo json_encode($resultInfo);
    }
?>
