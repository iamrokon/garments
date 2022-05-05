<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_trims_inhouse extends DB_CON
{
        public function select_all()
        {
            $con = $this->connectToDB();

            $sql = "SELECT
                    trim_inhouse.id,
                    (select style_name from style where id = (select style_name from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as style_name,
                    (select po_num from po where id = (select po_number from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as po_number,
                    (select sum(required_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_requirement,
                    (select sum(receive_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_received,
                    (select sum(total_issue_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_issue,
                    (select sum(balance_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_balance
                    FROM `trim_inhouse`
                    where deletion_status != 1
                    order by trim_inhouse.id desc";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_all_dynamically($start,$length)
        {
            $con = $this->connectToDB();
            if($length!=-1){
            $sql = "SELECT
                    trim_inhouse.id,
                    (select style_name from style where id = (select style_name from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as style_name,
                    (select po_num from po where id = (select po_number from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as po_number,
                    (select sum(required_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_requirement,
                    (select sum(receive_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_received,
                    (select sum(total_issue_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_issue,
                    (select sum(balance_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_balance
                    FROM `trim_inhouse`
                    where deletion_status != 1
                    order by trim_inhouse.id desc
                    LIMIT ".
                    $start."  ,".$length." ";
            }else {
              $sql = "SELECT
                      trim_inhouse.id,
                      (select style_name from style where id = (select style_name from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as style_name,
                      (select po_num from po where id = (select po_number from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as po_number,
                      (select sum(required_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_requirement,
                      (select sum(receive_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_received,
                      (select sum(total_issue_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_issue,
                      (select sum(balance_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_balance
                      FROM `trim_inhouse`
                      where deletion_status != 1
                      order by trim_inhouse.id desc";
            }

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_all_dynamically2($search)
        {
            $con = $this->connectToDB();
            // $sql = "SELECT
            //         trim_inhouse.id,
            //         (select style_name from style where id = (select style_name from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as style_namess,
            //         (select po_num from po where id = (select po_number from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as po_numberss,
            //         (select sum(required_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_requirement,
            //         (select sum(receive_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_received,
            //         (select sum(total_issue_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_issue,
            //         (select sum(balance_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_balance
            //         FROM `trim_inhouse`
            //         where deletion_status != 1
            //         and (
            //         style_namess Like '".$search."%'
            //         OR po_numberss Like '".$search."%'
            //         )
            //         order by trim_inhouse.id desc";


            $sql="select id,style_name,
            po_number,total_requirement,total_received,total_issue,total_balance,deletion_status
            from (
            SELECT   id,
            (select style_name from style where id = (select style_name from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as style_name,
            (select po_num from po where id = (select po_number from trinhouse_name where trinhouse_id = trim_inhouse.id LIMIT 1)) as po_number,
            (select sum(required_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_requirement,
            (select sum(receive_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_received,
            (select sum(total_issue_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_issue,
            (select sum(balance_quantity) from trinhouse_name where trinhouse_id = trim_inhouse.id)  as total_balance,
            deletion_status
            from trim_inhouse
            )a
            where deletion_status != 1
            and (
            style_name Like '".$search."%'
            OR po_number Like '".$search."%'
            )
            order by id desc";
            // $sql = "SELECT
            //         cutting_production_view.*
            //         FROM `cutting_production_view`
            //         where 1=1
            //         and (
            //         po_number Like '".$search."%'
            //         OR cut_number Like '".$search."%'
            //         )
            //         order by `cutting_production_view`.`id` desc";

            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }

        public function select_trinhouse1()
        {
            $con = $this->connectToDB();
            $sql = "SELECT COUNT(*) as rowNumber
                    FROM trim_inhouse
                    where deletion_status != 1
                    order by `trim_inhouse`.`id` desc";


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
                    item.name as itemName,
                    -- (select name from item where id = trinhouse_name.item_name)  as itemName,
                    (select style_name from style where id = trinhouse_name.style_name)  as styleName,
                    (select po_num from po where id = trinhouse_name.po_number)  as poNumber,
                    (select name from supplier where id = trinhouse_name.supplier)  as supplierName,
                    (select name from line where id = trinhouse_name.line_number)  as lineNumber,
                    (select size_num from size where id = trinhouse_name.size)  as sizeNumber,
                    (select name from shade where id = trinhouse_name.shade)  as shadeName
                    FROM `trinhouse_name`
                    left join item on trinhouse_name.item_name = item.id
                    where trinhouse_name.trinhouse_id = '".$id."'
                    and trinhouse_name.deletion_status != 1
                    order by item.name asc";


            $query_result = mysqli_query($con, $sql);
            if ($query_result) {
                return $query_result;
            } else {
                die('Query problem' . mysqli_error($con));
            }
        }


}

?>
