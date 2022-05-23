<?php
	$lname=$_POST['lname'];
    $fname=$_POST['fname'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
	$rpassword=$_POST['repeat-password'];
	include('DAO.php');
	$dao=new DAO();
    if($password==$rpassword){
        if(!$dao->AddUser($fname,$lname,$email,$username,$password)){
            $id = $dao->GetlastuserId();
            if(mkdir("../images/$id")){
                header("location:../login.php?response=1");
            }
            else header("location:../login.php?response=11");
        }
        else{
            header("location:../login.php?response=2");
            die();
        }
    }
    else{
        header("location:../login.php?response=3");
        die();
    }
?>