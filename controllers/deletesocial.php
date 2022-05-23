<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$socialid=$_GET['socialid'];
if(!$dao->deletesocial($socialid)){
    header("location:../profile.php?rep=1");
}
else{
    header("location:../profile.php?rep=2");
}

?>