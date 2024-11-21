<?php
$dbHost = "localhost";  
$dbUser = "root";//your user name  
$dbPass = "";// your password  
$dbName = "movie_booking";  

$conn=mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);

if($conn)
{
    //echo "Connection Successful";
}
else
{
    echo "Connection Failed".mysqli_connect_error();
}

?>