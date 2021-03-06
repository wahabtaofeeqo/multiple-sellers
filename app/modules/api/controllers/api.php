<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api extends MX_Controller {

    public $tb_users;
    public $tb_categories;
    public $tb_services;
    public $tb_orders;
    public $api_key;
    public $uid;

    public function __construct() {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'model');
        //Config Module
        $this->tb_users = USERS;
        $this->tb_categories = CATEGORIES;
        $this->tb_services = SERVICES;
        $this->tb_orders = ORDER;
    }

    public function index() {
        redirect(cn('api/docs'));
    }

    public function docs() {
        $api_key = null;
        $api_key = get_field(USERS, ['id' => session('uid')], "api_key");

        $new_order = array(
            "key" => lang("your_api_key"),
            "action" => "add",
            "service" => lang("service_id"),
            "link" => lang("link_to_page"),
            "quantity" => lang("needed_quantity"),
        );

        $status_order = array(
            "key" => lang("your_api_key"),
            "action" => "status",
            "order_id" => lang("order_id"),
        );

        $status_orders = array(
            "key" => lang("your_api_key"),
            "action" => "status",
            "order_ids" => lang("order_ids_separated_by_comma_array_data"),
        );

        $services = array(
            "key" => lang("your_api_key"),
            "action" => "services",
        );

        $balance = array(
            "key" => lang("your_api_key"),
            "action" => "balance",
        );

        $media = array(
            "key" => lang("your_api_key"),
            "action" => "media",
        );

        $data = array(
            "module" => get_class($this),
            "api_key" => $api_key,
            "api_url" => BASE . "api/v1",
            "new_order" => $new_order,
            "status_order" => $status_order,
            "status_orders" => $status_orders,
            "services" => $services,
            "balance" => $balance,
            "media" => $media,
        );

        if (!session('uid')) {
            $this->template->set_layout('general_page');
            $this->template->build("index", $data);
        }

        $this->template->build("index", $data);
    }

    public function v1() {

        if (isset($_REQUEST["key"])) {
            $this->api_key = urldecode($_REQUEST["key"]);
        }

        if (isset($_REQUEST["action"])) {
            $action = urldecode($_REQUEST["action"]);
        }

        if (isset($_REQUEST["order"])) {
            $order_id = urldecode($_REQUEST["order"]);
        }

        if (isset($_REQUEST["link"])) {
            $link = urldecode($_REQUEST["link"]);
        }

        if (isset($_REQUEST["quantity"])) {
            $quantity = urldecode($_REQUEST["quantity"]);
        }

        if (isset($_REQUEST["service"])) {
            $service_id = urldecode($_REQUEST["service"]);
        }

        if (isset($_REQUEST["orders"])) {
            $order_ids = $_REQUEST["orders"];
        }
        $api_client = "";
        if (isset($_REQUEST["api_client"])) {
            $api_client = $_REQUEST["api_client"];
        }

        if (isset($_REQUEST["media"])) {
            $service_id = urldecode($_REQUEST["media"]);
        }

        $uid_exists = get_field($this->tb_users, ["api_key" => $this->api_key, "status" => 1], "id");
        if ($this->api_key == "" || empty($uid_exists)) {
            echo_json_string(array(
                'error' => lang("api_is_disable_for_this_user_or_user_not_found_contact_the_support"),
            ));
        }

        $this->uid = $uid_exists;

        $action_allowed = array('add', 'status', 'services', 
            'balance', 'ticket', 'media', 'all-services', 'ticket-reply',
            'service-media');

        if ($action == "" || !in_array($action, $action_allowed)) {
            echo_json_string(array (
                'error' => lang("this_action_is_invalid"),
            ));
        }

        switch ($action) {
            case 'services':

                $api = $_REQUEST["key"];
                
                $services = $this->model->get_services_list($api);

                if (!empty($services)) {
                    echo_json_string($services);
                } else {
                    echo_json_string(array(
                        'status' => "success",
                        'data' => array(),
                    ));
                }
                break;

            case 'all-services':
            
                $api = $_REQUEST["key"];                
                $services = $this->model->get_all_services_list($api);

                if (!empty($services)) {
                    echo_json_string($services);
                } else {
                    echo_json_string(array(
                        'status' => "success",
                        'data' => array(),
                    ));
                }
                break;

            case 'add':
                if (isset($_REQUEST["post_data"])) {
                    $this->add($service_id, $link, $quantity, $api_client, $_REQUEST["post_data"]);
                } else {
                    $this->add($service_id, $link, $quantity, $api_client);
                }

                break;

            case 'status':

                if (isset($order_id)) {
                    $this->single_status($order_id);
                }

                if (isset($order_ids)) {
                    $this->multi_status($order_ids);
                }
                break;

            case 'balance':
                $this->balance();
                break;

            case 'ticket':
                //$api = $_REQUEST["key"];
                $post_data = $_REQUEST["post_data"];
                $this->add_ticket($post_data);
                break;

            case 'ticket-reply':
                $this->replyTicket($_REQUEST['post_data']);
                break;

            case 'ticket_update':
                //$api = $_REQUEST["key"];
                $post_data = $_REQUEST["post_data"];
                $this->add_ticket_update($post_data);
                break;

            case 'media':
                $media = $this->model->get_services_mediaList();
                if (!empty($media)) {
                    echo_json_string($media);
                } else {
                    echo_json_string(array(
                        'status' => "success",
                        'data' => "Empty Data",
                    ));
                }
                break;

            case 'service-media':

                $media = $this->model->getServiceMedia($_REQUEST['media']);
                if (!empty($media)) {
                    echo_json_string($media);
                } else {
                    echo_json_string(array());
                }
                break;

            default:
                echo_json_string(array(
                    'error' => lang("this_action_is_invalid"),
                ));
                break;
        }
    }

    private function add($service_id, $link, $quantity, $api_client = "", $post_data = array()) {

        if ($service_id == "" || $link == "" || $quantity == "") {
            echo_json_string(array(
                'error' => lang("there_are_missing_required_parameters_please_check_your_api_manual"),
            ));
        }

        $check_service = $this->model->check_record("*", $this->tb_services, $service_id, false, true);

        if (empty($check_service)) {
            echo_json_string(array(
                "error" => "ID is missing"
            ));
        }

        /* ----------  Get user's balance and custom_rate info  ---------- */
        $user = $this->model->get("balance, custom_rate", $this->tb_users, ['id' => $this->uid]);

        // check quantity
        if (!empty($check_service)) {
            
            $min = $check_service->min;
            $max = $check_service->max;
            $price = $check_service->price;
            //$total_charge = $price*($quantity/1000);
            $total_charge = $price * ($quantity);
            /* ----------  Set custom rate for each user  ---------- */
            if (isset($user->custom_rate) && $user->custom_rate > 0) {
                $total_charge = $total_charge - (($total_charge * $user->custom_rate) / 100);
            } else {
                $total_charge = $total_charge;
            }

            if ($quantity <= 0 || $quantity < $min) {
                echo_json_string(array(
                    "error" => lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount")
                ));
            }

            if ($quantity > $max) {
                echo_json_string(array(
                    "error" => lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount")
                ));
            }
        }

        // if ($check_service->api_service_id != "") {
        //     if ((!empty($user->balance) && $user->balance < $total_charge) || empty($user->balance)) {
        //         echo_json_string(array(
        //             "error" => lang("not_enough_funds_on_balance")
        //         ));
        //     }
        // }


        $data = array(
            "ids" => ids(),
            "uid" => $check_service->uid, //The seller that own the service
            "type" => 'api',
            "cate_id" => $check_service->cate_id,
            "service_id" => $check_service->id,
            "link" => $link,
            "quantity" => $quantity,
            "charge" => $total_charge,
            "api_provider_id" => $check_service->api_provider_id,
            "api_service_id" => $check_service->api_service_id,
            "api_order_id" => (!empty($check_service->api_provider_id) && !empty($check_service->api_service_id)) ? -1 : 0,
            "status" => 'pending',
            "changed" => NOW,
            "created" => NOW,
        );

        $post_data = json_decode($post_data, true);

        if (isset($post_data["description"])) {
            $data['description'] = $post_data["description"];
        }

        if (isset($post_data["file_link"])) {
            $data['file_link'] = $post_data["file_link"];
        }

        $this->db->insert($this->tb_orders, $data);

        if ($this->db->affected_rows() > 0) {
            
            $insert_id = $this->db->insert_id();
            $new_balance = $user->balance - $total_charge;
            $this->db->update($this->tb_users, ["balance" => $new_balance], ["id" => $this->uid]);

            //insert order id and api client for update status issue
            $client_data = array("order_id" => $insert_id, "api_client" => $api_client);
            $this->db->insert("order_api_clients", $client_data);

            /* ----------  Send Order notificaltion notice to Admin  ---------- */
            if (get_option("is_order_notice_email", '')) {
                $subject = getEmailTemplate("order_success")->subject;
                $subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);
                $email_content = getEmailTemplate("order_success")->content;
                $email_content = str_replace("{{user_email}}", "no_reply@email.com", $email_content);
                $email_content = str_replace("{{order_id}}", $insert_id, $email_content);
                $email_content = str_replace("{{currency_symbol}}", get_option("currency_symbol", ""), $email_content);
                $email_content = str_replace("{{total_charge}}", $total_charge, $email_content);
                $email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);

                $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'", "id", "ASC")->id;
                if ($admin_id == "") {
                    $admin_id = 40;
                }

                $check_send_email_issue = $this->model->send_email($subject, $email_content, $admin_id, false);
            }
            /* end email functionality */

            $url = base_url() . "/api_provider/cron/order";
            $this->call_cron($url);
            
            echo_json_string(array(
                'status' => "success",
                "order" => $insert_id,
            ));
        } else {
            echo_json_string(array(
                "error" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
            ));
        }
    }

    private function balance() {
        $get_balance = $this->model->check_record("balance", $this->tb_users, $this->uid, false, true);
        if (!empty($get_balance)) {
            echo_json_string(array(
                "status" => "success",
                "balance" => $get_balance->balance,
                "currency" => "USD"
            ));
        } else {
            echo_json_string(array(
                "error" => lang("the_account_does_not_exists"),
            ));
        }
    }

    private function single_status($order_id) {

        if ($order_id == "") {
            echo_json_string(array(
                'error' => lang("order_id_is_required_parameter_please_check_your_api_manual")
            ));
        }

        if (!is_numeric($order_id)) {
            echo_json_string(array(
                'error' => lang("incorrect_order_id"),
            ));
        }

        $check_order_id = $this->model->get_order_id($order_id, $this->uid);
        if (empty($check_order_id)) {
            echo_json_string(array(
                'error' => lang("incorrect_order_id"),
            ));
        } 
        else {
            //$url = base_url() . "/api_provider/cron/single_status_update/$order_id";
            //$this->call_cron($url);
            echo_json_string($check_order_id);
        }
    }

    private function multi_status($order_ids) {
        
        if ($order_ids == "") {
            echo_json_string(array(
                'error' => lang("order_id_is_required_parameter_please_check_your_api_manual"),
            ));
        }

        $order_ids = json_decode($order_ids);

        if (is_array($order_ids)) {
            $data = [];
            foreach ($order_ids as $order_id) {
                $check_order_id = $this->model->get_order_id($order_id, $this->uid);
                if (empty($check_order_id)) {
                    $data[$order_id] = "Incorrect order ID";
                } else {
                    $data[$order_id] = $check_order_id;
                }
            }
            $url = base_url() . "/api_provider/cron/single_status_update/$order_id";
            $this->call_cron($url);
            echo_json_string($data);
        }

        echo_json_string(array(
            'error' => lang("incorrect_order_id"),
        ));
    }

    public function add_ticket_update($data) {

        $data = json_decode($data, true);
        $subject = $data["subject"];
        $api_id = $data['api_id'];
        $ticket_messages = $data['ticket_message'];
        unset($data['api_id']);
        unset($data['ticket_message']);
        $subject_parts = preg_split('/\s+/', $subject);
        if (isset($data["ticket_back"]) && $data["ticket_back"] == true) {//back updated
            $custom_data = array("ids" => $data["ids"], "status" => $data["status"]);
            $affected_id = $this->model->update_or_insert_ticket($custom_data);
            if (isset($subject_parts[0]) && ($subject_parts[0] == "Payment" || $subject_parts[0] == "Other")) {//for Payment and Other
                //TO DO
            } else {
                //update another server
                $url = base_url() . "/api_provider/cron/ticket/" . $affected_id . "/0/false";
            }
        } else {
            $affected_id = $this->model->update_or_insert_ticket($data);
            if (isset($subject_parts[0]) && ($subject_parts[0] == "Payment" || $subject_parts[0] == "Other")) {//for Payment and Other no need to send other server
                //TO DO
            } else {
                //update another server
                $url = base_url() . "/api_provider/cron/ticket/" . $affected_id . "/" . $api_id;
            }
        }
        $ticket_messages_id = '';
        $message_data = '';
        //sync ticket messages
        foreach ($ticket_messages as $message) {
            if (isset($message["id"])) {
                unset($message["id"]);
            }
            $message["ticket_id"] = $affected_id;
            $ticket_messages_id = $this->model->update_or_insert_messages($message);
        }
        if ($ticket_messages_id == '') {
            $message_data = $data['description'];
        } else {
            $message_data = $this->model->get_messages($ticket_messages_id);
        }




        $subject = " Ticket # " . "$affected_id - $subject";
        $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'", "id", "ASC")->id;
        //$check_email_issue = $this->model->send_email($subject, $description, $admin_id, false);
        //$check_email_issue = $this->model->send_email_test($subject, $description, $admin_id, false);
        $email_from = $data["sender_first_name"];
        $email_name = $data["sender_email"];
        //$email_from = 'islamcmt@gmail.com';
        //$email_name = 'karim';
        //$check_email_issue = $this->model->send_email_to_othersite($subject, $message_data, $admin_id, false, $email_from, $email_name);
        $this->call_cron($url);
        echo_json_string(array(
            "status" => "success"
        ));
    }

    public function replyTicket($data) {

        $data = json_decode($data, true);
        $ids = $data['ids'];
        $messages = $data['messages'];

        $ticket = $this->model->getTicketWithIDs($ids);
        if (!empty($ticket)) {
            $this->model->insertORUpdateMessages($messages, $ticket->id);
        }
    }

    public function add_ticket($data) {

        $data = json_decode($data, true);
        
        $key = $_REQUEST['key'];
        $messages = $data['messages'];
        $subject = $data['subject'];

        $insert = array(
            'ids' => $data['ids'],
            'description' => $data['description'],
            'subject' => $subject,
            'api_key' => $key,
            'created' => NOW,
            'changed' => NOW);

        if (strpos($subject, "Order") !== false) {
            
            $orderDetails = $this->model->getOrder($data['order_id']);

            $insert['order_id'] = $data['insert_id'];
            $insert['uid'] = $this->model->getSellerUserID($data['order_id']);
        }

        if (strpos($subject, "Service") !== false) {
            
            $service = $this->model->getService($data['service_id']);

            $insert['uid'] = $service->uid;
            $insert['service_id'] = $data['service_id'];
        }
       

        $ticketID = $this->model->insertORUpdateTicket($insert);
        $this->model->insertORUpdateMessages($messages, $ticketID);

       
        exit();

        $data = json_decode($data, true);
        $subject = $data["subject"];
        $api_id = $data['api_id'];
        $ticket_messages = $data['ticket_message'];

        unset($data['api_id']);
        unset($data['ticket_message']);

        //Get the ID of the Seller of the ordered Service
        $orderID = $data['order_id'];
        $data['uid'] = $this->model->getSellerUserID($orderID);

        $subject_parts = preg_split('/\s+/', $subject);

        if (isset($data["ticket_back"]) && $data["ticket_back"] == true) {//back updated
            $custom_data = array("ids" => $data["ids"], "status" => $data["status"]);
            $affected_id = $this->model->update_or_insert_ticket($custom_data);

            if (isset($subject_parts[0]) && ($subject_parts[0] == "Payment" || $subject_parts[0] == "Other")) {//for Payment and Other
                //TO DO
            }
            else {
                //update another server
                $url = base_url() . "/api_provider/cron/ticket/" . $affected_id . "/0/false";
            }
        } 
        else {
            $affected_id = $this->model->update_or_insert_ticket($data);
            if (isset($subject_parts[0]) && ($subject_parts[0] == "Payment" || $subject_parts[0] == "Other")) {//for Payment and Other no need to send other server
                //TO DO
            } else {
                //update another server
                $url = base_url() . "/api_provider/cron/ticket/" . $affected_id . "/" . $api_id;
            }
        }
        
        $ticket_messages_id = '';
        $message_data = '';

        //sync ticket messages
        foreach ($ticket_messages as $message) {
            if (isset($message["id"])) {
                unset($message["id"]);
            }
            $message["ticket_id"] = $affected_id;
            $ticket_messages_id = $this->model->update_or_insert_messages($message);
        }

        if ($ticket_messages_id == '') {
            $message_data = $data['description'];
        } 
        else {
            $message_data = $this->model->get_messages($ticket_messages_id);
        }




        $subject = " Ticket # " . "$affected_id - $subject";
        $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'", "id", "ASC")->id;
        //$check_email_issue = $this->model->send_email($subject, $description, $admin_id, false);
        //$check_email_issue = $this->model->send_email_test($subject, $description, $admin_id, false);
        $email_from = $data["sender_first_name"];
        $email_name = $data["sender_email"];
        //$email_from = 'islamcmt@gmail.com';
        //$email_name = 'karim';
        $check_email_issue = $this->model->send_email($subject, $message_data, $admin_id, false, $email_from, $email_name);

        $this->call_cron($url);

        echo_json_string(array(
            "status" => "success"
        ));
    }

    public function call_cron($url, $is_post = false, $data = array()) {
        ini_set('max_execution_time', 300000);
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        //for get request
        if (!$is_post) {
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
            ]);
        } else {
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data
            ]);
        }

        $response = curl_exec($curl);
        //print_r($response);
        $err = curl_error($curl);
        //print_r($err);
        curl_close($curl);
    }

}
