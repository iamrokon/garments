<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_supplier extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `supplier` where deletion_status != 1 order by id";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


}

?>
