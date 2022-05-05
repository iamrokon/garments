<?php
    require_once dirname(__FILE__).('/../DB/operator/insert.php');

    $name = $_GET['name'];
    $id = $_GET['id'];
    $line = $_GET['line'];

    $obInsert = new insert();
    $result = $obInsert->add_operator($name,$id,$line);

    echo json_encode($result);
?>
