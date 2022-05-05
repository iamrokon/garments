<?php
    require_once dirname(__FILE__).('/../DB/process_c/insert.php');

    $process_name = $_GET['process_name'];

    $obSelect = new insert();
    $result = $obSelect->add_process_c($process_name);

    echo json_encode($result);
?>
