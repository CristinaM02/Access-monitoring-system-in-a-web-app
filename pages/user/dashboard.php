<?php 
include_once 'layout.php';
require_once '../assets/connection.php';
$user_id = $_SESSION['id'];
$sql = "CALL GetPages($user_id)";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row portfolio-grid">

                            <?php while($row = mysqli_fetch_assoc($result)) { 
                                $description = (strlen($row["Description"]) > 80) ? substr($row["Description"], 0, 70) . "..." : $row["Description"];
                                    echo '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                    <a href = "page.php?id=' . $row["ID"] .'">  
                                    <figure class="effect-text-in">                          
                                    <img src="../../images/pages/' . $row["CoverImage"] . '" alt="Page Cover">
                                    <figcaption>
                                    <h4> ' . $row["Title"] . '</h4>
                                    <p>' . $description . '</p>
                                    </figcaption>
                                    </figure>
                                    </a>
                                    </div>';
                                    }
                                        } else
                                            echo "You currently don't have access rights to any page!";
                                        mysqli_close($conn);
                                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php';?>