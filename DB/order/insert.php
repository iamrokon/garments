<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save($data)
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `order_details`
                             (
                               style,
                               po,
                               buyer,
                               color,
                               user_id,
                               season,
                               creation_date,
                               creation_time
                             )
                            VALUES
                            (
                              '$data[style]',
                              '$data[po]',
                              '$data[buyer_id]',
                              '$data[color_id]',
                              '$data[user_id]',
                              '$data[season_id]',
                              '$date',
                              '$time'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                //$message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
                return $db_connect->insert_id;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }

  }

  public function order_quantity_save($order_id=NULL,$size=NULL,$size_id=NULL,$quantity=NULL,$country=NULL,$user_id=NULL)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $sql_size = "SELECT size_num from size where id='$size_id' ";
      $result_size = mysqli_query($db_connect,$sql_size);
      $data = mysqli_fetch_assoc($result_size);
      $size = $data['size_num'];

      $sql = "INSERT INTO `order_qtn_size`
                           (
                             order_id,
                             size,
                             size_id,
                             quantity,
                             country_id,
                             user_id
                           )
                          VALUES
                          ( '$order_id',
                            '$size',
                            '$size_id',
                            '$quantity',
                            '$country',
                            '$user_id'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }

}


public function order_quantity_multi_save($sql)
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

      if (mysqli_multi_query($db_connect, $sql)) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
            return $message;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }

}




public function order_country_save(
                                   $order_id,
                                   $country_id,
                                   $color_id,
                                   $tod,
                                   $shipment,
                                   $user_id
                                   )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `order_country`
                         (
                           order_id,
                           country_id,
                           color_id,
                           tod,
                           shipment,
                           user_id
                         )
                        VALUES
                        ( '$order_id',
                          '$country_id',
                          '$color_id',
                          '$tod',
                          '$shipment',
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
