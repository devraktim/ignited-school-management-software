<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherHolidayController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->user) {
            redirect(base_url());
        }
        $this->load->model("Holiday");
    }

    public function index() {
        $data["holidays"] = $this->Holiday->get_all();
        $this->load->view("master/holidays", $data);
    }

    public function store() {
        $data = [
            "name" => $this->input->post("name"),
            "holiday_date" => $this->input->post("holiday_date")
        ];

        $id = $this->Holiday->insert($data);

        echo json_encode([
            "status" => true,
            "message" => "Holiday added successfully",
            "id" => $id
        ]);
    }

    public function update($id) {
        $data = [
            "name" => $this->input->post("name"),
            "holiday_date" => $this->input->post("holiday_date")
        ];

        $this->Holiday->update($id, $data);

        echo json_encode([
            "status" => true,
            "message" => "Holiday updated successfully"
        ]);
    }

    public function delete($id) {
        $this->Holiday->delete($id);

        echo json_encode([
            "status" => true,
            "message" => "Holiday deleted successfully"
        ]);
    }
}
