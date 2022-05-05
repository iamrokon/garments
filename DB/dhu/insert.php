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

      $sql = "INSERT INTO `dhu`
                           (
                             date,
                             user_id,
                             creation_date,
                             creation_time
                           )
                          VALUES
                          (
                            '$data[date]',
                            '$data[user_id]',
                            '$date',
                            '$time'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              return $db_connect->insert_id;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
}



public function save_dhu_child(
                               $dhu_id,
                               $reject_id,
                               $style_id,
                               $quantity
                              )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `dhu_category`
                         (
                           dhu_id,
                           rejection_id,
                           style_id,
                           quantity
                         )
                        VALUES
                        (
                          '$dhu_id',
                          '$reject_id',
                          '$style_id',
                          '$quantity'
                        )";

      if (mysqli_query($db_connect, $sql)) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
            return $message;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }
}
public function save_sewing_dhu_report($data)
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    date_default_timezone_set("Asia/Dhaka");
    $date = date("d-m-Y");
    $time = date("h:i:s A");

    $sql = "INSERT INTO `sewing_dhu_report`
                         (
                           style_id,
                           user_id,
                           creation_date
                         )
                        VALUES
                        (
                          '$data[style]',
                          '$data[user_id]',
                          '$data[date]'
                        )";

      if (mysqli_query($db_connect, $sql)) {
            return $db_connect->insert_id;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }
}
public function save_sewing_dhu_report_details(
                                $sewing_dhu_report_id,
                                $rejection_id,
                                $front,
                                $back,
                                $waist_band,
                                $output_top_side,
                                $total,
                                $process_percent,
                                $fixed_value
                              )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `sewing_dhu_report_details`
                         (
                           sewing_dhu_report_id,
                           rejection_id,
                           front,
                           back,
                           waist_band,
                           output_top_side,
                           total,
                           process_percent,
                           fixed_value
                         )
                        VALUES
                        (
                          '$sewing_dhu_report_id',
                          '$rejection_id',
                          '$front',
                          '$back',
                          '$waist_band',
                          '$output_top_side',
                          '$total',
                          '$process_percent',
                          '$fixed_value'
                        )";

      if (mysqli_query($db_connect, $sql)) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
            return $message;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }
}


public function save_dhu_category_details(
                                          $dhu_id,
                                          $style_id,
                                          $input_quantity,
                                          $remarks
                                          )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `dhu_category_details`
                         (
                           dhu_id,
                           style_id,
                           input_quantity,
                           remarks
                         )
                        VALUES
                        (
                          '$dhu_id',
                          '$style_id',
                          '$input_quantity',
                          '$remarks'
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
