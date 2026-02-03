<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SettingController extends CI_Controller {
        public function __construct() {
            parent::__construct();

            $this->load->model("Setting");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
        }


        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $settings = [];
            $personnel_settings = $this->Setting->get("personnel");

            for($i = 0 ; $i < count($personnel_settings) ; $i++) {
                $settings[$personnel_settings[$i]['key_name']] = $personnel_settings[$i]['value'];
            };

            $data = array(
                "settings"      => $settings
            );  

            $this->load->view("employee/setting", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            

            $keys = array_keys($_POST);
            $values = array_values($_POST);

            $data = array();

            for($i = 0 ; $i < count($keys) ; $i++) {
                $data[] = [
                    "module" => "personnel",
                    "key_name" => $keys[$i],
                    "value" => $values[$i]
                ];
            };

            $this->Setting->insert_or_update($data);

            $this->session->set_flashdata("success", "New record inserted");
            return redirect(base_url() . "personnel/settings/create");

        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
 
        }
       
    //    public function restore($id) {
    //         if(!$this->session->user) {
    //             return redirect(base_url());
    //         }

    //         $this->User->restore($id);

    //      	$this->session->set_flashdata("success", "Record restored");
    //         return redirect(base_url() . "User");
    //     }
    }