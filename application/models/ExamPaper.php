<?php
defined("BASEPATH") or exit("No direct script access allowed");

class ExamPaper extends CI_Model
{
    private $table = "exam_papers";

    public function get($id = null)
    {
        if ($id) {
            return $this->db
                ->where("id", $id)
                ->get($this->table)
                ->row_array();
        } else {
            return $this->db
                ->from($this->table)
                ->where(
                    "session_id",
                    $this->session->academy_session["current_session"]["id"]
                )
                ->get()
                ->result_array();
        }
    }

    public function get_where($clauses)
    {
        $clauses["session_id"] =
            $this->session->academy_session["current_session"]["id"];

        return $this->db
            ->where($clauses)
            ->get($this->table)
            ->row_array();
    }

    public function get_where_v2($clauses)
    {
        $clauses["session_id"] =
            $this->session->academy_session["current_session"]["id"];

        return $this->db
            ->where($clauses)
            ->get($this->table)
            ->result_array();
    }

    public function copy_data($session_id)
    {
        $records = $this->db
            ->from($this->table)
            ->where("session_id", 1)
            ->get()
            ->result_array();

        $data = [];

        foreach ($records as $record) {
            $d = $record;

            $d["session_id"] = $session_id;

            unset($d["id"]);

            $data[] = $d;
        }

        return $this->db->insert_batch($this->table, $data);
    }

    public function get_exams($clauses)
    {
        $clauses["session_id"] =
            $this->session->academy_session["current_session"]["id"];

        return $this->db
            ->where($clauses)
            ->get($this->table)
            ->result_array();
    }

    public function get_subjects($clauses)
    {
        $clauses["session_id"] =
            $this->session->academy_session["current_session"]["id"];

        return $this->db
            ->where($clauses)
            ->get($this->table)
            ->result_array();
    }

    public function insert($data)
    {
        $data["session_id"] =
            $this->session->academy_session["current_session"]["id"];
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where("id", $id)->update($this->table, $data);
    }

    public function search($clauses)
    {
        $clauses["session_id"] =
            $this->session->academy_session["current_session"]["id"];

        return $this->db
            ->select("*")
            ->from($this->table)
            ->where($clauses)
            ->get()
            ->result_array();
    }

    public function delete($id)
    {
        return $this->db->where("id", $id)->delete($this->table);
    }

