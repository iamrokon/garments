<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_cut_number extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `cut_no` where deletion_status != 1 order by cut_num";
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

        $sql = "SELECT * FROM `cut_no` where id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
