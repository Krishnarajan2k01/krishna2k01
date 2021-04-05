
<?php
include('connect.php');
session_start();
$conimg='/bechat/image/contect.png';
if(!isset($_SESSION['user']))
{
	header("location:home.php");
}
$user=$_SESSION['user'];
$sql=mysqli_query($db,"SELECT * FROM users WHERE username='$user'");
$b=mysqli_fetch_array($sql);
$conimg=$b['image'];
$conimg=str_replace("/bechat/","",$conimg);





if(isset($_POST['submit']))
{
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $imgname=$target_dir.rand(0,19999).".".$imageFileType;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
       // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($imgname)) {
      echo "<script>alert('error! Retry');
      window.location.href='upload.php';
      </script>.</br>";
      /* unlink($target_file); */
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
      echo "<script>alert('Sorry, your file is too large!! Retry');
      window.location.href='upload.php';
      </script>";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "<script>alert('Sorry,It's not a image!! Retry');
      window.location.href='upload.php';
      </script>.</br>";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      echo "<script>alert('Sorry,you have some errors!! Retry');
      window.location.href='upload.php';
      </script>.</br>";
    // if everything is ok, try to upload file
    } else {
      
      $path='/bechat/'.$imgname;
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imgname)) 
      {
      
        $sql=mysqli_query($db,"UPDATE `users` SET `image`='$path' WHERE username='$user'");
     
        if($conimg!='image/contect.png')
        {
          unlink($conimg);
        }
        echo "<script>alert('The image has been uploaded');
        window.location.href='settings.php';
        </script>.</br>";

      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
}
?>


<!DOCTYPE html>
<html>
  <head>
      <link rel="icon" href="/bechat/image/logo-h.png">
      <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  </head>
  <style>
      body{
        display:flex;
        background-size:cover;
        background-color:black;
        color:white;
        justify-content: center;
        align-items: center;
      }
  </style>
    <body>

    <form action="upload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" value="Upload Image" name="submit">
    </form>

    </body>
</html>


