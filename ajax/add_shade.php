<?php
    require_once dirname(__FILE__).('/../DB/shade/insert.php');

    $shade_name = $_GET['shade_name'];

    $obInsert = new insert();
    $result = $obInsert->add_shade($shade_name);

    echo json_encode($result);
?>
