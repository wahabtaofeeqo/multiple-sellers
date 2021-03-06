<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class add_funds extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
	}

	public function index() {
		unset_session('mseller');
		$this->db->select('*');
		$this->db->where('role','m-seller');
		$res_img = $this->db->get($this->tb_users);
		$mSellers = $res_img->result_array();
		$data = array(
			"module"        => get_class($this),
			"mSellers"   => $mSellers,
			"mSelle"   => post('id'),
			
		);

		$this->template->build('index', $data);
	}

	public function invoice($id = "") {
		$data = array();
		$this->load->view('invoice', $data);
	}
    public function set_funds(){
		$this->db->select('*');
		$this->db->where('role','m-seller');
		$res_img = $this->db->get($this->tb_users);
		$mSellers = $res_img->result_array();
		$data = array(
			"module"        => get_class($this),
			"mSellers"   => $mSellers,
			"mSelle"   => post('id'),
			
		);

		$this->load->view('index', $data);
	}
	public function process(){
		$amount = post("amount");
		$agree  = post("agree");
		$payment_method = post('payment_method');
		$seller=trim(post('payment_user'));
		
		if ($amount  == "") {
			ms(array(
				"status"  => "error",
				"message" => lang("amount_is_required"),
			));
		}

		if ($amount  < 0) {
			ms(array(
				"status"  => "error",
				"message" => lang("amount_must_be_greater_than_zero"),
			));
		}

		/*----------  Get Min ammout  ----------*/
		if (isset($seller)) {
			$min_ammount = get_option($payment_method."_payment_transaction_min_".$seller);
			
			
			if ($min_ammount < 0 || $min_ammount == "") {
			   $min_ammount = get_option('payment_transaction_min_'.$seller);
		    }
		}else{
			
			$min_ammount = get_option($payment_method."_payment_transaction_min");
			if ($min_ammount < 0 || $min_ammount == "") {
			   $min_ammount = get_option('payment_transaction_min');
		    }
			
		}
		
		

		if ($amount  < $min_ammount) {
			ms(array(
				"status"  => "error",
				"message" => lang("minimum_amount_is")." ".$min_ammount,
			));
		}

		if (!$agree) {
			ms(array(
				"status"  => "error",
				"message" => lang("you_must_confirm_to_the_conditions_before_paying")
			));
		}

		
		$transaction_fee = 0;
		if ($payment_method != "") {
			$transaction_fee = get_option($payment_method."_chagre_fee", 4);
		}
		
		$total_amount = $amount - (($amount*$transaction_fee)/100) - 0.3;
		set_session("real_amount", $amount);
		set_session("amount", (float)$total_amount);
		set_session("seller_id", $seller);
		ms(array(
			"status" => "success",
			"message" => lang("processing_"),
		));
	}

	public function two_checkout_form(){
		 
		$data = array(
			"module"        => get_class($this),
			"amount"        => session('amount'),
		);
		$this->template->build('2checkout_form', $data);
	}

	public function stripe_form(){
		$data = array(
			"module"        => get_class($this),
			"amount"        => session('amount'),
		);
		$this->template->build('stripe_form', $data);
	}

	public function success(){
		$id = session("transaction_id");
		
		$sellerid=trim(session("seller_id"));
		if (isset($sellerid)) {
			$seid=$sellerid;
		}else{
			$seid=session('uid');
		}
		
		$transaction = $this->model->get("*", $this->tb_transaction_logs, "id = '{$id}' AND uid ='".$seid."'");
		if (!empty($transaction)) {
			$data = array(
				"module"        => get_class($this),
				"transaction"   => $transaction,
			);
			unset_session("transaction_id");
			unset_session("seller_id");
			$this->template->build('payment_successfully', $data);
		}else{
			redirect(cn("add_funds"));
		}
	}

	public function unsuccess(){
		$data = array(
			"module"        => get_class($this),
		);
		$this->template->build('payment_unsuccessfully', $data);
	}

}