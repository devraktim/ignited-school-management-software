<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class LeadershipController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Leadership");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Leadership->get()
            );
            
            $this->load->view("master/leadership", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('leadership'),
                "created_at" => date("Y-m-d")
            );

            $this->Leadership->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
                
            return redirect(base_url() . "masters/leaderships/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('leadership')
            ];

            $this->Leadership->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/leaderships/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Leadership->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/leaderships/");
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