<?php 
define('DB_SERVER','sql108.epizy.com');
define('DB_USERNAME', 'epiz_30191346');
define('DB_PASSWORD', 'fUzUBIUiHgJ3');
define('DB_NAME','epiz_30191346_login');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn == false){
    die('Error: cannot connect');
}
?>