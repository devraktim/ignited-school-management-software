<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SubjectController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Subject");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Subject->get()
            );
            
            $this->load->view("subject/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("subject")) {
                $data = array(
                    "name" => $this->input->post('subject'),
                    "created_at" => date("Y-m-d")
                );

                $this->Subject->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/subjects/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('subject')
            ];

            $this->Subject->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/subjects/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Subject->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/subjects/");
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