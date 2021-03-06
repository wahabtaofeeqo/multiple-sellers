<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order_model extends MY_Model {
	public $tb_users;
	public $tb_order;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;

	public function __construct(){
		$this->tb_categories        = CATEGORIES;
		$this->tb_order             = ORDER;
		$this->tb_users             = USERS;
		$this->tb_services          = SERVICES;
		$this->tb_api_providers   	= API_PROVIDERS;
		parent::__construct();
	}

	function get_categories_list() {
	    $lang_current = get_lang_code_defaut();
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_categories);
		$this->db->where("status", "1");
		$this->db->where('lang', $lang_current->code);
		$this->db->order_by("sort", 'ASC');
		$query = $this->db->get();

		$categories = $query->result();
		if(!empty($categories)){
			return $categories;
		}
		return false;
	}

	function get_services_list_by_cate($id = ""){
		$data  = array();
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where("cate_id", $id);
		$this->db->where("uid", session("uid"));
		$this->db->order_by("price", "ASC");
		$query = $this->db->get();
		$services = $query->result();
		if(!empty($services)){
			return $services;
		}
		return false;
	}

	function get_service_item($id = ""){
		$data  = array();

		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where("id", $id);
		$this->db->where("status", "1");
		$this->db->where("uid", session("uid"));
		$query = $this->db->get();

		$service = $query->row();
		
		
		if(!empty($service)){
			return $service;
		}
		return false;
	}

	function get_services_by_cate($id = ""){
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where("cate_id", $id);
		$this->db->where("status", "1");
		$query = $this->db->get();

		$services = $query->result();
		if(!empty($services)){
			return $services;
		}

		return false;
	}
	function get_sub_categories_by_cate($id = ""){
		$data  = array();
		$this->db->select("*");
		$this->db->from("sub_categories");
		$this->db->where("cat_id", $id);
		$this->db->where("status", "1");
		$query = $this->db->get();
	
		$services = $query->result();
		if (get_role("m-seller")) {
		$i = 0;
			foreach ($services as $key => $row) {
				$muti_arr=explode(',', $row->seller_permission);
			    if(in_array(session('uid'),$muti_arr)){
				        if(in_array(session('uid'),$muti_arr)){
				
				
						}else{
						   unset($services[$key]);	
						   
						}
				
			    }else{
				 $services;	
				   
			    }
			}
		
		}
		if(!empty($services)){
			return $services;
		}

		return false; 
	}
	function get_second_sub_categories_by_cate($id = ""){
		$data  = array();
		$this->db->select("*");
		$this->db->from("second_sub_categories");
		$this->db->where("sub_cat_id", $id);
		$this->db->where("status", "1");
		$query = $this->db->get();

		$services = $query->result();
		if (get_role("m-seller")) {
		$i = 0;
			foreach ($services as $key => $row) {
				$muti_arr=explode(',', $row->seller_permission);
			    if(in_array(session('uid'),$muti_arr)){
				    if(in_array(session('uid'),$muti_arr)){
				
				
					}else{
					   unset($services[$key]);	
					   
					}
				
			    }else{
				   $services;	
				   
			    }
			}
		}
		
		if(!empty($services)){
			return $services;
		}

		return false; 
	}
	function get_services_by_sub_cate($id = ""){
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where("sub_cat_id", $id);
		$this->db->where("status", "1");
		$query = $this->db->get();

		$services = $query->result();
		if(!empty($services)){
			return $services;
		}

		return false;
	}
	function get_services_by_second_sub_cate($id = ""){
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where("second_sub_cat_id", $id);
		$this->db->where("status", "1");
		$query = $this->db->get();

		$services = $query->result();
		if(!empty($services)){
			return $services;
		}

		return false;
	}

	function get_order_logs_list($total_rows = false, $status = "", $limit = "", $start = "") {

		$data  = array();
		if (get_role("user") || get_role("admin")) {
			return $this->get_order_for_admin($total_rows, $status, $limit, $start);
		}
		elseif (get_role('m-seller')) {
			return $this->getSellerOrders($total_rows, $status, $limit, $start);
		}
		else {
			return false;
		}
	}

	function getSellerOrders($total_rows = false, $status = "", $limit = "", $start = "") {

		if ($limit != "" && $start >= 0) {
			$this->db->limit($limit, $start);
		}
		$this->db->select('o.*, u.email as user_email, s.name as service_name, api.name as api_name');
		$this->db->from($this->tb_order." o");
		$this->db->join($this->tb_users." u", "u.id = o.uid", 'left');
		$this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
		$this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');
		if($status != "all" && !empty($status)) {
			$this->db->where("o.status", $status);
		}

		$this->db->where("o.service_type !=", "subscriptions");
		$this->db->where("o.is_drip_feed !=", 1);
		$this->db->where("o.uid", session("uid"));
		$this->db->order_by("o.id", 'DESC');

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

	function get_order_for_admin($total_rows = false, $status = "", $limit = "", $start = "") {

		if ($limit != "" && $start >= 0) {
			$this->db->limit($limit, $start);
		}
		$this->db->select('o.*, u.email as user_email, s.name as service_name, api.name as api_name');
		$this->db->from($this->tb_order." o");
		$this->db->join($this->tb_users." u", "u.id = o.uid", 'left');
		$this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
		$this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');
		if($status != "all" && !empty($status)) {
			$this->db->where("o.status", $status);
		}

		$this->db->where("o.service_type !=", "subscriptions");
		$this->db->where("o.is_drip_feed !=", 1);
		//$this->db->where("o.uid", session("uid"));
		$this->db->order_by("o.id", 'DESC');

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

	function get_orders_logs_by_search($k){
		$k = trim(htmlspecialchars($k));
		if (get_role("user")||get_role("m-seller")) {
			$this->db->select('o.*, u.email as user_email, s.name as service_name');
			$this->db->from($this->tb_order." o");
			$this->db->join($this->tb_users." u", "u.id = o.uid", 'left');
			$this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`o`.`id` LIKE '%".$k."%' ESCAPE '!' OR `o`.`link` LIKE '%".$k."%' ESCAPE '!' OR `o`.`status` LIKE '%".$k."%' ESCAPE '!' OR  `s`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}
			$this->db->where("o.service_type !=", "subscriptions");
			$this->db->where("o.is_drip_feed !=", 1);
			$this->db->where("u.id", session("uid"));
			$this->db->order_by("o.id", 'DESC');
			$query = $this->db->get();
			$result = $query->result();

		}else{
			$this->db->select('o.*, u.email as user_email, s.name as service_name, api.name as api_name');
			$this->db->from($this->tb_order." o");
			$this->db->join($this->tb_users." u", "u.id = o.uid", 'left');
			$this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
			$this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`o`.`api_order_id` LIKE '%".$k."%' ESCAPE '!' OR `o`.`id` LIKE '%".$k."%' ESCAPE '!' OR `o`.`status` LIKE '%".$k."%' ESCAPE '!' OR `o`.`link` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`email` LIKE '%".$k."%' ESCAPE '!' OR  `s`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}
			$this->db->where("o.service_type !=", "subscriptions");
			$this->db->where("o.is_drip_feed !=", 1);
			$this->db->order_by("o.id", 'DESC');

			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}
        function get_order_client_list($order_id){
		$data  = array();
                
		$this->db->select("*");
                $this->db->where("order_id", $order_id);
		$this->db->from("order_api_clients");
		$query = $this->db->get();

		$clients = $query->result();
		if(!empty($clients)){
			return $clients;
		}
		return false;
	}
        
        function get_sub_category_lists(){
		$this->db->select('*');
		$this->db->from("sub_categories");
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get();
                $categories = $query->result();
                if(!empty($categories)){
			$i = 0;
			foreach ($categories as $key => $row) {
				$i++;
				// get services
				if ($i > 0) {
					if (get_role("supporter") || get_role("admin")) {
						$services = $this->model->fetch("id", $this->tb_services, ['sub_cat_id' => $row->id],'price', 'ASC');
					}else{
						$services = $this->model->fetch("id", $this->tb_services, ["status" => 1, 'sub_cat_id' => $row->id], 'price', 'ASC');
					}

					if(!empty($services)){
						$categories[$key]->is_exists_services = 1;
					}else{
						unset($categories[$key]);	
					}

				}else{
					break;
				}
				
			}
		}
                return $categories;
	}
        function get_second_sub_category_lists(){
		$this->db->select('*');
		$this->db->from("second_sub_categories");
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get();
                $categories = $query->result();
                if(!empty($categories)){
			$i = 0;
			foreach ($categories as $key => $row) {
				$i++;
				// get services
				if ($i > 0) {
					if (get_role("supporter") || get_role("admin")) {
						$services = $this->model->fetch("id", $this->tb_services, ['sub_cat_id' => $row->id],'price', 'ASC');
					}else{
						$services = $this->model->fetch("id", $this->tb_services, ["status" => 1, 'second_sub_cat_id' => $row->id], 'price', 'ASC');
					}

					if(!empty($services)){
						$categories[$key]->is_exists_services = 1;
					}else{
						unset($categories[$key]);	
					}

				}else{
					break;
				}
				
			}
		}
                return $categories;
	}

}

