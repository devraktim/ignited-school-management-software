<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class NationalityController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Nationality");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Nationality->get()
            );
            
            $this->load->view("nationality/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("nationality")) {
                $data = array(
                    "name" => $this->input->post('nationality'),
                    "created_at" => date("Y-m-d")
                );

                $this->Nationality->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/nationalities/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('nationality')
            ];

            $this->Nationality->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/nationalities/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Nationality->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/nationalities/");
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