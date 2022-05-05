<?php require_once '../../../layout/main.php';?>
<?php require_once '../../../DB/cproduction/select.php'; ?>

<?php

       $cut_pro_id = $_GET['cut_pro_id'];
       $ticket = $_GET['ticket'];


       try{
         $print_number = $_GET['print_number'];
       } catch (Exception $err){
         $print_number = 5;
       }

       //select cproduction details
       $selectCproduction = new select_cproduction();
       $cproduction_result = $selectCproduction->select_with_id($cut_pro_id);
       $cproduction_details = mysqli_fetch_assoc($cproduction_result);

       //select child of cproduction bundles
       $cproduction_child_result = $selectCproduction->select_child_with_pro_id_and_ticket_no($cut_pro_id,$ticket);

       $cproduction_process_result = $selectCproduction->select_bundle_process_with_production_id($cut_pro_id);

       ?>

       <div class="content-inner" style="background-color:white;">

           <div class="container w3-animate-right">

             <div class="row">

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
               <div class="form-group col-md-3">
                <div class="row">
                  <div class="col-md-3">
                  <img style="height:180px;width:90px;" src="<?php echo $baseUrl.'pages/cproduction/qr/'.$PNG_WEB_DIR.basename($filename); ?>" />
                  </div>

                  <div class="col-md-3">
                  <text style="margin-left:20px;font-size:12px;">Bundle</text>
                  <text style="margin-left:20px;font-size:12px;">Style</text>
                  <text style="margin-left:20px;font-size:12px;">Buyer</text>
                  <text style="margin-left:20px;font-size:12px;">Color</text>
                  <text style="margin-left:20px;font-size:12px;">Po</text>
                  <text style="margin-left:20px;font-size:12px;">Cut</text>
                  <text style="margin-left:20px;font-size:12px;">SR</text>
                  <text style="margin-left:20px;font-size:12px;">Test</text>
                  <text style="margin-left:20px;font-size:12px;">Test</text>
                  <text style="margin-left:20px;font-size:12px;">Test</text>
                  </div>

                </div>
               </div>

            <?php
           	  }
            }
            ?>

          </div>

        </div>

    </div>

<script>

function printDiv(){
		//Get the HTML of div
            var divElements = document.getElementById('qr').innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
              "<html><head><title></title></head><body>" +
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
		}


</script>
