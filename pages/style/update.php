<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/style/update.php'; ?>
<?php require_once '../../DB/process_c/select.php'; ?>

<?php
  $id = $_GET['id'];

  $selectProcessC = new select_process_c();
  $process_c_list =  $selectProcessC->select_all();

  $style = new select_style();
  $result = $style->select_with_id($id);
  $data = mysqli_fetch_assoc($result);

  $style_process_list = $style->select_style_process_with_id($id);
  $pro_list = array();

  while($row = mysqli_fetch_assoc($style_process_list)){
       array_push($pro_list,$row['pro_id']);
  }

  $style_shrinkage = $style->select_style_shrinkage_with_id($id);
  // $shrinkage_list = array();
  //
  // while($row = mysqli_fetch_assoc($style_shrinkage)){
  //      array_push($shrinkage_list,$row['pro_id']);
  // }

  $update_style = new update();

  if (isset($_POST['btn'])) {
     $message = $update_style->updateData($_POST);

     $message = $update_style->updateStyleProcess($_POST,$id);

     $message = $update_style->updateShrinkage($_POST,$id,$_POST['count']);

     $result = $style->select_with_id($id);
     $data = mysqli_fetch_assoc($result);

     $style_process_list = $style->select_style_process_with_id($id);
     $pro_list = array();

     while($row = mysqli_fetch_assoc($style_process_list)){
          array_push($pro_list,$row['pro_id']);
     }
    }
?>

<div class="content-inner">

    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: #3c8dbc;padding: 15px; margin-top: 5px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    All star marked ( <span style="color:red;">*</span> ) fields are mandatory, please fill up all mandatory fields.
                </span>
              <h4 style="color: #fff; text-align: center">
               <?php
               if (isset($message)) {
                   echo $message;
                   unset($message);
               }
               ?>
               </h4>
            </div>
            <!-- End Page Header -->
            <div class="box-body w3-card-4">
                <form method="post" enctype="multipart/form-data" action="" id="update-form" class="needs-validation" novalidate>

                    <div class="row" style="padding-right: 10px;padding-left: 10px;">

                     <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Style Name <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="style_name" value="<?php echo $data['style_name']; ?>" placeholder ="Enter Style Name" required="">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $data['id']; ?>" required="">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Length Wrap <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="length_wrap" value="<?php echo $data['length_wrap']; ?>" required="required">
                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Width Weft <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="width_weft" value="<?php echo $data['width_weft']; ?>" required="required">
                            </div>

                        </div>

                    </div> -->

                    <div id="add_row_table">
                      <?php $i=1;
                      $style_exist = 0;
                      foreach ($style_shrinkage as $shrinkage_info) {
                         if($shrinkage_info['id']){
                           $style_exist = 1;
                         }
                      }
                       foreach ($style_shrinkage as $shrinkage_info) {
                         ?>
                      <div class="row" style="padding-right: 10px;padding-left: 10px;">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="form-control-label">Pattern <span style="color:red;">*</span></label>

                                <div class="input-group">
                                    <span class="input-group-addon addon-primary">
                                        <i class="la la-file-text"></i>
                                    </span>
                                    <input type="text" class="form-control" name="pattern_<?php echo $i;?>" value="<?php echo $shrinkage_info['pattern'];?>" required="required">
                                    <input type="hidden" name="shrinkage_id_<?php echo $i;?>" value="<?php echo $shrinkage_info['id'];?>">
                                    <button id="add_style" name="add_style" type="button" onclick="addNewRow()" class="btn btn-danger center-block">+</button>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="form-control-label">Length Wrap <span style="color:red;">*</span></label>

                                <div class="input-group">
                                    <span class="input-group-addon addon-primary">
                                        <i class="la la-file-text"></i>
                                    </span>
                                    <input type="text" class="form-control" name="length_wrap_<?php echo $i;?>" value="<?php echo $shrinkage_info['length_wrap'];?>" required="required">
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">

                                <label class="form-control-label">Width Weft <span style="color:red;">*</span></label>

                                <div class="input-group">
                                    <span class="input-group-addon addon-primary">
                                        <i class="la la-file-text"></i>
                                    </span>
                                    <input type="text" class="form-control" name="width_weft_<?php echo $i;?>" value="<?php echo $shrinkage_info['width_weft'];?>" required="required">
                                </div>

                            </div>

                        </div>
                      <?php $i++;} ?>
                      </div>
                      <?php
                      if(!$style_exist){ $i=2;?>
                        <div class="row" style="padding-right: 10px;padding-left: 10px;">
                          <div class="col-md-4">
                              <div class="form-group">

                                  <label class="form-control-label">Pattern <span style="color:red;">*</span></label>

                                  <div class="input-group">
                                      <span class="input-group-addon addon-primary">
                                          <i class="la la-file-text"></i>
                                      </span>
                                      <input type="text" class="form-control" name="pattern_1" placeholder ="Enter Length Wrap" required="required">
                                      <button id="add_style" name="add_style" type="button" onclick="addNewRow()" class="btn btn-danger center-block">+</button>
                                  </div>

                              </div>

                          </div>
                          <div class="col-md-4">
                              <div class="form-group">

                                  <label class="form-control-label">Length Wrap <span style="color:red;">*</span></label>

                                  <div class="input-group">
                                      <span class="input-group-addon addon-primary">
                                          <i class="la la-file-text"></i>
                                      </span>
                                      <input type="text" class="form-control" name="length_wrap_1" placeholder ="Enter Length Wrap" required="required">
                                  </div>

                              </div>

                          </div>
                          <div class="col-md-4">
                              <div class="form-group">

                                  <label class="form-control-label">Width Weft <span style="color:red;">*</span></label>

                                  <div class="input-group">
                                      <span class="input-group-addon addon-primary">
                                          <i class="la la-file-text"></i>
                                      </span>
                                      <input type="text" class="form-control" name="width_weft_1" placeholder ="Enter Width Weft" required="required">
                                  </div>

                              </div>

                          </div>
                        </div>
                      <?php } ?>
                      <input type="hidden" name="count" id="count" value="<?php echo ($i-1);?>">
                  </div>


            <div class="col-md-6">

              <div class="form-group" style="display:none;">

                  <label class="form-control-label">Details <span style="color:red;">*</span></label>

                  <div class="input-group">
                      <span class="input-group-addon addon-primary">
                          <i class="la la-file-text"></i>
                      </span>
                      <input type="text" class="form-control" name="details" value="<?php echo $data['details']; ?>" placeholder ="Enter Short Name" required="">
                  </div>
                  </div>

           </div>

    </div>

      <div style="padding:10px;">

      <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Cutting Process List</label>
      <div id="process_c_list_div">
      <div class="row" id="process_c_list_creation">
      <?php
        while ($row = mysqli_fetch_assoc($process_c_list))
            {
      ?>
      <div class="col-md-2">
      <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;" name="style_insert[]" value="<?php echo $row['id']; ?>" <?php echo(in_array($row['id'], $pro_list) ? "checked='checked'" : "") ?>>
      <text style="color:black;">  <?php echo $row['name']; ?><text>
      </div>
      <?php
            }
      ?>
     </div>
     </div>

     </div>

   <br>

    <div class="text-center" style="padding-bottom: 10px;">
        <button name="btn" class="btn btn-gradient-03" type="submit">Update Info</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>


