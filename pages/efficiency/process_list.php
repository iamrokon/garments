<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/process_e/select.php'; ?>


<?php
      $ob = new select_process_e();
      $result = $ob->select_all();

?>

<div class="content-inner">


  <div id="process_modal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="box-body">

              <div class="row">

               <div class="col-md-12">
                  <div class="form-group">

                      <label class="form-control-label">
                         Name <span style="color:red;">*</span></label>

                      <div class="input-group">
                          <span class="input-group-addon addon-primary">
                              <i class="la la-file-text"></i>
                          </span>
                          <input type="text" class="form-control" id="process_name_input" placeholder ="Enter Process Name" required="required">
                      </div>

                  </div>

                  <div class="form-group">

                      <label class="form-control-label">
                         SMW <span style="color:red;">*</span></label>

                      <div class="input-group">
                          <span class="input-group-addon addon-primary">
                              <i class="la la-file-text"></i>
                          </span>
                          <input type="number" step="0.01" class="form-control" id="smv_input" placeholder ="Enter SMV" required="required">
                      </div>

                  </div>
                  <label class="form-control-label" id="process_output" style="color:red;"></label>

      </div>

  </div>


  <div class="text-center" style="padding-bottom: 10px;">
  <button id="add_process_data" class="btn btn-gradient-03" type="submit">Save</button>
  <button id="close_process_btn" class="btn btn-gradient-05" type="submit">Close</button>
  </div>

  </div>                        <!-- End Row -->

    </div>

  </div>


    <div class="w3-animate-right" style="margin-right:15px;margin-left:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">

              <div style="margin-right: 10px;margin-top: 10px;" class="row">

                <div class="col-md-4">

               </div>

               <div class="col-md-4">

              </div>

              <div class="col-md-4">
                <div class="text-center" style="padding-bottom: 10px;">
                     <button id="add_process_btn" type="button" class="btn btn-danger center-block">Add Process</button>
                </div>
             </div>

              </div>

                   <div class="table-responsive table-striped w3-hoverable w3-small" style="padding:25px;">
                          <table id="export-table" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                              <thead>
                                  <tr  class="btn-gradient-02">
                                    <th style="color:white;" class="text-center">ID</th>
                                    <th style="color:white;" class="text-center"><span style="width:100px;">Process Name</span></th>
                                    <th style="color:white;" class="text-center"><span style="width:100px;">SMV</span></th>
                                    <th style="color:white;" ><span style="width:100px;">Action</span></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:black;" class="text-center"><?php echo $i; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['smv']; ?> </td>
                                      <td class="td-actions" class="text-center">
                                          <a href="pages/efficiency/update_e.php?id=<?php echo $info['id']; ?>"><i class="la la-edit edit"></i></a>
                                      </td>
                                  </tr>
                                 <?php
                                      $i++;
                                 } ?>
                              </tbody>

                          </table>
                        </div>
                      </div>
                  </div>
              </div>

<script>


//process modal
document.getElementById("add_process_btn").onclick = function() {
   document.getElementById('process_modal').style.display = "block";
}

document.getElementById("add_process_data").onclick = function() {

  document.getElementById("process_output").innerHTML = '';

  var name = document.getElementById("process_name_input").value;
  var smv = document.getElementById("smv_input").value;

  $.post("ajax/add_process_e.php?name="+name+"&smv="+smv, function(data, status){
           console.log(data);
           document.getElementById("process_output").innerHTML = data;
           document.getElementById("process_name_input").value = "";
           document.getElementById("smv_input").value = "";
        });

}

document.getElementById("close_process_btn").onclick = function() {
   document.getElementById('process_modal').style.display = "none";
   location.reload();
}



</script>
