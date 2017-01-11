<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('user_model');
	}
	public function index()
	{
		if ($this->session->userdata('user_id')==null) {
			redirect('user/login');
		} else {
			redirect('user/dashboard');
		}
	}
	public function process()
	{
		if ($this->input->post('submit')!=null) {
			$this->user_model->submitMoney($this->input->post('user_id'),$this->input->post('amount'));
			redirect('user/dashboard');
		}elseif ($this->input->post('withdraw')!=null) {
			$this->user_model->withdrawMoney($this->input->post('user_id'),$this->input->post('amount'));
			redirect('user/dashboard');
		}
	}
	public function dashboard()
	{
		if ($this->session->userdata('user_id')==null) {
			redirect('user/login');
		}
		elseif ($this->session->userdata('user_id')=='1'){
			$users = $this->user_model->getUsers();
			$data = array('users' => $users);
			$this->load->view('admin_dashboard_view',$data);
		}
		else {
			$users = $this->user_model->getUsers($this->session->userdata('user_id'));
			$user=$this->user_model->getUserInfo($this->session->userdata('user_id'));
			$hosttrans=$this->user_model->getHostAck($this->session->userdata('user_id'));
			$clienttrans=$this->user_model->getClientAck($this->session->userdata('user_id'));
			$data = array('user' => $user,'users' => $users,'hosttrans'=>$hosttrans,'clienttrans'=>$clienttrans);
			$this->load->view('user_dashboard_view',$data);
		}
	}
	public function processAck()
	{
		$arr=array_count_values($_POST);
		if (isset($arr['on'])) {
			$usernames = array();
			$perperson=$_POST['moneytodivide']/$arr['on'];
			foreach ($_POST as $key => $value) {
				if ($value=='on') {
					$usernames[]=$key;
				}
			}
			foreach ($usernames as $name) {
				$userid=$this->user_model->getUserId($name);
				$this->user_model->transfermoney($this->session->userdata('user_id'),$userid,$this->input->post('desc'),$perperson);
			}
		}
		redirect('user/dashboard');
	}

	public function transfer($mtid)
	{
		$ack=$this->user_model->getAck($mtid);
		$firstuser=$this->user_model->getUserInfo($this->session->userdata('user_id'));
		if ($firstuser['usr_curr_balance']>=$ack['amount']) {
			$this->user_model->payAck($mtid);
			redirect('user/dashboard');
		}
		else{
			echo "Not Enough Balance";
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('user/login');
	}
	public function login()
	{
		if ($this->session->userdata('user_id')==null) {
			$this->load->view('login_view');
		} else {
			redirect('user/dashboard');
		}
	}
	public function changepass()
	{
		if ($this->input->post('usName')==null||$this->input->post('opWord')==null||$this->input->post('npWord')==null||$this->input->post('rpWord')==null) {
			redirect('user/login');
		}else{
			if ($this->input->post('npWord')==$this->input->post('rpWord')) {
				if($this->user_model->setNewPass($this->input->post('usName'),$this->input->post('opWord'),$this->input->post('npWord'))){
					echo "Password changed successfully!";
				}
				else{
					echo "Error while updating Password";
				}
			}
		}
	}
	public function doLogin()
	{
		if ($this->input->post('uName')==null||$this->input->post('pWord')==null) {
			redirect('user/login');
		}else{
			$isValid=$this->user_model->isValidUser($this->input->post('uName'),$this->input->post('pWord'));
			if ($isValid) {
				$this->session->set_userdata(array('user_id'=>$isValid));
				redirect('user/dashboard');
			}
			else{
				echo "Wrong Credentials";
			}
		}
	}
}