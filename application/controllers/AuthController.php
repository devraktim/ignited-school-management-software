<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class AuthController extends CI_Controller {
        public function __construct() {
            parent::__construct();

            $this->load->model("User");
            $this->load->model("AcademySession");
            $this->load->model("Employee");
        }

        public function register() {
            $username = $this->input->post("username");
            $password = $this->input->post("password");

            if(!$username || !$password) {
                $this->session->set_flashdata('error', "Please enter your username and password");
                return redirect(base_url());
            }

            $user = $this->User->get($username);

            if($user) {
                $this->session->set_flashdata('error', "This username is already exist");
                return redirect(base_url());
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $this->User->add($username, $hash);

            $user = $this->User->get($username);
            $this->session->user = ["id" => $user->id, "username" => $user->username];

            // $this->session->set_flashdata('success', "Your account has been created");
            return redirect(base_url());
        }

        public function login() {
        
            if ($this->form_validation->run("signin") == FALSE) {

                $academy_sessions = $this->AcademySession->get();
                $this->load->view("auth/login", array("academy_sessions" => $academy_sessions));
            }
            else {

                $username = $this->input->post("username");
                $password = $this->input->post("password");
                $academy_session = $this->AcademySession->get($this->input->post("session"));

                $user = $this->User->get($username);

                $employee = $this->Employee->get($user->employee_id);

                $permissions = $this->User->get_permissions($user->employee_id);

                if($employee['status'] == "INACTIVE" || $employee['deleted'] == 1 || $user->status == "INACTIVE") {
                    $this->session->set_flashdata('error', "You are not authenticate");
                }
                elseif(password_verify($password, $user->hash)) {
                    $this->session->user = [
                        "id"                    => $user->id,
                        "employee_id"           => $user->employee_id,
                        "name"                  => $user->name,
                        "image"                 => $employee['image'], 
                        "sex"                   => $employee['sex'], 
                        "username"              => $user->username,
                        "academy_session_id"    => $academy_session['id'],
                        "academy_session_start" => $academy_session['start'],
                        "academy_session_end"   => $academy_session['end'],
                        "permissions"           => $permissions
                    ];
                    
                    $this->session->academy_session = array(
                        "current_session" => array(
                            "id" => $academy_session['id'],
                            "start" => $academy_session['start'],
                            "end" => $academy_session['end']
                        ),
                    );
                }
                else {
                    $this->session->set_flashdata('error', "You have entered wrong username or password");
                }
                return redirect(base_url());
            }
        }

        public function edit_password() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->load->view("auth/change_password");
        }

        public function update_password() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $password = $this->input->post('password');

            $this->User->update($this->session->user["id"], array(
                "hash" => password_hash($password, PASSWORD_BCRYPT)
            ));

            $this->session->set_flashdata("success", "Password updated successfully");
            return redirect(base_url() . "change-password");
        }
        
        public function reset_user_password() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $password = "abc";
            // $password = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 8)), 0, 8);
            $id = $this->input->post('id');
            
            $this->User->reset_password($id, array(
                "hash" => password_hash($password, PASSWORD_BCRYPT)
            ));

            $this->session->set_flashdata("success", "Password updated successfully");
            return redirect(base_url() . "security/users/");
        }
    
        public function store_new_user_password() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $password = $this->input->post('password');

            $this->User->update($this->session->user["id"], array(
                "hash" => password_hash($password, PASSWORD_BCRYPT)
            ));

            $this->session->set_flashdata("success", "Password updated successfully");
            return redirect(base_url() . "change-password");
        }

        public function logout(){
            $this->session->sess_destroy();
            return redirect(base_url());
        }
    }