<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

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
			$this->load->view('groups/vw_groups', $this->data, false);
		

		}
		else{
			redirect(base_url());
		}
	}

	public function onCreateGroupView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2)){

			if(!empty(xss_clean($this->uri->segment(2)))){

				$group_id = xss_clean($this->uri->segment(2));
				$groupdata = $this->im->getGroupData($p=array('group_id'=>$group_id),$many=FALSE);
				if($groupdata){
						$this->data['group_data'] = array(
							'group_id'  => $groupdata->group_id,
							'group_name'  => $groupdata->group_name,
							'created_dtime'  => $groupdata->created_dtime
						);
				}
				else{
					$this->data['group_data']= '';
				}
				$this->load->view('groups/vw_create_group', $this->data, false);
			}
			else{
				$this->load->view('groups/vw_create_group');
			}
			

			//print_obj($this->data['cate_data']);die;
			


		}

	}

	public function onCheckDuplicateGroup()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$group_name = xss_clean($this->input->post('group_name'));

				$group_exists = $this->im->getGroupData($p=array('group_name'=>$group_name),$many=FALSE);
				if($group_exists){
						$return['group_exists'] = 1;
				}
				else{
					$return['group_exists'] = 0;
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

	public function onCreateGroup()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

					$group_name = xss_clean($this->input->post('group_name'));
					$group_id = xss_clean($this->input->post('group_id'));

					$chkdata = array('group_name'  => $group_name);
					$groupdata = $this->im->getGroupData($chkdata,$many=FALSE);

				
				if(empty($groupdata) && $group_id==0){
					 
					
					 $insdata = array(
								'group_name'  => $group_name,
								'created_dtime'  => dtime,
								'created_user'  => $this->session->userdata('userid')
							);

					$additem = $this->im->addGroup($insdata);

					if($additem){
						$return['group_added'] = 'success';
					}
					else{
						$return['group_added'] = 'failure';
					}
						
				}
				else{

					$updata = array(
								'group_name'  => $group_name,
								'edited_dtime'  => dtime,
								'edited_user'  => $this->session->userdata('userid')
							);
					$upditm = $this->im->updateGroup($updata,array('group_id'  => $group_id));
					if($upditm){
						$return['group_updated'] = 'success';
					}
					else{
						$return['group_updated'] = 'failure';
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

	public function onDeleteGroup()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
			{
			   if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$group_id = xss_clean($this->input->post('groupid'));
				$groupdata = $this->im->getGroupData(array('group_id'  => $group_id),$many=FALSE);

				if($groupdata){
					//del
					$delgroup = $this->im->delGroup(array('group_id' => $group_id));

					if($delgroup){
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