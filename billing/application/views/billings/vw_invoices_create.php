<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'common/assets/extra-libs/multicheck/multicheck.css';?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>common/assets/libs/select2/dist/css/select2.min.css">
	<link href="<?php echo base_url().'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css';?>" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title><?php echo comp_name; ?> | Receipt</title>
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
					<h4 class="page-title">Receipt</h4>
					<div class="ml-auto text-right">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Receipt</li>
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
                                <h5 class="card-title"><i class="icofont-document-folder"></i> Invoice Cum Money Receipt</h5><hr />
                                <h6 class="card-title textcen"><b>Bill No:</b> <?php echo $billno; ?></h6>
                            </div>

                       
                            <table class="table" border="1">
                              <thead style="text-align: center;">
                              	<tr>
                              		 <th scope="col" style="font-weight: bold;" colspan="2">Patient's Name</th>
                              		 <th scope="col" style="font-weight: bold;" colspan="1">Patient's Phone</th>
                                  	 <th scope="col" style="font-weight: bold;" colspan="1">Under</th>
                              	</tr>
                              	<tr>
                              		<th scope="col" style="font-weight: bold;" colspan="2">
                              			<input type="hidden" name="bill_no" id="bill_no" value="<?php echo $billno; ?>">
                              			<input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Patient's Name" required="">
                              		</th>

                              		<th scope="col" style="font-weight: bold;" colspan="1">
                              			<input type="text" class="form-control" id="patient_phone" name="patient_phone" placeholder="Patient's Phone" required="">
                              		</th>

                              		<th scope="col" style="font-weight: bold;" colspan="1">
                              			<!-- <input type="text" class="form-control" id="doctor_name" name="doctor_name" placeholder="Enter Under Dr." required=""> -->
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
                              		</th>

                              	</tr>
                                <tr>
                                  <th scope="col" style="font-weight: bold;">Sl.</th>
                                  <th scope="col" style="font-weight: bold;">Group</th>
                                  <th scope="col" style="font-weight: bold;">Item</th>
                                  <th scope="col" style="font-weight: bold;">Price</th>
                                </tr>
                              </thead>
                              <tbody>
                              	<?php
                              		for($i=1; $i<=14; $i++){

                              	?>

                                <tr style="text-align: center;">
                                	<td><?php echo $i; ?></td>
                                  <td>
                                  		<select class="select2 form-control custom-select" name="ddl_group_id<?php echo $i; ?>" id="ddl_group_id<?php echo $i; ?>" onchange="get_item_name(this.value,'<?php echo $i; ?>')" style="width: 100%; height:36px;" <?php if($i==1){ ?> required <?php } ?>>
                                            	<option value="0">Select</option>
                                                <?php
												if(!empty($group_data)){
													//print_obj($group_data);die;
													foreach($group_data as $key => $val){
												?>
													<option value="<?php echo $val['group_id']; ?>"><?php echo $val['group_name']; ?></option>
												<?php
													}
												}
												?>
                                     	</select>
                                    </td>
                                  <td>
                                  		<select class="select2 form-control custom-select" name="ddl_item_id<?php echo $i; ?>" id="ddl_item_id<?php echo $i; ?>" onchange="get_item_rate(this.value,'<?php echo $i; ?>')" style="width: 100%; height:36px;">
                                            	<option value="0">Select</option>
                                     	</select>
                                    </td>
                                  <td style="width: 30%;"><input type="text" class="form-control" id="txt_price<?php echo $i; ?>" name="txt_price<?php echo $i; ?>" value="0" required="" onchange="cal_total_price()"  style="width: 100%;"></td>
                                </tr>
                                <?php
                            	}
                                ?>

                                <tr style="text-align: center;">
                                	<td colspan="2"></td><td >Discount: </td>
                                	<td colspan="4"><input type="number" class="form-control" id="discount" onchange="cal_total_price()" value="0"></td>
                                </tr>

                                <tr style="text-align: center;">
									<td colspan="2"></td>
									<td><button type="button" id="get_tot_pr" class="btn btn-primary" onclick="cal_total_price()"><i class="icofont-rupee"></i>Gross Total</button></td>
                                	<td colspan="4"><input type="number" class="form-control" id="set_tot_pr" value="0.00" disabled=""></td>
								</tr>
								
								<tr style="text-align: center;">
									<td colspan="2"><input type="text" class="form-control" id="mrno" name="mrno" placeholder="MR Number.." required=""></td>
									<td>Advance: </td>
                                	<td colspan="4"><input type="number" class="form-control" id="advance" onchange="cal_net_price()" value="0"></td>
                                </tr>

								<tr style="text-align: center;">
                                	<td colspan="3"><button type="button" id="get_tot_net" class="btn btn-primary" onclick="cal_net_price()"><i class="icofont-rupee"></i>Net Total</button></td>
                                	<td colspan="4"><input type="number" class="form-control" id="set_tot_net" value="0.00" disabled=""></td>
                                </tr>

                              </tbody>
                            </table>

							<div class="border-top">
                            	<div class="card-body">
                                	<button type="button" id="submit" class="btn btn-success submit_btn">Submit</button>
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
<script src="<?php echo base_url().'common/assets/extra-libs/multicheck/datatable-checkbox-init.js';?>"></script>
<script src="<?php echo base_url().'common/assets/extra-libs/multicheck/jquery.multicheck.js';?>"></script>
<script src="<?php echo base_url().'common/assets/extra-libs/DataTables/datatables.min.js';?>"></script>


 <script src="<?php echo base_url();?>common/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url();?>common/assets/libs/select2/dist/js/select2.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url();?>common/dist/js/form_data.js"></script> -->
