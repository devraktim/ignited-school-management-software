<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParticipationController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary models or libraries here
        $this->load->model("Participation");
    }

    public function index() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "records" => $this->Participation->get()
        );

        $this->load->view("master/participation", $data);
    }

    public function store() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "name" => $this->input->post('participation'),
            "created_at" => date("Y-m-d")
        );

        $this->Participation->insert($data);
        $this->session->set_flashdata("success", "New record inserted");
            
        return redirect(base_url() . "masters/participations/");
    }

    public function update($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = [
            "name" => $this->input->post('participation')
        ];

        $this->Participation->update($id, $data);

        $this->session->set_flashdata("success", "Record updated");
        return redirect(base_url() . "masters/participations/");
    }

    public function delete($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $this->Participation->delete($id);

        $this->session->set_flashdata("success", "Record deleted");
        return redirect(base_url() . "masters/participations/");
    }

    // Additional methods as needed

}
