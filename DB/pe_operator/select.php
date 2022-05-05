<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_pe extends DB_CON
{

    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `operator`.*,
                (select name from `line` where id = line_id) as line_name
                FROM `operator`
                where deletion_status != 1
                order by operator.name";

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
                production_efficiency.*,
                (select user_name from user where id = production_efficiency.user_id)  as user_name
                FROM `production_efficiency`
                where id = '".$id."' and deletion_status != 1";

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

        $sql = "SELECT * FROM `production_efficiency_child` where pe_id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
