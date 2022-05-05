<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{
    public function updateData($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `production_efficiency_child` SET "
               . "one	= '$data[one]',"
               . "two	= '$data[two]',"
               . "three	= '$data[three]',"
               . "four	= '$data[four]',"
               . "five	= '$data[five]',"
               . "six	= '$data[six]',"
               . "seven	= '$data[seven]',"
               . "eight	= '$data[eight]',"
               . "nine	= '$data[nine]',"
               . "ten	= '$data[ten]'"
               . " WHERE id='$data[id]'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


    public function updateDataProcess($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `process_e` SET "
               . "name	= '$data[p_name]',"
               . "smv	= '$data[smv]'"
               . " WHERE id='$data[id]'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }



}

?>
