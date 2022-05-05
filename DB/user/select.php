<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_user extends DB_CON
{
    public function getUserWithId($id)
    {
        $db = new DB_CON();
        $con = $db->connectToDB();

        $sql = "SELECT * FROM `user` where id = '".$id."'";
        $query_result = mysqli_query($db_connect, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }


    public function select_all_users()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `user`";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
