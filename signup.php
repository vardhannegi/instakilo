
<?php
require_once "config.php";

$username = $password = $confirm_pasword = "";
$username_err = $password_err = $confirm_pasword_err = "";

if ($_SERVER['REQUEST_METHOD']=="POST"){

  if(empty(trim($_POST["username"]))){
    $username_err = "username cannot be blank";
  }
  else{
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn,$sql);
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt,"s",$param_username);
      $param_username = trim($_POST['username']);

      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==1)
        {
          $username_err = "This username is already taken";
        }
        else
        {
          $username = trim($_POST['username']);
        }
      }  
      else{
        echo "somthing went wronge";
      }      
    }
  }
  mysqli_stmt_close($stmt); 


if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
  $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  if ($stmt)
  {
    mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

    // Set these parameters
    $param_username = $username;
    $param_password = password_hash($password, PASSWORD_DEFAULT);

    // Try to execute the query
    if (mysqli_stmt_execute($stmt))
    {
        header("location: index.php");
    }
    else{
        echo "Something went wrong... cannot redirect!";
    }
  }
  mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Instakilo</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Instakilo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form class="d-flex">
          
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <form action ="" method="post" class="mb-3 container mt-5 col-sm-4">
    <h2 class="text-center">Signup Page</h2>
    <hr>
    
    <div class="mb-3 container">
      <label for="exampleInputEmail1" class="form-label">User Name</label>
      <input type="text" class="form-control" name = "username" id="exampleInputEmail1" aria-describedby="emailHelp">
      <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
    </div>
    <div class="mb-3 container">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" name = "password" id="exampleInputPassword1">
    </div>
    <div class="mb-3 container">
      <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" name = "confirm_password" id="exampleInputPassword1">
    </div>
    <!-- <div class="mb-3 form-check container"> -->
          
      <p>Already a member? <a href="index.php">Login Here</a></p>
      <p><a href="#">Forgot Password</a></p>
    <!-- </div> -->
    <button type="submit" class="btn btn-primary container mb-3 ">Submit</button>
  </form>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <div><?php
    echo $username_err;
    echo $password_err;
    echo $confirm_pasword_err;
    
    ?></div>
</body>

</html>