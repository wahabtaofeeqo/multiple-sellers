<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tickets_model extends MY_Model {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_orders;
	public $tb_tickets;
	public $tb_ticket_message;

	public function __construct(){
		parent::__construct();
		//Config Module
		$this->tb_users      = USERS;
		$this->tb_categories = CATEGORIES;
		$this->tb_services   = SERVICES;
		$this->tb_orders     = ORDER;
		$this->tb_tickets    = TICKETS;
		$this->tb_ticket_message    = TICKET_MESSAGES;

	}

// 	function get_tickets($total_rows = false, $status = "", $limit = "", $start = ""){
		
// 		$this->db->select('*');
// 		$this->db->from('tickets');
// 		$query = $this->db->get();
// 		$result_arr = $query->result();
		
// 		foreach ($result_arr as $key => $row) {
			
			
// 			$this->db->select('uid');
// 			$this->db->from('services');
// 			$this->db->where("id", trim($row->service_id));
// 			$query = $this->db->get();
// 			$ald=$query->row();
		
// 			//if(($row->api_uid=='0')||($row->api_uid=='')){
// 			    $this->db->update('tickets', ['api_uid' =>$ald->uid], ['id' => $row->id]);
// 			//}
// 		}
		
// 		//if (get_role("m-seller")) {
// 			$this->db->where("tk.api_uid", session("uid"));
// 		//}

// 		if($status != "all" && !empty($status)){
// 			$this->db->where("tk.status", $status);
// 		}

// 		if ($limit != "" && $start >= 0) {
// 			$this->db->limit($limit, $start);
// 		}

// 		$this->db->select('tk.*, u.email as user_email, u.last_name, u.first_name');
// 		$this->db->from($this->tb_tickets." tk");
// 		$this->db->join($this->tb_users." u", "u.id = tk.api_uid", 'left');
// 		$this->db->order_by("FIELD ( tk.status, 'new', 'pending', 'closed')");
// 		$this->db->order_by('tk.changed', 'DESC');
// 		$query = $this->db->get();
// 		if ($total_rows) {
// 			$result = $query->num_rows();
// 			return $result;
// 		}else{
// 			$result = $query->result();
// 			return $result;
// 		}
// 		return false;
// 	}
    function get_tickets($total_rows = false, $status = "", $limit = "", $start = "") {

		if (get_role("user") || get_role("m-seller")) {
			$this->db->where("tk.uid", session("uid"));
		}

		if($status != "all" && !empty($status)){
			$this->db->where("tk.status", $status);
		}

		if ($limit != "" && $start >= 0) {
			$this->db->limit($limit, $start);
		}

		$this->db->select('tk.*, u.email as user_email, u.last_name, u.first_name');
		$this->db->from($this->tb_tickets." tk");
		$this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');
		$this->db->order_by("FIELD ( tk.status, 'new', 'pending', 'closed')");
		$this->db->order_by('tk.changed', 'DESC');

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

	function get_ticket_detail($id){
		if (get_role("user")) {
			$this->db->where("tk.uid", session("uid"));
		}
		$this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name,u.role');
		$this->db->from($this->tb_tickets." tk");
		$this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');
		$this->db->where("tk.id", $id);
		$this->db->order_by('tk.changed', 'DESC');
		$query = $this->db->get();
		if($query->row()){
			return $data = $query->row();
		}else{
			return false;
		}
	}
        
        function get_specific_ticket_list($ticket_id=0,$ticket_ids=0){
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

	function get_ticket_content($id){
		// if (!get_role("admin")) {
		// 	$this->db->where("tk_m.uid", session("uid"));
		// }
		$this->db->select('tk_m.*, u.email as user_email, u.first_name, u.last_name,u.role');
		$this->db->from($this->tb_ticket_message." tk_m");
		$this->db->join($this->tb_users." u", "u.id = tk_m.uid", 'left');
		$this->db->where("tk_m.ticket_id", $id);
		$this->db->order_by('tk_m.created', 'ASC');
		$query = $this->db->get();
		if($query->result()){
			return $data = $query->result();
		}else{
			return false;
		}
	}


	function get_search_tickets($k){
		$k = trim(htmlspecialchars($k));

		if (get_role("user")) {
			$this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name');
			$this->db->from($this->tb_tickets." tk");
			$this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`tk`.`id` LIKE '%".$k."%' ESCAPE '!' OR `tk`.`subject` LIKE '%".$k."%' ESCAPE '!' OR  `tk`.`status` LIKE '%".$k."%' ESCAPE '!')");
			}	

			$this->db->where("tk.uid", session("uid"));
			$this->db->order_by("FIELD ( tk.status, 'new', 'pending', 'closed')");
			$this->db->order_by('tk.changed', 'DESC');
			$query = $this->db->get();

		}else{
			$this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name');
			$this->db->from($this->tb_tickets." tk");
			$this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`tk`.`id` LIKE '%".$k."%' ESCAPE '!' OR `tk`.`subject` LIKE '%".$k."%' ESCAPE '!' OR  `tk`.`status` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`email` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`last_name` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`first_name` LIKE '%".$k."%' ESCAPE '!')");
			}	
			$this->db->order_by("FIELD ( tk.status, 'new', 'pending', 'closed')");
			$this->db->order_by('tk.changed', 'DESC');
			$query = $this->db->get();
		}
		if($query->result()){
			return $data = $query->result();
		}else{
			return false;
		}
	}
	public function get_admin(){
		$data  = array();
		$this->db->select("first_name,last_name,email");
		$this->db->where("role","admin");
		$this->db->from($this->tb_users);
		$this->db->order_by("id", 'DESC');
		$query = $this->db->get();
		$result = $query->row_object();
		return $result;
	}
	function get_last_insert_ticket(){
	     $this->db->select('*');
         $this->db->from('tickets');
         $this->db->order_by('id', 'DESC'); // 'id' is the column name of the record has stored in the database.
         return $this->db->get()->row();
	}
}
