<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_style extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `style` where deletion_status != 1 order by style_name";
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

        $sql = "SELECT * FROM `style` where id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_style_process_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `style_process`.*,
                (select name from `process_c` where id = `style_process`.`pro_id`) as process_name
                FROM `style_process`
                where style_id = '".$id."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_style_shrinkage_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `shrinkage`.*
                FROM `shrinkage`
                where style_id = '".$id."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
