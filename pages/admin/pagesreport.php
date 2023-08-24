<?php include_once 'layout.php';
?>

<div id="rangepages" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>

<div class="row" id="pages">
<?php   function bringdata($startdate, $enddate){ 
    require_once '../assets/connection.php';?>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Pages</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                        <table id="pgs" class="datatables-pgs display expandable-table" style="width: 100%;">
                            <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Page views</th>
                                        <th>Unique viewers</th>
                                        <th>Sessions</th>
                                        <th>Avg. time on page</th>
                                        <th>Bounce rate</th>
                                        <th>Exit rate</th>
                                    </tr>
                                </thead>
                                <?php
                        $sql = "SELECT distinct pg.Title, count(sl.UserID) as total_views, count(distinct sl.UserID) as unique_viewers, count(distinct sl.Log_ID) as sessions, floor(sum(Time_spent)/count(distinct sl.Log_ID)) as avg_time, floor(Get_Page_BounceRate(sl.PageID,'$startdate','$enddate')*100/count(distinct sl.Log_ID)) as bounce, floor(Get_Page_ExitRate(sl.PageID,'$startdate','$enddate')*100/count(distinct sl.Log_ID)) as ex FROM session_logs as sl inner join pages as pg on pg.ID = sl.PageID WHERE DATE(sl.Start_Time) BETWEEN '$startdate' AND '$enddate' GROUP BY sl.PageID;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result) ){ 
                            $time = gmdate('H:i:s', $row['avg_time']);     
                        ?>
                                <tbdoy>
                                <tr>
                                <td><?=$row['Title'];?></td>  
                                <td><?=$row['total_views'];?></td> 
                                <td><?=$row['unique_viewers'];?></td> 
                                <td><?=$row['sessions'];?></td> 
                                <td><?=$time;?></td> 
                                <td><?=$row['bounce'].'%';?></td> 
                                <td><?=$row['ex'].'%';?></td> 
                                                             
</tr>
<?php }} ?>

</tbody>
                            </table>
                        </div>                    
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