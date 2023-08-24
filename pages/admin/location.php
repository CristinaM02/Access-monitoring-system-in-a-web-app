<?php include_once 'layout.php'; ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>
<div class="d-flex">
<div id="rangelocation" class="mb-5 w-25 d-inline-block"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>
<div class="d-inline-block ms-5">
<select id="roleselect">
  <option selected value="User">User</option>
  <option value="Admin">Admin</option>
</select>
</div> </div>
<div class="row" id="location">
<?php   function bringdata($startdate, $enddate, $role){ 
    require_once '../assets/connection.php';?>
    <div class="col-12 col-md-6">
        <div class="row">
            
            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                        <script type="text/javascript">
      google.charts.load('current', {'packages':['geochart'],});
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Unique Users'],
          <?php 
          $sql_country = "SELECT Country, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY Country;";
          $result_country = mysqli_query($conn, $sql_country);
          if (mysqli_num_rows($result_country) > 0) {
          while($row_country = mysqli_fetch_assoc($result_country)) { 
           echo "['".$row_country['Country']."',".$row_country['nr']."],";
                                    }}
            ?>
        ]);

        var options = {
            
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
    <div id="regions_div"></div>
</div>


</div>
</div>
</div>

                </div>
            </div>

            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                        <?php
                        $sql="select count(distinct Country) as nr_countries from login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success';"; 
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo '<img style="vertical-align:middle; width:6%;"src="../../images/icons/country.png"></img><div style="vertical-align:middle; display:inline; margin-left:1.5rem;"><span class="fw-bold">'
                        .$row['nr_countries'].' </span> distinct countries</div>';
                        ?>
</div>

</div>
</div>
</div>

                </div>
            </div>

            <div class="col-12 grid-margin grid-margin-md-0">
                <div class="card">
                <div class="card-body">
                <p class="card-title">City</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "device_tbl">
                        <table id="city" class="datatables-os display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>City</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql_city = "SELECT City, Country, Region, CountryCode, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND  DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY City;";
                                $result_city = mysqli_query($conn, $sql_city);
                                if (mysqli_num_rows($result_city) > 0) {
                                    while($row_city = mysqli_fetch_assoc($result_city)) {
                                ?>
                                <tbdoy>
                                    <tr>
                                <td>
                                       <?php 
                                       echo '<img class = "tbl_icon" src="../../images/icons/flags/'. $row_city['CountryCode'] .'.svg"></img>'. $row_city['City'] . ", " . $row_city['Region'] . ", " . $row_city['Country'];
                                       ?>
                                </td>
                                <td>
                                    <?=$row_city['nr']?>
                                </td>
</tr>
<?php }} ?>

</tbody>
</table>
</div>
<div id="device_pie" style="display: none;">

<canvas id="city_pie" width="400" height="400"></canvas>
<?php 
          $sql_city = "SELECT City, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND  DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY City;";
          $result_city = mysqli_query($conn, $sql_city);
          $lbls = $data = "";
          if (mysqli_num_rows($result_city) > 0) {
          while($row_city = mysqli_fetch_assoc($result_city)) { 
           $lbls .= "'".$row_city['City']."',";
           $data .=$row_city['nr'].",";
            }}
            ?>
<script>
 ctx1 = document.getElementById('city_pie');
 city_pie = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: [<?=$lbls?>],
        datasets: [{
            label: 'City',
            data: [<?=$data?>],
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

<div id="device_bar" style="display: none;">
<canvas id="myChart" width="400" height="400"></canvas>
<script>
 ctx = document.getElementById('myChart');
 myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?=$lbls?>],
        datasets: [{
            label: 'Unique users',
            data: [<?=$data?>],
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
                <p class="card-title">Country</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "os_tbl">
                        <table id="country" class="datatables-os display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql_country = "SELECT Country, CountryCode, count(DISTINCT User_Email) as nr FROM login_logs  l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY Country;";
                                $result_country = mysqli_query($conn, $sql_country);
                                if (mysqli_num_rows($result_country) > 0) {
                                    while($row_country = mysqli_fetch_assoc($result_country)) {
                                ?>
                                <tbdoy>
                                    <tr>
                                <td>
                                       <?php 
                                       echo '<img class = "tbl_icon" src="../../images/icons/flags/'. $row_country['CountryCode'] .'.svg"></img>'. $row_country['Country'];
                                       ?>
                                </td>
                                <td>
                                    <?=$row_country['nr']?>
                                </td>
                                </tr>
<?php }} ?>

</tbody>
</table>
</div>
<div id="os_pie" style="display: none;">
<?php 
          $sql_country = "SELECT Country, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY Country;";
          $result_country = mysqli_query($conn, $sql_country);
          $lbls2 = $data2 = "";
          if (mysqli_num_rows($result_country) > 0) {
          while($row_country = mysqli_fetch_assoc($result_country)) { 
           $lbls2 .= "'". $row_country['Country'] ."',";
           $data2 .= $row_country['nr'] .",";
            }}
            ?>
<canvas id="country_pie" width="400" height="400"></canvas>

<script>
 ctx2 = document.getElementById('country_pie');
 city_pie = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: [<?=$lbls2?>],
        datasets: [{
            label: 'Country',
            data: [<?=$data2?>],
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
<canvas id="country_bar" width="400" height="400"></canvas>
<script>
 ctx3 = document.getElementById('country_bar');
 country_bar = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: [<?=$lbls2?>],
        datasets: [{
            label: 'Unique users',
            data: [<?=$data2?>],
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
            <div class="col-12 grid-margin">
                <div class="card">
                <div class="card-body">
                <p class="card-title">Region</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id = "browser_tbl">
                        <table id="region" class="datatables-os display expandable-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Region</th>
                                        <th>Unique Users</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql_region = "SELECT Country, Region, CountryCode, count(DISTINCT User_Email) as nr FROM login_logs l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY Region;";
                                $result_region = mysqli_query($conn, $sql_region);
                                if (mysqli_num_rows($result_region) > 0) {
                                    while($row_region = mysqli_fetch_assoc($result_region)) {
                                ?>
                                <tbdoy>
                                    <tr>
                                <td>
                                       <?php 
                                       echo '<img class = "tbl_icon" src="../../images/icons/flags/'. $row_region['CountryCode'] .'.svg"></img>'. $row_region['Region'] . ", " . $row_region['Country'];
                                       ?>
                                </td>
                                <td>
                                    <?=$row_region['nr']?>
                                </td>
</tr>
<?php }} ?>

</tbody>
</table>

</div>
<?php 
          $sql_region = "SELECT Region, count(DISTINCT User_Email) as nr FROM login_logs  l inner join users u on u.ID = l.UserID WHERE Role ='$role' AND  DATE(Login) BETWEEN '$startdate' AND '$enddate' AND Status ='Success' GROUP BY Region;";
          $result_region = mysqli_query($conn, $sql_region);
          $lbls3 = $data3 = "";
          if (mysqli_num_rows($result_region) > 0) {
          while($row_region = mysqli_fetch_assoc($result_region)) { 
            $lbls3 .= "'".$row_region['Region']."',";
            $data3 .= $row_region['nr'].",";
          }}
            ?>
<div id="browser_pie" style="display: none;">
<canvas id="region_pie" width="400" height="400"></canvas>

<script>
 ctx4 = document.getElementById('region_pie');
 region_pie = new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: [<?=$lbls3?>],
        datasets: [{
            label: 'Region',
            data: [<?=$data3?>],
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
<canvas id="region_bar" width="400" height="400"></canvas>
<script>
 ctx5 = document.getElementById('region_bar');
 region_bar = new Chart(ctx5, {
    type: 'bar',
    data: {
        labels: [<?=$lbls3?>],
        datasets: [{
            label: 'Unique users',
            data: [<?=$data3?>],
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
