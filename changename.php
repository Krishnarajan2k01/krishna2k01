<?php
include("connect.php");
session_start();
if(!isset($_SESSION['user']))
{
    header("location:home.php");
}
$user=$_SESSION['user'];
$password=$_POST['cpassword'];
$nname=$_POST['nname'];
if($user!=NULL || $password!=NULL)
{
    $sql=mysqli_query($db,"SELECT * FROM users WHERE username='".mysqli_real_escape_string($db,$user)."' AND password='".mysqli_real_escape_string($db,sha1($password))."'");	
    if(mysqli_num_rows($sql)==1)
    {
        
			$sql=mysqli_query($db,"UPDATE `users` SET `name`='$nname' WHERE username='$user'");
			echo"<script>alert('Your Name is updated sucessfully');
				window.location.href='index.php';</script>";
	}
    else
    {
        echo"<script>alert('Current password is wrong enter correct password');
        window.location.href='settings.php';</script>";
    }
}
else
{
    echo"<script>window.location.href='settings.php';</script>";
}

?>
