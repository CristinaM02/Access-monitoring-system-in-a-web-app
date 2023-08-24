<?php include_once 'layout.php';
require '../assets/auth/security_functions.php';
require '../assets/auth/auth_functions.php';
require '../assets/auth/datacheck.php';
require '../assets/connection.php';

if(isset($_SESSION["STATUS"]["loginstatus"])){
 echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="newuser">
  Page successfully created!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
?>
<script src="//cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>

<form method="post" id="form" action="../assets/admin/addpage.php" enctype="multipart/form-data">

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            
                <p class="card-title">Add new page</p>
                <div class="row justify-content-center">
                    <div class="col-6">
                            <?php insert_csrf_token(); ?>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                            if (isset($_SESSION['STATUS']['signupstatus']))
                            echo $_SESSION['STATUS']['signupstatus'];
                         ?>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control form-control-lg" id="title" />
                                
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="maxlength-textarea" rows="5" maxlength="500"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="avatar">Cover image</label>
                                <input type="file" name="avatar" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control form-control-lg file-upload-info"
                                        disabled="">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary new-user" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                          if (isset($_SESSION['ERRORS']['imageerror']))
                          echo $_SESSION['ERRORS']['imageerror'];
                        ?>
                            </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Page content</p>
                <div class="row justify-content-center">
                    <div class="col-10">

                    <div class="form-group">
                                <label for="contenttitle">Title</label>
                                <input type="text" name="contenttitle" class="form-control form-control-lg" id="contenttitle" >
                            </div>
                            <div class="form-group">
                            <label for="editor1">Content to display</label>
                    <textarea name="editor1" id="editor1" rows="10" cols="80"></textarea> </div>
                    <script>
    CKEDITOR.replace('editor1', {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [

    { name: 'links' },
    { name: 'insert' },
    { name: 'tools' },
    { name: 'document',       groups: [ 'mode' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
    { name: 'styles' },
    { name: 'colors' }
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Save,Print,Iframe,Smiley,Anchor'
    });
  </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Access rights</p>
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="row">
                            <div class="col-sm-5">
                                <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                                    <?php 
                                    $sql = "SELECT id, username FROM users where role='user';";
                                        $result = mysqli_query($conn, $sql);
            
                                        if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'. $row["id"] . '">'. $row["username"] . '</option>';
                                        }
                                        } else {
                                        echo "There are no users to display!";
                                        }
                                        mysqli_close($conn);
                                        ?>

                                        </select>
                                        </div>

                                        <div class="col-sm-2 d-flex align-items-end flex-column">
                                        <button type="button" id="multiselect_rightAll" class="btn multiselectbtn"><i
                                                class="ti-angle-double-right"></i></button>
                                        <button type="button" id="multiselect_rightSelected" class="btn multiselectbtn"><i
                                                class="ti-angle-right"></i></button>
                                        <button type="button" id="multiselect_leftSelected" class="btn multiselectbtn"><i
                                                class="ti-angle-left"></i></button>
                                        <button type="button" id="multiselect_leftAll" class="btn multiselectbtn"><i
                                                class="ti-angle-double-left"></i></button>
                                    </div>

                                    <div class="col-sm-5">
                                        <select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple"></select>
                                    </div>
                                    <div class="container mt-5">
                                    <div class="row justify-content-center">
                                    <div class="col-2">
                                    <button type="submit" name="submit" class=" btn btn-primary">Add</button>
                    
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
</form>


<?php include_once 'footer.php';?>

