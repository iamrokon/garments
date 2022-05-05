<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
                         $order_id,
                         $country_id,
                         $size,
                         $quantity,
                         $user_id,
                         $creation_date,
                         $creation_time
                         )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `input_issue`
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
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }

  }

  public function order_quantity_save($order_id,$size,$quantity,$user_id)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $sql = "INSERT INTO `order_qtn_size`
                           (
                             order_id,
                             size,
                             quantity,
                             user_id
                           )
                          VALUES
                          ( '$order_id',
                            '$size',
                            '$quantity',
                            '$user_id'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }

}


public function bundle_issue_code($bundle_tkt_code,$line,$serial,$quantity,$user_id)
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    date_default_timezone_set("Asia/Dhaka");
    $date = date("d-m-Y");
    $time = date("h:i:s A");

    $sql = "INSERT INTO `bp_issue`
                         (
                           b_tkt_code,
                           line,
                           serial,
                           quantity,
                           date,
                           time,
                           scan_user
                         )
                        VALUES
                        (
                          '$bundle_tkt_code',
                          '$line',
                          '$serial',
                          '$quantity',
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

}public function save_iissue_info($po,$cut_num,$line,$serial,$user_id)
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    date_default_timezone_set("Asia/Dhaka");
    $date = date("d-m-Y");
    $time = date("h:i:s A");

    $sql = "INSERT INTO `iissue_scan`
                         (
                           po,
                           cut_num,
                           line,
                           serial,
                           date,
                           time,
                           scan_user
                         )
                        VALUES
                        (
                          '$po',
                          '$cut_num',
                          '$line',
                          '$serial',
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
