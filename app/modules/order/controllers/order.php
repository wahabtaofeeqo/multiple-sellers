<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class order extends MX_Controller {
	public $tb_users;
	public $tb_order;
	public $tb_categories;
	public $tb_services;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->tb_users               = USERS;
		$this->tb_order               = ORDER;
		$this->tb_categories          = CATEGORIES;
		$this->tb_services            = SERVICES;
		$this->module_name            = 'Order';
		$this->module_icon            = "fa ft-users";

		$this->columns = array(
			"order_id"                  => lang("order_id"),
			"order_basic_details"       => lang("order_basic_details"),
			"created"                   => lang("Created"),
			"status"                    => lang("Status"),
		);
		
		if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
			$this->columns = array(
				"order_id"                  => lang("order_id"),
				"api_order_id"              => lang("api_orderid"),
				"uid"                       => lang("User"),
				"order_basic_details"       => lang("order_basic_details"),
				"description"       => lang("Description"),
				"created"                   => lang("Created"),
				"status"                    => lang("Status"),
				"comment"                  => lang("Comment"),
				"response"                  => lang("API_Response"),
				"action"                    => lang("Action"),
			);
		}

	}

	// ADD
	public function index(){
		redirect(cn("order/add"));
	}

	public function add() {
		$categories = $this->model->get_categories_list();
                $sub_categories = $this->model->get_sub_category_lists();
                $second_sub_categories = $this->model->get_second_sub_category_lists();
				//$service=$this->model->get_service_all();
		$services_by_cate = "";
		if (!empty($categories)) {
			$category_item_default = $categories[0];
			$services_by_cate = $this->model->get_services_list_by_cate($category_item_default->id);
		}
		$data = array(
			"module"       => get_class($this),
			'categories'   => $categories,
			'services'     => $service,
			'sub_categories'     => $sub_categories,
			'second_sub_categories'     => $second_sub_categories
		);
		$this->template->build('add/add', $data);
	}

	public function get_services($id = ""){
		$check_category = $this->model->check_record("id", $this->tb_categories, $id, false, false);
		if ($check_category) {
			$services    = $this->model->get_services_by_cate($id);
			$data = array(
				"module"   		=> get_class($this),
				"services" 		=> $services,
			);
			$this->load->view('add/get_services', $data);
		}		
	}
	public function get_services_by_sub_cat($id = ""){
		$check_category = $this->model->check_record("id", "sub_categories", $id, false, false);
		if ($check_category) {
			$services    = $this->model->get_services_by_sub_cate($id);
			
			$data = array(
				"module"   		=> get_class($this),
				"services" 		=> $services,
			);
			$this->load->view('add/get_services', $data);
			
		}		
	}
	public function get_services_by_second_sub_cat($id = ""){
		$check_category = $this->model->check_record("id", "second_sub_categories", $id, false, false);
		if ($check_category) {
			$services    = $this->model->get_services_by_second_sub_cate($id);
			
			$data = array(
				"module"   		=> get_class($this),
				"services" 		=> $services,
			);
			$this->load->view('add/get_services', $data);
			
		}		
	}
	public function get_sub_categories_by_cat($id = ""){
		$check_category = $this->model->check_record("id", $this->tb_categories, $id, false, false);
		if ($check_category) {
		   
			$subcategories    = $this->model->get_sub_categories_by_cate($id);
			$data = array(
				"module"   		=> get_class($this),
				"subcategories" 		=> $subcategories,
			);
			$this->load->view('add/get_sub_catagories', $data);
		}		
	}
	public function get_second_sub_categories_by_cat($id = ""){
		$check_category = $this->model->check_record("id", "sub_categories", $id, false, false);

		if ($check_category) {
                        //error_log(print_r("ok",true),3,"/home/test/test.log");
			$subcategories    = $this->model->get_second_sub_categories_by_cate($id);
                        //error_log(print_r($subcategories,true),3,"/home/test/test.log");
			$data = array(
				"module"   		=> get_class($this),
				"second_subcategories" 		=> $subcategories,
			);
			$this->load->view('add/get_second_sub_catagories', $data);
		}		
	}

	public function get_service($id = ""){
		$check_service    = $this->model->get_service_item($id);
		// if (empty($check_service)) {
		// 	ms(array(
		// 		"status"  => "error",
		// 		"message" => lang("service_does_not_exists")
		// 	));
		// }

		$data = array(
			"module"   		=> get_class($this),
			"service" 		=> $check_service,
		);
		$this->load->view('add/get_service', $data);
	}

	public function ajax_add_order(){
		$api_provider_id    = post("api_provider_id");
		$api_service_id 	= post("api_service_id");
		$service_id 		= post("service_id");
		$cate_id 		    = post("category_id");
		$quantity 		    = post("quantity");
		$link 		        = "NULL";
                $description=post("desc");
		$runs               = post("runs");
		$interval           = post("interval");
		$is_drip_feed       = (post("is_drip_feed") == "on") ? 1 : 0;
		$agree 		        = (post("agree") == "on") ? 1 : 0;
		$service_type 	    = post("service_type");
		$sub_cate 	    = post("sub_cate_id");

		if ($cate_id == "") {
			ms(array(
				"status"  => "error",
				"message" => lang("please_choose_a_category")
			));
		}	
		if ($sub_cate == "") {
			ms(array(
				"status"  => "error",
				"message" => lang("please_choose_a_category")
			));
		}	

		if ($service_id == "") {
			ms(array(
				"status"  => "error",
				"message" => lang("please_choose_a_service")
			));
		}

		$check_category = $this->model->check_record("*", $this->tb_categories, $cate_id, false, true);
		$check_service  = $this->model->check_record("*", $this->tb_services, $service_id, false, true);
		if (empty($check_category)) {
			ms(array(
				"status"  => "error",
				"message" => lang("category_does_not_exists")
			));
		}

		if (empty($check_service)) {
			ms(array(
				"status"  => "error",
				"message" => lang("service_does_not_exists")
			));
		}
		/*----------  Add all order without quantity  ----------*/
		if ($service_type == "subscriptions") {
			$this->add_order_subscriptions($_POST);
			exit();
		}

		switch ($service_type) {

			case 'custom_comments':
				$comments = post("comments");
				if ($comments == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("comments_field_is_required")
					));
				}
				$quantity = count(explode(",", $comments));
				break;

			case 'mentions_custom_list':
				$usernames_custom = post("usernames_custom");
				if ($usernames_custom == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("username_field_is_required")
					));
				}
				$quantity = count(explode(",", $usernames_custom));
				break;

			case 'package':
				$quantity = 1;
				break;

			case 'custom_comments_package':
				$comments = post("comments_custom_package");
				if ($comments == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("comments_field_is_required")
					));
				}
				$quantity = 1;
				break;
		}


		if ($quantity == "") {
			ms(array(
				"status"  => "error",
				"message" => lang("quantity_is_required")
			));
		}
		
		/*----------  Check dripfeed  ----------*/
		if ($is_drip_feed) {

			if ($runs == "") {
				ms(array(
					"status"  => "error",
					"message" => lang("runs_is_required")
				));
			}
			
			if ($interval == "") {
				ms(array(
					"status"  => "error",
					"message" => lang("interval_time_is_required")
				));
			}

			if ($runs > 60) {
				ms(array(
					"status"  => "error",
					"message" => lang("interval_time_must_to_be_less_than_or_equal_to_60_minutes")
				));
			}
			$total_quantity = $runs * $quantity;
		}else{
			$total_quantity = $quantity;
		}
		
		/*----------  Check quantity  ----------*/
		if (!empty($check_service)) {
			$min          = $check_service->min;
			$max          = $check_service->max;
			$price        = $check_service->price;
			if ($service_type == "package" || $service_type == "custom_comments_package") {
				$total_charge = $price;
			}else{
				$total_charge = ($price*$total_quantity)/1;
			}
			
			if ($total_quantity <= 0 || ($total_quantity < $min) || $quantity < $min) {
				ms(array(
					"status"  => "error",
					"message" => lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount")
				));
			}	
					
			if ($total_quantity > $max) {
				ms(array(
					"status"  => "error",
					"message" => lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount")
				));
			}
		}
		/*----------  Set custom rate for each user  ----------*/
		$user = $this->model->get("balance, custom_rate", $this->tb_users, ['id' => session('uid')]);
		if (isset($user->custom_rate) && $user->custom_rate > 0) {
			$total_charge = $total_charge - (($total_charge*$user->custom_rate)/100);
		}else{
			$total_charge = $total_charge;
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

		/*----------  Collect data import to database  ----------*/
		$data = array(
			"ids" 	        	=> ids(),
			"uid" 	        	=> session("uid"),
			"cate_id" 	    	=> $cate_id,
			"sub_cat_id" 	    	=> $sub_cate,
			"service_id" 		=> $service_id,
			"service_type" 		=> $service_type,
			"link" 	        	=> $link,
			"description" 	        => $description,
			"file_link" 	        => $file_link,
			"quantity" 	    	=> $total_quantity,
			"charge" 	    	=> $total_charge,
			"api_provider_id"  	=> $api_provider_id,
			"api_service_id"  	=> $api_service_id,
			"is_drip_feed"  	=> $is_drip_feed,
			"status"			=> 'pending',
			"changed" 	    	=> NOW,
			"created" 	    	=> NOW,
		);
		/*----------  get the different required paramenter for each service type  ----------*/
		switch ($service_type) {

			case 'mentions_with_hashtags':
				$hashtags  = post("hashtags");
				$usernames = post("usernames");

				if ($usernames == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("username_field_is_required")
					));
				}

				if ($hashtags == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("hashtag_field_is_required")
					));
				}
				$data["usernames"] = $usernames;
				$data["hashtags"]  = $hashtags;
				break;

			case 'mentions_hashtag':
				$hashtag = post("hashtag");
				if ($hashtag == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("hashtag_field_is_required")
					));
				}
				$data["hashtag"] = $hashtag;
				break;	

			case 'comment_likes':
				$username = post("username");
				if ($username == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("username_field_is_required")
					));
				}

				$data["username"] = $username;
				break;	
							
			case 'mentions_user_followers':
				$username = post("username");
				if ($username == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("username_field_is_required")
					));
				}

				$data["username"] = $username;
				break;		

			case 'mentions_media_likers':
				$media_url = post("media_url");

				if ($media_url == "" || !filter_var($media_url, FILTER_VALIDATE_URL)) {
				    ms(array(
						"status"  => "error",
						"message" => lang("invalid_link")
					));
				}
				$data["media"] = $media_url;
				break;

			case 'custom_comments':
				$data["comments"] = json_encode(str_replace(",", "\n", $comments));
				break;

			case 'custom_comments_package':
				$data["comments"] = json_encode(str_replace(",", "\n", $comments));
				break;

			case 'mentions_custom_list':
				$data["usernames"] = json_encode(str_replace(",", "\n", $usernames_custom));
				break;

		}
		// Check agree
		if (!$agree) {
			ms(array(
				"status"  => "error",
				"message" => lang("you_must_confirm_to_the_conditions_before_place_order")
			));
		}
		// check balance
		if(!get_role("m-seller")){
			if ($user->balance != 0 && $user->balance < $total_charge || $user->balance == 0) {
				ms(array(
					"status"  => "error",
					"message" => lang("not_enough_funds_on_balance")
				));
			}
		}

		if ($is_drip_feed) {
			$data['runs'] = $runs;
			$data['interval'] = $interval;
			$data['dripfeed_quantity'] = $quantity;
			$data['status'] = 'inprogress';
		}

		if (!empty($api_provider_id) && !empty($api_service_id)) {
			$data['api_order_id'] = -1;
		}
		$this->save_order($this->tb_order, $data, $user->balance, $total_charge);
	}

	private function add_order_subscriptions($post){
		$api_provider_id    = $post["api_provider_id"];
		$api_service_id 	= $post["api_service_id"];
		$service_id 		= $post["service_id"];
		$cate_id 		    = $post["category_id"];
		$agree 		        = (isset($post['agree']) && $post["agree"] == "on") ? 1 : 0;
		$service_type 	    = $post["service_type"];
		$link 		        = $post["link"];

		/*----------  check service   ----------*/
		$check_service  = $this->model->check_record("*", $this->tb_services, $service_id, false, true);

		/*----------  Collect data import to database  ----------*/
		$data = array(
			"ids" 	        	=> ids(),
			"uid" 	        	=> session("uid"),
			"cate_id" 	    	=> $cate_id,
			"service_id" 		=> $service_id,
			"service_type" 		=> $service_type,
			"api_provider_id"  	=> $api_provider_id,
			"api_service_id"  	=> $api_service_id,
			"sub_status"  	    => 'Active',
			"status"  	        => 'pending',
			"changed" 	    	=> NOW,
			"created" 	    	=> NOW,
		);

		switch ($service_type) {
			case 'subscriptions':
				$username = $post["sub_username"];
				$posts    = (int)$post["sub_posts"];
				$min      = (int)$post["sub_min"];
				$max      = (int)$post["sub_max"];
				$delay    = (int)$post["sub_delay"];
				$expiry   = $post["sub_expiry"];

				if ($username == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("username_field_is_required")
					));
				}

				if ($min == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount")
					));
				}

				if ($min < $check_service->min) {
					ms(array(
						"status"  => "error",
						"message" => lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount")
					));
				}

				if ($max < $min) {
					ms(array(
						"status"  => "error",
						"message" => lang("min_cannot_be_higher_than_max")
					));
				}

				if ($max > $check_service->max) {
					ms(array(
						"status"  => "error",
						"message" => lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount")
					));
				}
				
				if (!in_array($delay, array(0, 5, 10, 15, 30, 60, 90))) {
					ms(array(
						"status"  => "error",
						"message" => lang("incorrect_delay")
					));
				}

				if ($posts <=  0 || $posts == "") {
					ms(array(
						"status"  => "error",
						"message" => lang("new_posts_future_posts_must_to_be_greater_than_or__equal_to_1")
					));
				}

				// Check agree
				if (!$agree) {
					ms(array(
						"status"  => "error",
						"message" => lang("you_must_confirm_to_the_conditions_before_place_order")
					));
				}
				// calculate total charge
				$charge = ($max * $posts * $check_service->price) / 1;
				
				// check balance
				$current_balance = $this->model->check_record("balance", $this->tb_users, session('uid'), false, true);
				if (($current_balance->balance != 0 && $current_balance->balance < $charge) || $current_balance->balance == 0) {
					ms(array(
						"status"  => "error",
						"message" => lang("not_enough_funds_on_balance")
					));
				}
				if ($expiry != "") {
					$expiry = str_replace('/', '-', $expiry);
					$expiry = date("Y-m-d", strtotime($expiry));
				}else{
					$expiry = "";
				}	
				
				$data["username"]     = $username;
				$data["sub_posts"]    = ($posts == "")? -1: $posts;
				$data["sub_min"]      = $min;
				$data["sub_max"]      = $max;
				$data["sub_delay"]    = $delay;
				$data["sub_expiry"]   = $expiry;

				if (!empty($api_provider_id) && !empty($api_service_id)) {
					$data['api_order_id'] = -1;
				}
				
				$this->save_order($this->tb_order, $data);
				break;
		}

	}

	/*----------  insert data to order  ----------*/
	private function save_order($table, $data_orders, $user_balance = "", $total_charge = ""){
		$this->db->insert($table, $data_orders);
		$order_id = $this->db->insert_id();
		if ($this->db->affected_rows() > 0) {

			if ($data_orders["service_type"] != "subscriptions") {
				$new_balance = $user_balance - $total_charge;
				$new_balance = ($new_balance > 0)? $new_balance : 0;
				$this->db->update($this->tb_users, ["balance" => $new_balance], ["id" => session("uid")]);
			}
			/*----------  Send Order notificaltion notice to Admin  ----------*/
			if(get_role("m-seller")){
				if (get_option("is_order_notice_email_".session('uid'), '')) {
					$user_email = $this->model->get("email", $this->tb_users, "id = '".session('uid')."'")->email;

					$subject = getEmailTemplate("order_success")->subject;
					$subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);
					$email_content = getEmailTemplate("order_success")->content;
					$email_content = str_replace("{{user_email}}", $user_email, $email_content);
					$email_content = str_replace("{{order_id}}", $order_id, $email_content);
					$email_content = str_replace("{{currency_symbol}}", get_option("currency_symbol",""), $email_content);
					$email_content = str_replace("{{total_charge}}", $total_charge, $email_content);
					$email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);

					$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
					if ($admin_id == "") {
						$admin_id = 1;
					}
					$check_send_email_issue = $this->model->send_email( $subject, $email_content, $admin_id, false);
					if($check_send_email_issue){
						ms(array(
							"status" => "error",
							"message" => $check_send_email_issue,
						));
					}
				
				}
			}else{
				if (get_option("is_order_notice_email", '')) {
					$user_email = $this->model->get("email", $this->tb_users, "id = '".session('uid')."'")->email;

					$subject = getEmailTemplate("order_success")->subject;
					$subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);
					$email_content = getEmailTemplate("order_success")->content;
					$email_content = str_replace("{{user_email}}", $user_email, $email_content);
					$email_content = str_replace("{{order_id}}", $order_id, $email_content);
					$email_content = str_replace("{{currency_symbol}}", get_option("currency_symbol",""), $email_content);
					$email_content = str_replace("{{total_charge}}", $total_charge, $email_content);
					$email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);

					$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
					if ($admin_id == "") {
						$admin_id = 1;
					}
					$check_send_email_issue = $this->model->send_email( $subject, $email_content, $admin_id, false);
					if($check_send_email_issue){
						ms(array(
							"status" => "error",
							"message" => $check_send_email_issue,
						));
					}
				}
			}
            
            //update another server table.removing cron tab
            $url = base_url()."/api_provider/cron/order";
			$this->call_cron($url);

			ms(array(
				"status"  => "success",
				"message" => lang("place_order_successfully")
			));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
			));
		}
	}
	// MASS ORDER
	public function ajax_mass_order(){
		$mass_order 		= post("mass_order");
		$agree 		        = (post("agree") == "on") ? 1 : 0;
		
		if (!$agree) {
			ms(array(
				"status"  => "error",
				"message" => lang("you_must_confirm_to_the_conditions_before_place_order")
			));
		}

		if ($mass_order == "") {
			ms(array(
				"status"  => "error",
				"message" => lang("field_cannot_be_blank")
			));
		}

		/*----------  get balance and custom_rate   ----------*/
		
		$user = $this->model->get("balance, custom_rate", $this->tb_users, ['id' => session('uid')]);
		
		if ($user->balance == 0) {
			ms(array(
				"status"  => "error",
				"message" => lang("you_do_not_have_enough_funds_to_place_order")
			));
		}
		$total_order  = 0;
		$total_errors = 0;
		$sum_charge = 0;
		$error_details = array();
		$orders = array();
		if (is_array($mass_order)) {
			foreach ($mass_order as $key => $row) {
				$order = explode("|", $row);

				// check format
				$order_count = count($order);
				if ($order_count > 3  || $order_count <= 2) {
					$error_details[$row] = lang("invalid_format_place_order");
					continue;
				}
				$service_id = $order[0];
				$quantity   = $order[1];
				$link       = $order[2];

				// check link
				if (!filter_var($link, FILTER_VALIDATE_URL)) {
				    $error_details[$row] = lang("invalid_link");
					continue;
				}

				// check service id
				$check_service = $this->model->check_record("*", $this->tb_services, $service_id, false, true);
				if (empty($check_service)) {
					$error_details[$row] = lang("service_id_does_not_exists");
					continue;
				}

				// check quantity and balance
				if (!empty($check_service)) {
					$min          = $check_service->min;
					$max          = $check_service->max;
					$price        = $check_service->price;
					$charge       = (float)$price*($quantity/1);

					/*----------  Set custom rate for each user  ----------*/
					if (isset($user->custom_rate) && $user->custom_rate > 0) {
						$charge = $charge - (($charge*$user->custom_rate)/100);
					}else{
						$charge = $charge;
					}
					
					if ($quantity <= 0 || $quantity < $min) {
						$error_details[$row] = lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount");
						continue;
					}	
							
					if ($quantity > $max) {
						$error_details[$row] = lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount");
						continue;
					}
				}

				// Order charge to .00 decimal points
                $charge = number_format($charge, 2, '.', '');
				// every thing is ok
				$orders[] = array(
					"ids" 	            => ids(),
					"uid" 	            => session("uid"),
					"cate_id"           => $check_service->cate_id,
					"service_id"        => $service_id,
					"link" 	            => $link,
					"quantity" 	        => $quantity,
					"charge" 	        => $charge,
					"api_provider_id"  	=> $check_service->api_provider_id,
					"api_service_id"  	=> $check_service->api_service_id,
					"api_order_id"  	=> (!empty($check_service->api_provider_id) && !empty($check_service->api_service_id)) ? -1 : 0,
					"status"			=> 'pending',
					"changed" 	        => NOW,
					"created" 	        => NOW,
				);
				$sum_charge += $charge;
			}

			// check sum_charge and balance
			if ($sum_charge > $user->balance) {
				ms(array(
					"status"  => "error",
					"message" => lang("not_enough_funds_on_balance")
				));
			}
			if (!empty($orders)) {
				$this->db->insert_batch($this->tb_order, $orders);
				$new_balance = $user->balance - $sum_charge;
				$this->db->update($this->tb_users, ["balance" => $new_balance], ["id" => session("uid")]);
			}
		}
		if (!empty($error_details)) {
			$this->load->view("add/mass_order_notification", ["error_details" => $error_details]);
		}else{
			ms(array(
				"status"  => "success",
				"message" => lang("place_order_successfully")
			));
		}

	}

	// LOGS
	public function log($order_status = ""){
		
		
		if ($order_status == "") {
			$order_status = "all";
		}
		
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
			'base_url'           => cn(get_class($this)."/log/".$order_status.$query_string),
			'total_rows'         => $this->model->get_order_logs_list(true, $order_status),
			'per_page'           => $limit_per_page,
			'use_page_numbers'   => true,
			'prev_link'          => '<i class="fe fe-chevron-left"></i>',
			'first_link'         => '<i class="fe fe-chevrons-left"></i>',
			'next_link'          => '<i class="fe fe-chevron-right"></i>',
			'last_link'          => '<i class="fe fe-chevrons-right"></i>',
		);
		$this->pagination->initialize($config);
		$links = $this->pagination->create_links();

		$order_logs = $this->model->get_order_logs_list(false, $order_status, $limit_per_page, $page * $limit_per_page);
		$data = array(
			"module"       => get_class($this),
			"columns"      => $this->columns,
			"order_logs"   => $order_logs,
			"order_status" => $order_status,
			"links"        => $links,
		);

		//print_r($data);

		$this->template->build('logs/logs', $data);
	}

	public function log_update($ids = ""){
		$order    = $this->model->get("*", $this->tb_order, "ids = '{$ids}'");
		$data = array(
			"module"   		=> get_class($this),
			"order" 	    => $order,
		);
		$this->load->view('logs/update', $data);
	}

	public function ajax_logs_update($ids = "") {

		$link = post("link");
		$desc  = post("order_desc");
		/* $start_counter  = post("start_counter");
		$remains 		= post("remains"); */
		$status 		= post("status");
		$attach_path = trim(session("path"));
		
		$desc = trim($desc);
		$desc = stripslashes($desc);
		$desc = htmlspecialchars($desc, ENT_QUOTES);
		
		/* if($link == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("link_is_required")
			));
		} 


		if(!is_numeric($start_counter) && $start_counter != ""){
			ms(array(
				"status"  => "error",
				"message" => lang("start_counter_is_a_number_format")
			));
		}

		if(!is_numeric($remains) && $remains != ""){
			ms(array(
				"status"  => "error",
				"message" => lang("start_counter_is_a_number_format")
			));
		}*/

		$data = array(
			"link" => $link,
			"status" => $status,
			"comment" => $desc,
			"comment_link" => $attach_path,
			"changed" => NOW,
		);

		set_session("path",'');
        $remains=0;
		$check_item = $this->model->get("ids,id, charge, uid, quantity, status", $this->tb_order, "ids = '{$ids}'");

		if(!empty($check_item)) {

			/*----------  If status = refund  ----------*/
			if ($status == "refunded" || $status == "partial" || $status == "cancelled") {
				$charge = $check_item->charge;
				$charge_back = 0;
				$real_charge = 0;

				if ($status == "partial") {
					$charge_back = ($charge * $remains) / $check_item->quantity;
					$real_charge = $charge - $charge_back;
				}

				$user = $this->model->get("id, balance", $this->tb_users, ["id"=> $check_item->uid]);
				if (!empty($user) && !in_array($check_item->status, array('partial', 'cancelled', 'refunded'))) {
					$balance = $user->balance;
					$balance += $charge - $real_charge;
					$this->db->update($this->tb_users, ["balance" => $balance], ["id"=> $check_item->uid]);
				}

				$data['charge'] = $real_charge;
			}

			$this->db->update($this->tb_order, $data, array("ids" => $check_item->ids));			
			//update another server table.removing cron tab
                        $client_arr = $this->model->get_order_client_list($check_item->id);
                        foreach($client_arr as $client) {
                        	
                            $url_host = $client->api_client;
                            if($url_host!='') {
                                $url = "http://$url_host/api_provider/cron/single_status_update/$check_item->id";
                                $this->call_cron($url);	
                            }
                            break;//only one item
                        }
			ms(array(
                "status"  => "success",
				"message" => lang("Update_successfully")
			));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
			));
		}
	}
	
	public function ajax_search(){
		$k = post("k");
		$order_logs = $this->model->get_orders_logs_by_search($k);
		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"order_logs" => $order_logs,
		);
		$this->load->view("logs/ajax_search", $data);
	}	

	public function ajax_order_by($status = ""){
		if (!empty($status) && $status !="" ) {
			$order_logs = $this->model->get_order_logs_list(false, $status);
			$data = array(
				"module"     => get_class($this),
				"columns"    => $this->columns,
				"order_logs" => $order_logs,
			);
			$this->load->view("logs/ajax_search", $data);
		}
	}

	public function ajax_log_delete_item($ids = ""){
		$this->model->delete($this->tb_order, $ids, false);
	}

	public function call_cron($url,$is_post=false,$data=array()){
		ini_set('max_execution_time', 300000);
	     $curl = curl_init();
		// Set some options - we are passing in a useragent too here
		//for get request
		if(!$is_post){
		    curl_setopt_array($curl, [
		        CURLOPT_RETURNTRANSFER => 1,
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
	    $err = curl_error($curl);
	    print_r($err);
	    print_r($response);

	    curl_close($curl);
	    
	}
	
	public function getAll_values(){
		$id=post("id");
		$services=$this->model->get_service_item($id);
		
		echo json_encode($services);
	}
	public function media_update(){
	    set_session("path",'');
		
	     if(isset($_FILES["myfile"]["name"])){
                    $maxsize=20971520;
                    if(($_FILES['myfile']['size'][0] >= $maxsize) || ($_FILES["myfile"]["size"][0] == 0)) {
                        ms(array(
                            "status"  => "error",
                            "message" => lang('unsupported_file_size')
                        ));
                    }
                    $target_dir = FCPATH."assets/uploads/order_file/";
                    $target_file = $target_dir . basename($_FILES["myfile"]["name"][0]);
                    if(move_uploaded_file($_FILES["myfile"]["tmp_name"][0], $target_file)){
                        $file_link=base_url()."/assets/uploads/order_file/".$_FILES["myfile"]["name"][0];
                        set_session("path",$file_link);
                    }
                    
        }
		
    }

}