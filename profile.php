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
<title>Socily - Profile Page</title>
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
	

	<div class="wrapper" id="wrapper">
    <?php include("models/header.php");
			$userId = $dao->GetUserId($nono);
			$user = $dao->GetUser($nono);
			foreach($user as $u){echo'
			<section class="cover-sec">
			<img src="'.$u[6].'" style="width:100%;height:100%;max-height:65vh" alt="Profile Background Picture">
			<button  onclick="backgroundImgBox()" class="cover-sec-btn"><i class="fa fa-camera"></i> Change Image<button>
		</section>


		<main>
			<div class="main-section">
				<div class="container">
					<div class="main-section-data">
						<div class="row">
							<div class="col-lg-3">
								<div class="main-left-sidebar">
									<div class="user_profile">
										<div class="user-pro-img">
											<img src="'.$u[5].'" style="width:170px; height:170px" alt="">';}?>
											<button  onclick="profileImgBox()" class="user-pro-img-btn"><i class="fa fa-camera"></i></button>
										</div><!--user-pro-img end-->
										<div class="user_pro_status">
											<ul class="flw-status">
												<li>
													<span>Following</span>
													<b><?php echo $dao->FollowNumber($userId)?></b>
												</li>
												<li>
													<span>Followers</span>
													<b><?php echo $dao->FollowerNumber($userId)?></b>
												</li>
											</ul>
										</div><!--user_pro_status end-->
										<ul class="social_links">
											<?php $socials = $dao->GetUserSocials($userId);
											foreach($socials as $s){
												if($s[1]=='Website') echo '<li><a href="'.$s[2].'" title="Website Link" target=”_blank”><i class="la la-globe"></i>'.$s[2].'</a></li>';
												else if($s[1]=='Twitter') echo '<li><a href="'.$s[2].'" title="Twitter Link" target=”_blank”><i class="fa fa-twitter-square"></i>'.$s[2].'</a></li>';
												else if($s[1]=='Facebook') echo '<li><a href="'.$s[2].'" title="Facebook Link" target=”_blank”><i class="fa fa-facebook-square"></i>'.$s[2].'</a></li>';
												else if($s[1]=='Instagram') echo '<li><a href="'.$s[2].'" title="Instagram Link" target=”_blank”><i class="fa fa-instagram-square"></i>'.$s[2].'</a></li>';
												else if($s[1]=='Behance') echo '<li><a href="'.$s[2].'" title="Behance Link" target=”_blank”><i class="fa fa-behance-square"></i>'.$s[2].'</a></li>';
												else echo '<li><a href="'.$s[2].'" title="Link" target=”_blank”>'.$s[2].'</a></li>';
											};?>
										</ul>
									</div><!--user_profile end-->
									<div class="suggestions full-width">
										<div class="sd-title">
											<h3>Friends List</h3>
										</div><!--sd-title end-->
										<div class="suggestions-list">
											<?php
											$friends = $dao->GetFollowesId($userId);
											foreach($friends as $f){
												$profiles = $dao->GetUserById($f);
												foreach($profiles as $p){
													echo'
													<div class="suggestion-usd">
														<img src="'.$p[3].'" alt="" style="width:50px;height:50px;">
														<div class="sgt-text">
															<a href="user-profile.php?user-id='.$p[4].'" class="user-profile-hover"><h4>'. strtolower($p[0]).' '. strtolower($p[1]).'</h4></a>
															<span>';
															if(strlen($p[2])>20){
																$p[2] = substr($p[2], 0, 20);
																echo ''.$p[2].' ...</span>';
															}
															else echo''.$p[2].'</span>';
														echo'</div>
													</div>													
													';
												}
											}
											?>
										</div><!--suggestions-list end-->
									</div><!--suggestions end-->
								</div><!--main-left-sidebar end-->
							</div>
							<div class="col-lg-6">
								<div class="main-ws-sec">
									<div class="user-tab-sec">
										<?php $user = $dao->GetUser($nono);
                                                foreach($user as $u){
                                                echo'
												<h3>'.strtolower($u[0]).' '.strtolower($u[1]).'</h3>                                            
										<div class="star-descp">
											<span>'.$u[4].'</span> ';};echo' 
											<button  class="star-descp-btn" onclick="statutbox()">Status</button>                                  
										</div><!--star-descp end-->
										<div class="tab-feed st2">
											<ul>
												<li data-tab="feed-dd" class="active">
													<a href="#" title="">
														<img src="images/ic1.png" alt="">
														<span>Feed</span>
													</a>
												</li>
												<li data-tab="info-dd">
													<a href="#" title="">
														<img src="images/ic2.png" alt="">
														<span>Info</span>
													</a>
												</li>	
											</ul>
										</div><!-- tab-feed end-->
									</div><!--user-tab-sec end-->
									<div class="product-feed-tab current" id="feed-dd">
										<div class="posts-section">';
										$posts = $dao->GetUserPublications($userId);
										foreach($posts as $p){echo'
											<div class="post-bar" id="'.$p[0].'">
												<div class="post_topbar">
													<div class="usy-dt">
														<img src="'.$p[3].'" style="width:50px; height:50px" alt="">      
														<div class="usy-name">
															<h3>'.$p[1].' '.$p[2].'</h3>';
															$time = abs(time()-strtotime($p[9]))-3600;
															if($time<60)
															{
																echo'<span><img src="images/clock.png" alt="">'.$time.' sec ago</span>';
															} 
															else if($time>=60 && $time<3600) 
															{
																$time = intdiv($time,60);
																echo'<span><img src="images/clock.png" alt="">'.$time.' min ago</span>';
															}
															else if($time<86400 && $time>=3600)
															{
																$time = intdiv($time,3600);
																echo'<span><img src="images/clock.png" alt="">'.$time.' hours ago</span>';
															}
															else if($time>=86400 && $time <604800)
															{
																$time = intdiv($time,86400);
																echo'<span><img src="images/clock.png" alt="">'.$time.' days ago</span>';
															} 
															else if($time>=604800 && $time<86400*31)
															{
																$time = intdiv($time,604800);
																echo'<span><img src="images/clock.png" alt="">'.$time.' weeks ago</span>';
															} 
															else if($time>=86400*31)
															{
																$time = intdiv($time,86400*31);
																echo'<span><img src="images/clock.png" alt="">'.$time.' months ago</span>';
															}  
															else echo'<span><img src="images/clock.png" alt="">'.$p[9].'</span>';
														echo'</div>
													</div>
													<div class="ed-opts">
														<a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
														<ul class="ed-options">
															<li><a href="controllers/deletepost.php?id='.$p[0].'" title="">Delete Post</a></li>
														</ul>
													</div>
												</div>
												<div class="job_descp">
													<h3>'.$p[4].'</h3>';
													if(!empty($p[5])) echo'<p>'.$p[5].'</p>';
													if(!empty($p[6])) echo'<img src="'.$p[6].'" style="width:100%;height:100%" alt="">';
													echo'
												</div>
												<div class="job-status-bar">
												<ul class="like-com">
													<li>';
													if($dao->testlikepost($userId,$p[0])) echo'<a href="controllers/likepost.php?postId='.$p[0].'&profile=1" style="color:#00AFF0;"><i class="la la-heart"></i>Unlike</a>';
													else echo'<a href="controllers/likepost.php?postId='.$p[0].'&profile=1"><i class="la la-heart"></i> Like</a>';
													$likes = $dao->Getpostlikeusers($p[0]);
													foreach($likes as $l){
														echo '<img src="'.$l[3].'" alt="" style="width:30px;height:30px">';
													}
													if(count($likes)>0) echo'<span>'.count($likes).'</span>';
													$comments = $dao->GetPubComments($p[0]);
													echo'
													</li> 
													<li style="color:#B2B2B2 ">
														<button style=" all: unset;" class="com" onclick="CommentBoxActive('.$p[0].')">
															<img src="images/com.png" alt="">'.count($comments).'
														</button>
													</li>
												</ul>
											</div>
											<div class="comment-section" id="comment-section-'.$p[0].'">
												<div class="comment-sec">
													';
														foreach($comments as $cmt){
															echo'
															<div class="comment-list">
																<div class="bg-img">
																	<img src="'.$cmt[3].'" style="width:40px;height:40px" alt="">
																</div>
																<div class="comment">
																	<h3>'. strtolower($cmt[1]).' '. strtolower($cmt[2]).'</h3>';
																	$time = abs(time()-strtotime($cmt[5])-3600);
																	if($time>=0 && $time<60)
																	{
																		echo'<span><img src="images/clock.png" alt="">'.$time.' sec ago</span>';
																	} 
																	if($time>=60 && $time<3600) 
																	{
																		$time = intdiv($time,60);
																		echo'<span><img src="images/clock.png" alt="">'.$time.' min ago</span>';
																	}
																	if($time<86400 && $time>=3600)
																	{
																		$time = intdiv($time,3600);
																		echo'<span><img src="images/clock.png" alt="">'.$time.' hour ago</span>';
																	}
																	if($time>=86400) echo'<span><img src="images/clock.png" alt="">'.$cmt[5].'</span>';
																	echo'
																	<p>'.$cmt[4].'</p>
																	</div>
																	<div class="ed-opts">
																		<a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
																		<ul class="ed-options">
																			<li><a href="controllers/deletecomment.php?id='.$cmt[0].'&profile='.$p[0].'" title=""><i class="la la-trash"></i></a></li>
																		</ul>
																	</div>
																	</div><!--comment-list end-->';
														}
														echo'		
												</div><!--comment-sec end-->
												<div class="post-comment">
													<div class="cm_img">
														<img src="'.$u[5].'" alt="" style="width:40px;height:40px">
													</div>
													<div class="comment_box">
														<form action="controllers/addComment.php" method="post" enctype="multipart/form-data">
															<input type="text" name="comment" placeholder="Post a comment">
															<input type="hidden" name="postId" value="'.$p[0].'">
															<input type="hidden" name="profile" value="">
															<button type="submit">Send</button>
														</form>
													</div>
												</div><!--post-comment end-->
											</div><!--comment-section end-->
											</div><!--post-bar end-->';}?>      
											<div class="process-comm">
												<div class="spinner">
													<div class="bounce1"></div>
													<div class="bounce2"></div>
													<div class="bounce3"></div>
												</div>
											</div><!--process-comm end-->
										</div><!--posts-section end-->
									</div><!--product-feed-tab end-->
									<div class="product-feed-tab" id="info-dd">
										<div class="user-profile-ov st2">
											<h3><a href="#" title="" class="exp-bx-open">Social Links </a><a href="#" title="" class="exp-bx-open social-btn-edit"  ><i class="fa fa-plus-square"></i></a></h3>
											<?php
											$socials = $dao->GetUserSocials($userId);
											$i=0;
											foreach($socials as $so){
												$i++;
												echo'<h4>'.$so[1].'</h4><a href="controllers/deletesocial.php?socialid='.$so[0].'" class="social-btn-edit" style="float:right;margin-left:10px"  title=""><i class="fa fa-trash"></i></a>';
												if($i==count($socials)) echo '<p class="no-margin"><a href="'.$so[2].'" title="" target=”_blank”>'.$so[2].'</a></p>';
												else echo '<p><a href="'.$so[2].'" title="" target=”_blank”>'.$so[2].'</a></p>';
											}
											?>
										</div><!--user-profile-ov end-->
										<div class="user-profile-ov">
											<h3><a href="#" title="" class="ed-box-open">User Informations</a> <a href="#" title="" class="ed-box-open"><i class="fa fa-pencil"></i></a> </h3>
											<?php
											$user = $dao->GetUserInfo($nono);
											foreach($user as $u){
												echo'
												<h4>Full Name</h4>
												<p>'.$u[1].' '.$u[2].'</p><br>
												<h4>Adress</h4>
												<p>'.$u[3].'</p><br>
												<h4>Gender</h4>
												<p>'.$u[4].'</p><br>
												<h4>Email</h4>
												<p>'.$u[5].'</p><br>
												<h4>Birthdate</h4>
												<p>'.$u[6].'</p>
												';
											}
											?>
											
										</div><!--user-profile-ov end-->
									</div><!--product-feed-tab end-->			
								</div><!--main-ws-sec end-->
							</div>
							<div class="col-lg-3">
								<div class="right-sidebar">
									<div class="widget widget-portfolio">
										<div class="wd-heady">
											<h3>Posts</h3>
											<img src="images/photo-icon.png" alt="">
										</div>
										<div class="pf-gallery" id="lastdiv">
											<ul>
												<?php
												$posts = $dao->GetUserPublicationsImg($userId);
												foreach($posts as $p){
													echo'<li><a href="profile.php#'.$p[0].'" title=""><img src="'.$p[6].'" alt=""></a></li>
													';
												}
														
													

												?>
											</ul>
										</div><!--pf-gallery end-->
									</div><!--widget-portfolio end-->
								</div><!--right-sidebar end-->
							</div>
						</div>
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
									<input type="hidden" name="profilepage" value="1">
									<button type="submit"><i class="fa fa-send"></i></button>
								</form>
							</div><!--typing-msg end--></div>
							</div></div>
						';	
						}}?>
					</div><!--chat-list end-->
		</div><!--chatbox-list end-->
					</div><!-- main-section-data end-->
				</div> 
			</div>
		</main>
		<?php include('models/footer.php')?>				

		<div class="overview-box" id="statut-box">
			<div class="overview-edit">
				<h3>Statut</h3>
				<span>50 character left</span>
				<form action="controllers/changestatut.php" method="post">
					<input type="text" name="statut" >
					<button type="submit" class="save">Save</button>
					<button  class="cancel" onclick="statutbox()">Cancel</button>
				</form>
				<button style=" all: unset;" onclick="statutbox()"><a title="" class="close"><i class="la la-close"></i></a></button>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->

		<div class="overview-box" id="profile-img">
			<div class="overview-edit">
				<h3>Profile Picture</h3>
				<form action="controllers/changeprofilepic.php" method="post" enctype="multipart/form-data">
					<input type="file" name="img" >
					<button type="submit" class="save">Save</button>
					<button  class="cancel" onclick="profileImgBox()">Cancel</button>
				</form>
				<button style=" all: unset;" onclick="profileImgBox()"><a title="" class="close"><i class="la la-close"></i></a></button>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->			
		
		<div class="overview-box" id="background-img">
			<div class="overview-edit">
				<h3>Profile Background Picture</h3>
				<form action="controllers/changebackgroundpic.php" method="post" enctype="multipart/form-data">
					<input type="file" name="img" >
					<button type="submit" class="save">Save</button>
					<button  class="cancel" onclick="backgroundImgBox()">Cancel</button>
				</form>
				<button style=" all: unset;" onclick="backgroundImgBox()"><a title="" class="close"><i class="la la-close"></i></a></button>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->


		<div class="overview-box" id="experience-box">
			<div class="overview-edit">
				<h3>Social Links</h3>
				<form action="controllers/addsocial.php" method="post" >
					<input type="text" name="name" placeholder="Name">
					<input type="text" name="link" placeholder="Link">
					<button type="submit" class="save">Save</button>
					<button class="cancel">Cancel</button>
				</form>
				<a href="#" title="" class="close-box"><i class="la la-close"></i></a>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->

		<div class="overview-box" id="education-box">
			<div class="overview-edit">
				<h3>User Info</h3>
				<form action="controllers/updateuser.php" method="post" enctype="multipart/form-data">
					<?php
					$user = $dao->GetUserInfo($nono);
					foreach($user as $ur){
						echo'
						<div class="row">
						<div class="col-lg-6 no-left-pd">
							<input type="text" name="fname" value="'.$ur[1].'" placeholder="First Name" required>	
						</div>
						<div class="col-lg-6 no-righ-pd">
							<input type="text" name="lname" value="'.$ur[2].'" placeholder="Last Name" required>
						</div>
						</div>
						<input type="text" name="address" value="'.$ur[3].'" placeholder="Address" required>';
						if(!empty($ur[4])){
							if($ur[4]=='Male'){
								echo'
								<select name="gender" id="pet-select" required>
									<option value="2" selected>Male</option>
									<option value="" disabled >--Please Select Yout Gender--</option>
									<option value="2">Male</option>
									<option value="1">Female</option>
								</select>
								';
							}
							else{
								echo'
								<select name="gender" id="pet-select" required>
									<option value="1" selected>Female</option>
									<option value="" disabled >--Please Select Yout Gender--</option>
									<option value="2">Male</option>
									<option value="1">Female</option>
								</select>
								';
							}
							
						}
						else{
							echo'
							<select name="gender" id="pet-select" required>
								<option value="" disabled selected>--Please Select Yout Gender--</option>
								<option value="2">Male</option>
								<option value="1">Female</option>
							</select>
							';
						}
							
						echo'<input type="email" name="email" value="'.$ur[5].'" placeholder="Email" required>
						<div class="datepicky">
							<div class="datefm">
								<input type="text" name="birthdate" value="'.$ur[6].'" placeholder="Birthdate" class="datepicker" required>	
								<i class="fa fa-calendar"></i>
							</div>
						</div>
						';
					}
					?>
					<button type="submit" class="save">Save</button>
					<button class="cancel">Cancel</button>
				</form>
				<a href="#" title="" class="close-box"><i class="la la-close"></i></a>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->

		<div class="overview-box" id="location-box">
			<div class="overview-edit">
				<h3>Location</h3>
				<form>
					<div class="datefm">
						<select>
							<option>Country</option>
							<option value="pakistan">Pakistan</option>
							<option value="england">England</option>
							<option value="india">India</option>
							<option value="usa">United Sates</option>
						</select>
						<i class="fa fa-globe"></i>
					</div>
					<div class="datefm">
						<select>
							<option>City</option>
							<option value="london">London</option>
							<option value="new-york">New York</option>
							<option value="sydney">Sydney</option>
							<option value="chicago">Chicago</option>
						</select>
						<i class="fa fa-map-marker"></i>
					</div>
					<button type="submit" class="save">Save</button>
					<button type="submit" class="cancel">Cancel</button>
				</form>
				<a href="#" title="" class="close-box"><i class="la la-close"></i></a>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->

		<div class="overview-box" id="skills-box">
			<div class="overview-edit">
				<h3>Skills</h3>
				<ul>
					<li><a href="#" title="" class="skl-name">HTML</a><a href="#" title="" class="close-skl"><i class="la la-close"></i></a></li>
					<li><a href="#" title="" class="skl-name">php</a><a href="#" title="" class="close-skl"><i class="la la-close"></i></a></li>
					<li><a href="#" title="" class="skl-name">css</a><a href="#" title="" class="close-skl"><i class="la la-close"></i></a></li>
				</ul>
				<form>
					<input type="text" name="skills" placeholder="Skills">
					<button type="submit" class="save">Save</button>
					<button type="submit" class="save-add">Save & Add More</button>
					<button type="submit" class="cancel">Cancel</button>
				</form>
				<a href="#" title="" class="close-box"><i class="la la-close"></i></a>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->

		<div class="overview-box" id="create-portfolio">
			<div class="overview-edit">
				<h3>Create Portfolio</h3>
				<form>
					<input type="text" name="pf-name" placeholder="Portfolio Name">
					<div class="file-submit">
						<input type="file" name="file">
					</div>
					<div class="pf-img">
						<img src="http://via.placeholder.com/60x60" alt="">
					</div>
					<input type="text" name="website-url" placeholder="htp://www.example.com">
					<button type="submit" class="save">Save</button>
					<button type="submit" class="cancel">Cancel</button>
				</form>
				<a href="#" title="" class="close-box"><i class="la la-close"></i></a>
			</div><!--overview-edit end-->
		</div><!--overview-box end-->

	</div><!--theme-layout end-->



<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/popper.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/flatpickr.min.js"></script>
<script type="text/javascript" src="lib/slick/slick.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>