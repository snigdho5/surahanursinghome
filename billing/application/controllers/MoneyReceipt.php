<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MoneyReceipt extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index()
	{
		if (!empty($this->session->userdata('userid')) && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{

			//
		}
		else{
				redirect(base_url());
			}
	}
	
	public function onGetMReceiptView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{

			// if($this->session->userdata('usergroup')==1){
			// 	$MRdata = $this->mm->getMRList($p=null);
			// }
			// else{
			// 	$MRdata = $this->mm->getMRList($p=array('money_receipt.created_user'=>$this->session->userdata('userid')));	
			// }

			$MRdata = $this->mm->getMRList($p=null);

			if($MRdata){

				foreach ($MRdata as $key => $value) {
				      $user_name = $this->am->getUserData($p=array('user_id'=>$value->created_user),$many=FALSE);
				      
					$this->data['mr_data'][] = array(
						'mr_id' => $value->mr_id,
						'mr_bill_no' => $value->mr_bill_no,
						'patient_name' => $value->patient_name,
						'doctor_name' => $value->doctor_name,
						'doctor_id' => $value->doctor_id,
						'particulars' => $value->particulars,
						'received_rs' => $value->received_rs,
						'charges' => $value->charges,
						'created_user' => $user_name->full_name,
						'created_dtime' => $value->created_dtime
					);
				}
				if($this->session->userdata('usergroup')==1){
					$sum_price = $this->mm->getMRSum($p=array('date(money_receipt.created_dtime)'=>date2));
				}else{
					$sum_price = $this->mm->getMRSum($p=array('created_user'=>$this->session->userdata('userid'), 'date(money_receipt.created_dtime)'=>date2));
				}
				//print_obj($sum_price);die;
				if(!empty($sum_price)){
					$this->data['grand_tot'] = $sum_price->tot_price;
				}
				else{
					$this->data['grand_tot'] = 0;
				}
			//print_obj($this->data['mr_data']);die;
			}else{
				$this->data['mr_data']= '';
				$this->data['grand_tot'] = 0;
				
			}
			$this->load->view('mreceipts/vw_receipts', $this->data, false);
		}
		else{
				redirect(base_url());
			}
	}


	public function onCreateMReceiptView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{

			
			
			$mrdata = $this->mm->getMRBillNo();
			//print_obj($mrdata);die;

			if(empty($mrdata->mr_bill_no)){
				$lastNumber = 0;
			}else{
				$numbers = explode('/', $mrdata->mr_bill_no);
				$lastNumber = end($numbers);
			}
			
			$this->data['billno'] = 'SNH/2020-21/C/'.random_strings(3).'/'.($lastNumber+1);
			//echo $this->data['billno'];die;

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

				$this->load->view('mreceipts/vw_receipt_create', $this->data, false);
			

			
		}
		else{
				redirect(base_url());
			}
	}

	
	public function onCreateMReceipt()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

					$this->form_validation->set_rules('patient_name', 'Patient Name', 'trim|required|xss_clean|htmlentities');
					//$this->form_validation->set_rules('doctor_id', 'Under Doctor', 'trim|required|xss_clean|htmlentities');
					$this->form_validation->set_rules('mr_bill_no', 'Bill No', 'trim|required|xss_clean|htmlentities');
					$this->form_validation->set_rules('received_rs', 'Received Rs', 'trim|required|xss_clean|htmlentities');

					if ($this->form_validation->run() == FALSE)
					{
						$this->form_validation->set_error_delimiters('', '');
						$return['errors'] = validation_errors();
						$return['mr_added'] = 'rule_error';
					}
					else 
					{
						$patient_name = strip_tags($this->input->post('patient_name'));
						$doctor_id = xss_clean($this->input->post('doctor_id'));
						$particulars = xss_clean($this->input->post('particulars'));
						$mr_bill_no1 = strip_tags($this->input->post('mr_bill_no'));
						$received_rs = strip_tags($this->input->post('received_rs'));

						$check_billno = $this->mm->getMRData($p=array('mr_bill_no'=>$mr_bill_no1),$many=FALSE);

						if(!empty($check_billno)){
							$mrdata = $this->mm->getMRBillNo();
							//print_obj($mrdata);die;

							if(empty($mrdata->mr_bill_no)){
								$lastNumber = 0;
							}else{
								$numbers = explode('/', $mrdata->mr_bill_no);
								$lastNumber = end($numbers);
							}
							
							$mr_bill_no = 'SNH/2020-21/C/'.random_strings(3).'/'.($lastNumber+1);
						}
						else{
							$mr_bill_no = $mr_bill_no1;
						}

						$mod_bill_no = str_replace("/", "_", $mr_bill_no);

							$addData = array(
									'patient_name' => $patient_name,
									'doctor_id' => $doctor_id,
									'particulars' => $particulars,
									'mr_bill_no' => $mr_bill_no,
									'received_rs' => $received_rs,
									'created_dtime'  => dtime,
									'created_date'  => date2,
									'created_user'  => $this->session->userdata('userid')
								 );
								//print_obj($addData);
							$addedMR = $this->mm->addMR($addData);
							if($addedMR){
								$return['billno'] = $mod_bill_no;
								$return['mr_added'] = 'success';
							}
							else{
								$return['mr_added'] = 'failure';
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

	public function onPrintReceipt()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			$get_bill_no = xss_clean($this->uri->segment(2));
			$mr_bill_no  = str_replace("_", "/", $get_bill_no);

			$MRdata = $this->mm->getMRList($p=array('mr_bill_no'=>$mr_bill_no));
			if($MRdata){

				foreach ($MRdata as $key => $value) {
					$this->data['mr_data'][] = array(
						'mr_id' => $value->mr_id,
						'mr_bill_no' => $value->mr_bill_no,
						'patient_name' => $value->patient_name,
						'doctor_name' => $value->doctor_name,
						'doctor_id' => $value->doctor_id,
						'particulars' => $value->particulars,
						'received_rs' => $value->received_rs,
						'in_words' => convert_number($value->received_rs),
						'charges' => $value->charges,
						'created_dtime' => $value->created_dtime
					);
				}

				
				
			//print_obj($this->data['user_data']);die;
			}else{
				$this->data['mr_data']= '';
				
			}
			$this->load->view('mreceipts/vw_print_receipt', $this->data, false);
		}
		else{
				redirect(base_url());
			}
	}


	public function onReportMR()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
					$this->data['from_date'] = strip_tags($this->input->post('from_date'));
					$this->data['to_date'] = strip_tags($this->input->post('to_date'));

					if($this->session->userdata('usergroup')==1){
						$mrdata = $this->mm->getMRList($p=array('date(money_receipt.created_dtime) >='=>$this->data['from_date'],'date(money_receipt.created_dtime) <='=>$this->data['to_date']));
						//print_obj($Invdata);

						if($mrdata){
							
							foreach ($mrdata as $key => $value) {
								$user_name = $this->am->getUserData($p=array('user_id'=>$value->created_user),$many=FALSE);
								//print_obj($user_name);die;
							
								$this->data['mr_data'][] = array(
									'mr_id' => $value->mr_id,
									'mr_bill_no' => $value->mr_bill_no,
									'patient_name' => $value->patient_name,
									'doctor_name' => $value->doctor_name,
									'doctor_id' => $value->doctor_id,
									'particulars' => $value->particulars,
									'received_rs' => $value->received_rs,
									'charges' => $value->charges,
									'created_user' => $user_name->full_name,
									'created_dtime' => $value->created_dtime
								);
							}
							$sum_price = $this->mm->getMRSum($p=array('date(money_receipt.created_dtime) >='=>$this->data['from_date'],'date(money_receipt.created_dtime) <='=>$this->data['to_date']));
							//print_obj($sum_price);die;
							if(!empty($sum_price)){
								$this->data['grand_tot'] = $sum_price->tot_price;
							}
							else{
								$this->data['grand_tot'] = 0;
							}
							
						//print_obj($this->data);die;
						}else{
							$this->data['mr_data']= '';
							$this->data['grand_tot'] = 0;
							
						}
					}
					else
					{
						$mrdata = $this->mm->getMRList($p=array('date(money_receipt.created_dtime) >='=>$this->data['from_date'],'date(money_receipt.created_dtime) <='=>$this->data['to_date'],'money_receipt.created_user'=>$this->session->userdata('userid')));
						if($mrdata){
							

							foreach ($mrdata as $key => $value) {
								$user_name = $this->am->getUserData($p=array('user_id'=>$value->created_user),$many=FALSE);
								$this->data['created_user'] = $user_name->full_name;

								$this->data['mr_data'][] = array(
									'mr_id' => $value->mr_id,
									'mr_bill_no' => $value->mr_bill_no,
									'patient_name' => $value->patient_name,
									'doctor_name' => $value->doctor_name,
									'doctor_id' => $value->doctor_id,
									'particulars' => $value->particulars,
									'received_rs' => $value->received_rs,
									'charges' => $value->charges,
									'created_dtime' => $value->created_dtime
								);
							}
							$sum_price = $this->mm->getMRSum($p=array('date(money_receipt.created_dtime) >='=>$this->data['from_date'],'date(money_receipt.created_dtime) <='=>$this->data['to_date'],'created_user'=>$this->session->userdata('userid')));
							//print_obj($sum_price);die;
							if(!empty($sum_price)){
								$this->data['grand_tot'] = $sum_price->tot_price;
							}
							else{
								$this->data['grand_tot'] = 0;
							}
							
						///print_obj($this->data);die;
						}else{
							$this->data['mr_data']= '';
							$this->data['grand_tot'] = 0;
							
						}
					}
					$this->load->view('mreceipts/vw_print_mr_report', $this->data, false);
			
		}
		else{
				redirect(base_url());
			}
	}


	public function onDeleteMR()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
			{
			   if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$mr_id = xss_clean($this->input->post('mrid'));
				$billno = xss_clean($this->input->post('billno'));
				$mrData = $this->mm->getMRData(array('mr_id'  => $mr_id),$many=FALSE);

				if($mrData){
					//del
					$delMr = $this->mm->delMR(array('mr_id' => $mr_id));

					if($delMr){
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
		}
 	}
	




}