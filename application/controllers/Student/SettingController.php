<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SettingController extends CI_Controller {
        public function __construct() {
            parent::__construct();

            $this->load->model("AcademyClass");
            $this->load->model("StudentType");
            $this->load->model("House");
            $this->load->model("Category");
            $this->load->model("Religion");
            $this->load->model("Nationality");
            $this->load->model("State");
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
            $student_settings = $this->Setting->get("student");

            for($i = 0 ; $i < count($student_settings) ; $i++) {
                $settings[$student_settings[$i]['key_name']] = $student_settings[$i]['value'];
            };

            $data = array(
                "classes"       => $this->AcademyClass->get(),
                "student_types" => $this->StudentType->get(),
                "houses"        => $this->House->get(),
                "categories"    => $this->Category->get(),
                "religions"     => $this->Religion->get(),
                "nationalities" => $this->Nationality->get(),
                "states"        => $this->State->get(),
                "settings"      => $settings
            );  

            $this->load->view("student/setting", $data);
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
                    "module" => "student",
                    "key_name" => $keys[$i],
                    "value" => $values[$i]
                ];
            };

            $this->Setting->insert_or_update($data);

            $this->session->set_flashdata("success", "New record inserted");
            return redirect(base_url() . "students/settings/create");

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