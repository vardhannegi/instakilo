<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

require_once "config.php";

$output = '';
$count = '';
$uname = $_SESSION['username'];
$pathx = "uploads/postuploads/";

$newarray = array();

    $query = mysqli_query($conn,"SELECT id,username, status_text,image_name, created_at FROM post1") or die("could not search!");
    $count = mysqli_num_rows($query);
    // $count .= $count; 
    if($count == 0) {
        $output = ' No one is going tere!';

    } else
    {
      // $new = mysqli_fetch_array($query);
      // array_push($row,$new);
        while($row = mysqli_fetch_array($query)) {
          $newarray[] = $row;
            // $uname = $row['username'];
            // $statustext = $row['status_text'];
            // $posttime = $row['created_at'];
            
            // $output .= '<div>'.$uname.'<img src="'.$pathx.$show_image.'">'. '<br>'.$posttime.'<br>'.$statustext.'</div>' ;
        }
    }

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" href="mystyle.css"> -->
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>instakilo</title>
</head>

<body>

    <div class="container1">
        <div class=" menu">
            <div class="navitem">
                <div class="item"><a href="#" title="Logo">
                        <img src="https://img.icons8.com/ios-filled/38/000000/instagram-new--v2.png" alt="Restaurant Logo" id="logo">
                    </a>
                </div>
                <div class="item">InstaKilo</div>
            </div>

            <div class="navitem textcenter ">
                <form>
                    <input class="sbar textcenter" type="text" name="searchbox" placeholder="search">
                </form>
            </div>

            <div class="floatright navitem ">
                <a href="#" class="itemright">
                    <img src="icons/home24px.png" class="img-responsive">
                </a>
                <a href="#" class="itemright">
                    <img src="icons/message24px.png" alt="Restaurant Logo" class="img-responsive">
                </a>
                <a href="#" class="itemright">
                    <img src="icons/like24px.png" class="img-responsive">
                </a>

                <?php 
                echo'
                <a class="itemright" href= "profile.php?userproname='.$_SESSION['username'].'"><img class="itemright" src="icons/login-as-user-32.png" > hi '. $_SESSION['username'].'</a>
                <a class="itemright" href="logout.php">Logout</a>';
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>



    <?php 
              echo "<br>";
              // echo '<div style="border-style:solid;">';
              foreach ($newarray as $value) {
                $show_image = $value['image_name'];
                $pathy = $pathx.$value["username"].'/';
                echo '<div class="container2">
                      <div class="postdiv">
                        <div class="posthead postdiv">
                          <div class="postheaditem">
                            <img src="https://img.icons8.com/ios-filled/28/000000/instagram-new--v2.png"/ id="logo">
                          </div>
                          <div class="menu postheaditem" style="width: 85%; ">
                               <a href="profile.php?userproname='.$value["username"].'">'.$value["username"].'</a>
                            <button class="dotbtn">
                              <svg aria-label="More options"  color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24">
                              <circle cx="12" cy="12" r="1.5"></circle>
                              <circle cx="6.5" cy="12" r="1.5"></circle>
                              <circle cx="17.5" cy="12" r="1.5"></circle></svg>
                            </button>
                          </div>
                          
                         </div>
                          
                         <div class="clearfix"></div>';

                         if(strpos($show_image, 'mp4') !== false) {
                          echo ' <div >
                          <video class="postimg "  controls src='.$pathy.$show_image.'></video>
                          </div>';
                      }else{
                        echo'<div class="postimg" style="background-image:url('.$pathy.$show_image.'); flex:2;"></div >
                        </div>';
                      }


                         echo'
                           
                        </div>
                        <div class="postreact postdiv">
                          <div class="reactitem">
                            <input type="image" name="Name of image button" onclick="this.src=\'icons/heart24px.png\'"/ class="divitems" src="icons/like24px.png">
                            <img class="divitems" src="icons/comments24px.png">
                            <img class="divitems" src="icons/sent24px.png">
                          </div>
                          <div class="floatright reactitem">
                            <img class="divitems" src="icons/bookmark24px.png">
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="likes postdiv"><b>1513 likes</b></div>
                        <div class=" postdiv">
                          <div class="caption">
                            <div class="captionitem">'.$value["username"].' : </div>
                            <div >'.$value['status_text'].'</div>
                          </div>';
                      ?>

    <?php 
                        $id = $value['id'];
                      
                        $sql = "SELECT * FROM `comments` WHERE post_id=$id ";
                              $result = mysqli_query($conn,$sql);
                              while($row = mysqli_fetch_assoc($result)){
                                  $uname = $row['user_name'];
                                  $cmnt = $row['comment'];
                                  echo '<div class="cmnt">
                                  <div ><b>'.$uname.'</b></div>
                                  <div >'.$cmnt.'</div>                                             
                              </div>';
                              }

                       ?>
    <?php
                      echo '<div class="cmntbar">
                        <div class="postitem"><img class="divitems" src="icons/like24px.png"></div>
                        <div>
                          <form method="post" action="comment.php">
                          <input type="hidden" name="postid" value="'.$value['id'].'">
                          <input type="hidden" name="user_name" value="'.$_SESSION["username"].'">
                          <input class="cmntinput menu" type="text" name="cmnt" placeholder="Post">
                          <input class="btn" type="submit" value="Submit">
                          </form>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>';
                
              }
              ?>
    <?php

// // Create a directory Iterator
// $directory = new DirectoryIterator(dirname(__FILE__));

// // Loop runs for each element of directory
// foreach($directory as $dir) {
	
// 	// Display the filename
// 	echo $dir->getFilename() . "<br>";
// }
?>











    </div>
    </div>
    <div class='container_item'></div>
    </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script> -->

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>