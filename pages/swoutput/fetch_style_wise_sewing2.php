<?php require_once '../../DB/swoutput/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>



<?php
// $user_id = $_SESSION['id'];
// $order_id = $_GET['id'];
$request=$_REQUEST;
$order_id = $request['order_id'];
$user_id = $request['user_id'];
$from_date = $request['from_date'];
$to_date = $request['to_date'];
 $selectOrder = new select_order();
 $order_result = $selectOrder->select_with_id($order_id);
 $selectCProduction = new select_cproduction();
 $order_details = mysqli_fetch_assoc($order_result);

       $selectLine = new select_line();

       $ob = new select_swoutput();
       $date = date("d-m-Y");

       $selectLine = new select_line();
       $line_list =  $selectLine->select_all();

       $ob_c = new select_cproduction();

       $selectSize = new select_size();
       $size_list =  $selectSize->select_all();

       $selectCountry = new select_country();
       $country_list =  $selectCountry->select_all();

       $selectPO = new select_po();
       $po_list =  $selectPO->select_all();

       $selectStyle = new select_style();
       $style_list =  $selectStyle->select_all();





?>
<?php
      //$request=$_REQUEST;
      $orderedCountryList = $selectOrder->select_oder_country_and_line_with_id_by_length($order_id,$request['start'],$request['length']);
      $orderedCountryList1 = $selectOrder->select_oder_country_and_line_with_id_by_length1($order_id);
      $rejectMultiple = 1;
      $total = 0;

      $totalRow=mysqli_fetch_assoc($orderedCountryList1);
      $totalData = $totalRow['rowNumber'];
      $totalFilter=$totalData;
      $search1 = 0;

      $data=array();

     $order_child_size_country = $selectOrder->select_child_with_order($order_id);
     while ($row = mysqli_fetch_assoc($order_child_size_country)){
        $size_id[] = $row['size_id'];
     }

    $i = 1;
    //foreach ($result as $info) {
    foreach ($orderedCountryList as $country) {

    $subdata=array();

    $subdata[]=$country['line_name'];
    $subdata[]=$order_details['style_name'];
    $subdata[]=$order_details['po_number'];
    $subdata[]=$country['country_name']." ";
    $grandTotal = 0;
    foreach ($size_id as  $size_info)
    {
      $result = $ob->select_scan_swoutput_by_style_po2($country['line_id'],$order_details['style'],$order_details['po'],$country['country_id'],$size_info,$from_date,$to_date);
      $scanCount = mysqli_num_rows($result);
      $subdata[]= $scanCount;
      $total += $scanCount;
    }

    // $subdata[]="e";
    $subdata[]=$total;
    //$subdata[]=$info['id'];
    // $subdata[]=$info['complete_qr_code'];
    // $subdata[]=$exactLine;
    // $subdata[]=$row_c['style_name'];
    // $subdata[]=$row_c['po_number'];
    // $subdata[]=$row_c['color_name'];
    // $subdata[]=$cut_pro_quantity;
    // $subdata[]=$row_c_c['country_name'];
    // $subdata[]=$row_c_c['ticket_size'];
    // $subdata[]=$row_c['cut_number'];
    // $subdata[]=$row_c_c['bundle_no']."/".$row_c_c2['bundle_no'];
    // $subdata[]=$getTod['tod'];
    // $subdata[]=$shipment['shipment'];
    // $subdata[]=$row_c_c['shade_name']."/".$row_c_c['pattern'];
    // $subdata[]="";
    // $subdata[]=$info['date'];
    // $subdata[]=$info['time'];
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
