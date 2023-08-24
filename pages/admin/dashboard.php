<?php include_once 'layout.php';
require_once '../assets/connection.php';
$sql = "CALL admin_dashboard();";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
mysqli_free_result($result);
mysqli_next_result($conn); 
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div>
                <div class="card-people mt-auto">
                  <img src="../../images/wallpaper.png" alt="wallpaper">
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent mt-5">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Users registered today</p>
                      <p class="fs-30 mb-2"><?=$row['regis_today'];?></p>
                      <p><?=$row['prc_reg'];?>% of total users</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">New logins today</p>
                      <p class="fs-30 mb-2"><?=$row['new_logged'];?></p>
                      <p><?=$row['prc_new'] ?: 0;?>%</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Users logged in today</p>
                      <p class="fs-30 mb-2"><?=$row['users_today'];?></p>
                      <p><?=$row['prc_u'] ?: 0;?>%</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Admins logged in today</p>
                      <p class="fs-30 mb-2"><?=$row['admins_today'];?></p>
                      <p><?=$row['prc_a'] ?: 0;?>%</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

            <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
                <div class="card position-relative">
                    <div class="card-body">
          <div class="row">
                          <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                            <div class="ml-xl-4 mt-3">
                            <p class="card-title">Current sessions</p>
                              <h1 class="text-primary"><?=$row['logged_now'];?></h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary">users logged in</h3>
                              <p class="mb-2 mb-xl-0">The total number of active sessions at this moment, including both users and admins, along with the top 5 cities of active users.</p>
                            </div>  
                            </div>
                          <div class="col-md-12 col-xl-9">
                            <div class="row">
                              <div class="col-md-6 border-right">
                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                  <?php
                                  $color = ['bg-primary', 'bg-info', 'bg-secondary', 'bg-warning', 'bg-danger'];
                                  $sql_city = "select  ROW_NUMBER() OVER(order by nr desc)-1 r, City, count(ID) as nr, floor((count(ID)*100/(select count(ID) from login_logs where date(Login) = CURDATE() and City = City and Logout is null and Status = 'Success'))) as prc from login_logs where date(Login) = CURDATE() and Logout is null and Status = 'Success' group by City LIMIT 5;";
                                  $result_city = mysqli_query($conn, $sql_city);
                                  ?>
                                  <table class="table table-borderless report-table">
                                    <tbody>
                                      <?php
                                      if (mysqli_num_rows($result_city) > 0) {
                                        while($row_city = mysqli_fetch_assoc($result_city)){ ?>
                                      <tr>
                                      <td class="text-muted"><?=$row_city['City'];?></td>
                                      <td class="w-100 px-0">
                                        <div class="progress progress-md mx-4">
                                          <div class="progress-bar <?=$color[$row_city['r']];?>" role="progressbar" style="width: <?=$row_city['prc'];?>%" aria-valuenow="<?=$row_city['prc'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </td>
                                      <td><h5 class="font-weight-bold mb-0"><?=$row_city['nr'];?></h5></td>
                                    </tr>
                                      <?php } }?>                                      
                                  </tbody></table>
                                </div>
                              </div>
                              <div class="col-md-6 mt-3">                                
