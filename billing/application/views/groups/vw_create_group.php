<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/extra-libs/multicheck/multicheck.css">
	<link href="<?php echo base_url();?>common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/libs/select2/dist/css/select2.min.css">
	<title><?php echo comp_name; ?> | Add Group</title>
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
					<h4 class="page-title">Add Group</h4>
					<div class="ml-auto text-right">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Group</li>
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
                                <div class="card-body">
                                    <h4 class="card-title">Create New Group <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'groups'; ?>'">Group List</button></h4>

                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Group Name</label>
                                        <div class="col-sm-9">
											<input type="hidden" id="grp_id" value="<?php echo (!empty($group_data) && $group_data['group_id']!='')?$group_data['group_id']:'0'; ?>">

                                            <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name.." value="<?php echo (!empty($group_data) && $group_data['group_name']!='')?$group_data['group_name']:''; ?>" required="">
                                             <label id="chk_msg" style="display: none;"></label>
                                        </div>
                                    </div>


                                    
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="button" id="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
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

	$("#group_name").keyup(function(){

    var group_name = $('#group_name').val();
    if(group_name!=''){
	   $.ajax({
	    type: "POST",
	    url: "<?php echo base_url().'duplicate_check_group'; ?>",
	    data: {group_name:group_name},
	    
	    success: function(d){
	        if(d.group_exists == 1)
	        {
	            $('#chk_msg').show();
	            $('#chk_msg').html('<i class="icofont-close-squared-alt"></i> Group already exists..!!');
	            $("#chk_msg").css("color", "red");
	            $('#submit').attr("disabled", true);
	            return false;
	        }else {
	            $('#chk_msg').show();
	            $('#chk_msg').html('<i class="icofont-tick-boxed"></i> Group available.');
	            $("#chk_msg").css("color", "green");
	            $('#submit').attr("disabled", false);
	        }
	     }
	    });
    }else{
    	$('#chk_msg').hide();
    }
   
  });

	$("#submit").click(function(){

		var group_name = $('#group_name').val();
		var group_id = $('#grp_id').val();

				$.ajax({

					type:'POST',

					url:'<?php echo base_url();?>creategroup',

					data:{group_name:group_name,group_id:group_id},

					success:function(d){

						if(d.group_added=='success'){

							alert('Group added!');
							window.location.reload();

						}
						else if(d.group_added=='failure'){

							alert('Something went wrong!');

						}else if(d.group_updated=='success'){

							alert('Group updated!');
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
