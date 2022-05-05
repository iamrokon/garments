<?php
    require_once dirname(__FILE__).('/../DB/rejection/insert.php');

    $name = $_GET['name'];

    $obInsert = new insert();
    $result = $obInsert->add_rejection($name);

    echo json_encode($result);
?>
