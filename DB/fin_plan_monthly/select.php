<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_monthly_finishing_plan extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                finishing_plan_monthly.*,
                (select po_num from po where id = finishing_plan_monthly.po_id)  as po_number,
                (select style_name from style where id = finishing_plan_monthly.style_id)  as style_name,
                (select name from unit where id = finishing_plan_monthly.unit_id)  as unit_name,
                (select user_name from user where id = finishing_plan_monthly.user_id)  as user_name
                FROM `finishing_plan_monthly`
                where finishing_plan_monthly.deletion_status != 1
                order by finishing_plan_monthly.id desc";
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
                finishing_plan_monthly.*,
                (select po_num from po where id = finishing_plan_monthly.po_id)  as po_number,
                (select style_name from style where id = finishing_plan_monthly.style_id)  as style_name,
                (select name from unit where id = finishing_plan_monthly.unit_id)  as unit_name,
                (select user_name from user where id = finishing_plan_monthly.user_id)  as user_name
                FROM `finishing_plan_monthly`
                where finishing_plan_monthly.deletion_status != 1
                and finishing_plan_monthly.id = '".$id."'";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_week_list_this_month()
    {
        $con = $this->connectToDB();

        $sql = "SELECT DISTINCT
                finishing_plan_monthly.week as week
                FROM `finishing_plan_monthly`
                where finishing_plan_monthly.deletion_status != 1
                and MONTH(finishing_plan_monthly.plan_date) = MONTH(CURDATE())
                and YEAR(finishing_plan_monthly.plan_date) = YEAR(CURDATE())
                order by finishing_plan_monthly.plan_date";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_order_tod_week_list_this_month()
    {
        $con = $this->connectToDB();

        $sql = "SELECT DISTINCT
                week(order_details.tod) as week
                FROM `order_details`
                where order_details.deletion_status != 1
                and MONTH(order_details.tod) = MONTH(CURDATE())
                and YEAR(order_details.tod) = YEAR(CURDATE())
                order by order_details.tod desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_plan_date_with_week_number($week_number)
    {
        $con = $this->connectToDB();

        $sql = "SELECT DISTINCT
                finishing_plan_monthly.plan_date as plan_date
                FROM `finishing_plan_monthly`
                where finishing_plan_monthly.deletion_status != 1
                and week = '".$week_number."'
                order by finishing_plan_monthly.plan_date";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_order_plan_date_with_week_number($week_number)
    {
        $con = $this->connectToDB();

        $sql = "SELECT DISTINCT
                order_details.tod as plan_date
                FROM `order_details`
                where order_details.deletion_status != 1
                and week(order_details.tod) = '".$week_number."'
                order by order_details.tod desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_finishing_plan_with_unit_id($unit_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                finishing_plan_monthly.*,
                (select po_num from po where id = finishing_plan_monthly.po_id)  as po_number,
                (select style_name from style where id = finishing_plan_monthly.style_id)  as style_name,
                (select name from unit where id = finishing_plan_monthly.unit_id)  as unit_name,
                (select user_name from user where id = finishing_plan_monthly.user_id)  as user_name
                FROM `finishing_plan_monthly`
                where finishing_plan_monthly.deletion_status != 1
                and unit_id = '".$unit_id."'
                order by finishing_plan_monthly.plan_date";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_order_qtn_child_this_month_tod()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `order_qtn_size`.*,
                `order_details`.tod as TOD,
                `order_details`.po as order_po_id,
                `order_details`.style as order_style_id,
                `order_details`.creation_time,
                `order_details`.creation_date,
                (select style_name from style where id = `order_details`.style) as style_name,
                (select po_num from po where id = `order_details`.po) as po_number,
                (select full_name from country where id = `order_qtn_size`.country_id) as country_name,
                (select sum(quantity) from order_qtn_size where order_id = `order_details`.id) as shipment_quantity,
                WEEK(TOD) as week_number,
                (select user_name from user where id = `order_qtn_size`.user_id) as user_name
                FROM `order_qtn_size` left join `order_details`
                on `order_qtn_size`.order_id = `order_details`.id
                where `order_qtn_size`.deletion_status != 1
                and MONTH(`order_details`.tod) = MONTH(CURDATE())
                and YEAR(`order_details`.tod) = YEAR(CURDATE())
                order by `order_details`.tod desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_finishing_plan_quantity_with_date_country_week_style_po(
                                                                                    $date,
                                                                                    $country,
                                                                                    $week,
                                                                                    $style,
                                                                                    $po
                                                                                   )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `order_qtn_size`.*,
                `order_details`.tod as TOD,
                `order_details`.creation_time,
                `order_details`.creation_date,
                (select style_name from style where id = `order_details`.style) as style_name,
                (select po_num from po where id = `order_details`.po) as po_number,
                (select full_name from country where id = `order_qtn_size`.country_id) as country_name,
                (select sum(quantity) from order_qtn_size where order_id = `order_details`.id) as shipment_quantity,
                WEEK(TOD) as week_number,
                (select user_name from user where id = `order_qtn_size`.user_id) as user_name
                FROM `order_qtn_size` left join `order_details`
                on `order_qtn_size`.order_id = `order_details`.id
                where `order_qtn_size`.deletion_status != 1
                and MONTH(TOD) = MONTH(CURDATE())
                and YEAR(TOD) = YEAR(CURDATE())
                and week(TOD) = '".$week."'
                and TOD = '".$date."'
                and order_details.style = '".$style."'
                and order_details.po = '".$po."'
                order by TOD desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_finishing_plan_quantity_with_date_unit_week_style_po(
                                                                                    $date,
                                                                                    $unit,
                                                                                    $week,
                                                                                    $style,
                                                                                    $po
                                                                                   )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                finishing_plan_monthly.quantity
                FROM `finishing_plan_monthly`
                where finishing_plan_monthly.deletion_status != 1
                and plan_date = '".$date."'
                and unit_id = '".$unit."'
                and week = '".$week."'
                and style_id = '".$style."'
                and po_id = '".$po."'
                order by finishing_plan_monthly.plan_date";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
