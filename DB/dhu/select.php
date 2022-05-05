<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_dhu extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `rejection` where deletion_status != 1 order by id";
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

        $sql = "SELECT * FROM `rejection` where id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_all_sewing_dhu_report()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                sewing_dhu_report.*,
                (select style_name from style where id = sewing_dhu_report.style_id) as style_name FROM
                `sewing_dhu_report`
                where deletion_status != 1

                order by sewing_dhu_report.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_sewing_dhu_rejection_by_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT sewing_dhu_report_details.*,
                (select name from rejection where id = sewing_dhu_report_details.rejection_id)  as rejection
                FROM `sewing_dhu_report_details` where `sewing_dhu_report_details`.`sewing_dhu_report_id` = '".$id."' ";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_sewing_dhu_report_by_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT sewing_dhu_report.*,
                (select style_name from style where id = sewing_dhu_report.style_id) as style_name,
                sewing_dhu_report.creation_date as date
                FROM `sewing_dhu_report` where `sewing_dhu_report`.`id` = '".$id."' ";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_sewing_dhu_report_details($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                sewing_dhu_report_details.*,
                sewing_dhu_report.creation_date as date,
                (select style_name from style where id = sewing_dhu_report.style_id) as style_name,
                (select name from rejection where id = sewing_dhu_report_details.rejection_id) as rejection FROM
                (`sewing_dhu_report_details` left join `sewing_dhu_report`
                on `sewing_dhu_report_details`.`sewing_dhu_report_id` = `sewing_dhu_report`.`id` )
                where `sewing_dhu_report_details`.`sewing_dhu_report_id` = '".$id."'
                order by sewing_dhu_report_details.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
