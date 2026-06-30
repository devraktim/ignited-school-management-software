<?php
class Auth_model extends CI_Model {

    public function studentLogin($username, $password)
    {
        $this->db->where('student_no', $username);
        $this->db->where('deleted', 0);
        $student = $this->db->get('students')->row();

        if (!$student) return false;

        $dob = date('dmY', strtotime($student->dob));

        if ($dob !== $password) return false;

        return $student;
    }

    public function teacherLogin($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if (!$user) return false;

        if (!password_verify($password, $user->hash)) return false;

        return $this->db->get_where('employees', ['id' => $user->employee_id])->row();
    }

    public function generateToken($user_id, $role)
    {
        $token = bin2hex(random_bytes(32));

        $this->db->insert('api_tokens', [
            'user_id' => $user_id,
            'role' => $role,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days'))
        ]);

        return $token;
    }

    public function formatStudent($s)
    {
        return [
            "id" => "s".$s->id,
            "username" => $s->student_no,
            "role" => "student",
            "name" => trim($s->f_name.' '.$s->m_name.' '.$s->l_name),
            "email" => $s->email,
            "phone" => $s->phone,
            "profileImage" => $s->image,
            "dob" => date('d F Y', strtotime($s->dob)),
            "class" => "Class ".$this->getClassName($s->class_id),
            "section" => "Section ".$this->getSectionName($s->section_id),
            "rollNumber" => $s->student_no
        ];
    }

    public function formatTeacher($t)
    {
        return [
            "id" => "t".$t->id,
            "username" => $t->email,
            "role" => "teacher",
            "name" => trim($t->f_name.' '.$t->l_name),
            "email" => $t->email,
            "phone" => $t->mobile_no,
            "profileImage" => $t->image,
            "subject" => "N/A",
            "assignedClasses" => $this->getAssignedClasses($t->id)
        ];
    }

    private function getClassName($id)
    {
        return $this->db->get_where('classes', ['id'=>$id])->row()->name ?? '';
    }

    private function getSectionName($id)
    {
        return $this->db->get_where('sections', ['id'=>$id])->row()->name ?? '';
    }

    private function getAssignedClasses($teacher_id)
    {
        $rows = $this->db->get_where('class_section_employee', [
            'employee_id' => $teacher_id
        ])->result();

        $result = [];
        foreach ($rows as $r) {
            $class = $this->getClassName($r->class_id);
            $section = $this->getSectionName($r->section_id);
            $result[] = "Class ".$class.$section;
        }
        return $result;
    }
}