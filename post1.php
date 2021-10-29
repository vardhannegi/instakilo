<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

require_once "config.php";

$status = "";
$status_err  = "";
$image = "";
$image_err = "";

if ($_SERVER['REQUEST_METHOD']=="POST")
{
    if(empty(trim($_POST['image_text'])))
    {
        $status_err  = "status cannot be blank";
    }
    else
    {
        $status = trim($_POST["image_text"]);
    }
    if(empty($_FILES['image']['name']))
    {
        $image_err  = "image cannot be blank";
    }
    else
    {
        $image = $_FILES['image']['name'];
    }

    if(empty($status_err) && empty($image_err))
    {
        $sql = "INSERT INTO post1 (username, status_text, image_name ) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt)
            {
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_status, $param_iname);

                // Set these parameters
                $param_username = $_SESSION["username"];
                $param_status = $status;
                $param_iname = $image;

                // Try to execute the query
                if (mysqli_stmt_execute($stmt))
                {
                    header("location: welcome.php");
                }
                else
                {
                    echo "Something went wrong... cannot redirect!";
                }
            }
            mysqli_stmt_close($stmt);
        $uname = $_SESSION["username"];

        # Location
        $target_dir = "uploads/postuploads/".$uname;

        # create directory if not exists in upload/ directory
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0755);
            $target = $target_dir .basename($image); 
        }
        $target_dir .= "/".$image;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir))
            {
                $msg = "Image uploaded successfully";
            }else
            {
                $msg = "Failed to upload image";
            }

        mysqli_close($conn);

    }
    else{
        header("location: welcome.php");
    }
}

// echo $msg;

function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Save image 
    imagejpeg($image, $destination, $quality); 
     
    // Return compressed image 
    return $destination;
}

?>