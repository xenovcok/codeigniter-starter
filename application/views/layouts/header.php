<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MACITO</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/assets/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/assets/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/assets/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="/assets/assets/css/custom.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="/assets/js/plugins/loaders/pace.min.js"></script>
	<script src="/assets/js/core/libraries/jquery.min.js"></script>
	<script src="/assets/js/core/libraries/bootstrap.min.js"></script>
	<script src="/assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="/assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script src="/assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script src="/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script src="/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="/assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="/assets/assets/js/app.js"></script>
	<script src="/assets/assets/js/custom.js"></script>
	<!-- <script src="/assets/js/demo_pages/dashboard.js"></script> -->
	<!-- /theme JS files -->

</head>

<body>


	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="/assets/images/logo_macito.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<!-- <p class="navbar-text"><span class="label bg-success">Online</span></p> -->

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="/assets/images/logo_macito.png" alt="">
						<span><?= $this->session->userdata('name') ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<!-- <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
						<li><a href="#"><i class="icon-coins"></i> My balance</a></li>
						<li><a href="#"><span class="badge bg-teal-400 pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li> -->
						<li><a href="/auth/logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">
					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">
								<li class="navigation-header"><span>Home</span> <i class="icon-menu"></i></li>
								<li class="<?= $page === 'Dashboard' ? 'active' : '' ?>">
									<a href="/page/dashboard">
										<i class="icon-home4"></i><span>Dashboard</span>
									</a>
								</li>
								<li class="<?= $page === 'Booking' ? 'active' : '' ?>">
									<a href="/page/booking">
										<i class="icon-book2"></i><span>Booking</span>
									</a>
								</li>
								<li class="<?= $page === 'Booking Check' ? 'active' : '' ?>">
									<a href="/page/booking-check" target="_blank">
										<i class="icon-clipboard5"></i> <span class="text-primary">Booking Check</span>
									</a>
								</li>

								<!-- Inventory -->

								<li class="navigation-header"><span>Bus</span> <i class="icon-menu"></i></li>
								<li class="<?= $page === 'Bus' ? 'active' : '' ?>">
									<a href="/page/bus">
										<i class="icon-bus"></i> <span>Bus List</span>
									</a>
								</li>
								<li>
									<a href="#" class="has-ul">
										<i class="icon-calendar"></i><span>Schedule</span>
									</a>
									<ul class="hidden-ul" style="<?= ($page === 'Schedule' || $page === 'Holiday') ? 'display: block' : 'display:none' ?>">
										<li class="<?= $page === 'Schedule' ? 'active' : '' ?>">
											<a href="/page/schedule">
												<span>Schedule Time</span>
											</a>
										</li>
										<li class="<?= $page === 'Holiday' ? 'active' : '' ?>">
											<a href="/page/holiday">
												<span>Holiday</span>
											</a>
										</li>
									</ul>
								</li>

								<li class="navigation-header"><span>User</span> <i class="icon-menu"></i></li>
								<li class="<?= $page === 'User' ? 'active' : '' ?>">
									<a href="/page/user">
										<i class="icon-users"></i> <span>User List</span>
									</a>
								</li>
								<li class="<?= $page === 'Settings' ? 'active' : '' ?>">
									<a href="/page/settings">
										<i class="icon-gear"></i> <span>Settings</span>
									</a>
								</li>

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->

			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->

				<!-- /page header -->
