<div class="search-area">
			<div class="search-input">
				<div class="search-close">
					<span></span>
					<span></span>
				</div>
				<form>
					<input type="text" name="text" placeholder="*Search Here">
				</form>
			</div>
		</div>

		<!-- mobile-nav section start here -->
		<div class="mobile-menu">
			<nav class="mobile-header primary-menu d-lg-none">
				<div class="header-logo">
					<a href="index.php" class="logo"><img src="assets/images/logo/01.png" alt="logo"></a>
				</div>
				<div class="header-bar" id="open-button">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</nav>
			<nav class="menu">
				<div class="mobile-menu-area d-lg-none">
					<div class="mobile-menu-area-inner" id="scrollbar">
						<ul class="m-menu">
							<li><a href="index.php">Home</a> </li>
							
							<li><a href="cows.php">Cows</a></li>
							<li><a href="milkQuery.php">Buy Milk</a></li>
							<?php
								if (isset($_SESSION['logged_username'])) { ?>
									<li><a href=""><?php echo $_SESSION['logged_username'] ?></a>
										<ul class="m-submenu">
											<li><a href="logout.php">Logout</a></li>
										</ul>
									</li>
								<?php }else{
									echo "<li><a href='login.php'>Login</a></li>";
								}
							?>
							
						</ul>
						<ul class="social-link-list d-flex flex-wrap">
							<li><a href="#" class="facebook"><i class=" fab fa-facebook-f"></i></a></li>
							<li><a href="#" class="twitter-sm"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
							<li><a href="#" class="google"><i class="fab fa-google-plus-g"></i></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<!-- mobile-nav section ending here -->

		<!-- header section start here -->
		<header class="header-section d-none d-lg-block">
			<div class="header-top">
				<div class="container">
					<div class="htop-area row">
						<div class="htop-left">
							<ul class="htop-information">
								<li><i class="far fa-envelope"></i> Gowala45@gmail.com</li>
								<li><i class="fas fa-phone-volume"></i> +88 130 589 745 6987</li>
								<li><i class="far fa-clock"></i> Mon - Fri 09:00 - 18:00</li>
							</ul>
						</div>
						<div class="htop-right">
							<ul>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-behance"></i></a></li>
								<li><a href="#"><i class="fab fa-instagram"></i></a></li>
								<li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
								<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="header-bottom transparent-bottom">
				<div class="container">
					<div class="row">
						<nav class="primary-menu">
							<div class="menu-area">
								<div class="row justify-content-between align-items-center">
									<a href="index.php" class="logo">
										<img src="assets/images/logo/01.png" alt="logo">
									</a>
									<div class="main-menu-area d-flex align-items-center">
										<ul class="main-menu d-flex align-items-center">
											<li><a href="index.php">Home</a> </li>
											
											
											<li><a href="cows.php">Cows</a></li>
											<li><a href="milkQuery.php">Buy Milk</a></li>
											
											<?php
												if (isset($_SESSION['logged_user_id'])) { ?>
													<li><a href=""><?php echo $_SESSION['logged_username'] ?></a>
														<ul class="submenu">
															<li><a href="profile.php">Profile</a></li>
															<li><a href="logout.php">Logout</a></li>
														</ul>
													</li>
												<?php }else{
													echo "<li><a href='login.php'>Login</a></li>";
												}
											?>
											
										</ul>
										
									</div>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</header>
		<!-- header section ending here -->