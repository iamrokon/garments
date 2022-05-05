<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_planning extends DB_CON
{

        public function select_all()
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    planning.*,
                    (select name from buyer where id = planning.buyer)  as buyer_name,
                    (select style_name from style where id = planning.style_id)  as style_name,
                    (select po_num from po where id = planning.po_id)  as po_number,
                    (select name from color where id = planning.color)  as color_name
                    FROM `planning`
                    order by planning.id desc";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }
        public function select_po_by_style($style_id)
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    order_details.*,
                    (select po_num from po where id = order_details.po)  as po_number,
                    (select style_name from style where id = order_details.style)  as style_name,
                    (select name from buyer where id = order_details.buyer)  as buyer_name,
                    (select name from color where id = order_details.color)  as color_name,
                    (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                    (select user_name from user where id = order_details.user_id)  as user_name
                    FROM `order_details`
                    where deletion_status != 1
                    AND `order_details`.`style` = '".$style_id."' ";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }



        public function select_cut_pro_by_style_po($style,$po)
        {
        	$con = $this->connectToDB();
        	$sql = "SELECT
        			cutting_production.*,
        			-- (select name from buyer where id = cutting_production.buyer)  as buyer_name,
        			-- (select po_num from po where id = cutting_production.po)  as po_number,
        			-- (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
        			(select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production
        			-- (select name from color where id = cutting_production.color)  as color_name,
        			-- (select style_name from style where id = cutting_production.style)  as style_name,
        			-- (select name from shade where id = cutting_production.shade)  as shade_name,
        			-- (select user_name from user where id = cutting_production.creator_id)  as user_name
        			FROM `cutting_production`
        			where deletion_status != 1
              and style = '".$style."'
              and po = '".$po."'
        			order by `cutting_production`.`id` desc";

        	$query_result = mysqli_query($con, $sql);
        	if ($query_result) {
        		return $query_result;
        	} else {
        		die('Query problem' . mysqli_error($con));
        	}
        }

        public function select_today_cut_pro_by_style_po($style,$po)
        {
        	$con = $this->connectToDB();
          $curr_date = date("d-m-Y");
        	$sql = "SELECT
        			cutting_production.*,
        			(select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production
        			FROM `cutting_production`
        			where deletion_status != 1
              and style = '".$style."'
              and po = '".$po."'
              and creation_date = '".$curr_date."'
        			order by `cutting_production`.`id` desc";

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
