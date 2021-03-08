<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/extra-libs/multicheck/multicheck.css">
	<link href="<?php echo base_url();?>common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/libs/select2/dist/css/select2.min.css">
	<title><?php echo comp_name; ?> | Add Item</title>
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
					<h4 class="page-title">Add Item</h4>
					<div class="ml-auto text-right">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Item</li>
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
                                    <h4 class="card-title">Create New Item <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_url().'items'; ?>'">Item List</button></h4>

                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Group</label>
                                        <div class="col-sm-9">
                                        	<input type="hidden" id="itm_id" value="<?php echo (!empty($item_data) && $item_data['item_id']!='')?$item_data['item_id']:'0'; ?>">
                                           
                                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;" id="group_id" name="group_id">
												<option value="0">Select</option>
												
												<?php
												if(!empty($group_data)){
													//print_obj($group_data);die;
													foreach($group_data as $key => $val){
												?>
													<option value="<?php echo $val['group_id']; ?>" <?php echo (!empty($item_data) && $item_data['group_id']==$val['group_id'])?'selected':''; ?>><?php echo $val['group_name']; ?></option>
												<?php
													}
												}
												?>

                                     		</select>
                                        </div>
                                    </div>

                                      <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Item Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Item Name.." value="<?php echo (!empty($item_data) && $item_data['item_name']!='')?$item_data['item_name']:''; ?>" required="">
                                             <label id="chk_msg" style="display: none;"></label>
                                        </div>
                                    </div>

                                     <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Price</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="item_price" name="item_price" placeholder="Item Price.." value="<?php echo (!empty($item_data) && $item_data['item_price']!='')?$item_data['item_price']:''; ?>" required="">
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

	$("#item_name").keyup(function(){

    var item_name = $('#item_name').val();
    if(item_name!=''){
	   $.ajax({
	    type: "POST",
	    url: "<?php echo base_url().'duplicate_check_item'; ?>",
	    data: {itemname:item_name},
	    
	    success: function(d){
	        if(d.item_exists == 1)
	        {
	            $('#chk_msg').show();
	            $('#chk_msg').html('<i class="icofont-close-squared-alt"></i> Item already exists..!!');
	            $("#chk_msg").css("color", "red");
	            $('#submit').attr("disabled", true);
	            return false;
	        }else {
	            $('#chk_msg').show();
	            $('#chk_msg').html('<i class="icofont-tick-boxed"></i> Item available.');
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

		var item_name = $('#item_name').val();
		var item_id = $('#itm_id').val();
		var group_id = $('#group_id').val();
		var item_price = $('#item_price').val();

				$.ajax({

					type:'POST',

					url:'<?php echo base_url();?>createitem',

					data:{item_name:item_name,item_id:item_id,group_id:group_id,item_price:item_price},

					success:function(d){

						if(d.item_added=='success'){

							alert('Item added!');
							window.location.reload();

						}
						else if(d.item_added=='failure'){

							alert('Something went wrong!');

						}else if(d.item_updated=='success'){

							alert('Item updated!');
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
