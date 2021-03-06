<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile_model extends MY_Model {
	public $tb_users;
    public $tb_users_files;
	
	public function __construct(){
		parent::__construct();
		$this->tb_users = USERS;
		$this->tb_users_files = 'users_files';
	}
	public function user_files(){
		$this->db->select('*');
		$this->db->from($this->tb_users_files);
		$this->db->where('uid',session('uid'));
		$query = $this->db->get();
		$result = $query->result();
		return $result;
		
	}

}
