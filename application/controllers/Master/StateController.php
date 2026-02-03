<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class StateController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("State");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->State->get()
            );
            
            $this->load->view("state/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("state")) {
                $data = array(
                    "name" => $this->input->post('state'),
                    "created_at" => date("Y-m-d")
                );

                $this->State->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/states/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('state')
            ];

            $this->State->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/states/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->State->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/states/");
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