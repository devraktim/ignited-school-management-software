<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SecurityController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Employee");
            $this->load->model("User");
            $this->load->model("Security");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $users = $this->Security->get();
            $this->load->view("security/index", array("users"  => $users));
        }

        public function create() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $employees = $this->User->get_active_non_user_employee();

            $this->load->view("security/create", array("employees" => $employees));
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("permissions")) {
                $data = array(
                    "employee_id" => $this->input->post('employee_id'),
                    "student_module" => $this->input->post('student_module'),
                    "academics_module" => $this->input->post('academics_module'),
                    "fees_module" => $this->input->post('fees_module'),
                    "hostel_module" => $this->input->post('hostel_module'),
                    "personnel_module" => $this->input->post('personnel_module'),
                    "leave_module" => $this->input->post('leave_module'),
                    "payroll_module" => $this->input->post('payroll_module'),
                    "library_module" => $this->input->post('library_module'),
                    "inventory_module" => $this->input->post('inventory_module'),
                    "mess_module" => $this->input->post('mess_module'),
                    "infirmary_module" => $this->input->post('infirmary_module'),
                    "system_administrator" => $this->input->post('system_administrator'),
                );

                $this->Security->insert($data);
                
                $this->User->insert(array(
                    "employee_id" => $this->input->post('employee_id'),
                    "username" => $this->input->post('username'),
                    "hash" => password_hash("abc", PASSWORD_DEFAULT),
                    "created_at" => date("Y-m-d")
                ));
                
                $success_message = "User " . $this->input->post('username') . ' created successfully';
                
                $this->session->set_flashdata("success", $success_message);
            }
            return redirect(base_url() . "security/users/create");

            
        }

        public function show($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $employee = $this->Employee->get($id);

            echo json_encode(array("employee" => $employee));

        }

        public function edit($employee_id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $user = $this->Security->get($employee_id);

            $this->load->view("security/edit", array("user" => $user));
           
        }

        public function generate_report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }
            
            $users = $this->Security->search($_GET);
            $this->load->view("security/report", array("users" => $users));
        }

        public function update() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("permissions")) {
                $data = array(
                    "student_module" => $this->input->post('student_module'),
                    "academics_module" => $this->input->post('academics_module'),
                    "fees_module" => $this->input->post('fees_module'),
                    "hostel_module" => $this->input->post('hostel_module'),
                    "personnel_module" => $this->input->post('personnel_module'),
                    "leave_module" => $this->input->post('leave_module'),
                    "payroll_module" => $this->input->post('payroll_module'),
                    "library_module" => $this->input->post('library_module'),
                    "inventory_module" => $this->input->post('inventory_module'),
                    "mess_module" => $this->input->post('mess_module'),
                    "infirmary_module" => $this->input->post('infirmary_module'),
                    "system_administrator" => $this->input->post('system_administrator'),
                );

                $employee_id = $this->input->post("employee_id");
                $user_id = $this->input->post("user_id");

                $this->Security->update($employee_id, $data);
                
                $this->User->update($user_id, array(
                    "username" => $this->input->post('username'),
                    "status" => $this->input->post('status'),
                ));
                
                $this->session->set_flashdata("success", "Record updated");
            }
            return redirect(base_url() . "security/users/");
        }

        public function report() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->load->view("security/report_index");
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