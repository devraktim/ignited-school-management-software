<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ExamController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Exam");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Exam->get()
            );
            
            $this->load->view("exam/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("exam")) {
                $data = array(
                    "name" => $this->input->post('exam'),
                    "short_name" => $this->input->post('short_name'),
                    "component" => $this->input->post('component'),
                    "created_at" => date("Y-m-d")
                );

                $this->Exam->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/exams/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('exam'),
                "short_name" => $this->input->post('short_name'),
                "component" => $this->input->post('component'),
            ];

            $this->Exam->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/exams/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Exam->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/exams/");
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