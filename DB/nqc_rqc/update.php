<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{
    public function update_bundle_status_order(
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

    public function update_trinhouse_by_id(
                                                      $id,
                                                      $type
                                                     )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `trim_inhouse` SET "
               . "type	= '$type'"
               . " WHERE id='$id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }
    public function update_trinhouse_info_by_id(
                                                      $id,
                                                      $trinhouse_id,
                                                      $challan,
                                                      $issue_date,
                                                      $item_name,
                                                      $line_number,
                                                      $style_select,
                                                      $po_number,
                                                      $pcd,
                                                      $tod_from,
                                                      $tod_to,
                                                      $country,
                                                      $supplier,
                                                      $item_color,
                                                      $size,
                                                      $shade,
                                                      $ref_no,
                                                      $unit_type,
                                                      $cons,
                                                      $actual_quantity,
                                                      $required_quantity,
                                                      $d_iissue_quantity,
                                                      $total_issue_quantity,
                                                      $balance_quantity,
                                                      $d_receive_quantity,
                                                      $receive_quantity,
                                                      $remarks
                                                     )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `trinhouse_name` SET "
               . "trinhouse_id	= '$trinhouse_id',"
               . "challan	= '$challan',"
               . "issue_date	= '$issue_date',"
               . "item_name	= '$item_name',"
               . "line_number	= '$line_number',"
               . "style_name	= '$style_select',"
               . "po_number	= '$po_number',"
               . "pcd	= '$pcd',"
               . "tod_from	= '$tod_from',"
               . "tod_to	= '$tod_to',"
               . "country	= '$country',"
               . "supplier	= '$supplier',"
               . "item_color	= '$item_color',"
               . "size	= '$size',"
               . "shade	= '$shade',"
               . "ref_no	= '$ref_no',"
               . "unit_type	= '$unit_type',"
               . "cons	= '$cons',"
               . "actual_quantity	= '$actual_quantity',"
               . "required_quantity	= '$required_quantity',"
               . "d_issue_quantity	= '$d_iissue_quantity',"
               . "total_issue_quantity	= '$total_issue_quantity',"
               . "balance_quantity	= '$balance_quantity',"
               . "d_receive_quantity	= '$d_receive_quantity',"
               . "receive_quantity	= '$receive_quantity',"
               . "receive_quantity	= '$receive_quantity',"
               . "remarks	= '$remarks'"
               . " WHERE id='$id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


}

?>
