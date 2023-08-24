<?php include_once 'layout.php';
      require_once '../assets/connection.php';
?>
<div class="d-flex">
<div id="reportrange" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>
<div class="d-inline-block ms-5">
<select id="rolelog">
  <option selected value="User">User</option>
  <option value="Admin">Admin</option>
</select>
</div> 
</div>

<p class="card-title mb-5"> Sessions log </p>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<div class="col-12" id="logpage">
    <?php   function bringdata($startdate, $enddate, $role){
        require '../assets/connection.php';
      $sql = "SELECT l.* FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate';";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) { 
      while($row = mysqli_fetch_assoc($result)) {?>

    <div class="squarecard">
        <div class="row">
            <div class="col-md-4">
                <div class="card-body">
                  <?php
                   $umail = $row['User_Email'];
                   $last_login = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Login FROM login_logs where User_Email = '$umail' order by Login desc;"));
                  $days_diff = date_diff(date_create(),date_create($last_login['Login']));
                  $last_login_days = $days_diff->format("%a days");
                  ?>
                    <h4 class="card-titlesmall" data-tippy-content="This user's last login was <?=$last_login_days?> ago.">
                        <?php
                      $date=date_create($row['Login']);
                      echo date_format($date,"l, d F Y") . " - " . date_format($date,"H:i:s");
                      ?>
                    </h4>
                    <?php
                    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Username, Image, Role FROM users where Email = '$umail';"));
                    echo '<img style = "width: 10%; margin-right:.5rem;" class = "rounded-circle" src="../../images/user_uploads/'. $user['Image'] .'"></img>'. $user['Username'];
                   ?>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-body">

                    <?php
                    $sql_count = "SELECT count(ID) as total FROM login_logs where User_Email = '$umail';";
                    $result_count = mysqli_query($conn, $sql_count);
                    $logins_nr = mysqli_fetch_assoc($result_count);
                    if($logins_nr['total'] == 1) {
                     $userimg = "singleuser.png";
                     $nr = "One time user - " . $logins_nr['total']. " login";}
                     else {
                      $userimg = "user.png";
                      $nr = "Returning user - " . $logins_nr['total']. " logins";}
                     ?>

                    <span class="visitorLogIcons">
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$userimg?>" data-tippy-content="<ul>
                <li><?=$nr?></li>
            </ul>">
                        </span>


                        <span class="visitorLogIconWithDetails">

                            <img src="../../images/icons/<?php if(file_exists('../../images/icons/flags/' . $row['CountryCode'] . '.svg'))
            echo 'flags/' . $row['CountryCode'] . '.svg'; 
            else echo 'Unknown.png';
            ?>" data-tippy-content="<ul>
            <li>Country: <?=$row['Country'];?></li>
            <li>Region: <?=$row['Region'];?></li>                
            <li>City: <?=$row['City'];?></li>                                        
             <li>IP: <?=$row['IP'];?></li>
        </ul>">
                        </span>

                        <?php switch ($row['Browser']) {
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
            <li>Browser: <?=$row['Browser'];?></li>
            </ul>">
                        </span>

                        <?php 
                if(str_contains($row['OS'], 'Android')) 
                  {$os =  "Android.png";}
                else if(str_contains($row['OS'], 'iPhone'))
                  {$os =  "Ios.png";}
                else if(str_contains($row['OS'], 'Linux'))
                  $os =  "Linux.png";
                else if(str_contains($row['OS'], 'Mac'))
                  $os =  "Mac.png";
                else if(str_contains($row['OS'], 'Ubuntu'))
                  $os =  "Ubuntu.png";
                else if(str_contains($row['OS'], 'Windows Phone'))
                  $os =  "Windows_phone.png";
                else if(str_contains($row['OS'], 'Windows'))
                  $os =  "Windows.png";
                else $os =  "Unknown.png";
              ?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$os?>" data-tippy-content="<ul>
            <li>Operating system: <?=$row['OS'];?></li>
            </ul>">
                        </span>

                        <?php switch ($row['Device']) {
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
            <li>Device type: <?=$row['Device'];?></li>          
            </ul>">
                        </span>

                    </span>
                    
                </div>
            </div>

            <div class="col-md-5">
                <div class="card-body">
                    <h4 class="card-titlesmall">
                        <?php
                        $uid = $row['ID'];
                       if($user['Role'] == 'User')
                        $sql_actionsnr = "SELECT count(ID) as total_actions FROM session_logs where Log_ID = $uid;";
                       else $sql_actionsnr = "SELECT count(ID) as total_actions FROM admin_session_logs where Log_ID = $uid;";
                        $result_actionsnr = mysqli_query($conn, $sql_actionsnr);
                        $actions_nr = mysqli_fetch_assoc($result_actionsnr);
                        $login = date_create($row['Login']);
                        $logout = date_create($row['Logout']);
                        $time_spent = date_diff($logout,$login);
                        if(!is_null($row['Logout'])){
                        if($time_spent->h > 0){
                        echo $actions_nr['total_actions'] . " actions - " . $time_spent->h . "h " . $time_spent->i . " mins " . $time_spent->s . "s";
                        }
                        else if($time_spent->i > 0) {
                            echo $actions_nr['total_actions'] . " actions - " . $time_spent->i . " mins " . $time_spent->s . "s";
                          }
                        else if($time_spent->s > 0) {
                            echo $actions_nr['total_actions'] . " actions - " . $time_spent->s . "s";
                          }
                        }
                        else {
                          echo $actions_nr['total_actions'] . " actions";
                        }

                        ?>
                    </h4>

                    <ul class="bullet-line-list">
                        <?php 
                        if($user['Role'] == 'User'){
                    $sql_actions = "SELECT PageID, URI, Start_Time, Time_Spent, Event_Description FROM session_logs where Log_ID = $uid;";
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
                }
              } }
              else{
                $sql_actions = "SELECT PageID, URI, Date, Event_Description FROM admin_session_logs where Log_ID = $uid;";
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
            }
          }
              }
              ?>
                    </ul>
                </div>
            </div>

        </div>

        <script>
                    tippy('[data-tippy-content]', {
                        content: 'Global content',
                        allowHTML: true,
                        placement: 'bottom-start',
                        arrow: false
                    });
                    </script>
    </div>
<!--
<div>
<table id="ses_log" class="datatables-users display expandable-table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Date</th>
                                        <th>City/Region/Country</th>
                                        <th>Browser</th>
                                        <th>OS</th>
                                        <th>Device</th>
                                        <th>Actions</th>
                                        <th>Time spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $user['Username']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
</div>
                  -->
    <?php }}     }
if (isset($_POST['sdate'])) {
  bringdata($_POST['sdate'],$_POST['edate'], $_POST['role']);
}
else {
  date_default_timezone_set('Europe/Bucharest');
  bringdata(date("Y-m-d"),date("Y-m-d"),'User');
}
?>
</div>


<?php include_once 'footer.php';?>

