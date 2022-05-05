<?php
require_once dirname(__FILE__).('/../db_con.php');

class delete extends DB_CON
{
    public function deleteData($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `style` SET "
               . "deletion_status	= '1'"
               . " WHERE id='$data[id]'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Deleted Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }



}

?>
