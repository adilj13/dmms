<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
                $this->load->database();
        }

        public function isValidUser($username,$password)
        {
        		$password=md5($password);
        		$sql = "SELECT * FROM users WHERE usr_name = ? AND usr_pass = ?";
                $query = $this->db->query($sql, array($username, $password));
                $res=$query->row();
                if(isset($res)){
                	return $res->usr_id;
                }else{
                	return false;
                }
        }

        public function submitMoney($userid,$amount=0)
        {
                $prevBal=$this->getUserBalance($userid);
                $newBal=$prevBal+$amount;
                $this->db->update('users', array('usr_curr_balance' => $newBal), array('usr_id' => $userid));
        }

        public function transfermoney($host,$client,$desc,$amount,$status='topay')
        {
                $this->db->insert('money_transfer',  array('host_usr_id' => $host, 'client_usr_id'=>$client,'description'=>$desc,'amount'=>$amount,'status'=>$status));
        }

        public function getHostAck($userid)
        {
                $sql = "SELECT * FROM money_transfer WHERE host_usr_id = ? AND status='topay'";
                $query = $this->db->query($sql, array($userid));
                $res=$query->result_array();
                if(isset($res)){
                        return $res;
                }else{
                        return false;
                }
        }

        public function payAck($mtid)
        {
                $ack=$this->getAck($mtid);
                $host=$this->getUserBalance($ack['host_usr_id']);
                $client=$this->getUserBalance($ack['client_usr_id']);
                $this->db->update('users',  array('usr_curr_balance' => ($host+$ack['amount'])), array('usr_id' => $ack['host_usr_id']));
                $this->db->update('users',  array('usr_curr_balance' => ($client-$ack['amount'])), array('usr_id' => $ack['client_usr_id']));
                $this->db->update('money_transfer',  array('status' => 'paid'), array('mt_id' => $ack['mt_id']));
        }

        public function getAck($mtid)
        {
                $sql = "SELECT * FROM money_transfer WHERE mt_id = ?";
                $query = $this->db->query($sql, array($mtid));
                $res=$query->row_array();
                if(isset($res)){
                        return $res;
                }else{
                        return false;
                }
        }

        public function getClientAck($userid)
        {
                $sql = "SELECT * FROM money_transfer WHERE client_usr_id = ? AND status='topay'";
                $query = $this->db->query($sql, array($userid));
                $res=$query->result_array();
                if(isset($res)){
                        return $res;
                }else{
                        return false;
                }
        }

        public function getUserId($usr_name)
        {
                $sql = "SELECT usr_id FROM users WHERE usr_name = ?";
                $query = $this->db->query($sql, array($usr_name));
                $res=$query->row_array();
                if(isset($res)){
                        return $res['usr_id'];
                }else{
                        return false;
                }
        }

        public function getUserInfo($userid)
        {
                $sql = "SELECT * FROM users WHERE usr_id = ?";
                $query = $this->db->query($sql, array($userid));
                $res=$query->row_array();
                if(isset($res)){
                        return $res;
                }else{
                        return false;
                }
        }

        public function withdrawMoney($userid,$amount=0)
        {

                $prevBal=$this->getUserBalance($userid);
                $newBal=$prevBal-$amount;
                if ($newBal<0) {
                        return;
                }else{
                        $this->db->update('users', array('usr_curr_balance' => $newBal), array('usr_id' => $userid));
                }

        }

        public function getUserBalance($userid)
        {
                $sql = "SELECT usr_curr_balance FROM users WHERE usr_id = ?";
                $query = $this->db->query($sql, array($userid));
                $res=$query->row_array();
                if(isset($res)){
                        return $res['usr_curr_balance'];
                }else{
                        return false;
                }
        }

        public function setNewPass($username,$oldpass,$newpass)
        {
        		$newpass=md5($newpass);
        		$isValid=$this->isValidUser($username,$oldpass);
        		if ($isValid) {
					$this->db->update('users', array('usr_pass' => $newpass), array('usr_id' => $isValid));
					return true;
        		}
        		else{
        			return false;
        		}
        }
        public function getUsers($except=1)
        {
                $sql = "SELECT * FROM users WHERE usr_id != ? AND usr_id != 1";
                $query = $this->db->query($sql, array($except));
                $res=$query->result_array();
                if(isset($res)){
                        return $res;
                }else{
                        return false;
                }
        }

        public function insert_entry()
        {
                $this->title    = $_POST['title']; // please read the below note
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->insert('entries', $this);
        }

        public function update_entry()
        {
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->update('entries', $this, array('id' => $_POST['id']));
        }

}