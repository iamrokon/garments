<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/cproduction/search.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/buyer/select.php'; ?>
<?php require_once '../../DB/color/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
      // $ob = new select_cproduction();
      // $result = $ob->select_all();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectBuyer = new select_buyer();
      $buyer_list =  $selectBuyer->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();

      $selectColor = new select_color();
      $color_list =  $selectColor->select_all();

      if (isset($_POST['search'])) {
          $search= new search_cproduction();
          $result = $search->search($_POST);
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-right:15px;margin-left:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


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
                         <label class="btn btn-info">Buyer</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="buyer_select" id="buyer_select">
                                           <option value="">Select Buyer</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($buyer_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                                      </div>
                                     </div>

                   </div>

                   <div class="row">

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">Color</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="color_select" id="color_select">
                                           <option value="">Select Color</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($color_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                         </div>
                        </div>

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


              <h4 style="color: #fff; text-align: center" id="mgs">
               <?php
               if (isset($_SESSION['message'])) {
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
               }
               ?>
               </h4>

               <?php
               // while ($info = mysqli_fetch_assoc($result)) {
               //   $cpro_result[] = $info;
               // }
               ?>



              <table id="example" class=" table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;">Buyer Name</span></th>
                                    <th style="color:white;"><span style="width:100px;">Style Name</span></th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Cut Number</th>
                                    <th style="color:white;">Cutting Production</th>
                                    <th style="color:white;">Color</th>
                                    <th style="color:white;">Shade</th>
                                    <th style="color:white;">Creation Date</th>
                                    <th style="color:white;">Creator</th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>


                              <?php ?>
                                <tfoot>
                                    <tr class="btn-gradient-02">
                                        <td style="font-weight: bold;">Count</td>
                                        <td style="font-weight: bold;"><span style="width:100px;"><?php //echo $i; ?></span></td>
                                        <td style="font-weight: bold;"><span style="width:100px;"></span></td>
                                        <td style="font-weight: bold;"></td>
                                        <td style="font-weight: bold;"></td>
                                        <td style="font-weight: bold;">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $total; ?></td>
                                        <td style="font-weight: bold;"></td>
                                        <td colspan="4" style="font-weight: bold;"></td>
                                    </tr>
                                </tfoot>

                          </table>
                        </div>

                      </div>
                  </div>
              </div>
              <script>
                $(document).ready(function(){
                     var dataTable=$('#example').DataTable({
                         "processing": true,
                         "serverSide":true,
                         "ajax":{
                             url:"pages/cproduction/fetch_cut_pro.php",
                             type:"post"
                         },
                          dom: 'lBfrtip',
                          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                          buttons: [
                              'copy', 'csv', 'excel', 'pdf', 'print'
                          ]
                     });
                 });
              </script>
