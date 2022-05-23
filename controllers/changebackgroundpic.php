<?php
    session_start();
    $nono = $_SESSION['nono'];
    include('DAO.php');
    $dao=new DAO();
    $userId = $dao->GetUserId($nono);
    $user = $dao->GetUserId($nono);

$target_dir = "../images/".$user."/";
$target_fileee = basename($_FILES["img"]["name"]);
$imageFileType = strtolower(pathinfo($target_fileee,PATHINFO_EXTENSION));
$target_file = $target_dir."background.png";
$dest = "images/".$user."/background.png";
$uploadOk = 1;

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  if ($_FILES["img"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        $vid="";
        $doc="";
        if(!$dao->changebackgroundpic($dest,$userId)){
            header("location:../profile.php?res=success");
        }
        else{
            header("location:../profile.php?res=error");
        }
      echo "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
    } else {
        header("location:../profile.php?res=error");
    }
  }
?>