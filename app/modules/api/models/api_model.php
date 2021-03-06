<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api_model extends MY_Model {

    public $tb_users;
    public $tb_categories;
    public $tb_services;
    public $tb_orders;
    public $tb_subcategories;
    public $tb_secondsubcategories;
    public $tb_services_media;

    public function __construct() {
        $this->tb_categories = CATEGORIES;
        $this->tb_services = SERVICES;
        $this->tb_orders = ORDER;
        $this->tb_subcategories = SUB_CATEGORIES;
        $this->tb_secondsubcategories = SECOND_SUB_CATEGORIES;
        $this->tb_services_media = services_media;
        $this->tb_users = USERS;
        parent::__construct();
    }

    function get_services_list($id) {
        
        $data = array();
        $this->db->select("s.id as service, s.dripfeed, s.type, s.media_url,s.api_service_id as s_id, s.name, s.desc, s.lang as servlang, c.name as category, c.lang as categorylang, c.desc as category_description, c.sort as csort, s.price as rate, s.min, s.max, s.file_link, subc.sort as sbsort, subc.desc as subdesc, subc.name as subcategory, subc.lang as subcategorylang, ssubc.sort as subsort, ssubc.desc as ssubdesc, ssubc.lang as secondsubcategorylang, ssubc.name as secondsubcategory");

        $this->db->from($this->tb_services . " s");
        $this->db->join($this->tb_categories . " c", "s.cate_id = c.id", 'left');
        $this->db->join($this->tb_subcategories . " subc", "s.sub_cat_id = subc.id", 'left');
        $this->db->join($this->tb_secondsubcategories . " ssubc", "s.second_sub_cat_id = ssubc.id", 'left');
        $this->db->join($this->tb_users . " usr", "s.uid = usr.id", 'left');

        $this->db->where("s.status", "1");
        $this->db->where("c.status", "1");
        
        //$this->db->where("usr.api_key", trim($id));
        //$this->db->where("subc.status", "1");
        //$this->db->where("ssubc.status", "1");

        $query = $this->db->get();
        if ($query->result()) {
            return $data = $query->result();
        } else {
            false;
        }
    }

    function get_all_services_list($id) {
        
        $data = array();
        $this->db->select("s.id as service, s.dripfeed, s.type, s.media_url,s.api_service_id as s_id, s.name, s.desc, s.lang as servlang, c.name as category, c.lang as categorylang, c.desc as category_description, c.sort as csort, s.price as rate, s.min, s.max, s.file_link, subc.sort as sbsort, subc.desc as subdesc, subc.name as subcategory, subc.lang as subcategorylang, ssubc.sort as subsort, ssubc.desc as ssubdesc, ssubc.lang as secondsubcategorylang, ssubc.name as secondsubcategory");

        $this->db->from($this->tb_services . " s");
        $this->db->join($this->tb_categories . " c", "s.cate_id = c.id", 'left');
        $this->db->join($this->tb_subcategories . " subc", "s.sub_cat_id = subc.id", 'left');
        $this->db->join($this->tb_secondsubcategories . " ssubc", "s.second_sub_cat_id = ssubc.id", 'left');
        $this->db->join($this->tb_users . " usr", "s.uid = usr.id", 'left');

        $this->db->where("s.status", "1");
        $this->db->where("c.status", "1");
        $this->db->where("s.add_type", trim($id));

        //$this->db->where("subc.status", "1");
        //$this->db->where("ssubc.status", "1");

        $query = $this->db->get();
        if ($query->result()) {
            return $data = $query->result();
        } else {
            false;
        }
    }

    function get_order_id($id, $uid) {
        
        $this->db->select("id as order, status, charge, start_counter as start_count, remains,comment,comment_link");
        $this->db->from($this->tb_orders);
        $this->db->where("id", $id);
        //$this->db->where("uid", $uid);
        $query = $this->db->get();

        $result = $query->row();
        if (!empty($result)) {
            switch ($result->status) {
                case 'completed':
                    $result->status = 'Completed';
                    break;
                case 'completed':
                    $result->status = 'Completed';
                    break;
                case 'processing':
                    $result->status = 'Processing';
                    break;
                case 'pending':
                    $result->status = 'Pending';
                    break;
                case 'inprogress':
                    $result->status = 'In progress';
                    break;
                case 'partial':
                    $result->status = 'Partial';
                    break;
                case 'cancelled':
                    $result->status = 'Cancelled';
                    break;
                case 'refunded':
                    $result->status = 'Refunded';
                    break;
            }
            return $result;
        }
        return false;
    }

    function update_or_insert_ticket($data) {

        $ids = $data['ids'];
        $this->db->select("*");
        $this->db->where("ids", $ids);
        $this->db->from("tickets");
        $query = $this->db->get();
        $tickets = $query->result_array();

        if (count($tickets) > 0) {//have to update
            $this->db->where("ids", $ids);

            $this->db->update('tickets', $data);
            return $tickets[0]["id"];
        }
        else {//insert
            //$data["uid"] = 0;

            $data["send_api_provider_id"] = "NULL";
            $this->db->insert("tickets", $data);
            return $this->db->insert_id();
        }
    }

    function update_or_insert_messages($data) {
        $ids = $data['ids'];
        $this->db->select("*");
        $this->db->where("ids", $ids);
        $this->db->from("ticket_messages");
        $query = $this->db->get();
        $tickets = $query->result_array();
        if (count($tickets) > 0) {//have to update
            $this->db->where("ids", $ids);
            $this->db->update('ticket_messages', $data);
            return $tickets[0]["id"];
        } else {//insert
            $data["uid"] = 0;
            $data["is_read"] = 1;
            $this->db->insert("ticket_messages", $data);
            return $this->db->insert_id();
        }
    }

    function get_messages($ticket_messages_id) {
        $data = array();
        $this->db->select("*");
        $this->db->where("id", $ticket_messages_id);
        $this->db->from("ticket_messages");
        $query = $this->db->get()->row();
        return $query->message;
    }

    function get_services_mediaList() {
        $data = array();
        $this->db->select("m.*");
        $this->db->from($this->tb_services . " s");
        $this->db->join($this->tb_services_media . " m", "s.media_url = m.media_id", 'left');
        $this->db->where("s.status", "1");
        $this->db->where("m.status", "0");

        $query = $this->db->get();
        if ($query->result()) {
            return $data = $query->result();
        } else {
            false;
        }
    }


    function getServiceMedia($id) {
        $data = array();
        $this->db->select("m.*");
        $this->db->from($this->tb_services . " s");
        $this->db->join($this->tb_services_media . " m", "s.media_url = m.media_id", 'left');
        $this->db->where("s.media_url", $id);
        $this->db->where("m.status", "0");

        $query = $this->db->get();
        if ($query->result()) {
            return $data = $query->result();
        } else {
            false;
        }
    }

    public function getSellerUserID($orderID) {

        $userID = 10;
        $order = $this->db->where('id', $orderID)->get('orders')->row();
        if ($order) {
            $userID = $order->uid;   
        }

        return $userID;
    }

    public function insertOrUpdateTicket($data) {

        $ticket = $this->db->where('ids', $data['ids'])->get('tickets')->row();
        if (empty($ticket)) {
            $this->db->insert('tickets', $data);
            return $this->db->insert_id();
        }
        else {
            $this->db->update('tickets', $data, ['ids' => $data['ids']]);
        }

        return $ticket->id;
    }

    public function insertORUpdateMessages($messages, $ticketID) {

        $savedMessages = $this->db->where('ticket_id', $ticketID)->get('ticket_messages')->result();
        foreach ($messages as $key => $message) {
            $message['ticket_id'] = $ticketID;
            $message['uid'] = 0;

            //Remove fields
            unset($message['sender_first_name']);
            unset($message['sender_last_name']);
            unset($message['sender_email']);
            unset($message['id']);

            $check = $this->db->where('ids', $message['ids'])->get('ticket_messages')->row();
            if (empty($check)) {
                $this->db->insert('ticket_messages', $message);
            }
        }
    }

    public function getOrder($id) {
        $response = $this->db->where("id", $id)->get($this->tb_orders);
        return $response->row();
    }

    public function getService($id) {
        $response = $this->db->where("id", $id)->get($this->tb_services);
        return $response->row();
    }

    public function getTicketWithIDs($ids) {
        $response = $this->db->where('ids', $ids)->get('tickets');
        return $response->row();
    }
}
