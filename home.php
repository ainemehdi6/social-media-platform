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
<title>Socily - Home Page</title>
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
		<main>
			<div class="main-section">
				<div class="container">
					<div class="main-section-data">
						<div class="row">
							<div class="col-lg-3 col-md-4 pd-left-none no-pd">
								<div class="main-left-sidebar no-margin">
									<div class="user-data full-width">
										<div class="user-profile">
											<div class="username-dt">
												<?php $user = $dao->GetUser($nono);
                                                foreach($user as $u){
												echo'<div class="usr-pic">
													<img src="'.$u[5].'" style="width:100px; height:100px" alt="">
												</div>
											</div><!--username-dt end-->
											<div class="user-specs">
												<h3>'. strtolower($u[0]).' '. strtolower($u[1]).'</h3>
												<span>'.$u[4].'</span>            
											</div>
										</div><!--user-profile end-->
										<ul class="user-fw-status">
											<li>
												<h4>Following</h4>
												<span>'.$dao->FollowNumber($userId).'</span>
											</li>
											<li>
												<h4>Followers</h4>
												<span>'.$dao->FollowerNumber($userId).'</span>
											</li>
											<li>
												<a href="profile.php" title="">View Profile</a>
											</li>
										</ul>
									</div><!--user-data end-->
									<div class="tags-sec full-width">
										<ul>
											<li><a href="#" title="">Help Center</a></li>
											<li><a href="#" title="">About</a></li>
											<li><a href="#" title="">Privacy Policy</a></li>
											<li><a href="#" title="">Cookies Policy</a></li>
											<li><a href="#" title="">Copyright Policy</a></li>
										</ul>
										<div class="cp-sec">
											<img src="images/logo2.png" alt="">
											<p><img src="images/cp.png" alt="">Copyright 2022</p>
										</div>
									</div><!--tags-sec end-->
								</div><!--main-left-sidebar end-->
							</div>
							<div class="col-lg-6 col-md-8 no-pd">
								<div class="main-ws-sec">
									<div class="post-topbar">
										<div class="user-picy">
										<img src="'.$u[5].'" style="width:100px; height:100px" alt="">
										</div>
										<div class="post-st">
											<ul>
												<li><a class="post-jb active" href="#" title="">Post an Article</a></li>
											</ul>
										</div><!--post-st end-->
									</div><!--post-topbar end-->
									<div class="posts-section">';}
									$follows = $dao->GetFollowesId($userId);
									$counter = 0;
									foreach($follows as $f){
										$posts = $dao->GetUsersPublications($f);
										foreach($posts as $p)
										{
											$counter++;
											echo'	
											<div class="post-bar">
											<div class="post_topbar">
												<div class="usy-dt">
													<img src="'.$p[3].'" style="widsth:50px;height:50px"alt="">
													<div class="usy-name">
															<a href="user-profile.php?user-id='.$f[0].'"><h3>'.$p[1].' '.$p[2].'</h3></a>';
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
													if($dao->testlikepost($userId,$p[0])) echo'<a href="controllers/likepost.php?postId='.$p[0].'" style="color:#00AFF0;"><i class="la la-heart"></i>Unlike</a>';
													else echo'<a href="controllers/likepost.php?postId='.$p[0].'"><i class="la la-heart"></i> Like</a>';
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
																</div>';
																	if($userId==$cmt[6]){
																		echo'
																		<div class="ed-opts">
																			<a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
																			<ul class="ed-options">
																				<li><a href="controllers/deletecomment.php?id='.$cmt[0].'&home=1" title=""><i class="la la-trash"></i></a></li>
																			</ul>
																		</div>
																		';
																	}							
															echo'</div><!--comment-list end-->';
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
															<button type="submit">Send</button>
														</form>
													</div>
												</div><!--post-comment end-->
											</div><!--comment-section end-->
										</div><!--post-bar end-->';
										if($counter == count($posts))
										{
											echo'
											<div class="top-profiles">
											<div class="pf-hd">
												<h3>Top Profiles</h3>
											</div>
											<div class="profiles-slider">';
												$profiles = $dao->GetUsers($userId);
												foreach($profiles as $p){
												echo'	
												<div class="user-profy">
													<img src="'.$p[3].'" style="width:57px;height:57px" alt="">
													<h3>'.strtolower($p[1]).' '.strtolower($p[2]).'</h3>
													<span>'.$p[4].'</span>
													<ul>';
													if($dao->testfollow($p[0],$userId)){
														echo'<li><a href="controllers/unfriend.php?follower='.$p[0].'" title="" class="btn btn-secondary" >Unfollow</a></li>';
													}
													else{
														echo'<li><a href="controllers/addfriend.php?follower='.$p[0].'" title="" class="followw">Follow</a></li>';
													}	
														echo'
													<li><a href="message.php?user-id='.$p[0].'" title="" class="envlp"><img src="images/envelop.png" alt=""></a></li>
													</ul>
													<a href="#" title="">View Profile</a>
												</div><!--user-profile end-->';
												}
											echo'</div><!--profiles-slider end-->
										</div><!--top-profiles end-->';
										}
										}
										
									}
									?>
										<div class="process-comm">
											<div class="spinner">
												<div class="bounce1"></div>
												<div class="bounce2"></div>
												<div class="bounce3"></div>
											</div>
										</div><!--process-comm end-->
									</div><!--posts-section end-->
								</div><!--main-ws-sec end-->
							</div>
							<div class="col-lg-3 pd-right-none no-pd">
								<div class="right-sidebar">
									<div class="widget widget-about">
										<img src="images/wd-logo.png" alt="">
										<h3>Chat with friends  on Socily</h3>
										<span>Any Time and Any Where</span>
									</div><!--widget-about end-->
									
									<div class="widget suggestions full-width">
										<div class="sd-title">
											<h3>Most Viewed People</h3>
										</div><!--sd-title end-->
										<div class="suggestions-list">
											<?php 
											$users = $dao->GetUsers($userId);
											foreach($users as $u){
												echo'
											<div class="suggestion-usd ">
												<img src="'.$u[3].'" alt="" style="width:35px;height:35px;">
												<div class="sgt-text">
													<a href="user-profile.php?user-id='.$u[0].'"><h4>'.strtolower($u[1]).' '.strtolower($u[2]).'</h4></a>
													<span>';
													if(strlen($u[4])>20){
														$u[4] = substr($u[4], 0, 20);
														echo ''.$u[4].' ...</span>';
													}
													else echo''.$u[4].'</span>';
												echo'</div>';
												if($dao->testfollow($u[0],$userId)){
													echo '<span><a href="controllers/unfriend.php?follower='.$u[0].'"><i class="la la-minus"></i></a></span>';
												}
												else{
												echo '<span><a href="controllers/addfriend.php?follower='.$u[0].'"><i class="la la-plus"></i></a></span>';
												}
											echo'</div>';
											}?>	
											<div class="view-more">
												<a href="#" title="">View More</a>
											</div>
										</div><!--suggestions-list end-->
									</div>
								</div><!--right-sidebar end-->
							</div>
						</div>
					</div><!-- main-section-data end-->
				</div> 
			</div>
		</main>
		<div class="post-popup job_post">
			<div class="post-project">
				<h3>Post an Article</h3>
				<div class="post-project-fields">
					<form action="controllers/addpost.php" method="post" enctype="multipart/form-data"> 
						<div class="row">
							<div class="col-lg-12">
								<input type="text" name="title" placeholder="Title">
							</div>
							<div class="col-lg-12">
								<textarea name="description"  placeholder="Description"></textarea>
							</div>
							<div class="col-lg-12">
								<p>Image</p>
								<input type="file" name="image" id="image">
							</div>
							<div class="col-lg-12">
								<ul>
									<li><input  class="active" name="submit" type="submit" value="post"></li>
									<li><a href="#" title="">Cancel</a></li>
								</ul>
							</div>
						</div>
					</form>
				</div><!--post-project-fields end-->
				<a href="#" title=""><i class="la la-times-circle-o"></i></a>
			</div><!--post-project end-->
		</div><!--post-project-popup end-->
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
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="lib/slick/slick.min.js"></script>
<script type="text/javascript" src="js/scrollbar.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>