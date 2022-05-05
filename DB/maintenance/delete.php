<?php
require_once dirname(__FILE__).('/../db_con.php');

class delete extends DB_CON
{
    public function delete_by_id($id)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `maintenance` SET "
               . "deletion_status	= '1'"
               . " WHERE id = '$id'";

            if (mysqli_query($db_connect, $sql)) {
                  $message = "<span style='color: white;background:#f44336;padding:8px;'>Deleted Successfully</span>";
                  return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }



}

?>
