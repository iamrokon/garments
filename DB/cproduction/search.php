<?php
require_once dirname(__FILE__).('/../db_con.php');

class search_cproduction extends DB_CON
{

    public function search($data)
    {
        $con = $this->connectToDB();

        $where = "";

        if(strlen($data['po_select']) > 0)
        {
            $where .= " and po = ".$data['po_select']." ";
        }

        if(strlen($data['buyer_select']) > 0)
        {
            $where .= " and buyer = ".$data['buyer_select']." ";
        }

        if(strlen($data['color_select']) > 0)
        {
            $where .= " and color = ".$data['color_select']." ";
        }

        if(strlen($data['style_select']) > 0)
        {
            $where .= " and style = ".$data['style_select']." ";
        }

        if(strlen($data['to_date']) > 0)
        {
            $from = date('d-m-Y', strtotime($_POST['from_date']));
            $to = date('d-m-Y', strtotime($_POST['to_date']));

            $where .= " and creation_date between '".$from."' and '".$to."' ";
        }


        $sql = "SELECT cutting_production*,
                (select id from id where id = cutting_production.id)  as id,
                (select buyer from buyer where id = cutting_production.buyer)  as buyer,
                (select po from po where id = cutting_production.po)  as po,
                (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_num,
                (select color from color where id = cutting_production.color)  as color,
                (select style from style where id = cutting_production.style)  as style,
                (select shade from shade where id = cutting_production.shade)  as shade
        
                FROM `cutting_production`
                where deletion_status != 1
                $where
                order by cutting_production_view.creation_date desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
