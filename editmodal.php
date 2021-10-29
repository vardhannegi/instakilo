<?php

include 'config.php'
    // $id = $_GET['post_id'];
    if(isset($_POST['submit'])){
        $statusupdate = $_POST['statusupdate'];


        $sql = "UPDATE `post1` SET `status_text` = '$statusupdate' WHERE `post1`.`id` = 39";
        $result = mysqli_query($conn,$sql);
        header("location: welcome.php");
        
        
    }
    ?>
    