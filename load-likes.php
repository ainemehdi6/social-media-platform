<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$postId=$_GET['postId'];
$not_to = $dao->IdUserFromPost($postId);
if(isset($_GET['profile'])){
    if(!$dao->testlikepost($userId,$postId)){
        if(!$dao->likepost($userId,$postId)){
            if(!$dao->AddNotification($userId,$not_to,'Liked your post',$postId)){
                header("location:../profile.php?rep=1");
            }
            else{
                header("location:../profile.php?rep=2");
            }
        }
        else{
            header("location:../profile.php?rep=3");
            die();
        }
    }
    else{
        if(!$dao->unlikepost($userId,$postId)){
            header("location:../profile.php?rep=4");
        }
        else{
            header("location:../profile.php?rep=5");
            die();
        }
    }
}
else if(isset($_GET['user-profile'])){
    $id=$_GET['user-profile'];
    if(!$dao->testlikepost($userId,$postId)){
        if(!$dao->likepost($userId,$postId)){
            if(!$dao->AddNotification($userId,$not_to,'Liked your post',$postId)){
                header("location:../user-profile.php?rep=1&user-id=$id");
            }
            else{
                header("location:../user-profile.php?rep=2&user-id=$id");
            }
        }
        else{
            header("location:../user-profile.php?rep=3&user-id=$id");
            die();
        }
    }
    else{
        if(!$dao->unlikepost($userId,$postId)){
            header("location:../user-profile.php?rep=4&user-id=$id");
        }
        else{
            header("location:../user-profile.php?rep=5&user-id=$id");
            die();
        }
    }
}
else{
    if(!$dao->testlikepost($userId,$postId)){
        $dao->likepost($userId,$postId);
        $dao->AddNotification($userId,$not_to,'Liked your post',$postId);
    }
    if($dao->testlikepost($userId,$p[0])) echo'<a onclick="likebtn(yes,'.$p[0].')" style="color:#00AFF0;"><i class="la la-heart"></i>Unlike</a>';
    else echo'<a onclick="likebtn(no,'.$p[0].')" ><i class="la la-heart"></i> Like</a>';
    $likes = $dao->Getpostlikeusers($p[0]);
    foreach($likes as $l){
        echo '<img src="'.$l[3].'" alt="" style="width:30px;height:30px">';
    }
    if(count($likes)>0) echo'<span>'.count($likes).'</span>';
}    
?>