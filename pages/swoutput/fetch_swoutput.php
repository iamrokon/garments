<?php require_once '../../DB/swoutput/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>



<?php
      $ob = new select_swoutput();
      //$result = $ob->select_scan_swoutput_history();


      $ob_c = new select_cproduction();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectCountry = new select_country();
      $country_list =  $selectCountry->select_all();

      $selectLine = new select_line();
      $line_list =  $selectLine->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();


?>

<?php
      $request=$_REQUEST;

      $result = $ob->select_scan_swoutput_history2($request['start'],$request['length']);
      $result1 = $ob->select_scan_swoutput_history1();
      $totalRow=mysqli_fetch_assoc($result1);
      $totalData = $totalRow['rowNumber'];
      $totalFilter=$totalData;
      $search1 = 0;

      // if(!empty($request['search']['value'])){
      //     $result2 = $ob->select_scan_swoutput_history3($request['search']['value']);
      //     $search1 = 1;
      // }


$data=array();

    $i = 1;
    foreach ($result as $info) {

    $subdata=array();


    $qrCode = base_convert($info['complete_qr_code'],36,10);

    $row_c_info = $ob_c->select_cut_pro_by_qrcode($qrCode);
    $row_c = mysqli_fetch_assoc($row_c_info);
    $linesName = "";
    $cut_pro_quantity = $qrCode - $row_c['qr_code'];
    $production_id = $row_c['id'];

    $row_c_c_info = $ob_c->select_cut_pro_child_by_qrcode($cut_pro_quantity,$production_id);
    if(!empty($request['search']['value'])){
        $row_c_c_info2 = $ob_c->select_cut_pro_child_by_qrcode2($cut_pro_quantity,$production_id,$request['search']['value']);
        $row_c_c = mysqli_fetch_assoc($row_c_c_info2);
        // if(($search1!=1) || (!$row_c_c['country_name'])){
        //   continue;
        // }
        if(!$row_c_c['country_name']){
          continue;
        }
    }else{
        $row_c_c = mysqli_fetch_assoc($row_c_c_info);
    }


    $row_c_c_info2 = $ob_c->select_cut_pro_child2_by_qrcode($production_id);
    $row_c_c2 = mysqli_fetch_assoc($row_c_c_info2);

    $cut_pro_bundle_id =$row_c_c['id'];
    $getTodInfo = $ob_c->select_tod_complete_qr_code($production_id,$cut_pro_bundle_id);
    $getTod = mysqli_fetch_assoc($getTodInfo);

    $lineNameInfo = $ob_c->select_line_name_by_child_id($cut_pro_bundle_id);
    $lineName = mysqli_fetch_assoc($lineNameInfo);

    $lineId = $ob_c->select_line_name($row_c['po'],$row_c['cut_num']);
    foreach ($lineId as $key => $row4) {

    $serial = explode("-",$row4['serial']);
    $serial_from = $serial['0'];
    $serial_to = $serial['1'];

    if($cut_pro_quantity>=$serial_from && $cut_pro_quantity<=$serial_to){
      $line = $row4['line'];


      $lineNameInfo =  $selectLine->select_with_id($line);
      $line_name = mysqli_fetch_assoc($lineNameInfo);
      $linesName = $line_name['name'];

    }

    }

    $shipmentInfo = $ob_c->select_shipment_info_by_order($production_id,$row_c_c['country_id']);
    $shipment = mysqli_fetch_assoc($shipmentInfo);

    if($lineName['line_name'])
    {
      $exactLine = $lineName['line_name'];
    }
    else {
      if($linesName){
        $exactLine = $linesName;
      }
    }



    $subdata[]=$info['id'];
    $subdata[]=$info['complete_qr_code'];
    $subdata[]=$exactLine;
    $subdata[]=$row_c['style_name'];
    $subdata[]=$row_c['po_number'];
    $subdata[]=$row_c['color_name'];
    $subdata[]=$cut_pro_quantity;
    $subdata[]=$row_c_c['country_name'];
    $subdata[]=$row_c_c['ticket_size'];
    $subdata[]=$row_c['cut_number'];
    $subdata[]=$row_c_c['bundle_no']."/".$row_c_c2['bundle_no'];
    $subdata[]=$getTod['tod'];
    $subdata[]=$shipment['shipment'];
    $subdata[]=$row_c_c['shade_name']."/".$row_c_c['pattern'];
    $subdata[]="";
    $subdata[]=$info['date'];
    $subdata[]=$info['time'];
    //$subdata[]=$row[3]; //age           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
     // $subdata[]='<button type="button" id="getEdit" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$info['id'].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Edit</button>
     //             <a href="./pages/order/order_details.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small info">Details</button></a>
     //             <button type="button" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash">&nbsp;</i>Delete</button>';
    $data[]=$subdata;
    $i++;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);

?>
