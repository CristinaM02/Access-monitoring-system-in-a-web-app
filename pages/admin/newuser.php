<?php include_once 'layout.php';
require '../assets/auth/security_functions.php';
require '../assets/auth/auth_functions.php';
require '../assets/auth/datacheck.php';

if(isset($_SESSION["STATUS"]["loginstatus"])){
 echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="newuser">
  User successfully added!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
?>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Add new user</p>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <form method="post" id="form" action="../assets/admin/adduser.php" enctype="multipart/form-data">
                            <?php insert_csrf_token(); ?>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                            if (isset($_SESSION['STATUS']['signupstatus']))
                            echo $_SESSION['STATUS']['signupstatus'];
                         ?>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg"
                                    id="username" readonly onfocus="this.removeAttribute('readonly');" />     
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
              <?php
                            if (isset($_SESSION['ERRORS']['usernameerror']))
                            echo $_SESSION['ERRORS']['usernameerror'];
                        ?>
                </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" name="email" class="form-control form-control-lg"
                                    id="email">
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['emailerror']))
                          echo $_SESSION['ERRORS']['emailerror'];
                        ?>
                </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-select form-control form-control-lg" name="role" id="Role">
                                    <option selected value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg"
                                    id="password">
                                    
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password" name="confirmpassword" class="form-control form-control-lg" id="confirmpassword">
                                
                            </div>
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                          if (isset($_SESSION['ERRORS']['passworderror']))
                          echo $_SESSION['ERRORS']['passworderror'];
                         ?>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Profile picture</label>
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
                <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-2">
                       <button type="submit" name="submit" class=" btn btn-primary">Add</button>
                        </form>
                    </div>
                   </div>
</div>
            </div>

        </div>
    </div>
</div>
<?php include_once 'footer.php';?>
