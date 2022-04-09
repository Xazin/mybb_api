<?php

class ApiError {
    private $success = false;
    private $message = 'Something went wrong';

    public function __construct($success, $message) {
        $this->success = $success;
        $this->message = $message;
    }

    public function display() {
        echo json_encode(array('success' => $this->success, 'message' => $this->message), JSON_PRETTY_PRINT);
    }
}
