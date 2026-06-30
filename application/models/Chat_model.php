<?php
class Chat_model extends CI_Model {

    public function isClassTeacher($employee_id, $class_id, $section_id)
    {
        return $this->db
            ->where('employee_id', $employee_id)
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->get('class_section_employee')
            ->num_rows() > 0;
    }

    public function sendClassMessage($data)
    {
        $this->db->insert('messages', $data);
        return $this->db->insert_id();
    }

    public function getClassMessages($class_id, $section_id)
    {
        return $this->db
            ->where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->order_by('id','ASC')
            ->get('messages')
            ->result();
    }

    public function canStudentMessageTeacher($student_id, $teacher_id)
    {
        $student = $this->db->get_where('students', ['id'=>$student_id])->row();

        return $this->db
            ->where('employee_id', $teacher_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->get('class_section_employee')
            ->num_rows() > 0;
    }

    public function canTeacherMessageStudent($teacher_id, $student_id)
    {
        $student = $this->db->get_where('students', ['id'=>$student_id])->row();

        return $this->db
            ->where('employee_id', $teacher_id)
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->get('class_section_employee')
            ->num_rows() > 0;
    }

    public function sendIndividualMessage($data)
    {
        $this->db->insert('messages', $data);
        return $this->db->insert_id();
    }

    public function getIndividualMessages($user_id, $role, $other_id, $other_role)
    {
        return $this->db
            ->group_start()
                ->group_start()
                    ->where('sender_id', $user_id)
                    ->where('sender_role', $role)
                    ->where('receiver_id', $other_id)
                    ->where('receiver_role', $other_role)
                ->group_end()
                ->or_group_start()
                    ->where('sender_id', $other_id)
                    ->where('sender_role', $other_role)
                    ->where('receiver_id', $user_id)
                    ->where('receiver_role', $role)
                ->group_end()
            ->group_end()
            ->order_by('id','ASC')
            ->get('messages')
            ->result();
    }
}