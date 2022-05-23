<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$id=$_GET['id'];
if(isset($_GET['profile'])){
    $id = $_GET['profile'];
    if(!$dao->deletecomment($id)){
        header("location:../profile.php?rep=1#$id");
    }
    else{
        header("location:../profile.php?rep=2#$id");
    }
}
else{
    if(!$dao->deletecomment($id)){
        header("location:../home.php?rep=1");
    }
    else{
        header("location:../home.php?rep=2");
    }
}


?>