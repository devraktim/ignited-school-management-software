<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class CategoryController extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model("Category");
        }

        public function index() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $data = array(
                "records" => $this->Category->get()
            );
            
            $this->load->view("category/index", $data);
        }

        public function store() {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            if($this->form_validation->run("category")) {
                $data = array(
                    "name" => $this->input->post('category'),
                    "created_at" => date("Y-m-d")
                );

                $this->Category->insert($data);
                $this->session->set_flashdata("success", "New record inserted");
            }
            return redirect(base_url() . "masters/categories/");
        }

        public function update($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }
           
            $data = [
                "name" => $this->input->post('category')
            ];

            $this->Category->update($id, $data);

            $this->session->set_flashdata("success", "Record updated");
            return redirect(base_url() . "masters/categories/");

        }

        public function delete($id) {
            if(!$this->session->user) {
                return redirect(base_url());
            }

            $this->Category->delete($id);

         	$this->session->set_flashdata("success", "Record deleted");
            return redirect(base_url() . "masters/categories/");
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