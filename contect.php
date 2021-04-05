<html>
<head>

        <link rel="icon" href="/bechat/image/logo-h.png">
        <link rel="stylesheet" href="style/settings.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
</head>
<body>
<div class="navbar">
    <a href="home.php"><div class=backbt></div></a>
			<h1>Contacts</h1>
    </div>
    <div class=body>
        <div>
            <input id='search' type="text" placeholder='Search' onkeyup='search()'>
            
        </div>
    <div id='main' style="width:80%;margin-bottom:50px;">
    <?php
        session_start();
        include("connect.php");
        $user=$_SESSION['user'];
        $conimg='/bechat/image/contect.png';
        $sql=mysqli_query($db,"SELECT * FROM users WHERE username!='$user' order by name");
                        while($to=mysqli_fetch_assoc($sql))
                        {
                            $rconimg=$to['image'];
                            echo'<li><a href="home.php?touser='.$to['id'].'">';
                            echo"<div class='u'><img src=$rconimg height=50px width=50px style='margin-top:-10px;background-color:black;'/>";
                            echo'<span id=toUser style="position:absolute;margin-left:10px;">'.$to['name'].'</span></div></a></li>';

                            
                            
                        }
        ?>
        </div>
</div>
<script>

    function search()
    {
       
        
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        ul = document.getElementById("main");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
               
            } else {
                li[i].style.display = "none";
            }
        }
    
    }
</script>
</body>
</html>