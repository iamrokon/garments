<?php
    require_once dirname(__FILE__).('/../DB/process/insert.php');

    $process_name = $_GET['process'];

    $obInsert = new insert();
    $result = $obInsert->add_process_name($process_name);

    echo json_encode($result);
?>
