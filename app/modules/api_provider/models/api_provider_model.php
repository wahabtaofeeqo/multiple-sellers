<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api_provider_model extends MY_Model {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_orders;
	public $tb_services_media;

	public function __construct(){
		$this->tb_categories 		= CATEGORIES;
		$this->tb_services   		= SERVICES;
		$this->tb_api_providers   	= API_PROVIDERS;
		$this->tb_orders     		= ORDER;
                $this->tb_users      = USERS;
				$this->tb_services_media   = services_media;
		parent::__construct();
	}

	function get_api_lists($status = false){
		$data  = array();
		if ($status) {
			$this->db->where("status", 1);
		}
		
		$this->db->select("*");
		$this->db->from($this->tb_api_providers);
		$this->db->order_by("id", 'ASC');

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function get_all_orders(){
		$data  = array();
		//$where = "(`status` = 'pending' or `status` = 'inprogress')";
		$this->db->select("*");
		$this->db->from($this->tb_orders);
		//$this->db->where($where);
		$this->db->where("api_service_id !=", "");
		$this->db->where("api_order_id =", -1);
		$this->db->order_by("id", 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function get_all_orders_(){
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_orders);
		$this->db->order_by("id", 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function get_all_users_(){
		$data  = array();
		$this->db->select("*");
		$this->db->where("status",1);
		$this->db->from($this->tb_users);
		$this->db->order_by("id", 'DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	function get_all_services_(){
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->order_by("id", 'ASC');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function get_all_services_where($where=array()){
		$data  = array();
                if(!empty($where)){
                    $this->db->where($where);
                }
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function get_messages($ticket_id){
		$data  = array();
		$this->db->select("*");
		$this->db->where("ticket_id",$ticket_id);
		$this->db->from("ticket_messages");
		$this->db->order_by("id", 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	function get_all_orders_status(){
		$where = "`api_service_id` != '' AND `api_order_id` > 0  AND service_type != 'subscriptions'";
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_orders);
		$this->db->where($where);
		$this->db->order_by("id", 'ASC');
		$this->db->limit(15,0);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function get_orders_status_by_id($order_id){
		$data  = array();
		$this->db->select("*");
		$this->db->from($this->tb_orders);
		$this->db->where('api_order_id',$order_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function get_all_subscriptions_status(){
		$where = "(`sub_status` = 'Active' or `sub_status` = 'Paused') AND `api_provider_id` != 0 AND `api_order_id` > 0 AND `changed` < '".NOW."' AND service_type = 'subscriptions'";
		$this->db->select("*");
		$this->db->from($this->tb_orders);
		$this->db->where($where);
		$this->db->order_by("id", 'ASC');
		$this->db->limit(15,0);
		$query = $this->db->get();
		$result = $query->result();
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
    
    function get_ticket_list($ticket_id=0,$ticket_ids=0){
		$this->db->select("*");
                if($ticket_id!=0){
                    $this->db->where("id", $ticket_id);
                }
                if($ticket_ids!=0){
                    $this->db->where("ids", $ticket_ids);
                }
		$this->db->from("tickets");
		$query = $this->db->get();

		$tickets = $query->result_array();
                return $tickets;
		
	}
	
	function get_all_media_where($where=array()){
		$data  = array();
                if(!empty($where)){
                    $this->db->where($where);
                }
		$this->db->select("*");
		$this->db->from($this->tb_services_media);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function getTicketWithID($ticketID) {

        $this->db->where('id', $ticketID);
		$this->db->from("tickets");
		$query = $this->db->get();

        return $query->row();
	}

	public function get_admin(){
		$data  = array();
		$this->db->select("*");
		$this->db->where("role","admin");
		$this->db->from($this->tb_users);
		$this->db->order_by("id", 'DESC');
		$query = $this->db->get();
		$result = $query->row_object();
		return $result;
	}

	function getOrder($id) {

        $this->db->where('id', $id);
		$this->db->from("orders");
		$query = $this->db->get();

        return $query->row();
	}

	function getOrders($id) {

        $this->db->where('id', $id);
		$this->db->from("orders");
		$query = $this->db->get();

        return $query->result();
	}
}
