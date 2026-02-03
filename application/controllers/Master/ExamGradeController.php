<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ExamGradeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("ExamGrade");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->ExamGrade->get()
            );
            
            $this->load->view("master/exam_grades.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("exam_grade")) {
                $data = array(
                    "name" => $this->input->post('exam_grade'),
                    "short_name" => $this->input->post('short_name'),
                    "created_at" => date("Y-m-d")
                );

                $this->ExamGrade->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/exam-grades/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('exam_grade'),
                "short_name" => $this->input->post('short_name'),
            ];

            $this->ExamGrade->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/exam-grades/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->ExamGrade->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/exam-grades/");
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