    public function getMarksEntryTeachers(
        $paperId,
        $classId,
        $sectionId = '',
        $subjectId = ''
    ) {
        $this->db
            ->select("
                exam_marks_entry_permissions.id,
                exam_marks_entry_permissions.status,

                employees.id as teacher_id,

                CONCAT(
                    COALESCE(employees.f_name,''),
                    ' ',
                    COALESCE(employees.m_name,''),
                    ' ',
                    COALESCE(employees.l_name,'')
                ) as teacher_name
            ")
            ->from("exam_marks_entry_permissions")
            ->join(
                "employees",
                "employees.id = exam_marks_entry_permissions.employee_id"
            )
            ->where("exam_paper_id", $paperId)
            ->where("class_id", $classId);

        if ($sectionId != '') {
            $this->db->where("section_id", $sectionId);
        }

        if ($subjectId != '') {
            $this->db->where("subject_id", $subjectId);
        }

        return $this->db->get()->result_array();
    }

    public function saveMarksEntryTeachers(
        $paperId,
        $classId,
        $sectionId,
        $subjectId,
        $teacherIds = []
    ) {
        $this->db
            ->where("exam_paper_id", $paperId)
            ->where("class_id", $classId)
            ->where("section_id", $sectionId)
            ->where("subject_id", $subjectId)
            ->delete("exam_marks_entry_permissions");

        foreach ($teacherIds as $teacherId) {
            $this->db->insert("exam_marks_entry_permissions", [
                "exam_paper_id" => $paperId,
                "class_id" => $classId,
                "section_id" => $sectionId,
                "subject_id" => $subjectId,
                "employee_id" => $teacherId,
                "status" => 1,
            ]);
        }

        return true;
    }

    public function toggleMarksEntryTeacher(
        $paperId,
        $classId,
        $sectionId,
        $subjectId,
        $teacherId,
        $status
    ) {
        return $this->db
            ->where("exam_paper_id", $paperId)
            ->where("class_id", $classId)
            ->where("section_id", $sectionId)
            ->where("subject_id", $subjectId)
            ->where("employee_id", $teacherId)

            ->update("exam_marks_entry_permissions", [
                "status" => $status,
            ]);
    }

    public function removeMarksEntryTeacher(
        $paperId,
        $classId,
        $sectionId,
        $subjectId,
        $teacherId
    ) {
        return $this->db
            ->where("exam_paper_id", $paperId)
            ->where("class_id", $classId)
            ->where("section_id", $sectionId)
            ->where("subject_id", $subjectId)
            ->where("employee_id", $teacherId)

            ->delete("exam_marks_entry_permissions");
    }

    public function getActiveTeachers()
    {
        return $this->db
            ->select(
                "
id,
CONCAT(
COALESCE(f_name,''),
' ',
COALESCE(m_name,''),
' ',
COALESCE(l_name,'')
) as teacher_name
"
            )
            ->where("deleted", 0)
            ->where("status", "ACTIVE")
            ->order_by("f_name")
            ->get("employees")
            ->result_array();
    }

public function toggleSubjectLock(
    $paperId,
    $classId,
    $sectionId,
    $subjectId,
    $status,
    $userId
){

    $row =
        $this->db
        ->where('exam_paper_id',$paperId)
        ->where('class_id',$classId)
        ->where('section_id',$sectionId)
        ->where('subject_id',$subjectId)
        ->get('exam_marks_subject_lock_permissions')
        ->row_array();

    if($row){

        return $this->db
        ->where('id',$row['id'])
        ->update(
            'exam_marks_subject_lock_permissions',
            [
                'is_locked'=>$status,
            ]
        );
    }

    return $this->db->insert(
        'exam_marks_subject_lock_permissions',
        [
            'exam_paper_id'=>$paperId,
            'class_id'=>$classId,
            'section_id'=>$sectionId,
            'subject_id'=>$subjectId,
            'is_locked'=>$status,
        ]
    );
}

public function isSubjectLocked(
    $paperIds,
    $classId,
    $sectionId,
    $subjectId
){

    $this->db
        ->where_in(
            'exam_paper_id',
            $paperIds
        );

    $this->db
        ->where(
            'class_id',
            $classId
        );

    $this->db
        ->where(
            'section_id',
            $sectionId
        );

    $this->db
        ->where(
            'subject_id',
            $subjectId
        );

    $this->db
        ->where(
            'is_locked',
            1
        );

    return $this->db
            ->count_all_results(
                'exam_marks_subject_lock_permissions'
            ) > 0;

}

public function toggleExamLock(
    $paperId,
    $classId,
    $sectionId,
    $status
){

    $row = $this->db
        ->where('exam_paper_id', $paperId)
        ->where('class_id', $classId)
        ->where('section_id', $sectionId)
        ->get('exam_marks_lock_permissions')
        ->row_array();

    if(!empty($row)){

        return $this->db
            ->where('id', $row['id'])
            ->update(
                'exam_marks_lock_permissions',
                [
                    'is_locked' => $status
                ]
            );
    }

    return $this->db->insert(
        'exam_marks_lock_permissions',
        [
            'exam_paper_id' => $paperId,
            'class_id'      => $classId,
            'section_id'    => $sectionId,
            'is_locked'     => $status
        ]
    );
}

public function isExamLocked(
    $paperIds,
    $classId,
    $sectionId
){

    $this->db
        ->where_in(
            'exam_paper_id',
            $paperIds
        );

    $this->db
        ->where(
            'class_id',
            $classId
        );

    $this->db
        ->where(
            'section_id',
            $sectionId
        );

    $this->db
        ->where(
            'is_locked',
            1
        );

    return $this->db
        ->count_all_results(
            'exam_marks_lock_permissions'
        ) > 0;
}

        public function hasMarksEntryPermission(
            $paperId,
            $classId,
            $sectionId,
            $subjectId,
            $employeeId
        ) {

            return $this->db
                ->where("exam_paper_id", $paperId)
                ->where("class_id", $classId)
                ->where("section_id", $sectionId)
                ->where("subject_id", $subjectId)
                ->where("employee_id", $employeeId)
                ->where("status", 1)
                ->count_all_results("exam_marks_entry_permissions") > 0;

        }

public function getEmployeeClasses($employeeId)
{
    return $this->db
        ->select('classes.id, classes.name')
        ->from('exam_marks_entry_permissions')
        ->join('classes', 'classes.id = exam_marks_entry_permissions.class_id')
        ->where('exam_marks_entry_permissions.employee_id', $employeeId)
        ->where('exam_marks_entry_permissions.status', 1)
        ->where('classes.deleted', 0)
        ->group_by('classes.id')
        ->get()
        ->result_array();
}

// public function getEmployeeSections($employeeId, $classId)
// {
//     return $this->db
//         ->select('sections.id, sections.name')
//         ->from('exam_marks_entry_permissions')
//         ->join('session_class_sections',
//             'session_class_sections.class_id = exam_marks_entry_permissions.class_id'
//         )
//         ->join('sections',
//             'sections.id = session_class_sections.section_id'
//         )
//         ->where('exam_marks_entry_permissions.employee_id', $employeeId)
//         ->where('exam_marks_entry_permissions.status', 1)
//         ->where('exam_marks_entry_permissions.class_id', $classId)
//         ->where('session_class_sections.class_id', $classId)
//         ->where('sections.deleted', 0)
//         ->group_by('sections.id')
//         ->get()
//         ->result_array();
// }

public function getEmployeeSections(
    $employeeId,
    $classId
) {

    return $this->db
        ->distinct()
        ->select("
            sections.id,
            sections.name
        ")
        ->from("exam_marks_entry_permissions")
        ->join(
            "sections",
            "sections.id = exam_marks_entry_permissions.section_id"
        )
        ->where(
            "exam_marks_entry_permissions.employee_id",
            $employeeId
        )
        ->where(
            "exam_marks_entry_permissions.class_id",
            $classId
        )
        ->where(
            "exam_marks_entry_permissions.status",
            1
        )
        ->where(
            "sections.deleted",
            0
        )
        ->order_by(
            "sections.name",
            "ASC"
        )
        ->get()
        ->result_array();
}


public function getEmployeeExams($employeeId, $classId, $sectionId)
{
    return $this->db
        ->select('exams.id, exams.name')
        ->from('exam_marks_entry_permissions')
        ->join('exam_papers', 'exam_papers.id = exam_marks_entry_permissions.exam_paper_id')
        ->join('exams', 'exams.id = exam_papers.exam_id')
        ->where('exam_marks_entry_permissions.employee_id', $employeeId)
        ->where('exam_marks_entry_permissions.status', 1)
        ->where('exam_marks_entry_permissions.class_id', $classId)
        ->where('exam_marks_entry_permissions.section_id', $sectionId)
        ->where('exam_papers.class_id', $classId)
        ->where('exams.deleted', 0)
        ->group_by('exams.id')
        ->get()
        ->result_array();
}

// public function getEmployeeSubjects($employeeId, $classId, $sectionId, $examId)
// {
//     $rows = $this->db
//         ->select('exam_papers.subjects, exam_papers.marks')
//         ->from('exam_marks_entry_permissions')
//         ->join('exam_papers', 'exam_papers.id = exam_marks_entry_permissions.exam_paper_id')
//         ->where('exam_marks_entry_permissions.employee_id', $employeeId)
//         ->where('exam_marks_entry_permissions.status', 1)
//         ->where('exam_marks_entry_permissions.class_id', $classId)
//         ->where('exam_marks_entry_permissions.section_id', $sectionId)
//         ->where('exam_papers.exam_id', $examId)
//         ->get()
//         ->result_array();

//     $subjectIds = [];
//     $components = [];

//     foreach ($rows as $row) {

//         // subjects (comma separated)
//         if (!empty($row['subjects'])) {
//             $subjectIds = array_merge($subjectIds, explode(',', $row['subjects']));
//         }

//         // components from JSON marks
//         if (!empty($row['marks'])) {
//             $marks = json_decode($row['marks']);
//             if ($marks && isset($marks->component_id)) {
//                 $components[] = $marks->component_id;
//             }
//         }
//     }

//     $subjectIds = array_unique($subjectIds);
//     $componentIds = array_unique($components);

//     $subjects = [];
//     if (!empty($subjectIds)) {
//         $subjects = $this->db
//             ->where_in('id', $subjectIds)
//             ->where('deleted', 0)
//             ->get('subjects')
//             ->result_array();
//     }

//     $components = [];
//     if (!empty($componentIds)) {
//         $components = $this->db
//             ->where_in('id', $componentIds)
//             ->where('deleted', 0)
//             ->get('components')
//             ->result_array();
//     }

//     return [
//         'subjects'   => $subjects,
//         'components' => $components
//     ];
// }

public function getEmployeeSubjects(
    $employeeId,
    $classId,
    $sectionId,
    $examId
) {

    $rows = $this->db
        ->select("
            exam_marks_entry_permissions.subject_id,
            exam_papers.marks
        ")
        ->from("exam_marks_entry_permissions")
        ->join(
            "exam_papers",
            "exam_papers.id = exam_marks_entry_permissions.exam_paper_id"
        )
        ->where("exam_marks_entry_permissions.employee_id", $employeeId)
        ->where("exam_marks_entry_permissions.status", 1)
        ->where("exam_marks_entry_permissions.class_id", $classId)
        ->where("exam_marks_entry_permissions.section_id", $sectionId)
        ->where("exam_papers.exam_id", $examId)
        ->get()
        ->result_array();

    $subjectIds = [];
    $componentIds = [];

    foreach ($rows as $row) {

        if (!empty($row["subject_id"])) {
            $subjectIds[] = $row["subject_id"];
        }

        if (!empty($row["marks"])) {

            $marks = json_decode($row["marks"]);

            if (
                $marks &&
                isset($marks->component_id)
            ) {
                $componentIds[] = $marks->component_id;
            }
        }
    }

    $subjectIds = array_unique($subjectIds);
    $componentIds = array_unique($componentIds);

    $subjects = [];

    if (!empty($subjectIds)) {

        $subjects = $this->db
            ->where_in("id", $subjectIds)
            ->where("deleted", 0)
            ->order_by("name", "ASC")
            ->get("subjects")
            ->result_array();
    }

    $components = [];

    if (!empty($componentIds)) {

        $components = $this->db
            ->where_in("id", $componentIds)
            ->where("deleted", 0)
            ->order_by("name", "ASC")
            ->get("components")
            ->result_array();
    }

    return [
        "subjects"   => $subjects,
        "components" => $components
    ];
}
}
