<?php include_once 'layout.php';?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>
<div id="rangeengage" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>

<div class="row" id="engage">
<?php   function bringdata($startdate, $enddate){ 
    require_once '../assets/connection.php';?>

<div class="col-md-12 grid-margin stretch-card">
<div class="card">
            <div class="card-body">
                <p class="card-title">Frequency overview</p>
                <div class="row">
                <?php $sql = "CALL Freq_overview('$startdate', '$enddate');";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result); 
                    $s = $row['avg_time_return']%60;
                    $m = floor(($row['avg_time_return']%3600)/60);
                    $h = floor(($row['avg_time_return']%86400)/3600);
                    if($h > 0) $total_time = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $total_time = $m . " mins " . $s ."s";
                        else if($s > 0) $total_time = $s ."s";
                        else $total_time = 0;
                    $s1 = $row['avg_time_new']%60;
                    $m1 = floor(($row['avg_time_new']%3600)/60);
                    $h1 = floor(($row['avg_time_new']%86400)/3600);
                    if($h1 > 0) $total_time1 = $h1 ."h ". $m1 . " mins " . $s1 ."s";
                        else if($m1 > 0) $total_time1 = $m1 . " mins " . $s1 ."s";
                        else if($s1 > 0) $total_time1 = $s1 ."s";
                        else $total_time1 = 0;
                    ?>
                <div class="col-md-6">
                        <p><b><?=$row['returning_users']?></b> returning visits</p>
                        <p><b><?=$row['returning_unique_users']?></b> returning unique users</p>
                        <p><b><?=$total_time?></b> average visit duration for returning users</p>
                        <p><b><?=$row['avg_at_return'] ?? '0'?></b> actions per returning visit</p>
                        <p><b><?=$row['bounce_return'] ?? '0'?>%</b> returning visits have bounced (left the website after one page)</p>
                        <p><b><?=$row['actions_return'] ?? '0'?></b> actions by the returning visits</p>
</div>
<div class="col-md-6">
<p><b><?=$row['new_users']?></b> new visits</p>
<p><b><?=$row['new_unique_users']?></b> new unique users</p>
                        <p><b><?=$total_time1?></b> average visit duration for new users</p>
                        <p><b><?=$row['avg_at_new'] ?? '0'?></b> actions per new visit</p>
                        <p><b><?=$row['bounce_new'] ?? '0'?>%</b> new visits have bounced (left the website after one page)</p>
                        <p><b><?=$row['actions_new'] ?? '0'?></b> actions by the new visits</p>
                        <?php mysqli_free_result($result);
                    mysqli_next_result($conn);   ?>
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
                <p class="card-title">Logins by duration</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "os_tbl">
                        <table id="log_duration" class="display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                    <th></th>
                                        <th>Login duration</th>
                                        <th>Logins</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                <tr>
                                <td></td>
                                <td>0-10s</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 0 AND 10;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>11-30s</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 11 AND 30;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>31-60s</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 31 AND 60;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>1-2 min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 61 AND 119;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>2-4 min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 2 AND 3;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>4-7 min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 4 AND 6;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>7-10 min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 7 AND 9;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>10-15 min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 10 AND 14;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>15-30 min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 15 AND 30;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>30+ min</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) > 30;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>

</tbody>
</table>
</div>

<div id="os_pie" style="display: none;">

<canvas id="duration_pie" width="400" height="400"></canvas>

<script>
 ctx1 = document.getElementById('duration_pie');
 duration_pie = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['0-10s', '11-30s', '31-60s', '1-2 min', '2-4 min', '4-7 min', '7-10 min', '10-15 min', '15-30 min', '30+ min'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 0 AND 10;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 11 AND 30;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 31 AND 60;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 61 AND 119;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 2 AND 3;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 4 AND 6;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 7 AND 9;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 10 AND 14;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 15 AND 30;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) > 30;"));
            echo $nr['total'];?>

            ],
            backgroundColor: [
                'rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 206, 86)','rgb(75, 192, 192)','rgb(153, 102, 255)','rgb(255, 159, 64)','rgb(250,128,114)','rgb(211,84,0)','rgb(39,55,70)','rgb(25,111,61)']
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
<canvas id="myChart" width="400" height="400"></canvas>
<script>
 ctx = document.getElementById('myChart');
 myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['0-10s', '11-30s', '31-60s', '1-2 min', '2-4 min', '4-7 min', '7-10 min', '10-15 min', '15-30 min', '30+ min'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 0 AND 10;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 11 AND 30;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 31 AND 60;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Second,Login,Logout) BETWEEN 61 AND 119;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 2 AND 3;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 4 AND 6;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 7 AND 9;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 10 AND 14;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) BETWEEN 15 AND 30;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(ID) as total FROM login_logs where Logout IS NOT NULL AND UserID in (SELECT ID from users where Role = 'User') AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' AND TIMESTAMPDIFF(Minute,Login,Logout) > 30;"));
            echo $nr['total'];?>

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

            <div class="col-12 grid-margin grid-margin-md-0">
                <div class="card">
                <div class="card-body">
                <p class="card-title">Logins by login number</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "device_tbl">
                        <table id="log_number" class="display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                    <th></th>
                                        <th>Login number</th>
                                        <th>Logins</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                <tr>
                                <td></td>
                                <td>1 login</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 1;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>2 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 2;"));                                
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>3 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 3;"));                                
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>4 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 4;"));                                  
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>5 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 5;"));                             
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>6 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 6;"));                                 
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>7 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 7;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>8 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 8;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>9-14 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 9 AND 14;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>15-25 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 15 AND 25;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>26-50 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 26 AND 50;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>51-100 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 51 AND 100;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>101-200 logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 101 AND 200;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>201+ logins</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs >= 201;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>

