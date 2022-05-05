<?php require_once '../../DB/shipment/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>

<?php
$request=$_REQUEST;
      $ob = new select_shipment();
      $result = $ob->select_all_order_list_info($request['start'],$request['length']);
      $result1 = $ob->select_all_order_list_info1();
      $totalRow=mysqli_fetch_assoc($result1);
      $totalData = $totalRow['rowNumber'];
      $total_order_qty = $totalRow['total_qty'];
      $totalFilter=$totalData;

      $select_order = new select_order();


$data=array();

$i = 1;
$countries = "";
while ($info = mysqli_fetch_assoc($result)) {
 $j=0;
//while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[]=$info['id'];
    $subdata[]=$info['style_name'];
    $subdata[]=$info['po_number'];


    $countries = "";
    $countryList = $select_order->select_oder_country_with_id($info['id']);
    while ($country = mysqli_fetch_assoc($countryList)) {
    if($j==3){
      $countries .= $country['country_name'].".... ";
        break;
    }
    $j++;
    $countries .= $country['country_name']." ";
    }
    //echo $countries;
    $subdata[]=$countries;
    $subdata[]=$info['total_quantity'];
    // $total_order_qty += $info['total_quantity'];
    $subdata[]=$info['cutting_plan']." %";
    $subdata[]=$info['cutting_date'];
    $subdata[]=$info['cutting_time'];
    $subdata[]=$info['user_name'];
    //$subdata[]=$row[3]; //age           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
     $subdata[]='<a href="./pages/order/order_details.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small info">Details</button></a>
                 <a href="./pages/order/export.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small w3-orange">PDF</button></a>
                 <a href="./pages/order/excel.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small w3-green">Excel</button></a>
                 <a href="./pages/order/delete.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small danger">Delete</button></a>';
    $data[]=$subdata;
    $i++;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "total_order_qty"   =>  intval($total_order_qty),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);

?>
