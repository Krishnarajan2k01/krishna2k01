<?php 
include('connect.php');
session_start();
if(!isset($_SESSION['user']))
{
	header("location:index.php");
}
$user=$_SESSION['user'];
$sql=mysqli_query($q,"SELECT * FROM users WHERE username='$user'");
$b=mysqli_fetch_array($sql);
$name=$b['name'];
$to=$_GET['touser'];
	$touser=mysqli_query($q,"SELECT * FROM users WHERE id='$to'");
	$a=mysqli_fetch_array($touser);
	$rena=$a['name'];
	$rec=$a['username'];
	$msg=$_POST['msg'];
if(isset($_POST['send']))
{
	if($msg!=" " && $msg!=null)
		mysqli_query($q,"INSERT INTO `mssg`(`sender`, `receiver`, `message`) VALUES ('$user','$rec','$msg')");
	

}
?>
<html>
<head>
	<link rel="stylesheet" href="home.css">
</head>
<body bgcolor="black">
	<form method='post' action="">
		<div class="navbar">
			<span><?php echo "Hello,$name";?></span>
			<span style="float:right;background:gray;padding:10px;border-radius:10px;"><a href="logout.php">Logout</a></span>
		</div>
		<div class="body">

		<div class="user">
			<?php
				$sql=mysqli_query($q,"SELECT * FROM users WHERE username!='$user'");
				while($to=mysqli_fetch_assoc($sql))
				{
					echo'<li style="list-style-type:none;"><a href="?touser='.$to['id'].'"><div class="u"><img src="contect.png" height=50px width=50px style="margin-top:-10px;"/><div style="margin-left:60px;margin-top:-45px;">'.$to['name'].'</div></div></a></li>';
				}

			?>	
		</div>
				
		<?php
		
			if(isset($_GET['touser']))
			{
				echo"<div class='tb' style='visibility:visible;'>";
				echo"<div class='toname'><img src='contect.png' height=50px width=50px><div style='padding-left:52px;margin-top:-50px'><span>$rena</span></div></div>";
			}
			else
			{
				echo"<div class='tb'>";
			}
			
			
			echo"<div id='chat' class='chatarea'>";
			$chat=mysqli_query($q,"SELECT * FROM `mssg` WHERE (sender='$user' AND receiver='$rec') or (sender='$rec' and receiver='$user')  ");
			while($m=mysqli_fetch_assoc($chat))
			{
				if($m['sender']==$_SESSION['user'])
				{
					$mesg=$m['message'];
					echo"<div style='text-align:right;'><p class='chat' style='background:lightblue;'>$mesg</p></div>";
				}
				else
				{
					$mesg=$m['message'];
					echo"<div style='text-align:left;'><p class='chat' style='background:seashell;'>$mesg</p></div>";
				}
			}
		
			echo"</div>";
		
		?>
		<div class="typ">
		<input id=sd  type='textarea' autofocus='autofocus' name=msg font-size="20px">
		<input type="submit" id="send" value="Send" name="send" >
		</div>
		</div>
		</div>







		<script type="text/javascript">

		
		chat=document.getElementById("chat");
		s=chat.scrollHeight;
		chat.scrollTo(0,s);

		
	
		setInterval(function(){
			//$("#chat").html(data);
			
		}, 1000);

		</script>
		
		</form>
</body>
</html>
