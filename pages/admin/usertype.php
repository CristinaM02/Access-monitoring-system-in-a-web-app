<?php include_once 'layout.php';?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

<div id="rangeusertype" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>

<div class="row" id="usertype">
<?php   function bringdata($startdate, $enddate){ 
    require_once '../assets/connection.php';?>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">User type</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id ="browser_tbl">
                            <table id="userstype" class="datatables-userstype display expandable-table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>User type</th>
                                        <th>Unique users</th>
                                        <th>Logins</th>
                                        <th>Actions</th>
                                        <th>Avg. actions per session</th>
                                        <th>Avg. time on website</th>
                                        <th>Active rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <?php
                        $sql = "CALL UserTypes('User', '$startdate', '$enddate');";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) 
                        $row = mysqli_fetch_assoc($result);
                        else $row = array("nr"=>0,"logins"=>0,"actions"=>0,"avg_actions"=>0,"avg_time"=>0,"bounce"=>0); 
                        mysqli_free_result($result);  
                        mysqli_next_result($conn);         
                        ?>
                                    <td>User</td>
                                    <td><?=$row['nr']?></td>
                                    <td><?=$row['logins']?></td>
                                    <td><?=$row['actions']?></td>
                                    <td><?=$row['avg_actions']?></td>
                                    <td><?=$row['avg_time']?></td>
                                    <td><?=$row['bounce'].'%'?></td>
                                    </tr>
                                    <tr>
                                    <?php
                        $sql_adm = "CALL UserTypes('Admin', '$startdate', '$enddate')";
                        $result_adm = mysqli_query($conn, $sql_adm);
                        if (mysqli_num_rows($result_adm) > 0) 
                        $row_adm = mysqli_fetch_assoc($result_adm);
                        else $row_adm = array("nr"=>0,"logins"=>0,"actions"=>0,"avg_actions"=>0,"avg_time"=>0,"bounce"=>0);
                            mysqli_free_result($result_adm);
                            mysqli_next_result($conn);  
                            mysqli_close($conn);          
                        ?>
                                    <td>Admin</td>
                                    <td><?=$row_adm['nr']?></td>
                                    <td><?=$row_adm['logins']?></td>
                                    <td><?=$row_adm['actions']?></td>
                                    <td><?=$row_adm['avg_actions']?></td>
                                    <td><?=$row_adm['avg_time']?></td>
                                    <td><?=$row_adm['bounce'],'%'?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

<div id="browser_pie" style="display: none;">
<canvas id="ut_p" width="100" height="100"></canvas>
<script>
 ctx1 = document.getElementById('ut_p');
 ut_p = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['User', 'Admin'],
        datasets: [{
            label: 'User type',
            data: [<?php echo $row['nr'].','. $row_adm['nr'];?>],
            backgroundColor: ['rgb(255, 99, 132)','rgb(54, 162, 235)']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
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
<canvas id="ut_b" width="100" height="100"></canvas>
<script>
 ctx2 = document.getElementById('ut_b');
  ut_b = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['User type', 'Logins', 'Unique users', 'Avg actions per session'],
        datasets: [{
            label: 'User',
            data: [ <?php echo $row['nr'].','.$row['logins'].','.$row['actions'].','.$row['avg_actions'];?>],
            backgroundColor: ['rgb(255, 99, 132)'],
            borderColor: ['rgb(255, 99, 132)'],
            borderWidth: 1
        },
        {
            label: 'Admin',
            data: [ <?php echo $row_adm['nr'].','.$row_adm['logins'].','.$row_adm['actions'].','.$row_adm['avg_actions'];?>],
            backgroundColor: ['rgb(54, 162, 235)'],
            borderColor: ['rgb(54, 162, 235)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
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

        <?php   } 
if (isset($_POST['sdate'])) {
    bringdata($_POST['sdate'],$_POST['edate']);
  }
  else {
    date_default_timezone_set('Europe/Bucharest');
    bringdata(date("Y-m-d"),date("Y-m-d"));
  }
  ?>

<?php include_once 'footer.php';?>