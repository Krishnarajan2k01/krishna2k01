<?php
include("connect.php");
$name=$_POST['name'];
$user=$_POST['user'];
$p1=$_POST['p1'];
$p2=$_POST['p2'];

$c=mysqli_query($q,"SELECT * FROM users WHERE username='$user'");
if($name!=NULL || $user!=NULL || $p1!=NULL || $p2!=NULL )
{
	
		if(mysqli_num_rows($c)==1)
		{
			$info="Username already exist";
		}
		elseif($p1==$p2)
		{	
			$p3=sha1($p1);
			$sql=mysqli_query($q,"INSERT INTO `users`(`name`, `username`, `password`) VALUES ('$name','$user','$p3')");
			$info="Successfully Registered User $name";
		}
		else
		{
			$info="Passwords Didn't Matched";
		}
}
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<link href='https://fonts.googleapis.com/css2?family=Pacifico&display=swap' rel='stylesheet'> 
		<link href='https://fonts.googleapis.com/css2?family=Lobster&display=swap' rel='stylesheet'>	
		<link rel='stylesheet' href='mystyle.css'>
	</head>
		<body>
				<form method='post' action=''>
				<div class="main"> 
				<table cellpadding='4' cellspeacing='4'> 
				<tr><td colspan="2"><h1>Sign Up</h1></td></tr>
				<tr><td align="center" class="info" colspan="2"><?php echo $info;?></td></tr>
				<tr><td align='center'>Name:</td><td><input type='text' name='name' class='tb' maxlength='20' size='10' placeholder='Name'></td></tr>
				<tr><td align='center'>Username:</td><td><input type='text' name='user' class='tb' maxlength='20' size='10' placeholder='Username'></td></tr>
				<tr><td align='center'>Password :</td><td><input type='password' name='p1' class='tb' maxlength='10' size='10' placeholder='Password'></td></tr>
				<tr><td align='center'>Re-Password :</td><td><input type='password' name='p2' class='tb' maxlength='10' size='10' placeholder='Re-type-password'></td></tr>
				<tr><td align='center'><input type='reset' value='Clear' class='bt'></td>
				<td align='center'><input type='submit' value='Add' name='add' class='bt'></td></tr>
				<tr><td align='center' colspan="2"><a href="index.php">BACK</a></td></tr>
				</div>
				</form>
		</body>
</html>






























		