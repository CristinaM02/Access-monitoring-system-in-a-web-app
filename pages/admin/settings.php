<?php include_once 'layout.php';
      require_once '../assets/connection.php';
      require '../assets/auth/security_functions.php';
      require '../assets/auth/auth_functions.php';
      require '../assets/auth/datacheck.php';
      ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Profile details</p>
                <div class="row justify-content-md-center">
                    <div class="col-10">
                        
                        <img src="../../images/user_uploads/<?=$_SESSION['image'];?>" alt="profile" class="img-lg mb-2 mx-auto d-block">
                        
                        <form method="post" class="pt-3" action="../assets/auth/updateprofile.php"  enctype="multipart/form-data">

              <?php insert_csrf_token(); ?>
              
              <div class="text-danger font-weight-bold mb-2">
              <?php
                            if (isset($_SESSION['STATUS']['updatestatus']))
                            echo $_SESSION['STATUS']['signupstatus'];
                        ?>
                </div>

                <div class="form-group row">
                  <label for="exampleInputUsername1" class="col-sm-2 col-form-label">Username:</label>
                  <div class="col-sm-8">
                  <input type="text" name="username" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username" value="<?=$_SESSION['username'];?>">
                </div> </div>
                <div class="text-danger font-weight-bold mb-2">
              <?php
                            if (isset($_SESSION['ERRORS']['usernameerror']))
                            echo $_SESSION['ERRORS']['usernameerror'];
                        ?>
                </div>

                <div class="form-group row">
                <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-8">
                  <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" value="<?=$_SESSION['email'];?>">
                </div> </div>
                <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['emailerror']))
                          echo $_SESSION['ERRORS']['emailerror'];
                        ?>
                </div>
               
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Profile picture:</label>
                <div class="col-sm-8">
                      <input type="file" name="avatar" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control form-control-lg file-upload-info" disabled="" placeholder="Profile picture" value="<?=$_SESSION['image'];?>">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary new-user" type="button">Upload</button>
                        </span>
                      </div>
                    </div> </div>

                    <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['imageerror']))
                          echo $_SESSION['ERRORS']['imageerror'];
                        ?>
                </div>

                <div class="mt-3 text-center">
                  <button name="submit" class="btn btn-primary btn-block mb-2"> Save changes</button>
                </div>
                
              </form>
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
                <p class="card-title">Change password</p>
                <div class="row justify-content-md-center">
                    <div class="col-12">
                        <form method="post" class="pt-3" action="../assets/auth/changepassword.php"   enctype="multipart/form-data">
                        <?php insert_csrf_token(); ?>

                        <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['changepass']))
                          echo $_SESSION['ERRORS']['changepass'];
                        ?>
                </div>

                        <div class="form-group col-6">
                        <label for="oldpass" class="col-sm-5 col-form-label">Current password</label>
                       <input type="password" name="oldpassword" class="form-control form-control-lg" id="oldpass" placeholder="Current password">
                      
                      </div>

                <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['oldpassworderror']))
                          echo $_SESSION['ERRORS']['oldpassworderror'];
                        ?>
                </div>

                        <div class="row">
                        <div class="form-group col-6">
                        <label for="exampleInputPassword1" class="col-sm-2 col-form-label">New password </label>
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="New password">
                </div>

                <div class="form-group col-6">
                <label class="col-sm-5 col-form-label">Confirm new password</label>
                  <input type="password" name="confirmpassword" class="form-control form-control-lg" placeholder="Confirm new password">
                </div>
</div>
                <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['newpassworderror']))
                          echo $_SESSION['ERRORS']['newpassworderror'];
                        ?>
                </div>

                <div class="mt-3 text-center">
                  <button name="submitpass" class="btn btn-primary btn-block mb-2">Update</button>
                </div>
                        </form>
                  
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
                <p class="card-title">Disable account</p>
                <div class="row justify-content-md-center">
                    <div class="col-12">
                        <div class="table-responsive">
                        <div class="alert alert-warning" role="alert" style="color:#ffab00;">
                        <b> To re-enable your account you will have to contact an administrator.</b>
                  </div>
                  <button type="button" style="color:#fff;" class="btn btn-danger btn-block mb-2 mx-2" onclick="showSwal('warning-message-and-cancel','<?=$_SESSION['id']?>')">Disable</button>
                        </div>
  </div>
</div>          
</div>      
                </div>
            </div>           
        </div>

<?php include_once 'footer.php';?>