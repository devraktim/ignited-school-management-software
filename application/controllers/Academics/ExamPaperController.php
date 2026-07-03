<?php
defined("BASEPATH") or exit("No direct script access allowed");

class ExamPaperController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Student");
        $this->load->model("AcademyClass");
        $this->load->model("ClassSection");
        $this->load->model("Section");
        $this->load->model("Exam");
        $this->load->model("Subject");
        $this->load->model("StudentSubject");
        $this->load->model("ExamPaper");
        $this->load->model("ExamGrade");
        $this->load->model("Component");
        $this->load->model("Marks");
    }

    public function index()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $exam_papers = $this->ExamPaper->get();

        $papers = [];

        for ($i = 0; $i < count($exam_papers); $i++) {
            $paper = [
                "id" => $exam_papers[$i]["id"],
                "class" => $this->AcademyClass->get(
                    $exam_papers[$i]["class_id"]
                ),
                "exam" => $this->Exam->get($exam_papers[$i]["exam_id"]),
                "paper_type" => $exam_papers[$i]["paper_type"],
                "subjects" => [],
            ];

            if ($exam_papers[$i]["subjects"] != "") {
                $subjects = explode(",", $exam_papers[$i]["subjects"]);

                for ($j = 0; $j < count($subjects); $j++) {
                    $paper["subjects"][] = $this->Subject->get($subjects[$j]);
                }
            }

            if ($paper["paper_type"] == "component") {
                $obj = json_decode($exam_papers[$i]["marks"]);

                $paper["marks"] = json_decode($exam_papers[$i]["marks"]);

                $paper["component"] = $this->Component->get($obj->component_id);
                $paper["full_marks"] = $obj->marks->full_marks;
                $paper["pass_marks"] = $obj->marks->pass_marks;
            }

            if ($paper["paper_type"] == "mark_grade") {
                $paper["marks"] = json_decode($exam_papers[$i]["marks"]);
            }

            $papers[] = $paper;
        }

        $data = [
            "classes" => $this->AcademyClass->get(),
            "exams" => $this->Exam->get(),
            "papers" => $papers,
            "grades" => $this->ExamGrade->get(),
        ];

        // Start Formatted Exam
        $formattedData = [];

        foreach ($data["papers"] as $entry) {
            $id = $entry["id"];
            $classId = $entry["class"]["id"];
            $className = $entry["class"]["name"];
            $examId = $entry["exam"]["id"];
            $examName = $entry["exam"]["name"];

            // Initialize class if not already
            if (!isset($formattedData[$classId])) {
                $formattedData[$classId] = [
                    "class_name" => $className,
                    "exams" => [],
                ];
            }

            // Initialize exam under the class if not already
            if (!isset($formattedData[$classId]["exams"][$examId])) {
                $formattedData[$classId]["exams"][$examId] = [
                    "exam_id" => $id,
                    "exam_name" => $examName,
                    "subjects" => [],
                ];
            }

            // Loop through subjects
            foreach ($entry["subjects"] as $subject) {
                // Skip if subject is empty
                if (empty($subject)) {
                    continue;
                }

                $subjectId = $subject["id"];

                $formattedData[$classId]["exams"][$examId]["subjects"][
                    $subjectId
                ] = [
                    "subject_name" => $subject["name"],
                    "component_name" => $entry["component"]["name"],
                    "full_marks" => $entry["marks"]->marks->full_marks,
                    "pass_marks" => $entry["marks"]->marks->pass_marks,
                ];
            }
        }
        // End Formatted Exam

        $data["papers"] = $formattedData;

        $this->load->view("academics/examination_paper", $data);
    }

    public function create()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $data = [
            "classes" => $this->AcademyClass->get(),
            "exams" => $this->Exam->get(),
            "subjects" => $this->Subject->get(),
            "components" => $this->Component->get(),
        ];

        $this->load->view("academics/set_examination_paper", $data);
    }

    public function get_exam_paper()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $record = $this->ExamPaper->get_where([
            "class_id" => $_GET["class_id"],
            "exam_id" => $_GET["exam_id"],
            "paper_type" => "grade",
        ]);

        $subjects = explode(",", $record["subjects"]);

        $subject_list = [];
        foreach ($subjects as $subject) {
            $subject_list[] = $this->Subject->get($subject);
        }

        echo json_encode(["subjects" => $subject_list]);
    }

    public function exam_paper_student()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $academy_session_id =
            $this->session->academy_session["current_session"]["id"];

        $students = $this->StudentSubject->get_students([
            "academy_class_id" => $_POST["class_id"],
            "section_id" => $_POST["section_id"],
            "subject_id" => $_POST["subject_id"],
            "current_session_id" => $academy_session_id,
        ]);

        $student_list = [];

        foreach ($students as $student) {
            $s = $this->Student->get($student["student_id"]);
            $student_list[] = [
                "id" => $s["id"],
                "student_no" => $s["student_no"],
                "roll_no" => $s["roll_no"],
                "f_name" => $s["f_name"],
                "m_name" => $s["m_name"],
                "l_name" => $s["l_name"],
                "grade" => $this->Marks->get_grade([
                    "class_id" => $_POST["class_id"],
                    "section_id" => $_POST["section_id"],
                    "exam_id" => $_POST["exam_id"],
                    "subject_id" => $_POST["subject_id"],
                    "student_id" => $s["id"],
                ]),
            ];
        }

        $academy_session_id =
            $this->session->academy_session["current_session"]["id"];
        $classes = $this->AcademyClass->get();
        $sections = $this->ClassSection->get_sections(
            $academy_session_id,
            $_POST["class_id"]
        );
        $exams = $this->Exam->get();
        $exam_grades = $this->ExamGrade->get();

        $record = $this->ExamPaper->get_where([
            "class_id" => $_POST["class_id"],
            "exam_id" => $_POST["exam_id"],
            "paper_type" => "grade",
        ]);

        $subject_list = explode(",", $record["subjects"]);

        $subjects = [];
        foreach ($subject_list as $subject) {
            $subjects[] = $this->Subject->get($subject);
        }

        $this->load->view("academics/grade_entry", [
            "students" => $student_list,
            "classes" => $classes,
            "sections" => $sections,
            "exams" => $exams,
            "subjects" => $subjects,
            "class_id" => $_POST["class_id"],
            "section_id" => $_POST["section_id"],
            "exam_id" => $_POST["exam_id"],
            "subject_id" => $_POST["subject_id"],
            "exam_grades" => $exam_grades,
        ]);
    }

    public function store()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $paper_type = trim($this->input->post("paper_type"));

        $data = [
            "class_id" => trim($this->input->post("class_id")),
            "exam_id" => trim($this->input->post("exam_id")),
            "subjects" => implode(",", $this->input->post("subject")),
            "paper_type" => trim($this->input->post("paper_type")),
            "marks" => json_encode([]),
        ];

        if ($paper_type == "component") {
            $obj = [
                "component_id" => trim($this->input->post("component_id")),
                "marks" => [
                    "full_marks" => trim($this->input->post("full_marks")),
                    "pass_marks" => trim($this->input->post("pass_marks")),
                ],
            ];

            $data["marks"] = json_encode($obj);
        }

        if ($paper_type == "mark_grade") {
            $mins = $this->input->post("min");
            $maxs = $this->input->post("max");
            $grades = $this->input->post("grade");

            $marks = [];

            for ($i = 0; $i < count($mins); $i++) {
                $marks[] = [
                    "min" => trim($mins[$i]),
                    "max" => trim($maxs[$i]),
                    "grade" => trim($grades[$i]),
                ];
            }

            $data["marks"] = json_encode([
                "mark_grade_full_marks" => trim(
                    $this->input->post("mark_grade_full_marks")
                ),
                "mark_grade_pass_marks" => trim(
                    $this->input->post("mark_grade_pass_marks")
                ),
                "marks" => $marks,
            ]);
        }

        $record = $this->ExamPaper->search([
            "class_id" => $data["class_id"],
            "exam_id" => $data["exam_id"],
            "paper_type" => $data["paper_type"],
        ]);

        if ($record["marks"] == $data["marks"]) {
            $d = [];
            $d["subjects"] = $data["subjects"];
            $this->ExamPaper->update($record[0]["id"], $d);

            $this->session->set_flashdata("success", "Success");

            return redirect(base_url() . "academics/examination-paper/");
        } else {
            $this->ExamPaper->insert($data);

            $this->session->set_flashdata("success", "Success");

            return redirect(
                base_url() . "academics/set-examination-paper/create/"
            );
        }
    }

    public function search()
    {
        $class_id = $_GET["class_id"];
        $exam_id = $_GET["exam_id"];

        $exam_papers = $this->ExamPaper->search([
            "class_id" => $class_id,
            "exam_id" => $exam_id,
        ]);

        header("Content-type: application/json");

        $used_subject = [];

        foreach ($exam_papers as $exam_paper) {
            $subjects = explode(",", $exam_paper["subjects"]);

            foreach ($subjects as $subject) {
                if (!in_array($subject, $used_subject)) {
                    $used_subject[] = $subject;
                }
            }
        }

        $subject_data = [];

        if (count($used_subject) > 0) {
            $subject_data = $this->Subject->get_where_id_not_in($used_subject);
        } else {
            $subject_data = $this->Subject->get();
        }

        echo json_encode($subject_data);
    }

    public function edit($id = null)
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        // Fetch data for select fields
        $data = [
            "classes" => $this->AcademyClass->get(),
            "exams" => $this->Exam->get(),
            "subjects" => $this->Subject->get(),
            "components" => $this->Component->get(),
            "exam_paper" => $this->ExamPaper->get($id),
        ];

        $data["exam_paper"]["marks"] = json_decode(
            $data["exam_paper"]["marks"],
            true
        );

        // Load the view
        $this->load->view("academics/edit_examination_paper", $data);
    }

    public function delete($id)
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $this->ExamPaper->delete($id);

        $this->session->set_flashdata("success", "Success");
        return redirect(base_url() . "academics/examination-paper/");
    }

    public function remove_subject()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $id = $_GET["id"];
        $subject_id = $_GET["subject_id"];

        $record = $this->ExamPaper->get($id);

        $subjects = explode(",", $record["subjects"]);

        if (($key = array_search($subject_id, $subjects)) !== false) {
            unset($subjects[$key]);
        }

        $subjects = implode(",", $subjects);

        $this->ExamPaper->update($id, [
            "subjects" => $subjects,
        ]);

        $this->session->set_flashdata("success", "Success");
        return redirect(base_url() . "academics/examination-paper/");
    }

    public function exam_control_privileges_create()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }
        $data;
        $class_id = $this->input->get("class_id");
        $section_id = $this->input->get("section_id");
        $exam_id = $this->input->get("exam_id");
        $component_id = $this->input->get("component_id");
        $subject_id = $this->input->get("subject_id");

        $academy_session_id =
            $this->session->academy_session["current_session"]["id"];

        if ($class_id && $exam_id) {
            $rows = $this->ExamPaper->get_exams([
                "class_id" => $class_id,
                "exam_id" => $exam_id,
                "paper_type" => "component",
            ]);

            $components = [];
            $subjects = [];

            for ($i = 0; $i < count($rows); $i++) {
                $r = json_decode($rows[$i]["marks"]);

                $subjects[] = explode(",", $rows[$i]["subjects"]);

                $components[] = $this->Component->get($r->component_id);
            }

            $subjects = array_merge(...$subjects);
            $subjects = array_unique($subjects);
            $subject_list = [];

            foreach ($subjects as $subject) {
                $subject_list[] = $this->Subject->get($subject);
            }

            echo json_encode([
                "components" => $components,
                "subjects" => $subject_list,
            ]);
        } elseif ($class_id) {
            $sections = $this->ClassSection->get_sections(
                $academy_session_id,
                $class_id
            );

            $rows = $this->ExamPaper->get_exams([
                "class_id" => $class_id,
                "paper_type" => "component",
            ]);

            $exams = [];
            $temp = [];

            foreach ($rows as $row) {
                if (!in_array($row["exam_id"], $temp)) {
                    $temp[] = $row["exam_id"];
                    $exams[] = $this->Exam->get($row["exam_id"]);
                }
            }

            echo json_encode(["sections" => $sections, "exams" => $exams]);
        } else {
            $classes = $this->AcademyClass->get();

            $this->load->view("academics/exam_control_privileges", [
                "classes" => $classes,
            ]);
        }
    }

    // Marks Entry Control Methods
    // public function exam_marks_control_privileges()
    // {
    //     if (!$this->session->user) {
    //         return redirect(base_url());
    //     }

    //     $class_id = "";
    //     $section_id = "";
    //     $component_id = "";
    //     $exam_id = "";
    //     $subject_id = "";

    //     $class_id = $this->input->post("class_id") ?? '';
    //     $section_id = $this->input->post("section_id") ?? '';
    //     $component_id = $this->input->post("component_id") ?? '';
    //     $exam_id = $this->input->post("exam_id") ?? '';
    //     $subject_id = $this->input->post("subject_id") ?? '';
    //     $academy_session_id = $this->session->academy_session['current_session']['id'];
        
    //     $clauses = ["class_id" => $class_id, "exam_id" => $exam_id];
    //     $exam_papers = [$this->ExamPaper->get_where($clauses)];

    //     // $exam_papers = $this->ExamPaper->get();
    //     // echo "<pre>";
    //     // print_r($subject_id);
    //     // echo "</pre>";
    //     // exit();

    //     $papers = [];

    //     for ($i = 0; $i < count($exam_papers); $i++) {
    //         $paper = [
    //             "id" => $exam_papers[$i]["id"],
    //             "class" => $this->AcademyClass->get(
    //                 $exam_papers[$i]["class_id"]
    //             ),
    //             "exam" => $this->Exam->get($exam_papers[$i]["exam_id"]),
    //             "paper_type" => $exam_papers[$i]["paper_type"],
    //             "subjects" => [],
    //         ];

    //         if ($exam_papers[$i]["subjects"] != "") {
    //             $subjects = explode(",", $exam_papers[$i]["subjects"]);

    //             for ($j = 0; $j < count($subjects); $j++) {

    //                 if($subject_id != "") {
    //                     if($subject_id == $subjects[$j]) {
    //                         $paper["subjects"][] = $this->Subject->get($subjects[$j]);
    //                     }
    //                 }

    //                 if($subject_id == "") {
    //                     $paper["subjects"][] = $this->Subject->get($subjects[$j]);
    //                 }
    //             }
    //         }

    //         if ($paper["paper_type"] == "component") {
    //             $obj = json_decode($exam_papers[$i]["marks"]);

    //             $paper["marks"] = json_decode($exam_papers[$i]["marks"]);

    //             $paper["component"] = $this->Component->get($obj->component_id);
    //             $paper["full_marks"] = $obj->marks->full_marks;
    //             $paper["pass_marks"] = $obj->marks->pass_marks;
    //         }

    //         if ($paper["paper_type"] == "mark_grade") {
    //             $paper["marks"] = json_decode($exam_papers[$i]["marks"]);
    //         }

    //         $papers[] = $paper;
    //     }

    //     $rows = $this->ExamPaper->get_exams([
    //         "class_id"      => $class_id, 
    //         "exam_id"       => $exam_id,
    //         "paper_type"    => "component"
    //     ]);
        
    //     $components = [];
    //     $subjects = [];
        
    //     for($i = 0 ; $i < count($rows) ; $i++) { 

    //         $r = json_decode($rows[$i]["marks"]);
            
    //         $subjects[] = explode(",", $rows[$i]["subjects"]);
            
    //         $components[] = $this->Component->get($r->component_id);
    //     }
        
    //     $subjects = array_merge(...$subjects);
    //     $subjects = array_unique($subjects);
    //     $subject_list = [];
        
    //     foreach($subjects as $subject) {
    //         $subject_list[] = $this->Subject->get($subject);
    //     }

    //     $data = [
    //         "classes" => $this->AcademyClass->get(),
    //         "sections" => $this->ClassSection->get_sections($academy_session_id, $class_id),
    //         "exams" => $this->Exam->get(),
    //         "papers" => $papers,
    //         "grades" => $this->ExamGrade->get(),
    //         "components" => $components, 
    //         "subjects" => $subject_list,
    //         "class_id" => $class_id,
    //         "section_id" => $section_id,
    //         "subject_id" => $subject_id
    //     ];

    //     // Start Formatted Exam
    //     $formattedData = [];

    //     foreach ($data["papers"] as $entry) {
    //         $id = $entry["id"];
    //         $classId = $entry["class"]["id"];
    //         $className = $entry["class"]["name"];
    //         $examId = $entry["exam"]["id"];
    //         $examName = $entry["exam"]["name"];

    //         // Initialize class if not already
    //         if (!isset($formattedData[$classId])) {
    //             $formattedData[$classId] = [
    //                 "class_name" => $className,
    //                 "exams" => [],
    //             ];
    //         }

    //         // Initialize exam under the class if not already
    //         if (!isset($formattedData[$classId]["exams"][$examId])) {
    //             $formattedData[$classId]["exams"][$examId] = [
    //                 "exam_id" => $id,
    //                 "exam_name" => $examName,
    //                 "subjects" => [],
    //             ];
    //         }

    //         // Loop through subjects
    //         foreach ($entry["subjects"] as $subject) {
    //             // Skip if subject is empty
    //             if (empty($subject)) {
    //                 continue;
    //             }

    //             $subjectId = $subject["id"];

    //             $formattedData[$classId]["exams"][$examId]["subjects"][$subjectId] = [
    //                 "paper_id" => $entry["id"],
    //                 "class_id" => $classId,
    //                 "section_id" => $entry["section"]["id"], // important
    //                 "subject_name" => $subject["name"],
    //                 "component_name" => $entry["component"]["name"],
    //                 "full_marks" => $entry["marks"]->marks->full_marks,
    //                 "pass_marks" => $entry["marks"]->marks->pass_marks,
    //                 "assigned_teachers_for_marks_entry" => $this->ExamPaper->getMarksEntryTeachers(
    //                     $entry["id"],
    //                     $class_id,
    //                     $section_id,
    //                     $subjectId
    //                 ),
    //             ];
    //         }
    //     }
    //     // End Formatted Exam

    //     $data["papers"] = $formattedData;

    //     // echo "<pre>";
    //     // print_r($data);
    //     // echo "</pre>";
    //     // exit();
    //     $this->load->view("academics/exam_control_privileges", $data);
    // }

    public function exam_marks_control_privileges()
    {
        if (!$this->session->user) {
            return redirect(base_url());
        }

        $class_id      = $this->input->post("class_id") ?? '';
        $section_id    = $this->input->post("section_id") ?? '';
        $exam_id       = $this->input->post("exam_id") ?? '';
        $subject_id    = $this->input->post("subject_id") ?? '';

        $academy_session_id =
            $this->session->academy_session["current_session"]["id"];

        $exam_papers = [];

        if ($class_id != '') {

            $clauses = [
                "class_id" => $class_id
            ];

            if ($exam_id != '') {
                $clauses["exam_id"] = $exam_id;
            }

            $exam_papers = $this->ExamPaper->get_where_v2($clauses);
        }

        $papers = [];

        foreach ($exam_papers as $examPaper) {

            $paper = [
                "id"         => $examPaper["id"],
                "class"      => $this->AcademyClass->get(
                    $examPaper["class_id"]
                ),
                "exam"       => $this->Exam->get(
                    $examPaper["exam_id"]
                ),
                "paper_type" => $examPaper["paper_type"],
                "subjects"   => []
            ];

            if (!empty($examPaper["subjects"])) {

                $subjects = explode(",", $examPaper["subjects"]);

                foreach ($subjects as $subject) {

                    if (
                        $subject_id != '' &&
                        $subject_id != $subject
                    ) {
                        continue;
                    }

                    $subjectData = $this->Subject->get($subject);

                    if (!empty($subjectData)) {
                        $paper["subjects"][] = $subjectData;
                    }
                }
            }

            if (
                $paper["paper_type"] == "component" &&
                !empty($examPaper["marks"])
            ) {

                $obj = json_decode($examPaper["marks"]);

                $paper["marks"] = $obj;

                if (
                    isset($obj->component_id)
                ) {
                    $paper["component"] =
                        $this->Component->get(
                            $obj->component_id
                        );
                }

                if (
                    isset($obj->marks->full_marks)
                ) {
                    $paper["full_marks"] =
                        $obj->marks->full_marks;
                }

                if (
                    isset($obj->marks->pass_marks)
                ) {
                    $paper["pass_marks"] =
                        $obj->marks->pass_marks;
                }
            }

            if ($paper["paper_type"] == "mark_grade") {
                $paper["marks"] =
                    json_decode($examPaper["marks"]);
            }

            $papers[] = $paper;
        }

        $componentClauses = [
            "paper_type" => "component"
        ];

        if ($class_id != '') {
            $componentClauses["class_id"] = $class_id;
        }

        if ($exam_id != '') {
            $componentClauses["exam_id"] = $exam_id;
        }

        $rows = $this->ExamPaper->get_exams(
            $componentClauses
        );

        $components = [];
        $subjects = [];

        foreach ($rows as $row) {

            $decoded = json_decode($row["marks"]);

            if (
                $decoded &&
                isset($decoded->component_id)
            ) {
                $component =
                    $this->Component->get(
                        $decoded->component_id
                    );

                if (!empty($component)) {
                    $components[$component["id"]] = $component;
                }
            }

            if (!empty($row["subjects"])) {

                $tempSubjects =
                    explode(",", $row["subjects"]);

                foreach ($tempSubjects as $subId) {
                    $subjects[$subId] = $subId;
                }
            }
        }

        $subject_list = [];

        foreach ($subjects as $subId) {

            $subjectData =
                $this->Subject->get($subId);

            if (!empty($subjectData)) {
                $subject_list[] = $subjectData;
            }
        }

        $data = [
            "classes" => $this->AcademyClass->get(),

            "sections" => $this->ClassSection->get_sections(
                $academy_session_id,
                $class_id
            ),

            "exams" => $this->Exam->get(),

            "papers" => $papers,

            "grades" => $this->ExamGrade->get(),

            "components" => array_values($components),

            "subjects" => $subject_list,

            "class_id" => $class_id,

            "section_id" => $section_id,

            "subject_id" => $subject_id,

            "exam_id" => $exam_id
        ];

        $formattedData = [];

        foreach ($data["papers"] as $entry) {

            if (
                empty($entry["class"]) ||
                empty($entry["exam"])
            ) {
                continue;
            }

            $classId   = $entry["class"]["id"];
            $className = $entry["class"]["name"];

            $examId    = $entry["exam"]["id"];
            $examName  = $entry["exam"]["name"];

            if (
                !isset($formattedData[$classId])
            ) {
                $formattedData[$classId] = [
                    "class_name" => $className,
                    "exams"      => []
                ];
            }

            if (
                !isset(
                    $formattedData[$classId]["exams"][$examId]
                )
            ) {
                $formattedData[$classId]["exams"][$examId] = [
                    "exam_id"   => $entry["id"],
                    "exam_name" => $examName,
                    "subjects"  => []
                ];
            }

            foreach ($entry["subjects"] as $subject) {

                if (empty($subject)) {
                    continue;
                }

                $subjectId = $subject["id"];
                $formattedData = [];

                foreach($exam_papers as $paper){

                    if(empty($paper['subjects'])){
                        continue;
                    }

                    $paperSubjects =
                        explode(',', $paper['subjects']);

                    foreach($paperSubjects as $subjectId){

                        if(
                            $subject_id != '' &&
                            $subject_id != $subjectId
                        ){
                            continue;
                        }

                        if(
                            !isset($formattedData[$subjectId])
                        ){

                            $subject =
                                $this->Subject->get(
                                    $subjectId
                                );

                            $formattedData[$subjectId] = [

                                'subject_id' =>
                                    $subjectId,

                                'subject_name' =>
                                    $subject['name'],

                                'paper_ids' => [],

                                'assigned_teachers' => []

                            ];
                        }

                        $formattedData[$subjectId]['paper_ids'][] =
                            $paper['id'];
                    }
                }

                foreach($formattedData as $subjectId => &$row){

                    $teacherMap = [];

                    foreach($row['paper_ids'] as $paperId){

                        $teachers =
                            $this->ExamPaper
                            ->getMarksEntryTeachers(
                                $paperId,
                                $class_id,
                                $section_id,
                                $subjectId
                            );

                        foreach($teachers as $teacher){

                            $teacherMap[
                                $teacher['teacher_id']
                            ] = [
                                'teacher_id'   => $teacher['teacher_id'],
                                'teacher_name' => $teacher['teacher_name'],
                                'status'       => $teacher['status']
                            ];
                        }
                    }

                    $row['assigned_teachers'] =
                        array_values($teacherMap);

                    // $row['exam_locked'] =
                    //     $this->ExamPaper->isExamLocked(
                    //         $row['paper_ids'],
                    //         $class_id,
                    //         $section_id
                    //     );

                    // echo "<pre>";
                    // print_r([ $row['paper_ids'],
                    //         $class_id,
                    //         $section_id,
                    //         $subjectId]);
                    // echo "</pre>";
                    // exit();

                    // $row['subject_locked'] =
                    //     $this->ExamPaper->isSubjectLocked(
                    //         $row['paper_ids'],
                    //         $class_id,
                    //         $section_id,
                    //         $subjectId
                    //     );

                    if($section_id != ''){

                        $row['exam_locked'] =
                            $this->ExamPaper->isExamLocked(
                                $row['paper_ids'],
                                $class_id,
                                $section_id
                            );

                        $row['subject_locked'] =
                            $this->ExamPaper->isSubjectLocked(
                                $row['paper_ids'],
                                $class_id,
                                $section_id,
                                $subjectId
                            );

                    }else{

                        $row['exam_locked'] = false;
                        $row['subject_locked'] = false;

                        $sections =
                            $this->ClassSection->get_sections(
                                $academy_session_id,
                                $class_id
                            );

                        foreach($sections as $section){

                            if(
                                $this->ExamPaper->isExamLocked(
                                    $row['paper_ids'],
                                    $class_id,
                                    $section['id']
                                )
                            ){
                                $row['exam_locked'] = true;
                            }

                            if(
                                $this->ExamPaper->isSubjectLocked(
                                    $row['paper_ids'],
                                    $class_id,
                                    $section['id'],
                                    $subjectId
                                )
                            ){
                                $row['subject_locked'] = true;
                            }

                            if(
                                $row['exam_locked'] &&
                                $row['subject_locked']
                            ){
                                break;
                            }
                        }
                    }
                }

            }
        }
        

        $data['papers'] = array_values($formattedData);

        $all_paper_ids = [];

        foreach ($data['papers'] as $paper) {

            foreach ($paper['paper_ids'] as $paperId) {

                if (!in_array($paperId, $all_paper_ids)) {
                    $all_paper_ids[] = $paperId;
                }
            }
        }

        $data['all_paper_ids'] = $all_paper_ids;

        $data['is_exam_locked'] = false;

        if($section_id != ''){

            $data['is_exam_locked'] =
                $this->ExamPaper->isExamLocked(
                    $row['paper_ids'],
                    $class_id,
                    $section_id
                );

        }else{

            $sections =
                $this->ClassSection->get_sections(
                    $academy_session_id,
                    $class_id
                );

            foreach($sections as $section){

                if(
                    $this->ExamPaper->isExamLocked(
                        $row['paper_ids'],
                        $class_id,
                        $section['id']
                    )
                ){
                    $data['is_exam_locked'] = true;
                }

            }
        }
        
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();


        $this->load->view(
            "academics/exam_control_privileges",
            $data
        );
    }

    public function get_marks_entry_teachers()
    {
        $paperId = $this->input->post("paper_ids");
        $subjectId = $this->input->post("subject_id");
        $classId = $this->input->post("class_id");
        $sectionId = $this->input->post("section_id");

        $teachers = $this->ExamPaper->getActiveTeachers();

        $assigned = $this->ExamPaper->getMarksEntryTeachers(
            $paperId,
            $classId,
            $sectionId,
            $subjectId
        );

        // echo "<pre>";
        // print_r($assigned);
        // echo "</pre>";
        // exit();

        $assignedIds = [];

        foreach ($assigned as $row) {
            $assignedIds[] = $row["teacher_id"];
        }

        $response = [];

        foreach ($teachers as $teacher) {
            $response[] = [
                "teacher_id" => $teacher["id"],
                "teacher_name" => $teacher["teacher_name"],
                "hasPermission" => in_array($teacher["id"], $assignedIds)
                    ? 1
                    : 0,
            ];
        }

        echo json_encode($response);
    }

    public function save_marks_entry_teachers()
    {
        $paperIds = $this->input->post("paper_ids");

        $subjectId = $this->input->post("subject_id");

        $teacherIds = $this->input->post("teacher_ids");

        $classId = $this->input->post("class_id");

        $sectionId = $this->input->post("section_id");

        $paperIds = !empty($paperIds)
            ? array_map(
                "trim",
                explode(",", $paperIds)
            )
            : [];

        if (!is_array($teacherIds)) {

            $teacherIds = !empty($teacherIds)
                ? array_map(
                    "trim",
                    explode(",", $teacherIds)
                )
                : [];
        }

        if (!empty($sectionId)) {

            $sectionIds = [$sectionId];

        } else {

            $academy_session_id =
                $this->session
                ->academy_session[
                    "current_session"
                ]["id"];

            $sections =
                $this->ClassSection
                ->get_sections(
                    $academy_session_id,
                    $classId
                );

            $sectionIds = [];

            foreach ($sections as $section) {

                $sectionIds[] =
                    $section["id"];
            }
        }

        foreach ($paperIds as $paperId) {

            foreach ($sectionIds as $secId) {

                $this->ExamPaper
                    ->saveMarksEntryTeachers(
                        $paperId,
                        $classId,
                        $secId,
                        $subjectId,
                        $teacherIds
                    );
            }
        }

        echo json_encode([
            "status" => true,
            "message" => "Saved Successfully",
        ]);
    }

    // public function remove_marks_entry_teacher()
    // {
    //     if (!$this->session->user) {

    //         echo json_encode([
    //             "status" => false,
    //             "message" => "Unauthorised",
    //         ]);

    //         exit();
    //     }

    //     $paperIds = explode(
    //         ",",
    //         $this->input->post("paper_ids")
    //     );

    //     $subjectId = $this->input->post("subject_id");
    //     $teacherId = $this->input->post("teacher_id");
    //     $classId = $this->input->post("class_id");
    //     $sectionId = $this->input->post("section_id");

    //     foreach ($paperIds as $paperId) {

    //         $this->ExamPaper->removeMarksEntryTeacher(
    //             $paperId,
    //             $classId,
    //             $sectionId,
    //             $subjectId,
    //             $teacherId
    //         );
    //     }

    //     echo json_encode([
    //         "status" => true,
    //         "message" => "Teacher removed successfully",
    //     ]);
    // }

    // public function toggle_marks_entry_teacher()
    // {
    //     if (!$this->session->user) {

    //         echo json_encode([
    //             "status" => false,
    //             "message" => "Unauthorised",
    //         ]);

    //         exit();
    //     }

    //     $paperIds = explode(
    //         ",",
    //         $this->input->post("paper_ids")
    //     );

    //     $subjectId = $this->input->post("subject_id");
    //     $teacherId = $this->input->post("teacher_id");
    //     $classId = $this->input->post("class_id");
    //     $sectionId = $this->input->post("section_id");
    //     $status = $this->input->post("status");

    //     foreach ($paperIds as $paperId) {

    //         $this->ExamPaper->toggleMarksEntryTeacher(
    //             $paperId,
    //             $classId,
    //             $sectionId,
    //             $subjectId,
    //             $teacherId,
    //             $status
    //         );
    //     }

    //     echo json_encode([
    //         "status" => true,
    //         "message" => "Teacher status updated successfully",
    //     ]);
    // }

    public function remove_marks_entry_teacher()
    {
        if (!$this->session->user) {

            echo json_encode([
                "status" => false,
                "message" => "Unauthorised",
            ]);

            exit();
        }

        $paperIds = !empty($this->input->post("paper_ids"))
            ? array_map("trim", explode(",", $this->input->post("paper_ids")))
            : [];

        $subjectId = $this->input->post("subject_id");
        $teacherId = $this->input->post("teacher_id");
        $classId = $this->input->post("class_id");
        $sectionId = $this->input->post("section_id");

        $academySessionId =
            $this->session->academy_session["current_session"]["id"];

        if (empty($sectionId)) {

            $sections = $this->ClassSection->get_sections(
                $academySessionId,
                $classId
            );

            $sectionIds = [];

            foreach ($sections as $section) {
                $sectionIds[] = $section["id"];
            }

        } else {

            $sectionIds = [$sectionId];

        }

        foreach ($sectionIds as $sectionId) {

            foreach ($paperIds as $paperId) {

                $this->ExamPaper->removeMarksEntryTeacher(
                    $paperId,
                    $classId,
                    $sectionId,
                    $subjectId,
                    $teacherId
                );

            }

        }

        echo json_encode([
            "status" => true,
            "message" => "Teacher removed successfully",
        ]);
    }

    public function toggle_marks_entry_teacher()
    {
        if (!$this->session->user) {

            echo json_encode([
                "status" => false,
                "message" => "Unauthorised",
            ]);

            exit();
        }

        $paperIds = !empty($this->input->post("paper_ids"))
            ? array_map("trim", explode(",", $this->input->post("paper_ids")))
            : [];

        $subjectId = $this->input->post("subject_id");
        $teacherId = $this->input->post("teacher_id");
        $classId = $this->input->post("class_id");
        $sectionId = $this->input->post("section_id");
        $status = $this->input->post("status");

        $academySessionId =
            $this->session->academy_session["current_session"]["id"];

        if (empty($sectionId)) {

            $sections = $this->ClassSection->get_sections(
                $academySessionId,
                $classId
            );

            $sectionIds = [];

            foreach ($sections as $section) {
                $sectionIds[] = $section["id"];
            }

        } else {

            $sectionIds = [$sectionId];

        }

        foreach ($sectionIds as $sectionId) {

            foreach ($paperIds as $paperId) {

                $this->ExamPaper->toggleMarksEntryTeacher(
                    $paperId,
                    $classId,
                    $sectionId,
                    $subjectId,
                    $teacherId,
                    $status
                );

            }

        }

        echo json_encode([
            "status" => true,
            "message" => "Teacher status updated successfully",
        ]);
    }
    
    public function toggle_exam_lock()
    {
        if (!$this->session->user) {

            echo json_encode([
                "status" => false,
                "message" => "Unauthorised",
            ]);

            exit();
        }

        // exit();
        
        $paperIds = $this->input->post("paper_ids");
        $classId = $this->input->post("class_id");
        $sectionId = $this->input->post("section_id");
        $status = $this->input->post("status");

        $paperIds = !empty($paperIds)
            ? array_map("trim", explode(",", $paperIds))
            : [];

        $userId = $this->session->user["id"];

        $academySessionId =
            $this->session->academy_session["current_session"]["id"];


        if (empty($sectionId)) {

            $sections = $this->ClassSection->get_sections(
                $academySessionId,
                $classId
            );

            $sectionIds = [];

            foreach ($sections as $section) {

                $sectionIds[] = $section["id"];

            }

        } else {

            $sectionIds = [$sectionId];

        }

        foreach ($sectionIds as $sectionId) {

            foreach ($paperIds as $paperId) {

                $this->ExamPaper->toggleExamLock(
                    $paperId,
                    $classId,
                    $sectionId,
                    $status
                );

            }

        }

        echo json_encode([
            "status" => true,
            "message" => $status
                ? "Exam Locked Successfully"
                : "Exam Unlocked Successfully",
        ]);
    }

    public function toggle_subject_lock()
    {
        if (!$this->session->user) {

            echo json_encode([
                "status" => false,
                "message" => "Unauthorised",
            ]);

            exit();
        }

        
        // exit();

        $paperIds = $this->input->post("paper_ids");
        $subjectId = $this->input->post("subject_id");
        $classId = $this->input->post("class_id");
        $sectionId = $this->input->post("section_id");
        $status = $this->input->post("status");

        $paperIds = !empty($paperIds)
            ? array_map("trim", explode(",", $paperIds))
            : [];

        $userId = $this->session->user["id"];

        $academySessionId =
            $this->session->academy_session["current_session"]["id"];

        if (empty($sectionId)) {

            $sections = $this->ClassSection->get_sections(
                $academySessionId,
                $classId
            );

            $sectionIds = [];

            foreach ($sections as $section) {
                $sectionIds[] = $section["id"];
            }

        } else {

            $sectionIds = [$sectionId];
        }


        foreach ($sectionIds as $sectionId) {

            foreach ($paperIds as $paperId) {

                $this->ExamPaper->toggleSubjectLock(
                    $paperId,
                    $classId,
                    $sectionId,
                    $subjectId,
                    $status,
                    $userId
                );
            }
        }

        echo json_encode([
            "status" => true,
            "message" => $status
                ? "Subject Locked Successfully"
                : "Subject Unlocked Successfully",
        ]);
    }


}
