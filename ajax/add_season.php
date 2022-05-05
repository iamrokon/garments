<?php
    require_once dirname(__FILE__).('/../DB/season/insert.php');

    $season_name = $_GET['season_name'];

    $obInsert = new insert();
    $result = $obInsert->add_season_name($season_name);

    echo json_encode($result);
?>
