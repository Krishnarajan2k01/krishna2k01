<?php 
	include('connect.php');
	session_start();
	if(!isset($_SESSION['user']))
	{
		header("location:index.php");
	}
	$user=$_SESSION['user'];
	$sql=mysqli_query($db,"SELECT * FROM users WHERE username='$user'");
	$b=mysqli_fetch_array($sql);
	$name=$b['name'];
	$conimg=$b['image'];
	$to=$_GET['touser']; 
	$touser=mysqli_query($db,"SELECT * FROM users WHERE id='$to'");
	$a=mysqli_fetch_array($touser);
	$rconimg=$a['image'];
	$rena=$a['name'];
	$rec=$a['username'];
	if(isset($_POST['slip']))
	{
		$target_dir = "data/";
		$filefullname=basename($_FILES["source"]["name"]);
		$target_file = $target_dir . $filefullname;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));  
		$check = getimagesize($_FILES["source"]["tmp_name"]);
		if($check !== false) {
		  $filefirstname="IMAGE.";
		} else {
		  $filefirstname="FILE.";
		}
		if ($_FILES["source"]["size"] > 52428800) {
			echo "<script>alert('Sorry, your file is too large!! Retry');</script>";
			$uploadOk = 0;
		}
		if ($uploadOk == 1) {
			if (move_uploaded_file($_FILES["source"]["tmp_name"], $target_file)) 
			{
				$filename=$filefirstname.$imageFileType;
				$msg="<span class='chat' style='padding:20px 100px;border:0px;'><a href="."'".$target_file."'"." target='_blank'>".$filename."</a></span>";
				$simple_string=$msg;
				$ciphering = "AES-128-CTR";
				$iv_length = openssl_cipher_iv_length($ciphering); 
				$options = 0; 
				$encryption_iv = '1234567891011121'; 
				$encryption_key = $rec;
				$msg = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);  
				mysqli_query($db,"INSERT INTO `mssg`(`sender`, `receiver`, `message`) VALUES ('$user','$rec','$msg')");
					
			}
			else{
				echo "<script>alert('Sorry, your file may have some problem!! Retry');</script>";
			}
		}

	}
	
?>






