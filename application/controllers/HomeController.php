<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class HomeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademySession");
        }

        public function index() {
            
            if($this->session->user) {
                $academy_sessions = $this->AcademySession->get();
                $open_to_create_new_session = count($academy_sessions) > 1 ? false : true;

                $this->load->view("dashboard.php", ["open_to_create_new_session" => $open_to_create_new_session]);
            }
            else {
                $academy_sessions = $this->AcademySession->get();
                
                $this->load->view("auth/login", array("academy_sessions" => $academy_sessions));
            }
        }
    }