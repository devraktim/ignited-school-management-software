<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class JobStatusController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("JobStatus");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->JobStatus->get()
            );
            
            $this->load->view("master/job_status", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("job_status")) {
                $data = array(
                    "name" => $this->input->post('job_status'),
                    "created_at" => date("Y-m-d")
                );

                $this->JobStatus->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/job-status/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('job_status')
            ];

            $this->JobStatus->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/job-status/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->JobStatus->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/job-status/");
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