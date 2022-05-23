<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$follow=$_GET['follower'];
if(isset($_GET['search'])){
    $s=$_GET['search'];
    if($dao->testfollow($follow,$userId)){
        if(!$dao->unFriend($follow,$userId)){
            header("location:../search.php?rep=1&search=$s");
        }else{
            header("location:../search.php?rep=2&search=$s");
        }
    }
    else{
        header("location:../search.php?rep=3&search=$s");
    }
}
else if(isset($_GET['user-id'])){
    $s=$_GET['user-id'];
    if($dao->testfollow($follow,$userId)){
        if(!$dao->unFriend($follow,$userId)){
            header("location:../user-profile.php?rep=4&user-id=$s");
        }else{
            header("location:../user-profile.php?rep=5&user-id=$s");
        }
    }
    else{
        header("location:../user-profile.php?rep=6&user-id=$s");
    }
}
else{
    if($dao->testfollow($follow,$userId)){
        if(!$dao->unFriend($follow,$userId)){
            header("location:../home.php?rep=7");
        }else{
            header("location:../home.php?rep=8");
            die();
        }
    }
    else{
        header("location:../home.php?rep=9");
    }
}
?>