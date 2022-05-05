<?php
    require_once dirname(__FILE__).('/../DB/item/insert.php');

    $item_name = $_GET['item_name'];

    $obInsert = new insert();
    $result = $obInsert->add_item_name($item_name);

    echo json_encode($result);
?>