<html>
	<head>
		<link rel="icon" href="/bechat/image/logo-h.png">
		<link rel="stylesheet" href="style/home.css">
		<link rel="stylesheet" href="style/popup.css">
		<script src="jquery-3.6.0.min.js"></script>
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	</head>
	<body>
	
		<div class="navbar">
			<span class='head'><?php echo "Hello,$name";?></span>
			<div class='menu' style="float:right"><img src='/bechat/image/white_menu.png' height=40px width=40px>
					<div class='menu-view'>
						<a href="settings.php">Settings</a>
						<a href="contect.php">Contacts</a>
						<a href="home.php">Refresh</a>
						<a href="logout.php">Logout</a>
					</div>
			</div>
		</div>
		<div class="body">
			<div id='user' class="user">
				<!-- <div class=search>hello</div> -->
				<?php
					$sql=mysqli_query($db,"SELECT * FROM users WHERE username!='$user' order by name");
					while($to=mysqli_fetch_assoc($sql))
					{
						$c=mysqli_query($db,"SELECT * FROM `mssg` WHERE (sender='$user' AND receiver='$to[username]') or (sender='$to[username]' and receiver='$user')  ");
						if(mysqli_fetch_assoc($c)>0){
						
						echo'<li><a href="?touser='.$to['id'].'">';
						echo"<div class='u'><img src=".$to['image']." height=50px width=50px style='margin-top:-10px;'/>";
						echo'<span id=toUser style="position:absolute;">'.$to['name'].'</span></div></a></li>';
						}
						
					}
					

				?>	
			</div>
				<?php
					if(isset($_GET['touser']))
					{
						echo"<script>let d=0;</script>";
						echo"<div id='tb' class='tb' style='visibility:visible;'>";
						echo"<div class='toname'><img class='reciver' src='$rconimg' height=50px width=50px><div style='margin-left:82px;margin-top:-50px'><span id='rena' class='rena'>$rena</span></div><a href='home.php'><img id=mback src='image/white_back.png' height=30px style='display:none;' ></a></div>";
					}
					else
					{
						echo"<script>let d=1;</script>";
						echo"<div id='tb' class='tb'>";
					}
				?> 
								<div id='chat' class='chatarea' ></div>
								<div id='cpop' class='child-popup'>
									<form id='f' class="f" method='post' enctype="multipart/form-data">
									<h4>Select You want to send a file</h4>
									<h6>You selected file should < 50Mb </h6>
									<input type="file" id="files" name="source" required><br>
									<input type="reset"  value="Clear"><input id='fs'type="submit" name="slip" value="Submit">
									</form>
								</div>
								<div class="typ">
									<input id=sd  type='text' autofocus='autofocus' name=msg font-size="20px" autocomplete='off' onkeyup="butt()" placeholder='Type a message...'>
									<button type="button" id="send" value="Send" name="send" style="display:none"><img src='/bechat/image/send.png' height="50px"></button>
									<button type="button" id='ib' value="Send" name="image" onclick="ib();"><img src='/bechat/image/clip.png' height="50px"></button>
								</div>
							</div> 
					</div>
					<div id='popup' class="popup" onclick="back()"></div>
			<script>
				scroll_last();
				var current = "<?php echo $rec; ?>";
				$(document).ready(function(){
					display();
					$("#fs").click(function(){ins(msg);}); 
					setInterval(function(){display();}, 4000); 
					$("#send").click(function(){let msg=document.getElementById("sd").value;ins(msg);});
					/* $("#files").prop('required',true);*/
					$(document).on("keypress",function(e){
					let msg=document.getElementById("sd").value;
					if(e.which==13){
						if(document.getElementById("sd").value.trim()!="" || document.getElementById("sd").value==null)
							ins(msg);
					}
							
				})
				});
				function display(){ 
						$.ajax({
							url: "reload.php",
							method:"POST",
							data: {touser:current},
							success: function( result ) {
								$( "#chat" ).html(result);
								scroll_last();
							}
						});
				}
				function scroll_last(){
					chat=document.getElementById("chat");
					s=chat.scrollHeight;
					c=chat.scrollTop;
					chat.scrollTo(0,s);
				}
				function ins(msg){
					$.ajax({
							url: "ins.php",
							method:"POST",
							data: {
								touser:current,
								message:msg
								},
							success: function( result ) {
								display();
								scroll_last();
								$('#sd').val("");
								butt();
							}
						});
				}
				function back()
				{
					document.getElementById("popup").style.display = "none";
					document.getElementById("cpop").style.display = "none";
				}
				function ib()
				{
					document.getElementById("popup").style.display = "flex";
					document.getElementById("cpop").style.display = "flex";
				}
				
			</script>
			<script>
					function butt(){
						if(document.getElementById("sd").value.trim()!="" || document.getElementById("sd").value==null){
							document.getElementById("send").style.display="";
							document.getElementById("ib").style.display="none";	
						}
						else{
							document.getElementById("ib").style.display="";
							document.getElementById("send").style.display="none";
						}
					}
					const elem = document.querySelector("#user")
					if(elem.childNodes.length<=3)
					{
						document.getElementById("user").innerHTML="<span class='intro'>welcome You are new user you get a new friends to click here..<a href='contect.php' style='text-decoration: none;color:orange;'>Contacts</a> chat rendomly</span>";
					}
					function myFunction(x) {
					if (x.matches) { // If media query matches
						if(d==0){
							document.getElementById("user").style.display="none";
							document.getElementById("mback").style.display="";
						}

						
					} else {
						document.getElementById("user").style.display="";
						document.getElementById("mback").style.display="none";
						let d=1;
					}
					}

					var x = window.matchMedia("(max-width: 600px)")
					myFunction(x) // Call listener function at run time
					x.addListener(myFunction) // Attach listener function on state changes
			</script>
	</body>
</html>
