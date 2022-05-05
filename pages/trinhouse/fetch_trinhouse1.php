<?php require_once '../../DB/trims_inhouse/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/search.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
    // $ob = new select_trims_inhouse();
    // $result = $ob->select_all();

    $request=$_REQUEST;
    $ob = new select_trims_inhouse();
    $result = $ob->select_all_dynamically($request['start'],$request['length']);
    $result1 = $ob->select_trinhouse1();
    $totalRow=mysqli_fetch_assoc($result1);
    $totalData = $totalRow['rowNumber'];
    $totalFilter=$totalData;

    if(!empty($request['search']['value'])){
        $result = $ob->select_all_dynamically2($request['search']['value']);
    }
    $data=array();

    $i = 1;
    //$total = 0;
    foreach ($result as $info) {

    $subdata=array();
    $subdata[]=$info['id'];
    $trinhouseListById = $ob->select_all_trinhouse_name($info['id']);

    while ($trinhouseName = mysqli_fetch_assoc($trinhouseListById)) {

      $subdata[] = $trinhouseName['styleName']." ";
         break;
       }
    $trinhouseListById = $ob->select_all_trinhouse_name($info['id']);

    while ($trinhouseName = mysqli_fetch_assoc($trinhouseListById)) {
        $subdata[] = $trinhouseName['poNumber']." ";
        break;
      }
    $subdata[]=$info['total_requirement'];
    $subdata[]=$info['total_received'];
    $subdata[]=$info['total_issue'];
    $subdata[]=$info['total_balance'];
    $subdata[]='<a href="./pages/trinhouse/details.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small info">Details</button></a>
                <a href="./pages/trinhouse/update.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small info">Update</button></a>
                <a href="./pages/trinhouse/copy.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small info">Copy</button></a>
                <a href="./pages/trinhouse/delete.php?id='.$info['id'].'"><button class="btn badge-text badge-text-small danger">Delete</button></a>';
    $data[]=$subdata;
    $i++;
  }
  $json_data=array(
      // "totalVal"          =>  intval($total),
      "draw"              =>  intval($request['draw']),
      "recordsTotal"      =>  intval($totalData),
      "recordsFiltered"   =>  intval($totalFilter),
      "data"              =>  $data
  );

  echo json_encode($json_data);
?>
