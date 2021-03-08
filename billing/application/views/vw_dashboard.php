
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<title><?php echo comp_name; ?> | Dashboard</title>
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
	<div class="lds-ripple">
		<div class="lds-pos"></div>
		<div class="lds-pos"></div>
	</div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
	<!-- Topbar header - style you can find in pages.scss -->
	<?php $this->load->view('header_main'); ?>
	<!-- End Topbar header -->
	<!-- Left Sidebar - style you can find in sidebar.scss  -->
	<?php $this->load->view('sidebar_main'); ?>
	<!-- End Left Sidebar - style you can find in sidebar.scss  -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- Page wrapper  -->
	<!-- ============================================================== -->
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-12 d-flex no-block align-items-center">
					<h4 class="page-title">Dashboard</h4>
					<div class="ml-auto text-right">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Library</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 d-flex no-block align-items-center">
					<p class="page-title"><i class="icofont-calendar"></i> Next Renewal: Jun 8, 2021</p>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Container fluid  -->
		<!-- ============================================================== -->
		<div class="container-fluid">
			<!-- ============================================================== -->
			<!-- Sales Cards  -->
			<!-- ============================================================== -->
			<div class="row">
				<!-- Column -->
				<div class="col-md-6 col-lg-2 col-xlg-3">
					<div class="card card-hover">
						<a href="<?php echo base_url();?>newinvoice">
							<div class="box bg-cyan text-center">
								<h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
								<h6 class="text-white">New invoice</h6>
							</div>
						</a>
					</div>
				</div>
				<!-- Column -->
				<div class="col-md-6 col-lg-4 col-xlg-3">
					<div class="card card-hover">
						<a href="<?php echo base_url();?>newmoneyreceipt">
							<div class="box bg-success text-center">
								<h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
								<h6 class="text-white">New Money Receipt</h6>
							</div>
						</a>
					</div>
				</div>
				<!-- Column -->
				<div class="col-md-6 col-lg-2 col-xlg-3">
					<div class="card card-hover">
						<a href="<?php echo base_url();?>invoices">
							<div class="box bg-warning text-center">
								<h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
								<h6 class="text-white">Invoices</h6>
							</div>
						</a>
					</div>
				</div>
				<!-- Column -->
				<div class="col-md-6 col-lg-2 col-xlg-3">
					<div class="card card-hover">
						<a href="<?php echo base_url();?>moneyreceipts">
							<div class="box bg-danger text-center">
								<h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
								<h6 class="text-white">Money Receipts</h6>
							</div>
						</a>
					</div>
				</div>
				<!-- Column -->
				<div class="col-md-6 col-lg-2 col-xlg-3">
					<div class="card card-hover">
						<a href="<?php echo base_url();?>items">
							<div class="box bg-info text-center">
								<h1 class="font-light text-white"><i class="mdi mdi-arrow-all"></i></h1>
								<h6 class="text-white">Items</h6>
							</div>
						</a>
					</div>
				</div>
				<!-- Column -->
			</div>
			<!-- ============================================================== -->
			<!-- Sales chart -->
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="d-md-flex align-items-center">
								<div>
									<h4 class="card-title">Site Analysis</h4>
									<h5 class="card-subtitle">Overview of Suraha Nursing Home Pvt. Ltd.</h5>
								</div>
							</div>
							<div class="row">
								<!-- column -->
								<div class="col-lg-9">
									<div class="flot-chart">
										<div class="flot-chart-content" id="flot-line-chart"></div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="row">
										<div class="col-6">
											<div class="bg-dark p-10 text-white text-center">
												<i class="fa fa-user m-b-5 font-16"></i>
												<h5 class="m-b-0 m-t-5">0</h5>
												<small class="font-light">Total Users</small>
											</div>
										</div>
										<div class="col-6">
											<div class="bg-dark p-10 text-white text-center">
												<i class="fa fa-plus m-b-5 font-16"></i>
												<h5 class="m-b-0 m-t-5">0</h5>
												<small class="font-light">New Users</small>
											</div>
										</div>
										<div class="col-6 m-t-15">
											<div class="bg-dark p-10 text-white text-center">
												<i class="fa fa-cart-plus m-b-5 font-16"></i>
												<h5 class="m-b-0 m-t-5">0</h5>
												<small class="font-light">Total Shop</small>
											</div>
										</div>
										<div class="col-6 m-t-15">
											<div class="bg-dark p-10 text-white text-center">
												<i class="fa fa-tag m-b-5 font-16"></i>
												<h5 class="m-b-0 m-t-5">0</h5>
												<small class="font-light">Total Orders</small>
											</div>
										</div>
										<div class="col-6 m-t-15">
											<div class="bg-dark p-10 text-white text-center">
												<i class="fa fa-table m-b-5 font-16"></i>
												<h5 class="m-b-0 m-t-5">0</h5>
												<small class="font-light">Pending Orders</small>
											</div>
										</div>
										<div class="col-6 m-t-15">
											<div class="bg-dark p-10 text-white text-center">
												<i class="fa fa-globe m-b-5 font-16"></i>
												<h5 class="m-b-0 m-t-5">0</h5>
												<small class="font-light">Online Orders</small>
											</div>
										</div>
									</div>
								</div>
								<!-- column -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- footer -->
		<!-- ============================================================== -->
		<?php $this->load->view('footer'); ?>
		<!-- ============================================================== -->
		<!-- End footer -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Page wrapper  -->
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- All Jquery -->
<!-- ============================================================== -->
<?php $this->load->view('bottom_js'); ?>
<!--This page JavaScript -->
<!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->

<!-- Charts js Files -->
<script src="<?php echo base_url().'common/assets/libs/flot/excanvas.js';?>"></script>
<script src="<?php echo base_url().'common/assets/libs/flot/jquery.flot.js';?>"></script>
<script src="<?php echo base_url().'common/assets/libs/flot/jquery.flot.pie.js';?>"></script>
<script src="<?php echo base_url().'common/assets/libs/flot/jquery.flot.time.js';?>"></script>
<script src="<?php echo base_url().'common/assets/libs/flot/jquery.flot.stack.js';?>"></script>
<script src="<?php echo base_url().'common/assets/libs/flot/jquery.flot.crosshair.js';?>"></script>
<script src="<?php echo base_url().'common/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js';?>"></script>
<script src="<?php echo base_url().'common/dist/js/pages/chart/chart-page-init.js';?>"></script>
<!-- ============================================================== -->

</body>

</html>
