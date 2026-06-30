<?php
class Chats extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->auth();
        $this->load->model('Chat_model');
    }

    public function classMessages($class_id)
    {
        $student = $this->db->get_where('students',['id'=>$this->user_id])->row();

        $messages = $this->Chat_model->getClassMessages($class_id, $student->section_id);

        $this->success(["messages"=>$messages]);
    }

    public function sendClassMessage($class_id)
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['text'])) {
            $this->error('EMPTY_MESSAGE','Message required');
        }

        $student = $this->db->get_where('students',['id'=>$this->user_id])->row();

        if ($this->role == 'teacher') {

            if (!$this->Chat_model->isClassTeacher($this->user_id, $class_id, $student->section_id)) {
                $this->error('FORBIDDEN','Only class teacher can send');
            }
        }

        $id = $this->Chat_model->sendClassMessage([
            "sender_id"=>$this->user_id,
            "sender_role"=>$this->role,
            "receiver_type"=>"class",
            "class_id"=>$class_id,
            "section_id"=>$student->section_id,
            "message"=>$input['text'],
            "created_at"=>date('Y-m-d H:i:s')
        ]);

        $this->success(["message_id"=>$id]);
    }

    public function individualMessages($id)
    {
        $other_id = (int)$id;

        if ($this->role == 'student') {
            $other_role = 'teacher';
        } else {
            $other_role = 'student';
        }

        $messages = $this->Chat_model->getIndividualMessages(
            $this->user_id,
            $this->role,
            $other_id,
            $other_role
        );

        $this->success(["messages"=>$messages]);
    }

    public function sendIndividualMessage($id)
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['text'])) {
            $this->error('EMPTY_MESSAGE','Message required');
        }

        $receiver_id = (int)$id;

        if ($this->role == 'student') {

            // student → teacher
            if (!$this->Chat_model->canStudentMessageTeacher($this->user_id, $receiver_id)) {
                $this->error('FORBIDDEN','You can only message your class teacher');
            }

            $receiver_role = 'teacher';

        } else {

            // teacher → student
            if (!$this->Chat_model->canTeacherMessageStudent($this->user_id, $receiver_id)) {
                $this->error('FORBIDDEN','You can only message your students');
            }

            $receiver_role = 'student';
        }

        $id = $this->Chat_model->sendIndividualMessage([
            "sender_id"=>$this->user_id,
            "sender_role"=>$this->role,
            "receiver_id"=>$receiver_id,
            "receiver_role"=>$receiver_role,
            "receiver_type"=>"individual",
            "message"=>$input['text'],
            "created_at"=>date('Y-m-d H:i:s')
        ]);

        $this->success(["message_id"=>$id]);
    }
}