<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Bill_model extends MY_Model {


	function __construct(){
		//
	}

	public function addInvoice($data){
		$this->table='invoice_cum_mr';
		return $this->store($data);
	}

	public function getInvData($param=null,$many=FALSE){
		$this->table='invoice_cum_mr';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='inv_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='inv_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}


	public function getInvList($param=null,$group_by=null){

		$this->db->select('invoice_cum_mr.*,items.item_name AS item_name,mt_doctors.doctor_name AS doctor_name');

		$this->db->join('items','items.item_id=invoice_cum_mr.item_id','left');

		$this->db->join('mt_doctors','mt_doctors.doctor_id=invoice_cum_mr.doctor_id','left');

		if($param!=null){
			$this->db->where($param);
		}

		if($group_by!=null){
			$this->db->group_by("invoice_cum_mr.".$group_by);
		}

		$this->db->order_by("invoice_cum_mr.inv_id", "DESC");

		$query = $this->db->get('invoice_cum_mr');
		//echo $this->db->last_query();die;
		return $query->result();

	}

	public function getInvSum($param){

		if($param!=null){
			$this->db->select('SUM(net_amt) as tot_price');
			return $this->db->get_where('invoice_cum_mr_discount',$param)->first_row();
		}

	}

	public function getInvSum1($param){

		if($param!=null){
			$this->db->select('SUM(price) as tot_price');
			return $this->db->get_where('invoice_cum_mr',$param)->first_row();
		}

	}

	public function getInvBillNo($param=null){

		$this->db->select('bill_no');
		$this->db->from('invoice_cum_mr');
		$this->db->order_by('inv_id', 'DESC');
		$this->db->limit('1');

		$query = $this->db->get();
		return $query->row();
	}


	public function updateInvoice($data,$param){
		$this->table='invoice_cum_mr';
		return $this->modify($data,$param);
	}

	public function delInvoice($param){
		$this->table='invoice_cum_mr';
		return $this->remove($param);
	}

	//discount
	public function addInvoiceDiscount($data){
		$this->table='invoice_cum_mr_discount';
		return $this->store($data);
	}

	public function getInvDiscountData($param=null,$many=FALSE){

		$this->table='invoice_cum_mr_discount';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='inv_dis_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='inv_dis_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}

	public function delInvDisc($param){
		$this->table='invoice_cum_mr_discount';
		return $this->remove($param);
	}


}