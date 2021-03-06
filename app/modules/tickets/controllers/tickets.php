<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class tickets extends MX_Controller {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_orders;
	public $tb_tickets;
	public $tb_ticket_message;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_users      = USERS;
		$this->tb_categories = CATEGORIES;
		$this->tb_services   = SERVICES;
		$this->tb_orders     = ORDER;
		$this->tb_tickets    = TICKETS;
		$this->tb_ticket_message    = TICKET_MESSAGES;

	}

	public function index($ticket_id = 0) {

		$page        = (int)get("p");
		$page        = ($page > 0) ? ($page - 1) : 0;
		
		if(get_role("m-seller")){
		   $limit_per_page = get_option("default_limit_per_page_".session('uid'), 10);
		}else{
			$limit_per_page = get_option("default_limit_per_page", 10);
		}
		
		$query = array();
		$query_string = "";
		if(!empty($query)){
			$query_string = "?".http_build_query($query);
		}

		$config = array(
			'base_url'           => cn(get_class($this).$query_string),
			'total_rows'         => $this->model->get_tickets(true),
			'per_page'           => $limit_per_page,
			'use_page_numbers'   => true,
			'prev_link'          => '<i class="fe fe-chevron-left"></i>',
			'first_link'         => '<i class="fe fe-chevrons-left"></i>',
			'next_link'          => '<i class="fe fe-chevron-right"></i>',
			'last_link'          => '<i class="fe fe-chevrons-right"></i>',
		);
		
		$this->pagination->initialize($config);
		$links = $this->pagination->create_links();

		$tickets = $this->model->get_tickets(false, "all", $limit_per_page, $page * $limit_per_page);

		/*----------  Check auto delete ticket  ----------*/
		$tks_id=trim(session('uid'));
		if(get_role("m-seller")){
			
			if (get_option("is_clear_ticket_".session('uid'), "")) {

				$days = get_option("default_clear_ticket_days_".$tks_id, "");
				$day_tmp           = strtotime(NOW) - ($days*24*60*60);
				$old_tickets       = $this->model->fetch('id, uid',$this->tb_tickets, "changed <= '".date("Y-m-d H:i:s", $day_tmp)."'");
				if (!empty($old_tickets)) {
					foreach ($old_tickets as $key => $row) {
						$this->db->delete($this->tb_ticket_message, ['ticket_id' => $row->id]);
						$this->db->delete($this->tb_tickets, ['id' => $row->id]);
					}
				}
			}
		}else{
			if(get_option("is_clear_ticket", "")) {

			$days = get_option("default_clear_ticket_days", "");
			$day_tmp           = strtotime(NOW) - ($days*24*60*60);
			$old_tickets       = $this->model->fetch('id, uid',$this->tb_tickets, "changed <= '".date("Y-m-d H:i:s", $day_tmp)."'");
			if (!empty($old_tickets)) {
				foreach ($old_tickets as $key => $row) {
					$this->db->delete($this->tb_ticket_message, ['ticket_id' => $row->id]);
					$this->db->delete($this->tb_tickets, ['id' => $row->id]);
				}
			}
		}}

		$data = array(
			"module"     => get_class($this),
			"tickets"    => $tickets,
			"links"		 => $links,
                        "ticket_data"=>$ticket_id
		);
		if(get_role("m-seller")){
			$data["admin_data"] = $this->model->get_admin();
		}
		
		$this->template->build("index", $data);
	}
	
	public function add(){
		$data = array(
			"module"   => get_class($this),
		);
		$this->load->view('add', $data);
	}	

	public function view($id = ""){
		if (get_role('admin') || get_role('supporter')|| get_role('m-seller')) {
			$ticket_status = get_field($this->tb_tickets, ['id' => $id], 'status');
			if (!empty($ticket_status) && $ticket_status == 'new') {
				$this->db->update($this->tb_tickets, ['status' => 'pending'], ['id' => $id]);
                                //update another server
                                $check_item = $this->model->get("ids,id,api_provider", $this->tb_tickets, "id = '{$id}'");
                                $url=base_url()."/api_provider/cron/ticket/".$id;
                                if($check_item->api_provider !="NULL" && $check_item->api_provider !=null && $check_item->api_provider !="null" ){
                                    $url=base_url()."/api_provider/cron/ticket/".$id."/0/false";
                                }
                                $this->call_cron($url);
			}
		}

		$ticket = $this->model->get_ticket_detail($id);
		$receiver = $this->db->get_where('general_users', ['role !=' => $ticket->role])->row();
		if (!empty($ticket)) {
			$ticket_content = $this->model->get_ticket_content($id);
			/*----------  Exchange ticket status to read  ----------*/
			if (!empty($ticket_content)) {
				$end_ticket_message = end($ticket_content);
				if ($end_ticket_message->uid != session('uid')) {
					$this->db->update($this->tb_ticket_message, ['is_read' => 0], ['ticket_id' => $end_ticket_message->ticket_id]);
				}
				if(get_role("m-seller")||get_role("admin")) {
					if ($end_ticket_message->uid == session('uid')) {
						$this->db->update($this->tb_ticket_message, ['is_read' => 0], ['ticket_id' => $end_ticket_message->ticket_id]);
					}	
				} 
			}

			$data = array(
				"module"   => get_class($this),
				"ticket"   => $ticket,
				"receiver" => $receiver,
				"ticket_content"   => $ticket_content
			);
			if(get_role("m-seller")){
            	$data["admin_data"] = $this->model->get_admin();
        	}
			$this->template->build('update', $data);
		}else{
			load_404();
		}
	}

	public function ajax_add(){
		$subject 		= post("subject");
		$description    = post("description");
                $send_api_provider_id="NULL";
		if($subject == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("subject_is_required")
			));
		}

		switch ($subject) {

			case 'subject_order':
				$subject = lang("Order");

				$request = post("request");
				$orderid = post("orderid");
				if($request == ""){
					ms(array(
						"status"  => "error",
						"message" => lang("please_choose_a_request")
					));
				}
				if($orderid == ""){
					ms(array(
						"status"  => "error",
						"message" => lang("order_id_field_is_required")
					));
				}

				switch ($request) {
					case 'refill':
						$request = lang("Refill");
						break;
					case 'cancellation':
						$request = lang("Cancellation");
						break;
					case 'speed_up':
						$request = lang("Speed_Up");
						break;
					default:
						$request = lang("Other");
						break;
				}
				$subject = $subject. " - ".$request. " - ".$orderid;
				break;

			case 'subject_payment':
				$subject = "Payment";
				$payment = post("payment");
				$transaction_id = post("transaction_id");
				$send_api_provider_id = !empty(post("api_sender"))?post("api_sender"):"NULL";

				if($payment == ""){
					ms(array(
						"status"  => "error",
						"message" => lang("please_choose_a_payment_type")
					));
				}

				if($transaction_id == ""){
					ms(array(
						"status"  => "error",
						"message" => lang("transaction_id_field_is_required")
					));
				}

				switch ($payment) {
					case 'paypal':
						$payment = lang("Paypal");
						break;
					case 'stripe':
						$payment = lang("Stripe");
						break;
					case 'twocheckout':
						$payment = lang("2Checkout");
						break;
					default:
						$payment = lang("Other");
						break;
				}
				$subject = $subject. " - ".$payment. " - ".$transaction_id;

				break;

			case 'subject_service':
				$subject = lang("Service");
                                $serviceid = post("serviceid");
                                $subject = $subject. " - ".$serviceid;
				break;
			
			default:
				$subject = lang("Other");
                                $send_api_provider_id = !empty(post("api_sender"))?post("api_sender"):"NULL";
				break;
		}

		if($description == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("description_is_required")
			));
		}
                
                //upload a file
                $file_link="";
                if(isset($_FILES["attach_file"]["name"])){
                    $maxsize=20971520;
                    if(($_FILES['attach_file']['size'][0] >= $maxsize) || ($_FILES["attach_file"]["size"][0] == 0)) {
                        ms(array(
                            "status"  => "error",
                            "message" => lang('unsupported_file_size')
                        ));
                    }
                    $target_dir = FCPATH."assets/uploads/ticket_file/";
                    $target_file = $target_dir . basename($_FILES["attach_file"]["name"][0]);
                    if(move_uploaded_file($_FILES["attach_file"]["tmp_name"][0], $target_file)){
                        $file_link=base_url()."/assets/uploads/ticket_file/".$_FILES["attach_file"]["name"][0];
                    }
                    
                }

		//
		$last_record = $this->model->get_last_insert_ticket();
        
        if($last_record != null){
            $play_id = 1 + $last_record->play_id;
        }else{
            $play_id = 1;
        }
        
		$data = array(
			"ids"             => ids(),
			"uid"             => 40,
			"subject"         => $subject,
			"description"     => $description,
                        "file_link"         => $file_link,
                        "send_api_provider_id"         => $send_api_provider_id,
						"api_uid" =>session('uid'),
			"changed"         => NOW,
			"created"         => NOW,
		    "play_id"         => '',
		);
                if(post("subject")=="subject_order"){
                    $data["order_id"]=$orderid;
                }
                if(post("subject")=="subject_service"){
                    $data["service_id"]=$serviceid;
                }
		$this->db->insert($this->tb_tickets, $data);
		$tkid=$this->db->insert_id();
		$sess_id=trim(session('uid'));
		if ($this->db->affected_rows() > 0) {
                        $ticket_number = $this->db->insert_id();
                        /*----------  Send email notification to new user  ----------*/
						if(get_role("m-seller")){
							if (get_option("is_ticket_notice_email_".$sess_id, '')) {
									$subject = $subject;
									$ticket_number = $this->db->insert_id();;
									$subject = get_option("website_name", "") ." - #Ticket"."$ticket_number - $subject";
									$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
									if ($admin_id == "") {
										$admin_id = 40;
									}
									$login_uid=session('uid');
									if($login_uid!=$admin_id){//that means user
										$check_email_issue = $this->model->send_email($subject, $description , $admin_id, false,$login_uid);
									}else{
										$check_email_issue = $this->model->send_email($subject, $description , session('uid'), false);
									}
							}
                        //update another server
							$url=base_url()."/api_provider/cron/ticket/".$ticket_number;
							$this->call_cron($url);
							
							
						}else{
							
							if (get_option("is_ticket_notice_email", '')) {
									$subject = $subject;
									$ticket_number = $this->db->insert_id();;
									$subject = get_option("website_name", "") ." - #Ticket"."$ticket_number - $subject";
									$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
									if ($admin_id == "") {
										$admin_id = 40;
									}
									$login_uid=session('uid');
									if($login_uid!=$admin_id){//that means user
										$check_email_issue = $this->model->send_email($subject, $description , $admin_id, false,$login_uid);
									}else{
										$check_email_issue = $this->model->send_email($subject, $description , session('uid'), false);
									}
							}
                        //update another server
							 $url=base_url()."/api_provider/cron/ticket/".$ticket_number;
							 $this->call_cron($url);
						}
						
	 		if (get_role('admin') || get_role('supporter')|| get_role('m-seller')) {
			$ticket_status = get_field($this->tb_tickets, ['id' => $tkid], 'status');
			if (!empty($ticket_status) && $ticket_status == 'new') {
				$this->db->update($this->tb_tickets, ['status' => 'new'], ['id' => $tkid]);
                                //update another server
                                $check_item = $this->model->get("ids,id,api_provider", $this->tb_tickets, "id = '{$tkid}'");
                                $url=base_url()."/api_provider/cron/ticket/".$tkid;
                                if($check_item->api_provider !="NULL" && $check_item->api_provider !=null && $check_item->api_provider !="null" ){
                                    $url=base_url()."/api_provider/cron/ticket/".$tkid."/0/false";
                                }
                                $this->call_cron($url);
			}
			$this->db->update($this->tb_tickets, ['status' => 'new','api_uid'=>session('uid')], ['id' => $tkid]);
		}

		$ticket = $this->model->get_ticket_detail($tkid);
		if (!empty($ticket)) {
			$ticket_content = $this->model->get_ticket_content($tkid);
			/*----------  Exchange ticket status to read  ----------*/
			 if (!empty($ticket_content)) {
				$end_ticket_message = end($ticket_content);
				if ($end_ticket_message->uid != session('uid')) {
					$this->db->update($this->tb_ticket_message, ['is_read' => 0], ['ticket_id' => $end_ticket_message->ticket_id]);
				}
				if(get_role("m-seller")||get_role("admin")) {
					if ($end_ticket_message->uid == session('uid')) {
						$this->db->update($this->tb_ticket_message, ['is_read' => 0], ['ticket_id' => $end_ticket_message->ticket_id]);
					}	
				} 
			} 

			
		 } 	

			ms(array(
				"status"  => "success",
				"message" => lang("ticket_created_successfully")
			));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
			));
		}
	}

	public function ajax_update($ids) {

		$message = post("message");
		
                if($message == "") {
                    ms(array(
                            "status"  => "error",
                            "message" => lang('message_is_required')
                    ));
		}
                
        //upload a file
                $file_link="";
                if(isset($_FILES["attach_file"]["name"]) && $_FILES['attach_file']['name'] != null) {

                    $maxsize = 20971520;
                    if(($_FILES['attach_file']['size'][0] >= $maxsize) || ($_FILES["attach_file"]["size"][0] == 0)) {
                        ms(array(
                            "status"  => "error",
                            "message" => lang('unsupported_file_size')
                        ));
                    }
                    $target_dir = FCPATH."assets/uploads/ticket_file/";
                    $target_file = $target_dir . basename($_FILES["attach_file"]["name"][0]);
                    if(move_uploaded_file($_FILES["attach_file"]["tmp_name"][0], $target_file)){
                        $file_link=base_url()."/assets/uploads/ticket_file/".$_FILES["attach_file"]["name"][0];
                    }
                    
                }
		//data
		$data = array(
			"ids"	          => ids(),
			"uid"             => 40,
			"message"         => $message,
			"file_link"       => $file_link,
			"is_read"         => 0,
			"api_uid" 		  => session('uid'),
			"created"         => NOW,
			"changed"         => NOW,
		);

		$check_item = $this->model->get("ids, id, uid, subject,api_provider", $this->tb_tickets, "ids = '{$ids}'");
        if($check_item->api_provider != "NULL" && $check_item->api_provider !=null && $check_item->api_provider != "null" ) {
            $data["uid"] = 0;//
            $data["is_read"] = 0;//
        }

        $sess_id = trim(session('uid'));     

		if(!empty($check_item)) {
			$data["ticket_id"] = $check_item->id;
			$this->db->insert($this->tb_ticket_message, $data);
			
			if ($this->db->affected_rows() > 0) {

				/*----------  Update time for changed in Tickets  ----------*/
				$this->db->update($this->tb_tickets, ["changed" => NOW], ["id" => $check_item->id]);
                                
                //update another server
                $url = base_url()."/api_provider/cron/ticket/".$check_item->id;

                if($check_item->api_provider !="NULL" && $check_item->api_provider !=null && $check_item->api_provider !="null" ) {
                    $url = base_url()."/api_provider/cron/ticket/".$check_item->id."/0/false";
                }

               	$this->call_cron($url);
                              
				/*----------  Send email notification to new user  ----------*/
				if(get_role("m-seller")) {

					if (get_option("is_ticket_notice_email_".$sess_id, '')) {
						$subject = $check_item->subject;
						$ticket_number = $check_item->id;
						$check_item->uid;	
						
						$subject = get_option("website_name", "") ." - #Ticket"."$ticket_number - $subject";
											$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
											if ($admin_id == "") {
												$admin_id = 40;
											}
											$login_uid=session('uid');
											if($login_uid!=$admin_id){//that means user
												$check_email_issue = $this->model->send_email($subject, $message , $admin_id, false,$login_uid);
											}else{
												$check_email_issue = $this->model->send_email($subject, $message , $check_item->uid, false);
											}
						if ($check_email_issue) {
							ms(array(
								"status"  => "error",
								"message" => $check_email_issue,
							));
						}
					}
				}
				else {
					
					if (get_option("is_ticket_notice_email", '')) {
						$subject = $check_item->subject;
						$ticket_number = $check_item->id;
						$check_item->uid;
						
						
						$subject = get_option("website_name", "") ." - #Ticket"."$ticket_number - $subject";
											$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
											if ($admin_id == "") {
												$admin_id = 40;
											}
											$login_uid=session('uid');
											if($login_uid!=$admin_id){//that means user
												$check_email_issue = $this->model->send_email($subject, $message , $admin_id, false,$login_uid);
											}else{
												$check_email_issue = $this->model->send_email($subject, $message , $check_item->uid, false);
											}
						if ($check_email_issue) {
							ms(array(
								"status"  => "error",
								"message" => $check_email_issue,
							));
						}
					}
				}
				ms(array(
					"status"  => "success",
					"message" => lang("your_email_has_been_successfully_sent_to_user")
				));
			}
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
			));
		}
	}
	
	public function ajax_change_status($ids){
		$status = post("status");
		$check_item = $this->model->get("ids,id,api_provider", $this->tb_tickets, "ids = '{$ids}'");
		if(!empty($check_item)){
			$data["status"]  = $status;
			$data["changed"] = NOW;
			$this->db->update($this->tb_tickets, $data, ["ids" => $ids]);
			if ($this->db->affected_rows() > 0) {
                               //update another server
                                $url=base_url()."/api_provider/cron/ticket/".$check_item->id;
                                if($check_item->api_provider !="NULL" && $check_item->api_provider !=null && $check_item->api_provider !="null" ){
                                    $url=base_url()."/api_provider/cron/ticket/".$check_item->id."/0/false";
                                }
                                $this->call_cron($url);
				ms(array(
					"status"  => "success",
					"message" => lang("Update_successfully")
				));
			}
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
			));
		}
	}

	public function ajax_search(){
		$k = post("k");
		$tickets = $this->model->get_search_tickets($k);
		$data = array(
			"module"     => get_class($this),
			"tickets" => $tickets,
		);
		$this->load->view("ajax_search", $data);
	}

	public function ajax_order_by($status = ""){
		if (!empty($status) && $status !="" ) {
			$tickets = $this->model->get_tickets(false, $status);
			$data = array(
				"module"     => get_class($this),
				"tickets" 	 => $tickets,
			);
			$this->load->view("ajax_search", $data);
		}
	}

	public function ajax_delete_item($ids = ""){
		$this->model->delete($this->tb_tickets, $ids, false);
	}
        
    public function call_cron($url,$is_post=false,$data=array()) {

		ini_set('max_execution_time', 300000);
	     $curl = curl_init();
		// Set some options - we are passing in a useragent too here
		//for get request
		if(!$is_post){
		    curl_setopt_array($curl, [
		        CURLOPT_RETURNTRANSFER => 1,
		        CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
		        CURLOPT_URL => $url,
		    ]);
		}else{
		    curl_setopt_array($curl, [
		        CURLOPT_RETURNTRANSFER => 1,
		        CURLOPT_URL => $url,
		        CURLOPT_POST => 1,
		        CURLOPT_POSTFIELDS => $data
		    ]);
		}

	    $response = curl_exec($curl);
	    print_r($response);
	    $err = curl_error($curl);
	    print_r($err);
	    curl_close($curl);
	}
}

