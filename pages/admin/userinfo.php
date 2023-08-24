<?php include_once 'layout.php'; 
require '../assets/connection.php';
require '../assets/auth/security_functions.php';

$uid = $_GET['id'];
$sql = "SELECT u.Id, u.Username, u.Email, u.Role, u.CreationDate, u.LastLogin, u.Image, u.Is_Active, u.VerificationDate, (SELECT Login FROM login_logs where UserID = $uid order by Login asc limit 1) as first_log, count(l.ID) as total_logs, sum(TIMESTAMPDIFF(SECOND, l.Login, COALESCE(l.Logout, l.Login))) as total_time
FROM users as u inner join login_logs as l on u.ID = l.UserID where u.ID = $uid AND Status = 'Success';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-5">
                      <div class="border-bottom text-center pb-2">
                        <img src="../../images/user_uploads/<?=$row['Image'];?>" alt="profile" class="img-lg rounded-circle mb-3">
                        <div class="mb-3">
                          <h3><?=$row['Username'];?></h3>
                        </div>

                        <p>
                          <span>Email:</span>
                          <span class="text-muted"><?=$row['Email'];?></span>
                        </p>
                        <p>
                          <span>Role:</span>
                          <span class="text-muted"><?=$row['Role'];?></span>
                        </p>
                        <p>
                          <span>Status:</span>
                          <span class="text-muted"><?php if($row['Is_Active']=='Yes') echo 'Active'; else echo 'Inactive';?></span>
                        </p>
                      </div>

                      <div class="border-bottom pb-2 d-flex flex-row">
                         <h4 class="pt-3">Last session</h4>

                         <span class="visitorLogIcons ms-5 pt-3">
                       <?php
                       $sql_last_log = "SELECT * FROM login_logs where UserID = $uid order by Login desc limit 1;";
