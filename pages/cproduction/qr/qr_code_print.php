<?php require_once '../../DB/cproduction/select.php'; ?>

<?php

$cut_pro_id = $_GET['cut_pro_id'];
$ticket = $_GET['ticket'];

try{
  $print_number = $_GET['print_number'];
} catch (Exception $err){
  $print_number = 5;
}

//select cproduction details
$selectCproduction = new select_cproduction();
$cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
$cproduction_details = mysqli_fetch_assoc($cproduction_result);

//select child of cproduction bundles
$cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);

$cproduction_process_result = $selectCproduction->select_bundle_process_with_production_id($cut_pro_id);


?>
