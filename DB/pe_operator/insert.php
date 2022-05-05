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

        $sql = "INSERT INTO `production_efficiency`
                             (
                               style,
                               line,
                               e_date,
                               user_id,
                               creation_date,
                               creation_time
                             )
                            VALUES
                            (
                              '$data[style]',
                              '$data[line]',
                              '$data[edate]',
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

  public function pe_child_save(
                                $pe_id,
                                $opt_id,
                                $opt_name,
                                $line,
                                $process_id,
                                $smv,
                                $target,
                                $one,
                                $two,
                                $three,
                                $four,
                                $five,
                                $six,
                                $seven,
                                $eight,
                                $nine,
                                $ten
                                )
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $sql = "INSERT INTO `production_efficiency_child`
                           (
                             pe_id,
                             opt_id,
                             opt_name,
                             line_id,
                             process_id,
                             smv,
                             target,
                             one,
                             two,
                             three,
                             four,
                             five,
                             six,
                             seven,
                             eight,
                             nine,
                             ten
                           )
                          VALUES
                          (
                            '$pe_id',
                            '$opt_id',
                            '$opt_name',
                            '$line',
                            '$process_id',
                            '$smv',
                            '$target',
                            '$one',
                            '$two',
                            '$three',
                            '$four',
                            '$five',
                            '$six',
                            '$seven',
                            '$eight',
                            '$nine',
                            '$ten'
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
