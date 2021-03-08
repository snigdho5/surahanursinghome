<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

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

			$itemdata = $this->im->getItemData($p=null,$many=TRUE);
			if($itemdata){
				foreach ($itemdata as $key => $value) {
					$groupdata = $this->im->getGroupData($p=array('group_id'=>$value->group_id),$many=FALSE);
					if(!empty($groupdata)){
						$group_name = $groupdata->group_name;
					}else{
						$group_name = 'N/A';
					}
					
					$this->data['item_data'][] = array(
						'item_id'  => $value->item_id,
						'group_id'  => $value->group_id,
						'group_name'  => $group_name,
						'item_name'  => $value->item_name,
						'item_price'  => $value->item_price,
						'created_dtime'  => $value->created_dtime
					);
				}
			}
			else{
				$this->data['item_data'] = '';
			}
			$this->load->view('items/vw_items', $this->data, false);
		

		}
		else{
			redirect(base_url());
		}
	}

	public function onCreateItemView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2)){

			if(!empty(xss_clean($this->uri->segment(2)))){

				$item_id = xss_clean($this->uri->segment(2));
				$itemdata = $this->im->getItemData($p=array('item_id'=>$item_id),$many=FALSE);
				if($itemdata){
						$this->data['item_data'] = array(
							'item_id'  => $itemdata->item_id,
							'group_id'  => $itemdata->group_id,
							'item_name'  => $itemdata->item_name,
							'item_price'  => $itemdata->item_price,
							'created_dtime'  => $itemdata->created_dtime
						);
				}
				else{
					$this->data['item_data']= '';
				}

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
				$this->load->view('items/vw_create_item', $this->data, false);
			}
			else{
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

				$this->load->view('items/vw_create_item', $this->data, false);
			}
			

			//print_obj($this->data['cate_data']);die;
			


		}

	}

	public function onCheckDuplicateItem()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$item_name = xss_clean($this->input->post('itemname'));

				$item_exists = $this->im->getItemData($p=array('item_name'=>$item_name),$many=FALSE);
				if($item_exists){
						$return['item_exists'] = 1;
				}
				else{
					$return['item_exists'] = 0;
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

	public function onCreateItem()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
		{
			if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

					$item_name = xss_clean($this->input->post('item_name'));
					$item_id = xss_clean($this->input->post('item_id'));
					$group_id = xss_clean($this->input->post('group_id'));
					$item_price = xss_clean($this->input->post('item_price'));

					$chkdata = array('item_name'  => $item_name);
					$itmdata = $this->im->getItemData($chkdata,$many=FALSE);

				
				if(empty($itmdata) && $item_id==0){
					 
					
					 $insdata = array(
								'item_name'  => $item_name,
								'group_id'  => $group_id,
								'item_price'  => $item_price,
								'created_dtime'  => dtime,
								'created_user'  => $this->session->userdata('userid')
							);

					$additem = $this->im->addItem($insdata);

					if($additem){
						$return['item_added'] = 'success';
					}
					else{
						$return['item_added'] = 'failure';
					}
						
				}
				else{

					$updata = array(
								'item_name'  => $item_name,
								'group_id'  => $group_id,
								'item_price'  => $item_price,
								'edited_dtime'  => dtime,
								'edited_user'  => $this->session->userdata('userid')
							);
					$upditm = $this->im->updateItem($updata,array('item_id'  => $item_id));
					if($upditm){
						$return['item_updated'] = 'success';
					}
					else{
						$return['item_updated'] = 'failure';
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

	public function onDeleteItem()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in')==1 && ($this->session->userdata('usergroup')==1  || $this->session->userdata('usergroup')==2))
			{
			   if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST'){

				$item_id = xss_clean($this->input->post('item_id'));
				$itemdata = $this->im->getItemData(array('item_id'  => $item_id),$many=FALSE);

				if($itemdata){
					//del
					$delitem = $this->im->delItem(array('item_id' => $item_id));

					if($delitem){
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