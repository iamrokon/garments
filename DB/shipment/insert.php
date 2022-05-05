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

        $sql = "INSERT INTO `shipment`
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
  public function shipment_scan_code($complete_qr_code,$user_id)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $date = date("d-m-Y");
      $time = date("h:i:s A");

      $sql = "INSERT INTO `shipment_scan`
                           (
                             complete_qr_code,
                             date,
                             time,
                             scan_user
                           )
                          VALUES
                          (
                            '$complete_qr_code',
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
