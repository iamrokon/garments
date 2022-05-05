<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/order/search.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
      $ob = new select_order();
      $result = $ob->select_all();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectCountry = new select_country();
      $country_list =  $selectCountry->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();

      if (isset($_POST['search'])) {
          $search= new search_order();
          $result = $search->search($_POST);
      }

?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-bottom:15px;margin-right:10px;margin-left:10px;">


            <div class="w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">

              <div style="margin-right: 10px;margin-top: 10px;" id ="search">

                <form method="POST" action="">

                          <div class="row">

                            <div class="form-group col-md-4">
                                <label class="btn btn-info">Style Name</label>
                                <div class="input-group margin" style="margin-top: 0px">
                                               <select class="form-control col-md-12" name="style_select" id="style_select">
                                                  <option value="">Select Name</option>

                                                  <?php
                                                    while ($row = mysqli_fetch_assoc($style_list))
                                                        {
                                                  ?>
                                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                                                  <?php
                                                        }
                                                  ?>
                                                </select>
                                </div>
                          </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">PO Number</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                          <select class="form-control col-md-12" name="po_select" id="po_select">
                                           <option value="">Select PO</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($po_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                        </div>
                        </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">Country</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="country_select" id="country_select">
                                           <option value="">Select Country</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($country_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                                      </div>
                                     </div>

                   </div>

                   <div class="row">

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">From Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="from_date" name="from_date" autocomplete="off">
                     </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">To Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="to_date" name="to_date" autocomplete="off">
                     </div>

                 </div>

                 <div class="text-center" style="padding-top: 10px;">
                 <button id="search" name="search" type="submit" class="btn btn-danger center-block">SEARCH</button>
                 </div>

                </form>
              </div>

                   <div class="table-responsive table-striped w3-hoverable w3-small" style="padding:25px;">
                          <table id="export-table" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                              <thead>
                                  <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;"><span style="width:100px;">Style Name</span></th>
                                    <th style="color:white;"><span style="width:100px;">Buyer Name</span></th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Country</th>
                                    <th style="color:white;">Total Order Quantity</th>
                                    <th style="color:white;">Entry Date</th>
                                    <th style="color:white;">Entry Time</th>
                                    <th style="color:white;">Creator</th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 0;
                                   $total = 0;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:black;" class="text-center"><?php echo $info['id']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['style_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['buyer_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['po_number']; ?> </td>

                                      <td style="color:black;">
                                        <?php
                                        $countryList = $ob->select_oder_country_with_id($info['id']);
                                        while ($country = mysqli_fetch_assoc($countryList)) {
                                          ?>
                                                  <?php echo $country['country_name']." "; ?>
                                          <?php
                                          } ?>
                                      </td>

                                      <td style="color:black;" class="text-center"><?php echo $quantity = $info['total_quantity']; ?> </td>
                                      <td style="color:black;"><?php echo $info['creation_date']; ?> </td>
                                      <td style="color:black;"><?php echo $info['creation_time']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['user_name']; ?> </td>
                                      <td class="td-actions" class="text-center">
                                          <a href="./pages/order/details.php?id=<?php echo $info['id']; ?>"><button class="btn badge-text badge-text-small info">Details</button></a>
                                      </td>
                                  </tr>
                                 <?php
                                      $i++;
                                      $total += $quantity;
                                 } ?>
                              </tbody>

                               <?php ?>
                                <tfoot>
                                    <tr class="btn-gradient-02">
                                        <td style="font-weight: bold;">Count</td>
                                        <td style="font-weight: bold;"><span style="width:100px;"><?php echo $i; ?></span></td>
                                        <td style="font-weight: bold;"><span style="width:100px;"></span></td>
                                        <td style="font-weight: bold;"><span style="width:100px;"></span></td>
                                        <td style="font-weight: bold;">Total Order Quantity</td>
                                        <td style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total; ?></td>
                                        <td style="font-weight: bold;"></td>
                                        <td style="font-weight: bold;"></td>
                                        <td style="font-weight: bold;"></td>
                                        <td style="font-weight: bold;"></td>
                                    </tr>
                                </tfoot>
                                <?php  ?>

                          </table>
                        </div>
                      </div>
                  </div>
              </div>
