<?php
session_start();
$nono = $_SESSION['nono'];
include('DAO.php');
$dao=new DAO();
$title=$_POST['title'];
$description=$_POST['description'];
$user=$dao->GetUserId($nono);
if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){
  $target_dir = "../images/".$user."/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  $dest = "images/".$user."/" . basename($_FILES["image"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  //mkdir('../assets/documents/' .$cname);
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
  
    if ($_FILES["image"]["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
  
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
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
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
          $vid="";
          $doc="";
          if(!$dao->Addpost($title,$description,$dest,$vid,$doc,$user)){
              header("location:/socily/home.php?res=success");
          }
          else{
              header("location:/socily/home.php?res=error");
          }
        echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
      } else {
          header("location:home.php?res=error");
      }
    }
}
else{
  if(!$dao->AddpostNoPic($title,$description,$user)){
    header("location:/socily/home.php?res=success");
}
else{
    header("location:/socily/home.php?res=error");
}
}

 
  /*
$image=$_FILES["image"]["tmp_name"];
$dest0="../images/".$user."/".$title.".jpg";
$dest="images/".$user."/".$title.".jpg";
move_uploaded_file($image,$dest0);
$vid="";
$doc="";
if($dao->Addpost($title,$description,$dest,$vid,$doc,$user)){
    header("location:home.php?res=success");
}
else{
    header("location:home.php?res=error");
}
*/
?>