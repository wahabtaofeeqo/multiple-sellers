<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class services_model extends MY_Model {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_services_media;
	public $tb_order;
	public $tb_sub_categories;
    public $tb_second_sub_categories;

	public function __construct(){
		$this->tb_categories     = CATEGORIES;
		$this->tb_services       = SERVICES;
		$this->tb_api_providers  = API_PROVIDERS;
		$this->tb_services_media   = services_media;
		$this->tb_sub_categories = SUB_CATEGORIES;
        $this->tb_second_sub_categories = SECOND_SUB_CATEGORIES;
		$this->tb_order             = ORDER;
		$this->tb_users             = USERS;
		parent::__construct();
	}

	function get_services_list() {

	    $lang_current = get_lang_code_defaut();
		$data  = array();
		
		// get categories
		if (get_role("user")) {
			$this->db->where("status", "1","lang", $lang_current->code);
		}

		$this->db->select("id, ids, name");
		$this->db->from($this->tb_categories);
		$this->db->where('lang', $lang_current->code);
		$this->db->order_by("sort", 'ASC');

		$query = $this->db->get();
		$categories = $query->result();
// 		print_r($categories);
		if(!empty($categories)) {

			$i = 0;
			foreach ($categories as $key => $row) {
				$i++;
				// get services
				if ($i > 0) {
					// if (get_role("supporter") || get_role("admin")) {
						
					// 	$services = $this->model->fetch("id", $this->tb_services, ['cate_id' => $row->id, 'uid' => session('uid')],'price', 'ASC');

					// }

					if(get_role("m-seller")) {
						$services = $this->model->fetch("id", $this->tb_services, ['cate_id' => $row->id, 'uid' => session('uid')],'price', 'ASC');
					}
					else {
						$services = $this->model->fetch("id", $this->tb_services, ["status" => 1, 'cate_id' => $row->id], 'price', 'ASC');
					}

					if(!empty($services)) {
						$categories[$key]->is_exists_services = 1;
					}
					else {
						unset($categories[$key]);	
					}

				}
				else{
					break;
				}
				
			}
		}

		return $categories;
	}

	function get_services_by_search($k) {
	    $lang_current = get_lang_code_defaut();
		$k = trim(htmlspecialchars($k));

		if (get_role("supporter") || get_role("admin")|| get_role("m-seller")) {
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`s`.`id` LIKE '%".$k."%' ESCAPE '!' OR `s`.`api_service_id` LIKE '%".$k."%' ESCAPE '!' OR  `s`.`name` LIKE '%".$k."%' ESCAPE '!' OR  `api`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}
			$this->db->where('lang', $lang_current->code);
			if (get_role("m-seller")) {
				$this->db->where('s.uid', session('uid'));
			}
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();

		}else{
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`s`.`id` LIKE '%".$k."%' ESCAPE '!' OR `s`.`api_service_id` LIKE '%".$k."%' ESCAPE '!' OR  `s`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}

			$this->db->where("s.status", 1);
			$this->db->where('lang', $lang_current->code);
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
// 		prin_r($result);
		return $result;
	}

	function get_services_by_cate_id($id){
	    $lang_current = get_lang_code_defaut();
		if (get_role("supporter") || get_role("admin")|| get_role("m-seller")) {
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
			
			$this->db->where("s.cate_id", $id);
			$this->db->where('lang', $lang_current->code);
			
			if (get_role("m-seller")) {
				$this->db->where('s.uid', session('uid'));
			}
			
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}else{
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			$this->db->where("s.cate_id", $id);
			$this->db->where("s.status", 1);
			$this->db->where('lang', $lang_current->code);
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}
	function get_services_by_sub_cate_id($id) {
		
	    $lang_current = get_lang_code_defaut();
		if (get_role("supporter") || get_role("admin")|| get_role("m-seller")) {
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
			
			$this->db->where("s.sub_cat_id", $id);
			$this->db->where('lang', $lang_current->code);
			if (get_role("m-seller")) {
				$this->db->where('s.uid', session('uid'));
			}
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}else{
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			$this->db->where("s.sub_cat_id", $id);
			$this->db->where("s.status", 1);
			$this->db->where('lang', $lang_current->code);
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}
        
    function get_sub_category_lists(){
        
        $lang_current = get_lang_code_defaut();
		$this->db->select('*');
		$this->db->from("sub_categories");
		$this->db->where('lang', $lang_current->code);
		
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
						$services = $this->model->fetch("id", $this->tb_services, ['sub_cat_id' => $row->id,'uid' => session('uid')],'price', 'ASC');
					}

					if(get_role("m-seller")){
						$services = $this->model->fetch("id", $this->tb_services, ['sub_cat_id' => $row->id, 'uid' => session('uid')],'price', 'ASC');
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
		if (get_role("m-seller")) {
		$i = 0;
			foreach ($categories as $key => $row) {
				$muti_arr=explode(',', $row->seller_permission);
			    if(in_array(session('uid'),$muti_arr)){
				        if(in_array(session('uid'),$muti_arr)){
				
				
						}else{
						   unset($categories[$key]);	
						   
						}
				
			    }else{
				 $categories;	
				   
			    }
			}
		
		}
                return $categories;
	}
        
    function get_second_sub_category_lists() {
            $lang_current = get_lang_code_defaut();
		$this->db->select('*');
		$this->db->from("second_sub_categories");
		$this->db->where('lang', $lang_current->code);
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get();
                $categories = $query->result();
                if(!empty($categories)){
			$i = 0;
			foreach ($categories as $key => $row) {
				$i++;
				// get services
				if ($i > 0) {
					// if (get_role("supporter") || get_role("admin")) {
						
					// 	$services = $this->model->fetch("id", $this->tb_services, ['second_sub_cat_id' => $row->id, 'uid' => session('uid')],'price', 'ASC');
					
					// }else

					if(get_role("m-seller")){
						
						$services = $this->model->fetch("id", $this->tb_services, ['second_sub_cat_id' => $row->id, 'uid' => session('uid')],'price', 'ASC');
					
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
		if (get_role("m-seller")) {
		$i = 0;
			foreach ($categories as $key => $row) {
				$muti_arr=explode(',', $row->seller_permission);
			    if(in_array(session('uid'),$muti_arr)){
				        if(in_array(session('uid'),$muti_arr)){
				
				
						}else{
						   unset($categories[$key]);	
						   
						}
				
			    }else{
				 $categories;	
				   
			    }
			}
		
		   }
                return $categories;
		}
		
		//Added by mithu0705
		function get_services_by_id($id, $type) {
			
			$lang_current = get_lang_code_defaut();
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			if($type=='sub_cat_id') {
				$this->db->where('sub_cat_id', $id);
				//$this->db->where('second_sub_cat_id', 0);
			}
			else if($type=='cate_id') {
				$this->db->where('cate_id', $id);
				$this->db->where('sub_cat_id', 0);
				$this->db->where('second_sub_cat_id', 0);				
			}
			else {
				//$this->db->where('sub_cat_id', 0);
				$this->db->where('second_sub_cat_id', $id);	
			}

			$this->db->where('lang', $lang_current->code);
			if (get_role("m-seller")) {
			   $this->db->where('s.uid', session('uid'));
			}
			// if (get_role("admin")) {
			//    $this->db->where('s.uid', session('uid'));
			// }
			$query = $this->db->get();	
			
			return $query->result();
		
	}

	function get_services($ids, $suid, $type) {
		
		$lang_current = get_lang_code_defaut();
		
		if (get_role("supporter") || get_role("admin")|| get_role("m-seller")) {

			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
			
			if($type == 'main') {
			  $this->db->where("s.cate_id", $ids);
			  $this->db->where('sub_cat_id', 0);
			  $this->db->where('second_sub_cat_id', 0);
			}
			else if($type == 'sub') {
				$this->db->where('cate_id', $ids);
				$this->db->where('sub_cat_id', $suid);
				//$this->db->where('second_sub_cat_id', 0);
			}

			$this->db->where('lang', $lang_current->code);
			if (get_role("m-seller")) {
				$this->db->where('s.uid', session('uid'));
			}

			// if (get_role("admin")) {
			// 	$this->db->where('s.uid', session('uid'));
			// }

			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}else{
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			if($type=='main'){
			  $this->db->where("s.cate_id", $ids);
			  $this->db->where('sub_cat_id', 0);
			  $this->db->where('second_sub_cat_id', 0);
			}else if($type=='sub'){
				$this->db->where('cate_id', $ids);
				$this->db->where('sub_cat_id',$suid);
				$this->db->where('second_sub_cat_id', 0);
			}
			$this->db->where("s.status", 1);
			$this->db->where('lang', $lang_current->code);
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
		
	}
	
	function services_media_display($ids){
		
		    $this->db->select('*');
			$this->db->from($this->tb_services_media);
		 	 $this->db->where('media_id', $ids);
			$this->db->where('status',0);
			if (get_role("m-seller")) {
				$this->db->where('uid', session('uid'));
			}
			$this->db->order_by("img_order", 'ASC');
			$query = $this->db->get();
			return $result = $query->result();
		
	}
	
	function services_media($data){
		
		    $this->db->select('*');
			$this->db->from($this->tb_services_media);
			$this->db->where($data);
			if (get_role("m-seller")) {
				$this->db->where('uid', session('uid'));
			}
			$query = $this->db->get();
			return $result = $query->result();
		
	}
	function get_media_by_ser(){
		
			 $this->db->select('*');
			 $this->db->from($this->tb_services_media);
			 $this->db->order_by("img_order", 'ASC');
			 $this->db->where('status', 0);
			 if (get_role("m-seller")) {
				$this->db->where('uid', session('uid'));
			 }
			 $querys = $this->db->get();
			 return $querys->result();
		
	}
	
	function get_services_by_sort($id){
		$type=session("type");
		$idm=session("c_id");
	
	    $lang_current = get_lang_code_defaut();
		
				if (get_role("supporter") || get_role("admin")|| get_role("m-seller")) {
					
					$this->db->select(' s.*, api.name as api_name');
					$this->db->from($this->tb_services." s");
					
					if($type=='sub_cat_id'){
						if(($id==4)||($id==5)){
							
							$this->db->join($this->tb_sub_categories." c1", "s.sub_cat_id = c1.id", 'left');
							$this->db->join($this->tb_order." ord", "s.sub_cat_id = ord.sub_cat_id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.sub_cat_id', $idm);
							$this->db->where('s.second_sub_cat_id', 0);
							
						}else{
							
							$this->db->join($this->tb_sub_categories." c1", "s.sub_cat_id = c1.id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.sub_cat_id', $idm);
							$this->db->where('s.second_sub_cat_id', 0);
						}
						
					}else if($type=='cate_id'){
						if(($id==4)||($id==5)){
							
							$this->db->join($this->tb_categories." c2", "s.cate_id = c2.id", 'left');
							$this->db->join($this->tb_order." ord", "s.cate_id = ord.cate_id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.cate_id', $idm);
							$this->db->where('s.sub_cat_id', 0);
							$this->db->where('s.second_sub_cat_id', 0);
							
						}else{
							$this->db->join($this->tb_categories." c2", "s.cate_id = c2.id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.cate_id', $idm);
							$this->db->where('s.sub_cat_id', 0);
							$this->db->where('s.second_sub_cat_id', 0);
						}							
					}else{
						if(($id==4)||($id==5)){
							
							$this->db->join($this->tb_second_sub_categories." c3", "s.second_sub_cat_id = c3.id", 'left');
							$this->db->join($this->tb_order." ord", "s.second_sub_cat_id = ord.second_sub_cat_id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.second_sub_cat_id',$idm);	
							
						}else{
							$this->db->join($this->tb_second_sub_categories." c3", "s.second_sub_cat_id = c3.id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.second_sub_cat_id',$idm);	
						}
					}
					
					
					$this->db->where('s.lang', $lang_current->code);
					$this->db->where("s.status", 1);
					if (get_role("m-seller")) {
						$this->db->where('s.uid', session('uid'));
					}
					if($id==1){
							$this->db->limit(5);
							$this->db->order_by("s.id", 'DESC');
					}else if($id==2){
						 $this->db->order_by("s.price", 'DESC');
					}else if($id==3){
						$this->db->order_by("s.price", 'ASC');
					}else if($id==4){
						$this->db->order_by("s.id", 'DESC');
					}else if($id==5){
						$this->db->order_by("s.id", 'ASC');
					}else{}
					
					
					$query = $this->db->get();
					$result = $query->result();
					
					
				}else{
					$this->db->select(' s.*, api.name as api_name');
					$this->db->from($this->tb_services." s");
					
					if($type=='sub_cat_id'){
						if(($id==4)||($id==5)){
							
							$this->db->join($this->tb_sub_categories." c1", "s.sub_cat_id = c1.id", 'left');
							$this->db->join($this->tb_order." ord", "s.sub_cat_id = ord.sub_cat_id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.sub_cat_id', $idm);
							$this->db->where('s.second_sub_cat_id', 0);
							
						}else{
							
							$this->db->join($this->tb_sub_categories." c1", "s.sub_cat_id = c1.id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.sub_cat_id', $idm);
							$this->db->where('s.second_sub_cat_id', 0);
						}
						
					}else if($type=='cate_id'){
						if(($id==4)||($id==5)){
							
							$this->db->join($this->tb_categories." c2", "s.cate_id = c2.id", 'left');
							$this->db->join($this->tb_order." ord", "s.cate_id = ord.cate_id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.sub_cat_id', $idm);
							$this->db->where('s.second_sub_cat_id', 0);
							
						}else{
							$this->db->join($this->tb_categories." c2", "s.cate_id = c2.id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.sub_cat_id', $idm);
							$this->db->where('s.second_sub_cat_id', 0);
						}							
					}else{
						if(($id==4)||($id==5)){
							
							$this->db->join($this->tb_second_sub_categories." c3", "s.second_sub_cat_id = c3.id", 'left');
							$this->db->join($this->tb_order." ord", "s.second_sub_cat_id = ord.second_sub_cat_id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.second_sub_cat_id',$idm);	
							
						}else{
							$this->db->join($this->tb_second_sub_categories." c3", "s.second_sub_cat_id = c3.id", 'left');
							$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
							$this->db->where('s.second_sub_cat_id',$idm);	
						}
					}
					
					
					$this->db->where('s.lang', $lang_current->code);
					$this->db->where("s.status", 1);
					if($id==1){
						$this->db->limit(5);
						$this->db->order_by("s.id", 'DESC');
					}else if($id==2){
						 $this->db->order_by("s.price", 'DESC');
					}else if($id==3){
						$this->db->order_by("s.price", 'ASC');
					}else if($id==4){
						$this->db->order_by("s.id", 'DESC');
					}else if($id==5){
						$this->db->order_by("s.id", 'ASC');
					}else{}
					
					
					$query = $this->db->get();
					$result = $query->result();
				}
		
		return $result;
	}
	
	function get_order_logs_list($total_rows = false, $status = "", $limit = "", $start = ""){
		 $data  = array();
		if (get_role("user")) {
			$this->db->where("o.uid", session("uid"));
		}
		if ($limit != "" && $start >= 0) {
			$this->db->limit($limit, $start);
		}
		$this->db->select('o.*, u.email as user_email, s.name as service_name, api.name as api_name');
		$this->db->from($this->tb_order." o");
		$this->db->join($this->tb_users." u", "u.id = o.uid", 'left');
		$this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
		$this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');
		if($status != "all" && !empty($status)){
			$this->db->where("o.status", $status);
		}
		$this->db->where("o.service_type !=", "subscriptions");
		$this->db->where("o.is_drip_feed !=", 1);
		
		if (get_role("m-seller")) {
			 $this->db->where('s.uid', session('uid'));
		}
		
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

	function getService($ids) {

        $this->db->select("s.id as service, s.dripfeed, s.type, s.media_url, s.api_service_id as s_id, s.name, s.desc, s.lang as servlang, c.name as category, c.lang as categorylang, c.desc as category_description, c.sort as csort, s.price as rate, s.min, s.max, s.file_link, subc.sort as sbsort, subc.desc as subdesc, subc.name as subcategory, subc.lang as subcategorylang, ssubc.sort as subsort, ssubc.desc as ssubdesc, ssubc.lang as secondsubcategorylang, ssubc.name as secondsubcategory, sm.file_path, sm.name as image");

        $this->db->from($this->tb_services . " s");
        $this->db->join($this->tb_categories . " c", "s.cate_id = c.id", 'left');
        $this->db->join($this->tb_sub_categories . " subc", "s.sub_cat_id = subc.id", 'left');
        $this->db->join($this->tb_second_sub_categories . " ssubc", "s.second_sub_cat_id = ssubc.id", 'left');
        $this->db->join($this->tb_users . " usr", "s.uid = usr.id", 'left');
        $this->db->join($this->tb_services_media . " sm", "s.ids = sm.media_id", "left");

        $this->db->where("s.status", "1");
        $this->db->where("c.status", "1");
		$this->db->where('s.ids', $ids);
		$result = $this->db->get();
		
		return $result->row();
	}

	public function getAdminKey() {
		$this->db->where("id", 4); // Temporary
		$query = $this->db->get($this->tb_api_providers);
		return $query->row();
	}

	public function findOrCreateService($data) {
		$check = $this->db->where('name', $data['name'])->get($this->tb_services)->row();
		if ($check) {
			return $check->id;
		}
		else {
			$this->db->insert($this->tb_services, $data);
			return $this->db->insert_id();
		}
	}
}
