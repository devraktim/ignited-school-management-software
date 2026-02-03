<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ExpressivenessController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Expressivenesses");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Expressivenesses->get()
            );
            
            $this->load->view("master/expressiveness", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('expressiveness'),
                "created_at" => date("Y-m-d")
            );

            $this->Expressivenesses->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "masters/expressivenesses/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('expressiveness')
            ];

            $this->Expressivenesses->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/expressivenesses/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Expressivenesses->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/expressivenesses/");
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