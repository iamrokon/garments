<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_maintenance extends DB_CON
{

        public function select_all($month,$year)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    maintenance.*
                    -- (select name from item_maintenance where id = maintenance.item_name)  as item
                    FROM `maintenance`
                    where `maintenance`.`month` = '".$month."'
                    and `maintenance`.`year` = '".$year."'
                    and deletion_status != 1
                    order by maintenance.id desc";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }
        public function select_daily_issue_qty($maintenance_id,$day,$month,$year)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    maintenance_daily_issue.*
                    FROM `maintenance_daily_issue`
                    where `maintenance_daily_issue`.`maintenance_id` = '".$maintenance_id."'
                    and `maintenance_daily_issue`.`day` = '".$day."'
                    and `maintenance_daily_issue`.`month` = '".$month."'
                    and `maintenance_daily_issue`.`year` = '".$year."'
                    order by maintenance_daily_issue.id desc LIMIT 1";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_daily_issue_qty_by_id($maintenance_id,$day)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    maintenance_daily_issue.*
                    FROM `maintenance_daily_issue`
                    where `maintenance_daily_issue`.`maintenance_id` = '".$maintenance_id."'
                    and `maintenance_daily_issue`.`day` = '".$day."'
                    order by maintenance_daily_issue.id desc LIMIT 1";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_with_id($id)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    maintenance.*
                    FROM `maintenance`
                    where id = $id";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_all_trinhouse_name($id)
        {
            $con = $this->connectToDB();
            // $sql = "SELECT sewing_dhu_report_details.*,
            //         (select name from rejection where id = sewing_dhu_report_details.rejection_id)  as rejection
            //         FROM `sewing_dhu_report_details` where `sewing_dhu_report_details`.`sewing_dhu_report_id` = '".$id."' ";
            $sql = "SELECT
                    trinhouse_name.*,
                    (select name from item where id = trinhouse_name.item_name)  as itemName,
                    (select DISTINCT style_name from style where id = trinhouse_name.style_name)  as styleName,
                    (select po_num from po where id = trinhouse_name.po_number)  as poNumber,
                    (select name from supplier where id = trinhouse_name.supplier)  as supplierName,
                    (select name from color where id = trinhouse_name.item_color)  as colorName,
                    (select name from line where id = trinhouse_name.line_number)  as lineNumber,
                    (select size_num from size where id = trinhouse_name.size)  as sizeNumber,
                    (select name from shade where id = trinhouse_name.shade)  as shadeName
                    FROM `trinhouse_name`
                    where `trinhouse_name`.`trinhouse_id` = '".$id."' ";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_child_with_id($id)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    trinhouse_name.*,
                    (select name from item where id = trinhouse_name.item_name)  as itemName,
                    (select style_name from style where id = trinhouse_name.style_name)  as styleName,
                    (select po_num from po where id = trinhouse_name.po_number)  as poNumber,
                    (select name from supplier where id = trinhouse_name.supplier)  as supplierName,
                    (select name from line where id = trinhouse_name.line_number)  as lineNumber,
                    (select size_num from size where id = trinhouse_name.size)  as sizeNumber,
                    (select name from shade where id = trinhouse_name.shade)  as shadeName
                    FROM `trinhouse_name`
                    where trinhouse_id = '".$id."'
                    and deletion_status != 1
                    order by trinhouse_name.id asc";


            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }


}

?>
