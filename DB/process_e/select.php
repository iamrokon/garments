<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_process_e extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `process_e` where deletion_status != 1 order by name";
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

        $sql = "SELECT * FROM `process_e` where id = '".$id."' and deletion_status != 1";
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

        $sql = "SELECT `production_efficiency_child`.*,
                (select name from process_e where `production_efficiency_child`.process_id = id) as process_name
                FROM `production_efficiency_child`
                where id = '".$id."' and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_process_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT `process_e`.*
                FROM `process_e`
                where id = '".$id."' and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
