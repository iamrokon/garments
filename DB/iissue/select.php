<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_iissue extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                iissue_scan.*,
                (select po_num from po where id = iissue_scan.po)  as po_number,
                (select cut_num from cut_no where id = iissue_scan.cut_num)  as cut_number,
                (select name from line where id = iissue_scan.line)  as line_name
                FROM `iissue_scan`
                where deletion_status != 1
                order by `iissue_scan`.`id` desc";

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

        $sql = "SELECT * FROM `input_issue` where order_id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_order_and_country($order_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `input_issue` where order_id = '".$order_id."' and country_id = '".$country_id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_input_issue()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                0  as total_issue_quantity,
                (select user_name from user where id = order_details.cutting_user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                and cutting_plan > 0
                and cutting_production = 0
                and order_details.id in (select order_id from input_issue)
                and order_details.id not in (select order_id from swing_output)
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_scan_iissue_history()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `bp_issue`.id as id,
                `bp_issue`.b_tkt_code as t_code,
                `bp_issue`.date as date,
                `bp_issue`.time as time,
                `bp_issue`.quantity as quantity,
                `bp_issue`.serial as serial,
                (select name from process_c where id = bp_issue.part) as part_name,
                (select name from line where id = bp_issue.line) as line_name,
                (select `size`.`size_num` from `size` where id = (select size from cut_pro_size
                 where `cut_pro_size`.`production_id` = `cut_pro_bundle`.`production_id`
                 and `cut_pro_size`.`ticket_no` = `cut_pro_bundle`.`ticket_no`
                )) as size_number,
                (select name from buyer where id = cutting_production.buyer)  as buyer_name,
                (select po_num from po where id = cutting_production.po)  as po_number,
                (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production,
                (select name from color where id = cutting_production.color)  as color,
                (select style_name from style where id = cutting_production.style)  as style_name,
                (select name from shade where id = cutting_production.shade)  as shade,
                -- `cut_pro_bundle`.`quantity`  as quantity,
                cutting_production.lay as lay,
                IFNULL((select sum(quantity) from cut_pro_bundle
                where ticket_no = cut_pro_bundle.ticket_no),0) as total_quantity_bundle,
                (select user_name from user where id = bp_issue.scan_user)  as user_name
                FROM ((`bp_issue` left join `cut_pro_bundle`
                on `cut_pro_bundle`.id = `bp_issue`.b_tkt_code)
                left join `cutting_production`
                on `cut_pro_bundle`.production_id = `cutting_production`.id)
                where bp_issue.deletion_status != 1
                order by `bp_issue`.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }



    public function select_input_issue_quantity($po_number,$style,$country,$size)
    {
        $con = $this->connectToDB();

        $sql = "SELECT count(part) as totalPart,
                IFNULL(IF(count(part) = (select count(id) from cut_process where production_id
                = `cut_pro_bundle`.production_id), `cut_pro_bundle`.quantity, '0'),0) as quantity
                FROM (((`bp_issue`
                left join `cut_pro_bundle` on
                `cut_pro_bundle`.`b_tkt_code`
                = `bp_issue`.`b_tkt_code`)
                left join `cutting_production` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`)
                left join `cut_pro_size` on `cutting_production`.`id` = `cut_pro_size`.`production_id`)
                where `cutting_production`.`po` = '".$po_number."'
                and `cut_pro_bundle`.`country_id` = '".$country."'
                and (select `size`.`size_num` from size where id = `cut_pro_size`.`size`) = '".$size."'";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
}

?>
