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



}

?>
