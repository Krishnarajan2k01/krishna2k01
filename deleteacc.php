<?php
include("connect.php");
$user=$_POST['user'];
if(isset($_POST['user'])){
    $sql=mysqli_query($db,"DELETE FROM `users` WHERE username='$user'");
    $sql=mysqli_query($db,"DELETE FROM `mssg` WHERE sender='$user' or receiver='$user'");
    $ck1=mysqli_query($db,"SELECT * FROM users WHERE username='$user'");
    $ck2=mysqli_query($db,"SELECT * FROM `mssg` WHERE sender='$user' or receiver='$user'");
    if(mysqli_fetch_array($ck1)==0 && mysqli_fetch_array($ck2)==0){
        echo"sucess";
    }
    else{
        echo"failed";
    }
}

 
?>