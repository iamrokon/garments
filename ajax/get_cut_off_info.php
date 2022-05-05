<?php
    require_once dirname(__FILE__).('/../DB/country/select.php');

    $country_id = $_GET['country_id'];

    $ob = new select_country();
    $result = $ob->select_with_id($country_id);

    echo json_encode(mysqli_fetch_assoc($result));
?>
