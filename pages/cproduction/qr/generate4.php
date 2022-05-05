<?php require_once '../../../layout/rootURL.php';?>
<?php require_once '../../../DB/cproduction/select.php'; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<style>
    @media print {
        #printbtn {
            display :  none;
        }
    }

    * {
      box-sizing: border-box;
    }

    /* Create three equal columns that floats next to each other */
    .column {
      float: left;
      width: 8%;
      padding: 10px;
      height: 200px; /* Should be removed. Only for demonstration */
    }

    /* Create three equal columns that floats next to each other */
    .column2 {
      float: left;
      width: 5%;
      padding: 0px;
      height: 200px; /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }

</style>

<?php

       $cut_pro_id = $_GET['cut_pro_id'];
       $ticket = $_GET['ticket'];


       try{
         $print_number = $_GET['print_number'];
       } catch (Exception $err){
         $print_number = 1;
       }

       if($print_number == 0 || $print_number == "")
       {
         $print_number = 1;
       }

       //select cproduction details
       $selectCproduction = new select_cproduction();
       $cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
       $cproduction_details = mysqli_fetch_assoc($cproduction_result);

       //select child of cproduction bundles
       $cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);

       $cproduction_process_result = $selectCproduction->select_bundle_process_with_production_id($cut_pro_id);

       ?>

      <button onclick="window.print();" id="printbtn">print</button>

      <div style="margin-top:10px;">
      <?php

      //set it to writable location, a place for temp generated PNG files
      $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

      //html PNG location prefix
       $PNG_WEB_DIR = 'temp/';

       include "qrlib.php";

       //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

        $filename = $PNG_TEMP_DIR.'test.png';

        	 while ($row = mysqli_fetch_assoc($cproduction_child_result))
        	 {
             while ($row_p = mysqli_fetch_assoc($cproduction_process_result))
          	 {
               for($i=1;$i<=$print_number;$i++){

               $bundle_no = $row['bundle_no'];
               $style = $cproduction_details['style_name'];
               $buyer = $cproduction_details['buyer_name'];
               $color = $cproduction_details['color_name'];
               $po = $cproduction_details['po_number'];
               $cut_number = $cproduction_details['cut_number'];
               $shade_name = $cproduction_details['shade_name'];

               $bundle_tkt_code = $row['b_tkt_code'];

               $bundle_part = $row_p['process_name'];
               $bundle_part_id = $row_p['id'];

               $ticket_size = $row['ticket_size'];
               $from_id = $row['from_id'];
               $to_id = $row['to_id'];
               $quantity = $row['quantity'];

               $qrString = $bundle_tkt_code."-".$bundle_part_id;


        	     $errorCorrectionLevel = 'M';
               $matrixPointSize = min(max((int)4, 1), 10);

               $filename = $PNG_TEMP_DIR.'test'.md5($qrString.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
               QRcode::png($qrString, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

               ?>
               <div class="column">
                  <div>
                  <img style="height:120px;width:90px;" src="<?php echo $baseUrl.'pages/cproduction/qr/'.$PNG_WEB_DIR.basename($filename); ?>" />
                 </div>

                  <div>
                  <text style="margin-left:20px;font-size:12px;"><?php echo $bundle_part;?></text>
                 </div>
              </div>

              <div class="column" style="margin-top:10px;">
                <text style="margin-left:0px;font-size:10px;">Bundle:<?php echo "  ".$bundle_no;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Style:<?php echo "  ".$style;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Buyer:<?php echo "  ".$buyer;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Color:<?php echo "  ".$color;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Po:<?php echo "  ".$po;?></text><br>
                <text style="margin-left:0px;font-size:10px;">CNo:<?php echo "  ".$cut_number;?></text><br>
                <text style="margin-left:0px;font-size:10px;">SR:<?php echo "  ".$from_id." - ".$to_id;?></text><br>
                <text style="margin-left:0px;font-size:10px;">QTY:<?php echo "  ".$quantity;?></text><br>
                <text style="margin-left:0px;font-size:10px;">Size:<?php echo "  ".$ticket_size;?></text><br>
             </div>

            <?php
           	  }
             }
            }
            ?>
          </div>
<script>


</script>
