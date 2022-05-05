<?php
    require_once dirname(__FILE__).('/../DB/line/insert.php');

    $name = $_GET['name'];

    $obInsert = new insert();
    $result = $obInsert->add_line($name);

    echo json_encode($result);
?>
