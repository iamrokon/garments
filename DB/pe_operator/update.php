<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{
    public function updateData($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `operator` SET "
               . "`line_id` = '$data[line_select]'"
               . " WHERE id = '$data[operator_select]'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }

}

?>
