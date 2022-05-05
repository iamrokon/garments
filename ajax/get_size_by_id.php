<?php
    require_once dirname(__FILE__).('/../DB/size/select.php');

    $size = $_GET['size'];

    $ob = new select_size();
    $result = $ob->select_with_id($size);

    echo json_encode(mysqli_fetch_assoc($result));
?>