<script>
	/****************************************
	 
	 ****************************************/
	$(document).ready(function(){

		$(".select2").select2();

	

		$("#submit").click(function(){

			$('.submit_btn').prop('disabled', true);
			$('#chk_msg').show();
			$('#chk_msg').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');

			var patient_name = $('#patient_name').val();
			var patient_phone = $('#patient_phone').val();
			var doctor_id = $('#doctor_id').val();
			var bill_no = $('#bill_no').val();
			var mrno = $('#mrno').val();
			var discount = parseFloat($('#discount').val());
			var advance = parseFloat($('#advance').val());
			var group_id = '';
			var item_id = '';
        	var price = '';
        	

        	for(var i=1;i<=14;i++)

	        {

	            group_id += $('#ddl_group_id'+i).val() + ",";
	            item_id += $('#ddl_item_id'+i).val() + ",";
	            price += $('#txt_price'+i).val() + ",";

	        }

					$.ajax({

						type:'POST',

						url:'<?php echo base_url();?>save_invoice',

						data:{patient_name:patient_name,patient_phone:patient_phone,doctor_id:doctor_id,bill_no:bill_no,mrno:mrno,discount:discount,advance:advance,group_id:group_id,item_id:item_id,price:price},

						success:function(d){

							if(d.inv_added=='success'){
								alert('Bill Successfully Saved!');
								//alert(d.sms_status);
								window.open('<?php echo base_url();?>print_invoice/'+d.billno,'_blank','toolbar=yes,scrollbars=yes,resizable=yes,width=800,height=800');
								window.location.reload();

							}
							else if(d.inv_added=='rule_error'){
								$('.submit_btn').prop('disabled', false);
								//alert(d.errors);
					            $('#chk_msg').html('<b style="color:maroon;"><i class="icofont-warning" style="color:red"></i> ERROR: '+d.errors+'</b>');
					            $("#chk_msg").focus();

							}
							else if(d.inv_added=='failure'){
								$('.submit_btn').prop('disabled', false);
								alert('Bill not saved. Enter at least 1 row!');
							}else{
								alert('Something went wrong!');
							}

						}

					});


			});

		

	});

	function get_item_name(group_id,icount)

    {

        var mode="get_item_name_by_group";

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'get_dropdowns'; ?>",
            data: {"mode":mode,"group_id":group_id},
            
            success: function(d){ 
            	var html = '<option value="0">Select</option>';
	            	myArray = d.itemdata;
	            	for (var j = 0; j < myArray.length; j++){
	            		html += '<option value="'+myArray[j]['item_id']+'">'+myArray[j]['item_name']+'</option>';
					  	
					}
					//console.log(html);
				$('#ddl_item_id'+icount).html(html);
                
             }
            });

    }

    function get_item_rate(item_id,icount)

    {

        var mode="get_item_rate_by_name";

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'get_dropdowns'; ?>",
            data: {"mode":mode,"item_id":item_id},
            
            success: function(d){ 
					//alert(d.rate);
				$('#txt_price'+icount).val(d.rate);
                
             }
            });

    }

    function cal_total_price(){
            var i;
            var tot_pr=0.00;
            var tot_sum=0.00;
            var discount = parseFloat($('#discount').val());

            for(i=1;i<=14;i++) {
                tot_sum += (parseFloat($('#txt_price'+i).val()));
            }
            var tot_pr = tot_sum - discount;
             $('#set_tot_pr').val(tot_pr.toFixed(2));
            //alert(tot_pr);
    }

	function cal_net_price(){

            var net=0.00;
            var gross = parseFloat($('#set_tot_pr').val());
			var advance = parseFloat($('#advance').val());

            var net = gross - advance;
             $('#set_tot_net').val(net.toFixed(2));
            //alert(tot_pr);
    }

</script>

</body>

</html>