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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Socily - Profile Account Settings Page</title>
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
		<?php include("models/header.php")?>
		<section class="profile-account-setting">
			<div class="container">
				<div class="account-tabs-setting">
					<div class="row">
						<div class="col-lg-3">
							<div class="acc-leftbar">
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
								    <a class="nav-item nav-link" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password" aria-selected="false"><i class="fa fa-lock"></i>Change Password</a>
								    <a class="nav-item nav-link" id="nav-notification-tab" data-toggle="tab" href="#nav-notification" role="tab" aria-controls="nav-notification" aria-selected="false"><i class="fa fa-flash"></i>Notifications</a>
								    <a class="nav-item nav-link" id="nav-deactivate-tab" data-toggle="tab" href="#nav-deactivate" role="tab" aria-controls="nav-deactivate" aria-selected="false"><i class="fa fa-random"></i>Desactivate Account</a>
								  </div>
							</div><!--acc-leftbar end-->
						</div>
						<div class="col-lg-9">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">		
								</div>
							  	<div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
										<div class="acc-setting">
											<h3>Account Setting</h3>
											<form action="controllers/updateUserPass.php" method="post" enctype="multipart/form-data">
												<div class="cp-field">
													<h5>Old Password</h5>
													<div class="cpp-fiel">
														<input type="password" name="old-password" placeholder="Old Password">
														<i class="fa fa-lock"></i>
													</div>
												</div>
												<div class="cp-field">
													<h5>New Password</h5>
													<div class="cpp-fiel">
														<input type="password" name="new-password" placeholder="New Password">
														<i class="fa fa-lock"></i>
													</div>
												</div>
												<div class="cp-field">
													<h5>Repeat Password</h5>
													<div class="cpp-fiel">
														<input type="password" name="repeat-password" placeholder="Repeat Password">
														<i class="fa fa-lock"></i>
													</div>
												</div>
												<div class="save-stngs pd2">
													<ul>
														<li><button type="submit">Save Setting</button></li>
													</ul>
												</div><!--save-stngs end-->
											</form>
										</div><!--acc-setting end-->
							  	</div>
							  	<div class="tab-pane fade" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab">
							  		<div class="acc-setting">
							  			<h3>Notifications</h3>
							  			<div class="notifications-list">
											  <?php
												$notifications = $dao->GetNotifications($user_Id);
												foreach($notifications as $not){
													echo'
													<div class="notfication-details">
														<div class="noty-user-img">
															<img src="'.$not[3].'" alt="" style="width:40px;height:40px;">
														</div>
														<div class="notification-info">
															<h3><a href="user-profile.php?user-id='.$not[0].'" title="">'.strtolower($not[1]).' '.strtolower($not[2]).'</a> '.$not[4].' ';
															if(!empty($not[5])){
																echo'<a href="profile.php#'.$not[6].'" title=""> '.$dao->GetPostTitle($not[5]).'</a>.</h3><br>';
															}
															else echo'.</h3><br>';		
															$time = abs(time()-strtotime($not[7])-3600);
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
																			if($time>=86400) echo'<span>'.$not[7].'</span>';	
														echo'</div><!--notification-info -->
													</div>
													';
												};
											  ?>							  			
							  			</div><!--notifications-list end-->
							  		</div><!--acc-setting end-->
							  	</div>
							  	<div class="tab-pane fade" id="nav-deactivate" role="tabpanel" aria-labelledby="nav-deactivate-tab">
							  		<div class="acc-setting">
										<h3>Deactivate Account</h3>
										<form>
											<div class="cp-field">
												<h5>Email</h5>
												<div class="cpp-fiel">
													<input type="text" name="email" placeholder="Email">
													<i class="fa fa-envelope"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>Password</h5>
												<div class="cpp-fiel">
													<input type="password" name="password" placeholder="Password">
													<i class="fa fa-lock"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>Please Explain Further</h5>
												<textarea></textarea>
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit">Save Setting</button></li>
												</ul>
											</div><!--save-stngs end-->
										</form>
									</div><!--acc-setting end-->
							  	</div>
							</div>
						</div>
					</div>
				</div><!--account-tabs-setting end-->
				
			</div>
			
		</section>



		<?php include('models/footer.php')?>	

	</div><!--theme-layout end-->



<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="lib/slick/slick.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>


</body>
</html>