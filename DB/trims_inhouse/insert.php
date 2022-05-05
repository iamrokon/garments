<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save(
                         $type
                         )
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        $sql = "INSERT INTO `trim_inhouse`
                            (
                            `type`,
                            `creation_date`,
                            `creation_time`
                            )
                            VALUES
                            (
                            '$type',
                            '$date',
                            '$time'
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
