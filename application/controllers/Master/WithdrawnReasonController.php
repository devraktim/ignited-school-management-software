<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class WithdrawnReasonController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("WithdrawnReason");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->WithdrawnReason->get()
            );
            
            $this->load->view("master/withdrawal_reason.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("withdrawal_reason")) {
                $data = array(
                    "name" => $this->input->post('withdrawal_reason'),
                    "created_at" => date("Y-m-d")
                );

                $this->WithdrawnReason->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/withdrawal-reason/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('withdrawal_reason')
            ];

            $this->WithdrawnReason->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/withdrawal-reason/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->WithdrawnReason->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/withdrawal-reason/");
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