<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SessionController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("AcademySession");
            $this->load->model("ClassSection");
            $this->load->model("ExamPaper");
            $this->load->model("StudentSubject");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $academy_sessions = $this->AcademySession->get();

            $this->load->view("session/index", ["academy_sessions" => $academy_sessions]);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("session")) {
                $data = array(
                    "display_format" => $this->input->post('display_format'),
                    "start"          => $this->input->post('start'),
                    "end"            => $this->input->post('end')
                );

                if($session_id = $this->AcademySession->insert($data))
                {
                    $this->ClassSection->copy_data($session_id);
                    $this->ExamPaper->copy_data($session_id);
                    // $this->StudentSubject->copy_data($session_id);
                }
                
                
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/sessions/");

        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

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