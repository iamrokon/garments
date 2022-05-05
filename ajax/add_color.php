<?php
    require_once dirname(__FILE__).('/../DB/color/insert.php');

    $color = $_GET['color_name'];

    $obInsert = new insert();
    $result = $obInsert->add_color($color);

    echo json_encode($result);
?>
