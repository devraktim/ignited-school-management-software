<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EvolutionSubjectController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("EvolutionSubject");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->EvolutionSubject->get()
            );
            
            $this->load->view("master/evolution_subjects.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("evolution_subject")) {
                $data = array(
                    "name" => $this->input->post('evolution_subject'),
                    "created_at" => date("Y-m-d")
                );

                $this->EvolutionSubject->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/evolution-subjects/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('evolution_subject'),
            ];

            $this->EvolutionSubject->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/evolution-subjects/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->EvolutionSubject->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/evolution-subjects/");
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