<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/trims_inhouse/select.php'; ?>
<?php require_once '../../DB/trims_inhouse/search.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
      // $ob = new select_trims_inhouse();
      // $result = $ob->select_all();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectLine = new select_line();
      $line_list =  $selectLine->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();

      if (isset($_POST['search'])) {
        //echo "$_POST['type_select']";
        // echo '<pre>';
        // print_r($_POST['type_select']);
        // echo  '</pre>';
          $search= new search_trims_inhouse();
          $result = $search->search($_POST);
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-right:10px;margin-left:10px;">

            <!-- <div class="w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


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
                         <label class="btn btn-info">Line</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="line_select" id="line_select">
                                           <option value="">Select Line</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($line_list))
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
                         <label class="btn btn-info">PCD</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="pcd" name="pcd" autocomplete="off">
                     </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">TOD</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="tod" name="tod" autocomplete="off">
                     </div>
                    <div class="form-group col-md-4">
                        <label class="btn btn-info">Type</label>
                        <div style="margin-top: 0px">
                           <select class="form-control" name="type_select" id="type_select">
                             <option value="">Select Type</option>
                              <option value="0">Recieve</option>
                              <option value="1">Inhouse</option>
                           </select>
                         </div>
                     </div>
                  </div>


                 </div>

                 <div class="text-center" style="padding-top: 10px;">
                 <button id="search" name="search" type="submit" class="btn btn-danger center-block">SEARCH</button>
                 </div>

                </form>
              </div> -->



          <div class="table-responsive table-striped w3-hoverable w3-small" style="padding:25px;">
              <table id="example" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;">Style name</th>
                                    <th style="color:white;">PO</th>
                                    <th style="color:white;">Total Requirement</th>
                                    <th style="color:white;">Total Received</th>
                                    <th style="color:white;">Total issue</th>
                                    <th style="color:white;">Total Balance</th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
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
                             url:"pages/trinhouse/fetch_trinhouse.php",
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
