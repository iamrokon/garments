<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $production_id = $_GET['production_id'];

    $ob = new select_cproduction();
    $result = $ob->select_cut_pro_child2_by_qrcode($production_id);

    echo json_encode(mysqli_fetch_assoc($result));
?>
