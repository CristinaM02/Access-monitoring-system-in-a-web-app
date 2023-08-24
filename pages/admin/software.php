<?php include_once 'layout.php';?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

<div class="d-flex">
<div id="range" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>
<div class="d-inline-block ms-5">
<select id="rolesoftware">
  <option selected value="User">User</option>
  <option value="Admin">Admin</option>
</select>
</div> </div>
<div class="row" id="software">
<?php   function bringdata($startdate, $enddate, $role){ 
    require_once '../assets/connection.php';?>
    <div class="col-12 col-md-6">
        <div class="row">
            
            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <p class="card-title">Operating system</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "os_tbl">
                        <table id="os" class="datatables-os display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Operating system</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                    <tr>
                                <td>
                                       <img class = "tbl_icon" src="../../images/icons/Windows.png"></img> Windows
                                </td>
                                <td>
                                    <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%windows%' AND OS NOT LIKE '%Phone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Windows_phone.png"></img> Windows phone
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Windows Phone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email) AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Ubuntu.png"></img> Ubuntu
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Ubuntu%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Android.png"></img> Android
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Android%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Linux.png"></img> Linux
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Linux%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Mac.png"></img> Mac
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Mac%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Ios.png"></img> iOS
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%iPhone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Unknown.png"></img> Unknown
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Other%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
</tbody>
</table>
</div>
<div id="os_pie" style="display: none;">
<canvas id="os_p" width="400" height="400"></canvas>
<script>
 ctx1 = document.getElementById('os_p');
 os_p = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['Windows', 'Windows Phone', 'Ubuntu', 'Android', 'Linux', 'Mac', 'iOS', 'Unknown'],
        datasets: [{
            label: 'Operating system',
            data: [
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%windows%' AND OS NOT LIKE '%Phone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total'];?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Windows Phone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Ubuntu%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Android%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total'];  ?>, 
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Linux%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Mac%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%iPhone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,    
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Other%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?> 
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

<div id="os_bar" style="display: none;">
<canvas id="ob_b" width="400" height="400"></canvas>
<script>
 ctx2 = document.getElementById('ob_b');
 ob_b = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Windows', 'Windows Phone', 'Ubuntu', 'Android', 'Linux', 'Mac', 'iOS', 'Unknown'],
        datasets: [{
            label: 'Unique users',
            data: [
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%windows%' AND OS NOT LIKE '%Phone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total'];?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Windows Phone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Ubuntu%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Android%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total'];  ?>, 
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Linux%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Mac%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%iPhone%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,    
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct OS) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and OS like '%Other%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?> 
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
                <p class="card-title">Device type</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "device_tbl">
                        <table id="device" class="datatables-os display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                    <tr>
                                <td>
                                       <img class = "tbl_icon" src="../../images/icons/Desktop.png"></img> Desktop
                                </td>
                                <td>
                                    <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Device) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Device like '%Desktop%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Mobile.png"></img> Mobile
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Device) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Device like '%Mobile%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>


</tbody>
</table>
</div>
<div id="device_pie" style="display: none;">
<canvas id="device_p" width="400" height="400"></canvas>
<script>
 ctx3 = document.getElementById('device_p');
 device_p = new Chart(ctx3, {
    type: 'pie',
    data: {
        labels: ['Desktop', 'Mobile'],
        datasets: [{
            label: 'Device',
            data: [
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Device) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Device like '%Desktop%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Device) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Device like '%Mobile%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                 echo $nr['total']; ?>
            ],
            backgroundColor: [
                'rgb(255, 99, 132)','rgb(54, 162, 235)']
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
<canvas id="device_b" width="400" height="400"></canvas>
<script>
 ctx4 = document.getElementById('device_b');
 device_b = new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: ['Desktop', 'Mobile'],
        datasets: [{
            label: 'Unique users',
            data: [
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Device) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Device like '%Desktop%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Device) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Device like '%Mobile%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                 echo $nr['total']; ?>
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
                <p class="card-title">Browser</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "browser_tbl">
                        <table id="browser" class="datatables-os display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Browser</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <tbdoy>
                                    <tr>
                                <td>
                                       <img class = "tbl_icon" src="../../images/icons/Opera.png"></img> Opera
                                </td>
                                <td>
                                    <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Opera%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Edge.png"></img> Microsoft Edge
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Edge%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Chrome.png"></img> Chrome
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Chrome%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Safari.png"></img> Safari
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Safari%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Firefox.png"></img> Firefox
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Firefox%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/IE.png"></img> Internet Explorer
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Internet Explorer%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
<tr>
                                <td>
                                <img class = "tbl_icon" src="../../images/icons/Unknown.png"></img> Unknown
                                </td>
                                <td>
                                <?php
                                    $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Other%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                                    echo $nr['total'];
                                    ?>
                                </td>
</tr>
</tbody>
</table>
</div>
<div id="browser_pie" style="display: none;">
<canvas id="browser_p" width="400" height="400"></canvas>
<script>
 ctx5 = document.getElementById('browser_p');
 browser_p = new Chart(ctx5, {
    type: 'pie',
    data: {
        labels: ['Opera', 'Microsoft Edge', 'Chrome', 'Safari', 'Firefox', 'Internet Explorer', 'Unknown'],
        datasets: [{
            label: 'Browser',
            data: [
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Opera%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Edge%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Chrome%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Safari%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,  
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Firefox%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>, 
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Internet Explorer%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Other%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>
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
<div id="piechart_browser"></div>
</div>

<div id="browser_bar" style="display: none;">
<canvas id="browser_b" width="400" height="400"></canvas>
<script>
 ctx6 = document.getElementById('browser_b');
 browser_b = new Chart(ctx6, {
    type: 'bar',
    data: {
        labels: ['Opera', 'Microsoft Edge', 'Chrome', 'Safari', 'Firefox', 'Internet Explorer', 'Unknown'],
        datasets: [{
            label: 'Unique users',
            data: [
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Opera%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Edge%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Chrome%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Safari%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,  
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Firefox%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>, 
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Internet Explorer%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>,
                <?php $nr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM (SELECT count(distinct Browser) FROM `login_logs` l inner join users u on u.ID = l.UserID WHERE Role ='$role' and Browser like '%Other%' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' group by User_Email)  AS subquery;"));
                echo $nr['total']; ?>
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
