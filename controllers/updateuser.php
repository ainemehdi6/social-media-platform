<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$address=$_POST['address'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$birthdate=$_POST['birthdate'];
if(!$dao->updateuser($fname,$lname,$address,$gender,$email,$birthdate,$userId)){
    header("location:../profile.php?rep=1");
}
else{
    header("location:../profile.php?rep=1");
}