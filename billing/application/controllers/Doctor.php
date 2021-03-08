<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}


	public function index()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{

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
			$this->load->view('doctors/vw_doctors', $this->data, false);
		

		}
		else{
			redirect(base_url());
		}
	}

	public function onCreateDoctorView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2)){

			if(!empty(xss_clean($this->uri->segment(2)))){

				$doctor_id = xss_clean($this->uri->segment(2));
				$docdata = $this->im->getDoctorData($p=array('doctor_id'=>$doctor_id),$many=FALSE);
				if($docdata){
						$this->data['doctor_data'] = array(
							'doctor_id'  => $docdata->doctor_id,
							'doctor_name'  => $docdata->doctor_name,
							'created_dtime'  => $docdata->created_dtime
						);
				}
				else{
					$this->data['doctor_data']= '';
				}
				$this->load->view('doctors/vw_create_doctor', $this->data, false);
			}
			else{
				$this->load->view('doctors/vw_create_doctor');
			}
			

			//print_obj($this->data['cate_data']);die;
			


		}

	}

	public function onCheckDuplicateDoctor()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$doctor_name = xss_clean($this->input->post('docname'));

				$doc_exists = $this->im->getDoctorData($p=array('doctor_name'=>$doctor_name),$many=FALSE);
				if($doc_exists){
						$return['doc_exists'] = 1;
				}
				else{
					$return['doc_exists'] = 0;
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

	public function onCreateDoctor()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

					$doctor_name = xss_clean($this->input->post('docname'));
					$doctor_id = xss_clean($this->input->post('docid'));

					$chkdata = array('doctor_name'  => $doctor_name);
					$docdata = $this->im->getDoctorData($chkdata,$many=FALSE);

				
				if(empty($docdata) && $doctor_id==0){
					 
					
					 $insdata = array(
								'doctor_name'  => $doctor_name,
								'created_dtime'  => dtime,
								'created_user'  => $this->session->userdata('userid')
							);

					$adddoc = $this->im->addDoctor($insdata);

					if($adddoc){
						$return['doc_added'] = 'success';
					}
					else{
						$return['doc_added'] = 'failure';
					}
						
				}
				else{

					$updata = array(
								'doctor_name'  => $doctor_name,
								'edited_dtime'  => dtime,
								'edited_user'  => $this->session->userdata('userid')
							);
					$upddoc = $this->im->updateDoctor($updata,array('doctor_id'  => $doctor_id));
					if($upddoc){
						$return['doc_updated'] = 'success';
					}
					else{
						$return['doc_updated'] = 'failure';
					}
					
				}

			header('Content-Type: application/json');
			echo json_encode($return);	

			}else{
				redirect(base_url());
			}
		}
	else{
			redirect(base_url());
		}
 }

	public function onDeleteDoctor()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
			{
			   if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$doctor_id = xss_clean($this->input->post('docid'));
				$docdata = $this->im->getDoctorData(array('doctor_id'  => $doctor_id),$many=FALSE);

				if($docdata){
					//del
					$deldoc = $this->im->delDoctor(array('doctor_id' => $doctor_id));

					if($deldoc){
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