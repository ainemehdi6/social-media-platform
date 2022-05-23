<?php
    session_start();
    include("DAO.php");
    session_start();
    $nono = $_SESSION['nono'];
    $dao=new DAO();
	$opassword=$_POST['old-password'];
    $password=$_POST['new-password'];
    $rpassword=$_POST['repeat-password'];
    if($password==$rpassword){
        if(!$dao->UpdateUserPass($password,$nono)){
            header("location:../profile-account-setting.php?response=1");
        }
        else{
            header("location:../profile-account-setting.php?response=2");
            die();
        }
    }
    else{
        header("location:../profile-account-setting.php?response=3");
        die();
    }
?>