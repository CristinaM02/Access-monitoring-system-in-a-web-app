<?php include_once 'layout.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

<div class="d-flex">
<div id="rangetimes" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>
<div class="d-inline-block ms-5">
<select id="roletimes">
  <option selected value="User">User</option>
  <option value="Admin">Admin</option>
</select>
</div> </div>
<div class="row" id="times">
<?php   function bringdata($startdate, $enddate, $role){ 
    require_once '../assets/connection.php';?>
    <div class="col-12 col-md-6">
        <div class="row">
            
            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <p class="card-title">Logins per time</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "os_tbl">
                        <table id="hours" class="datatables-hours display expandable-table" style="width:100%">
                        <?php
                        $sql = "SELECT HOUR(Login) as hour, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' and DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY HOUR(Login);";
                        $result = mysqli_query($conn, $sql);
                        $hours = [];
                        while($row = mysqli_fetch_assoc($result)){
                        $hours[$row['hour']] = $row['nr'];
                        }                       
                        ?>
                                <thead>
                                    <tr>
                                        <th>Hour</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                    <tr>
                                <td>
                                       00
                                </td>
                                <td>
                                    <?php echo (array_key_exists(0, $hours)) ? $hours['0'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                01
                                </td>
                                <td>
                                <?php echo (array_key_exists(1, $hours)) ? $hours['1'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                02
                                </td>
                                <td>
                                <?php echo (array_key_exists(2, $hours)) ? $hours['2'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                03
                                </td>
                                <td>
                                <?php echo (array_key_exists(3, $hours)) ? $hours['3'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                04
                                </td>
                                <td>
                                <?php echo (array_key_exists(4, $hours)) ? $hours['4'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                05
                                </td>
                                <td>
                                <?php echo (array_key_exists(5, $hours)) ? $hours['5'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                06
                                </td>
                                <td>
                                <?php echo (array_key_exists(6, $hours)) ? $hours['6'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                07
                                </td>
                                <td>
                                <?php echo (array_key_exists(7, $hours)) ? $hours['7'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                08
                                </td>
                                <td>
                                <?php echo (array_key_exists(8, $hours)) ? $hours['8'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                09
                                </td>
                                <td>
                                <?php echo (array_key_exists(9, $hours)) ? $hours['9'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                10
                                </td>
                                <td>
                                <?php echo (array_key_exists(10, $hours)) ? $hours['10'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                11
                                </td>
                                <td>
                                <?php echo (array_key_exists(11, $hours)) ? $hours['11'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                12
                                </td>
                                <td>
                                <?php echo (array_key_exists(12, $hours)) ? $hours['12'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                13
                                </td>
                                <td>
                                <?php echo (array_key_exists(13, $hours)) ? $hours['13'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                14
                                </td>
                                <td>
                                <?php echo (array_key_exists(14, $hours)) ? $hours['14'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                15
                                </td>
                                <td>
                                <?php echo (array_key_exists(15, $hours)) ? $hours['15'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                16
                                </td>
                                <td>
                                <?php echo (array_key_exists(16, $hours)) ? $hours['16'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                17
                                </td>
                                <td>
                                <?php echo (array_key_exists(17, $hours)) ? $hours['17'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                18
                                </td>
                                <td>
                                <?php echo (array_key_exists(18, $hours)) ? $hours['18'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                19
                                </td>
                                <td>
                                <?php echo (array_key_exists(19, $hours)) ? $hours['19'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                20
                                </td>
                                <td>
                                <?php echo (array_key_exists(20, $hours)) ? $hours['20'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                21
                                </td>
                                <td>
                                <?php echo (array_key_exists(21, $hours)) ? $hours['21'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                22
                                </td>
                                <td>
                                <?php echo (array_key_exists(22, $hours)) ? $hours['22'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                23
                                </td>
                                <td>
                                <?php echo (array_key_exists(23, $hours)) ? $hours['23'] : "0"; ?>
                                </td>
</tr>
</tbody>
</table>
</div>
<div id="os_pie" style="display: none;">
<canvas id="times_p" width="400" height="400"></canvas>
<script>
 ctx1 = document.getElementById('times_p');
 times_p = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
        datasets: [{
            label: 'Times',
            data: [
              <?php echo (array_key_exists(0, $hours)) ? $hours['0'] : "0"; ?>,
              <?php echo (array_key_exists(1, $hours)) ? $hours['1'] : "0"; ?>,
              <?php echo (array_key_exists(2, $hours)) ? $hours['2'] : "0"; ?>,
              <?php echo (array_key_exists(3, $hours)) ? $hours['3'] : "0"; ?>,  
              <?php echo (array_key_exists(4, $hours)) ? $hours['4'] : "0"; ?>, 
              <?php echo (array_key_exists(5, $hours)) ? $hours['5'] : "0"; ?>,   
              <?php echo (array_key_exists(6, $hours)) ? $hours['6'] : "0"; ?>,            
              <?php echo (array_key_exists(7, $hours)) ? $hours['7'] : "0"; ?>,  
              <?php echo (array_key_exists(8, $hours)) ? $hours['8'] : "0"; ?>,
              <?php echo (array_key_exists(9, $hours)) ? $hours['9'] : "0"; ?>,
              <?php echo (array_key_exists(10, $hours)) ? $hours['10'] : "0"; ?>,
              <?php echo (array_key_exists(11, $hours)) ? $hours['11'] : "0"; ?>, 
              <?php echo (array_key_exists(12, $hours)) ? $hours['12'] : "0"; ?>,  
              <?php echo (array_key_exists(13, $hours)) ? $hours['13'] : "0"; ?>,    
              <?php echo (array_key_exists(14, $hours)) ? $hours['14'] : "0"; ?>,            
              <?php echo (array_key_exists(15, $hours)) ? $hours['15'] : "0"; ?>,
              <?php echo (array_key_exists(16, $hours)) ? $hours['16'] : "0"; ?>,
              <?php echo (array_key_exists(17, $hours)) ? $hours['17'] : "0"; ?>,  
              <?php echo (array_key_exists(18, $hours)) ? $hours['18'] : "0"; ?>,  
              <?php echo (array_key_exists(19, $hours)) ? $hours['19'] : "0"; ?>,    
              <?php echo (array_key_exists(20, $hours)) ? $hours['20'] : "0"; ?>,            
              <?php echo (array_key_exists(21, $hours)) ? $hours['21'] : "0"; ?>,  
              <?php echo (array_key_exists(22, $hours)) ? $hours['22'] : "0"; ?>, 
              <?php echo (array_key_exists(23, $hours)) ? $hours['23'] : "0"; ?>
            ],
            backgroundColor: ['rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 206, 86)','rgb(75, 192, 192)','rgb(153, 102, 255)','rgb(255, 159, 64)','rgb(250,128,114)','rgb(211,84,0)','rgb(39,55,70)','rgb(25,111,61)', 'rgb(171, 178, 185)', 'rgb(171, 235, 198 )', 'rgb(241, 148, 138)', 'rgb(113, 125, 126)', 'rgb(203, 67, 53)', 'rgb(125, 102, 8)', 'rgb(0, 255, 0)', 'rgb(255, 0, 255)', 'rgb(128, 0, 128)', 'rgb(176,196,222)', 'rgb(0, 255, 255)', 'rgb(188,143,143)', 'rgb(255,228,181)', 'rgb(255,239,213)', 'rgb(189,183,107)']
        }]
    },
    options: {
        responsive: true,
        plugins: {
      labels: {
    render: 'percentage',
    fontColor: '#fff',
    fontStyle: 'normal',
    fontSize: 15,
    position: 'border',
    precision: 2
  }
        }
    }
});
</script>
</div>

<div id="os_bar" style="display: none;">
<canvas id="times_b" width="400" height="400"></canvas>
<script>
 ctx2 = document.getElementById('times_b');
 times_b = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
        datasets: [{
            label: 'Unique users',
            data: [
              <?php echo (array_key_exists(0, $hours)) ? $hours['0'] : "0"; ?>,
              <?php echo (array_key_exists(1, $hours)) ? $hours['1'] : "0"; ?>,
              <?php echo (array_key_exists(2, $hours)) ? $hours['2'] : "0"; ?>,
              <?php echo (array_key_exists(3, $hours)) ? $hours['3'] : "0"; ?>,  
              <?php echo (array_key_exists(4, $hours)) ? $hours['4'] : "0"; ?>, 
              <?php echo (array_key_exists(5, $hours)) ? $hours['5'] : "0"; ?>,   
              <?php echo (array_key_exists(6, $hours)) ? $hours['6'] : "0"; ?>,            
              <?php echo (array_key_exists(7, $hours)) ? $hours['7'] : "0"; ?>,  
              <?php echo (array_key_exists(8, $hours)) ? $hours['8'] : "0"; ?>,
              <?php echo (array_key_exists(9, $hours)) ? $hours['9'] : "0"; ?>,
              <?php echo (array_key_exists(10, $hours)) ? $hours['10'] : "0"; ?>,
              <?php echo (array_key_exists(11, $hours)) ? $hours['11'] : "0"; ?>, 
              <?php echo (array_key_exists(12, $hours)) ? $hours['12'] : "0"; ?>,  
              <?php echo (array_key_exists(13, $hours)) ? $hours['13'] : "0"; ?>,    
              <?php echo (array_key_exists(14, $hours)) ? $hours['14'] : "0"; ?>,            
              <?php echo (array_key_exists(15, $hours)) ? $hours['15'] : "0"; ?>,
              <?php echo (array_key_exists(16, $hours)) ? $hours['16'] : "0"; ?>,
              <?php echo (array_key_exists(17, $hours)) ? $hours['17'] : "0"; ?>,  
              <?php echo (array_key_exists(18, $hours)) ? $hours['18'] : "0"; ?>,  
              <?php echo (array_key_exists(19, $hours)) ? $hours['19'] : "0"; ?>,    
              <?php echo (array_key_exists(20, $hours)) ? $hours['20'] : "0"; ?>,            
              <?php echo (array_key_exists(21, $hours)) ? $hours['21'] : "0"; ?>,  
              <?php echo (array_key_exists(22, $hours)) ? $hours['22'] : "0"; ?>, 
              <?php echo (array_key_exists(23, $hours)) ? $hours['23'] : "0"; ?>
            ],
            backgroundColor: ['rgba(118, 193, 250)'],
            borderColor: ['rgba(118, 193, 250)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {labels: {render: function (args) {return '';}}},
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</div>
<ul class = "tblicons" >
<li onclick="os_toggle_tbl()"><i class="ti-layout-cta-left"></i></li>
<li onclick="os_toggle_pie()"><i class="ti-pie-chart"></i></li>
<li onclick="os_toggle_bar()"><i class="ti-bar-chart"></i></li>
</ul>
</div>
</div>
</div>

                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="row">
            
            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <p class="card-title">Logins by day of week</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "browser_tbl">
                        <table id="device" class="datatables-device display expandable-table" style="width:100%">
                        <?php
                        $sql = "SELECT dayname(Login) as day, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' and DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY dayname(Login);";
                        $result = mysqli_query($conn, $sql);
                        $days = [];
                        while($row = mysqli_fetch_assoc($result)){
                        $days [$row['day']] = $row['nr'];
                        }                       
                        ?>
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                    <tr>
                                <td>
                                       Monday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Monday', $days)) ? $days['Monday'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                Tuesday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Tuesday', $days)) ? $days['Tuesday'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                Wednesday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Wednesday', $days)) ? $days['Wednesday'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                Thursday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Thursday', $days)) ? $days['Thursday'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                Friday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Friday', $days)) ? $days['Friday'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                Saturday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Saturday', $days)) ? $days['Saturday'] : "0"; ?>
                                </td>
</tr>
<tr>
                                <td>
                                Sunday
                                </td>
                                <td>
                                <?php echo (array_key_exists('Sunday', $days)) ? $days['Sunday'] : "0"; ?>
                                </td>
</tr>
</tbody>
</table>
</div>
<div id="browser_pie" style="display: none;">
<canvas id="days_p" width="400" height="400"></canvas>
<script>
 ctx3 = document.getElementById('days_p');
 days_p= new Chart(ctx3, {
    type: 'pie',
    data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            label: 'Days',
            data: [
              <?php echo (array_key_exists('Monday', $days)) ? $days['Monday'] : "0"; ?>,
          <?php echo (array_key_exists('Tuesday', $days)) ? $days['Tuesday'] : "0"; ?>,
          <?php echo (array_key_exists('Wednesday', $days)) ? $days['Wednesday'] : "0"; ?>,
          <?php echo (array_key_exists('Thursday', $days)) ? $days['Thursday'] : "0"; ?>,  
          <?php echo (array_key_exists('Friday', $days)) ? $days['Friday'] : "0"; ?>,  
          <?php echo (array_key_exists('Saturday', $days)) ? $days['Saturday'] : "0"; ?>,                
          <?php echo (array_key_exists('Sunday', $days)) ? $days['Sunday'] : "0"; ?> 
            ],
            backgroundColor: ['rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 206, 86)','rgb(75, 192, 192)','rgb(153, 102, 255)','rgb(255, 159, 64)','rgb(250,128,114)','rgb(211,84,0)','rgb(39,55,70)','rgb(25,111,61)']
        }]
    },
    options: {
        responsive: true,
        plugins: {
      labels: {
    render: 'percentage',
    fontColor: '#fff',
    fontStyle: 'normal',
    fontSize: 15,
    position: 'border',
    precision: 2
  }
        }
    }
});
</script>
</div>

<div id="browser_bar" style="display: none;">
<canvas id="days_b" width="400" height="400"></canvas>
<script>
 ctx4 = document.getElementById('days_b');
 days_b = new Chart(ctx4, {
    type: 'bar',
    data: {
      labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            label: 'Unique users',
            data: [
              <?php echo (array_key_exists('Monday', $days)) ? $days['Monday'] : "0"; ?>,
              <?php echo (array_key_exists('Tuesday', $days)) ? $days['Tuesday'] : "0"; ?>,
              <?php echo (array_key_exists('Wednesday', $days)) ? $days['Wednesday'] : "0"; ?>,
              <?php echo (array_key_exists('Thursday', $days)) ? $days['Thursday'] : "0"; ?>,  
              <?php echo (array_key_exists('Friday', $days)) ? $days['Friday'] : "0"; ?>,  
              <?php echo (array_key_exists('Saturday', $days)) ? $days['Saturday'] : "0"; ?>,                
              <?php echo (array_key_exists('Sunday', $days)) ? $days['Sunday'] : "0"; ?> 
            ],
            backgroundColor: ['rgba(118, 193, 250)'],
            borderColor: ['rgba(118, 193, 250)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {labels: {render: function (args) {return '';}}},
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</div>
<ul class = "tblicons" >
<li onclick="browser_toggle_tbl()"><i class="ti-layout-cta-left"></i></li>
<li onclick="browser_toggle_pie()"><i class="ti-pie-chart"></i></li>
<li onclick="browser_toggle_bar()"><i class="ti-bar-chart"></i></li>
    </ul>
</div>
</div>
</div>
                </div>
            </div>



        </div>
    </div>

</div>

<?php   
  mysqli_close($conn);  } 
if (isset($_POST['sdate'])) {
    bringdata($_POST['sdate'],$_POST['edate'], $_POST['role']);
  }
  else {
    date_default_timezone_set('Europe/Bucharest');
    bringdata(date("Y-m-d"),date("Y-m-d"),'User');
  }?>


<?php include_once 'footer.php';?>
