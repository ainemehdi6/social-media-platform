<?php
	$username=$_POST['username'];
	$password=$_POST['password'];
	include('DAO.php');
	$dao=new DAO();
	if($dao->authentificationUser($username,$password)){
		$arr = str_split('ABCDEFGHIJKLMNOP()[]{}&#-_=+@1234567890'); 
		shuffle($arr); 
		$arr = array_slice($arr, 0, 12); 
		$str = implode('', $arr); 
		setcookie("nextlforu", "$str", time() + 2 * 24 * 60 * 60,"/");
		$userId = $dao->GetUserId($username);
		if(!$dao->AddLastAuth($userId,$str)){
			session_start();
			$_SESSION['nono']=$username; 
			header("location:../home.php");
		}
		else{
			header("location:../login.php?rep=1");
			die();
		}
	}else{
		header("location:../login.php?erreur=2");
		die();
	}

?>