<?php include_once 'layout.php';
require '../assets/connection.php';
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Contact us</p>
                <div class="row justify-content-md-center form-container">
                   
                       
                            <div class="text-danger font-weight-bold mb-2">
                                <?php
                            if (isset($_SESSION['STATUS']['contactform']))
                            echo $_SESSION['STATUS']['contactform'];
                         ?>
                            </div>

                            <div class="row">
                        <div class="form-group col-6">
                        <label class="col-sm-2 col-form-label">First name</label>
                  <input type="text" name="fname" class="form-control form-control-lg" placeholder="First name" required>
                </div>

                <div class="form-group col-6">
                <label class="col-sm-5 col-form-label">Last name</label>
                  <input type="text" name="lname" class="form-control form-control-lg" placeholder="Last name" required>
                </div>
                </div>

                <div class="form-group col-8 mx-auto">
                        <label class="col-sm-2 col-form-label">Email</label>
                  <input type="email" name="email" class="form-control form-control-lg" placeholder="First name" required>
                </div>

                <div class="form-group col-8 mx-auto">
                        <label class="col-sm-2 col-form-label">Message</label>
                        <textarea class="form-control" name = "message" rows="8" placeholder="Type your message..." required></textarea>
                </div>

                <div class="text-center my-3">
                       <button type="button" name="submit" id="submitcontact" class=" btn btn-primary">Submit</button>
                    </div>
                       

                   </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'footer.php';?>
