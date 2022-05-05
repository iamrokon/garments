<?php
    require_once dirname(__FILE__).('/../DB/cproduction/select.php');

    $cut_pro_bundle_id = $_GET['cut_pro_bundle_id'];

    $ob = new select_cproduction();
    $result = $ob->select_line_name_by_child_id($cut_pro_bundle_id);

    echo json_encode(mysqli_fetch_assoc($result));
?>
