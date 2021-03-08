<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && $this->session->userdata('usergroup')==1)
		{

			//
		}
		else{
				redirect(base_url());
			}
	}
	
	public function onGetInvoiceView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 &&  ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			// if($this->session->userdata('usergroup')==1){
			// 	$Invdata = $this->bm->getInvList($p=null,$group_by='bill_no');
			// }
			// else{
			// 	$Invdata = $this->bm->getInvList($p=array('invoice_cum_mr.created_user'=>$this->session->userdata('userid')),$group_by='bill_no');
			// }
			
			$Invdata = $this->bm->getInvList($p=null,$group_by='bill_no');

			
			if($Invdata){

				foreach ($Invdata as $key => $value) {
				    $user_name = $this->am->getUserData($p=array('user_id'=>$value->created_user),$many=FALSE);
					 //print_obj($user_name);die;
					 
					 $bill_amt = $this->bm->getInvDiscountData($p=array('bill_no'=>$value->bill_no),$many=FALSE);
				    
					$this->data['inv_data'][] = array(
						'inv_id' => $value->inv_id,
						'patient_name' => $value->patient_name,
						'patient_phone' => $value->patient_phone,
						'doctor_name' => $value->doctor_name,
						'bill_no' => $value->bill_no,
						'mr_billno' => $value->mr_billno,
						'bill_amt' => $bill_amt->net_amt,
						'group_id' => $value->group_id,
						'item_id' => $value->item_id,
						'price' => $value->price,
						'created_user' => $user_name->full_name,
						'created_dtime' => $value->created_dtime
					);
				}
				if($this->session->userdata('usergroup')==1){
					$billedAmt = $this->bm->getInvSum($p=array('date(dtime)'=>date2),$many=FALSE);
				}else{
					$billedAmt = $this->bm->getInvSum($p=array('created_user'=>$this->session->userdata('userid'), 'date(dtime)'=>date2),$many=FALSE);
				}
				
				if(!empty($billedAmt)){
					$this->data['billed_today'] = $billedAmt->tot_price;
				}
				else{
					$this->data['billed_today'] = 0;
				}

					// Authorisation details.	
					$username = "dev@surahanursinghome.com";
					$hash = "9ecb82000c9bb875d32f495754b7b8158dde3205e9e9890bf424255c26c0beae";
					
					// You shouldn't need to change anything here.	
					$data = "username=".$username."&hash=".$hash;
					$ch = curl_init('http://api.textlocal.in/balance/?');
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$credits_json = curl_exec($ch);
					// This is the number of credits you have left	
					curl_close($ch);
					$sms_credits = json_decode($credits_json);	
					//print_obj($sms_credits);die;

					$this->data['sms_credits'] = $sms_credits->balance->sms;
				
			//print_obj($this->data['inv_data']);die;
			}else{
				$this->data['inv_data']= '';
				$this->data['grand_tot'] = 0;
				
			}
			$this->load->view('billings/vw_invoices', $this->data, false);
		}
		else{
				redirect(base_url());
			}
	}


	public function onCreateInvoiceView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{

			$invdata = $this->bm->getInvBillNo();
			//print_obj($invdata);die;

			if(empty($invdata->bill_no)){
				$lastNumber = 0;
			}else{
				$numbers = explode('/', $invdata->bill_no);
				$lastNumber = end($numbers);
			}
			
			$this->data['billno'] = 'SUR/2020-21/C/'.random_strings(3).'/'.($lastNumber+1);
			//echo $this->data['billno'];die;

			$groupdata = $this->im->getGroupData($p=null,$many=TRUE);
			if($groupdata){
				foreach ($groupdata as $key => $value) {
					$this->data['group_data'][] = array(
						'group_id'  => $value->group_id,
						'group_name'  => $value->group_name,
						'created_dtime'  => $value->created_dtime
					);
				}
			}
			else{
				$this->data['group_data'] = '';
			}

			$docdata = $this->im->getDoctorData($p=null,$many=TRUE);
				if($docdata){
					foreach ($docdata as $key => $value) {
						$this->data['doctor_data'][] = array(
						'doctor_id'  => $value->doctor_id,
						'doctor_name'  => $value->doctor_name,
						'created_dtime'  => $value->created_dtime
						);
					}
				}
				else{
						$this->data['doctor_data'] = '';
					}

			$this->load->view('billings/vw_invoices_create', $this->data, false);
			

			
		}
		else{
				redirect(base_url());
			}
	}

	public function onGetInvoiceDrops()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				
				$mode = xss_clean($this->input->post('mode'));

				if($mode=='get_item_name_by_group'){

					$group_id = xss_clean($this->input->post('group_id'));
					$item_data = $this->im->getItemData($p=array('group_id'=>$group_id),$many=TRUE);
					// print_obj($item_data);die;

					if($item_data){
						foreach ($item_data as $key => $value) {
							$return['itemdata'][] = array(
							'item_id'  => $value->item_id,
							'item_name'  => $value->item_name
							);
						}
					}
					else{
						$return['itemdata'] = '';
					}
				}

				elseif($mode=='get_item_rate_by_name'){

					$item_id = xss_clean($this->input->post('item_id'));
					$item_data = $this->im->getItemData($p=array('item_id'=>$item_id),$many=FALSE);
					// print_obj($item_data);die;

					if($item_data){
							$return['rate'] = $item_data->item_price;
					}
					else{
						$return['rate'] = '';
					}
				}
				
					
				header('Content-Type: application/json');

				echo json_encode($return);	
			}
			else{
				//exit('No direct script access allowed');
				redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
	}

	public function onSetInvoice()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

					$this->form_validation->set_rules('patient_name', 'Patient Name', 'trim|required|xss_clean|htmlentities');
					$this->form_validation->set_rules('patient_phone', 'Phone', 'trim|required|regex_match[/^[0-9]{10}$/]|xss_clean|htmlentities');
					$this->form_validation->set_rules('doctor_id', 'Under Doctor', 'trim|required|xss_clean|htmlentities');
					$this->form_validation->set_rules('bill_no', 'Bill No', 'trim|required|xss_clean|htmlentities');
					$this->form_validation->set_rules('group_id', 'Group', 'trim|required|xss_clean|htmlentities');

					if ($this->form_validation->run() == FALSE)
					{
						$this->form_validation->set_error_delimiters('', '');
						$return['errors'] = validation_errors();
						$return['inv_added'] = 'rule_error';
					}
					else 
					{

						$patient_name = strip_tags($this->input->post('patient_name'));
						$patient_phone = strip_tags($this->input->post('patient_phone'));
						$doctor_id = strip_tags($this->input->post('doctor_id'));
						$bill_no_inp = strip_tags($this->input->post('bill_no'));
						$mrno = strip_tags($this->input->post('mrno'));
						$discount = xss_clean($this->input->post('discount'));
						$advance = xss_clean($this->input->post('advance'));
						$str_group_id = xss_clean($this->input->post('group_id'));
						$str_item_id = xss_clean($this->input->post('item_id'));
						$str_price = xss_clean($this->input->post('price'));

						
						$group_id = explode(',',$str_group_id);
						$item_id = explode(',',$str_item_id);
						$price = explode(',',$str_price);

						$check_billno = $this->bm->getInvData($p=array('bill_no'=>$bill_no_inp),$many=FALSE);

						if(!empty($check_billno)){
							$invdata = $this->bm->getInvBillNo();
							//print_obj($invdata);die;

							if(empty($invdata->bill_no)){
								$lastNumber = 0;
							}else{
								$numbers = explode('/', $invdata->bill_no);
								$lastNumber = end($numbers);
							}
							$bill_no =  'SUR/2020-21/C/'.random_strings(3).'/'.($lastNumber+1);
						}
						else{
							$bill_no = $bill_no_inp;
						}
						
						$mod_bill_no = str_replace("/", "_", $bill_no);

						
					
						for ($i=0; $i <=14 ; $i++) { 
							if($group_id[$i]!=0 && $group_id[$i]!='' && $item_id[$i]!=0 && $item_id[$i]!='' && $price[$i]!=0 && $price[$i]!='' && $price[$i]!='NaN'){

								$addData = array(
									'patient_name' => $patient_name,
									'patient_phone' => $patient_phone,
									'doctor_id' => $doctor_id,
									'bill_no' => $bill_no,
									'mr_billno' => $mrno,
									'group_id' => $group_id[$i],
									'item_id' => $item_id[$i],
									'price' => $price[$i],
									'created_dtime'  => dtime,
									'created_date'  => date2,
									'created_user'  => $this->session->userdata('userid')
								 );
								//print_obj($addData);
								$invAdded = $this->bm->addInvoice($addData);

								
							}
						}
						
						//die;
						
						if(isset($invAdded)){
							//discount

							$bill_amt = $this->bm->getInvSum1($p=array('bill_no'=>$bill_no));

							if($discount!=0 && $discount!='' && $discount!='NaN'){
								$gross_amt = $bill_amt->tot_price - $discount;
							}else{
								$gross_amt = $bill_amt->tot_price;
							}

							if($advance!=0 && $advance!='' && $advance!='NaN'){
								$net_amt = $gross_amt - $advance;
							}else{
								$net_amt = $gross_amt;
							}

							
							$addOthData = array(
										'bill_no' => $bill_no,
										'discount' => $discount,
										'advance' => $advance,
										'gross_amt' => $gross_amt,
										'net_amt' => $net_amt,
										'created_user' => $this->session->userdata('userid'),
										'dtime'  => dtime
								);
								//print_obj($addOthData);die;
							$invAdv = $this->bm->addInvoiceDiscount($addOthData);

							if($invAdv){
								$return['billno'] = $mod_bill_no;
								$return['inv_added'] = 'success';
								}
							else{
								$return['inv_added'] = 'failure';
								}
								

							//sms starts
								$sms = 1;//sms switch

								if($sms==1){
								//testlocal	
								// Authorisation details.
								$username = "dev@surahanursinghome.com";
								$hash = "9ecb82000c9bb875d32f495754b7b8158dde3205e9e9890bf424255c26c0beae";

								// Config variables. Consult http://api.textlocal.in/docs for more info.
								$test = "0";

								// Data for text message. This is the text message data.
								$sender = "TXTLCL"; // This is who the message appears to be from.
								$numbers = "91".$patient_phone; // A single number or a comma-seperated list of numbers
								$message = 'Dear '.$patient_name.', Rs. '.$net_amt.'/- has been received from you. Bill #: '.$bill_no.'. Thank you. Suraha Nursing Home Pvt. Ltd.';
								//echo $message;die;
								// 612 chars or less
								$message = urlencode($message);
								$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
								$ch = curl_init('http://api.textlocal.in/send/?');
								curl_setopt($ch, CURLOPT_POST, true);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$result = curl_exec($ch); // This is the result from the API
								curl_close($ch);
								$return['sms_status'] = $result;
								}




								elseif($sms==2){
									//textguru
									$username = "surahanursinghome";
									$password = "92689059";
									$senderid = "CHCKSMS";
									$phone = $patient_phone;
									$message = 'Dear '.$patient_name.', Rs. '.$bill_amt->tot_price.'/- has been received from you. Bill #: '.$bill_no.'. Thank you. Suraha Nursing Home Pvt. Ltd.';

									$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
									curl_setopt($ch, CURLOPT_POST, 1);

									//curl_setopt($ch, CURLOPT_POSTFIELDS, "username=surahanursinghome&password=92689059&source=CHCKSMS&dmobile=8617587115&message=This is a test message.");

									curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&source=$senderid&dmobile=$phone&message=$message");

									curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
									$data = curl_exec($ch);
									$return['sms_status'] = $data;
								}
								//sms ends
								
								
							}
						else{
								$return['inv_added'] = 'failure';
							}		
						
					
				}

				header('Content-Type: application/json');

				echo json_encode($return);	
			}	
			else{
				//exit('No direct script access allowed');
				redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
	}

	public function onPrintInvoice()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			$g_bill_no = xss_clean($this->uri->segment(2));
			$bill_no  = str_replace("_", "/", $g_bill_no);
			//echo $billno;die;

			$Invdata = $this->bm->getInvList($p=array('bill_no'=>$bill_no));
			if($Invdata){

				foreach ($Invdata as $key => $value) {
					$groupdata = $this->im->getGroupData($p=array('group_id'=>$value->group_id),$many=FALSE);
					if(!empty($groupdata)){
						$group_name = $groupdata->group_name;
					}else{
						$group_name = 'N/A';
					}

					$this->data['inv_data'][] = array(
						'inv_id' => $value->inv_id,
						'patient_name' => $value->patient_name,
						'patient_phone' => $value->patient_phone,
						'doctor_name' => $value->doctor_name,
						'bill_no' => $value->bill_no,
						'mr_billno' => $value->mr_billno,
						'group_id' => $value->group_id,
						'group_name'  => $group_name,
						'item_id' => $value->item_id,
						'item_name' => $value->item_name,
						'price' => $value->price,
						'created_dtime' => $value->created_dtime
					);
				}

			// $sum_price = $this->bm->getInvSum($p=array('bill_no'=>$bill_no));
			// //print_obj($sum_price);die;
			// if(!empty($sum_price)){
			// 	$this->data['grand_tot'] = $sum_price->tot_price;
			// }
			// else{
			// 	$this->sdata['grand_tot'] = 0;
			// }

			$discountData = $this->bm->getInvDiscountData($p=array('bill_no'=>$bill_no),$many=FALSE);
			if(!empty($discountData)){
				$this->data['dis_data'] = array(
					'discount' => $discountData->discount,
					'advance' => $discountData->advance,
					'gross_amt' => $discountData->gross_amt,
					'net_amt' => $discountData->net_amt,
					'net_in_words' => convert_number($discountData->net_amt)
				);
			}
			else{
				$this->data['dis_data'] = 0;
			}
			
				
			//print_obj($this->data['user_data']);die;
			}else{
				$this->data['inv_data']= '';
				$this->data['dis_data']= '';
				
			}
			$this->load->view('billings/vw_print_invoice', $this->data, false);
		}
		else{
				redirect(base_url());
			}
	}


	public function onReportInvoice()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
					$this->data['from_date'] = strip_tags($this->input->post('from_date'));
					$this->data['to_date'] = strip_tags($this->input->post('to_date'));

					if($this->session->userdata('usergroup')==1){
						$Invdata = $this->bm->getInvList($p=array('date(invoice_cum_mr.created_dtime) >='=>$this->data['from_date'],'date(invoice_cum_mr.created_dtime) <='=>$this->data['to_date']),$group_by='bill_no');
						//print_obj($Invdata);

						if($Invdata){
							
							foreach ($Invdata as $key => $value) {
								$user_name = $this->am->getUserData($p=array('user_id'=>$value->created_user),$many=FALSE);
								//print_obj($user_name);die;
								
								$bill_amt = $this->bm->getInvDiscountData($p=array('bill_no'=>$value->bill_no),$many=FALSE);
								
								$this->data['inv_data'][] = array(
									'inv_id' => $value->inv_id,
									'patient_name' => $value->patient_name,
									'patient_phone' => $value->patient_phone,
									'doctor_name' => $value->doctor_name,
									'bill_no' => $value->bill_no,
									'discount' => $bill_amt->discount,
									'advance' => $bill_amt->advance,
									'gross_amt' => $bill_amt->gross_amt,
									'net_amt' => $bill_amt->net_amt,
									'created_user' => $user_name->full_name,
									'created_dtime' => $value->created_dtime
								);
							}
							$sum_price = $this->bm->getInvSum($p=array('date(dtime) >='=>$this->data['from_date'],'date(dtime) <='=>$this->data['to_date']));
							//print_obj($sum_price);die;
							if(!empty($sum_price)){
								$this->data['grand_tot'] = $sum_price->tot_price;//net total
							}
							else{
								$this->data['grand_tot'] = 0;
							}
							
						//print_obj($this->data);die;
						}else{
							$this->data['inv_data']= '';
							$this->data['grand_tot'] = 0;
							
						}
					}
					else
					{
						$Invdata = $this->bm->getInvList($p=array('date(invoice_cum_mr.created_dtime) >='=>$this->data['from_date'],'date(invoice_cum_mr.created_dtime) <='=>$this->data['to_date'],'invoice_cum_mr.created_user'=>$this->session->userdata('userid')),$group_by='bill_no');
						if($Invdata){
							

							foreach ($Invdata as $key => $value) {
								$user_name = $this->am->getUserData($p=array('user_id'=>$value->created_user),$many=FALSE);
								$this->data['created_user'] = $user_name->full_name;

								$bill_amt = $this->bm->getInvDiscountData($p=array('bill_no'=>$value->bill_no),$many=FALSE);
								
								$this->data['inv_data'][] = array(
									'inv_id' => $value->inv_id,
									'patient_name' => $value->patient_name,
									'patient_phone' => $value->patient_phone,
									'doctor_name' => $value->doctor_name,
									'bill_no' => $value->bill_no,
									'discount' => $bill_amt->discount,
									'advance' => $bill_amt->advance,
									'gross_amt' => $bill_amt->gross_amt,
									'net_amt' => $bill_amt->net_amt,
									'created_dtime' => $value->created_dtime
								);
							}
							$sum_price = $this->bm->getInvSum($p=array('date(dtime) >='=>$this->data['from_date'],'date(dtime) <='=>$this->data['to_date'],'created_user'=>$this->session->userdata('userid')));
							//print_obj($sum_price);die;
							if(!empty($sum_price)){
								$this->data['grand_tot'] = $sum_price->tot_price;
							}
							else{
								$this->data['grand_tot'] = 0;
							}
							
						///print_obj($this->data);die;
						}else{
							$this->data['inv_data']= '';
							$this->data['grand_tot'] = 0;
							
						}
					}
					$this->load->view('billings/vw_print_report', $this->data, false);
			
		}
		else{
				redirect(base_url());
			}
	}

	public function onDeleteInvoice()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
			{
			   if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$invid = xss_clean($this->input->post('invid'));
				$billno = xss_clean($this->input->post('billno'));
				$invoiceData = $this->bm->getInvData(array('inv_id'  => $invid),$many=FALSE);

				if($invoiceData){
					//del
					$delinv = $this->bm->delInvoice(array('bill_no' => $billno));
					$delInvDis = $this->bm->delInvDisc(array('bill_no' => $billno));

					if($delinv && $delInvDis){
						$return['deleted'] = 'success';
					}
					else{
						$return['deleted'] = 'failure';
					}
						
				}
				else{
					$return['deleted'] = 'not_exists';
				}

			header('Content-Type: application/json');
			echo json_encode($return);	

			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
 	}
	




}