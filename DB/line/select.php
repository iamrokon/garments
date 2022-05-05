<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_line extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `line` where deletion_status != 1 order by id";
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
                line.*
                FROM `line`
                where id = '$id'
                and deletion_status != 1";
        //$sql = "SELECT * FROM `line` where id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    
    public function select_with_id_qr($id)
    {
        $con = $this->connectToDB();
        $sql = "SELECT
                name
                FROM `line`
                where id = '$id'
                and deletion_status != 1";
        //$sql = "SELECT * FROM `line` where id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
