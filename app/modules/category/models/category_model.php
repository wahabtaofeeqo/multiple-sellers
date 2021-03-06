<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category_model extends MY_Model {
    
	public $tb_users;
	public $tb_categories;
	public $tb_services;

	public function __construct(){
		$this->tb_categories = CATEGORIES;
		parent::__construct();
	}



	function get_category_lists($total_rows = false, $status = "", $limit = "", $start = ""){
	    $lang_current = get_lang_code_defaut();
		if ($limit != "" && $start >= 0) {
			$this->db->limit($limit, $start);
		}
		$this->db->select('*');
		$this->db->from($this->tb_categories);
		$this->db->where('lang', $lang_current->code);
		$this->db->order_by('sort', 'ASC');

		$query = $this->db->get();
		if ($total_rows) {
			$result = $query->num_rows();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
		return false;
	}

	function get_sub_category_lists(){
	    $lang_current = get_lang_code_defaut();
		$this->db->select('*');
		$this->db->from("sub_categories");
		$this->db->where('lang', $lang_current->code);
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get();
                $result = $query->result();
                return $result;
		return false;
	}
	function get_second_sub_category_lists(){
	    $lang_current = get_lang_code_defaut();
		$this->db->select('*');
		$this->db->from("second_sub_categories");
		$this->db->where('lang', $lang_current->code);
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get();
                $result = $query->result();
                return $result;
		 return false;
	}

	function get_category_lists_by_search($k = ""){
	    $lang_current = get_lang_code_defaut();
		$k = trim(htmlspecialchars($k));
		if (get_role("user")) {
			$this->db->where("status", "1");
		}
		$this->db->select('*');
		$this->db->from($this->tb_categories);
		$this->db->where('lang', $lang_current->code);

		if ($k != "" && strlen($k) >= 2) {
			$this->db->like("name", $k, 'both');
			$this->db->or_like("desc", $k, 'both');
		}
		$this->db->order_by('sort', 'ASC');

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	//added bu mithu0705
	function GetSubCatm($sub){
	    $result=$this->db->query("SELECT * FROM `sub_categories` WHERE cat_id='$sub'");
		return $result;
	}
	
	function get_sub_category_by($id){
	    $lang_current = get_lang_code_defaut();
		$this->db->select('*');
		$this->db->from("sub_categories");
		$this->db->where('lang', $lang_current->code);
		$this->db->where('cat_id', $id);
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
		
	}

	public function getCategoryWithIDs($ids) {
		return $this->db->where('ids', $ids)->get($this->tb_categories)->row();
	}

	public function getServicesByCategoryID($id) {
		return $this->db->where('cate_id', $id)->get('services')->result();
	}

	public function deleteServicesByCategoryID($id) {
		return $this->db->delete('services', ['cate_id' => $id]);
	}

	public function getAdminKey() {
		$this->db->where("id", 4); // Temporary
		$query = $this->db->get('api_providers');
		return $query->row();
	}
}
