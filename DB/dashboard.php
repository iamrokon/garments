<?php
require_once dirname(__FILE__).('/db_con.php');

class dashboard extends DB_CON
{

    public function getTotalOrderQuantity(){
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT ifnull(sum(quantity),0) as totalQuantity
              FROM `order_qtn_size` left join `order_details` on `order_details`.id = `order_qtn_size`.order_id
              WHERE order_details.creation_date  LIKE '%".$monthYear."'
              and `order_details`.deletion_status != 1";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          $result = mysqli_fetch_assoc($query_result);
          return $result['totalQuantity'];
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function allOrderQuantity(){
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT ifnull(sum(quantity),0) as totalQuantity
              FROM `order_qtn_size` left join `order_details` on `order_details`.id = `order_qtn_size`.order_id
              WHERE `order_details`.deletion_status != 1";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          $result = mysqli_fetch_assoc($query_result);
          return $result['totalQuantity'];
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function dailyOrderQuantity(){
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $date = date("d-m-Y");

      $sql = "SELECT ifnull(sum(quantity),0) as totalQuantity
              FROM `order_qtn_size` left join `order_details` on `order_details`.id = `order_qtn_size`.order_id
              WHERE order_details.creation_date = '$date'
              and `order_details`.deletion_status != 1";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          $result = mysqli_fetch_assoc($query_result);
          return $result['totalQuantity'];
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }


    public function getTotalCuttingProductionQuantity(){
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT ifnull(sum(quantity),0) as totalQuantity
              FROM `cut_pro_bundle`
              WHERE cut_pro_bundle.creation_date  LIKE '%".$monthYear."'
              and deletion_status != '1'";
      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          $result = mysqli_fetch_assoc($query_result);
          return $result['totalQuantity'];
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function allCuttingProductionQuantity(){
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT ifnull(sum(quantity),0) as totalQuantity
              FROM `cut_pro_bundle`
              WHERE deletion_status != '1'";
      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          $result = mysqli_fetch_assoc($query_result);
          return $result['totalQuantity'];
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function dailyCuttingProductionQuantity(){
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $date = date("d-m-Y");

      $sql = "SELECT ifnull(sum(quantity),0) as totalQuantity
              FROM `cut_pro_bundle`
              WHERE cut_pro_bundle.creation_date = '$date'
              and deletion_status != '1'";
      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          $result = mysqli_fetch_assoc($query_result);
          return $result['totalQuantity'];
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }


    public function dailyInputIssue(){

      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $date = date("d-m-Y");

      $sql = "SELECT
              `cut_pro_bundle`.`quantity`  as quantity,
              cutting_production.lay as lay,
              IFNULL((select sum(quantity) from cut_pro_bundle
              where ticket_no = cut_pro_bundle.ticket_no),0) as total_quantity_bundle,
              (select user_name from user where id = bp_issue.scan_user)  as user_name
              FROM ((`bp_issue` left join `cut_pro_bundle`
              on `cut_pro_bundle`.id = `bp_issue`.b_tkt_code)
              left join `cutting_production`
              on `cut_pro_bundle`.production_id = `cutting_production`.id)
              where bp_issue.date = '$date'
              and bp_issue.deletion_status != 1
              order by `bp_issue`.id desc";

      $sql_new = "SELECT
              serial
              FROM iissue_scan
              where iissue_scan.date = '$date'
              and deletion_status != 1
              order by iissue_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      $query_result_new = mysqli_query($con, $sql_new);
      $totalQuantity = 0;
      if ($query_result) {

          while($row = mysqli_fetch_assoc($query_result))
          {
            $totalQuantity += $row['quantity'];
          }

          //return $totalQuantity;
      }
      if ($query_result_new) {
          while($row = mysqli_fetch_assoc($query_result_new))
          {
            $new_iissue = explode("-",$row['serial']);
            //$new_iissue_qty = $new_iissue[1];
            $new_iissue_qty = $new_iissue[1] - $new_iissue[0] + 1;
            $totalQuantity += $new_iissue_qty;
            //return $new_iissue;
          }
      }
      if($totalQuantity){
        return $totalQuantity;
      }else {
        return 0;
      }
    }

    public function getTotalInputIssue(){

      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT
              `cut_pro_bundle`.`quantity`  as quantity,
              cutting_production.lay as lay,
              IFNULL((select sum(quantity) from cut_pro_bundle
              where ticket_no = cut_pro_bundle.ticket_no),0) as total_quantity_bundle,
              (select user_name from user where id = bp_issue.scan_user)  as user_name
              FROM ((`bp_issue` left join `cut_pro_bundle`
              on `cut_pro_bundle`.id = `bp_issue`.b_tkt_code)
              left join `cutting_production`
              on `cut_pro_bundle`.production_id = `cutting_production`.id)
              where bp_issue.date like '%".$monthYear."'
              and bp_issue.deletion_status != 1
              order by `bp_issue`.id desc";

      $sql_new = "SELECT
              serial
              FROM iissue_scan
              where iissue_scan.date like '%".$monthYear."'
              and deletion_status != 1
              order by iissue_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      $query_result_new = mysqli_query($con, $sql_new);
      $totalQuantity = 0;
      if ($query_result) {

          while($row = mysqli_fetch_assoc($query_result))
          {
            $totalQuantity += $row['quantity'];
          }

          //return $totalQuantity;
      }
      if ($query_result_new) {
          while($row = mysqli_fetch_assoc($query_result_new))
          {
            $new_iissue = (int)explode("-",$row['serial']);
            //$new_iissue_qty = $new_iissue[1];
            $new_iissue_qty = $new_iissue[1] - $new_iissue[0] + 1;
            $totalQuantity += $new_iissue_qty;
            //return $new_iissue;
          }
      }
      if($totalQuantity){
        return $totalQuantity;
      }else {
        return 0;
      }
    }

    public function allInputIssue(){

      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT
              `cut_pro_bundle`.`quantity`  as quantity,
              cutting_production.lay as lay,
              IFNULL((select sum(quantity) from cut_pro_bundle
              where ticket_no = cut_pro_bundle.ticket_no),0) as total_quantity_bundle,
              (select user_name from user where id = bp_issue.scan_user)  as user_name
              FROM ((`bp_issue` left join `cut_pro_bundle`
              on `cut_pro_bundle`.id = `bp_issue`.b_tkt_code)
              left join `cutting_production`
              on `cut_pro_bundle`.production_id = `cutting_production`.id)
              where bp_issue.deletion_status != 1
              order by `bp_issue`.id desc";

      $sql_new = "SELECT
              serial
              FROM iissue_scan
              where deletion_status != 1
              order by iissue_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      $query_result_new = mysqli_query($con, $sql_new);
      $totalQuantity = 0;
      if ($query_result) {

          while($row = mysqli_fetch_assoc($query_result))
          {
            $totalQuantity += $row['quantity'];
          }

          //return $totalQuantity;
      }
      if ($query_result_new) {
          while($row = mysqli_fetch_assoc($query_result_new))
          {
            $new_iissue = explode("-",$row['serial']);
            //$new_iissue_qty = $new_iissue[1];
            if(isset($new_iissue[1])){
              if(is_numeric($new_iissue[1]) && is_numeric($new_iissue[0])){
                $new_iissue_qty = $new_iissue[1] - $new_iissue[0] + 1;
                $totalQuantity += $new_iissue_qty;
              }
            }
            //return $new_iissue;
          }
      }
      if($totalQuantity){
        return $totalQuantity;
      }else {
        return 0;
      }
    }

    public function getTotalTrimsInhouse()
    {
        $con = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $year = date("Y");
        $month = date("m");
        $monthYear = $month."-".$year;

        $sql = "SELECT
                trim_inhouse.*,
                (select sum(required_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_requirement,
                (select sum(receive_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_received,
                (select sum(total_issue_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_issue,
                (select sum(balance_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_balance
                FROM `trim_inhouse`
                where trim_inhouse.creation_date like '%".$monthYear."'
                and deletion_status != 1

                order by trim_inhouse.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
