<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/extra-libs/multicheck/multicheck.css">
	<link href="<?php echo base_url();?>common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/libs/select2/dist/css/select2.min.css">
	<title><?php echo comp_name; ?> | New Money Receipt</title>
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
					<h4 class="page-title">New Money Receipt</h4>
					<div class="ml-auto text-right">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">New Money Receipt</li>
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
				
						<form class="form-horizontal" id="create_user_form">
							<?php //print_obj($user_data);die; ?>
                                <div class="card-body">
                                    <h4 class="card-title">New Money Receipt <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'moneyreceipts'; ?>'">Money Receipts</button></h4><hr>

                                    <h6 class="card-title textcen"><b>Bill No:</b> <?php echo $billno; ?></h6>
                                

                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Under</label>
                                        <div class="col-sm-9">
                                        	<input type="hidden" id="mr_id" value="<?php echo (!empty($item_data) && $item_data['mr_id']!='')?$item_data['mr_id']:'0'; ?>">
                                        	<input type="hidden" name="bill_no" id="bill_no" value="<?php echo ($billno && $billno!='')?$billno:'0'; ?>">
                                           
                                            <select class="select2 form-control custom-select" name="doctor_id" id="doctor_id" style="width: 100%; height:36px;">
                                            	<option value="0">Select</option>
                                            	<?php
												if(!empty($doctor_data)){
													//print_obj($doctor_data);die;
													foreach($doctor_data as $key => $val){
											?>
												<option value="<?php echo $val['doctor_id']; ?>"><?php echo $val['doctor_name']; ?></option>
											<?php
												}
											}
											?>
                                     	</select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Particulars</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="particulars" name="particulars" placeholder="Particulars.." value="<?php echo (!empty($item_data) && $item_data['particulars']!='')?$item_data['particulars']:''; ?>" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Received From</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Patient's Name.." value="<?php echo (!empty($item_data) && $item_data['patient_name']!='')?$item_data['patient_name']:''; ?>" required="">
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Received Rs.</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="received_rs" name="received_rs" placeholder="Received Rs..." value="<?php echo (!empty($item_data) && $item_data['received_rs']!='')?$item_data['received_rs']:''; ?>" required="">
                                        </div>
                                    </div>

                                    
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="button" id="submit" class="btn btn-primary submit_btn">Submit</button>
                                    </div>
								</div>
								<p id="chk_msg" class="textcen" style='display: none;'></p>
                            </form>
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
<script src="<?php echo base_url();?>common/assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
<script src="<?php echo base_url();?>common/assets/extra-libs/multicheck/jquery.multicheck.js"></script>
<script src="<?php echo base_url();?>common/assets/extra-libs/DataTables/datatables.min.js"></script>

 <script src="<?php echo base_url();?>common/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url();?>common/assets/libs/select2/dist/js/select2.min.js"></script>

    <script>
	$(".select2").select2();

	// $("#patient_name").keyup(function(){

 //    var patient_name = $('#patient_name').val();
 //    if(patient_name!=''){
	//    $.ajax({
	//     type: "POST",
	//     url: "<?php echo base_url().'duplicate_check_item'; ?>",
	//     data: {patientname:patient_name},
	    
	//     success: function(d){
	//         if(d.is_exists == 1)
	//         {
	//             $('#chk_msg').show();
	//             $('#chk_msg').html('<i class="icofont-close-squared-alt"></i> Item already exists..!!');
	//             $("#chk_msg").css("color", "red");
	//             $('#submit').attr("disabled", true);
	//             return false;
	//         }else {
	//             $('#chk_msg').show();
	//             $('#chk_msg').html('<i class="icofont-tick-boxed"></i> Item available.');
	//             $("#chk_msg").css("color", "green");
	//             $('#submit').attr("disabled", false);
	//         }
	//      }
	//     });
 //    }else{
 //    	$('#chk_msg').hide();
 //    }
   
 //  });

	$("#submit").click(function(){

		$('.submit_btn').prop('disabled', true);
		$('#chk_msg').show();
		$('#chk_msg').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');

		var mr_bill_no = $('#bill_no').val();
		var patient_name = $('#patient_name').val();
		var doctor_id = $('#doctor_id').val();
		var particulars = $('#particulars').val();
		var received_rs = $('#received_rs').val();

				$.ajax({

					type:'POST',

					url:'<?php echo base_url();?>createmoneyreceipt',

					data:{mr_bill_no:mr_bill_no,patient_name:patient_name,doctor_id:doctor_id,particulars:particulars,received_rs:received_rs},

					success:function(d){

						if(d.mr_added=='success'){

							alert('Receipt Successfully Saved!');
							window.open('<?php echo base_url();?>print_receipt/'+d.billno,'_blank','toolbar=yes,scrollbars=yes,resizable=yes,width=800,height=800');
							window.location.reload();

						}
						else if(d.mr_added=='rule_error'){
								$('.submit_btn').prop('disabled', false);
					            $('#chk_msg').html('<b style="color:maroon;"><i class="icofont-warning" style="color:red"></i> ERROR: '+d.errors+'</b>');
					            $("#chk_msg").focus();

							}
						else if(d.mr_edited=='success'){
							$('.submit_btn').prop('disabled', false);
							alert('Receipt updated!');
							window.location.reload();

						}else{
							alert('Something went wrong!');
						}
					}

				});


		});
</script>

</body>

</html>
