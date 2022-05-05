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
      $totalFilter=$totalData;

      $soutput_qty = $ob->select_tot_soutput_qty();
      $tot_soutput_qty_info = mysqli_fetch_assoc($soutput_qty);
      $tot_soutput_qty=$tot_soutput_qty_info['totRow'];

      $select_order = new select_order();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectCountry = new select_country();
      $country_list =  $selectCountry->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();


      $data=array();

      $i = 1;
      $total_order_qty = 0;
      $countries = "";
while ($info = mysqli_fetch_assoc($result)) {
 $j=0;
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
    $subdata[]=$countries;
    $subdata[]=$info['total_quantity'];
    $total_order_qty += $info['total_quantity'];
    $subdata[]=$info['cutting_plan']." %";


    $cut_pro_id = $ob->select_all_cut_pro_id($info['po']);

    $cut_pro_qty = $ob->select_cut_pro_qty($info['po']);
    $total_cut_pro_qty = 0;
    while ($cut_pro_qty_info = mysqli_fetch_assoc($cut_pro_qty)) {
      $total_cut_pro_qty += $cut_pro_qty_info['total_quantity'];
    }
    $subdata[]=$total_cut_pro_qty;
    $soutput_qty = $ob->select_soutput_qty($info['po']);
    $soutput_qty_info = mysqli_fetch_assoc($soutput_qty);
    $subdata[]=$soutput_qty_info['rowNumber'];
    $subdata[]=$info['cutting_date'];
    $subdata[]=$info['cutting_time'];
    $subdata[]=$info['user_name'];
    $subdata[]='<a href="./pages/swoutput/style_wise_sewing.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small w3-orange">Sewing</button></a>';
    $data[]=$subdata;
    $i++;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "tot_soutput_qty"      =>  intval($tot_soutput_qty),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);

?>
