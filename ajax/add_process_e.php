<?php
    require_once dirname(__FILE__).('/../DB/process_e/insert.php');

    $process_name = $_GET['name'];
    $smv = $_GET['smv'];

    $obInsert = new insert();

    if($process_name != '')
    {
      $result = $obInsert->add_process_name($process_name,$smv);
      echo json_encode($result);
    }

?>
