<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_size extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `size` where deletion_status != 1 order by CAST(inseam AS int), CAST(size_num AS int)";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_size_with_p()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `size`
                where deletion_status != 1
                and `size_num` LIKE '%P'
                order by CAST(inseam AS int), CAST(size_num AS int)";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_size_without_p()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `size`
                where deletion_status != 1
                and `size_num` NOT LIKE '%P'
                order by CAST(inseam AS int), CAST(size_num AS int)";
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

        $sql = "SELECT * FROM `size` where id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
