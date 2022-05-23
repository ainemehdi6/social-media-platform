<?php
session_start();
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($_SESSION['nono']);
if(!$dao->DeleteLastAuth($userId)){
    setcookie("nextlforu", "", time() - 60,"/");
    session_destroy();
    header("location:/Socily/login.php");
}
else{
    setcookie("nextlforu", "", time() - 60,"/");
    session_destroy();
    header("location:/Socily/login.php?erreur=1");
}


?>