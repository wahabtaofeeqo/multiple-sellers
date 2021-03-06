<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class stripe extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $stripeapi;
	public $payment_type;
	public $currency_code;
	public $mode;

	public function __construct(){
		parent::__construct();
		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->payment_type		   = "stripe";
		
		
		$id=trim(session("seller_id"));
		if (isset($id)) {
			$this->mode 			   = get_option("payment_environment_".$id, "");
			$this->currency_code       = (get_option("currency_code_".$id, "USD") == "")? 'USD' : get_option("currency_code", "");
			$this->load->library("stripeapi");
			$this->stripeapi = new stripeapi(get_option('stripe_secret_key_'.$id,""), get_option('stripe_publishable_key_'.$id,""), $this->mode);
			
		}else{	
			$this->mode 			   = get_option("payment_environment", "");
			$this->currency_code       = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "");
			$this->load->library("stripeapi");
			$this->stripeapi = new stripeapi(get_option('stripe_secret_key',""), get_option('stripe_publishable_key',""), $this->mode);
		}
		
		
	}

	public function index(){
		redirect(cn("add_funds"));
	}

	/**
	 *
	 * Create payment
	 *
	 */
	public function create_payment(){
		$amount = session("amount");
		$token  = post("stripeToken");
		
		if(!empty($token)){
			// Card info
			$card_num       = post('card_num');
			$card_cvv       = post('cvv');
			$card_exp_month = post('exp_month');
			$card_exp_year  = post('exp_year');
			
			// Buyer info
			$data_buyer_info = array(
				"source" 		  => $token,
				"email" 	  => post('email'),
			);

			//add customer to stripe
			$customer = $this->stripeapi->customer_create($data_buyer_info);
			
			// Item info
			$itemName   = (get_option("website_name","") == "")? "SmartPanel" : get_option("website_name","");
			$itemNumber = 'SMMPANEL9271';
			$orderID    = 'SKA92712382139';//charge a credit or a debit card.
			
			$sell_id=trim(session("seller_id"));
			$data_charge = array(
				'customer'     => $customer->id,
		        'amount'       => $amount*100,
		        'currency'     => strtolower($this->currency_code),
		        'description'  => $itemName,
		        'metadata'     => array(
		            'order_id' => $orderID
		        )
			);

			//charge a credit or a debit card
		    $result = $this->stripeapi->create_payment($data_charge);
		    
			if (!empty($result) && $result->status == 'success') {
				/*----------  Insert to Transaction table  ----------*/
				$response = $result->response;
				unset_session("amount");
				$data = array(
					"ids" 				=> ids(),
					"uid" 				=> trim(session('seller_id')),
					"type" 				=> $this->payment_type,
					"transaction_id" 	=> $response->id,
					"amount" 	        => $amount,
					"created" 			=> NOW,
				);

				$this->db->insert($this->tb_transaction_logs, $data);
				$transaction_id = $this->db->insert_id();

				/*----------  Add funds to user balance  ----------*/
				if (isset($sell_id)) {
					$user_balance = get_field($this->tb_users, ["id" => $sell_id], "balance");
					$user_balance += session('real_amount');
					$this->db->update($this->tb_users, ["balance" => $user_balance], ["id" => $sell_id]);
					unset_session("real_amount");
				}else{
					$user_balance = get_field($this->tb_users, ["id" => session("uid")], "balance");
					$user_balance += session('real_amount');
					$this->db->update($this->tb_users, ["balance" => $user_balance], ["id" => session("uid")]);
					unset_session("real_amount");
				}

				/*----------  Send payment notification email  ----------*/
				
				
				
				if (isset($sell_id)) {
				
					if (get_option("is_payment_notice_email_".$sell_id, '')) {
						$CI = &get_instance();
						if(empty($CI->payment_model)){
							$CI->load->model('model', 'payment_model');
						}
						$check_send_email_issue = $CI->payment_model->send_email(get_option('email_payment_notice_subject', ''), get_option('email_payment_notice_content', ''), $sell_id);
						if($check_send_email_issue){
							ms(array(
								"status" => "error",
								"message" => $check_send_email_issue,
							));
						}
					}
				}else{
					if (get_option("is_payment_notice_email", '')) {
						$CI = &get_instance();
						if(empty($CI->payment_model)){
							$CI->load->model('model', 'payment_model');
						}
						$check_send_email_issue = $CI->payment_model->send_email(get_option('email_payment_notice_subject', ''), get_option('email_payment_notice_content', ''), session('uid'));
						if($check_send_email_issue){
							ms(array(
								"status" => "error",
								"message" => $check_send_email_issue,
							));
						}
					}
				}	
				set_session("transaction_id", $transaction_id);
				redirect(cn("add_funds/success"));
			}else{
				redirect(cn("add_funds/unsuccess"));
				unset_session("seller_id");
			}
	
		}else{
			redirect(cn("add_funds"));
		}
	}
}