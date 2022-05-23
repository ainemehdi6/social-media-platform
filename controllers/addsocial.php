<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$name=$_POST['name'];
$link=$_POST['link'];
if(!$dao->addsocial($name,$link,$userId)){
    header("location:../profile.php?rep=1");
}
else  header("location:../profile.php?rep=2");