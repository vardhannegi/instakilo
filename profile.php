<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: index.php");
}

require_once "config.php";

$output = '';
$count = '';
$uname = $_GET['userproname'];
$pathx = "uploads/postuploads/".$uname."/";

$newarray = array();
// $uname = $_SESSION['username'];


    $query = mysqli_query($conn,"SELECT * FROM post1 WHERE username= '".$_GET['userproname']."'") or die("could not search!");
    $count = mysqli_num_rows($query);
    if($count == 0) {
        $output = 'Nothing posted yet!';

    } else{
        while($row = mysqli_fetch_array($query)) {
          $newarray[] = $row;
            // $statustext = $row['status_text'];
            // $time = $row['created_at'];

            // $output .= '<div>'.$time.' <br> '.$statustext.'</div>';
        }
    }
    if(isset($_GET['delete'])){
      $sno = $_GET['delete'];
      $sql1 = "DELETE FROM `post1` WHERE `post1`.`id` = $sno";
      $sql2= "DELETE FROM `comments` WHERE `comments`.`post_id` = $sno";
  
      $stmt1 = mysqli_query($conn, $sql1);
      $stmt2 = mysqli_query($conn, $sql2);      
      header("location: profile.php?userproname=".$_SESSION["username"]);
    }


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Instakilo</title>
</head>

<body>



    <?php
                     
                     if(isset($_POST['postid1'])){
                      $statusupdate = $_POST['statusupdate'];
                      $post1 = $_POST['postid1'];
              
                      $sql = "UPDATE `post1` SET `status_text` = '$statusupdate' WHERE `post1`.`id` = $post1";
                      $result = mysqli_query($conn,$sql);
                                               
                      
                  }
                  ?>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="hidden" name="postid1" id="postid1">
                            <label for="editInputEmail1">Email address</label>
                            <input type="text" class="form-control" name="statusupdate" id="editInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <div class="container1">
        <div class=" menu">
            <div class="navitem">
                <div class="item"><a href="#" title="Logo">
                        <img src="https://img.icons8.com/ios-filled/38/000000/instagram-new--v2.png" /
                            alt="Restaurant Logo" id="logo">
                    </a>
                </div>
                <div class="item"><a href="welcome.php" title="Logo">InstaKilo</a></div>
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


    <!-- <script>
   function mydrop() {
      document.getElementById("mydropdown").innerHTML += '<div style="list-style-type: none;"><li><a class="dropdown-item" data-value="delete" href="delete.php">Delete</a></li><li><a class="dropdown-item" href="#">Separated link</a></li></div>';
}
</script> -->


    <!-- <button class="dotbtn" id="mydropdown" onclick=mydrop()>
                                              
  <svg aria-label="More options"  color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24">
  <circle cx="12" cy="12" r="1.5"></circle>
  <circle cx="6.5" cy="12" r="1.5"></circle>
  <circle cx="17.5" cy="12" r="1.5"></circle></svg> -->

    <!-- <span class="btnspan"><button class="dotbtn edit" id='.$id.'>Edit</button> <button class="dotbtn delete" id='.$did.' onclick=mydrop()>Delete</button></span> -->
    <!-- <a href="editmodal.php?post_id='.$id.'" class="btnspan btn-outline-success ml-6" data-toggle="modal" data-target="#editModal">Edit</a> -->
    <?php
    $profile_user = $_GET['userproname'];
    echo '<div class="profil_container">
        <div class="proitem">
            <div ><img src="https://img.icons8.com/windows/96/000000/login-as-user.png" /></div>
            <div ><h1> Hi '. $profile_user.'</h1></div>';
            if($_SESSION['username']!==$_GET['userproname']){
            echo'<div><a href="message.html" class="itemright"> Message </a></div>';
            }
            
            
      if($_SESSION['username']==$_GET['userproname']){
        echo'
          <div ><a " href="#">Edit Profile</a></div>
          
      </div>
  
        <div >
          <form action = "post1.php" method="post" enctype="multipart/form-data">
          <label >What\'s in your mind</label><br>
          <textarea 
            id="text" 
            cols="40" 
            rows="4" 
            name="image_text" 
            placeholder="Say something about this image...">
          </textarea>
        </div>
          <div ><img src="https://img.icons8.com/ios/30/000000/opened-folder.png"/>
          <input type="file" name="image" id="fileToUpload"></input>
          </div >
        <button style="width: 60px;" type="submit" name ="upload"  ">Post</button>
        </form>
    </div> ';
                }
                
   
                echo "<br>";
                // echo '<div style="border-style:solid;">';
                foreach ($newarray as $value) {
                  $show_image = $value['image_name'];
                  $pathy = $pathx.$value["username"].'/';
                  $id = $value['id']; 
                  echo '<div class="container2">
                        <div class="postdiv">
                          <div class="posthead postdiv">
                            <div class="postheaditem">
                              <img src="https://img.icons8.com/ios-filled/28/000000/instagram-new--v2.png"/ id="logo">
                            </div>
                            <div class="menu postheaditem" style="width: 90%; ">
                                 <a href="profile.php?userproname='.$value["username"].'">'.$value["username"].'</a>';
                                 

                                 if($_SESSION['username']==$_GET['userproname']){
                                     echo '
                                 
                                 <span class="btnspan"><button class="dotbtn edit" id='.$id.'>Edit</button> <button class="dotbtn delete" id='.$id.' >Delete</button></span>';
                                 }
                            
                            echo'     </div>
                            
                           </div>
                            
                           <div class="clearfix"></div>';

                           if(strpos($show_image, 'mp4') !== false) {
                            echo ' <div >
                            <video class="postimg "  controls src='.$pathx.$show_image.'></video>
                            </div>';
                        }else{
                          echo'<div class="postimg" style="background-image:url('.$pathx.$show_image.'); flex:2;"></div >
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
                        <!-- <div >
                                <div class="postimg" style="background-image:url('.$pathy.$show_image.'); flex:2;"></div >
                            </div> -->
  
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

            <!-- <div class = 'container_item'>B</div> -->

            <!-- Optional JavaScript; choose one of the two! -->

            <!-- Option 1: Bootstrap Bundle with Popper -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>

            <script>
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log("edit ", e);
                    postid1.value = e.target.id;
                    $('#editModal').modal('toggle');

                })
            })

            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log("edit ", );
                    sno = e.target.id;

                    if (confirm("Are you sure you want to delete this post!")) {
                        console.log("yes");
                        window.location = `profile.php?delete=${sno}`;

                    } else {
                        console.log("no");
                    }
                })
            })
            </script>

</body>

</html>