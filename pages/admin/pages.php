<?php include_once 'layout.php';
      require_once '../assets/connection.php';
      
      $sql = "SELECT ID,Title, Description, Status, LastModification FROM pages";
      $result = $conn->query($sql);
      $arr_pages = [];
      if ($result->num_rows > 0) {
          $arr_pages = $result->fetch_all(MYSQLI_ASSOC);
      }
      ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Pages</p>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
      <table id="pages_list" class="datatables-pages display expandable-table" style="width:100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Last modification</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($arr_pages)) { ?>
        <?php foreach($arr_pages as $page) { ?>
        <tr>
            <td><?php echo '<a href="managepage.php?id='. $page['ID'] .'" class="link-dark"><b>' .$page['Title'] . '</b></a>' ?></td>
            <td><?php echo substr($page['Description'], 0, 100);?></td>
            <td> <label class="badge
            <?php if ($page['Status'] == 'Active') {echo " badge-success";} else {echo " badge-danger";}?>
            ">
                <?php echo $page['Status']; ?></td> </label>
                <td><?php $date=date_create($page['LastModification']);
                                        echo date_format($date,"d-m-Y H:i:s"); ?></td>
            <td>
                <div class="btn-group dropleft">
                    <i class="icon-options-vertical" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </i>
                    <div class="dropdown-menu" x-placement="right-start"
                        style="position: absolute; transform: translate3d(111px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a href="managepage.php?id=<?=$page['ID']?>" class="dropdown-item">View</a>
                        <a href="javascript:ChangePageStatus('<?php echo $page['Status']; ?>',
                        '<?php echo $page['ID']; ?>')" class="dropdown-item enable-page">
                        <?php if ($page['Status'] == 'Active') {echo "Disable";} else {echo "Enable";}?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:DeletePage('<?php echo $page['ID']; ?>')" class="dropdown-item text-danger delete-record">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>

</table>

</div>
  </div>
</div>
                    </div>
                </div>
            </div>
            
        </div>


<?php include_once 'footer.php';?>