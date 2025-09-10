<?php

class User {
    public $id;
    public $is_bot;
    public $first_name;
    public $last_name;
    public $username;
    public $language_code;
    
    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->is_bot = $data['is_bot'] ?? false;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->language_code = $data['language_code'] ?? null;
    }
}

class Chat {
    public $id;
    public $type;
    public $title;
    public $username;
    public $first_name;
    public $last_name;
    
    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
    }
}

class Message {
    public $message_id;
    public $from;
    public $date;
    public $chat;
    public $text;
    public $entities;
    
    public function __construct($data) {
        $this->message_id = $data['message_id'] ?? null;
        $this->from = isset($data['from']) ? new User($data['from']) : null;
        $this->date = $data['date'] ?? null;
        $this->chat = isset($data['chat']) ? new Chat($data['chat']) : null;
        $this->text = $data['text'] ?? null;
        $this->entities = $data['entities'] ?? null;
    }
}

class Update {
    public $update_id;
    public $message;
    public $edited_message;
    public $callback_query;
    public $pre_checkout_query;
    
    public function __construct($data) {
        $this->update_id = $data['update_id'] ?? null;
        $this->message = isset($data['message']) ? new Message($data['message']) : null;
        $this->edited_message = isset($data['edited_message']) ? new Message($data['edited_message']) : null;
        $this->callback_query = isset($data['callback_query']) ? new CallbackQuery($data['callback_query']) : null;
        $this->pre_checkout_query = isset($data['pre_checkout_query']) ? new PreCheckoutQuery($data['pre_checkout_query']) : null;
    }
}

class CallbackQuery {
    public $id;
    public $from;
    public $message;
    public $data;
    
    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->from = isset($data['from']) ? new User($data['from']) : null;
        $this->message = isset($data['message']) ? new Message($data['message']) : null;
        $this->data = $data['data'] ?? null;
    }
}

class PreCheckoutQuery {
    public $id;
    public $from;
    public $currency;
    public $total_amount;
    public $invoice_payload;
    
    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->from = isset($data['from']) ? new User($data['from']) : null;
        $this->currency = $data['currency'] ?? null;
        $this->total_amount = $data['total_amount'] ?? null;
        $this->invoice_payload = $data['invoice_payload'] ?? null;
    }
}

class File {
    public $file_id;
    public $file_unique_id;
    public $file_size;
    public $file_path;
    
    public function __construct($data) {
        $this->file_id = $data['file_id'] ?? null;
        $this->file_unique_id = $data['file_unique_id'] ?? null;
        $this->file_size = $data['file_size'] ?? null;
        $this->file_path = $data['file_path'] ?? null;
    }
}

class SuccessfulPayment {
    public $currency;
    public $total_amount;
    public $invoice_payload;
    public $telegram_payment_charge_id;
    public $provider_payment_charge_id;
    
    public function __construct($data) {
        $this->currency = $data['currency'] ?? null;
        $this->total_amount = $data['total_amount'] ?? null;
        $this->invoice_payload = $data['invoice_payload'] ?? null;
        $this->telegram_payment_charge_id = $data['telegram_payment_charge_id'] ?? null;
        $this->provider_payment_charge_id = $data['provider_payment_charge_id'] ?? null;
    }
}

class Transaction {
    public $id;
    public $status;
    public $userID;
    public $amount;
    public $createdAt;
    
    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->userID = $data['userID'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
    }
}

?>