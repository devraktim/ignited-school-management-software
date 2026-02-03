<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ConductController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Conduct");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Conduct->get()
            );
            
            $this->load->view("master/conduct", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('conduct'),
                "created_at" => date("Y-m-d")
            );

            $this->Conduct->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "masters/conducts/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('conduct')
            ];

            $this->Conduct->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/conducts/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Conduct->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/conducts/");
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