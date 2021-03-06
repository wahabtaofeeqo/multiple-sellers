<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class services extends MX_Controller {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_services_media;
	public $columns;
	public $module_name;
	public $module_icon;
    public $tb_sub_categories;
    public $tb_second_sub_categories;
	
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_categories = CATEGORIES;
		$this->tb_services   = SERVICES;
		$this->tb_api_providers   = API_PROVIDERS;
		$this->tb_services_media   = services_media;		
		$this->tb_sub_categories = SUB_CATEGORIES;
        $this->tb_second_sub_categories = SECOND_SUB_CATEGORIES;
		$this->module_name   = 'Services';
		$this->module_icon   = "fa ft-users";

		$this->columns = array(
			"name"             => lang("Name"),
			"price"            => lang("rate")."(".get_option("currency_symbol","").")",
			"min_max"          => lang("min__max_order"),
			"media"            => lang("Media"),
			"desc"             => lang("Description"),
		);

        if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
			$this->columns = array(
				"name"             => lang("Name"),
				"add_type"         => lang("Type"),
				"api_service_id"   => lang("api_service_id"),
				"provider"         => lang("api_provider"),
				"price"            => lang("rate")."(".get_option("currency_symbol","").")",
				"min_max"          => lang("min__max_order"),
				"media"            => lang("Media"),
				"desc"             => lang("Description"),
				"dripfeed"         => lang("dripfeed"),
				"status"           => lang("Status"),
			);
		}				
	}

	public function index() {

		if (!session('uid') && get_option("enable_service_list_no_login") != 1) {
			redirect(cn());
		}

        $get = $_GET;
		$all_services = $this->model->get_services_list();

        $sub_categories = $this->model->get_sub_category_lists();		
        $second_sub_categories = $this->model->get_second_sub_category_lists();

        $all_cat = $all_services;
        $all_sub = $sub_categories;
        $all_second_sub=$second_sub_categories;
                
        if(isset($get['cat_id']) && $get['sub_cat_id'] && $get['second_sub_cat_id']) {
                    
            $cat_id = $get['cat_id'];
            $sub_cat_id=$get['sub_cat_id'];
            $second_sub_cat_id=$get['second_sub_cat_id'];
                    
            foreach($all_services as $key => $serv) {
                if($serv->id == $cat_id) {
                    continue;
                }
                else {
                    unset($all_services[$key]);
                }
            }
                    
            foreach($sub_categories as $k => $sub) {
                if($sub->id == $sub_cat_id){
                    continue;
                }
                else {
                    unset($sub_categories[$k]);
                }
            }
                    
            foreach($second_sub_categories as $l => $second_sub) {
                        
                if($second_sub->id==$second_sub_cat_id) {
                    continue;
                }
                else {
                    unset($second_sub_categories[$l]);
            	}
            }
					
        }
        else if(isset($get['cat_id']) && $get['sub_cat_id']) {
                    $cat_id=$get['cat_id'];
                    $sub_cat_id=$get['sub_cat_id'];
                    $second_sub_cat_id=$get['second_sub_cat_id'];
                    foreach($all_services as $key=>$serv){
                        if($serv->id==$cat_id){
                            continue;
                        }else{
                            unset($all_services[$key]);
                        }
                    }
                    foreach($sub_categories as $k=>$sub){
                        if($sub->id==$sub_cat_id){
                            continue;
                        }else{
                            unset($sub_categories[$k]);
                        }
                    }
                     foreach($second_sub_categories as $l=>$second_sub){
                        if($second_sub->id==$second_sub_cat_id){
                            continue;
                        }else{
                            unset($second_sub_categories[$l]);
                        }
                    } 
        }
        else if(isset($get['cat_id'])) {
                    $cat_id=$get['cat_id'];
                    $sub_cat_id=$get['sub_cat_id'];
                    $second_sub_cat_id=$get['second_sub_cat_id'];
                    foreach($all_services as $key=>$serv){
                        if($serv->id==$cat_id){
                            continue;
                        }else{
                            unset($all_services[$key]);
                        }
                    }
                     foreach($sub_categories as $k=>$sub){
                        if($sub->id==$sub_cat_id){
                            continue;
                        }else{
                            unset($sub_categories[$k]);
                        }
                    }
                    foreach($second_sub_categories as $l=>$second_sub){
                        if($second_sub->id==$second_sub_cat_id){
                            continue;
                        }else{
                            unset($second_sub_categories[$l]);
                        }
                    } 
        }
        else {
            $all_services = array();
            $sub_categories = array();
        }
                
		$data = array(
			"module"       => get_class($this),
			"columns"      => $this->columns,
			"all_services" => $all_services,
			"categories"   => $all_services,
			"all_categories" => $all_cat,
            "sub_categories" => $sub_categories,
            "all_sub_categories" => $all_sub,
            "second_sub_categories" => $second_sub_categories,
            "all_second_sub_categories" => $second_sub_categories			
		);

		if (!session('uid')) {
			$this->template->set_layout('general_page');
			$this->template->build("index", $data);
		}

		$this->template->build("index", $data);
	}

	public function update($ids = "") {

	    $lang_current = get_lang_code_defaut();
		$service     = $this->model->get("*", $this->tb_services, "ids = '{$ids}' ");
		$categories  = $this->model->fetch("*", $this->tb_categories, "status = 1", "lang = eng ", 'sort','ASC');
		$api_providers  = $this->model->fetch("*", $this->tb_api_providers, "status = 1", 'id','ASC');
        $sub_categories = $this->model->get_sub_category_lists();	
		$folders = '';
		$second_subcategories = array();
		$media = array();
		
		if(!empty($ids)) {

			$media = $this->model->services_media_display($service->media_url);
			$second_subcategories = $this->model->get_second_sub_category_lists();

			$target_dir = FCPATH."assets/uploads/media/".$ids;
			
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			$folders = $this->folder_size($target_dir);
		}

		$data = array(
			"module"   			=> get_class($this),
			"service" 			=> $service,
			"categories" 		=> $categories,
			"api_providers" 	=> $api_providers,
            "sub_categories" 	=> $sub_categories,
			"second_subcategories"=>$second_subcategories,
		    "media"              =>$media,
			"drsize"             =>$folders
		);
				
		$this->load->view('update', $data);
	}

	public function bulk_update($ids = "") {

		$service     = $this->model->get("*", $this->tb_services, "ids = '{$ids}' ");
		$categories  = $this->model->fetch("*", $this->tb_categories, "status = 1", 'sort','ASC');
                $sub_categories = $this->model->get_sub_category_lists();
		$api_providers  = $this->model->fetch("*", $this->tb_api_providers, "status = 1", 'id','ASC');
		$second_subcategories = $this->model->get_second_sub_category_lists();
		$data = array(
			"module"   			=> get_class($this),
			"service" 			=> $service,
			"categories" 		=> $categories,
			"api_providers" 	=> $api_providers,
            "sub_categories"        =>$sub_categories,
			"second_subcategories"=>$second_subcategories
		);
		$this->load->view('bulk_update', $data);
	}

	public function desc($ids = ""){
		$service    = $this->model->get("id, ids, name, desc,file_link", $this->tb_services, "ids = '{$ids}' ");
		$data = array(
			"module"   		=> get_class($this),
			"service" 		=> $service,
		);
		$this->load->view('descriptions', $data);
	}

	public function ajax_update($ids = "") {
		
	    $lang_current = get_lang_code_defaut();
		$name 		        = post("name");
		$category	        = post("category");
		$sub_category	    = post("sub_cate_id");
		$second_sub_category= post("second_sub_cate_id");
		$min	            = post("min");
		$max	            = post("max");
		$service_type	    = post("service_type");
		$add_type			= post("add_type");
		$price	            = (float)post("price");
		$status 	        = (int)post("status");
		$dripfeed 	        = (int)post("dripfeed");
		$desc 		        = post("desc");
		$lang   = $lang_current->code;
		$desc = trim($desc);
		$desc = stripslashes($desc);

		// $desc = utf8_encode($desc);
		$desc = htmlspecialchars($desc, ENT_QUOTES);
		$maindir = post("dirm");
		$array = explode("/", $maindir);
		//print_r($array);
		//print_r($array);
		$dir = (count($array) > 3) ? $array[3] : '';

		$img_order=post("imgorder");
		if($name == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("name_is_required")
			));
		}

		if($category == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("category_is_required")
			));
		}
		if($sub_category == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("category_is_required")
			));
		}
		if($second_sub_category == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("category_is_required")
			));
		}

		if($min == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("min_order_is_required")
			));
		}

		if($max == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("max_order_is_required")
			));
		}

		if($min > $max){
			ms(array(
				"status"  => "error",
				"message" => lang("max_order_must_to_be_greater_than_min_order")
			));
		}

		if($price == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("price_invalid")
			));
		}

		$decimal_places = get_option("auto_rounding_x_decimal_places", 4);
		if(strlen(substr(strrchr($price, "."), 1)) > $decimal_places || strlen(substr(strrchr($price, "."), 1)) < 0){
			ms(array(
				"status"  => "error",
				"message" => lang("price_invalid_format")
			));
		}

		$service_type_array = array('default', 'subscriptions', 'custom_comments', 'custom_comments_package', 'mentions_with_hashtags', 'mentions_custom_list', 'mentions_hashtag', 'mentions_user_followers', 'mentions_media_likers', 'package', 'comment_likes');

		if (!in_array($service_type, $service_type_array)) {
			ms(array(
				"status"  => "error",
				"message" => 'Service Type invalid format'
			));
		}
                
        
        //upload a file
        $file_link = "";
                
        if(isset($_FILES["attach_file"]["name"])){
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
                $file_link = base_url()."/assets/uploads/ticket_file/".$_FILES["attach_file"]["name"][0];
            }
                    
        }

		$data = array(
			"uid"             => session('uid'),
			"cate_id"         => $category,
			"sub_cat_id"        => $sub_category,
			"second_sub_cat_id" => $second_sub_category,
			"name"            => $name,
			"desc"            => $desc,
			"file_link"       => $file_link,
			"media_url"       => $dir,
			"min"             => $min,
			"type"            => $service_type,
			"max"             => $max,
			"price"           => $price,
			"dripfeed"        => $dripfeed,
			"status"          => $status,
			"lang"            => $lang
		);

		/*----------  Fields for Service API type  ----------*/
		switch ($add_type) {
			case 'api':
				$api_provider_id	 = post("api_provider_id");
				$api_service_id	     = post("api_service_id");
				$api = $this->model->get("ids", $this->tb_api_providers, ['id' => $api_provider_id, 'status' => 1]);
				if (empty($api)) {
					ms(array(
						"status"  => "error",
						"message" => lang("api_provider_does_not_exists")
					));
				}

				if ($api_service_id == "") {
					ms(array(
						"status"  => "error",
						"message" => 'API Service ID invalid format'
					));
				}
				$data['api_provider_id'] = $api_provider_id;
				$data['api_service_id']  = $api_service_id;
				break;
			
			default:
				$data['api_provider_id'] = "";
				$data['api_service_id']  = "";
				break;
		}
		
		$data['add_type'] = $add_type;
		$check_item = $this->model->get("ids", $this->tb_services, "id = '{$ids}'");
		$idup;

		if(empty($check_item)){

			$data["ids"]     = ids();
			$data["changed"] = NOW;
			$data["created"] = NOW;

			//$this->db->insert($this->tb_services, $data);
		
			$insert_id = $this->model->findOrCreateService($data); //$this->db->insert_id();
			$data_service_up["api_service_id"] = $insert_id;

			$this->db->update($this->tb_services, $data_service_up, ["id" => $insert_id]);
			$check_item = $this->model->get("ids", $this->tb_services, ['id' => $insert_id]);
			$type = 0;
			$idup = $check_item->ids;
			$this->folderExs($check_item->ids, $maindir, $type, $img_order);
		}
		else {

			$idup = $check_item->ids;
			
			$type = 1;
			$data["changed"] = NOW;
			$data["media_url"] = $dir;
			$this->db->update($this->tb_services, $data, array("ids" => $check_item->ids));
	
			$this->folderExs($check_item->ids, $maindir, $type, $img_order);
		}

		$datas = array(
			"uid"             => session('uid'),
			"cate_id"         => $category,
			"sub_cat_id"      => $sub_category,
			"second_sub_cat_id"         => $second_sub_category,
			"name"            => $name,
			"desc"            => $desc,
			"file_link"       => $file_link,
			"min"             => $min,
			"type"            => $service_type,
			"max"             => $max,
			"price"           => $price,
			"dripfeed"        => $dripfeed,
			"status"          => $status,
			"lang"            => $lang
		);
	
		$this->db->update($this->tb_services, $datas, array("ids" => $idup));

		$service = $this->model->getService($idup);
		$this->sendUpdate($service);

		set_session("clk",'1');
		ms(array(
			"status"  => "success",
			"message" => lang("Update_successfully")
		));
	}
        
    public function ajax_bulk_update($ids = array()) {

        $idss=post("ids");
        $category	        = post("category");
        $min	            = post("min");
		$max	            = post("max");
		$price	            = (float)post("price");
		$desc 		        = post("desc");
		$desc = trim($desc);
		$desc = stripslashes($desc);
		$desc = htmlspecialchars($desc, ENT_QUOTES);
                $data=array();
		if($min != ""){
                    $data["min"]=$min;
		}

		if($max != ""){
                    $data["max"]=$max;
		}
                if(!empty($desc)){
                    $data["desc"]=$desc;
                }
		if( $min!="" && $max !="" && $min > $max){
			ms(array(
				"status"  => "error",
				"message" => lang("max_order_must_to_be_greater_than_min_order")
			));
                }
                if($price != ""){
                    $data["price"]=$price;
		}
                
                if($category != 0){
                    $data["cate_id"]=$category;
		}
                
                
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
                        $data["file_link"]=$file_link;
                    }
                    
                }
                
                
                
		$decimal_places = get_option("auto_rounding_x_decimal_places", 2);
		if(strlen(substr(strrchr($price, "."), 1)) > $decimal_places || strlen(substr(strrchr($price, "."), 1)) < 0){
			ms(array(
				"status"  => "error",
				"message" => lang("price_invalid_format")
			));
		}
                if(!is_array($idss)){
                    $idss_data=array();
                    parse_str($idss, $idss_data);
                    if(isset($idss_data['ids'])){
                        $idss=$idss_data['ids'];
                    }
                    
                }
                if(!empty($data)){
                    foreach ($idss as $key => $ids) {
                         $this->db->update($this->tb_services, $data, array("ids" => $ids));
                }
               
                }
		ms(array(
			"status"  => "success",
			"message" => lang("Update_successfully")
		));
	}
	
	public function ajax_search(){
		$k = post("k");
		$services = $this->model->get_services_by_search($k);
		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"services"   => $services,
		);
		$this->load->view("ajax_search", $data);
	}
	
	public function ajax_service_sort_by_cate($id){
		$type=session("type");
		$idm=session("c_id");
		$nd=$id;
		if($type=='sub_cat_id'){
			$catname=get_field($this->tb_sub_categories, ['id' => $idm], 'name');
		}else if($type=='cate_id'){
			$catname=get_field($this->tb_categories, ['id' => $idm], 'name');
		}else{
			$catname=get_field($this->tb_second_sub_categories, ['id' => $idm], 'name');
		}
		
		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"catename"  => $catname,
			"services"   => $this->model->get_services_by_sort($nd),
			 "medias"   => $this->model->get_media_by_ser(),
		);
		
		$this->load->view("ajax_load_services_by_sub_cate", $data);
	}

	public function ajax_load_services_by_cate($id){

		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"services"   => $this->model->get_services_by_cate_id($id),
			"cate_id"    => $id,
		);
		$this->load->view("ajax_load_services_by_cate", $data);
	}
	public function ajax_load_services_by_sub_cate($id) {

		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"services"   => $this->model->get_services_by_sub_cate_id($id),
			"sub_cate_id"    => $id,
		);

		$this->load->view("ajax_load_services_by_sub_cate", $data);
	}
	
	
	
	public function ajax_load_services_by_second_sub_cate($id){
		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"services"   => $this->model->get_services_by_second_sub_cate($id),
			"second_sub_cate_id"    => $id,
		);
		$this->load->view("ajax_load_services_by_sub_cate", $data);
	}

	public function ajax_delete_item($ids = ""){

		$service = $this->model->getService($ids);
		$this->sendDelete($service);

		$target_dir = FCPATH."assets/uploads/media/".$ids;
		array_map('unlink', glob("$target_dir/*.*"));
		rmdir($target_dir);
		$this->db->delete($this->tb_services_media, ['media_id' => $ids]);
		$this->db->delete($this->tb_services, array('ids' => $ids));
		ms(
			array(
				"status"  => "success",
				"message" => lang("Deleted_successfully"))
		);
	}

	public function ajax_actions_option(){
		$type = post("type");
		$idss = post("ids");
		if ($type == '') {
			ms(array(
				"status"  => "error",
				"message" => lang('There_was_an_error_processing_your_request_Please_try_again_later')
			));
		}

		if (in_array($type, ['delete', 'deactive', 'active']) && empty($idss)) {
			ms(array(
				"status"  => "error",
				"message" => lang("please_choose_at_least_one_item")
			));
		}
		switch ($type) {
			case 'delete':
				foreach ($idss as $key => $ids) {
					
					$this->db->delete($this->tb_services, ['ids' => $ids]);
					$target_dir = FCPATH."assets/uploads/media/".$ids;
					array_map('unlink', glob("$target_dir/*.*"));
				    rmdir($target_dir);
			        $this->db->delete($this->tb_services_media, ['media_id' => $ids]);
				}
				
				ms(array(
					"status"  => "success",
					"message" => lang("Deleted_successfully")
				));
				break;
			case 'deactive':
				foreach ($idss as $key => $ids) {
					$this->db->update($this->tb_services, ['status' => 0], ['ids' => $ids]);
				}
				ms(array(
					"status"  => "success",
					"message" => lang("Updated_successfully")
				));
				break;

			case 'active':
				foreach ($idss as $key => $ids) {
					$this->db->update($this->tb_services, ['status' => 1], ['ids' => $ids]);
				}
				ms(array(
					"status"  => "success",
					"message" => lang("Updated_successfully")
				));
				break;


			case 'all_deactive':
				$deactive_services = $this->model->fetch("*", $this->tb_services, ['status' => 0]);
				if (empty($deactive_services)) {
					ms(array(
						"status"  => "error",
						"message" => lang("failed_to_delete_there_are_no_deactivate_service_now")
					));
				}
				$this->db->delete($this->tb_services, ['status' => 0]);
				ms(array(
					"status"  => "success",
					"message" => lang("Deleted_successfully")
				));

				break;
			
			default:
				ms(array(
					"status"  => "error",
					"message" => lang('There_was_an_error_processing_your_request_Please_try_again_later')
				));
				break;
		}

	}
	
	//Added by mithu0705
	public function ajax_load_services_by_id($id){
		
		set_session("url", 'ajax_load_services_by_id/'.$id);
		set_session("type",$_POST['type']);
		set_session("clk",'0');
		set_session("c_id",$id);
		
		$type = $_POST['type'];
		$catename = get_field($this->tb_categories, ['id' => $id], 'name');

		$data = array(
			"module"     => get_class($this),
			"columns"    => $this->columns,
			"services"   => $this->model->get_services_by_id($id, $type),
			"medias"   => $this->model->get_media_by_ser(),
			"cate_id" => $id,
			"catename" => $catename,
			"sub_cate_id"    => $id,
		);
		
		$this->load->view("ajax_load_services_by_sub_cate", $data);
	}
	
	public function ajax_media(){
		 $dir = post("dir");
		 if(isset($_FILES["profile_image"]["name"])){
                   
						if(empty($dir)){
							$dirName = date('YmdHis', time());
						
							$target_dir = FCPATH."assets/uploads/media/".$dirName."/";
							if (!file_exists($target_dir)) {
									mkdir($target_dir, 0777, true);
							}
						}else{
							
							if(strstr($dir, '/')){
								$array = explode("/",$dir);
								$fpath=$array[8];
								
								
							}else{
								$fpath=$dir;
							}
							
							$target_dir=FCPATH."assets/uploads/media/".$fpath."/";
							$dirName=$fpath;
							
						}
						
						$imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"][0],PATHINFO_EXTENSION));
						$mediatype=0;
						if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"
							|| $imageFileType == "gif" ) {
							 $mediatype=0;
						}else if($imageFileType == "mp4" || $imageFileType == "webm" || $imageFileType == "avi"
							|| $imageFileType == "wmv" ){
							 $mediatype=1;
							
						}else{}
					   
					    if($mediatype==1){
						$target_file = $target_dir . basename($_FILES["profile_image"]["name"][0]);
						$file_path=0;
						if(move_uploaded_file($_FILES["profile_image"]["tmp_name"][0], $target_file)){
							$file_link=base_url()."/assets/uploads/media/".$dirName.'/'.$_FILES["profile_image"]["name"][0];
							$file_path=$_SERVER['SERVER_NAME']."/assets/uploads/media/".$dirName.'/'.$_FILES["profile_image"]["name"][0];
						} else {
							$return_arr[]=array("msg" =>"fail","dir" =>$target_dir,"link" => $file_link,"fSize"=>$folderS,"medType"=> $mediatype);
					
						    echo json_encode($return_arr); 
						}
						
							$this->db->select_max('img_order');
							$this->db->where('media_id', $dirName);
							$res_img = $this->db->get($this->tb_services_media);
							$imgor = $res_img->row();
				
							$folderS=$this->folder_size($target_dir);
							
							$array = explode("/",$target_dir);
							$data["media_id"]=$dirName;
							$data["name"] = $_FILES["profile_image"]["name"][0];
							$data["file_path"] =$file_path;
							$data["uid"] =session('uid');
							$data["type"]=$mediatype;
							$data["img_order"]=$imgor->img_order+1;
							
							$this->db->insert($this->tb_services_media, $data); 						
							$return_arr[]=array("msg" =>"success","dir" =>$target_dir,"link" => $file_link,"fSize"=>$folderS,"medType"=> $mediatype);
						
							 echo json_encode($return_arr); 
						}else{
						
							$target_dir_path = FCPATH."assets/uploads/media/".$dirName."/temp/";
							if (!file_exists($target_dir_path)) {
									mkdir($target_dir_path, 0777, true);
							}
							$target_file = $target_dir_path . basename($_FILES["profile_image"]["name"][0]);
							$file_path=0;
							if(move_uploaded_file($_FILES["profile_image"]["tmp_name"][0], $target_file)){
								$file_link=base_url()."/assets/uploads/media/".$dirName.'/temp/'.$_FILES["profile_image"]["name"][0];
								$file_path=$_SERVER['SERVER_NAME']."assets/uploads/media/".$dirName.'/temp/'.$_FILES["profile_image"]["name"][0];
							}
							
							$folderS=$this->folder_size(FCPATH."assets/uploads/media/".$dirName);
							$return_arr[]= array(
											"dir" => $target_dir,
											"link" => $file_link,
											"fSize"=> $folderS,
											 "medType"=>$mediatype,
									 );
							
							echo json_encode($return_arr);
					}
					
                }
	}
	
	public function remove_media(){
		
		$array =post("dir");		
		if(strstr($array, '/')){
			$array = explode("/",$array);
			$fpath=$array[8];
		}else{
			$fpath=$array;
		}
		
		$api_type=trim(post('service'));
		$data["name"] =trim(post("image"));
		$data["uid"] =session('uid');
		$data["media_id"] =$fpath;
		$this->db->delete($this->tb_services_media, $data);
		
		$folderS=0;
		if($api_type!='api') {
			$path=FCPATH."assets/uploads/media/".$fpath."/".trim(post("image"));
			unlink($path);
			$folderS=$this->folder_size(FCPATH."assets/uploads/media/".$fpath);
		}
		
		$return_arr[]= array(
			"msg" =>'success',
			"fSize" =>$folderS
		);
		echo json_encode($return_arr);
	}
	
	public function service_media($ids = "") {
		
		$m_id = $this->model->get("media_url,name", $this->tb_services, ['ids' => $ids]);
		$media    = $this->model->services_media_display($m_id->media_url);
		
		 $data = array(
			"module"   		=> get_class($this),
			"media" 		=> $media,
			"mname" 		=> $m_id->name,
		);

		$this->load->view('service_media', $data); 
	}
	
	public function folder_size($target_dir){
		if(strstr($target_dir, '/')){
			$target_dirs=$target_dir;
		}else{
		
			$target_dirs=FCPATH."assets/uploads/media/".$target_dir."/";
		}
		 
		$size = 0;
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($target_dirs)) as $file){
			$size += $file->getSize();
		}
    
		$mod = 1024;
		$units = explode(' ','B KB MB GB TB PB');
		for ($i = 0; $size > $mod; $i++) {
			$size /= $mod;
		}
		return round($size, 2) . ' ' . $units[$i];
        
	}
	
	public function folderExs($check_item, $maindir, $type, $img_order){
			
			$array = explode("/", $maindir);
			$dir = (count($array) > 8) ? $array[8] : ''; // 8 initaially
			$dir = $array[(count($array) - 2)];
			
		    $target_dir = FCPATH."assets/uploads/media/".$check_item;
			$target_path = "http://" . $_SERVER['SERVER_NAME']."/msellers/assets/uploads/media/".$check_item;

			if (file_exists($maindir)) {
				rename($maindir, $target_dir);
			}

			$result = $this->model->services_media(array("media_id" => $dir));
			$data_media["media_id"] = $check_item;
			$data_media["status"] = 0;
			$data_media["file_path"] = $target_path;

			foreach ($result as $key => $row) {	
				$this->db->update($this->tb_services_media, $data_media, ["id" => $row->id]);
			}
			
			if($type == 0) {
				$updatemedia['media_url'] = $check_item;
				$this->db->update($this->tb_services, $updatemedia, ["ids" => $check_item]);			
		    }

			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}			
			
			$results=$this->model->services_media(array("uid" => session('uid'),"status" => 1));
			
			if($type == 1) {
				foreach ($results as $keys => $rows) {
					$target_dir = FCPATH."assets/uploads/media/".$rows->media_id;
					if (file_exists($target_dir)) {
						array_map('unlink', glob("$target_dir/*.*"));
						rmdir($target_dir);
					}

					$data_d["media_id"] = $rows->media_id;
					$this->db->delete($this->tb_services_media, $data_d);
				}
			}

			$m_id = 0;
			$imArr = explode(",",$img_order);
			
			if($type == 0) {
				$m_id = $check_item;
			}
			else { 
			    if($dir == '' || $dir == 'NULL'){
				   $m_id = $maindir;
				}
				else{
					$m_id = $dir;
				}
			}
			
			for($i = 0; $i < count($imArr); ++$i) {
				$img_or['img_order'] = $i;
				$this->db->update($this->tb_services_media, $img_or, ["media_id" => $m_id, "name" => trim($imArr[$i])]);
			}
	}
	
	public function fileExs() {

		$folder = post("dir");
		$image = post("image");
		$url = FCPATH."assets/uploads/media/".$folder."/".$image;	
		
		if(file_exists($url)) {
			$result=1;
		}
		else{
			$result=0;
		}
		
	   $return_arr[]= array(
			"success" =>$result
		);

		echo json_encode($return_arr);
	}
		
	public function cropImg() {
	 	
		$arr=post('data');
		
		$imgwidth=$arr["imgWidth"];
		$imgheight=$arr["imgHeight"];
		$top=$arr["imgTop"];
		$left=$arr["imgLeft"];
		$dWidth=$arr["dWidth"];
		$dheight=$arr["dheight"]; 
		$imgname=$arr["imgName"];
		$dir=$arr["dir"];
		
        $file_path = APPPATH. '../assets/uploads/media/'.$dir.'/temp/'.$imgname;
        ini_set('memory_limit', '512M');
        
        $file = new SplFileInfo($file_path);
        $ext  =  strtolower($file->getExtension());
        
        if($ext=='png'){
            $img_r = imagecreatefrompng($file_path);
        }else{
            $img_r = imagecreatefromjpeg($file_path);
        }
        	
        
        $width = imagesx($img_r);
        $height = imagesy($img_r);
        $rty=$dWidth*3;
        $rtu=$dheight*3;

        $xc=$left*3;
        $yc=$top*3;

        $wc=$imgwidth*3;
        $hc=$imgheight*3;
        
        $dst_r = ImageCreateTrueColor($rty, $rtu);
                
        $file_paths = APPPATH. '../assets/uploads/media/'.$dir.'/'.$imgname;
                
        
        $whiteBackground = imagecolorallocate($dst_r, 0, 0, 0); 
        imagefill($dst_r,0,0,$whiteBackground); 
        
        imagecopyresampled($dst_r, $img_r, $xc, $yc, 0, 0, $wc, $hc, $width, $height);
		
		    $folderS=$this->folder_size(APPPATH. '../assets/uploads/media/'.$dir.'/');
			$data["media_id"]=$dir;
			$data["name"] = $imgname;
			$data["file_path"] =$file_paths;
			$data["uid"] =session('uid');
			$data["type"]=0;
			$this->db->insert($this->tb_services_media, $data); 
		
         if($ext=='png'){
            header('Content-type: image/png');
            imagejpeg($dst_r,$file_paths); 
        }else{
            header('Content-type: image/jpeg');
            imagepng($dst_r,$file_paths); 
        } 
		unlink($file_path);
	} 	

	public function sendUpdate($service) {
		
		$response = $this->model->getAdminKey();
		$url = main_admin_api_endpoint();

		$post = array(
			'id' => $service->service,
			'name' => $service->name,
			'desc' => $service->desc,
			'price' => $service->rate,
			'min' => $service->min,
			'max' => $service->max,
			'dripfeed' => $service->dripfeed,
			'type' => $service->type,
			'media_url' => $service->media_url,
			'lang' => $service->servlang,
			'file_link' => $service->file_path . "/" . $service->image,
			'category' => $service->category,
			'catlang' => $service->categorylang,
			'sort' => $service->csort,
			'category_description' => $service->category_description,
			'subcat' => $service->subcategory,
			'subcatdesc' => $service->subdesc,
			'subcatsort' => $service->sbsort,
			'subcatlang' => $service->subcategorylang,
			'secsubcat' => $service->secondsubcategory,
			'secsubcatdesc' => $service->ssubdesc,
			'secsubcatsort' => $service->subsort,
			'secsubcatlang' => $service->secondsubcategorylang);

		$data = array(
			'key' => $response->key,
			'action' => 'update-service',
			'post_data' => json_encode($post));

		$this->connectAPI($url, $data);
	}

	public function connectAPI($url, $data) {

		$curl = curl_init();
		curl_setopt_array($curl, [
		    	CURLOPT_RETURNTRANSFER => 1,
		    	CURLOPT_URL => $url,
		    	CURLOPT_POST => 1,
		    	CURLOPT_POSTFIELDS => $data
			]
		);

	    $response = curl_exec($curl);
	    $err = curl_error($curl);
	    //print_r($response);
	    //print_r($err);

	    curl_close($curl);
	}


	function sendDelete($service) {

		$response = $this->model->getAdminKey();
		$url = main_admin_api_endpoint();

		$data = array(
			'key' => $response->key,
			'action' => 'delete-service',
			'service_id' => $service->service);
		
		$this->connectAPI($url, $data);
	}
}