</tbody>
</table>
</div>
<div id="device_pie" style="display: none;">
<canvas id="number_pie" width="400" height="400"></canvas>

<script>
 ctx2 = document.getElementById('number_pie');
 number_pie = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9-14', '15-25', '26-50', '51-100', '101-200', '201+'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 1;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 2;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 3;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 4;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 5;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 6;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 7;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 8;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 9 AND 14;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 15 AND 25;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 26 AND 50;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 51 AND 100;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 101 AND 200;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs >= 201;"));
            echo $nr['total'];?>
            ],
            backgroundColor: [
                'rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 206, 86)','rgb(75, 192, 192)','rgb(153, 102, 255)','rgb(255, 159, 64)','rgb(250,128,114)','rgb(211,84,0)','rgb(39,55,70)','rgb(25,111,61)', 'rgb(60,179,113)','rgb(128,128,128)', 'rgb(238,232,170)', 'rgb(220,20,60)']
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

<div id="device_bar" style="display: none;">
<canvas id="number_bar" width="400" height="400"></canvas>
<script>
 ctx3 = document.getElementById('number_bar');
 number_bar = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9-14', '15-25', '26-50', '51-100', '101-200', '201+'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 1;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 2;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 3;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 4;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 5;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 6;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 7;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs = 8;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 9 AND 14;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 15 AND 25;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 26 AND 50;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 51 AND 100;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs BETWEEN 101 AND 200;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(logs) as total from (SELECT UserID as uid, (select count(ID) from login_logs where UserID = uid and Status ='Success' AND UserID in (SELECT ID from users where Role = 'User') and DATE(Login) <= '$enddate') as logs FROM login_logs where Status ='Success' AND DATE(Login) BETWEEN '$startdate' AND '$enddate') t where logs >= 201;"));
            echo $nr['total'];?>
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
<li onclick="device_toggle_tbl()"><i class="ti-layout-cta-left"></i></li>
<li onclick="device_toggle_pie()"><i class="ti-pie-chart"></i></li>
<li onclick="device_toggle_bar()"><i class="ti-bar-chart"></i></li>
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
                <p class="card-title">Logins per number of pages</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "browser_tbl">
                        <table id="log_pages" class="display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                    <th></th>
                                        <th>Login duration</th>
                                        <th>Logins</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                <tr>
                                <td></td>
                                <td>1 page</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 1) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>2 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 2) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>3 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 3) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>4 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 4) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>5 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 5) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>6-7 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 6 AND 7) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>8-10 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 8 AND 10) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>11-14 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 11 AND 14) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>15-20 pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 15 AND 20) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>21+ pages</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) >= 21) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>

</tbody>
</table>
                        </div>
                        <div id="browser_pie" style="display: none;">

<canvas id="pages_pie" width="400" height="400"></canvas>