<canvas id="active_users" width="400" height="400"></canvas>
<script>
 ctx1 = document.getElementById('active_users');
 active_users = new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: ['Users','Admins'],
        datasets: [{
            label: 'Active users',
            data: [<?=$row['users_now'] . ',' . $row['admins_now'];?>],
            backgroundColor: ["#4B49AC", "#FFC100"]
        }]
    },
    options: {
    responsive: true,
    aspectRatio: 1.8,
    borderWidth: 0,
    cutout: 78,
    plugins: {
            legend: {
                display: false
            },
        }
}
});
</script>
                                <div id="north-america-legend">
                                    <div class="report-chart">
                                        <div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: #4B49AC"></div>
                                                <p class="mb-0">Users</p></div>
                                                <p class="mb-0"><?=$row['users_now'];?></p></div>
                                                <div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: #FFC100"></div>
                                                        <p class="mb-0">Admins</p></div><p class="mb-0"><?=$row['admins_now'];?></p></div>
                                                        
                                                    </div>
                                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
                          </div>
                        </div>
                        </div>
 
                        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="card-title mb-0">Latest users actions</p>
                  <div class="table-responsive">
                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th class="ps-0  pb-2 border-bottom">Page</th>
                          <th class="border-bottom pb-2">Action</th>
                          <th class="border-bottom pb-2">User</th>
                        </tr>
                      </thead>
                      <?php
                      $sql_user = "(Select p.Title as Page, 'Page visit' as Event, u.Username as User, u.ID as uid, s.Start_Time as dt
                      from session_logs s inner join users u on s.UserID = u.ID inner join pages p on p.ID = s.PageID)
                      UNION
                      (Select p.Title as Page, 'Outlink click' as Event, u.Username as User, u.ID as uid, s.Date as dt
                      from outlinks s inner join users u on s.UserID = u.ID inner join pages p on p.ID = s.PageID)
                      UNION
                      (Select s.Form_name as Page, 'Form completion' as Event, u.Username as User, u.ID as uid, s.Start_Time as dt
                      from forms s inner join users u on s.UserID = u.ID)
                      order by dt desc LIMIT 7;";
                      $result_user = mysqli_query($conn, $sql_user);
                      ?>
                      <tbody>
                      <?php
                       if (mysqli_num_rows($result_user) > 0) {
                       while($row_user = mysqli_fetch_assoc($result_user)){ ?>
                        <tr>
                          <td class="ps-0"><?=$row_user['Page'];?></td>
                          <td><p class="mb-0"><?=$row_user['Event'];?></p></td>
                          <td><a class="text-muted" href="userinfo.php?id=<?=$row_user['uid'];?>"><?=$row_user['User'];?></a></td>
                        </tr>
                       <?php } } ?> 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <p class="card-title">Users actions performed today</p>
                      <div class="charts-data">
                        <div class="mt-3">
                          <p class="mb-0">Page views</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar bg-inf0" role="progressbar" style="width: <?=$row['prc_pg'];?>%" aria-valuenow="<?=$row['prc_pg'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row['pgs_view'];?></p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Outlink clicks</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: <?=$row['prc_link'];?>%" aria-valuenow="<?=$row['prc_link'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row['links'];?></p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Form completions</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: <?=$row['prc_form'];?>%" aria-valuenow="<?=$row['prc_form'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row['forms'];?></p>
                          </div>
                        </div>
                        
                      </div>  
                    </div>
                  </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <p class="card-title">Admins actions performed today</p>
                      <div class="charts-data">
                        <div class="mt-3">
                          <p class="mb-0">Page creations</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar bg-inf0" role="progressbar" style="width: <?=$row['pgc'];?>%" aria-valuenow="<?=$row['pgc'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row['pgs_create'];?></p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Page updates</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: <?=$row['pgu'];?>%" aria-valuenow="<?=$row['pgu'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row['pgs_update'];?></p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-0">Page content updates</p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar bg-info" role="progressbar" style="width: <?=$row['cu'];?>%" aria-valuenow="<?=$row['cu'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row['content_update'];?></p>
                          </div>
                        </div>
                        
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="card-title mb-0">Latest admins actions</p>
                  <div class="table-responsive">
                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th class="ps-0  pb-2 border-bottom">Page</th>
                          <th class="border-bottom pb-2">Action</th>
                          <th class="border-bottom pb-2">User</th>
                        </tr>
                      </thead>
                      <?php
                      $sql_admin = "Select p.Title as Page, s.Event_Description as Event, u.Username as User, u.ID as uid
                      from admin_session_logs s inner join users u on s.UserID = u.ID inner join pages p on p.ID = s.PageID
                      order by s.Date desc LIMIT 7;";
                      $result_admin = mysqli_query($conn, $sql_admin);
                      ?>
                      <tbody>
                      <?php
                       if (mysqli_num_rows($result_admin) > 0) {
                       while($row_admin = mysqli_fetch_assoc($result_admin)){ ?>
                        <tr>
                          <td class="ps-0"><?=$row_admin['Page'];?></td>
                          <td><p class="mb-0"><?=$row_admin['Event'];?></p></td>
                          <td><a class="text-muted" href="userinfo.php?id=<?=$row_admin['uid'];?>"><?=$row_admin['User'];?></a></td>
                        </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

<?php include_once 'footer.php';?>