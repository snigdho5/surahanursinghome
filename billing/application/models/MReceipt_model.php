<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class MReceipt_model extends MY_Model {


	function __construct(){
		//
	}

	public function addMR($data){
		$this->table='money_receipt';
		return $this->store($data);
	}

	public function getMRData($param=null,$many=FALSE){
		$this->table='money_receipt';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='mr_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='mr_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}


	public function getMRList($param=null,$group_by=null){

		$this->db->select('money_receipt.*,mt_doctors.doctor_name AS doctor_name');

		$this->db->join('mt_doctors','mt_doctors.doctor_id=money_receipt.doctor_id','left');

		if($param!=null){
			$this->db->where($param);
		}

		if($group_by!=null){
			$this->db->group_by("money_receipt.".$group_by);
		}

		$this->db->order_by("money_receipt.mr_id", "DESC");

		$query = $this->db->get('money_receipt');
		//echo $this->db->last_query();die;
		return $query->result();

	}

	public function getMRBillNo($param=null){

		$this->db->select('mr_bill_no');
		$this->db->from('money_receipt');
		$this->db->order_by('mr_id', 'DESC');
		$this->db->limit('1');

		$query = $this->db->get();
		return $query->row();
	}

	public function getMRSum($param=null){

		if($param!=null){
			$this->db->select('SUM(received_rs) as tot_price');
			return $this->db->get_where('money_receipt',$param)->first_row();
		}

	}


	public function updateMR($data,$param){
		$this->table='money_receipt';
		return $this->modify($data,$param);
	}

	public function delMR($param){
		$this->table='money_receipt';
		return $this->remove($param);
	}

	
}