<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$id=$_GET['id'];
if(!$dao->deletepost($id)){
    header("location:../profile.php?rep=1");
}
else{
    header("location:../profile.php?rep=2");
}

?>