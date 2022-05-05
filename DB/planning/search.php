<?php
require_once dirname(__FILE__).('/../db_con.php');

class search_trims_inhouse extends DB_CON
{

    public function search($data)
    {
        $con = $this->connectToDB();

        $where = "";

        if(strlen($data['style_select']) > 0)
        {
            $where .= " and style_name = ".$data['style_select']." ";
        }

        if(strlen($data['po_select']) > 0)
        {
            $where .= " and po_number = ".$data['po_select']." ";
        }

        if(strlen($data['line_select']) > 0)
        {
            $where .= " and line_number = ".$data['line_select']." ";
        }

        if(strlen($data['pcd']) > 0)
        {
            $pcd = date('Y-m-d', strtotime($_POST['pcd']));

            $where .= " and pcd = '".$pcd."' ";
        }

        if(strlen($data['tod']) > 0)
        {
            $tod = date('Y-m-d', strtotime($_POST['tod']));

            $where .= " and tod = '".$tod."' ";
        }

        //if(strlen($data['type_select']) > 0)
        //{
            $where .= " and type = ".$data['type_select']." ";
        //}


        $sql = "SELECT
                trim_inhouse.*,
                (select name from item where id = trim_inhouse.item_name)  as itemName,
                (select style_name from style where id = trim_inhouse.style_name)  as styleName,
                (select po_num from po where id = trim_inhouse.po_number)  as poNumber,
                (select name from supplier where id = trim_inhouse.supplier)  as supplierName,
                (select name from color where id = trim_inhouse.item_color)  as colorName,
                (select name from line where id = trim_inhouse.line_number)  as lineNumber,
                (select size_num from size where id = trim_inhouse.size)  as sizeNumber,
                (select name from shade where id = trim_inhouse.shade)  as shadeName
                FROM `trim_inhouse`
                where deletion_status != 1
                $where
                order by id desc";


        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
            //echo $sql;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
