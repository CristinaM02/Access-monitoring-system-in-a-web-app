<?php include_once 'layout.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

<div id="rangeover" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>

<div class="row" id="overview">

<?php   function bringdata($startdate, $enddate){ 
    require_once '../assets/connection.php';?>

<div class="col-md-12 grid-margin stretch-card">
<div class="card">
            <div class="card-body">
                <p class="card-title">Users logins over time</p>
                <div class="row">
                    <?php
                     $diff=date_diff(date_create($startdate),date_create($enddate));
                     if($diff->format("%a") == 0){
                     $begin = date_sub(date_create($startdate),date_interval_create_from_date_string("30 days"));
                    }
                    else $begin = date_create($startdate);
                    $begin = date_format($begin,"Y-m-d");
                    $sql = "CALL LoginsPerDay('$begin', '$enddate');";
                    $result = mysqli_query($conn, $sql);
                    $lbls = $logins = $unique_us =  $avg_duration = $pages = $avg_act = $links = "";
                    while($row = mysqli_fetch_assoc($result)){
                        $lbls .= "'".$row["dt"]."',";
                        $logins .= "'".$row["logins"]."',";
                        $unique_us .= "'".$row["unique_users"]."',";
                        $avg_duration .= "'".$row["avg_duration"]."',";
                        $pages .= "'".$row["pages"]."',";
                        $links .= "'".$row["outlinks"]."',";
                        $avg_act .= "'".$row["avg_actions"]."',";
                    }
                    mysqli_free_result($result);
                    mysqli_next_result($conn);  
                         
                     ?>
                    <div class="col-12">
                    <canvas id="line_chart" width="400" height="50"></canvas>
<script>
 ctx8 = document.getElementById('line_chart').getContext('2d');
 line_chart = new Chart(ctx8, {
    type: 'line',
    data: { 
        labels: [<?=$lbls;?>],
        datasets: [{
    label: 'Logins',
    data: [<?=$logins;?>],
    fill: false,
    backgroundColor: 'rgb(75, 192, 192)',
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  },
  {
    label: 'Unique users',
    data: [<?=$unique_us;?>],
    fill: false,
    backgroundColor: 'rgb(250, 128, 114)',
    borderColor: 'rgb(250, 128, 114)',
    tension: 0.1
  },
  {
    label: 'Page views',
    data: [<?=$pages;?>],
    fill: false,
    backgroundColor: 'rgb(39, 55, 70)',
    borderColor: 'rgb(39, 55, 70)',
    tension: 0.1
  },
  {
    label: 'Outlinks',
    data: [<?=$links;?>],
    fill: false,
    backgroundColor: 'rgb(170, 183, 184 )',
    borderColor: 'rgb(170, 183, 184 )',
    tension: 0.1
  },
  {
    label: 'Avg actions per session',
    data: [<?=$avg_act;?>],
    fill: false,
    backgroundColor: 'rgb(195, 155, 211 )',
    borderColor: 'rgb(195, 155, 211 )',
    tension: 0.1
  },{
    label: 'Avg. session duration (in seconds)',
    data: [<?=$avg_duration;?>],
    fill: false,
    backgroundColor: 'rgb(39, 174, 96)',
    borderColor: 'rgb(39, 174, 96)',
    tension: 0.1
  }
]
},
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            },
            x: {
        ticks: {
            maxTicksLimit: 5,
      maxRotation: 0,
      minRotation: 0
            }
        }
        }
    }
});
</script>
</div>
</div>
</div>
</div> 
</div>


    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Users logins overview</p>
                <div class="row">
                <?php $sql = "CALL Users_overview('$startdate', '$enddate');";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $total_time = 0;
                    $s = $row['avg_session']%60;
                    $m = floor(($row['avg_session']%3600)/60);
                    $h = floor(($row['avg_session']%86400)/3600);
                    if($h > 0) $total_time = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $total_time = $m . " mins " . $s ."s";
                        else if($s > 0) $total_time = $s ."s";
                    ?>
                <div class="col-md-6">
                        <p><b><?=$row['logins']?></b> logins, <b><?=$row['unique_users']?></b> unique users</p>
                        <p><b><?=$total_time?></b> average session duration</p>
                        <p><b><?=$row['b']?>%</b> sessions have bounced (left the website after one page)</p>
                        <p><b><?=$row['act'] ?? '0'?></b> avg actions (page views, outlinks) per session</p>
                        <p><b><?=$row['max_pg'] ?? '0'?></b> max pages viewed in one session</p>
