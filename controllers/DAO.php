<?php
class DAO{
	public function __construct(){}
	public function connexion(){
		$pdo = new PDO('mysql:host=127.0.0.1;dbname=socily','root','20192020');
		return $pdo;
	}
	public function authentificationUser($username,$password){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT * from user where username= ? and password = ?");
   		$reponse->execute([$username,$password]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function AddLastAuth($user_id,$AuthKey){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into lastAuth(user_id,Authkey) values (?,?)");
   		$reponse->execute([$user_id,$AuthKey]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function DeleteLastAuth($user_id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("DELETE from lastAuth where user_id=?");
   		$reponse->execute([$user_id]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function AddUser($fname,$lname,$email,$username,$password){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("insert into user(fname,lname,email,username,password) values(?,?,?,?,?)");
		$reponse->execute([$fname,$lname,$email,$username,$password]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function User($username){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT * from user where username= ?");
		$reponse->execute([$username]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function GetUserId($username){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT id FROM user where username='".$username."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['id'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function GetLastUserAuth($AuthKey){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT user_id FROM lastauth where AuthKey='".$AuthKey."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['user_id'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function GetUsernameById($id){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT username FROM user where id='".$id."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['username'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function GetUser($username){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT fname,lname,email,username,statut,profile_img,background_img,gender,birthdate from user where username= ?");
		$reponse->execute([$username]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6],$ligne[7],$ligne[8]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetUserInfo($username){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT id,fname,lname,adress,gender,email,birthdate from user where username= ?");
		$reponse->execute([$username]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function updateuser($fname,$lname,$adress,$gender,$email,$birthdate,$userId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("UPDATE user SET fname=?,lname=?,adress=?,gender=?,email=?,birthdate=? where id=?");
		$reponse->execute([$fname,$lname,$adress,$gender,$email,$birthdate,$userId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function UpdateUserPass($password,$username){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("UPDATE user SET password=? where username=?");
		$reponse->execute([$password,$username]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function GetUserById($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT fname,lname,statut,profile_img,id from user where id= ?");
		$reponse->execute($id);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetUsers($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT id,fname,lname,profile_img,statut,username from user where id!=?");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function FollowNumber($id){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT count(id) FROM follow where followee_id='".$id."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['count(id)'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function FollowerNumber($id){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT count(id) FROM follow where follower_id='".$id."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['count(id)'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function GetUsersPublications($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT post.id,fname,lname,profile_img,title,description,photo,video,doc,DATE_FORMAT(date, '%D %b %Y,%r') from post,user where user.id=post.user_id and post.user_id= ? order by post.date desc");
		$reponse->execute($id);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6],$ligne[7],$ligne[8],$ligne[9]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetUserPublications($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT post.id,fname,lname,profile_img,title,description,photo,video,doc,DATE_FORMAT(date, '%D %b %Y,%r') from post,user where user.id=post.user_id and post.user_id= ? order by post.date desc");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6],$ligne[7],$ligne[8],$ligne[9]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetUserPublicationsImg($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT post.id,fname,lname,profile_img,title,description,photo,video,doc,DATE_FORMAT(date, '%D %b %Y,%r') from post,user where user.id=post.user_id and post.user_id= ? and post.photo is not null order by post.date desc");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6],$ligne[7],$ligne[8],$ligne[9]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetFollowesId($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT followee_id from follow where follower_id=?");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetUserSocials($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT * from socials where user_id=?");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function Addpost($title,$desc,$image,$vid,$doc,$user_id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into post(title,description,photo,video,doc,user_id,date) values (?,?,?,?,?,?,now())");
		$reponse->execute([$title,$desc,$image,$vid,$doc,$user_id]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function AddpostNoPic($title,$desc,$user_id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into post(title,description,user_id,date) values (?,?,?,now())");
		$reponse->execute([$title,$desc,$user_id]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function likepost($user_id,$postId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into post_like(user_id,post_id) values (?,?)");
		$reponse->execute([$user_id,$postId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function testlikepost($user,$post){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT * from post_like where user_id=? and post_id=? ");
		$reponse->execute([$user,$post]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function unlikepost($user_id,$postId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("DELETE from  post_like where user_id=? and post_id=?");
		$reponse->execute([$user_id,$postId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function testfollow($foll,$user){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT * from follow where followee_id=? and follower_id=? ");
		$reponse->execute([$foll,$user]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function AddFriend($foll,$user){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into follow(followee_id,follower_id) values (?,?)");
		$reponse->execute([$foll,$user]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function unFriend($foll,$user){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("DELETE from follow where followee_id =? and follower_id=?");
		$reponse->execute([$foll,$user]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function Getpostlikeusers($postId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT user.id,fname,lname,profile_img from user,post_like where user.id=post_like.user_id and post_like.post_id=?");
		$reponse->execute([$postId]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetMessageId($userId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT distinct user.id from message,user where (user.id=msg_from and msg_to=?) or (user.id=msg_to and msg_from =?)");
		$reponse->execute([$userId,$userId]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetMessages($userId,$from){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare('SELECT cont,DATE_FORMAT(date, "%r")  from message where (msg_from=? and msg_to=?) or (msg_to=? and msg_from =?) order by date desc LIMIT 1');
		$reponse->execute([$from,$userId,$from,$userId]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetAllMessages($userId,$from){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare('SELECT *,DATE_FORMAT(date, "%D %b %Y,%r") from message where (msg_from=? and msg_to=?) or (msg_to=? and msg_from =?) order by date');
		$reponse->execute([$from,$userId,$from,$userId]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function SendMessage($userId,$to,$cont){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into message(msg_from,msg_to,cont,date,is_seen) values (?,?,?,now(),0)");
		$reponse->execute([$userId,$to,$cont]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function MessageNonVu($username,$friend){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="select count(id) from message where is_seen=0 and (msg_to=".$username." and msg_from =".$friend.")";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['count(id)'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function GetlastuserId(){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'socily' and TABLE_NAME='user'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['AUTO_INCREMENT'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function MessageNonVuAll($username){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="select count(id) from message where is_seen=0 and msg_to=".$username."";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['count(id)'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function UpdateMsgVu($userId,$friend){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("UPDATE message set is_seen=1 where msg_to=? and msg_from =?");
		$reponse->execute([$userId,$friend]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function GetProfiles($query,$id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT id,fname,lname,statut,profile_img from user where fname  like '%".$query."%' or lname like '%".$query."%' and id!=?");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function GetPubComments($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT post_comment.id,fname,lname,profile_img,cont,DATE_FORMAT(post_comment.date, '%D %b %Y,%r'),post_comment.user_id
								from post_comment,user,post 
								where user.id= post_comment.user_id and post.id= post_comment.post_id 
								and post.id= ? order by post_comment.date");
		$reponse->execute([$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[6]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function AddComment($userId,$postId,$comment){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into post_comment(user_id,post_id,cont,date) values (?,?,?,now())");
		$reponse->execute([$userId,$postId,$comment]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function GetPostTitle($id){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT title FROM post where id='".$id."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['title'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function GetNotifications($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("SELECT  user.id,fname,lname,profile_img,notifications.cont,notifications.post_id,notifications.date,is_seen 
								from user,notifications
								where (user.id=notifications.not_from  and not_to=? and not_from!=?) order by notifications.date desc");
		$reponse->execute([$id,$id]);
		$lst=[];
		while($ligne=$reponse->fetch()){
			 $lst[]=[$ligne[0],$ligne[1],$ligne[2],$ligne[3],$ligne[4],$ligne[5],$ligne[5],$ligne[6],$ligne[7]];
	   }
		$reponse->closeCursor();  
		return $lst;
	}
	public function IdUserFromPost($id){
		$con = mysqli_connect('127.0.0.1','root','20192020','socily');
		mysqli_select_db($con,"socily");
		$sql="SELECT user_id FROM post where id='".$id."'";
		$query = mysqli_query($con,$sql);
		$result = mysqli_fetch_assoc($query);
		$resultstring = $result['user_id'];
		mysqli_close($con); 
   		return $resultstring;
	}
	public function AddNotification($userId,$not_to,$cont,$post_id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into notifications(not_from,not_to,cont,post_id,date) values (?,?,?,?,now())");
		$reponse->execute([$userId,$not_to,$cont,$post_id]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function AddNotificationNOPost($userId,$not_to,$cont){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into notifications(not_from,not_to,cont,date) values (?,?,?,now())");
		$reponse->execute([$userId,$not_to,$cont]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function changestatut($satut,$userId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("UPDATE user set statut=? where id=?");
		$reponse->execute([$satut,$userId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function changeprofilepic($pic,$userId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("UPDATE user set profile_img=? where id=?");
		$reponse->execute([$pic,$userId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function changebackgroundpic($pic,$userId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("UPDATE user set background_img=? where id=?");
		$reponse->execute([$pic,$userId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function addsocial($name,$link,$userId){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("INSERT into socials(name,link,user_id) values(?,?,?)");
		$reponse->execute([$name,$link,$userId]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function deletesocial($socialid){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("DELETE from socials where id=?");
		$reponse->execute([$socialid]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function deletepost($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("DELETE from post where id=?");
		$reponse->execute([$id]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
	public function deletecomment($id){
		$bdd=$this->connexion();
		$reponse=$bdd->prepare("DELETE from post_comment where id=?");
		$reponse->execute([$id]);
		if ($reponse->fetch()) return true;
   		else return false;
	}
}
?>