<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_finishing_plan extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT distinct
                finshing_plan.id,
                finshing_plan.*,
                (select sum(hour_value) from finishing_plan_hour where plan_id = finshing_plan.id)  as total_hour_value,
                (select user_name from user where id = finshing_plan.user_id)  as user_name
                FROM `finshing_plan` left join `finishing_plan_hour` on finshing_plan.id = finishing_plan_hour.id
                where finishing_plan_hour.deletion_status != 1
                order by finshing_plan.id desc";
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

        $sql = "SELECT distinct
                finshing_plan.id,
                finshing_plan.*,
                (select name from unit where id = finishing_plan_hour.unit_id)  as unit_number,
                (select name from hour where id = finishing_plan_hour.hour_id)  as hour_number,
                (select sum(hour_value) from finishing_plan_hour where plan_id = finshing_plan.id)  as total_hour_value,
                (select user_name from user where id = finshing_plan.user_id)  as user_name
                FROM `finshing_plan` left join `finishing_plan_hour` on finshing_plan.id = finishing_plan_hour.id
                where finishing_plan_hour.deletion_status != 1
                and finshing_plan.id = '".$id."'";
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

        $sql = "SELECT finishing_plan_hour.*,
                (select name from hour where id = finishing_plan_hour.hour_id)  as hour_name,
                (select name from process where id = finishing_plan_hour.process_id)  as process_name
                FROM `finishing_plan_hour`
                where plan_id = '".$id."'
                and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_finishing_plan_hour_with_plan_id_and_unit_id($plan_id,$unit_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT finishing_plan_hour.*,
                (select name from hour where id = finishing_plan_hour.hour_id)  as hour_name,
                (select name from process where id = finishing_plan_hour.process_id)  as process_name
                FROM `finishing_plan_hour`
                where plan_id = '".$plan_id."'
                and unit_id = '".$unit_id."'
                and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_finishing_plan_unit_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT finishing_plan_unit.*,
                (select name from unit where id = finishing_plan_unit.unit_id)  as unit_name
                FROM `finishing_plan_unit`
                where plan_id = '".$id."' and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
