<?php
   require 'assets/auth/security_functions.php';
   require 'assets/auth/auth_functions.php';
    check_logged_out();
    generate_csrf_token();
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
  <?php if (isset($_GET['selector']))
  echo '<link rel="stylesheet" href="../../css/layout/style.css">';
  else echo '<link rel="stylesheet" href="../css/layout/style.css">';?> 
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
              <?php if (isset($_GET['selector'])) 
              echo '<img src="../../images/logo.png" alt="logo">';
              else echo '<img src="../images/logo.png" alt="logo">';
              ?>
              </div>
              <h4>Password reset</h4>
              <?php if (isset($_GET['selector']) && isset($_GET['validator'])) {;?>

            <form class="pt-3" action="../assets/auth/resettoken.php" method="post">
                <?php
                    insert_csrf_token();
                    $selector = $_GET['selector'];
                    $validator = $_GET['validator'];
                ?>
            <input type="hidden" name="selector" value="<?php echo $selector; ?>">
            <input type="hidden" name="validator" value="<?php echo $validator; ?>">
            <div class="text-success font-weight-bold mb-2">
              <?php
                if (isset($_SESSION['STATUS']['resetsubmit']))
                echo $_SESSION['STATUS']['resetsubmit'];
                    ?>
                </div>
            <div class="text-danger font-weight-bold mb-2">
              <?php
                if (isset($_SESSION['ERRORS']['passworderror']))
                 echo $_SESSION['ERRORS']['passworderror'];
                    ?>
                </div>

                <div class="form-group form-floating">
                  <input type="password" id="newpassword" name="newpassword" class="form-control form-control-lg" placeholder="New password" required>
                  <label for="newpassword">New password</label>
                </div>

                <div class="form-group form-floating">
                  <input type="password" id="confirmpassword" name="confirmpassword" class="form-control form-control-lg" placeholder="Confirm password" required>
                  <label for="confirmpassword">New password</label>
                </div>

                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="resetsubmit">
                    RESET</button>
                </div>
              </form>
              <?php } else { ?>
            
              <form method="post" action="assets/auth/passreset.php" class="pt-3">
              <?php insert_csrf_token(); ?>
              <div class="text-success font-weight-bold mb-2">
              <?php
                                    if (isset($_SESSION['STATUS']['resentsend']))
                                        echo $_SESSION['STATUS']['resentsend'];

                                ?>
                </div>
                <div class="text-danger font-weight-bold mb-2">
                <?php
                                    if (isset($_SESSION['ERRORS']['emailerror']))
                                        echo $_SESSION['ERRORS']['emailerror'];
                                ?>
                </div>
                <div class="form-group form-floating">
                  <input type="email" name="email" class="form-control form-control-lg" id="Email" placeholder="Email" required>
                  <label for="Email">Email</label>
                </div>
                
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="resentsend">
                    RESET</button>
                </div>
 
                <div class="text-center mt-4 font-weight-light">
                  Back to <a href="../index.php" class="text-primary">homepage</a>
                </div>
              </form>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->


</body>

</html>
