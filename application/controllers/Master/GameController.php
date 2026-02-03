<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary models or libraries here
        $this->load->model("Game");
    }

    public function index() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "records" => $this->Game->get()
        );

        $this->load->view("master/games", $data);
    }

    public function store() {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = array(
            "name" => $this->input->post('game'),
            "created_at" => date("Y-m-d")
        );

        $this->Game->insert($data);
        $this->session->set_flashdata("success", "New record inserted");
            
        return redirect(base_url() . "masters/games/");
    }

    public function update($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = [
            "name" => $this->input->post('game')
        ];

        $this->Game->update($id, $data);

        $this->session->set_flashdata("success", "Record updated");
        return redirect(base_url() . "masters/games/");
    }

    public function delete($id) {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $this->Game->delete($id);

        $this->session->set_flashdata("success", "Record deleted");
        return redirect(base_url() . "masters/games/");
    }

    // Additional methods as needed

}
