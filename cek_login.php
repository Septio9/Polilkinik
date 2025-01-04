<?php 
session_start();
 
include 'koneksi.php';
 
$username = $_POST['username'];
$password = $_POST['password'];
 
$login = mysqli_query($conn,"select * from user where username='$username' and password='$password'");

$cek = mysqli_num_rows($login);
 

if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
 
	
	if($data['level']=="admin"){
 
	
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "admin";
		
		header("location:admin/index.php");
 
	
	}else if($data['level']=="user"){
	
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "user";
		
		header("location:user/index.php");
 
	
	}else if($data['level']=="petugas"){
	
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "petugas";
		
		header("location:petugas/index.php");
 
	}else{
 
	
		header("location:index.php?pesan=gagal");
	}	
}else{
	header("location:index.php?pesan=gagal");
}
 
?>