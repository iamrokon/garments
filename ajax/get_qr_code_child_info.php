<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $cut_pro_quantity = $_GET['cut_pro_quantity'];
    $production_id = $_GET['production_id'];

    $ob = new select_cproduction();
    $result = $ob->select_cut_pro_child_by_qrcode($cut_pro_quantity,$production_id);

    echo json_encode(mysqli_fetch_assoc($result));
?>
