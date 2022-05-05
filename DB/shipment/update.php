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


    public function update_issue_order(
                                       $order_id,
                                       $issue_quantity,
                                       $issue_country,
                                       $issue_size,
                                       $user_id
                                      )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `order_qtn_size` SET "
               . "issue_quantity	= '$issue_quantity',"
               . "issue_date	= '$date',"
               . "issue_time	= '$time',"
               . "issue_user_id	= '$user_id'"
               . " WHERE order_id ='$order_id'"
               . " and size = '$issue_size'"
               . " and country_id = '$issue_country'";

            if (mysqli_query($db_connect, $sql)) {
                $message = '<span style="color: white;background:#f44336;padding:8px;">Info Saved Successfully</span>';
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }



}

?>
