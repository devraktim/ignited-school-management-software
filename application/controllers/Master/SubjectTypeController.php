<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SubjectTypeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("SubjectType");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->SubjectType->get()
            );
            
            $this->load->view("subject_type/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("subject_type")) {
                $data = array(
                    "name" => $this->input->post('subject_type'),
                    "created_at" => date("Y-m-d")
                );

                $this->SubjectType->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/subject-types/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('subject_type')
            ];

            $this->SubjectType->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/subject-types/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->SubjectType->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/subject-types/");
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