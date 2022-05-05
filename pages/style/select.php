<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
      $ob = new select_style();
      $result = $ob->select_all();
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-left:15px;margin-right:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">
                          <table id="export-table" class="table mb-0">
                              <thead class="btn-gradient-02">
                                  <tr>
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;"><span style="width:40px;">Style Name</span></th>
                                    <th style="color:white;"><span style="width:100px;">Process List</span></th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:gray;"><?php echo $info['id']; ?> </td>
                                      <td style="color:gray;"><?php echo $info['style_name']; ?> </td>

                                       <td style="color:gray;">
                                       <?php
                                        $process_list = $ob->select_style_process_with_id($info['id']);
                                        while ($process = mysqli_fetch_assoc($process_list))
                                        {
                                           echo '<span style="margin:3px;" class="badge-text badge-text-small w3-green">'.$process['process_name'].'</span>';
                                        }
                                       ?>
                                       </td>

                                      <td class="td-actions">
                                          <a href="./pages/style/update.php?id=<?php echo $info['id']; ?>"><i class="la la-edit edit"></i></a>
                                          <a href="./pages/style/delete.php?id=<?php echo $info['id']; ?>"><i class="la la-close delete"></i></a>
                                      </td>
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
