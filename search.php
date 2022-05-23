<?php
session_start();
include("controllers/DAO.php");
$dao=new DAO();
if(isset($_COOKIE['nextlforu']) && !empty($_COOKIE['nextlforu'])){
	$user_idd= $dao->GetLastUserAuth($_COOKIE['nextlforu']);
	$nono = $dao->GetUsernameById($user_idd);
	$_SESSION['nono']=$nono;	
}
else{
	if( !isset($_SESSION['nono']) || !$dao->User($_SESSION['nono']) ){
	header("location:login.php?erreur=1");
	die();
	}
	else{
		$nono=$_SESSION['nono'];
	}
}
if(isset($_GET['search'])){
	$querie=$_GET['search'];
}
else{
	header("location:home.php?erreur=1");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Socily - Search Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="icon" href="images/logo.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome-font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick-theme.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>
<body>
	<div class="wrapper">
        <?php include("models/header.php");
            $userId = $dao->GetUserId($nono);
        ?>
		<section class="companies-info">
			<div class="container">
				<div class="company-title">
					<h3>Search Results</h3>
				</div>
				<div class="companies-list">
					<div class="row">
                        <?php 
                        $profiles = $dao->GetProfiles($querie,$userId);
                        foreach($profiles as $p){
                        echo'
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
							<div class="company_profile_info">
								<div class="company-up-info">
									<img src="'.$p[4].'" alt=""  style="width:91px; height:91px">
									<h3>'. strtolower($p[1]).' '. strtolower($p[2]).'</h3>
									<h4>'.$p[3].'</h4>
									<ul>';
                                    if($dao->testfollow($p[0],$userId)){
                                        echo'<li><a href="controllers/unfriend.php?follower='.$p[0].'&search='.$querie.'" title="" class="btn btn-secondary" >Unfollow</a></li>';
                                    }
                                    else{
                                        echo'<li><a href="controllers/addfriend.php?follower='.$p[0].'&search='.$querie.'" title="" class="followw">Follow</a></li>';
                                    }
                                    echo'
                                    <li><a href="message.php?user-id='.$p[0].'" title="" class="message-us"><i class="fa fa-envelope"></i></a></li>
									</ul>
								</div>
								<a href="user-profile.php?user-id='.$p[0].'" title="" class="view-more-pro">View Profile</a>
							</div><!--profile_info end-->
						</div>';
                        }
                        if(empty($profiles)){
                            echo'';
                        }
                        ?>
						
					</div>
				</div><!--Profiles-list end-->
			</div>
		</section><!--Profiles-info end-->
		<div class="chatbox-list">
			<div class="chatbox">
				<div class="chat-mg bx">
					<a href="#" title=""><img src="images/chat.png" alt=""></a>
					<span><?php echo $dao->MessageNonVuAll($userId); ?></span>
				</div>
				<div class="conversation-box" id="conversation-box">
					<div class="con-title">
						<h3>Messages</h3>
						<a href="#" title="" class="close-chat"><i class="la la-minus-square"></i></a>
					</div>
					<div class="chat-list">
						<?php 
						$mesid = $dao->GetMessageId($userId);
						foreach($mesid as $mi){
							$iddd = implode("",$mi);
							$message = $dao->GetMessages($userId,$iddd);	
							foreach($message as $m){
								$user = $dao->GetUserById($mi);
								foreach($user as $u){
									echo'
									<div class="conv-list '; if($dao->MessageNonVu($userId,$iddd)!=0) echo'active'; echo'">
									<button onclick="chatBoxActive('.$iddd.')" style=" all: unset; ">
									<div class="usrr-pic">
										<img src="'.$u[3].'" alt="" style="width:50px;height:50px;">
										<span class="active-status activee"></span>
									</div>	
									<div class="usy-info">
									<h3>'.strtolower($u[0]).' '.strtolower($u[1]).'</h3><span>';
									if(strlen($m[0])>30){
										$sb = strlen($m[0])/30;
										$j=0;
										for ($i=0; $i < $sb; $i++) { 
											$j++;
											$p1 = substr($m[0], $i*30, 30*$j);
											echo "$p1<br>";
										}
										
									}
									else echo $m[0];
								echo'</span></div>
									<div class="ct-time">
										<span>'.$m[1].'</span>
									</div>';
									$msgNonVuNumber = $dao->MessageNonVu($userId,$iddd);
									if($msgNonVuNumber!=0) echo '<span class="msg-numbers">'.$msgNonVuNumber.'</span>';
									echo'</button>
									</div>';
								}
							}}	
			$mesid = $dao->GetMessageId($userId);
			foreach($mesid as $mi){
			$iddd = implode("",$mi);
			$user = $dao->GetUserById($mi);
			foreach($user as $u){	
			echo'<div class="chatbox-list">
			<div class="chatbox">
				<div class="conversation-box" id="conversation-box-'.$iddd.'">
					<div class="con-title mg-3">
						<div class="chat-user-info">
							<img src="'.$u[3].'" alt="" style="width:34px;height:33px;">
							<h3>'.strtolower($u[0]).' '.strtolower($u[1]).' <span class="status-info"></span></h3>
						</div>
						<div class="st-icons">
						<button onclick="chatBoxActive('.$iddd.')" style=" all: unset; color:#ffffff" ><i class="la la-close"></i></button>
						</div>
					</div>
					<div class="chat-hist mCustomScrollbar" data-mcs-theme="dark">';
					$messages =$dao->GetAllMessages($userId,$iddd);
					foreach($messages as $msg){
					if($msg[1]==$userId){
						echo'
						<div class="chat-msg"><p>';
							if(strlen($msg[3])>30){
								$sb = strlen($msg[3])/30;
								$j=0;
								for ($i=0; $i < $sb; $i++) { 
									$j++;
									$p1 = substr($msg[3], $i*30, 30*$j);
									echo "$p1<br>";
								}
								
							}
							else echo $msg[3];
							echo'</p>';
								$time = abs(time()-strtotime($msg[4]))-7200;
								if($time>=0 && $time<60)
								{
									echo'<span>'.$time.' sec ago</span>';
								} 
								if($time>=60 && $time<3600) 
								{
									$time = intdiv($time,60);
									echo'<span>'.$time.' min ago</span>';
								}
								if($time<86400 && $time>=3600)
								{
									$time = intdiv($time,3600);
									echo'<span>'.$time.' hour ago</span>';
								}
								if($time>=86400) echo'<span>'.$msg[6].'</span>';
							echo'</div>';
						}
						else{
							echo'
							<div class="chat-msg st2"><p>';
								if(strlen($msg[3])>30){
									$sb = strlen($msg[3])/30;
									$j=0;
									for ($i=0; $i < $sb; $i++) { 
										$j++;
										$p1 = substr($msg[3], $i*30, 30*$j);
										echo "$p1<br>";
									}
									
								}
								else echo $msg[3];
								echo'</p>';
								$time = abs(time()-strtotime($msg[4])-3600);
								if($time<60)
								{
									echo'<span>'.$time.' sec ago</span>';
								} 
								if($time>=60 && $time<3600) 
								{
									$time = intdiv($time,60);
									echo'<span>'.$time.' min ago</span>';
								}
								if($time<86400 && $time>=3600)
								{
									$time = intdiv($time,3600);
									echo'<span>'.$time.' hour ago</span>';
								}
								if($time>=86400) echo'<span>'.$msg[6].'</span>';
							echo '</div>';
						}
					}	echo'</div><!--chat-history end-->';			
						echo'<div class="typing-msg">
								<form action="controllers/sendmessage.php" method="post" enctype="multipart/form-data">
									<textarea name="message" placeholder="Type a message here"></textarea>
									<input type="hidden" name="to" value="'.$iddd.'">
									<input type="hidden" name="searchpage" value="1">
									<input type="hidden" name="search" value="'.$querie.'">
									<button type="submit"><i class="fa fa-send"></i></button>
								</form>
							</div><!--typing-msg end--></div>
							</div></div>
						';	
						}}?>
					</div><!--chat-list end-->
		</div><!--chatbox-list end-->
	</div><!--theme-layout end-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/flatpickr.min.js"></script>
<script type="text/javascript" src="lib/slick/slick.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>