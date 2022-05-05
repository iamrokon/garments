<?php
    require_once dirname(__FILE__).('/../DB/buyer/insert.php');

    $buyer_name = $_GET['buyer_name'];

    $obInsert = new insert();
    $result = $obInsert->add_buyer_name($buyer_name);

    echo json_encode($result);
?>
