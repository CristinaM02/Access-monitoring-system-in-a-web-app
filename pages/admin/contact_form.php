<?php include_once 'layout.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

<div id="rangecontact" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>

<div class="row" id="contact_f">

    <?php   function bringdata($startdate, $enddate){ 
    require_once '../assets/connection.php';?>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Form overview</p>
                <div class="row">
                <?php 
                     $sql = "CALL contact_form('$startdate', '$enddate', 'Contact us');";
                     $result = mysqli_query($conn, $sql);
                     $row = mysqli_fetch_assoc($result); 
                    $hesitation = 0;
                    $s = $row['hes']%60;
                    $m = floor(($row['hes']%3600)/60);
                    $h = floor(($row['hes']%86400)/3600);
                    if($h > 0) $hesitation = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $hesitation = $m . " mins " . $s ."s";
                        else if($s > 0) $hesitation = $s ."s";

                    $first_sub = 0;
                    $s = $row['first_s']%60;
                    $m = floor(($row['first_s']%3600)/60);
                    $h = floor(($row['first_s']%86400)/3600);
                    if($h > 0) $first_sub = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $first_sub = $m . " mins " . $s ."s";
                        else if($s > 0) $first_sub = $s ."s";

                    $avg = 0;
                    $s = $row['av_time']%60;
                    $m = floor(($row['av_time']%3600)/60);
                    $h = floor(($row['av_time']%86400)/3600);
                    if($h > 0) $avg = $h ."h ". $m . " mins " . $s ."s";
                        else if($m > 0) $avg = $m . " mins " . $s ."s";
                        else if($s > 0) $avg = $s ."s";
                    ?>
                    <div class="col-md-6">
                    <p><b><?=$row['start_rate']?>%</b> starter rate</p>
                    <p><b><?=$row['submit_rate']?>%</b> submitter rate</p>
                    <p><b><?=$row['resub_rate']?>%</b> re-submitter rate</p>
                    <p><b><?=$row['resubmitters']?></b> re-submitters</p>
                    </div>
                    <div class="col-md-6">
                    <p><b><?=$row['starters']?></b> starters</p>
                    <p><b><?=$row['views']?></b> views</p>
                    <p><b><?=$row['viewers']?></b> viewers</p>
                    <p><b><?=$row['submitters']?></b> submitters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Form timings</p>
                <div class="row">
                    <div class="col-md-6">
                    <p><b><?=$hesitation?></b> avg. hesitation time</p>
                    <p><b><?=$first_sub?></b> avg. time to first submit</p>
                    </div>
                    <div class="col-md-6">
                    <p><b><?=$avg?></b> avg. time spent</p>
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