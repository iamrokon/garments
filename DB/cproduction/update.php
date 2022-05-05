<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{
    public function updateData($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `size` SET "
               . "size_num	= '$data[size_num]',"
               . "details = '$data[details]'"
               . " WHERE id='$data[id]'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


    public function update_cutting_pro_bundle_with_id(
                                                      $id,
                                                      $from_id,
                                                      $to_id,
                                                      $quantity,
                                                      $pattern,
                                                      $shade,
                                                      $country
                                                     )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `cut_pro_bundle` SET "
               . "from_id	= '$from_id',"
               . "to_id	= '$to_id',"
               . "quantity	= '$quantity',"
               . "pattern	= '$pattern',"
               . "shade	= '$shade',"
               . "country_id	= '$country'"
               . " WHERE id='$id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


    public function update_cutting_pro_info(
                                                      $id,
                                                      $buyer_select,
                                                      $po_select,
                                                      $cut_num_select,
                                                      $color_select,
                                                      $style_select,
                                                      $shade_select,
                                                      $lay_number,
                                                      $section_select,
                                                      $pcs
                                                     )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `cutting_production` SET "
               . "buyer	= '$buyer_select',"
               . "po	= '$po_select',"
               . "cut_num	= '$cut_num_select',"
               . "color	= '$color_select',"
               . "style	= '$style_select',"
               . "shade	= '$shade_select',"
               . "lay	= '$lay_number',"
               . "section	= '$section_select',"
               . "total_pcs	= '$pcs'"
               . " WHERE id='$id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }

    public function production_size_update(
                                    $cut_pro_number,
                                    $label,
                                    $ticket_no,
                                    $size
                                    )
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `cut_pro_size` SET "
               . "label	= '$label',"
               . "size	= '$size'"
               . " WHERE production_id='$cut_pro_number'"
               . " and ticket_no='$ticket_no'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }

    public function production_process_update(
                                      $cut_pro_number,
                                      $pro_id
                                    )
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `cut_process` SET "
               . "deletion_status	= '1'"
               . " WHERE production_id='$cut_pro_number'"
               . " and pro_id='$pro_id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }




    // public function production_size_update(
    //                                        $cut_pro_number,
    //                                        $ticket_no,
    //                                        $size
    //                                        )
    // {
    //     $db = new DB_CON();
    //     $db_connect = $db->connectToDB();
    //
    //     $sql = "INSERT INTO `cut_pro_size`
    //                          (
    //                            production_id,
    //                            ticket_no,
    //                            size
    //                          )
    //                         VALUES
    //                         (
    //                           '$cut_pro_number',
    //                           '$ticket_no',
    //                           '$size'
    //                         )";
    //
    //       if (mysqli_query($db_connect, $sql)) {
    //             $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
    //             return $message;
    //       } else {
    //         die('Query problem' . mysqli_error($db_connect));
    //     }
    // }



}

?>
