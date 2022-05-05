<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
      $buyer,
      $style_id,
      $projected_qty,
      $po_id,
      $color,
      $dely_date,
      $order_qty,
      $cutting_plan_qty,
      $cutting_plan,
      $today_cut_pro_qty,
      $total_cut_pro_qty,
      $cutting_balance,
      $cutting,
      $cutting_status,
      $today_iissue,
      $total_iissue,
      $input_balance,
      $input_status,
      $today_soutput,
      $total_soutput,
      $sewing_rejection_qty,
      $wip_in_line,
      $today_wsend,
      $total_wsend,
      $wsend_balance,
      $w_rejection,
      $wip_at_wash,
      $today_fin_in,
      $total_fin_in,
      $today_fin_out,
      $total_fin_out,
      $fin_out_perc,
      $fin_rejection_qty,
      $wip_at_finish,
      $tot_fin_rejection_qty,
      $today_ship,
      $total_ship,
      $bal_to_ship,
      $order_to_ship,
      $cut_to_ship,
      $remarks
        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `planning`
                            (
                            `buyer`,
                            `style_id`,
                            `projected_qty`,
                            `po_id`,
                            `color`,
                            `dely_date`,
                            `order_qty`,
                            `cutting_plan_qty`,
                            `cutting_plan`,
                            `today_cut_pro_qty`,
                            `total_cut_pro_qty`,
                            `cutting_balance`,
                            `cutting`,
                            `cutting_status`,
                            `today_iissue`,
                            `total_iissue`,
                            `input_balance`,
                            `input_status`,
                            `today_soutput`,
                            `total_soutput`,
                            `sewing_rejection_qty`,
                            `wip_in_line`,
                            `today_wsend`,
                            `total_wsend`,
                            `wsend_balance`,
                            `w_rejection`,
                            `wip_at_wash`,
                            `today_fin_in`,
                            `total_fin_in`,
                            `today_fin_out`,
                            `total_fin_out`,
                            `fin_out_perc`,
                            `fin_rejection_qty`,
                            `wip_at_finish`,
                            `tot_fin_rejection_qty`,
                            `today_ship`,
                            `total_ship`,
                            `bal_to_ship`,
                            `order_to_ship`,
                            `cut_to_ship`,
                            `remarks`
                            )
                            VALUES
                            (
                            '$buyer',
                            '$style_id',
                            '$projected_qty',
                            '$po_id',
                            '$color',
                            '$dely_date',
                            '$order_qty',
                            '$cutting_plan_qty',
                            '$cutting_plan',
                            '$today_cut_pro_qty',
                            '$total_cut_pro_qty',
                            '$cutting_balance',
                            '$cutting',
                            '$cutting_status',
                            '$today_iissue',
                            '$total_iissue',
                            '$input_balance',
                            '$input_status',
                            '$today_soutput',
                            '$total_soutput',
                            '$sewing_rejection_qty',
                            '$wip_in_line',
                            '$today_wsend',
                            '$total_wsend',
                            '$wsend_balance',
                            '$w_rejection',
                            '$wip_at_wash',
                            '$today_fin_in',
                            '$total_fin_in',
                            '$today_fin_out',
                            '$total_fin_out',
                            '$fin_out_perc',
                            '$fin_rejection_qty',
                            '$wip_at_finish',
                            '$tot_fin_rejection_qty',
                            '$today_ship',
                            '$total_ship',
                            '$bal_to_ship',
                            '$order_to_ship',
                            '$cut_to_ship',
                            '$remarks'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                return $db_connect->insert_id;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }
    public function save_daily_issue_qty(
          $item_name,
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
                            `item_name`,
                            `day`,
                            `daily_issue_qty`,
                            `month`,
                            `year`
                            )
                            VALUES
                            (
                            '$item_name',
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
