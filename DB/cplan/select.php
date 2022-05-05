<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_cplan extends DB_CON
{
    public function select_child_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `order_qtn_size` where order_id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_cutting_plan()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select full_name from country where id = order_details.country)  as country_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.cutting_user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                and cutting_plan > 0
                and cutting_production = 0
                and order_details.id not in (select order_id from input_issue)
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_cutting_plan_with_po_number($po_number)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select full_name from country where id = order_details.country)  as country_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.cutting_user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                and cutting_plan > 0
                and cutting_production = 0
                and order_details.po = $po_number
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }



    public function select_size_with_po_number($po_number)
    {
        $con = $this->connectToDB();

        $sql =  "SELECT DISTINCT
                `order_qtn_size`.`size` as size
                FROM `order_qtn_size`
                left join `order_details` on `order_details`.`id` = `order_qtn_size`.`order_id`
                where `order_details`.`deletion_status` != 1
                and `order_details`.`cutting_plan` > 0
                and `order_details`.`cutting_production` = 0
                and `order_details`.`po` = $po_number
                order by `order_qtn_size`.`size`";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }



    public function select_quantity_with_po_number_cplan($po_number)
    {
        $con = $this->connectToDB();

        $sql =  "SELECT DISTINCT
                `order_qtn_size`.`size` as size,
                `order_qtn_size`.`quantity` as quantity
                FROM `order_qtn_size`
                left join `order_details` on `order_details`.`id` = `order_qtn_size`.`order_id`
                where `order_details`.`deletion_status` != 1
                and `order_details`.`cutting_plan` > 0
                and `order_details`.`cutting_production` = 0
                and `order_details`.`po` = $po_number
                order by `order_qtn_size`.`size`";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
