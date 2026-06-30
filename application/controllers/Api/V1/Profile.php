<?php
class Profile extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->auth();
    }

    public function index()
    {
        if ($this->role == 'student') {
            $user = $this->db->get_where('students',['id'=>$this->user_id])->row();
            $this->load->model('Auth_model');
            $this->success($this->Auth_model->formatStudent($user));
        } else {
            $user = $this->db->get_where('employees',['id'=>$this->user_id])->row();
            $this->load->model('Auth_model');
            $this->success($this->Auth_model->formatTeacher($user));
        }
    }
}