<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EvolutionGradeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("EvolutionGrade");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->EvolutionGrade->get()
            );
            
            $this->load->view("master/evolution_grades.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("evolution_grade")) {
                $data = array(
                    "name" => $this->input->post('evolution_grade'),
                    "short_name" => $this->input->post('short_name'),
                    "created_at" => date("Y-m-d")
                );

                $this->EvolutionGrade->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/evolution-grades/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('evolution_grade'),
                "short_name" => $this->input->post('short_name'),
            ];

            $this->EvolutionGrade->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/evolution-grades/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->EvolutionGrade->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/evolution-grades/");
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