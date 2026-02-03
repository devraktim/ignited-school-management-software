<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class EmployeeTypeController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("EmployeeType");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->EmployeeType->get()
            );
            
            $this->load->view("master/employee_types.php", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("employee_type")) {
                $data = array(
                    "name" => $this->input->post('employee_type'),
                    "created_at" => date("Y-m-d")
                );

                $this->EmployeeType->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/employee-types/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('employee_type')
            ];

            $this->EmployeeType->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/employee-types/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->EmployeeType->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/employee-types/");
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