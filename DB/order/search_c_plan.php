<?php
require_once dirname(__FILE__).('/../db_con.php');

class search_c_plan extends DB_CON
{

    public function search($data)
    {
        $con = $this->connectToDB();

        $where = "";

        if(strlen($data['po_select']) > 0)
        {
            $where .= " and po = ".$data['po_select']." ";
        }

        if(strlen($data['country_select']) > 0)
        {
            $where .= " and country = ".$data['country_select']." ";
        }

        if(strlen($data['style_select']) > 0)
        {
            $where .= " and style = ".$data['style_select']." ";
        }

        if(strlen($data['to_date']) > 0)
        {
            $from = date('d-m-Y', strtotime($_POST['from_date']));
            $to = date('d-m-Y', strtotime($_POST['to_date']));

            $where .= " and cutting_date between '".$from."' and '".$to."' ";
        }


        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select full_name from country where id = order_details.country)  as country_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.cutting_user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                $where and cutting_plan > 0
                order by order_details.creation_date desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
