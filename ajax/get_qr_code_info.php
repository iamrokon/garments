<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $bundle_tkt = $_GET['bundle_tkt'];

    $ob = new select_cproduction();
    $result = $ob->select_cut_pro_by_qrcode($bundle_tkt);

    echo json_encode(mysqli_fetch_assoc($result));
?>
