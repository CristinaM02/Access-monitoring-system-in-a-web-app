<?php

function page_text($page_id){
    require '../assets/connection.php';
    $sql_content = "SELECT Title, Text FROM page_text WHERE PageID = $page_id;";
    $result_content = mysqli_query($conn, $sql_content);
    if (mysqli_num_rows($result_content) > 0) {
        $content = mysqli_fetch_assoc($result_content);
        echo '<div class="card">
        <div class="card-body">
        <h5 class="card-title">' . $content['Title'] .'</h5>
        <p class="card-text my-5">' . htmlspecialchars_decode($content['Text']) . '</p>
        </div>
        </div>';
    } else {
      echo "<strong> There is no content for this page! </strong>";
    }
    
    mysqli_close($conn);
}

function page_content($page_id){
        page_text($page_id);
}

?>