<?php
    require_once dirname(__FILE__).('/../DB/style/insert.php');

    $style_name = $_GET['style_name'];

    $obInsert = new insert();
    $result = $obInsert->add_style($style_name);

    echo json_encode($result);
?>
