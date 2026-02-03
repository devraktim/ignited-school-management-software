<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class PunctualityController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Punctuality");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Punctuality->get()
            );
            
            $this->load->view("master/punctuality", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('punctuality'),
                "created_at" => date("Y-m-d")
            );

            $this->Punctuality->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "masters/punctualities/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('punctuality')
            ];

            $this->Punctuality->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/punctualities/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Punctuality->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/punctualities/");
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