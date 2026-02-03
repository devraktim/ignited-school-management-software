<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApprisalOtherController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary models or libraries here
        $this->load->model("ApprisalOther");
    }

    public function index() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "records" => $this->ApprisalOther->get()
        );

        $this->load->view("master/apprisal_other", $data);
    }

    public function store() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "name" => $this->input->post('other'),
            "created_at" => date("Y-m-d")
        );

        $this->ApprisalOther->insert($data);
        $this->session->set_flashdata("success", "New record inserted");
            
        return redirect(base_url() . "masters/apprisal-others/");
    }

    public function update($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = [
            "name" => $this->input->post('other')
        ];

        $this->ApprisalOther->update($id, $data);

        $this->session->set_flashdata("success", "Record updated");
        return redirect(base_url() . "masters/apprisal-others/");
    }

    public function delete($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $this->ApprisalOther->delete($id);

        $this->session->set_flashdata("success", "Record deleted");
        return redirect(base_url() . "masters/apprisal-others/");
    }

    // Additional methods as needed

}
