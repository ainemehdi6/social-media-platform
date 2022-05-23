<?php
    session_start();
    $nono = $_SESSION['nono'];
    include('DAO.php');
    $dao=new DAO();
    $userId = $dao->GetUserId($nono);
    $statut=$_POST['statut'];
    if(!$dao->changestatut($statut,$userId)){
        header("location:../profile.php?response=1");
    }
    else{
        header("location:../profile.php?response=2");
    }
?>