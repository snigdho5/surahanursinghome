<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Main_model extends MY_Model {


	function __construct(){
		$this->table='contact_us';
		$this->primary_key='cont_id';
	}

	public function addEmail($data){
		$this->table='contact_us';
		return $this->store($data);
	}

	public function addAppoint($data){
		$this->table='bookings';
		return $this->store($data);
	}

	public function addHits($data){
		$this->table='website_hits';
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



}
