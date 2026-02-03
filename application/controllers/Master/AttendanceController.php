<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class AttendanceController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Attendance");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Attendance->get()
            );
            
            $this->load->view("master/attendance", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "name" => $this->input->post('attendance'),
                "created_at" => date("Y-m-d")
            );

            $this->Attendance->insert($data);
            $this->session->set_flashdata("success", "New record inserted");
            
            return redirect(base_url() . "masters/attendances/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('attendance')
            ];

            $this->Attendance->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/attendances/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Attendance->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/attendances/");
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