$result_last_log = mysqli_query($conn, $sql_last_log);
if (mysqli_num_rows($result_last_log) > 0) { 
    while($row_last_log= mysqli_fetch_assoc($result_last_log)){;
                       ?>
                        <span class="visitorLogIconWithDetails">
                        <img src="../../images/icons/<?php if(file_exists('../../images/icons/flags/' . $row_last_log['CountryCode'] . '.svg'))
            echo 'flags/' . $row_last_log['CountryCode'] . '.svg'; 
            else echo 'Unknown.png';
            ?>" data-tippy-content="<ul>
            <li>Country: <?=$row_last_log['Country'];?></li>
            <li>Region: <?=$row_last_log['Region'];?></li>                
            <li>City: <?=$row_last_log['City'];?></li>                                        
             <li>IP: <?=$row_last_log['IP'];?></li>
        </ul>">
                        </span>
                        <?php switch ($row_last_log['Browser']) {
                case "Chrome": $browser =  "Chrome.png";
                  break;
                case "Edge":
                  $browser =  "Edge.png";
                  break;
                case "Firefox":
                  $browser =  "Firefox.png";
                  break;
                case "Safari":
                  $browser =  "Safari.png";
                  break;
                case "Internet Explorer":
                  $browser =  "IE.png";
                  break;
                case "Opera":
                  $browser =  "Opera.png";
                  break;
                default:
                  $browser =  "Unknown.png";
              }?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$browser?>" data-tippy-content="<ul>
            <li>Browser: <?=$row_last_log['Browser'];?></li>
            </ul>">
                        </span>
                        <?php 
                if(str_contains($row_last_log['OS'], 'Android')) 
                  {$os =  "Android.png";}
                else if(str_contains($row_last_log['OS'], 'iPhone'))
                  {$os =  "Ios.png";}
                else if(str_contains($row_last_log['OS'], 'Linux'))
                  $os =  "Linux.png";
                else if(str_contains($row_last_log['OS'], 'Mac'))
                  $os =  "Mac.png";
                else if(str_contains($row_last_log['OS'], 'Ubuntu'))
                  $os =  "Ubuntu.png";
                else if(str_contains($row_last_log['OS'], 'Windows Phone'))
                  $os =  "Windows_phone.png";
                else if(str_contains($row_last_log['OS'], 'Windows'))
                  $os =  "Windows.png";
                else $os =  "Unknown.png";
              ?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$os?>" data-tippy-content="<ul>
            <li>Operating system: <?=$row_last_log['OS'];?></li>
            </ul>">
                        </span>

                        <?php switch ($row_last_log['Device']) {
                case "Desktop": 
                  $device =  "Desktop.png";
                  break;
                case "Mobile":
                  $device =  "Mobile.png";
                  break;
                default:
                  $device =  "Unknown.png";
              }?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$device?>" data-tippy-content="<ul>
            <li>Device type: <?=$row_last_log['Device'];?></li>          
            </ul>">
                        </span>
</span>
<?php } } else echo '<span class="text-muted">No info available</span>'?>

                        
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
                        if($row['Role']=='User') {
                          $sql_user_pg = "SELECT count(ID) as total_pgs FROM session_logs where UserID = $uid;";
                          $result_user_pg = mysqli_query($conn, $sql_user_pg);
                         if (mysqli_num_rows($result_user_pg) > 0)  $row_user_pg = mysqli_fetch_assoc($result_user_pg);
                        echo '<p>This user logged in ' . $row['total_logs'] .' times, viewed '. $row_user_pg['total_pgs'] .' pages and spent a total of '.$total_time . ' on the website.</p>';
                        }
                        else {
                          $sql_user_pg = "SELECT count(distinct PageID) as total_pgs, count(ID) as total_actions FROM admin_session_logs where UserID = $uid;";
                          $result_user_pg = mysqli_query($conn, $sql_user_pg);
                         if (mysqli_num_rows($result_user_pg) > 0)  $row_user_pg = mysqli_fetch_assoc($result_user_pg);
                        echo '<p>This user logged in ' . $row['total_logs'] .' times, did '. $row_user_pg['total_actions'] .' actions on '. $row_user_pg['total_pgs'] .' pages and spent a total of '.$total_time . ' on the website.</p>';}
                        ?>
                                                                                  
                        <div class="d-flex flex-row mb-1 mt-3">
  <div class="p-2"><h5>Creation</h5> <p><?php $date=date_create($row['CreationDate']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span></p></div>
  <div class="ms-auto p-2"><h5>Verification</h5><p><?php if(is_null($row['VerificationDate']))
                                    {echo '<span class="'.'text-muted'.'">Account not verified</span>';} else { 
                                    $date=date_create($row['VerificationDate']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span><?php }?></p></div>
</div>
                        
                        <div class="d-flex flex-row mb-1">
  <div class="p-2"><h5>First login</h5> <p><?php if(is_null($row['first_log']))
                                    {echo '<span class="'.'text-muted'.'">User never logged in</span>';} else { 
                                    $date=date_create($row['first_log']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span><?php }?></p></div>
  <div class="ms-auto p-2"><h5>Last login</h5><p><?php if(is_null($row['LastLogin']))
                                    {echo '<span class="'.'text-muted'.'">-</span>';} else { 
                                    $date=date_create($row['LastLogin']);
                                    echo date_format($date,"l, d-m-Y"); 
                                    $diff = date_diff(new DateTime(), $date)?> <span class="text-muted"> - <?=$diff->format("%a")?> days ago</span><?php }?></p></div>
</div>

<div class="mb-1">
  <?php
   $sql_device = "SELECT Device, count(ID) as nr from login_logs where UserID = $uid group by Device;";
   $result_device = mysqli_query($conn, $sql_device);
  ?>
  <div class="p-2"><h5>Devices</h5>
  <?php    if (mysqli_num_rows($result_device) > 0)  { 
  while($row_device = mysqli_fetch_assoc($result_device)){ ?> 
  <p><?php if($row_device['Device'] == 'Desktop') $img = 'Desktop.png'; else if($row_device['Device'] == 'Mobile') $img = 'Mobile.png'; else $img = 'Unknown.png';
  echo '<img style="width:1rem; margin-right:0.7rem;" src="../../images/icons/'.$img.'">' . $row_device['nr'] . ' logins from '. $row_device['Device'];?></p>
<?php  } } else echo '<p class="text-muted"> - </p>'; ?></div>
</div>

<div class="mb-1">
<?php
   $sql_country = "SELECT Country, CountryCode, count(ID) as nr from login_logs where UserID = $uid group by Country;";
   $result_country = mysqli_query($conn, $sql_country);
  ?>
  <div class="p-2"><h5>Locations</h5> 
  <?php     if (mysqli_num_rows($result_country) > 0)  {
  while($row_country = mysqli_fetch_assoc($result_country)){ ?> 
    <p><?php 
    if (file_exists('../../images/icons/flags/'.$row_country['CountryCode'].'.svg')) $flag = $row_country['CountryCode']; else $flag = 'xx';
    echo $row_country['nr'] . ' logins from '. $row_country['Country'].
    '<img style="width:1.3rem; margin-left:0.6rem; bottom:50px;" src="../../images/icons/flags/'. $flag.'.svg">';?></p>
<?php  }} else echo '<p class="text-muted"> - </p>'; ?></div>
</div>
               
</div>
                      
                      
                     
<div class="text-center">
                      <button class="btn btn-danger btn-block mb-2 mx-2"><a href="javascript:UserStatus('<?php echo $row['Is_Active']; ?>',
                        '<?php echo $row['Id']; ?>')">
                        <?php if ($row['Is_Active'] == 'Yes') {echo "Disable";} else {echo "Enable";}?>
                        </a></button>
</div>
                    </div>
                    <div class="col-lg-7">
                    <?php
                    $sql_session =  "SELECT RANK() OVER (order by Login) as row_nr, Login, ID, Browser, OS, Device FROM login_logs WHERE Status ='Success' AND UserID = $uid ORDER BY Login desc;";
                    $result_session = mysqli_query($conn, $sql_session);
                    ?>
                    <div class="mt-4">
                    <div class="accordion accordion-bordered" id="accordion-2" role="tablist">
                     <?php
                     if (mysqli_num_rows($result_session) > 0) { 
                      while($row_session = mysqli_fetch_assoc($result_session)) {
                        ?>
                      <div class="card">
                        <div class="card-header" role="tab" id="heading-<?=$row_session['row_nr']?>">
                          <h6 class="mb-0">
                            <a data-bs-toggle="collapse" href="#collapse-<?=$row_session['row_nr']?>" aria-expanded="false" aria-controls="collapse-<?=$row_session['row_nr']?>" class="collapsed">
                              
                              <div class="d-flex flex-row">
                              <div class="px-2">Session <?=$row_session['row_nr']?></div>
                               <div class="ms-auto px-2 mx-2"><?php $date=date_create($row_session['Login']);
                      echo date_format($date,"l, d F Y") . " " . date_format($date,"H:i:s"); ?></div>
                              </div>
                            </a>
                          </h6>
                        </div>
                        <div id="collapse-<?=$row_session['row_nr']?>" class="collapse" role="tabpanel" aria-labelledby="heading-<?=$row_session['row_nr']?>" data-parent="#accordion-2" style="">
                          <div class="card-body">
                          <div class="d-flex mb-2">
  <div class="p-2">
  <span class="visitorLogIcons ms-5 pt-3">
  <?php switch ($row_session['Browser']) {
                case "Chrome": $browser =  "Chrome.png";
                  break;
                case "Edge":
                  $browser =  "Edge.png";
                  break;
                case "Firefox":
                  $browser =  "Firefox.png";
                  break;
                case "Safari":
                  $browser =  "Safari.png";
                  break;
                case "Internet Explorer":
                  $browser =  "IE.png";
                  break;
                case "Opera":
                  $browser =  "Opera.png";
                  break;
                default:
                  $browser =  "Unknown.png";
              }?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$browser?>" data-tippy-content="<ul>
            <li>Browser: <?=$row_session['Browser'];?></li>
            </ul>">
                        </span>

                        <?php 
                if(str_contains($row_session['OS'], 'Android')) 
                  {$os =  "Android.png";}
                else if(str_contains($row_session['OS'], 'iPhone'))
                  {$os =  "Ios.png";}
                else if(str_contains($row_session['OS'], 'Linux'))
                  $os =  "Linux.png";
                else if(str_contains($row_session['OS'], 'Mac'))
                  $os =  "Mac.png";
                else if(str_contains($row_session['OS'], 'Ubuntu'))
                  $os =  "Ubuntu.png";
                else if(str_contains($row_session['OS'], 'Windows Phone'))
                  $os =  "Windows_phone.png";
                else if(str_contains($row_session['OS'], 'Windows'))
                  $os =  "Windows.png";
                else $os =  "Unknown.png";
              ?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$os?>" data-tippy-content="<ul>
            <li>Operating system: <?=$row_session['OS'];?></li>
            </ul>">
                        </span>

                        <?php switch ($row_session['Device']) {
                case "Desktop": 
                  $device =  "Desktop.png";
                  break;
                case "Mobile":
                  $device =  "Mobile.png";
                  break;
                default:
                  $device =  "Unknown.png";
              }?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$device?>" data-tippy-content="<ul>
            <li>Device type: <?=$row_session['Device'];?></li>          
            </ul>">
                        </span>
                      
    </span>
  </div>
  <div class="ms-auto p-2">
    <?php
     $lg_id = $row_session['ID']; 
    if($row['Role']=='User'){
      $sql_actionsnr = "SELECT count(ID) as total_actions FROM session_logs where Log_ID = $lg_id;";
      $result_actionsnr = mysqli_query($conn, $sql_actionsnr);
      $actions_nr = mysqli_fetch_assoc($result_actionsnr);
      echo $lg_id;
      if ($actions_nr['total_actions'] == 1)
      echo $actions_nr['total_actions'] . " action";
      else
      echo $actions_nr['total_actions'] . " actions";
    }else{
      $sql_actionsnr = "SELECT count(ID) as total_actions FROM admin_session_logs where Log_ID = $lg_id;";
      $result_actionsnr = mysqli_query($conn, $sql_actionsnr);
      $actions_nr = mysqli_fetch_assoc($result_actionsnr);
      if ($actions_nr['total_actions'] == 1)
      echo $actions_nr['total_actions'] . " action";
      else
      echo $actions_nr['total_actions'] . " actions";
    }
    ?>
  </div>
</div>
<div class="d-flex justify-content-center mt-2">
<ul class="bullet-line-list">
<?php 
 $lg_id = $row_session['ID'];
if($row['Role']=='User'){
                    $sql_actions = "SELECT PageID, URI, Start_Time, Time_Spent, Event_Description FROM session_logs where Log_ID = $lg_id;";
                    $result_actions = mysqli_query($conn, $sql_actions);
                    if (mysqli_num_rows($result_actions) > 0) {
                      while($actions = mysqli_fetch_assoc($result_actions)) {
                        $pgid = $actions['PageID'];
                        $start_time = date_format(date_create($actions['Start_Time']),"d M Y H:i:s");
                        $pg_total_time = $actions['Time_Spent'];
                        $hours = floor($pg_total_time / 3600);
                        $minutes = floor(($pg_total_time / 60) % 60);
                        $seconds = $pg_total_time % 60;
                        if($hours > 0) $pg_time =  $hours . 'h ' . $minutes . ' mins ' . $seconds . 's';
                        else if ($minutes > 0) $pg_time = $minutes . ' mins ' . $seconds . 's';
                        else if ($seconds > 0) $pg_time = $seconds . 's';
                        else $pg_time = '0s';
                        $sql_pg_name = "SELECT Title FROM pages where ID = $pgid;";
                        $resultpg = mysqli_query($conn, $sql_pg_name);
                        $pg = mysqli_fetch_assoc($resultpg);
                    echo '<li class="mb-3">
											<p data-tippy-content="<ul>
                      <li>'. $start_time .'</li>
                      <li>Time on page: ' . $pg_time . '</li>
                      <li>Event: ' .$actions['Event_Description'] . '</li>
                      </ul>">'.$pg['Title'].'</p>
											<a href="'. $actions['URI'] .'">' . substr($actions['URI'],49) . '</a>
										</li>'; 
                } }
            } else {
              $sql_actions = "SELECT PageID, URI, Date, Event_Description FROM admin_session_logs where Log_ID = $lg_id;";
                    $result_actions = mysqli_query($conn, $sql_actions);
                    if (mysqli_num_rows($result_actions) > 0) {
                      while($actions = mysqli_fetch_assoc($result_actions)) {
                        $pgid = $actions['PageID'];
                        $start_time = date_format(date_create($actions['Date']),"d M Y H:i:s");
                        $sql_pg_name = "SELECT Title FROM pages where ID = $pgid;";
                        $resultpg = mysqli_query($conn, $sql_pg_name);
                        $pg = mysqli_fetch_assoc($resultpg);
                    echo '<li class="mb-3">
											<p data-tippy-content="<ul>
                      <li>'. $start_time .'</li>
                      <li>Event: ' .$actions['Event_Description'] . '</li>
                      </ul>">'.$pg['Title'].'</p>
											<a href="'. $actions['URI'] .'">' . substr($actions['URI'],49) . '</a>
										</li>'; 
            } }
          }
            ?>
  </ul>
</div>
                          </div>
                        </div>
                      </div>
                      
                      <?php } } else echo'<h5 class="text-muted text-center">No sessions to display</h5>'?>
                    </div>
                  </div>

                  </div>   <!-- end col-lg-7-->

                </div>
              </div>
            </div>
          </div>
                                  </div>
<?php }
else {
    echo "User doesn't exist!";
  } ?>
  
<?php include_once 'footer.php';?>
<script>
                    tippy('[data-tippy-content]', {
                        content: 'Global content',
                        allowHTML: true,
                        placement: 'bottom-start',
                        arrow: false
                    });
                    </script>