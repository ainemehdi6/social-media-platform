<?php
$user_Id=$dao->GetUserId($nono);
$user=$dao->GetUser($nono);
foreach($user as $us){
echo'<header>
			<div class="container">
				<div class="header-data">
					<div class="logo">
						<a href="home.php" title=""><img src="images/logo.png" alt=""></a>
					</div><!--logo end-->
					<div class="search-bar">
						<form action="search.php" method="GET">
							<input type="text" name="search" placeholder="Search...">
							<button type="submit"><i class="la la-search"></i></button>
						</form>
					</div><!--search-bar end-->
					<nav>
						<ul>
							<li>
								<a href="home.php" title="">
									<span><img src="images/icon1.png" alt=""></span>
									Home
								</a>
							</li>
							<li>
								<a href="profile.php" title="">
									<span><img src="images/icon4.png" alt=""></span>
									Profile
								</a>

							</li>
							<li>
								<a href="#" title="" class="not-box-open">
									<span><img src="images/icon6.png" alt=""></span>
									Messages
								</a>
								<div class="notification-box msg">
									<div class="nt-title">
										<h4>Messages</h4>
									</div>
									<div class="nott-list">';	
									$mesid = $dao->GetMessageId($user_Id);
									foreach($mesid as $mi){
										$iddd = implode("",$mi);
										$message = $dao->GetMessages($user_Id,$iddd);	
										foreach($message as $m){
											$user = $dao->GetUserById($mi);
											foreach($user as $u){
												echo'
												<div class="notfication-details">
													<div class="noty-user-img">
														<img src="'.$u[3].'" alt="" style="width:40px;height:40px;">
													</div>
														<div class="notification-info">
														<a href="user-profile.php?user-id='.$iddd.'" title=""><h3 style="color:black">'.strtolower($u[0]).' '.strtolower($u[1]).'</h3></a> 
														<button onclick="ChatlistBox();chatBoxActive('.$iddd.')" style=" all: unset; "><p>';
														if(strlen($m[0])>40){
															$sb = strlen($m[0])/40;
															$j=0;
															for ($i=0; $i < $sb; $i++) { 
																$j++;
																$p1 = substr($m[0], $i*40, 40*$j);
																echo "$p1<br>";
															}
															
														}
														else echo $m[0];	
														echo'</p></button>';
														$time = abs(time()-strtotime($m[1])-3600);
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
																	if($time>=86400) echo'<span>'.$m[1].'</span>';	
														echo'</div><!--notification-info -->
												</div>
												';
											}
										}
									}
										echo'
						  				<div class="view-all-nots">
						  					<a href="#" title="">View All Messsages</a>
						  				</div>
									</div><!--nott-list end-->
								</div><!--notification-box end-->
							</li>
							<li>
								<a href="#" title="" class="not-box-open">
									<span><img src="images/icon7.png" alt=""></span>
									Notifications
								</a>
								<div class="notification-box">
									<div class="nt-title">
										<h4>Notifications</h4>
									</div>
									<div class="nott-list">';
										$notifications = $dao->GetNotifications($user_Id);
										$i=0;
										foreach($notifications as $not){
											$i++;
											if($i==6) break;
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
										echo'
						  				<div class="view-all-nots">
						  					<a href="profile-account-setting.php" title="">View All Notification</a>
						  				</div>
									</div><!--nott-list end-->
								</div><!--notification-box end-->
							</li>
						</ul>
					</nav><!--nav end-->
					<div class="menu-btn">
						<a href="#" title=""><i class="fa fa-bars"></i></a>
					</div><!--menu-btn end-->
					<div class="user-account">
						<div class="user-info">
							<img src="'.$us[5].'" style="width:30px;height:30px" alt="">
							<a href="#" title="">'.strtolower($us[1]).'</a>
							<i class="la la-sort-down"></i>
						</div>
						<div class="user-account-settingss">
							<h3>Setting</h3>
							<ul class="us-links">
								<li><a href="profile-account-setting.php#nav-password" title="">Account Setting</a></li>
								<li><a href="#" title="">Privacy</a></li>
								<li><a href="#" title="">Faqs</a></li>
								<li><a href="#" title="">Terms & Conditions</a></li>
							</ul>
							<h3 class="tc"><a href="controllers/logout.php" title="">Logout</a></h3>
						</div><!--user-account-settingss end-->
					</div>
				</div><!--header-data end-->
			</div>
		</header><!--header end-->
	
';}?>