</form>

</div>
</div>
</div>
</div>

<script>

function addNewRow(){
  var count = document.getElementById('count').value;
              count++;
              document.getElementById('count').value = count;



  rowItem = '<div class="row" style="padding-right: 10px;padding-left: 10px;">'
              +'<div class="col-md-4">'
                +'<div class="form-group">'

                      +'<label class="form-control-label">Pattern <span style="color:red;">*</span></label>'

                      +'<div class="input-group">'
                          +'<span class="input-group-addon addon-primary">'
                              +'<i class="la la-file-text"></i>'
                          +'</span>'
                          +'<input type="text" class="form-control" name="pattern_'+count+'" placeholder ="Enter Length Wrap" required="required">'
                          +'<button id="add_style" name="add_style" type="button" onclick="addNewRow()" class="btn btn-danger center-block">+</button>'
                      +'</div>'

                  +'</div>'

              +'</div>'
              +'<div class="col-md-4">'
                  +'<div class="form-group">'

                      +'<label class="form-control-label">Length Wrap <span style="color:red;">*</span></label>'

                      +'<div class="input-group">'
                          +'<span class="input-group-addon addon-primary">'
                              +'<i class="la la-file-text"></i>'
                          +'</span>'
                          +'<input type="text" class="form-control" name="length_wrap_'+count+'" placeholder ="Enter Length Wrap" required="required">'
                      +'</div>'

                  +'</div>'

              +'</div>'
              +'<div class="col-md-4">'
                  +'<div class="form-group">'

                      +'<label class="form-control-label">Width Weft <span style="color:red;">*</span></label>'

                      +'<div class="input-group">'
                          +'<span class="input-group-addon addon-primary">'
                              +'<i class="la la-file-text"></i>'
                          +'</span>'
                          +'<input type="text" class="form-control" name="width_weft_'+count+'" placeholder ="Enter Width Weft" required="required">'
                      +'</div>'

                  +'</div>'

              +'</div>'
              +'</div>';
              $('#add_row_table').append(rowItem);

}
</script>
