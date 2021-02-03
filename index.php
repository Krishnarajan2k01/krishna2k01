<?php
include("connect.php");
session_start();
if(isset($_SESSION['user']))
{
	header("location:home.php");
}
$user=$_POST['user'];
$password=$_POST['password'];
if($user!=NULL || $_POST['password']!=NULL)
{
	$sql=mysqli_query($q,"SELECT * FROM users WHERE username='".mysqli_real_escape_string($q,$user)."' AND password='".mysqli_real_escape_string($q,sha1($password))."'");	
	if(mysqli_num_rows($sql)==1)
	{
		$_SESSION['user']=$_POST['user'];
		echo"login successfully<a href='logout.php'>logout</a>";
		header("location:home.php");
	}
	else
	{
		$info="Incorrect Email or Password";
	}
}
?>

<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet"> 
<link rel="stylesheet" href="mystyle.css">
<body>
<form method='post' action=''>	
<div class="main">
	<table cellpadding='4' cellspeacing='4'> 
	<tr><td align='center' colspan="2"><h1>Login</h1></td></tr>
	<tr><td align="center" class="info" colspan="2"><?php echo $info;?></td></tr>
	<tr><td align='center'>Username:</td><td><input type='text' name='user' class='tb' maxlength='20' size='10' placeholder='Username'></td></tr>
	<tr><td align='center'>Password:</td><td><input type='password' name='password' class='tb' maxlength='10' size='10' placeholder='Password'></td></tr>
	<tr><td align='center'><input type='reset' value='Clear' name='hi' class='bt'></td>
	<td align='center'><input type='submit' value='Submit' name='submit' class='bt'></td></tr>
	<tr><td align='center' colspan="2">New registration<a href="new.php">Click here...</td></tr>
	</table>
</div>
</form>
</body>
</html>