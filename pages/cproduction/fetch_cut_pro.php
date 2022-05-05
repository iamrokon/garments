<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/cproduction/search.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>


<?php
    $request=$_REQUEST;
    $ob = new select_cproduction();
    $result = $ob->select_cut_pro_info($request['start'],$request['length']);
    $result1 = $ob->select_cut_pro_info1();
    $totalRow=mysqli_fetch_assoc($result1);
    $totalData = $totalRow['rowNumber'];
    $totalFilter=$totalData;

    if(!empty($request['search']['value'])){
        $result = $ob->select_cut_pro_info2($request['search']['value']);
    }

    $data=array();

    $i = 0;
    $total = 0;
     foreach ($result as $info) {

    $subdata=array();
    $subdata[]=$info['id'];
    $subdata[]=$info['buyer_name'];
    $subdata[]=$info['style_name'];
    $subdata[]=$info['po_number'];
    $subdata[]=$info['cut_number'];
    $pro_cut = $info['cutting_production'];
    $subdata[]=$pro_cut;
    $subdata[]=$info['color_name'];
    $subdata[]=$info['shade_name'];
    $subdata[]=$info['creation_date']."<br>".$info['creation_time'];
    $subdata[]=$info['user_name'];

     $subdata[]='<a href="./pages/cproduction/details.php?id='.$info['id'].'"><button style="font-size:.8rem" class="btn badge-text badge-text-small info">Details</button></a>
                 <a href="./pages/cproduction/complete_qr_code_pdf.php?id='.$info['id'].'"><button style="font-size:.8rem" class="btn badge-text badge-text-small w3-green">C. QR</button></a>
                 <a href="./pages/cproduction/complete_qr_code_pdf_new.php?id='.$info['id'].'"><button style="font-size:.8rem" class="btn badge-text badge-text-small w3-green">QR2</button></a>
                 <a href="./pages/cproduction/delete.php?id='.$info['id'].'"><button style="font-size:.8rem" class="btn badge-text badge-text-small danger">Delete</button></a>';
    $data[]=$subdata;
     $i++;
     $total += $pro_cut;
 }

$json_data=array(
    "totalVal"              =>  intval($total),
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);
// echo json_encode(
//     SSP::simple($json_data)
// );

?>
