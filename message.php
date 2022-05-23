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
if(isset($_GET['user-id'])){
	$user_id = $_GET['user-id'];
}
else header("location:home.php?erreur=1");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Socily - Message Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="icon" href="images/logo.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome-font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick-theme.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>


<body>
	

	<div class="wrapper">
	<?php include("models/header.php");
	$userId = $dao->GetUserId($nono);?>
		<section class="messages-page">
			<div class="container">
				<div class="messages-sec">
					<div class="row">
						<div class="col-lg-4 col-md-12 no-pdd">
							<div class="msgs-list">
								<div class="msg-title">
									<h3>Messages</h3>
								</div><!--msg-title end-->
								<div class="messages-list">
									<ul>
									<?php
									$iddd = str_split($user_id);
									$userinfo = $dao->GetUserById($iddd);
									foreach($userinfo as $ui){
										echo'
										<li class="active">
											<div class="usr-msg-details">
												<div class="usr-ms-img">
													<img src="'.$ui[3].'" alt="">
													<span class="msg-status"></span>
												</div>
												<div class="usr-mg-info">
													<h3>'.strtolower($ui[0]).' '.strtolower($ui[1]).'</h3>
												</div><!--usr-mg-info end-->
											</div><!--usr-msg-details end-->
										</li>								
									</ul>
								</div><!--messages-list end-->
							</div><!--msgs-list end-->
						</div>
						<div class="col-lg-8 col-md-12 pd-right-none pd-left-none">
						<div class="main-conversation-box">
								<div class="message-bar-head">
									<div class="usr-msg-details">
										<div class="usr-ms-img">
											<img src="'.$ui[3].'" alt="">
										</div>
										<div class="usr-mg-info">
											<h3>'.strtolower($ui[0]).' '.strtolower($ui[1]).'</h3>
											<p>Online</p>
										</div><!--usr-mg-info end-->
									</div>
								</div><!--message-bar-head end-->
								';}
								$messages = $dao->GetAllMessages($userId,$user_id);
								if(empty($messages)){
									echo'
									<div class="messages-line" style="max-height:55vh">
									</div><!--messages-line end-->
								<div class="message-send-area">
									<form action="controllers/sendmessage.php" method="post" enctype="multipart/form-data">
										<div class="mf-field">
											<input type="text" name="message" placeholder="Type a message here">
											<input type="hidden" name="to" value="'.$user_id.'">
											<input type="hidden" name="messagepage" value="1">								
											<button type="submit">Send</button>
										</div>
									</form>
									';
								}	
								else{
									echo'
									<div class="messages-line"><br><br><br><br><br><br><br>';
									foreach($messages as $msg){
										if($msg[1]==$userId){
										echo'
										<div class="main-message-box ta-right">
											<div class="message-dt">
												<div class="message-inner-dt">
													<p>';
													//echo $width = "<script>document.write(window.screen.width);</script>";
													if(strlen($msg[3])>80){
														$sb = strlen($msg[3])/40;
														$j=0;
														for ($i=0; $i < $sb; $i++) { 
															$j++;
															$p1 = substr($msg[3], $i*40, 40*$j);
															echo "$p1<br>";
														}
														
													}
													else echo $msg[3];	
													echo'</p>
												</div><!--message-inner-dt end-->';
												$time = abs(time()-strtotime($msg[4]))-3600;
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
											echo'</div><!--message-dt end-->
											<div class="messg-usr-img">
												<img src="'.$us[5].'" alt="">
											</div><!--messg-usr-img end-->
										</div><!--main-message-box end-->
										';
										}
										else{
											echo'
											<div class="main-message-box st3">
											<div class="message-dt st3">
												<div class="message-inner-dt">
													<p>'.$msg[3].'</p>
												</div><!--message-inner-dt end-->';
												$time = abs(time()-strtotime($msg[4]))-3600;
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
											echo'</div><!--message-dt end-->
											<div class="messg-usr-img">
												<img src="'.$u[3].'" alt="">
											</div><!--messg-usr-img end-->
										</div><!--main-message-box end-->';	
									}
								}							
								echo'</div><!--messages-line end-->
								<div class="message-send-area">
									<form action="controllers/sendmessage.php" method="post" enctype="multipart/form-data">
										<div class="mf-field">
											<input type="text" name="message" placeholder="Type a message here">
											<input type="hidden" name="to" value="'.$user_id.'">
											<input type="hidden" name="messagepage" value="1">								
											<button type="submit">Send</button>
										</div>
									</form>
									';
								}?>	
								</div><!--message-send-area end-->
							</div><!--main-conversation-box end-->
						</div>
					</div>
				</div><!--messages-sec end-->
			</div>
		</section><!--messages-page end-->



		<?php include("models/footer.php");?>

	</div><!--theme-layout end-->



<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="lib/slick/slick.min.js"></script>
<script type="text/javascript" src="js/scrollbar.js"></script>
<script type="text/javascript" src="js/script.js"></script>

</body>
</html>