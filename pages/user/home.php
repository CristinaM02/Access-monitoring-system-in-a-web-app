<?php  include_once 'layout.php'; 
require_once '../assets/connection.php';
$uid = $_SESSION['id'];
$sql = "CALL user_dashboard($uid);";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
mysqli_free_result($result);
mysqli_next_result($conn);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
            <div class="col-md-3 grid-margin">
							<div class="card bg-facebook d-flex align-items-center">
								<div class="card-body">
									<div class="d-flex flex-row align-items-center">
                                    <span class="material-icons text-white icon-md m-ico">login</span>
										<div class="ms-3">
											<h6 class="text-white"><?=$row['logins'];?></h6>
											<p class="mt-2 text-white card-text">logins today</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 grid-margin">
							<div class="card bg-linkedin d-flex align-items-center">
								<div class="card-body">
									<div class="d-flex flex-row align-items-center">
                                    <span class="material-icons text-white icon-md m-ico">auto_stories</span>
										<div class="ms-3">
                                        <h6 class="text-white"><?=$row['pages'];?> pages</h6>
											<p class="mt-2 text-white card-text">viewed today</p>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-md-3 grid-margin">
							<div class="card bg-behance d-flex align-items-center">
								<div class="card-body">
									<div class="d-flex flex-row align-items-center">
                                        <span class="material-icons text-white icon-md m-ico">links</span>
										<div class="ms-3">
                                        <h6 class="text-white"><?=$row['links'];?> outlinks</h6>
											<p class="mt-2 text-white card-text">clicked today</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 grid-margin">
							<div class="card bg-twitter d-flex align-items-center">
								<div class="card-body">
									<div class="d-flex flex-row align-items-center">
                                    <span class="material-icons text-white icon-md m-ico">edit_note</span>
										<div class="ms-3">
											<h6 class="text-white"><?=$row['forms'];?> forms</h6>
											<p class="mt-2 text-white card-text">completions today</p>
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
                  <p class="card-title mb-0">Time on pages</p>
                  <div class="table-responsive">
                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th class="ps-0  pb-2 border-bottom">Page</th>
                          <th class="border-bottom pb-2">Time</th>
                          <th class="border-bottom pb-2">Views</th>
                        </tr>
                      </thead>
                      <?php
                      $sql_time = "select p.Title, count(s.PageID) as v, sum(s.Time_spent) as time from session_logs s  inner join pages p on s.PageID = p.ID where s.UserID = $uid group by PageID LIMIT 7;";
                      $result_time = mysqli_query($conn, $sql_time);
                      ?>
                      <tbody>
                      <?php
                       if (mysqli_num_rows($result_time) > 0) {
                       while($row_time = mysqli_fetch_assoc($result_time)){ ?>
                        <tr>
                          <td class="ps-0"><?=$row_time['Title'];?></td>
                          <td><p class="mb-0"><?=gmdate('H:i:s', $row_time['time'])?></p></td>
                          <td class="text-muted"><?=$row_time['v'];?></td>
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
                    <?php
                    $color = ['bg-primary', 'bg-info', 'bg-secondary', 'bg-warning'];
                      $sql_links = "select ROW_NUMBER() OVER(order by nr desc)-1 r, SUBSTRING(URL, 13, LENGTH(URL)-13) as link, count(ID) as nr, floor(count(ID)*100/(select count(ID) from outlinks where UserID = $uid)) as prc from outlinks where UserID = $uid group by URL LIMIT 4;";
                      $result_links = mysqli_query($conn, $sql_links);
                      ?>
                      <p class="card-title">Last outlinks accessed</p>
                      <div class="charts-data">
                      <?php
                       if (mysqli_num_rows($result_links) > 0) {
                       while($row_links = mysqli_fetch_assoc($result_links)){ ?>
                        <div class="mt-3">
                          <p class="mb-0"><?=$row_links['link'];?></p>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="progress progress-md flex-grow-1 me-4">
                              <div class="progress-bar <?=$color[$row_links['r']];?>" role="progressbar" style="width: <?=$row_links['prc'];?>%" aria-valuenow="<?=$row_links['prc'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0"><?=$row_links['nr'];?></p>
                          </div>
                        </div>
                            <?php } } ?>                  
                      </div>  
                    </div>
                  </div>
                </div>
                <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                  <div class="card data-icon-card-primary">
                    <div class="card-body">
                      <p class="card-title text-white">Pages time</p>                      
                      <div class="row">
                        <div class="col-8 text-white">
                          <?php
                           $total_time = 0;
                           $s = $row['pages_time']%60;
                           $m = floor(($row['pages_time']%3600)/60);
                           $h = floor(($row['pages_time']%86400)/3600);
                           if($h > 0) $total_time = $h ."h ". $m . " mins " . $s ." s";
                               else if($m > 0) $total_time = $m . " mins " . $s ." s";
                               else if($s > 0) $total_time = $s ."s";
                          ?>
                          <h3><?=$total_time;?></h3>
                          <p class="text-white font-weight-500 mb-0">The overall time spent viewing pages today.</p>
                        </div>
                        <div class="col-4 background-icon">
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
                  <p class="card-title">Other users have seen</p>
                  <?php $sql_other = "SELECT u.Username, p.Title, s.Start_Time, u.Image
                    from session_logs s inner join users u on s.UserID = u.ID inner join pages p on p.ID = s.PageID where u.Id <> $uid order by s.Start_Time desc LIMIT 5;";
                    $result_other = mysqli_query($conn, $sql_other);
                    ?>
                  <ul class="icon-data-list">
                  <?php
                       if (mysqli_num_rows($result_other) > 0) {
                       while($row_other = mysqli_fetch_assoc($result_other)){ ?>
                    <li>
                      <div class="d-flex">
                        <img src="../../images/user_uploads/<?=$row_other['Image']?>" alt="user">
                        <div>
                          <p class="text-info mb-1"><?=$row_other['Title']?></p>
                          <p class="mb-0"><?=$row_other['Username']?></p>
                          <small><?php $date=date_create($row_other['Start_Time']);
                      echo date_format($date,"d F") . ", " . date_format($date,"H:i"); ?></small>
                        </div>
                      </div>
                    </li>
                    <?php } } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

<?php include_once 'footer.php';?>