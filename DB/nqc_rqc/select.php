<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_nqc extends DB_CON
{

        public function select_all()
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    monthly_total_nqc.*
                    FROM `monthly_total_nqc`
                    order by monthly_total_nqc.id desc";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }
        public function select_daily_issue_qty($item_name,$day,$month,$year)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    maintenance_daily_issue.*
                    FROM `maintenance_daily_issue`
                    where `maintenance_daily_issue`.`item_name` = '".$item_name."'
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

        public function select_with_id($id)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    trim_inhouse.*
                    FROM `trim_inhouse`
                    where id = $id
                    and deletion_status != 1";

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
