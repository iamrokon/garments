<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save($data,$total_c_p_val)
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `cutting_production`
                             (
                               buyer,
                               po,
                               cut_num,
                               color,
                               style,
                               shade,
                               lay,
                               section,
                               total_pcs,
                               bundle_no,
                               creator_id,
                               creation_date,
                               creation_time,
                               qr_code
                             )
                            VALUES
                            ( '$data[buyer]',
                              '$data[po]',
                              '$data[cut_num]',
                              '$data[color]',
                              '$data[style]',
                              '$data[shade]',
                              '$data[lay]',
                              '$data[section_name]',
                              '$data[total_pcs]',
                              '$data[bundle_no_t]',
                              '$data[user_id]',
                              '$date',
                              '$time',
                              '$total_c_p_val'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                return $db_connect->insert_id;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }
  }

  public function production_bundle_save(
                                         $cut_pro_id,
                                         $ticket_no,
                                         $bundle_no,
                                         $from_id,
                                         $to_id,
                                         $quantity,
                                         $pattern,
                                         $shade,
                                         $country,
                                         $user_id
                                         )
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $date = date("d-m-Y");
      $time = date("h:i:s A");

      $b_tkt_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

      $query = mysqli_query($db_connect, "SELECT * FROM `cut_pro_bundle` WHERE b_tkt_code ='" . $b_tkt_code ."'");

      while(mysqli_num_rows($query) > 0){
         $b_tkt_code = substr(md5(uniqid(mt_rand(), true)), 0, 6);
         $query = mysqli_query($db_connect, "SELECT * FROM `cut_pro_bundle` WHERE b_tkt_code ='" . $b_tkt_code ."'");
      }

      $sql = "INSERT INTO `cut_pro_bundle`
                           (
                             production_id,
                             ticket_no,
                             bundle_no,
                             from_id,
                             to_id,
                             quantity,
                             pattern,
                             shade,
                             country_id,
                             b_tkt_code,
                             creation_date,
                             creation_time,
                             creator_id
                           )
                          VALUES
                          ( '$cut_pro_id',
                            '$ticket_no',
                            '$bundle_no',
                            '$from_id',
                            '$to_id',
                            '$quantity',
                            '$pattern',
                            '$shade',
                            '$country',
                            '$b_tkt_code',
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




public function production_size_save(
                                       $cut_pro_number,
                                       $label,
                                       $ticket_no,
                                       $size
                                       )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `cut_pro_size`
                         (
                           production_id,
                           label,
                           ticket_no,
                           size
                         )
                        VALUES
                        (
                          '$cut_pro_number',
                          '$label',
                          '$ticket_no',
                          '$size'
                        )";

      if (mysqli_query($db_connect, $sql)) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
            return $message;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }
}

public function production_process_save(
                                       $cut_pro_number,
                                       $pro_id
                                       )
{
    $db = new DB_CON();
    $db_connect = $db->connectToDB();

    $sql = "INSERT INTO `cut_process`
                         (
                           production_id,
                           pro_id
                         )
                        VALUES
                        ( '$cut_pro_number',
                          '$pro_id'
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
