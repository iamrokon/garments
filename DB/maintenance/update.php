<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{

    public function update_maintenance(
                          $id,
                          $mc_model,
                          $mc_type,
                          $rack_no,
                          $box_no,
                          $item_name,
                          $parts_number,
                          $prev_stock,
                          $rec_challan_no,
                          $today_rec_date,
                          $today_received,
                          $prev_received,
                          $tot_received,
                          $tot_stock_qty,
                          $unit,
                          $unit_price,
                          $day_issue,
                          $prev_issue,
                          $tot_issue,
                          $tot_balance,
                          $tot_price,
                          $next_order_qty,
                          $next_unit_price,
                          $next_tot_price,
                          $remarks,
                          $month,
                          $year
                         )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        //$sql = "UPDATE `maintenance` SET `mc_model`='aaa' WHERE id=39";
        $sql = "UPDATE `maintenance` SET "
               . "mc_model	= '$mc_model',"
               . "mc_type	= '$mc_type',"
               . "rack_no	= '$rack_no',"
               . "box_no	= '$box_no',"
               . "item_name	= '$item_name',"
               . "parts_number	= '$parts_number',"
               . "prev_stock	= '$prev_stock',"
               . "rec_challan_no	= '$rec_challan_no',"
               . "today_rec_date	= '$today_rec_date',"
               . "today_received	= '$today_received',"
               . "prev_received	= '$prev_received',"
               . "tot_received	= '$tot_received',"
               . "tot_stock_qty	= '$tot_stock_qty',"
               . "unit	= '$unit',"
               . "unit_price	= '$unit_price',"
               . "day_issue	= '$day_issue',"
               . "prev_issue	= '$prev_issue',"
               . "tot_issue	= '$tot_issue',"
               . "tot_balance	= '$tot_balance',"
               . "tot_price	= '$tot_price',"
               . "next_order_qty	= '$next_order_qty',"
               . "next_unit_price	= '$next_unit_price',"
               . "next_tot_price	= '$next_tot_price',"
               . "remarks	= '$remarks',"
               . "month	= '$month',"
               . "year	= '$year'"
               . " WHERE id='$id'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }
    public function update_daily_issue_qty(
          $maintenance_id,
          $day,
          $daily_issue_qty,
          $month,
          $year
          )
    {
        $db_connect = $this->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "UPDATE `maintenance_daily_issue` SET "
               . "daily_issue_qty	= '$daily_issue_qty',"
               . "month	= '$month',"
               . "year	= '$year'"
               . " WHERE maintenance_id='$maintenance_id'"
               . " and day='$day'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


}

?>
