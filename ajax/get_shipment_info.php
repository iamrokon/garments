<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $production_id = $_GET['production_id'];

    $ob = new select_cproduction();
    $result = $ob->select_shipment_info_by_order($production_id);

    echo json_encode(mysqli_fetch_assoc($result));
?>
