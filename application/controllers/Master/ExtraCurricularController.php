<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExtraCurricularController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary models or libraries here
        $this->load->model("ExtraCurricular");
    }

    public function index() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "records" => $this->ExtraCurricular->get()
        );

        $this->load->view("master/extracurriculars", $data);
    }

    public function store() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "name" => $this->input->post('extracurricular'),
            "created_at" => date("Y-m-d")
        );

        $this->ExtraCurricular->insert($data);
        $this->session->set_flashdata("success", "New record inserted");
            
        return redirect(base_url() . "masters/extracurriculars/");
    }

    public function update($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = [
            "name" => $this->input->post('extracurricular')
        ];

        $this->ExtraCurricular->update($id, $data);

        $this->session->set_flashdata("success", "Record updated");
        return redirect(base_url() . "masters/extracurriculars/");
    }

    public function delete($id) {
        
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $this->ExtraCurricular->delete($id);

        $this->session->set_flashdata("success", "Record deleted");
        return redirect(base_url() . "masters/extracurriculars/");
    }

    // Additional methods as needed

}
