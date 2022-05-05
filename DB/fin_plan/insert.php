<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
                          $user_id
                        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `finshing_plan`
                             (
                               user_id,
                               creation_date,
                               creation_time
                             )
                            VALUES
                            (
                              '$user_id',
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


  public function finishing_plan_hour_quantity_save(
                                                    $plan_id,
                                                    $unit_id,
                                                    $hour_id,
                                                    $hour_value,
                                                    $target,
                                                    $process
                                                    )
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $sql = "INSERT INTO `finishing_plan_hour`
                           (
                             plan_id,
                             unit_id,
                             hour_id,
                             hour_value,
                             target,
                             process_id
                           )
                          VALUES
                          ( '$plan_id',
                            '$unit_id',
                            '$hour_id',
                            '$hour_value',
                            '$target',
                            '$process'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }

}


public function finishing_planning_unit_save(
                                             $plan_id,
                                             $unit_id,
                                             $user_id
                                             )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `finishing_plan_unit`
                         (
                           plan_id,
                           unit_id,
                           user_id
                         )
                        VALUES
                        ( '$plan_id',
                          '$unit_id',
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
