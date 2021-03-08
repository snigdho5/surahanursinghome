<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {

	public function __construct() {
		parent:: __construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$hdata = array(
			'ip' => $this->input->ip_address(),
			'hit_dtime' => dtime
			);
		$added=$this->mm->addHits($hdata);

		$docdata = $this->mm->getDoctorData($p=null,$many=TRUE);
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

		$this->load->view('vw_welcome', $this->data, false);
	}


	public function onSetContUs()
	{
		if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->form_validation->set_rules('name', 'Fullname', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|regex_match[/^[0-9]{10}$/]|xss_clean|htmlentities');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|htmlentities');
			$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean|htmlentities');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('', '');
				$return['errors'] = validation_errors();
				$return['mailsent'] = 'rule_error';
			}
			else 
			{
				$fullname = strip_tags($this->input->post('name'));
				$phone = strip_tags($this->input->post('phone'));
				$email = strip_tags($this->input->post('email'));
				$message = strip_tags($this->input->post('message'));
				$subject = strip_tags($this->input->post('subject'));

				$data = array(
				'name' => $fullname,
				'phone' => $phone,
				'email' => $email,
				'message' => $message,
				'subject' => $subject,
				'iplocation' => $this->input->ip_address(),
				'dtime' => dtime
				);
				//print_obj($data);die;
				$added=$this->mm->addEmail($data);

				if($added){
				//mail
				
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$this->load->library('email',$config);
				
				$to = 'info@surahanursinghome.com';
				//$cc = 'mailbox@smarttraininghub.com';
				$subject_m = 'Suraha - Contact Us | From - '.$fullname;
				$msg = "<p>You've got a new a message.</p>
				   <table border=\"1\">

				   <tr>
				   <th>Subject</th>
				   <th>Name</th>
				   <th>Email</th>
				   <th>Message</th>
				   </tr>

				   <tr>
				   <td>".$subject."</td>
				   <td>".$fullname."</td>
				   <td>".$email."</td>
				   <td>".$message."</td>
				   </tr>
				   </table>
				   <p>Dated: ".dtime."</p>
				   <p>*This is a system generated e-mail please do not reply to this mail.*</p>
				   ";

				$this->email->set_newline("\r\n");
				$this->email->from('dev@surahanursinghome.com','Suraha Mailler');
				$this->email->to($to);
				//$this->email->cc($cc);
				$this->email->subject($subject_m);
				$this->email->message($msg);

				if ($this->email->send())
					{
						$return['mailsent'] = 'success';
					}
					else
					{
						$return['mailsent'] = 'failure_mail';
					}
				}
				else{
					$return['mailsent'] = 'failure';
				}
				//print_obj();die;
			}
			header('Content-Type: application/json');
			echo json_encode($return);	
		}else{}
	}


	public function onSetAppoint()
	{
		if($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD')=='POST')
		{
			$this->form_validation->set_rules('name', 'Fullname', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|regex_match[/^[0-9]{10}$/]|xss_clean|htmlentities');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|htmlentities');
			$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('doctor', 'Doctor', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('day', 'Day', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('time', 'Time', 'trim|required|xss_clean|htmlentities');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('', '');
				$return['errors'] = validation_errors();
				$return['mailsent'] = 'rule_error';
			}
			else 
			{
				$fullname = strip_tags($this->input->post('name'));
				$phone = strip_tags($this->input->post('phone'));
				$email = strip_tags($this->input->post('email'));
				$message = strip_tags($this->input->post('message'));
				$doctor = strip_tags($this->input->post('doctor'));
				$day = strip_tags($this->input->post('day'));
				$time = strip_tags($this->input->post('time'));

				$data = array(
				'name' => $fullname,
				'phone' => $phone,
				'email' => $email,
				'message' => $message,
				'doctor_id' => $doctor,
				'day' => $day,
				'time' => $time,
				'iplocation' => $this->input->ip_address(),
				'dtime' => dtime
				);
				//print_obj($data);die;
				$added=$this->mm->addAppoint($data);

				if($added){
				//mail
				
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$this->load->library('email',$config);
				
				$to = 'info@surahanursinghome.com';
				//$cc = 'mailbox@smarttraininghub.com';
				$subject = 'Suraha - Book an Appoinment | From - '.$fullname;
				$msg = "<p>You've got a new a message.</p>
				   <table border=\"1\">

				   <tr>
				   <th>Name</th>
				   <th>Phone</th>
				   <th>Email</th>
				   <th>Message</th>
				   <th>Day</th>
				   <th>Time</th>
				   </tr>

				   <tr>
				   <td>".$fullname."</td>
				   <td>".$phone."</td>
				   <td>".$email."</td>
				   <td>".$message."</td>
				   <td>".$day."</td>
				   <td>".$time."</td>
				   </tr>
				   </table>
				   <p>Dated: ".dtime."</p>
				   <p>*This is a system generated e-mail please do not reply to this mail.*</p>
				   ";

				$this->email->set_newline("\r\n");
				$this->email->from('dev@surahanursinghome.com','Suraha Mailler');
				$this->email->to($to);
				//$this->email->cc($cc);
				$this->email->subject($subject);
				$this->email->message($msg);

				if ($this->email->send())
					{
						$return['mailsent'] = 'success';
					}
					else
					{
						$return['mailsent'] = 'failure_mail';
					}
				}
				else{
					$return['mailsent'] = 'failure';
				}
				//print_obj();die;
			}
			header('Content-Type: application/json');
			echo json_encode($return);	
		}else{}
	}


	
	

}
