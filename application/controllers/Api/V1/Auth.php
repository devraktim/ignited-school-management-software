<?php
class Auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function login()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';
        $role     = $input['role'] ?? '';

        if (!$username || !$password || !$role) {
            $this->error('MISSING_FIELDS','All fields required');
        }

        if ($role == 'student') {
            $student = $this->Auth_model->studentLogin($username, $password);

            if (!$student) {
                $this->error('INVALID_CREDENTIALS','Invalid username or password.',401);
            }

            if ($student->status != 'ACTIVE') {
                $this->error('ACCOUNT_INACTIVE',$this->studentStatusMessage($student->status));
            }

            $token = $this->Auth_model->generateToken($student->id,'student');

            $this->success([
                "token"=>$token,
                "user"=>$this->Auth_model->formatStudent($student)
            ]);
        }

        if ($role == 'teacher') {

            $teacher = $this->Auth_model->teacherLogin($username, $password);

            if (!$teacher) {
                $this->error('INVALID_CREDENTIALS','Invalid username or password.',401);
            }

            if ($teacher->status != 'ACTIVE') {
                $this->error('ACCOUNT_INACTIVE','Your account is inactive.');
            }

            $token = $this->Auth_model->generateToken($teacher->id,'teacher');

            $this->success([
                "token"=>$token,
                "user"=>$this->Auth_model->formatTeacher($teacher)
            ]);
        }

        $this->error('ROLE_MISMATCH','Invalid role');
    }

    public function logout()
    {
        $headers = $this->input->request_headers();

        if (!isset($headers['Authorization'])) {
            $this->error('UNAUTHORIZED', 'Token missing', 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        $this->load->model('Api_model');
        $this->Api_model->deleteToken($token);

        $this->success([
            "message" => "Logged out successfully"
        ]);
    }

    private function studentStatusMessage($status)
    {
        switch ($status) {
            case 'INACTIVE': return 'Your account is inactive.';
            case 'WITHDRAWN': return 'You are withdrawn.';
            case 'PASSED OUT': return 'You have passed out.';
            default: return 'Access denied';
        }
    }
}