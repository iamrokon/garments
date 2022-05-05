<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $production_id = $_GET['production_id'];
    $cut_pro_bundle_id = $_GET['cut_pro_bundle_id'];

    $ob = new select_cproduction();
    $result = $ob->select_tod_complete_qr_code($production_id,$cut_pro_bundle_id);

    echo json_encode(mysqli_fetch_assoc($result));
?>
