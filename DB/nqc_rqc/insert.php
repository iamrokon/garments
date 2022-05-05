<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
          $date,
          $style,
          $po,
          $ttl_tod,
          $season,
          $order_qty,
          $ship_qty,
          $country,
          $inspection_qty,
          $skip,
          $initial_pass,
          $initial_fail,
          $inline_pass,
          $inline_fail,
          $final_pass,
          $final_fail,
          $critical_fault,
          $major_fault,
          $defect_qty,
          $defect_detail,
          $remarks,
          $ins_by
        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        // $date = date("d-m-Y");
        // $time = date("h:i:s A");

        $sql = "INSERT INTO `nqc_rqc`
                            (
                            `date`,
                            `style`,
                            `po`,
                            `ttl_tod`,
                            `season`,
                            `order_qty`,
                            `ship_qty`,
                            `country`,
                            `inspection_qty`,
                            `skip`,
                            `initial_pass`,
                            `initial_fail`,
                            `inline_pass`,
                            `inline_fail`,
                            `final_pass`,
                            `final_fail`,
                            `critical_fault`,
                            `major_fault`,
                            `defect_qty`,
                            `defect_detail`,
                            `remarks`,
                            `ins_by`
                            )
                            VALUES
                            (
                            '$date',
                            '$style',
                            '$po',
                            '$ttl_tod',
                            '$season',
                            '$order_qty',
                            '$ship_qty',
                            '$country',
                            '$inspection_qty',
                            '$skip',
                            '$initial_pass',
                            '$initial_fail',
                            '$inline_pass',
                            '$inline_fail',
                            '$final_pass',
                            '$final_fail',
                            '$critical_fault',
                            '$major_fault',
                            '$defect_qty',
                            '$defect_detail',
                            '$remarks',
                            '$ins_by'
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
    public function save_total_qty(
          $month,
          $year,
          $t_initial_pass,
          $t_initial_fail,
          $t_inline_pass,
          $t_inline_fail,
          $t_final_pass,
          $t_final_fail,
          $t_skip
        )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `monthly_total_nqc`
                            (
                              `month`,
                              `year`,
                              `t_initial_pass`,
                              `t_initial_fail`,
                              `t_inline_pass`,
                              `t_inline_fail`,
                              `t_final_pass`,
                              `t_final_fail`,
                              `t_skip`
                            )
                            VALUES
                            (
                              '$month',
                              '$year',
                              '$t_initial_pass',
                              '$t_initial_fail',
                              '$t_inline_pass',
                              '$t_inline_fail',
                              '$t_final_pass',
                              '$t_final_fail',
                              '$t_skip'
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
