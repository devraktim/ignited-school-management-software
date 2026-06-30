<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $user_id;
    public $role;

    public function __construct()
    {
        parent::__construct();
    }

    protected function success($data = [])
    {
        echo json_encode([
            "success" => true,
            "data" => $data,
            "error" => null
        ]);
        exit;
    }

    protected function error($code, $message, $status = 400)
    {
        http_response_code($status);
        echo json_encode([
            "success" => false,
            "data" => null,
            "error" => [
                "code" => $code,
                "message" => $message
            ]
        ]);
        exit;
    }

    protected function auth()
    {
        $headers = $this->input->request_headers();

        if (!isset($headers['Authorization'])) {
            $this->error('UNAUTHORIZED', 'Token missing', 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $this->load->model('Api_model');
        $user = $this->Api_model->getUserByToken($token);

        if (!$user) {
            $this->error('UNAUTHORIZED', 'Invalid token', 401);
        }

        $this->user_id = $user->user_id;
        $this->role = $user->role;
    }
}