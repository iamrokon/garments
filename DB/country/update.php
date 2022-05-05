<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{
    public function updateData($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `country` SET "
               . "full_name	= '$data[full_name]',"
               . "short_name = '$data[short_name]',"
               . "cut_off = '$data[cut_off]',"
               . "country_code = '$data[country_code]'"
               . " WHERE id='$data[id]'";

        if (mysqli_query($db_connect, $sql)) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
            return $message;
        } else {
            die('Query Problem' . mysqli_error($db_connect));
        }
    }



}

?>
