<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ResignationController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("Resignation");
    }

    public function index() {
        if(!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "records" => $this->Resignation->get()
        );
        
        $this->load->view("resignation/index", $data);
    }

    public function store() {
        if(!$this->session->user) {
            return redirect(base_url());
        }

   
        $data = array(
            "name" => $this->input->post('name'),
            "created_at" => date("Y-m-d")
        );

        $this->Resignation->insert($data);
        $this->session->set_flashdata("success", "New record inserted");
        
        return redirect(base_url() . "masters/resignations/");
    }

    public function update($id) {
        if(!$this->session->user) {
            return redirect(base_url());
        }
       
        $data = [
            "name" => $this->input->post('name')
        ];

        $this->Resignation->update($id, $data);

        $this->session->set_flashdata("success", "Record updated");
        return redirect(base_url() . "masters/resignations/");
    }

    public function delete($id) {
        if(!$this->session->user) {
            return redirect(base_url());
        }

        $this->Resignation->delete($id);

        $this->session->set_flashdata("success", "Record deleted");
        return redirect(base_url() . "masters/resignations/");
    }
}
