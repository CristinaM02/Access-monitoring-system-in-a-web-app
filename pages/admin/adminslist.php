<?php include_once 'layout.php';
      require_once '../assets/connection.php';
      
      $sql = "SELECT ID, Username, Email, CreationDate, LastLogin, Image, Is_Active, Is_Verified FROM users WHERE role='admin';";
      $result = $conn->query($sql);
      $arr_users = [];
      if ($result->num_rows > 0) {
          $arr_users = $result->fetch_all(MYSQLI_ASSOC);
      }
      ?>


<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Admins</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="admins" class="datatables-users display expandable-table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                        <th>Active</th>
                                        <th>Verified</th>
                                        <th>Created at</th>
                                        <th>Last login</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($arr_users)) { ?>
                                    <?php foreach($arr_users as $user) { ?>
                                    <tr>
                                        <td><?php echo $user['Image']; ?></td>
                                        <td><?php echo $user['Username']; ?></td>
                                        <td><?php echo $user['Email']; ?></td>
                                        <td><?php echo '<div><div><a href="userinfo.php?id='. $user['ID'] .'" class="link-dark"><b>' .$user['Username'] . '</b></a></div><div class="text-muted">' . $user['Email'] . '</div></div>'; ?></td>
                                        <td> <label class="badge
                                         <?php if ($user['Is_Active'] == 'Yes') {echo " badge-success";} else {echo " badge-danger";}?>">
                                         <?php echo $user['Is_Active']; ?></label>
                                        </td>
                                        <td> <label class="badge
                                         <?php if ($user['Is_Verified'] == 'Yes') {echo " badge-success";} else {echo " badge-danger";}?>">
                                         <?php echo $user['Is_Verified']; ?></label>
                                        </td>
                                        <td><?php $date=date_create($user['CreationDate']);
                                        echo date_format($date,"d-m-Y H:i:s"); ?></td>
                                        <td><?php $date=date_create($user['LastLogin']);
                                        echo date_format($date,"d-m-Y H:i:s"); ?></td>
                                        <td>
                                            <div class="btn-group dropleft">
                                                <i class="icon-options-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </i>
                                                <div class="dropdown-menu" x-placement="right-start"
                                                    style="position: absolute; transform: translate3d(111px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a href="userinfo.php?id=<?=$user['ID']?>" class="dropdown-item">View</a>
                                                    <a href="javascript:UserStatus('<?php echo $user['Is_Active']; ?>',
                                                        '<?php echo $user['ID']; ?>')" class="dropdown-item enable-page">
                                                        <?php if ($user['Is_Active'] == 'Yes') {echo "Disable";} else {echo "Enable";}?>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="javascript:DeleteUser('<?php echo $user['ID']; ?>')" class="dropdown-item text-danger delete-record">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
  </div>
</div>
                    </div>
                </div>
            </div>
            
        </div>




<?php include_once 'footer.php';?>