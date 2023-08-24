<?php include_once 'layout.php'; 
require '../assets/connection.php';
require '../assets/auth/security_functions.php';

$pgid = $_GET['id'];
$sql = "SELECT pg.CoverImage, pg.ID, pg.Title, pg.Description, pg.Status, count(sl.PageID) as total_visits, count(distinct sl.UserID) as users, count(distinct sl.Log_ID) as ss, sum(Time_spent) as total_time, (select count(DISTINCT ID) from admin_session_logs where PageID = $pgid) as actions, (select count(DISTINCT UserID) from admin_session_logs where PageID = $pgid) as admins, date(pg.CreationDate) as creation, date(pg.LastModification) as modif, (select date(Start_Time) from session_logs where PageID = $pgid order by Start_Time asc limit 1) as first_visit, (select date(Start_Time) from session_logs where PageID = $pgid order by Start_Time desc limit 1) as last_visit
FROM pages as pg inner join session_logs as sl on sl.PageID = pg.ID where pg.ID = $pgid;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>

<script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>


<div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="border-bottom text-center pb-4">
                        <img src="../../images/pages/<?=$row['CoverImage'];?>" alt="profile" class="img-fluid w-50 mb-3">
                        <div class="mb-3">
                          <h3><?=$row['Title'];?></h3>
                        </div>
                        <p class="w-75 mx-auto mb-3"><?=$row['Description'];?></p>
                        
                        <p>
                          <span>Status:</span>
                          <span class="text-muted"><?=$row['Status'];?></span>
                        </p>
                      </div>

                      <div class="py-3">
                        <h4>Summary</h4>
                        <?php
                        $s = $row['total_time']%60;
                        $m = floor(($row['total_time']%3600)/60);
                        $h = floor(($row['total_time']%86400)/3600);
                        $d = floor(($row['total_time']%2592000)/86400);
                        if($d > 0) $total_time = $d ." days ". $h ."h ". $m . " mins " . $s ."s";
                        else if($h > 0) $total_time = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $total_time = $m . " mins " . $s ."s";
                        else if($s > 0) $total_time = $s ."s";
                        else $total_time = 0;
                        ?>
                        <p>This page has been visited <?=$row['total_visits'];?> times by <?=$row['users'];?> users in <?=$row['ss'];?> sessions. The total time spent on this page is <?=$total_time;?>.</p>   
                        <p>There had been <?=$row['actions'];?> actions done for this page by <?=$row['admins'];?> admins.</p>                                                           
                        <div class="d-flex flex-row mb-3">
  <div class="p-2"><h5>Creation</h5> <p><?php $date=date_create($row['creation']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span></p></div>
  <div class="ms-auto p-2"><h5>Last modification</h5><p><?php $date=date_create($row['modif']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span></p></div>
</div>
                        
                        <div class="d-flex flex-row mb-3">
  <div class="p-2"><h5>First visit</h5> <p><?php $date=date_create($row['first_visit']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span></p></div>
  <div class="ms-auto p-2"><h5>Last visit</h5><p><?php $date=date_create($row['last_visit']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span></p></div>
</div>
                      </div>
<div class="text-center">
                      <button class="btn btn-danger btn-block mb-2 mx-2"><a href="javascript:ChangePageStatus('<?php echo $row['Status']; ?>',
                        '<?php echo $row['ID']; ?>')">
                        <?php if ($row['Status'] == 'Active') {echo "Disable";} else {echo "Enable";}?>
                        </a></button>
</div>
                    </div>
                    <div class="col-lg-8">
                      
                      <div class="mt-4 py-2 border-top border-bottom">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <?php if(isset($_REQUEST['tabid'])) $tab_id = $_REQUEST['tabid']; else $tab_id = 'details'; ?>
  <li class="nav-item" role="presentation">
    <button class="nav-link <?php echo $tab_id == 'details' ? 'active' : '' ?>" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link <?php echo $tab_id == 'content' ? 'active' : '' ?>" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab" aria-controls="content" aria-selected="false">Content</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link <?php echo $tab_id === 'access' ? 'active' : '' ?>" id="access-tab" data-bs-toggle="tab" data-bs-target="#access" type="button" role="tab" aria-controls="access" aria-selected="false">Access rights</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link <?php echo $tab_id === 'historic' ? 'active' : '' ?>" id="historic-tab" data-bs-toggle="tab" data-bs-target="#historic" type="button" role="tab" aria-controls="historic" aria-selected="false">Historic</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link <?php echo $tab_id === 'visits' ? 'active' : '' ?>" id="visits-tab" data-bs-toggle="tab" data-bs-target="#visits" type="button" role="tab" aria-controls="visits" aria-selected="false">Visits</button>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade <?php echo $tab_id == 'details' ? 'active show' : '' ?>" id="details" role="tabpanel" aria-labelledby="details-tab">
  <form method="post" id="form" action="../assets/admin/updatepage.php" enctype="multipart/form-data">
                            <?php insert_csrf_token(); ?>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                            if (isset($_SESSION['STATUS']['pagestatus']))
                            echo $_SESSION['STATUS']['pagestatus'];
                         ?>
                            </div>
                            <input type="hidden" name="pgid" id="pgid" value="<?php echo $_GET['id'];?>" />
  <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control form-control-lg" id="title" value="<?=$row['Title'];?>">
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                          if (isset($_SESSION['ERRORS']['pgtitleerror']))
                          echo $_SESSION['ERRORS']['pgtitleerror'];
                        ?>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="maxlength-textarea" rows="5" maxlength="500"><?=$row['Description'];?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="avatar">Cover image</label>
                                <input type="file" name="avatar" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control form-control-lg file-upload-info"  value="<?=$row['CoverImage'];?>"
                                        disabled="">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary new-user" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                          if (isset($_SESSION['ERRORS']['pgimageerror']))
                          echo $_SESSION['ERRORS']['pgimageerror'];
                        ?>
                            </div>
                                <div class="text-center">
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </div>
</form>
  </div>
  <div class="tab-pane fade <?php echo $tab_id == 'content' ? 'active show' : '' ?>" id="content" role="tabpanel" aria-labelledby="content-tab">
  <form method="post" id="form" action="../assets/admin/updatepage.php" enctype="multipart/form-data">
  <?php insert_csrf_token(); ?>
  <input type="hidden" name="pgid" id="pgid" value="<?php echo $_GET['id'];?>" />
  <div class="text-danger font-weight-bold mb-2">
                                <?php
                            if (isset($_SESSION['STATUS']['contentstatus']))
                            echo $_SESSION['STATUS']['contentstatus'];
                         ?>
                            </div>
  
    <?php
    $sql_content = "SELECT * FROM page_text where PageID = $pgid;";
    $result_content = mysqli_query($conn, $sql_content);
    
    if (mysqli_num_rows($result_content) > 0)
       $row_content = mysqli_fetch_assoc($result_content);
       else $row_content = ["Title"=>NULL, "Text"=>NULL];
    ?>                          <div class="form-group">
                                <label for="contenttitle">Title</label>
                                <input type="text" name="contenttitle" class="form-control form-control-lg" id="contenttitle" value="<?=$row_content['Title']?>">
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                            if (isset($_SESSION['ERROR']['contenttitle']))
                            echo $_SESSION['ERROR']['contenttitle'];
                         ?>
                            </div>

                            <div class="form-group">
                            <label for="editor1">Content to display</label>
                    <textarea name="editor1" id="editor1" rows="10" cols="80"><?=$row_content['Text']?></textarea> </div>
                    <script>
    CKEDITOR.replace('editor1', {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [

    { name: 'links' },
    { name: 'insert' },
    { name: 'tools' },
    { name: 'document',       groups: [ 'mode' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
    { name: 'styles' },
    { name: 'colors' }
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Save,Print,Iframe,Smiley,Anchor'
    });
  </script>
<div class="text-center">
                            <button type="submit" name="update_content" class="btn btn-primary">Update</button>
                            </div>
</form>
  </div>
  <div class="tab-pane fade <?php echo $tab_id == 'access' ? 'active show' : '' ?>" id="access" role="tabpanel" aria-labelledby="access-tab">
  <table id="accessusers" class="datatables-accessusers display expandable-table" style="width: 100%;">
  <?php
  $sql_user = "SELECT ac.UserID, u.Username, u.Image, u.Email FROM accessrights as ac INNER JOIN users as u on ac.UserID = u.ID WHERE PageID = $pgid;";
  $result_user = mysqli_query($conn, $sql_user);
  if (mysqli_num_rows($result_user) > 0) {
  ?>
                                <thead>
                                    <tr>
                                         <th>User</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody> 
                                  <?php while($row_user = mysqli_fetch_assoc($result_user)) { ?>                                   
                                    <tr>
                                    <td><?php echo $row_user['Image']; ?></td>
                                        <td><?php echo $row_user['Username']; ?></td>
                                        <td><?php echo $row_user['Email']; ?></td>
                                        <td><?php echo '<div><div><a href="#" class="link-dark"><b>' .$row_user['Username'] . '</b></a></div><div class="text-muted">' . $row_user['Email'] . '</div></div>'; ?></td>
                                  </tr>
                                  <?php }} ?>
                                </tbody>
                                  </table>


                                  <div class="text-center mt-5">
                                  <button id = "addacc" type="button" class="btn btn-outline-info btn-fw" onclick="toggle_add_access()">Add users</button>
                                  <button id = "removeacc" type="button" class="btn btn-outline-danger btn-fw mx-3"  onclick="toggle_remove_access()">Remove users</button>

                                  <div id="addaccess" style="display:none;" class="my-5">

                                  <form method="post" id="form" action="../assets/admin/updatepage.php" enctype="multipart/form-data">
                                  <input type="hidden" name="pgid" id="pgid" value="<?php echo $_GET['id'];?>" />
                                  <div class="row">
                                  <div class="col-sm-5">
                                     <select name="addfrom[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                                    <?php 
                                    $sql = "SELECT id, username FROM users where role='user' and id not in (SELECT userid FROM accessrights where pageid = $pgid);";
                                        $result = mysqli_query($conn, $sql);
            
                                        if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'. $row["id"] . '">'. $row["username"] . '</option>';
                                        }
                                        } else {
                                        echo "There are no users to display!";
                                        }
                                        ?>

                                        </select>
                                        </div>

                                        <div class="col-sm-2 d-flex align-items-end flex-column">
                                        <button type="button" id="multiselect_rightAll" class="btn multiselectbtn"><i
                                                class="ti-angle-double-right"></i></button>
                                        <button type="button" id="multiselect_rightSelected" class="btn multiselectbtn"><i
                                                class="ti-angle-right"></i></button>
                                        <button type="button" id="multiselect_leftSelected" class="btn multiselectbtn"><i
                                                class="ti-angle-left"></i></button>
                                        <button type="button" id="multiselect_leftAll" class="btn multiselectbtn"><i
                                                class="ti-angle-double-left"></i></button>
                                          </div>

                                     <div class="col-sm-5">
                                        <select name="addto[]" id="multiselect_to" class="form-control" size="8" multiple="multiple"></select>
                                     </div>

                                      <div class="text-center mt-5">
                                       <button type="submit" name="addaccess" class=" btn btn-primary">Add</button>
                                       </div>
                                      </div>
                                      
                                       </form>
                                  </div>

                                  <div id="removeaccess" style="display:none;" class="my-5">
                                  <form method="post" id="form" action="../assets/admin/updatepage.php" enctype="multipart/form-data">
                                  <input type="hidden" name="pgid" id="pgid" value="<?php echo $_GET['id'];?>" />
                                  <div class="row">
                                  <div class="col-sm-5">
                                  <select name="removefrom[]" id="multiselect2" class="form-control" size="8" multiple="multiple">
                                    <?php 
                                    $sql = "SELECT id, username FROM users where role='user' and id in (SELECT userid FROM accessrights where pageid = $pgid);";
                                        $result = mysqli_query($conn, $sql);
            
                                        if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'. $row["id"] . '">'. $row["username"] . '</option>';
                                        }
                                        } else {
                                        echo "There are no users to display!";
                                        }
                                        ?>

                                        </select>
                                      </div>
                                  
                                        <div class="col-sm-2 d-flex align-items-end flex-column">
                                        <button type="button" id="multiselect2_rightAll" class="btn multiselectbtn"><i
                                                class="ti-angle-double-right"></i></button>
                                        <button type="button" id="multiselect2_rightSelected" class="btn multiselectbtn"><i
                                                class="ti-angle-right"></i></button>
                                        <button type="button" id="multiselect2_leftSelected" class="btn multiselectbtn"><i
                                                class="ti-angle-left"></i></button>
                                        <button type="button" id="multiselect2_leftAll" class="btn multiselectbtn"><i
                                                class="ti-angle-double-left"></i></button>
                                          </div>

                                     <div class="col-sm-5">
                                        <select name="removeto[]" id="multiselect2_to" class="form-control" size="8" multiple="multiple"></select>
                                     </div>

                                      <div class="text-center mt-5">
                                       <button type="submit" name="removeaccess" class=" btn btn-primary">Remove</button>
                                       </div>
                                      </div>
                                      
                                       </form>
                                  </div>

                                </div>
</div>
  <div class="tab-pane fade <?php echo $tab_id == 'historic' ? 'active show' : '' ?>" id="historic" role="tabpanel" aria-labelledby="historic-tab">
  <div class="d-flex justify-content-center">
  <ul class="timeline-list">
  <?php 
       $sql = "SELECT sl.Event_Description, sl.UserID, sl.Date, u.Username, u.Image FROM admin_session_logs as sl inner join users as u on sl.UserID = u.ID where pageid = $pgid;";
       $result = mysqli_query($conn, $sql);
       if (mysqli_num_rows($result) > 0) {
       while($row = mysqli_fetch_assoc($result)) {
       ?>
										<li>
											<h6><?=$row['Event_Description']?></h6>
                      <div class="d-flex align-items-center py-2">
                      <img class="rounded-circle" style="width:30px;" src="../../images/user_uploads/<?=$row['Image']?>" alt="profile">
											<h6 class="mx-3 mt-2"><?=$row['Username']?></h6>
									</div>

											<p class="text-muted mb-4">
												<i class="ti-time"></i>
												<?php $date=date_create($row['Date']);
                                    echo date_format($date,"d-m-Y"); ?>
											</p>
										</li>

                  <?php
                   }
                  } else {
                  echo "There is no historic available for this page!";
                  } ?>
                  </ul>
                  </div>
</div>
  <div class="tab-pane fade <?php echo $tab_id == 'visits' ? 'active show' : '' ?>" id="visits" role="tabpanel" aria-labelledby="visits-tab">
  <table id="pagevisits" class="datatables-pagevisits display expandable-table" style="width: 100%;">
  <?php
  $sql_user = "SELECT u.Username, u.Image, u.Email, sl.Start_Time, sl.Time_spent FROM session_logs as sl inner join users as u on u.ID = sl.UserID WHERE sl.PageID = $pgid;";
  $result_user = mysqli_query($conn, $sql_user);
  if (mysqli_num_rows($result_user) > 0) {
  ?>
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Time spent</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                  <?php while($row_user = mysqli_fetch_assoc($result_user)) { ?>                                   
                                    <tr>
                                    <td><?php echo $row_user['Image']; ?></td>
                                        <td><?php echo $row_user['Username']; ?></td>
                                        <td><?php echo $row_user['Email']; ?></td>
                                        <td><?php echo '<div><div><a href="#" class="link-dark"><b>' .$row_user['Username'] . '</b></a></div><div class="text-muted">' . $row_user['Email'] . '</div></div>'; ?></td>
                                        <td><?php $date=date_create($row_user['Start_Time']);
                                        echo date_format($date,"d-m-Y H:i:s"); ?></td>
                                        <td><?php 
                                        $hours = floor($row_user['Time_spent'] / 3600);
                                        $mins = floor($row_user['Time_spent'] / 60 % 60);
                                        $sec = floor($row_user['Time_spent'] % 60);
                                        if($hours > 0) echo $hours .'h ' . $mins . 'mins ' . $sec .'s';
                                        else if($mins > 0) echo $mins . 'mins ' . $sec .'s';
                                        else echo $sec .'s';
                                        ?></td>
                                  </tr>
                                  <?php }} ?>
                                </tbody>
                                  </table>
</div>
</div>
                      </div>
                      
                  </div>
                </div>
              </div>
            </div>
          </div>
                                  </div>
<?php }
else {
    echo "Page doesn't exist!";
  } ?>
  
<?php include_once 'footer.php';?>