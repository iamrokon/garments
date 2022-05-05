<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
                          $data
                        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `finishing_plan_monthly`
                             (
                               unit_id,
                               style_id,
                               po_id,
                               week,
                               cutoff,
                               quantity,
                               color,
                               plan_date,
                               user_id,
                               creation_date,
                               creation_time
                             )
                            VALUES
                            (
                              '$data[unit_select]',
                              '$data[style_select]',
                              '$data[po_select]',
                              '$data[week_number]',
                              '$data[cutoff_select]',
                              '$data[quantity]',
                              '$data[color]',
                              '$data[plan_date]',
                              '$data[user_id]',
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

}

?>
