<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Item_model extends MY_Model {


	function __construct(){
		//
	}
	
	//item
	public function addItem($data){
		$this->table='items';
		return $this->store($data);
	}
	
	public function getItemData($param=null,$many=FALSE){
		$this->table='items';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='item_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='item_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}

	public function updateItem($data,$param){
		$this->table='items';
		return $this->modify($data,$param);
	}

	public function delItem($param){
		$this->table='items';
		return $this->remove($param);
	}

	//doctor

	public function addDoctor($data){
		$this->table='mt_doctors';
		return $this->store($data);
	}

	public function getDoctorData($param=null,$many=FALSE){
		$this->table='mt_doctors';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='doctor_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='doctor_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}

	public function updateDoctor($data,$param){
		$this->table='mt_doctors';
		return $this->modify($data,$param);
	}

	public function delDoctor($param){
		$this->table='mt_doctors';
		return $this->remove($param);
	}

	//Group

	public function addGroup($data){
		$this->table='mt_groups';
		return $this->store($data);
	}

	public function getGroupData($param=null,$many=FALSE){
		$this->table='mt_groups';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='group_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='group_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}

	public function updateGroup($data,$param){
		$this->table='mt_groups';
		return $this->modify($data,$param);
	}

	public function delGroup($param){
		$this->table='mt_groups';
		return $this->remove($param);
	}

	// sms
	public function getSmsData($param=null,$many=FALSE){
		$this->table='sms_balance';
		if($param!=null && $many==FALSE){
			return $this->get_one($param);
		}
		elseif($param!=null && $many==TRUE){
			return $this->get_many($param,$order_by='sms_id',$order='DESC',FALSE);
		}
		elseif($param==null && $many==TRUE){
			return $this->get_many($param=null,$order_by='sms_id',$order='DESC',FALSE);
		}
		else{
			return $this->get_many();
		}
	}

	public function updateSms($data,$param){
		$this->table='sms_balance';
		return $this->modify($data,$param);
	}


}
