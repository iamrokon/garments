<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save( $order_id,
                          $country_id,
                          $size,
                          $quantity,
                          $user_id
                        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `swing_output`
                             (
                               order_id,
                               country_id,
                               size,
                               quantity,
                               user_id,
                               creation_date,
                               creation_time
                             )
                            VALUES
                            ( '$order_id',
                              '$country_id',
                              '$size',
                              '$quantity',
                              '$user_id',
                              '$date',
                              '$time'
                            )";

          if (mysqli_query($db_connect, $sql)) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
            return $message;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }

  }

  public function swing_output_scan_code($complete_qr_code,$pro_id,$user_id)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $date = date("Y-m-d");
      $time = date("h:i:s A");

      $inputQrCode = base_convert($complete_qr_code, 36, 10);

      $sql1 = "SELECT
              cutting_production.*
              FROM `cutting_production`
              where `cutting_production`.qr_code <= $inputQrCode
              and deletion_status != 1
              order by `cutting_production`.`id` desc
              LIMIT 1";

      $query_result = mysqli_query($db_connect, $sql1);
      $row_c = mysqli_fetch_assoc($query_result);
      $production_id = $row_c['id'];
      $style = $row_c['style'];
      $po = $row_c['po'];


      $cut_pro_quantity = $inputQrCode - $row_c['qr_code'];
      $sql2 = "SELECT cut_pro_bundle.*,
              (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
              and ticket_no = cut_pro_bundle.ticket_no) as size
              FROM `cut_pro_bundle`
              where production_id = '".$production_id."'
              and '".$cut_pro_quantity."' >= `cut_pro_bundle`.`from_id`
              and deletion_status != 1
              order by `cut_pro_bundle`.`id` desc
              LIMIT 1";

      $query_result2 = mysqli_query($db_connect, $sql2);
      $row_c_c = mysqli_fetch_assoc($query_result2);

      $cut_pro_bundle_id =$row_c_c['id'];
      $country =$row_c_c['country_id'];
      $size =$row_c_c['size'];

      $sql3 = "SELECT
              `bp_issue`.id as id,
              `bp_issue`.line as line,
              (select name from line where id = bp_issue.line) as line_name
              FROM `bp_issue` where
              `bp_issue`.b_tkt_code = '".$cut_pro_bundle_id."'
              and bp_issue.deletion_status != 1
              order by `bp_issue`.id desc LIMIT 1";
      $query_result3 = mysqli_query($db_connect, $sql3);
      $lineName = mysqli_fetch_assoc($query_result3);

      $po = $row_c['po'];
      $cut_num = $row_c['cut_num'];
      $sql4 = "SELECT iissue_scan.*
              FROM `iissue_scan`
              where po = $po
              and cut_num = $cut_num
              and deletion_status != 1
              order by `iissue_scan`.id desc";
      $lineId = mysqli_query($db_connect, $sql4);

      foreach ($lineId as $key => $row4) {
        $serial = explode("-",$row4['serial']);
        $serial_from = $serial['0'];
        $serial_to = $serial['1'];

        if($cut_pro_quantity>=$serial_from && $cut_pro_quantity<=$serial_to){
          $line = $row4['line'];
        }
      }

      if($lineName['line_name'])
      {
        $exactLine = $lineName['line'];
      }
      else {
        if($line){
          $exactLine = $line;
        }
      }

      $sql = "INSERT INTO `swing_output_scan`
                           (
                             complete_qr_code,
                             line,
                             production_id,
                             style,
                             po,
                             country,
                             size,
                             date,
                             time,
                             scan_user
                           )
                          VALUES
                          (
                            '$complete_qr_code',
                            '$exactLine',
                            '$production_id',
                            '$style',
                            '$po',
                            '$country',
                            '$size',
                            '$date',
                            '$time',
                            '$user_id'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
  }


}

?>
