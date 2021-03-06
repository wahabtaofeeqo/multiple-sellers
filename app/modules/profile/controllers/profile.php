<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class profile extends MX_Controller {
	public $tb_users;
	public $module_name;
	public $module_icon;
	public $tb_users_files;
	
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->tb_users = USERS;
		$this->tb_users_files = 'users_files';
	}

	public function index(){		
		
		$data = array(
			"module"       => get_class($this),
			"user"         => $this->model->get('*', $this->tb_users, "id = '".session('uid')."'"),
			"files"        => $this->model->user_files()
		);
		$this->template->build('index', $data);
	}

	public function ajax_update($ids = ''){
		$id                 = session('uid');
		$first_name         = post('first_name');
		$last_name          = post('last_name');
		
		$email              = post('email');
		$password           = post('password');
		$re_password        = post('re_password');
		$timezone           = post('timezone');

		if($first_name == '' || $last_name == ''){
			ms(array(
				'status'  => 'error',
				'message' => lang("please_fill_in_the_required_fields"),
			));
		}

		$data = array(
			"first_name"              => $first_name,
			"last_name"               => $last_name,
			"timezone"                => $timezone,
			"changed"                 => NOW,
		);

		if($password != ''){
			if($password == ''){
				ms(array(
					'status'  => 'error',
					'message' => lang("Password_is_required"),
				));
			}

			if(strlen($password) < 6){
				ms(array(
					'status'  => 'error',
					'message' => lang("Password_must_be_at_least_6_characters_long"),
				));
			}

			if($re_password!= $password){
				ms(array(
					'status'  => 'error',
					'message' => lang("Password_does_not_match_the_confirm_password"),
				));
			}
			$data['password'] = md5($password);
		}

		if($id != ''){
			$checkUser = $this->model->get('id,ids,email',$this->tb_users,"`id` = '{$id}'");

			if(empty($checkUser)){
				ms(array(
					'status'  => 'error',
					'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
				));
			}

			// check email

			if($email == ''){
				ms(array(
					'status'  => 'error',
					'message' => lang("email_is_required"),
				));
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		      	ms(array(
					'status'  => 'error',
					'message' => lang("invalid_email_format"),
				));
		    }

			$checkUserEmail = $this->model->get('email, ids', $this->tb_users,"email='{$email}' AND `id` != '{$id}'");

			if(!empty($checkUserEmail)){
				ms(array(
					'status'  => 'error',
					'message' => lang("An_account_for_the_specified_email_address_already_exists_Try_another_email_address"),
				));
			}

			$data['email']   = $email;

			if($this->db->update($this->tb_users, $data, "id ='{$id}'")){
				ms(array(
					'status'  => 'success',
					'message' => lang('Update_successfully'),
				));
			}
		}else{
			ms(array(
				'status'  => 'error',
				'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
			));
		}
	}

	public function ajax_update_more_infors($ids = ''){
		$id                 = session('uid');
		$website            = post('website');
		$phone              = post('phone');
		$skype_id           = post('skype_id');
		$what_asap          = post('what_asap');
		$address            = post('address');

		$more_information = array(
			"website"         => $website,
			"phone"        	  => $phone,
			"what_asap"       => $what_asap,
			"skype_id"        => $skype_id,
			"address"         => $address,
		);

		$data = array(
			"more_information"        => json_encode($more_information),
			"changed"                 => NOW,
		);

		if($id != ''){
			$checkUser = $this->model->get('id,ids,email',$this->tb_users,"`id` = '{$id}'");

			if(empty($checkUser)){
				ms(array(
					'status'  => 'error',
					'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
				));
			}

			if($this->db->update($this->tb_users, $data, "id ='{$id}'")){
				ms(array(
					'status'  => 'success',
					'message' => lang('Updated_successfully'),
				));
			}
		}else{
			ms(array(
				'status'  => 'error',
				'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
			));
		}
	}

	public function ajax_update_api($ids = ''){
		$id                 = session('uid');

		$api_key = create_random_string_key(32);
		$data = array(
			"api_key"         => $api_key,
			"changed"         => NOW,
		);

		if($id != ''){

			$checkUser = $this->model->get('id,ids,api_key', $this->tb_users,"`id` = '{$id}'");
			$checkApi_key = $this->model->get('id,ids,api_key', $this->tb_users,"`api_key` = '{$api_key}'");
			if(empty($checkUser) || !empty($checkApi_key)){
				ms(array(
					'status'  => 'error',
					'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
				));
			}

			if($this->db->update($this->tb_users, $data, "id ='{$id}'")){
				ms(array(
					'status'  => 'success',
					'message' => lang('Update_successfully'),
				));
			}
		}else{
			ms(array(
				'status'  => 'error',
				'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
			));
		}
	}
public function ajax_files(){
			
		if(isset($_FILES["profile_image"]["name"])){                   
					
					
					    $dirName=md5(session('uid'));
						$target_dir = FCPATH."assets/uploads/users/".$dirName."/";
						if (!file_exists($target_dir)) {
								mkdir($target_dir, 0777, true);
						}
					
					
					 $imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"][0],PATHINFO_EXTENSION));
					$mediatype=0;
					if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"
						|| $imageFileType == "doc" || $imageFileType == "pdf"){
						
						$mediatype=$imageFileType;	
					}else{}
                   
					$target_file = $target_dir . basename($_FILES["profile_image"]["name"][0]);
					$file_path=0;
                    if(move_uploaded_file($_FILES["profile_image"]["tmp_name"][0], $target_file)){
                        $file_link=base_url()."/assets/uploads/users/".$dirName.'/'.$_FILES["profile_image"]["name"][0];
                        $file_path=$_SERVER['SERVER_NAME']."/assets/uploads/users/".$dirName.'/'.$_FILES["profile_image"]["name"][0];
                    } 
									
					$data = array(
						"media_id"     => $dirName,
						"name"         => $_FILES["profile_image"]["name"][0],
						"file_path"    => $file_path,
						"uid"          => session('uid'),
						"type"         => $mediatype,
						"changed"         => NOW,
						"created"         => NOW,
					);
					
					$this->db->insert($this->tb_users_files, $data); 
					 $return_arr[]= array("msg" => 'success','link'=>$file_path,'type'=>$mediatype);
					
					echo json_encode($return_arr); 
					
					
                    
		 } 
		
	}
	
	public function remove_files(){
		
		$data["name"] =trim(post("image"));
		$data["uid"] =session('uid');
		$this->db->delete($this->tb_users_files, $data);		
	
		$path=FCPATH."assets/uploads/users/".md5(session('uid'))."/".trim(post("image"));
		unlink($path);
		
		$return_arr[]= array(
			"msg" =>'success'
		);
		
		echo json_encode($return_arr);
	}
}