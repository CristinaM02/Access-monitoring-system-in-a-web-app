<?php include_once 'layout.php';
      require_once '../assets/connection.php';
      
      $sql = "SELECT * FROM login_logs where Status ='Success' AND date(Login) = CURDATE() AND Logout IS NULL;";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
      ?>

<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Logged users in real time</p>
                <div class="row">
                    <div class="col-12">
                            <div class="table-responsive pt-3">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th style="width: 85%">Date</th>
                                            <th>User logins</th>
                                            <th>Users actions</th>
                                            <th>Admin logins</th>
                                            <th>Admins actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Last 30 minutes</td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "SELECT count(l.ID) as total_logins FROM login_logs l inner join users u on u.ID = l.UserID WHERE Status ='Success' AND Role = 'User' AND Login >= DATE_SUB(now(), INTERVAL 30 MINUTE)";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_logins'];
                                            ?>
                                            </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "select (SELECT count(ID) as total_actions FROM session_logs WHERE Log_ID in (SELECT ID FROM login_logs WHERE Status ='Success' AND Login >= DATE_SUB(now(), INTERVAL 30 MINUTE)))+ (SELECT count(ID) as total_actions FROM outlinks WHERE Date >= DATE_SUB(now(), INTERVAL 30 MINUTE)) total_actions;";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_actions'];
                                            ?>
                                            </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "SELECT count(l.ID) as total_logins FROM login_logs l inner join users u on u.ID = l.UserID WHERE Status ='Success' AND Role = 'Admin' AND Login >= DATE_SUB(now(), INTERVAL 30 MINUTE);";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_logins'];
                                            ?>
                                            </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "SELECT count(ID) as total_actions FROM admin_session_logs WHERE Log_ID in (SELECT ID FROM login_logs WHERE Status ='Success' AND Login >= DATE_SUB(now(), INTERVAL 30 MINUTE));";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_actions'];
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Last 24 hours </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "SELECT count(l.ID) as total_logins FROM login_logs l inner join users u on u.ID = l.UserID WHERE Status ='Success' AND Role = 'User' AND Login >= DATE_SUB(now(), INTERVAL 1 DAY);";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_logins'];
                                            ?>
                                            </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "select (SELECT count(ID) as total_actions FROM session_logs WHERE Log_ID in (SELECT ID FROM login_logs WHERE Status ='Success' AND Login >= DATE_SUB(now(), INTERVAL 1 DAY)))+ (SELECT count(ID) as total_actions FROM outlinks WHERE Date >= DATE_SUB(now(), INTERVAL 1 DAY)) total_actions;";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_actions'];
                                            ?>
                                            </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "SELECT count(l.ID) as total_logins FROM login_logs l inner join users u on u.ID = l.UserID WHERE Status ='Success' AND Role = 'Admin' AND Login >= DATE_SUB(now(), INTERVAL 1 DAY);";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_logins'];
                                            ?>
                                            </td>
                                            <td class="text-center">
                                            <?php
                                            $sql_count = "SELECT count(ID) as total_actions FROM admin_session_logs WHERE Log_ID in (SELECT ID FROM login_logs WHERE Status ='Success' AND Login >= DATE_SUB(now(), INTERVAL 1 DAY));";
                                            $result_count = mysqli_query($conn, $sql_count);
                                            $row_count = mysqli_fetch_assoc($result_count);
                                            echo $row_count['total_actions'];
                                            ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                                <table class="table table-sm">
                                    <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) {?>
                                        <tr class="table-grey">
                                            <td style="width: 30%;">
                                                <?php
                                                $umail = $row['User_Email'];
                                                $role = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Role from users where Email = '$umail';"));
                                                $uid = $row['ID'];
                                                $date=date_create($row['Login']);
                                                if($role['Role'] == 'User')
                                                $sql_actionsnr = "SELECT count(ID) as total_actions FROM session_logs where Log_ID = $uid;";
                                                else  $sql_actionsnr = "SELECT count(ID) as total_actions FROM admin_session_logs where Log_ID = $uid;";
                                                $result_actionsnr = mysqli_query($conn, $sql_actionsnr);
                                                $actions_nr = mysqli_fetch_assoc($result_actionsnr);

                                                
                                                if($actions_nr['total_actions'] > 0 && $role['Role'] == 'User'){
                                                $sql_pg = "SELECT sum(Time_spent) as time_spent FROM session_logs where Log_ID = $uid;";
                                                $result_pg = mysqli_query($conn, $sql_pg);
                                                $pg_total_time = mysqli_fetch_assoc($result_pg);
                                                $hours = floor($pg_total_time['time_spent'] / 3600);
                                                $minutes = floor(($pg_total_time['time_spent'] / 60) % 60);
                                                 $seconds = $pg_total_time['time_spent'] % 60;
                                                 if($hours > 0) $pg_time =  $hours . 'h ' . $minutes . ' mins ' . $seconds . 's';
                                                 else if ($minutes > 0) $pg_time = $minutes . ' mins ' . $seconds . 's';
                                                 else if ($seconds > 0) $pg_time = $seconds . 's';
                                                 else $pg_time = '0s';
                                                echo date_format($date,"l, d F Y") . " - " . date_format($date,"H:i:s") . " (" . $actions_nr['total_actions'] ." actions - " . $pg_time . ")";
                                                }
                                                else{
                                                    echo date_format($date,"l, d F Y") . " - " . date_format($date,"H:i:s") . " (" . $actions_nr['total_actions'] ." actions)";
                                                }
                                              
                                                ?>
                                            </td>

                                            <td>
                                            <span class="visitorLogIcons" style="top: 3px;">
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
                        <span class="visitorLogIconWithDetails">
                            <img class="ico" src="../../images/icons/<?=$userimg?>" data-tippy-content="<ul>
                <li><?=$nr?></li>
            </ul>">
                        </span>

                        <span class="visitorLogIconWithDetails">

<img class="ico" src="../../images/icons/<?php if(file_exists('../../images/icons/flags/' . $row['CountryCode'] . '.svg'))
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
                            <img class="ico" src="../../images/icons/<?=$browser?>" data-tippy-content="<ul>
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
                            <img class="ico" src="../../images/icons/<?=$os?>" data-tippy-content="<ul>
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
                            <img class="ico" src="../../images/icons/<?=$device?>" data-tippy-content="<ul>
            <li>Device type: <?=$row['Device'];?></li>          
            </ul>">
                        </span>

                     </span>
                     </td>
                                        </tr>
                                        <?php } } 
                                        else  echo '<h5 class="mt-4 text-center">There is no user currently logged in!</h5>';
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php';?>

<script>
                    tippy('[data-tippy-content]', {
                        content: 'Global content',
                        allowHTML: true,
                        placement: 'bottom-start',
                        arrow: false
                    });
                    </script>