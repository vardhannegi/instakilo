<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

require_once "config.php";

$sql = "DELETE FROM `post1` WHERE `post1`.`id` = 38";
$stmt = mysqli_query($conn, $sql);
header("location: profile.php");

?>