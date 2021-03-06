<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class blocks extends MX_Controller {
	public $tb_transaction_logs;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_tickets    		= TICKETS;
		$this->tb_users    		    = USERS;
		$this->tb_ticket_message    = TICKET_MESSAGES;
		$this->tb_transaction_logs  = TRANSACTION_LOGS;
	}

	public function set_language(){
		set_language(post("id"));

		ms(array("status" => "success"));
	}

	public function header(){
		$news = 0;
		$unread_tickets = 0;

		if (get_role('user')) {

			$this->db->select('tk_m.ticket_id');
			$this->db->from($this->tb_ticket_message." tk_m");
			$this->db->join($this->tb_tickets." tk", "tk.id = tk_m.ticket_id", 'left');
			$this->db->where("tk.uid", session('uid'));
			$this->db->where("tk_m.uid !=", session('uid'));
			$this->db->where("tk_m.is_read", 1);
			$this->db->group_by('tk_m.ticket_id');
			$query = $this->db->get();
			$unread_tickets = $query->num_rows();
		}else if(get_role('m-seller')){
			$this->db->select("id");
			$this->db->from($this->tb_tickets);
			$this->db->where('api_uid', session('uid'));
			$this->db->where('status', 'new');
			$query = $this->db->get();
			$news = $query->num_rows();

			$this->db->select("tk_m.ticket_id");
			$this->db->from($this->tb_ticket_message. " tk_m");
			$this->db->join($this->tb_tickets." tk", "tk_m.ticket_id = tk.id", 'left');
			$this->db->where('tk.status !=', 'new');
			$this->db->where('tk_m.api_uid', session('uid'));
			$this->db->where('tk_m.is_read', 1);
			$this->db->group_by('tk_m.ticket_id');
			$query = $this->db->get();
			$unread_tickets = $query->num_rows();
			
		}else{

			$this->db->select("id");
			$this->db->from($this->tb_tickets);
			$this->db->where('uid', session('uid'));
			$this->db->where('status', 'new');
			$query = $this->db->get();
			$news = $query->num_rows();

			$this->db->select("tk_m.ticket_id");
			$this->db->from($this->tb_ticket_message. " tk_m");
			$this->db->join($this->tb_tickets." tk", "tk_m.ticket_id = tk.id", 'left');
			$this->db->where('tk.status !=', 'new');
			$this->db->where('tk_m.uid', session('uid'));
			$this->db->where('tk_m.is_read', 1);
			$this->db->group_by('tk_m.ticket_id');
			$query = $this->db->get();
			$unread_tickets = $query->num_rows();
		}

		$total_unread_tickets = $news + $unread_tickets;
		$data = array(
			"total_unread_tickets" => $total_unread_tickets,
			"user_balance_seller" => $this->get_sum_value($this->tb_transaction_logs),
		);
              
					  
                $menu_data=array();
                $current_user=get_current_user_data();
                if(isset($current_user->menu_permissions)){
                    $menu_arr=explode(',', $current_user->menu_permissions);
                    $this->db->select('*');
                    $this->db->from('general_menu_manager');
                    $query = $this->db->get();
                    $menu_res = $query->result_array();
                    foreach ($menu_res as $men){
                        if(isset($current_user->super_admin) && $current_user->super_admin==1){
                            array_push($menu_data,$men['menu_tag']);
                        }else{
                            if(in_array($men['id'],$menu_arr)){
                                array_push($menu_data,$men['menu_tag']);
                            }
                        }
                    }
                    
                }
				
				
        $data['menu_permission']=$menu_data;
		$this->load->view('header', $data);
	}
	
	public function sidebar(){
		$data = array();
		$this->load->view('sidebar', $data);
	}	
	
	private function get_sum_value($table){
		if (!get_role("admin")) {
			$this->db->where("uid", session("uid"));
		}
		$this->db->select_sum("amount");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();

		if ($result[0]->amount > 0) {
			return $result[0]->amount;
		}else{
			return 0;
		}

	}
	
	public function footer(){
		$data = array(
        	'lang_current' => get_lang_code_defaut(),
        	'languages'    => $this->model->fetch('*', LANGUAGE_LIST,'status = 1'),
        );
		$this->load->view('footer', $data);
	}	
	
	public function empty_data(){
		$data = array();
		$this->load->view('empty_data', $data);
	}

	public function back_to_admin(){
		$user = $this->model->get("id, ids", $this->tb_users, ['id' => session('uid')]);
		if (empty($user)) {
			ms(array(
				'status'  => 'error',
				'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
			));
		}
		unset_session("uid_tmp");
		unset_session("user_current_info");
		if (!session('uid_tmp')) {
			ms(array(
				'status'  => 'success',
				'message' => lang("processing_"),
			));
		}
	}
}