<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'common/assets/extra-libs/multicheck/multicheck.css';?>">
	<link href="<?php echo base_url().'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<title><?php echo comp_name; ?> | Money Receipts</title>
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
	<!-- ============================================================== -->
	<!-- Topbar header - style you can find in pages.scss -->
	<?php $this->load->view('header_main'); ?>
	<!-- End Topbar header -->
	<!-- Left Sidebar - style you can find in sidebar.scss  -->
	<?php $this->load->view('sidebar_main'); ?>
	<!-- End Left Sidebar - style you can find in sidebar.scss  -->
	<!-- ============================================================== -->
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-12 d-flex no-block align-items-center">
					<h4 class="page-title">Money Receipts</h4>
					<div class="ml-auto text-right">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Money Receipts</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<div class="container-fluid">
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						<h5 class="card-title">Report</h5>
						<form action="<?php echo base_url();?>mrreport" method="POST" target="_blank">
							<div class="input-group">
								<div class="col-sm-5">
								<label class="m-t-15"><i class="fa fa-calendar"></i> From Date:</label>
									<input type="text" class="form-control" id="from_date" name="from_date" placeholder="yyyy-mm-dd" autocomplete="off" required>
								</div>
								<div class="col-sm-5">
								<label class="m-t-15"><i class="fa fa-calendar"></i> To Date:</label>
										<input type="text" class="form-control" id="to_date" name="to_date" placeholder="yyyy-mm-dd" autocomplete="off" required>
								</div>
								<div class="col-sm-2">
								<label class="m-t-15"><i class="icofont-print"></i> Get Report:</label>
									<button type="submit" class="btn badge-primary form-control">Report</button>
								</div>
							</div>
						</form>
						<hr />

							<h5 class="card-title">Money Receipts <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'newmoneyreceipt'; ?>'">New Money Receipt</button> <span style="margin-left: 50px;"><i class="icofont-copy-invert"></i> Total Billed (<?php echo (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')!=1)?($this->session->userdata('fullname').', '.dt):dt;  ?>): <i class="icofont-rupee"></i><?php echo $grand_tot; ?></span></h5>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
									<tr class="textcen">
										<th>Sl</th>
										<th>Created On</th>
										<th>Bill No</th>
										<th>Patient</th>
										<th>Under</th>
										<th>Received Rs.</th>
										<th>Bill</th>
										<th>Billed By</th>
										<?php /* <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) { 
												?>
										<th>Action</th>
										<?php } ?> */?>

									</tr>
									</thead>
									<tbody class="textcen">
									<?php
									if(!empty($mr_data)){
										//print_obj($mr_data);die;
										$sl=1;
										foreach($mr_data as $key => $val){
											?>
											<tr>
												<td><?php echo $sl; ?></td>
												<td><?php echo $val['created_dtime']; ?></td>
												<td><?php echo $val['mr_bill_no']; ?></td>
												<td><?php echo $val['patient_name']; ?></td>
												<td><?php echo $val['doctor_name']; ?></td>
												<td><?php echo $val['received_rs']; ?></td>
												<td>
													<?php 
														$mod_mr_billno  = str_replace("/", "_", $val['mr_bill_no']);
													  ?>
														 <button type="button" onclick="window.open('<?php echo base_url().'print_receipt/'.$mod_mr_billno; ?>','_blank')"><i class="icofont-search-document"></i></button> 
												</td>
												<td><?php echo $val['created_user']; ?>
												<?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) {
													?>
													  <br />
														<button type="button" class="del_mr" data-mrid="<?php echo $val['mr_id']; ?>" data-billno="<?php echo $val['mr_bill_no']; ?>"><i class="fas fa-trash-alt"></i></button>
													  
												<?php } ?>
												</td>
											</tr>
											<?php
											$sl++;
										}
									}
									else{
										if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1) { 
										?>
										<tr><td colspan="8">No data found</td></tr>
									<?php
										}else{
											?>
											<tr><td colspan="7">No data found</td></tr>
											<?php
											}
										}
									?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Container fluid  -->
		<!-- ============================================================== -->
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
<?php $this->load->view('bottom_js'); ?>
<!-- this page js -->
<script src="<?php echo base_url().'common/assets/extra-libs/multicheck/datatable-checkbox-init.js';?>"></script>
<script src="<?php echo base_url().'common/assets/extra-libs/multicheck/jquery.multicheck.js';?>"></script>
<script src="<?php echo base_url().'common/assets/extra-libs/DataTables/datatables.min.js';?>"></script>
<script src="<?php echo base_url();?>common/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
	
	$('#from_date').datepicker({
            autoclose: true,
            todayHighlight: true
		});
		$('#to_date').datepicker({
            autoclose: true,
            todayHighlight: true
		});
		
	$('#zero_config').DataTable();

	$(document).ready(function(){

	
	$(document).on('click', '.del_mr', function(){

		var mrid = $(this).attr('data-mrid');
		var billno = $(this).attr('data-billno');

		conf = confirm('Are you sure to delete '+billno+'?');
		if(conf){
			$.ajax({

					type:'POST',

					url:'<?php echo base_url();?>deletemreceipt',

					data:{mrid:mrid,billno:billno},

					success:function(d){

						if(d.deleted=='success'){

							alert('Receipt deleted!');
							window.location.reload();

						}
						else if(d.deleted=='not_exists'){

							alert('Receipt not exists!');

						}else{
							alert('Something went wrong!');
						}

					}

				});
			}
		});	

	

});
</script>

</body>

</html>
