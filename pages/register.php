<?php
session_start();
require 'assets/auth/security_functions.php';
require 'assets/auth/auth_functions.php';
require 'assets/auth/datacheck.php';
check_logged_out();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Access Monitor</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Styles -->
  <link rel="stylesheet" href="../css/layout/style.css">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../images/logo.png" alt="logo">
              </div>
              <h4>New here?</h4>
              <h6 class="font-weight-light">Sign up in a few steps.</h6>
              <form method="post" class="pt-3" action="assets/auth/register.php" enctype="multipart/form-data">

              <?php insert_csrf_token(); ?>
              
              <div class="text-danger font-weight-bold mb-2">
              <?php
                            if (isset($_SESSION['STATUS']['signupstatus']))
                            echo $_SESSION['STATUS']['signupstatus'];
                        ?>
                </div>

                <div class="form-group form-floating">
                  <input type="text" name="username" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username"
                  readonly onfocus="this.removeAttribute('readonly');">
                  <label for="username">Username</label>
                </div>
                <div class="text-danger font-weight-bold mb-2">
              <?php
                            if (isset($_SESSION['ERRORS']['usernameerror']))
                            echo $_SESSION['ERRORS']['usernameerror'];
                        ?>
                </div>

                <div class="form-group form-floating">
                  <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                  <label for="email">Email</label>
                </div>
                <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['emailerror']))
                          echo $_SESSION['ERRORS']['emailerror'];
                        ?>
                </div>

                <div class="form-group form-floating">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                  <label for="password">Password</label>
                </div>
                <div class="form-group form-floating">
                  <input type="password" name="confirmpassword" class="form-control form-control-lg" placeholder="Confirm password">
                  <label for="confirmpassword">Confirm password</label>
                </div>
                
                <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['passworderror']))
                          echo $_SESSION['ERRORS']['passworderror'];
                        ?>
                </div>
                
                <div class="form-group">
                      <input type="file" name="avatar" class="file-upload-default">            
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control form-control-lg file-upload-info" disabled="" placeholder="Profile picture">
                        
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>

                    <div class="text-danger font-weight-bold mb-2">
                <?php
                          if (isset($_SESSION['ERRORS']['imageerror']))
                          echo $_SESSION['ERRORS']['imageerror'];
                        ?>
                </div>

                <div class="mt-3">
                  <button name="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    SIGN UP</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="../index.php" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<script src="../vendors/js/vendor.bundle.base.js"></script> 
<script src="../js/file-upload.js"></script> 
</body>

</html>
