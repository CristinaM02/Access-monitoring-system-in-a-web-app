<?php include_once 'layout.php';
      require_once '../assets/connection.php';
      
      $sql = "SELECT * FROM login_logs where Status = 'Error';";
      $result = $conn->query($sql);
      $arr_rows = [];
      if ($result->num_rows > 0) {
          $arr_rows = $result->fetch_all(MYSQLI_ASSOC);
      }
      ?>


<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Logon attempts</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="logon_attempts" class="datatables-logattempts display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>User info</th>
                                        <th>Location</th>
                                        <th>Browser</th>
                                        <th>OS</th> 
                                        <th>Device</th>                            
                                        <th>Date</th>
                                        <th>Error reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($arr_rows)) { ?>
                                    <?php foreach($arr_rows as $log) { ?>
                                    <tr>
                                        <td><?=$log['User_Email']; ?></td>
                                        <td>
                                        <span class="visitorLogIcons">

                                        <span class="visitorLogIconWithDetails">

                            <img src="../../images/icons/<?php if(file_exists('../../images/icons/flags/' . $log['CountryCode'] . '.svg'))
            echo 'flags/' . $log['CountryCode'] . '.svg'; 
            else echo 'Unknown.png';
            ?>" data-toggle="tooltip" data-bs-placement="bottom" title="<ul>
            <li>Country: <?=$log['Country'];?></li>
            <li>Region: <?=$log['Region'];?></li>                
            <li>City: <?=$log['City'];?></li>                                        
             <li>IP: <?=$log['IP'];?></li>
        </ul>">
                        </span>

                        <?php switch ($log['Browser']) {
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
                            <img src="../../images/icons/<?=$browser?>" data-toggle="tooltip" data-bs-placement="bottom" title="<ul>
            <li>Browser: <?=$log['Browser'];?></li>
            </ul>">
                        </span>

                        <?php 
                if(str_contains($log['OS'], 'Android')) 
                  {$os =  "Android.png";}
                else if(str_contains($log['OS'], 'iPhone'))
                  {$os =  "Ios.png";}
                else if(str_contains($log['OS'], 'Linux'))
                  $os =  "Linux.png";
                else if(str_contains($log['OS'], 'Mac'))
                  $os =  "Mac.png";
                else if(str_contains($log['OS'], 'Ubuntu'))
                  $os =  "Ubuntu.png";
                else if(str_contains($log['OS'], 'Windows Phone'))
                  $os =  "Windows_phone.png";
                else if(str_contains($log['OS'], 'Windows'))
                  $os =  "Windows.png";
                else $os =  "Unknown.png";
              ?>
                        <span class="visitorLogIconWithDetails">
                            <img src="../../images/icons/<?=$os?>" data-toggle="tooltip" data-bs-placement="bottom" title="<ul>
            <li>Operating system: <?=$log['OS'];?></li>
            </ul>">
                        </span>

                        <?php switch ($log['Device']) {
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
                            <img src="../../images/icons/<?=$device?>" data-toggle="tooltip" data-bs-placement="bottom" title="<ul>
            <li>Device type: <?=$log['Device'];?></li>          
            </ul>">
                        </span>

                                    </span>

                                    
                                        </td>
                                        <td><?=$log['Country'] . ' - ' . $log['Region'] . ' - ' . $log['City']; ?></td>
                                        <td><?=$log['Browser']; ?></td>
                                        <td><?=$log['OS']; ?></td>
                                        <td><?=$log['Device']; ?></td>
                                        <td><?php $date=date_create($log['Login']);
                                            echo date_format($date,"d-m-Y H:i:s"); ?></td>
                                        <td><?=$log['Error']; ?></td>
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

