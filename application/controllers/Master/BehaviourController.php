<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class BehaviourController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Behaviour");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Behaviour->get()
            );
            
            $this->load->view("master/behaviour", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('behaviour'),
                "created_at" => date("Y-m-d")
            );

            $this->Behaviour->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
                
            return redirect(base_url() . "masters/behaviours/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('behaviour')
            ];

            $this->Behaviour->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/behaviours/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Behaviour->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/behaviours/");
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