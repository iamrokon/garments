<?php
    require_once dirname(__FILE__).('/../DB/section/insert.php');

    $section = $_GET['section_name'];

    $obInsert = new insert();
    $result = $obInsert->add_section($section);

    echo json_encode($result);
?>
