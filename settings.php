<?php
    include('connect.php');
    session_start();
    $conimg='/bechat/image/contect.png';
    if(!isset($_SESSION['user']) || $_SESSION['user']=='Admin')
    {
        header("location:home.php");
    }
    $user=$_SESSION['user'];
    $sql=mysqli_query($db,"SELECT * FROM users WHERE username='$user'");
    $b=mysqli_fetch_array($sql);
    $conimg=$b['image'];
    $name=$b['name'];
?>

<html>
<head>
    <link rel="icon" href="/bechat/image/logo-h.png">
    <link rel="stylesheet" href="style/settings.css">
    <link rel="stylesheet" href="style/popup.css">
    <script src="jquery-3.6.0.min.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
</head>
<body>
    <div class="navbar">
    <a href="home.php"><div class=backbt></div></a>
			<h1>Settings</h1>
    </div>
    <div class=body>
    <br></br>
    <img id='popimg' src="<?php echo $conimg;?>" height='80%' width='50%'>
     <div  class="pro" onclick='viewimg()'><img  src="<?php echo $conimg;?>" height='250' width='250'><div class='cam' onclick='cimg()'></div></div>
     <h2><?php echo $name;?></h2>
     
    
     <div id='cpop' class='child-popup'>
         <form id='f' class="f" action="password.php" method='post'>
         <input type="password" placeholder='Current password' name='cpassword' autocomplete='off' required><br><hr>
         <input type="password" placeholder='New password' name='p1' autocomplete='off' required>
         <input type="password" placeholder='Re-New password' name='p2' autocomplete='off' required><br>
         <input type="reset" value="Clear"><input type="submit" value="Submit">
        </form>
     </div>
    <div id='cpop1' class='child-popup'>
        <form class="f" action="changename.php" method='post'>
            <input type="text" placeholder='New Name' name='nname' autocomplete='off' required><hr>
            <input type="password" placeholder='Current password' name='cpassword' autocomplete='off' required>
            <input type="reset" value="Clear"><input type="submit" value="Submit">
        </form>
    </div>
    </div>
    <div class=b1 onclick='nc()'>Change Name</div>
    <div class=b1 onclick='cp()'>Change password</div>
    <div class=b3 >Delete my account</div>
    <a href="logout.php"><div class=b1>Logout</div></a>
    <div class="b2" ></div>
    <div id='popup' class="popup" onclick="back()">
        
    </div>
    
    <script>
        function back()
        {
            document.getElementById("popup").style.display = "none";
            document.getElementById("cpop").style.display = "none";
            document.getElementById("popimg").style.display = "none";
            document.getElementById("cpop1").style.display = "none";
        }
        function cp()
        {
            document.getElementById("popup").style.display = "flex";
            document.getElementById("cpop").style.display = "flex";
        }
        function viewimg()
        {
            document.getElementById("popup").style.display = "flex";
            document.getElementById("popimg").style.display = "inline";
        }
        function nc()
        {
            document.getElementById("popup").style.display = "flex";
            document.getElementById("cpop1").style.display = "flex";
        }
        function cimg()
        {
            window.location.href='upload.php';
        }
    </script>
    <script>
        let u="<?php echo $user; ?>";
        $(document).ready(function(){
            $(".b3").click(function(){
                let c=confirm("If you delete your account to you lose your data permenently");
                if(c==1){
                    $.ajax({
                        url: "deleteacc.php",
                        method:"POST",
                        data: {user:u},
                        success: function( result ) 
                        {
                            alert("Deleted "+result);
                            window.location.href='logout.php';
                        }
                    });
                }
            });
        })
    </script>
</body>
</html>