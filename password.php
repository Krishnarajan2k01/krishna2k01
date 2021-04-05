<?php

include("connect.php");
session_start();
if(!isset($_SESSION['user']))
{
    header("location:home.php");
}
$user=$_SESSION['user'];
$password=$_POST['cpassword'];
$p1=$_POST['p1'];
$p2=$_POST['p2'];
if($user!=NULL || $password!=NULL)
{
    $sql=mysqli_query($db,"SELECT * FROM users WHERE username='".mysqli_real_escape_string($db,$user)."' AND password='".mysqli_real_escape_string($db,sha1($password))."'");	
    if(mysqli_num_rows($sql)==1)
    {
        if($p1==$p2)
		{	
			$p3=sha1($p1);
			$sql=mysqli_query($db,"UPDATE `users` SET `password`='$p3' WHERE username='$user'");
			echo"<script>alert('Your Password is updated sucessfully');
				window.location.href='logout.php';</script>";
		}
        else{
            echo"<script>alert('New passwords are not match');
				window.location.href='settings.php';</script>";
        }
    }
    else
    {
        echo"<script>alert('Current password is wrong enter correct password');
        window.location.href='settings.php';</script>";
    }
}
?>
