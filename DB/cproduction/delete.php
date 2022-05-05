<?php
require_once dirname(__FILE__).('/../db_con.php');

class delete extends DB_CON
{
    public function delete_by_id($id)
    {
        $db_connect = $this->connectToDB();

        $sql1 = "SELECT
                cutting_production.*,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production
                FROM `cutting_production`
                where id = '$id' ";

        $query_result1 = mysqli_query($db_connect, $sql1);
        if ($query_result1) {
            $lastCutProQtyInfo = mysqli_fetch_assoc($query_result1);
            $cutting_production = $lastCutProQtyInfo['cutting_production'];
        }

        if($cutting_production == 0){
          $sql = "DELETE from cutting_production where id = '$id'";
        }else{
          $sql = "UPDATE `cutting_production` SET "
                 . "deletion_status = '1'"
                 . " WHERE id = '$id'";
        }

            if (mysqli_query($db_connect, $sql)) {

              $sqlChild = "UPDATE `cut_pro_bundle` SET "
                     . "deletion_status	= '1'"
                     . " WHERE `cut_pro_bundle`.`production_id` = '$id'";

                     if (mysqli_query($db_connect, $sqlChild)) {
                      $message = "<span style='color: white;background:#f44336;padding:8px;'>Deleted Successfully</span>";
                      return $message;
                     }

            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }



}

?>
