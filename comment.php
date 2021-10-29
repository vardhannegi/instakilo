<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $post_id = $_POST['postid'];
    $cmntusername = $_POST['user_name'];
    $cmnt = $_POST['cmnt'];

    $sql = "INSERT INTO `comments` (`post_id`, `user_name`, `comment`, `created_at`)
     VALUES ('$post_id', '$cmntusername', '$cmnt', current_timestamp())";
    $result = mysqli_query($conn,$sql);
    header("Location: welcome.php");
}
?>