<?php
    include('connect.php');
    session_start();
    $user=$_SESSION['user'];
    $rec=$_POST['touser'];
		$simple_string=$_POST['message'];
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$encryption_iv = '1234567891011121'; 
		$encryption_key = $rec;
		$msg = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);  
		if($msg!=" " && $msg!=null)
			mysqli_query($db,"INSERT INTO `mssg`(`sender`, `receiver`, `message`) VALUES ('$user','$rec','$msg')");
		

?>