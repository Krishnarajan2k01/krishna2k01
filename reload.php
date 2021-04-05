<?php
 session_start();
include("connect.php");

$user=$_SESSION['user'];
$rec=$_POST['touser'];
$ciphering = "AES-128-CTR";
$options = 0;
$decryption_iv = '1234567891011121';  


$output="";

$chat=mysqli_query($db,"SELECT * FROM `mssg` WHERE (sender='$user' AND receiver='$rec') or (sender='$rec' and receiver='$user')  ");
while($m=mysqli_fetch_assoc($chat))
{
	if($m['sender']==$_SESSION['user'])
	{
		$decryption_key = $rec;
		$mesg=openssl_decrypt ($m['message'], $ciphering,$decryption_key, $options, $decryption_iv); 
		$output.="<div style='text-align:right;margin-right:5px;'><p class='chat' style='background:lightblue;'>$mesg</p></div>";
	}
	else
	{
		$decryption_key = $user;
		$mesg=openssl_decrypt ($m['message'], $ciphering,$decryption_key, $options, $decryption_iv);
		$output.="<div style='text-align:left;margin-left:5px;'><p class='chat' style='background:seashell;'>$mesg</p></div>";
	}
}
 echo $output; 
?>