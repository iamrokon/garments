<?php
    require_once dirname(__FILE__).('/../DB/country/insert.php');

    $country_name = $_GET['country_name'];
    $cut = $_GET['cut'];
    $country_code = $_GET['country_code'];

    $obSelect = new insert();
    $result = $obSelect->add_country($country_name,$cut,$country_code);

    echo json_encode($result);
?>
