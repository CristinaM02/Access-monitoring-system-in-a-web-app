<?php 
include_once 'layout.php';
require_once '../assets/user/pagecontent.php';
 
if(isset($_GET['id'])){
?>

<div class="row">
    <div class="col-12">
                <?php page_content($_GET['id']); 
                }?>
    </div>
</div>

<?php include_once 'footer.php';?>

