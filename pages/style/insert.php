<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/style/insert.php'; ?>
<?php require_once '../../DB/process_c/select.php'; ?>

<?php
      $style = new insert();

      $selectProcessC = new select_process_c();
      $process_c_list =  $selectProcessC->select_all();

      if (isset($_POST['btn'])) {

          $insert_id = $style->save($_POST);

          if($insert_id > 0){

            $totalCount = count($_POST['style_insert']);

            for($i = 0; $i<$totalCount; $i++){

              $message = $style->add_style_process(
                                                   $insert_id,
                                                   $_POST['style_insert'][$i]
                                                  );
            }
            for($i = 1; $i<=$_POST['count']; $i++){

              $message = $style->add_shrinkage(
                                                   $insert_id,
                                                   $_POST['pattern_'.$i],
                                                   $_POST['length_wrap_'.$i],
                                                   $_POST['width_weft_'.$i]
                                                  );
            }
          }
      }

      if($message){
         $_SESSION['message'] = $message;
         header("Location: insert.php"); // redirect back to your form
         exit;
      }

?>

<div class="content-inner">



  <div id="process_c_modal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="box-body">

              <div class="row">

               <div class="col-md-12">
                  <div class="form-group">

                      <label class="form-control-label">Process Name <span style="color:red;">*</span></label>

                      <div class="input-group">
                          <span class="input-group-addon addon-primary">
                              <i class="la la-file-text"></i>
                          </span>
                          <input type="text" class="form-control" id="process_c_name_input" placeholder ="Enter Process Name" required="required">
                      </div>
                  </div>

                  <label class="form-control-label" id="process_c_output" style="color:red;"></label>

      </div>

  </div>


  <div class="text-center" style="padding-bottom: 10px;">
  <button id="add_process_c_data" class="btn btn-gradient-03" type="submit">Save</button>
  <button id="close_process_c_btn" class="btn btn-gradient-05" type="submit">Close</button>
  </div>

  </div>                        <!-- End Row -->

    </div>

  </div>




    <div class="w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: #3c8dbc;padding: 15px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    All star marked ( <span style="color:red;">*</span> ) fields are mandatory, please fill up all mandatory fields.
                </span>
              <h4 style="color: #fff; text-align: center">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
               </h4>
            </div>
            <!-- End Page Header -->
            <div class="box-body w3-card-4">
                <form method="post" enctype="multipart/form-data" action="" class="needs-validation" novalidate>

                    <div class="row" style="padding-right: 10px;padding-left: 10px;">

                     <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Style Name <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-file-text"></i>
                                </span>
                                <input type="text" class="form-control" name="style_name" placeholder ="Enter Style Name" required="required">
                            </div>

                        </div>

                    </div>
                <div id="add_row_table">
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
                  <input type="hidden" name="count" id="count" value="1">
              </div>


            <div class="col-md-6">

              <div class="form-group" style="display:none;">

                  <label class="form-control-label">Details <span style="color:red;">*</span></label>

                  <div class="input-group">
                      <span class="input-group-addon addon-primary">
                          <i class="la la-file-text"></i>
                      </span>
                      <input type="text" class="form-control" name="details" placeholder ="Enter Details" required="required">
                  </div>

              </div>

        </div>

    </div>

    <br>

      <div style="padding:10px;">

      <label class="form-control-label btn btn-success" style="margin-right:10px;margin-top:10px;">Cutting Process List</label>
      <button id="add_process_c" type="button" class="btn btn-danger center-block">+</button>
      <div>
      <input id="checkAllProcessC" style="margin-left:10px;height:17px;width:17px;" value="0" type="checkbox"><text style="color:black;">  All</text>
      </div>
      <div id="process_c_list_div">
      <div class="row" id="process_c_list_creation">
      <?php
        while ($row = mysqli_fetch_assoc($process_c_list))
            {
      ?>
      <div class="col-md-2">
      <input type="checkbox"  class="checkItem" style="margin-left:10px;height:17px;width:17px;" name="style_insert[]" value="<?php echo $row['id']; ?>">
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
        <button name="btn" class="btn btn-gradient-03" type="submit">Save Info</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>


</form>

</div>

</div>
</div>
</div>

<script>

$(document).ready(function () {

   $('#checkAllProcessC').click(function () {
         $("#process_c_list_div :checkbox").attr('checked', true);
     });


     //process c modal
     document.getElementById("add_process_c").onclick = function() {
        document.getElementById('process_c_modal').style.display = "block";
     }

     document.getElementById("add_process_c_data").onclick = function() {

       var process_name = document.getElementById("process_c_name_input").value;
       $.post("ajax/add_process_c.php?process_name="+process_name, function(data, status){
                console.log(data);
                document.getElementById("process_c_output").innerHTML = data;
                document.getElementById("process_c_name_input").value = "";
             });

     }

     document.getElementById("close_process_c_btn").onclick = function() {
        document.getElementById('process_c_modal').style.display = "none";
        document.getElementById('process_c_list_creation').innerHTML = '';
        document.getElementById("process_c_output").innerHTML = '';

        var selectProcessC = '';

        $.get("ajax/all_process_c_list.php", function(data, status){

                 var data = JSON.parse(data);

                 data.forEach(function(process){

                   selectProcessC +=  '<div class="col-md-2">'
                                    +'<input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="cproduction_'+process.id+'" value="'+process.id+'">'
                                    +'<text style="color:black;" id="cproduction_'+process.id+'">'+process.name+'</text>'
                                    +'</div>';

                 });

                 $('#process_c_list_creation').append(selectProcessC);
              });
     }


});


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
