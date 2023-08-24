<?php include_once 'layout.php';?>

<div id="rangeoutlinks" class="mb-5 w-25"
    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="ti-calendar"></i>&nbsp;
    <span></span> <i class="ti-angle-down"></i>
</div>

<div class="row" id="links">
<?php   function bringdata($startdate, $enddate){ 
    require_once '../assets/connection.php';?>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Outlinks</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                       
                            <table id="outlinks" class="datatables-out display expandable-table" style="width: 100%;">
                            <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Page</th>
                                        <th>Unique users</th>
                                        <th>Clicks</th>
                                    </tr>
                                </thead>
                                <?php
                                 $sql = "SELECT distinct p.Title, o.PageID, count(distinct o.UserID) as users, count(o.ID) as clicks FROM outlinks as o inner join pages as p on p.ID = o.PageID WHERE date(o.Date) between '$startdate' AND '$enddate' group by o.PageID;";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tbdoy>
                                <tr>
                                <td></td> 
                                <td><?=$row['PageID'];?></td>
                                <td><?=$row['Title'];?></td>
                                <td><?=$row['users'];?></td>
                                <td><?=$row['clicks'];?></td>   
                                                             
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