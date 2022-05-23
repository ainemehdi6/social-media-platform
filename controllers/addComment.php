<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$comment=$_POST['comment'];
$postId=$_POST['postId'];
$not_to = $dao->IdUserFromPost($postId);
if(isset($_POST['profile'])){
    if(!$dao->AddComment($userId,$postId,$comment)){
        if(!$dao->AddNotification($userId,$not_to,'Comment your post',$postId)){
            header("location:../profile.php?rep=1");
        }
        else{
            header("location:../profile.php?rep=2");
        }
    }
    else header("location:../profile.php?rep=3");
}
else if(isset($_POST['user-profile'])){
    $id = $_POST['user-profile'];
    if(!$dao->AddComment($userId,$postId,$comment)){
        if(!$dao->AddNotification($userId,$not_to,'Comment your post',$postId)){
            header("location:../user-profile.php?rep=1&user-id=$id");
        }
        else{
            header("location:../user-profile.php?rep=2&user-id=$id");
        }
    }
    else header("location:../user-profile.php?rep=3&user-id=$id");
}
else{
    if(!$dao->AddComment($userId,$postId,$comment)){
        if(!$dao->AddNotification($userId,$not_to,'Comment your post',$postId)){
            header("location:../home.php?rep=1");
        }
        else{
            header("location:../home.php?rep=2");
        }
    }
    else header("location:../home.php?rep=3");
}

?>