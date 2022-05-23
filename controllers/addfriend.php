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
        header("location:../search.php?rep=1&search=$s");
    }
    else{
        if(!$dao->AddFriend($follow,$userId)){
            if(!$dao->AddNotificationNOPost($userId,$follow,'Followed You')){
                header("location:../search.php?rep=2&search=$s");
            }
            else{
                header("location:../search.php?rep=22&search=$s");
            }
        }else{
            header("location:../search.php?rep=3&search=$s");
            die();
        }
    }
}
else if(isset($_GET['user-id'])){
    $id=$_GET['user-id'];
    if($dao->testfollow($follow,$userId)){
        header("location:../user-profile.php?rep=1&user-id=$s");
    }
    else{
        if(!$dao->AddFriend($follow,$userId)){
            if(!$dao->AddNotificationNOPost($userId,$follow,'Followed You')){
                header("location:../user-profile.php?rep=2&user-id=$id");
            }
            else{
                header("location:../user-profile.php?rep=22&user-id=$id");
            }
        }else{
            header("location:../user-profile.php?rep=3&user-id=$id");
        }
    }
}
else{
    if($dao->testfollow($follow,$userId)){
        header("location:../home.php?rep=1");
    }
    else{
        if(!$dao->AddFriend($follow,$userId)){
            if(!$dao->AddNotificationNOPost($userId,$follow,'Followed You')){
                header("location:../home.php?rep=2");
            }
            else{
                header("location:../home.php?rep=22");
            }
        }else{
            header("location:../home.php?rep=3");
            die();
        }
    }
}


?>