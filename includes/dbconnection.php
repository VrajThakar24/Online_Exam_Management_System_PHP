<?php
$servername="localhost";
$username="root";
$password="";
$db="online_exam_db";
$conn=mysqli_connect($servername,$username,$password,$db);
if(mysqli_connect_errno())
{
    echo"Failed to connect My sql:".mysqli_connect_error();
    exit();
}
?>