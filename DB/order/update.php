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


    public function update_size_quantity_with_id($id,$size_id,$quantity,$country,$user_id)
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql_size = "SELECT size_num from size where id='$size_id'";
        $result_size = mysqli_query($db_connect,$sql_size);
        $data_size = mysqli_fetch_assoc($result_size);
        $size = $data_size['size_num'];

        $sql = "UPDATE `order_qtn_size` SET "
               . "size	= '$size',"
               . "size_id	= '$size_id',"
               . "quantity	= '$quantity',"
               . "country_id	= '$country',"
               . "update_date	= '$date',"
               . "update_time	= '$time',"
               . "update_user_id	= '$user_id'"
               . "WHERE id='$id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


    public function update_order_parent(
                                        $po_select,
                                        $style_select,
                                        $order_details_id,
                                        $color_id,
                                        $user_id
                                        )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `order_details` SET "
               . "po	= '$po_select',"
               . "style	= '$style_select',"
               . "color	= '$color_id',"
               . "update_date	= '$date',"
               . "update_time	= '$time',"
               . "update_user_id	= '$user_id'"
               . "WHERE id='$order_details_id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }

    public function update_cutting_plan($order_id,$cutting_plan,$user_id)
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `order_details` SET "
               . "cutting_plan	= '$cutting_plan',"
               . "cutting_date	= '$date',"
               . "cutting_time	= '$time',"
               . "cutting_user_id	= '$user_id'"
               . " WHERE id='$order_id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


    //country shipment and tod update
    public function order_country_update(
                                         $order_id,
                                         $country_id,
                                         $old_country_id,
                                         $color_id,
                                         $tod,
                                         $shipment,
                                         $user_id
                                         )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `order_country` SET "
               . "color_id	= '$color_id',"
               . "tod	= '$tod',"
               . "shipment	= '$shipment',"
               . "country_id	= '$country_id',"
               . "update_user_id	= '$user_id' "
               . "WHERE order_id = '$order_id' "
               . " AND country_id = '$old_country_id' ";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


}

?>