<script>
 ctx4 = document.getElementById('pages_pie');
 pages_pie = new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: ['1pg', '2pg', '3pg', '4pg', '5pg', '6-7 pg', '8-10 pg', '11-14 pg', '15-20 pg', '21+ pg'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 1) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 2) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 3) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 4) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 5) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 6 AND 7) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 8 AND 10) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 11 AND 14) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 15 AND 20) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) >= 21) AS subquery;"));
            echo $nr['total'];?>

            ],
            backgroundColor: [
                'rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 206, 86)','rgb(75, 192, 192)','rgb(153, 102, 255)','rgb(255, 159, 64)','rgb(250,128,114)','rgb(211,84,0)','rgb(39,55,70)','rgb(25,111,61)']
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
<canvas id="pages_bar" width="400" height="400"></canvas>
<script>
 ctx5 = document.getElementById('pages_bar');
 pages_bar = new Chart(ctx5, {
    type: 'bar',
    data: {
        labels: ['1pg', '2pg', '3pg', '4pg', '5pg', '6-7 pg', '8-10 pg', '11-14 pg', '15-20 pg', '21+ pg'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 1) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 2) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 3) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 4) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) = 5) AS subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 6 AND 7) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 8 AND 10) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 11 AND 14) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) BETWEEN 15 AND 20) AS subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT ID from session_logs where DATE(Start_Time) BETWEEN '$startdate' AND '$enddate' group by Log_ID having count(distinct PageID) >= 21) AS subquery;"));
            echo $nr['total'];?>
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
            </div>    <!-- end div col-12 grid-margin -->


            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <p class="card-title">Logins by day since last login</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "logdays_tbl">
                        <table id="log_days" class="display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                    <th></th>
                                        <th>Days since last login</th>
                                        <th>Logins</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                <tr>
                                <td></td>
                                <td>New login</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where max2 is null) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>0 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 0) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>1 day</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 1) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>2 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 2) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>3 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 3) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>4 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 4) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>5 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 5) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>6 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 6) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>7 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 7) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>8-14 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 8 AND 14) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>15-30 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 15 AND 30) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>31-60 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 31 AND 60) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>61-120 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 61 AND 120) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>121-364 days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 121 AND 364) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td></td>
                                <td>365+ days</td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) >= 365) as subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
                                </tr>

</tbody>
</table>
                        </div>
                        <div id="logdays_pie" style="display: none;">
<canvas id="days_pie" width="400" height="400"></canvas>

<script>
 ctx6 = document.getElementById('days_pie');
 days_pie = new Chart(ctx6, {
    type: 'pie',
    data: {
        labels: ['new', '0 days', '1 day', '2 days', '3 days', '4 days', '5 days', '6 days', '7 days', '8-14 days', '15-30 days', '31-60 days', '61-120 days', '121-364 days', '365+ days'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where max2 is null) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 0) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 1) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 2) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 3) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 4) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 5) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 6) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 7) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 8 AND 14) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 15 AND 30) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 31 AND 60) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 61 AND 120) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 121 AND 364) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) >= 365) as subquery;"));
            echo $nr['total'];?>
            ],
            backgroundColor: [
                'rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 206, 86)','rgb(75, 192, 192)','rgb(153, 102, 255)','rgb(255, 159, 64)','rgb(250,128,114)','rgb(211,84,0)','rgb(39,55,70)','rgb(25,111,61)', 'rgb(60,179,113)','rgb(128,128,128)', 'rgb(238,232,170)', 'rgb(220,20,60)', 'rgb(74, 35, 90)']
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

<div id="logdays_bar" style="display: none;">
<canvas id="days_bar" width="400" height="400"></canvas>
<script>
 ctx7 = document.getElementById('days_bar');
 days_barr = new Chart(ctx7, {
    type: 'bar',
    data: {
        labels: ['new', '0 days', '1 day', '2 days', '3 days', '4 days', '5 days', '6 days', '7 days', '8-14 days', '15-30 days', '31-60 days', '61-120 days', '121-364 days', '365+ days'],
        datasets: [{
            label: 'Logins',
            data: [
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where max2 is null) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 0) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 1) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 2) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 3) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 4) as subquery;"));
            echo $nr['total']; ?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 5) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 6) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) = 7) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 8 AND 14) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 15 AND 30) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 31 AND 60) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 61 AND 120) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) BETWEEN 121 AND 364) as subquery;"));
            echo $nr['total'];?>,
            <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as total from (SELECT datediff(max, max2) as diff FROM (SELECT ID, UserID as uid, Login as max, (SELECT Login from login_logs where ID = (SELECT max(ID) from login_logs where UserID = uid AND Status = 'Success' AND Login < max)) as max2 from login_logs where DATE(Login) BETWEEN '$startdate' AND '$enddate' AND UserID in (SELECT ID from users where Role = 'User') AND Status = 'Success') t where datediff(max, max2) >= 365) as subquery;"));
            echo $nr['total'];?>
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
<li onclick="logdays_toggle_tbl()"><i class="ti-layout-cta-left"></i></li>
<li onclick="logdays_toggle_pie()"><i class="ti-pie-chart"></i></li>
<li onclick="logdays_toggle_bar()"><i class="ti-bar-chart"></i></li>
    </ul>
</div>
</div>
</div>
                </div>
            </div>    <!-- end div col-12 grid-margin -->


        </div>
    </div>     <!-- end div col-12 col-md-6 -->

</div>

<?php   } 
if (isset($_POST['sdate'])) {
    bringdata($_POST['sdate'],$_POST['edate']);
  }
  else {
    date_default_timezone_set('Europe/Bucharest');
    bringdata(date("Y-m-d"),date("Y-m-d"));
  }?>


<?php include_once 'footer.php';?>
