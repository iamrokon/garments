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
                               country,
                               style,
                               po,
                               user_id,
                               creation_date,
                               creation_time
                             )
                            VALUES
                            ( '$data[country]',
                              '$data[style]',
                              '$data[po]',
                              '$data[user_id]',
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





}

?>
