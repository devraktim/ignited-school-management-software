<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AbsentReasonController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("AbsentReason");
    }

    public function index() {
        if(!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "records" => $this->AbsentReason->get()
        );
        
        $this->load->view("absent_reason/index", $data);
    }

    public function store() {
        if(!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "name" => $this->input->post('reason'),
            "created_at" => date("Y-m-d")
        );

        $this->AbsentReason->insert($data);
        $this->session->set_flashdata("success", "New record inserted");
        
        return redirect(base_url() . "masters/absent-reasons/");
    }

    public function update($id) {
        if(!$this->session->user) {
            return redirect(base_url());
        }
       
        $data = [
            "name" => $this->input->post('reason')
        ];

        $this->AbsentReason->update($id, $data);

        $this->session->set_flashdata("success", "Record updated");
        return redirect(base_url() . "masters/absent-reasons/");
    }

    public function delete($id) {
        if(!$this->session->user) {
            return redirect(base_url());
        }

        $this->AbsentReason->delete($id);

        $this->session->set_flashdata("success", "Record deleted");
        return redirect(base_url() . "masters/absent-reasons/");
    }
}
