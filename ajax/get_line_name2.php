<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $po = $_GET['po'];
    $cut_num = $_GET['cut_num'];

    $ob = new select_cproduction();
    $result = $ob->select_line_name($po,$cut_num);
    $listArray = array();

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $listArray[] = $row;
    }
    echo json_encode($listArray);

    // $listArray = array();
    //
    // while($row = $list->fetch_array(MYSQLI_ASSOC)) {
    //         $listArray[] = $row;
    // }
    //
    // echo json_encode($listArray);

    //echo json_encode(mysqli_fetch_assoc($result));
?>
