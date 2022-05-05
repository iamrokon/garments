<?php
require_once dirname(__FILE__).('/../db_con.php');

class search_pe extends DB_CON
{

    public function search($data)
    {
        $con = $this->connectToDB();

        $where = "";

        if(strlen($data['operator_select']) > 0)
        {
            $where .= " and `production_efficiency_child`.opt_id = ".$data['operator_select']." ";
        }

        if(strlen($data['style_select']) > 0)
        {
            $where .= " and ".$data['style_select']." IN (select `production_efficiency`.style from `production_efficiency`) ";
        }

        if(strlen($data['process_select']) > 0)
        {
            $where .= " and `production_efficiency_child`.`process_id` = ".$data['process_select']." ";
        }

        if(strlen($data['to_date']) > 0)
        {
            $from = date('Y-m-d', strtotime($_POST['from_date']));
            $to = date('Y-m-d', strtotime($_POST['to_date']));

            $where .= " and production_efficiency.e_date between '".$from."' and '".$to."' ";
        }

        $l_selection = $_POST['l_selection'];

        $count = 0;

        if(count($l_selection) > 0){

          $l_check = "";

          foreach ($l_selection as $chk) {
                   $count++;

                   if($count == '1'){
                       $where .= " and ( `production_efficiency_child`.line_id = '".$chk."' ";
                   }else {
                     $where .= " or `production_efficiency_child`.line_id = '".$chk."' ";
                   }

                 }
        }

        if(count($l_selection) > 0){
            $where .= " )";
        }


        $sql = "SELECT DISTINCT
                production_efficiency_child.opt_id as opt_id,
                production_efficiency.*,
                production_efficiency_child.*,
                (select name from line where id = production_efficiency_child.line_id) as line_name,
                production_efficiency_child.opt_name as opt_name,
                (select name from process_e where id = `production_efficiency_child`.process_id)  as process_name,
                (select smv from process_e where id = `production_efficiency_child`.process_id)  as smv,
                production_efficiency_child.target  as target,
                production_efficiency_child.one  as one,
                production_efficiency_child.two  as two,
                production_efficiency_child.three  as three,
                production_efficiency_child.four  as four,
                production_efficiency_child.five  as five,
                production_efficiency_child.six  as six,
                production_efficiency_child.seven  as seven,
                production_efficiency_child.eight  as eight,
                production_efficiency_child.nine  as nine,
                production_efficiency_child.ten  as ten,
                (select user_name from user where id = production_efficiency.user_id)  as user_name
                FROM `production_efficiency_child` left join `production_efficiency`
                on `production_efficiency_child`.pe_id = `production_efficiency`.id
                where `production_efficiency_child`.deletion_status != 1
                $where
                order by production_efficiency.id desc";

                echo "<script>console.log(".$sql.")</script>";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
