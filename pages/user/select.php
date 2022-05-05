<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/user/select.php'; ?>

<?php
      $select_user_list = new select_user();
      $result = $select_user_list->select_all_users();
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-bottom:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">
                          <table id="export-table" class="table mb-0">
                              <thead class="btn-gradient-02">
                                  <tr>
                                    <th style="color:white;">Photo</th>
                                    <th style="color:white;"><span style="width:100px;">Full Name</span></th>
                                    <th style="color:white;">Telephone</th>
                                    <th style="color:white;">Email</th>
                                      <th style="color:white;"><span style="width:100px;"><span style="width:100px;">Address</span></th>
                                    <th style="color:white;"><span style="width:100px;"><span style="width:100px;">Status</span></th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td><img src=./pages/user/<?php echo $info['image']; ?> alt="name" height="70px" width="70px"></td>
                                      <td style="color:gray;"><?php echo $info['user_name']; ?> </td>
                                      <td style="color:gray;"><?php echo $info['tel']; ?> </td>
                                      <td style="color:gray;"><?php echo $info['email']; ?></td>
                                      <td style="color:gray;"><?php echo $info['address']; ?></td>
                                        <td>
                                          <?php
                                              if ($info['status'] == 1) {
                                                  ?>
                                                  <span style="width:100px;"><span class="badge-text badge-text-small success">Active</span></span>
                                                  <?php
                                              } else {
                                                  ?>
                                                    <span style="width:100px;"><span class="badge-text badge-text-small w3-red">Inactive</span></span>
                                              <?php } ?>
                                          </td>
                                      <td class="td-actions">
                                          <a href="./pages/user/update.php?id=<?php echo $info['id']; ?>"><i class="la la-edit edit"></i></a>
                                          <!--<a href="#"><i class="la la-close delete"></i></a>-->
                                      </td>
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
