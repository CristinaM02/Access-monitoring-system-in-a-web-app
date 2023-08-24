<?php include_once 'layout.php';
      require_once '../assets/connection.php';
      ?>
<script src='https://cdn.plot.ly/plotly-2.11.1.min.js'></script>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                        <div id="myDiv" style="width:1150px;height:1000px;"><!-- Plotly chart will be drawn inside this DIV --></div>
                          <script>

    var data = [{
    type: 'scattergeo',
    mode: 'markers',

    lon: [
      <?php
    $sql = "SELECT lon from login_logs where Status ='Success' AND date(Login) = CURDATE() AND Logout IS NULL;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
    echo $row['lon'].','; }}
    ?>
    ],
    lat: [
      <?php
    $sql = "SELECT lat from login_logs where Status ='Success' AND date(Login) = CURDATE() AND Logout IS NULL;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
    echo $row['lat'].','; }}
    ?>
    ],
    hovertemplate:  '<b>%{text}</b>',
        text: [
            <?php
    $sql = "SELECT City, Region, Country, TIMESTAMPDIFF(SECOND, Login, now()) as duration from login_logs where Status ='Success' AND date(Login) = CURDATE() AND Logout IS NULL;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $time = $row['duration']; 
        if(floor($time / 3600) > 0)
        $time_f =  floor($time / 3600) . 'h ' . floor(($time / 60) % 60) . 'mins ' . $time % 60 . 's';
        else if(floor(($time / 60) % 60) > 0)
        $time_f =  floor(($time / 60) % 60) . 'mins ' . $time % 60 . 's';
        else if($time % 60 . 's' > 0) $time_f =  $time % 60 . 's';
        else $time_f = "0s";
    echo '"'. $row['City'].', '.$row['Region']. ', '.$row['Country'].'<br>'. $time_f .' ago",';
}}
    ?>
        ],
    marker: {
        size: 12,
        color: ['#bebada', '#ffffb3', '#fb8072', '#fdb462', '#d9d9d9', '#bc80bd','#b3de69', '#8dd3c7', '#80b1d3', '#fccde5' ],
        line: {width: 1},
        opacity: 0.8
    },
    name: '',
    
}];

var layout = {
    title: 'Real time users location',
    font: {
        family: 'Droid Serif, serif',
        size: 6
    },
    titlefont: {size: 16},
    geo: {
        scope: 'world',
        showrivers: true,
        rivercolor: '#dbeeff',
        showlakes: true,
        lakecolor: '#dbeeff',
        showland: true,
        landcolor: '#EAEAAE',
        showsubunits: true,
        showcountries: true,
        countrycolor: '#383838',
        countrywidth: 1.5,
        subunitcolor: '#d3d3d3'
    },
    config: { responsive: true }
};

Plotly.newPlot('myDiv', data, layout);

                            </script>
                       
                        </div>
  </div>
</div>
                    </div>
                </div>
            </div>
            
        </div>




<?php include_once 'footer.php';?>