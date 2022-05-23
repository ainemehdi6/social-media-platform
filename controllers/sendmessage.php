<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$userId = $dao->GetUserId($nono);
$to=$_POST['to'];
$message=$_POST['message'];
if(isset($_POST['profilepage'])){
    if(!$dao->SendMessage($userId,$to,$message)){
        if(!$dao->UpdateMsgVu($userId,$to)){
            header("location:../profile.php?rep=1");
        }
        else header("location:../profile.php?rep=2");
    }
    else{
        header("location:../profile.php?rep=3");
    }
}
else if(isset($_POST['searchpage'])){
    if(!$dao->SendMessage($userId,$to,$message)){
        if(!$dao->UpdateMsgVu($userId,$to)){
            header('location:../search.php?rep=1&search='.$_POST["search"].'');
        }
        else header('location:../search.php?rep=1&search='.$_POST["search"].'');
    }
    else{
        header('location:../search.php?rep=1&search='.$_POST["search"].'');
    }
}
else if(isset($_POST['userpage'])){
    if(!$dao->SendMessage($userId,$to,$message)){
        if(!$dao->UpdateMsgVu($userId,$to)){
            header('location:../user-profile.php?rep=1&user-id='.$_POST["user-id"].'');
        }
        else header('location:../user-profile.php?rep=1&user-id='.$_POST["user-id"].'');
    }
    else{
        header('location:../user-profile.php?rep=1&user-id='.$_POST["user-id"].'');
    }
}
else if(isset($_POST['messagepage'])){
    if(!$dao->SendMessage($userId,$to,$message)){
        if(!$dao->UpdateMsgVu($userId,$to)){
            header("location:../message.php?rep=1&user-id=$to");
        }
        else header("location:../message.php?rep=2&user-id=$to");
    }
    else{
        header("location:../message.php?rep=3&user-id=$to");
    }
}
else{
    if(!$dao->SendMessage($userId,$to,$message)){
        if(!$dao->UpdateMsgVu($userId,$to)){
            header("location:../home.php?rep=1");
        }
        else header("location:../home.php?rep=2");
    }
    else{
        header("location:../home.php?rep=3");
    }
}
?>