</div>
<div class="col-md-6">
<p><b><?=$row['pg_view']?></b> pageviews, <b><?=$row['unique_pg_view']?></b> unique pageviews</p>
<p><b><?=$row['links']?></b> outlinks, <b><?=$row['unique_links']?></b> unique outlinks</p>

                        <?php mysqli_free_result($result);
                    mysqli_next_result($conn);   ?>
</div>
</div>
        </div>
    </div>

</div>

<div class="col-md-12 grid-margin stretch-card">
<div class="card">
            <div class="card-body">
                <p class="card-title">Admins logins over time</p>
                <div class="row">
                    <?php
                     $diff=date_diff(date_create($startdate),date_create($enddate));
                     if($diff->format("%a") == 0){
                     $begin = date_sub(date_create($startdate),date_interval_create_from_date_string("30 days"));
                    }
                    else $begin = date_create($startdate);
                    $begin = date_format($begin,"Y-m-d");
                    $sql = "CALL Admin_LoginsPerDay('$begin', '$enddate');";
                    $result = mysqli_query($conn, $sql);
                    $lbls = $logins = $unique_us =  $avg_duration = $avg_act = "";
                    while($row = mysqli_fetch_assoc($result)){
                        $lbls .= "'".$row["dt"]."',";
                        $logins .= "'".$row["logins"]."',";
                        $unique_us .= "'".$row["unique_users"]."',";
                        $avg_duration .= "'".$row["avg_duration"]."',";
                        $avg_act .= "'".$row["avg_act"]."',";
                    }
                    mysqli_free_result($result);
                    mysqli_next_result($conn);  
                         
                     ?>
                    <div class="col-12">
                    <canvas id="line_chart1" width="400" height="50"></canvas>
<script>
 ctx1 = document.getElementById('line_chart1').getContext('2d');
 line_chart1 = new Chart(ctx1, {
    type: 'line',
    data: { 
        labels: [<?=$lbls;?>],
        datasets: [{
    label: 'Logins',
    data: [<?=$logins;?>],
    fill: false,
    backgroundColor: 'rgb(75, 192, 192)',
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  },
  {
    label: 'Unique users',
    data: [<?=$unique_us;?>],
    fill: false,
    backgroundColor: 'rgb(250, 128, 114)',
    borderColor: 'rgb(250, 128, 114)',
    tension: 0.1
  },
  {
    label: 'Avg actions per session',
    data: [<?=$avg_act;?>],
    fill: false,
    backgroundColor: 'rgb(195, 155, 211 )',
    borderColor: 'rgb(195, 155, 211 )',
    tension: 0.1
  },{
    label: 'Avg. session duration (in seconds)',
    data: [<?=$avg_duration;?>],
    fill: false,
    backgroundColor: 'rgb(39, 174, 96)',
    borderColor: 'rgb(39, 174, 96)',
    tension: 0.1
  }
]
},
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            },
            x: {
        ticks: {
            maxTicksLimit: 5,
      maxRotation: 0,
      minRotation: 0
            }
        }
        }
    }
});
</script>
</div>
</div>
</div>
</div> 
</div>


    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Admins logins overview</p>
                <div class="row">
                <?php $sql = "CALL Admin_overview('$startdate', '$enddate');";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $total_time = 0;
                    $s = $row['avg_session']%60;
                    $m = floor(($row['avg_session']%3600)/60);
                    $h = floor(($row['avg_session']%86400)/3600);
                    if($h > 0) $total_time = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $total_time = $m . " mins " . $s ."s";
                        else if($s > 0) $total_time = $s ."s";
                    ?>
                <div class="col-md-6">
                        <p><b><?=$row['logins']?></b> logins, <b><?=$row['unique_users']?></b> unique users</p>
                        <p><b><?=$total_time?></b> average session duration</p>
                        <p><b><?=$row['avg_act'] ?? '0'?></b> avg actions (page creation, page update, content update) per session</p>
                        <p><b><?=$row['max_act'] ?? '0'?></b> max actions in one session</p>
</div>
<div class="col-md-6">
<p><b><?=$row['pgs_created']?></b> pages created</p>
<p><b><?=$row['pgs_updated']?></b> pages updated</p>
<p><b><?=$row['content_update']?></b> page's content updated</p>

                        <?php mysqli_free_result($result);
                    mysqli_next_result($conn);   ?>
</div>
</div>
        </div>
    </div>

</div>


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
