<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_item_maintenance extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `item_maintenance` where deletion_status != 1 order by id asc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_last_item()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `item_maintenance` where deletion_status != 1 order by id desc LIMIT 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
