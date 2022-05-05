<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/shipment/select.php'; ?>


<?php
      $ob = new select_shipment();
      $result = $ob->select_all();


      if (isset($_POST['search'])) {
          $search= new search_c_plan();
          $result = $search->search($_POST);
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-top:15px;margin-bottom:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


              <table id="export-table" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;"><span style="width:100px;">Style Name</span></th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Country</th>
                                    <th style="color:white;">Quantity</th>
                                    <th style="color:white;">Cutting(%)</th>
                                    <th style="color:white;">Issue Quantity</th>
                                    <th style="color:white;">Output Quantity</th>
                                    <th style="color:white;">Wash Send</th>
                                    <th style="color:white;">Finishing Quantity</th>
                                    <th style="color:white;">Shipment Quantity</th>
                                    <th style="color:white;">Creation Date</th>
                                    <th style="color:white;">Creation Time</th>
                                    <th style="color:white;">Creator</th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:black;" class="text-center"><?php echo $info['id']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['style_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['po_number']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['country_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['total_quantity']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['cutting_plan']." %"; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['total_issue_quantity']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['total_output_quantity']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['total_wsend_quantity']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['total_finishing_quantity']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['total_shipment_quantity']; ?> </td>
                                      <td style="color:black;width:100px;" class="text-center"><?php echo $info['cutting_date']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['cutting_time']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['user_name']; ?> </td>
                                      <td class="td-actions" class="text-center">
                                          <a href="./pages/shipment/details_shipment.php?id=<?php echo $info['id']; ?>"><button class="btn  btn-xs btn-success">Details</button></a>
                                      </td>
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
