<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
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
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `maintenance`
                            (
                            `mc_model`,
                            `mc_type`,
                            `rack_no`,
                            `box_no`,
                            `item_name`,
                            `parts_number`,
                            `prev_stock`,
                            `rec_challan_no`,
                            `today_rec_date`,
                            `today_received`,
                            `prev_received`,
                            `tot_received`,
                            `tot_stock_qty`,
                            `unit`,
                            `unit_price`,
                            `day_issue`,
                            `prev_issue`,
                            `tot_issue`,
                            `tot_balance`,
                            `tot_price`,
                            `next_order_qty`,
                            `next_unit_price`,
                            `next_tot_price`,
                            `remarks`,
                            `month`,
                            `year`,
                            `creation_date`,
                            `creation_time`
                            )
                            VALUES
                            (
                            '$mc_model',
                            '$mc_type',
                            '$rack_no',
                            '$box_no',
                            '$item_name',
                            '$parts_number',
                            '$prev_stock',
                            '$rec_challan_no',
                            '$today_rec_date',
                            '$today_received',
                            '$prev_received',
                            '$tot_received',
                            '$tot_stock_qty',
                            '$unit',
                            '$unit_price',
                            '$day_issue',
                            '$prev_issue',
                            '$tot_issue',
                            '$tot_balance',
                            '$tot_price',
                            '$next_order_qty',
                            '$next_unit_price',
                            '$next_tot_price',
                            '$remarks',
                            '$month',
                            '$year',
                            '$date',
                            '$time'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                return $db_connect->insert_id;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }
    public function save_daily_issue_qty(
          $maintenance_id,
          $day,
          $daily_issue_qty,
          $month,
          $year
        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `maintenance_daily_issue`
                            (
                            `maintenance_id`,
                            `day`,
                            `daily_issue_qty`,
                            `month`,
                            `year`
                            )
                            VALUES
                            (
                            '$maintenance_id',
                            '$day',
                            '$daily_issue_qty',
                            '$month',
                            '$year'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                return $db_connect->insert_id;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }

    public function trinhouse_name(
                         $trinhouse_id,
                         $item_name,
                         $challan,
                         $iissuedate,
                         $line_number,
                         $style_name,
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
                         $con,
                         $actual_quantity,
                         $required_quantity,
                         $total_issue_quantity,
                         $balance_quantity,
                         $receive_quantity,
                         $remarks,
                         $type
                         )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `trinhouse_name`
                            (
                            `trinhouse_id`,
                            `challan`,
                            `issue_date`,
                            `item_name`,
                            `line_number`,
                            `style_name`,
                            `po_number`,
                            `pcd`,
                            `tod_from`,
                            `tod_to`,
                            `country`,
                            `supplier`,
                            `item_color`,
                            `size`,
                            `shade`,
                            `ref_no`,
                            `unit_type`,
                            `cons`,
                            `actual_quantity`,
                            `required_quantity`,
                            `total_issue_quantity`,
                            `balance_quantity`,
                            `receive_quantity`,
                            `remarks`,
                            `type`,
                            `creation_date`,
                            `creation_time`
                            )
                            VALUES
                            (
                            '$trinhouse_id',
                            '$challan',
                            '$iissuedate',
                            '$item_name',
                            '$line_number',
                            '$style_name',
                            '$po_number',
                            '$pcd',
                            '$tod_from',
                            '$tod_to',
                            '$country',
                            '$supplier',
                            '$item_color',
                            '$size',
                            '$shade',
                            '$ref_no',
                            '$unit_type',
                            '$con',
                            '$actual_quantity',
                            '$required_quantity',
                            '$total_issue_quantity',
                            '$balance_quantity',
                            '$receive_quantity',
                            '$remarks',
                            '$type',
                            '$date',
                            '$time'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Saved Successfully</span>";
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }

  }


}

?>
