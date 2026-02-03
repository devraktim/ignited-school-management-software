<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FirstTerm {
    public function __construct() {
        parent::__construct();
        $this->load->model("AcademyClass");
        $this->load->model("Section");
        $this->load->model("ClassSection");
        $this->load->model("ExamPaper");
        $this->load->model("EvolutionGrade");
        $this->load->model("EvolutionSubject");
        $this->load->model("EvolutionPaper");
        $this->load->model("ExamAttendence");
        $this->load->model("StudentSubject");
        $this->load->model("Subject");
        $this->load->model("Remarks");
        $this->load->model("Exam");
        $this->load->model("Student");
        $this->load->model("Marks");
    }
    
    public function get_result() {
            $class_id =     $this->input->post("class_id");
            $section_id =   $this->input->post("section_id");
            $exam_id =      $this->input->post("exam_id");
            
            $report_for =   $this->input->post("report_for");
            
            
            // Class I to II
            if(in_array($class_id, [2, 3]) && $exam_id == 2) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"                      => $class_id,
                    "section_id"                    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 2) {
                    if($section_id == 1) {
                        $class_teacher = "MS. JEENY";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. KALPANA";
                    }
                }
                
                if($class_id == 3) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TULSI";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. LIPIKA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 1, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 2, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "evs"                   =>  $unit_test_marks["evs"]                 + $first_term_marks["evs"],
                        "computer"              =>  $unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $percentage = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "evs"               => $totals["evs"],
                        "computer"          => $totals["computer"]
                    ];
                    
                    $total_percentage = $percentage["english"] + $percentage["second_language"] + $percentage["mathematics"] + $percentage["evs"] + $percentage["computer"] ;
                    $total_avg_percentage = number_format($total_percentage / 5);
                    
                    
                    $division = "";
                    
                    if($total_avg_percentage >= 85 && $total_avg_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg_percentage >= 65 && $total_avg_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg_percentage >= 45 && $total_avg_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["evs"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],               
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                $this->load->view("academics/".$this->input->post('result_type')."/class_i_vi", ["students" => $records, "ranks" => $all_ranks, "class" => $class, "section" => $section]);
            }
            
            // Class III to IV
            else if(in_array($class_id, [4, 5]) && $exam_id == 2)
            {
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
            
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 4) {
                    if($section_id == 1) {
                        $class_teacher = "SR. RUPOLA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. PRISCILLA";
                    }
                }
                
                if($class_id == 5) {
                    if($section_id == 1) {
                        $class_teacher = "MS. CHRISTABEL";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. SUSHMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "third_language"=> $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 1, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 1, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 2, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 2, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "science"               =>  $unit_test_marks["science"]             + $first_term_marks["science"],
                        "social_studies"        =>  $unit_test_marks["social_studies"]      + $first_term_marks["social_studies"],
                        "computer"              =>  $unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $percentage = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "science"           => $totals["science"],
                        "social_studies"    => $totals["social_studies"],
                        "computer"          => $totals["computer"]
                    ];
                    
                    $total_percentage = $percentage["english"] + $percentage["second_language"] + $percentage["mathematics"] + $percentage["science"] + $percentage["social_studies"] + $percentage["computer"] ;
                    $total_avg_percentage = number_format($total_percentage / 6);
                    
                    $division = "";
                    
                    if($total_avg_percentage >= 85 && $total_avg_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg_percentage >= 65 && $total_avg_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg_percentage >= 45 && $total_avg_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["science"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["social_studies"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                $this->load->view("academics/".$this->input->post('result_type')."/class_iii_iv", ["students" => $records, "ranks" => $all_ranks, "class" => $class, "section" => $section]);
            }
            
            // Class V
            else if(in_array($class_id, [6]) && $exam_id == 2)
            {
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
            
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 6) {
                    if($section_id == 1) {
                        $class_teacher = "MS. MARINA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. REETU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"                => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"       => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id']),
                        "drawing"           => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 1, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 1, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "science"               => $this->Marks->get_student_marks($class_id, 2, 4,  $student['id']),
                        "social_studies"        => $this->Marks->get_student_marks($class_id, 2, 20, $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "science"               =>  $unit_test_marks["science"]             + $first_term_marks["science"],
                        "social_studies"        =>  $unit_test_marks["social_studies"]      + $first_term_marks["social_studies"],
                        "computer"              =>  $unit_test_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $percentage = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "science"           => $totals["science"],
                        "social_studies"    => $totals["social_studies"],
                        "computer"          => $totals["computer"]
                    ];
                    
                    $total_percentage = $percentage["english"] + $percentage["second_language"] + $percentage["mathematics"] + $percentage["science"] + $percentage["social_studies"] + $percentage["computer"] ;
                    $total_avg_percentage = number_format($total_percentage / 6);
                    
                    
                    $division = "";
                    
                    if($total_avg_percentage >= 85 && $total_avg_percentage <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg_percentage >= 65 && $total_avg_percentage <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg_percentage >= 45 && $total_avg_percentage <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg_percentage < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["science"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["social_studies"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                $this->load->view("academics/".$this->input->post('result_type')."/class_v", ["students" => $records, "ranks" => $all_ranks, "class" => $class, "section" => $section]);
            }
            
            // Class VI, VII, VIII
            else if(in_array($class_id, [7, 8, 9]) && $exam_id == 2)
            {
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 7) {
                    if($section_id == 1) {
                        $class_teacher = "MS. SAROJ";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. YOGITA";
                    }
                }
                if($class_id == 8) {
                    if($section_id == 1) {
                        $class_teacher = "MS. NIKHAT";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. JYOTIKA";
                    }
                }
                if($class_id == 9) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TERESA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. DONA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    
                    // Get the subject_id of Subject 10
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 24,
                        "student_id"        => $student['id'],
                    ]);
                    
                    $subject_id = $row["subject_id"];
                    $subject = $this->Subject->get($subject_id);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "moral_science"     => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"         => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "third_language"    => $this->Marks->get_student_grade($class_id, 2, 26,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT TEST
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 1, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 1, $subject_id, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 2, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 2, $subject_id, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "physics"               =>  $unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $unit_test_marks["biology"]             + $first_term_marks["biology"],
                        "history"               =>  $unit_test_marks["history"]             + $first_term_marks["history"],
                        "geography"             =>  $unit_test_marks["geography"]           + $first_term_marks["geography"],
                        "subject_10_marks"      =>  $unit_test_marks["subject_10_marks"]    + $first_term_marks["subject_10_marks"],
                    ];
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "pcb"               => number_format(($totals["physics"] + $totals["chemistry"] + $totals["biology"]) / 3),
                        "hg"                => number_format(($totals["history"] + $totals["geography"]) / 2),
                        "subject_10_marks"  => $totals["subject_10_marks"]
                    ];
                    
                    $total_avg = $avgs["english"] + $avgs["second_language"] + $avgs["mathematics"] + $avgs["pcb"] + $avgs["hg"] + $avgs["subject_10_marks"];
                    
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["physics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["chemistry"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["biology"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["history"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["geography"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["subject_10_marks"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($avgs["english"] >= 45 && $avgs["second_language"] >= 25 && $avgs["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_avg;
                        }
                    }
                    

                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],
                        "remarks"               => $remark,
                        "unit_test_marks"       => $unit_test_marks,
                        "first_term_marks"      => $first_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "avgs"                  => $avgs,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_point"           => $total_point,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($all_ranks);
                // echo "</pre>";
                
                $this->load->view("academics/".$this->input->post('result_type')."/class_vi_viii", ["students" => $records, "ranks" => $all_ranks, "class" => $class, "section" => $section]);
            }
            
            // Class IX to X
            else if(in_array($class_id, [10, 11]) && $exam_id == 2) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 10) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TAPASYA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. SMRITA";
                    }
                }
                
                if($class_id == 11) {
                    if($section_id == 1) {
                        $class_teacher = "MS. PRATIMA";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. PRASANSA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Get the subject_id of Subject 10
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 24,
                        "student_id"        => $student['id'],
                    ]);
                    
                    $subject_id = $row["subject_id"];
                    $subject = $this->Subject->get($subject_id);
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25,  $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5, $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 1, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 1, $subject_id, $student['id']),
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25,  $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5, $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 15, $student['id']),
                        "geography"             => $this->Marks->get_student_marks($class_id, 2, 10, $student['id']),
                        "subject_10_marks"      => $this->Marks->get_student_marks($class_id, 2, $subject_id, $student['id']),
                    ];
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "physics"               =>  $unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $unit_test_marks["biology"]             + $first_term_marks["biology"],
                        "history"               =>  $unit_test_marks["history"]             + $first_term_marks["history"],
                        "geography"             =>  $unit_test_marks["geography"]           + $first_term_marks["geography"],
                        "subject_10_marks"      =>  $unit_test_marks["subject_10_marks"]    + $first_term_marks["subject_10_marks"],
                    ];
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "pcb"               => number_format(($totals["physics"] + $totals["chemistry"] + $totals["biology"]) / 3),
                        "hg"                => number_format(($totals["history"] + $totals["geography"]) / 2),
                        "second_language"   => $totals["second_language"],
                        "mathematics"       => $totals["mathematics"],
                        "subject_10_marks"  => $totals["subject_10_marks"],
                    ];
                    
                    $total_avg = $avgs["english"] + $avgs["pcb"] + $avgs["hg"] + $avgs["second_language"] + $avgs["mathematics"] + $avgs["subject_10_marks"];
                    
                    
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 33 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["pcb"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["hg"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["second_language"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["mathematics"] < 33)  {$number_of_failed_subject++;}
                    if($avgs["subject_10_marks"] < 33)  {$number_of_failed_subject++;}
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
                
                $this->load->view("academics/".$this->input->post('result_type')."/class_ix_x", ["students" => $records, "ranks" => $ranks, "class" => $class, "section" => $section]);
            }
            
            // Class XI Section SC
            else if(in_array($class_id, [12]) && $section_id == 3  && $exam_id == 2) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [];
                    
                    // english_language
                    if(strtoupper($first_term_marks["english_language"]) == "AB") {
                        $totals["english_language"] = "AB";
                    }
                    else {
                        $totals["english_language"] = (int)$first_term_marks["english_language"] * 2;
                    }
                    
                    // english_literature
                    if(strtoupper($first_term_marks["english_literature"]) == "AB") {
                        $totals["english_literature"] = "AB";
                    }
                    else {
                        $totals["english_literature"] = (int)$first_term_marks["english_literature"] * 2;
                    }
                    
                    // physics
                    if(strtoupper($first_term_marks["physics"]) == "AB") {
                        $totals["physics"] = "AB";
                    }
                    else {
                        $totals["physics"] = (int)$first_term_marks["physics"] * 2;
                    }
                    
                    // chemistry
                    if(strtoupper($first_term_marks["chemistry"]) == "AB") {
                        $totals["chemistry"] = "AB";
                    }
                    else {
                        $totals["chemistry"] = (int)$first_term_marks["chemistry"] * 2;
                    }
                    
                    // biology
                    if(strtoupper($first_term_marks["biology"]) == "AB") {
                        $totals["biology"] = "AB";
                    }
                    else {
                        $totals["biology"] = (int)$first_term_marks["biology"] * 2;
                    }
                    
                    // optional_paper_1
                    if(strtoupper($first_term_marks["optional_paper_1"]) == "AB") {
                        $totals["optional_paper_1"] = "AB";
                    }
                    else {
                        $totals["optional_paper_1"] = (int)$first_term_marks["optional_paper_1"] * 2;
                    }
                    
                    // optional_paper_2
                    if(strtoupper($first_term_marks["optional_paper_2"]) == "AB") {
                        $totals["optional_paper_2"] = "AB";
                    }
                    else {
                        $totals["optional_paper_2"] = (int)$first_term_marks["optional_paper_2"] * 2;
                    }
                
                    $avgs = [];
                    
                    if($totals["english_language"] == "AB" ||  $totals["english_literature"] == "AB") {
                        $avgs["english"] = 0;
                    }
                    else {
                        $avgs["english"] =  number_format(($totals["english_language"] + $totals["english_literature"]) / 2);
                    }
                    
                    if($totals["physics"] == "AB") {
                        $avgs["physics"] = 0;    
                    }
                    else {
                        $avgs["physics"] = $totals["physics"];
                    }
                    
                    if($totals["chemistry"] == "AB") {
                        $avgs["chemistry"] = 0;    
                    }
                    else {
                        $avgs["chemistry"] = $totals["chemistry"];
                    }
                    
                    if($totals["biology"] == "AB") {
                        $avgs["biology"] = 0;    
                    }
                    else {
                        $avgs["biology"] = $totals["biology"];
                    }
                    
                    if($totals["optional_paper_1"] == "AB") {
                        $avgs["optional_paper_1"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if($totals["optional_paper_2"] == "AB") {
                        $avgs["optional_paper_2"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    $total_avg = $avgs["english"] + $avgs["physics"] + $avgs["chemistry"] + $avgs["biology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $has_ab = "NO";
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value == "AB") {
                            $point = 8;
                            $has_ab = "YES";
                            
                        }
                        elseif($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["physics"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["chemistry"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["biology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                        "has_ab"            => $has_ab
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                $this->load->view("academics/".$this->input->post('result_type')."/class_xi_SC", ["students" => $records, "ranks" => $ranks, "class" => $class, "section" => $section]);
            }
            
            // Class XI Section AR
            else if(in_array($class_id, [12]) && $section_id == 4 && $exam_id == 2) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 2, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 2, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [];
                    
                    // english_language
                    if(strtoupper($first_term_marks["english_language"]) == "AB") {
                        $totals["english_language"] = "AB";
                    }
                    else {
                        $totals["english_language"] = (int)$first_term_marks["english_language"] * 2;
                    }
                    
                    // english_literature
                    if(strtoupper($first_term_marks["english_literature"]) == "AB") {
                        $totals["english_literature"] = "AB";
                    }
                    else {
                        $totals["english_literature"] = (int)$first_term_marks["english_literature"] * 2;
                    }
                    
                    // history
                    if(strtoupper($first_term_marks["history"]) == "AB") {
                        $totals["history"] = "AB";
                    }
                    else {
                        $totals["history"] = (int)$first_term_marks["history"] * 2;
                    }
                    
                    // political_science
                    if(strtoupper($first_term_marks["political_science"]) == "AB") {
                        $totals["political_science"] = "AB";
                    }
                    else {
                        $totals["political_science"] = (int)$first_term_marks["political_science"] * 2;
                    }
                    
                    // sociology
                    if(strtoupper($first_term_marks["sociology"]) == "AB") {
                        $totals["sociology"] = "AB";
                    }
                    else {
                        $totals["sociology"] = (int)$first_term_marks["sociology"] * 2;
                    }
                    
                    // optional_paper_1
                    if(strtoupper($first_term_marks["optional_paper_1"]) == "AB") {
                        $totals["optional_paper_1"] = "AB";
                    }
                    else {
                        $totals["optional_paper_1"] = (int)$first_term_marks["optional_paper_1"] * 2;
                    }
                    
                    // optional_paper_2
                    if(strtoupper($first_term_marks["optional_paper_2"]) == "AB") {
                        $totals["optional_paper_2"] = "AB";
                    }
                    else {
                        $totals["optional_paper_2"] = (int)$first_term_marks["optional_paper_2"] * 2;
                    }
                
                    $avgs = [];
                    
                    if($totals["english_language"] == "AB" ||  $totals["english_literature"] == "AB") {
                        $avgs["english"] = 0;
                    }
                    else {
                        $avgs["english"] =  number_format(($totals["english_language"] + $totals["english_literature"]) / 2);
                    }
                    
                    if($totals["history"] == "AB") {
                        $avgs["history"] = 0;    
                    }
                    else {
                        $avgs["history"] = $totals["history"];
                    }
                    
                    if($totals["political_science"] == "AB") {
                        $avgs["political_science"] = 0;    
                    }
                    else {
                        $avgs["political_science"] = $totals["political_science"];
                    }
                    
                    if($totals["sociology"] == "AB") {
                        $avgs["sociology"] = 0;    
                    }
                    else {
                        $avgs["sociology"] = $totals["sociology"];
                    }
                    
                    if($totals["optional_paper_1"] == "AB") {
                        $avgs["optional_paper_1"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if($totals["optional_paper_2"] == "AB") {
                        $avgs["optional_paper_2"] = 0;    
                    }
                    else {
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    
                    // if(isset($unit_test_marks["optional_paper_1"])) {
                    //     $totals["optional_paper_1"] = $unit_test_marks["optional_paper_1"] + $first_term_marks["optional_paper_1"];
                    // }
                    
                    // if(isset($unit_test_marks["optional_paper_2"])) {
                    //     $totals["optional_paper_2"] = $unit_test_marks["optional_paper_2"] + $first_term_marks["optional_paper_2"];
                    // }
                    
                    // $avgs = [
                    //     "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                    //     "history"           => $totals["history"],
                    //     "political_science" => $totals["political_science"],
                    //     "sociology"         => $totals["sociology"],
                    // ];
                    
                    // if(isset($totals["optional_paper_1"])) { 
                    //     $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    // }
                    
                    // if(isset($totals["optional_paper_2"])) { 
                    //     $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    // }
                    
                    $total_avg = $avgs["english"] + $avgs["history"] + $avgs["political_science"] + $avgs["sociology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $has_ab = "NO";
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value == "AB") {
                            $point = 8;
                            $has_ab = "YES";
                        }
                        elseif($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["history"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["political_science"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["sociology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                        "has_ab"            => $has_ab
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                $this->load->view("academics/".$this->input->post('result_type')."/class_xi_AR", ["students" => $records, "ranks" => $ranks, "class" => $class, "section" => $section]);
            }


            // Class XII Section SC
            else if(in_array($class_id, [13]) && $section_id == 3  && $exam_id == 2) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                if($class_id == 13) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ANITA";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. ONGMU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 1, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 1, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 1, 5,  $student['id']),
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "physics"               => $this->Marks->get_student_marks($class_id, 2, 6,  $student['id']),
                        "chemistry"             => $this->Marks->get_student_marks($class_id, 2, 7,  $student['id']),
                        "biology"               => $this->Marks->get_student_marks($class_id, 2, 5,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                        
                        $unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[1]["id"],  $student['id']);
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "physics"               =>  $unit_test_marks["physics"]             + $first_term_marks["physics"],
                        "chemistry"             =>  $unit_test_marks["chemistry"]           + $first_term_marks["chemistry"],
                        "biology"               =>  $unit_test_marks["biology"]             + $first_term_marks["biology"]
                    ];
                    
                    if(isset($unit_test_marks["optional_paper_1"])) {
                        $totals["optional_paper_1"] = $unit_test_marks["optional_paper_1"] + $first_term_marks["optional_paper_1"];
                    }
                    
                    if(isset($unit_test_marks["optional_paper_2"])) {
                        $totals["optional_paper_2"] = $unit_test_marks["optional_paper_2"] + $first_term_marks["optional_paper_2"];
                    }
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "physics"           => $totals["physics"],
                        "chemistry"         => $totals["chemistry"],
                        "biology"           => $totals["biology"],
                    ];
                    
                    if(isset($totals["optional_paper_1"])) { 
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if(isset($totals["optional_paper_2"])) { 
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    $total_avg = $avgs["english"] + $avgs["physics"] + $avgs["chemistry"] + $avgs["biology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["physics"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["chemistry"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["biology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                $this->load->view("academics/".$this->input->post('result_type')."/class_xi_xii_SC", ["students" => $records, "ranks" => $ranks, "class" => $class, "section" => $section]);
            }
            
            // Class XII Section AR
            else if(in_array($class_id, [13]) && $section_id == 4 && $exam_id == 2) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                
                $records = [];
                
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 12) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ROSELINE";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. KARMA";
                    }
                }
                
                if($class_id == 13) {
                    // SC
                    if($section_id == 3) {
                        $class_teacher = "MS. ANITA";
                    }
                    
                    // AR
                    if($section_id == 4) {
                        $class_teacher = "MS. ONGMU";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    $optional_papers = [];
                    
                    // Subject 3
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 12,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    // Subject 8
                    $row = $this->StudentSubject->get_where([
                        "academy_class_id"  => $class_id,
                        "subject_type_id"   => 17,
                        "student_id"        => $student['id'],
                    ]);
                    
                    if($row["subject_id"]) {
                        $subject_id = $row["subject_id"];
                        $subject = $this->Subject->get($subject_id);
                        
                        $optional_papers[] = $subject;
                    }
                    
                    
                    
                    // SC
                    if($section_id == 3) {
                        // Subject 4
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 13,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                    
                    // AR
                    if($section_id == 4) {
                        // Subject 7
                        $row = $this->StudentSubject->get_where([
                            "academy_class_id"  => $class_id,
                            "subject_type_id"   => 16,
                            "student_id"        => $student['id'],
                        ]);
                        
                        if($row["subject_id"]) {
                            $subject_id = $row["subject_id"];
                            $subject = $this->Subject->get($subject_id);
                            
                            $optional_papers[] = $subject;
                        }
                    }
                   
                    
                    $grade_subjects = [
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id'])
                    ];
                    
                    $unit_test_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 1, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 1, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 1, 29,  $student['id']),
                    ];
                    
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "history"               => $this->Marks->get_student_marks($class_id, 2, 9,  $student['id']),
                        "political_science"     => $this->Marks->get_student_marks($class_id, 2, 21,  $student['id']),
                        "sociology"             => $this->Marks->get_student_marks($class_id, 2, 29,  $student['id']),
                    ];
                    
                    if(count($optional_papers) == 1) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                    }
                    
                    if(count($optional_papers) == 2) {
                        $unit_test_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[0]["id"],  $student['id']);
                        $first_term_marks["optional_paper_1"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[0]["id"],  $student['id']);
                        
                        $unit_test_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 1, $optional_papers[1]["id"],  $student['id']);
                        $first_term_marks["optional_paper_2"] = $this->Marks->get_student_marks($class_id, 2, $optional_papers[1]["id"],  $student['id']);
                    }
                    
                    $totals = [
                        "english_language"      =>  $unit_test_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "history"               =>  $unit_test_marks["history"]             + $first_term_marks["history"],
                        "political_science"     =>  $unit_test_marks["political_science"]           + $first_term_marks["political_science"],
                        "sociology"             =>  $unit_test_marks["sociology"]             + $first_term_marks["sociology"]
                    ];
                    
                    if(isset($unit_test_marks["optional_paper_1"])) {
                        $totals["optional_paper_1"] = $unit_test_marks["optional_paper_1"] + $first_term_marks["optional_paper_1"];
                    }
                    
                    if(isset($unit_test_marks["optional_paper_2"])) {
                        $totals["optional_paper_2"] = $unit_test_marks["optional_paper_2"] + $first_term_marks["optional_paper_2"];
                    }
                    
                    $avgs = [
                        "english"           => number_format(($totals["english_language"] + $totals["english_literature"]) / 2),
                        "history"           => $totals["history"],
                        "political_science" => $totals["political_science"],
                        "sociology"         => $totals["sociology"],
                    ];
                    
                    if(isset($totals["optional_paper_1"])) { 
                        $avgs["optional_paper_1"] = $totals["optional_paper_1"];
                    }
                    
                    if(isset($totals["optional_paper_2"])) { 
                        $avgs["optional_paper_2"] = $totals["optional_paper_2"];
                    }
                    
                    $total_avg = $avgs["english"] + $avgs["history"] + $avgs["political_science"] + $avgs["sociology"] + $avgs["second_language"] + $avgs["mathematics"];
                    
                    if(isset($avgs["optional_paper_1"])){
                        $total_avg+=$avgs["optional_paper_1"];
                    }
                    
                    if(isset($avgs["optional_paper_2"])){
                        $total_avg+=$avgs["optional_paper_2"];
                    }
                
                    $points = [];
                    $total_point = 0;
                    $division = "";
                    
                    foreach($avgs as $key => $value) {
                        
                        $point = "";
                        
                        if($value >= 90 && $value <= 100) {
                            $point = 1;
                        }
                        elseif($value >= 80 && $value <= 89) {
                            $point = 2;
                        }
                        elseif($value >= 70 && $value <= 79) {
                            $point = 3;
                        }
                        elseif($value >= 60 && $value <= 69) {
                            $point = 4;
                        }
                        elseif($value >= 50 && $value <= 59) {
                            $point = 5;
                        }
                        elseif($value >= 46 && $value <= 49) {
                            $point = 6;
                        }
                        elseif($value == 45) {
                            $point = 7;
                        }
                        else {
                            $point = 8;
                        }
                        
                        $total_point += $point;
                        $points[$key] = $point;
                    }
                    
                    
                    if($total_point > 44) {
                        $division = "Unsatisfactory";
                    }
                    elseif($total_point >= 39 && $total_point <= 44) {
                        $division = "Pass";
                    }
                    elseif($total_point >= 31 && $total_point <= 38) {
                        $division = "3rd";
                    }
                    elseif($total_point >= 21 && $total_point <= 30) {
                        $division = "2nd";
                    }
                    elseif($total_point <= 21) {
                        $division = "1st";
                    }
                    else {
                        $division = "";
                    }
                    
                    $passed_in_english = $avgs["english"] >= 35 ? true : false;
                    $number_of_failed_subject = 0;
                    $eligible_for_rank = true;
                    $passed = true;
                    
                    if($avgs["history"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["political_science"] < 35)  {$number_of_failed_subject++;}
                    if($avgs["sociology"] < 35)  {$number_of_failed_subject++;}
                    
                    if(isset($avgs["optional_paper_1"]))
                    { 
                        if($avgs["optional_paper_1"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    if(isset($avgs["optional_paper_2"]))
                    { 
                        if($avgs["optional_paper_2"] < 35) {$number_of_failed_subject++;}
                    }
                    
                    
                    if(!$passed_in_english || $number_of_failed_subject >=3) {
                        $passed = false;
                        $eligible_for_rank = false;
                    }
                    else {
                        $passed = true;
                         
                        if($number_of_failed_subject == 1 || $number_of_failed_subject == 2){
                            $eligible_for_rank = false;    
                        }
                    }
                    
                    
                    if($eligible_for_rank) {
                        if(!in_array($total_avg, $ranks)) {
                            $ranks[] = $total_avg;
                        }    
                    }
                    
                    $data = [
                        "name"              => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"           => $student["roll_no"],
                        "student_no"        => $student["student_no"],
                        "student_id"        => $student["id"],
                        "remarks"           => $remark,
                        "optional_papers"   => $optional_papers,
                        "unit_test_marks"   => $unit_test_marks,
                        "first_term_marks"  => $first_term_marks,
                        "evolution_grades"  => $grades,
                        "totals"            => $totals,
                        "avgs"              => $avgs,
                        "total_avg"         => $total_avg,
                        "points"            => $points,
                        "total_point"       => $total_point,
                        "division"          => $division,
                        "attendence"        => $attendence,
                        "subject"           => $subject,
                        "passed"            => $passed,
                        "eligible_for_rank" => $eligible_for_rank,
                        "grade_subjects"    => $grade_subjects,
                        "class_teacher"     => $class_teacher,
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                    
                rsort($ranks);
            
                // echo "<pre>";
                // print_r($ranks);
                // echo "</pre>";
    
                $this->load->view("academics/".$this->input->post('result_type')."/class_xi_xii_AR", ["students" => $records, "ranks" => $ranks, "class" => $class, "section" => $section]);
            }


            // Class I to II
            if(in_array($class_id, [2, 3]) && $exam_id == 4) 
            { 
            
                $students = $this->Student->get_where([
                    "class_id"      => $class_id,
                    "section_id"    => $section_id,
                    "student_session.promoted"      => "ANY",
                ]);
                
                $records = [];
                $ranks = [];
                
                $class_teacher = "";
                if($class_id == 2) {
                    if($section_id == 1) {
                        $class_teacher = "MS. JEENY";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. KALPANA";
                    }
                }
                
                if($class_id == 3) {
                    if($section_id == 1) {
                        $class_teacher = "MS. TULSI";
                    }
                    
                    if($section_id == 2) {
                        $class_teacher = "MS. LIPIKA";
                    }
                }
                
                foreach($students as $student) {
                    $student_evolution = $this->Marks->get_student_evolution($class_id, $exam_id, $student['id']);
                    $grades = explode(",", $student_evolution);
                    
                    $attendence = $this->ExamAttendence->get_student_attendence_percentage($class_id, $exam_id, $student['id']);
                    $remark     = $this->Remarks->get_student_remarks($class_id, $exam_id, $student['id']);
                    
                    // Grade Subjects
                    $grade_subjects = [
                        "gk"            => $this->Marks->get_student_grade($class_id, 2, 22,  $student['id']), 
                        "moral_science" => $this->Marks->get_student_grade($class_id, 2, 23,  $student['id']),
                        "catechism"     => $this->Marks->get_student_grade($class_id, 2, 24,  $student['id']),
                        "handwriting"   => $this->Marks->get_student_grade($class_id, 2, 27,  $student['id']),
                        "drawing"       => $this->Marks->get_student_grade($class_id, 2, 30,  $student['id'])
                    ];
                    
                    // Marks Subject UNIT1 TEST
                    $unit_test1_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 1, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 1, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 1, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 1, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 1, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 1, 16, $student['id']),
                    ];
                    
                    // Marks Subject First Term
                    $first_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 2, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 2, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 2, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 2, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 2, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 2, 16, $student['id']),
                    ];
                    
                    // Marks Subject UNIT2 TEST
                    $unit_test2_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 3, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 3, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 3, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 3, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 3, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 3, 16, $student['id']),
                    ];
                    
                    // Marks Subject Annual Term
                    $annual_term_marks = [
                        "english_language"      => $this->Marks->get_student_marks($class_id, 4, 2,  $student['id']),
                        "english_literature"    => $this->Marks->get_student_marks($class_id, 4, 1,  $student['id']),
                        "second_language"       => $this->Marks->get_student_marks($class_id, 4, 25, $student['id']),
                        "mathematics"           => $this->Marks->get_student_marks($class_id, 4, 3,  $student['id']),
                        "evs"                   => $this->Marks->get_student_marks($class_id, 4, 8,  $student['id']),
                        "computer"              => $this->Marks->get_student_marks($class_id, 4, 16, $student['id']),
                    ];
                    
                    $first_term_totals = [
                        "english_language"      =>  $unit_test1_marks["english_language"]    + $first_term_marks["english_language"],
                        "english_literature"    =>  $unit_test1_marks["english_literature"]  + $first_term_marks["english_literature"],
                        "second_language"       =>  $unit_test1_marks["second_language"]     + $first_term_marks["second_language"],
                        "mathematics"           =>  $unit_test1_marks["mathematics"]         + $first_term_marks["mathematics"],
                        "evs"                   =>  $unit_test1_marks["evs"]                 + $first_term_marks["evs"],
                        "computer"              =>  $unit_test1_marks["computer"]            + $first_term_marks["computer"],
                    ];
                    
                    $annual_term_totals = [
                        "english_language"      =>  $unit_test2_marks["english_language"]    + $annual_term_marks["english_language"],
                        "english_literature"    =>  $unit_test2_marks["english_literature"]  + $annual_term_marks["english_literature"],
                        "second_language"       =>  $unit_test2_marks["second_language"]     + $annual_term_marks["second_language"],
                        "mathematics"           =>  $unit_test2_marks["mathematics"]         + $annual_term_marks["mathematics"],
                        "evs"                   =>  $unit_test2_marks["evs"]                 + $annual_term_marks["evs"],
                        "computer"              =>  $unit_test2_marks["computer"]            + $annual_term_marks["computer"],
                    ];
                    
                    $final_term_avg = [
                        "english_language"      =>  ceil($first_term_totals["english_language"] / 2),
                        "english_literature"    =>  ceil($first_term_totals["english_literature"] / 2),
                        "second_language"       =>  ceil($first_term_totals["second_language"] / 2),
                        "mathematics"           =>  ceil($first_term_totals["mathematics"] / 2),
                        "evs"                   =>  ceil($first_term_totals["evs"] / 2),
                        "computer"              =>  ceil($first_term_totals["computer"] / 2),
                    ];
                    
                    $annual_term_avg = [
                        "english_language"      =>  ceil($annual_term_totals["english_language"] / 2),
                        "english_literature"    =>  ceil($annual_term_totals["english_literature"] / 2),
                        "second_language"       =>  ceil($annual_term_totals["second_language"] / 2),
                        "mathematics"           =>  ceil($annual_term_totals["mathematics"] / 2),
                        "evs"                   =>  ceil($annual_term_totals["evs"] / 2),
                        "computer"              =>  ceil($annual_term_totals["computer"] / 2),
                    ];
                    
                    $first_term_percentage = [
                        "english"           => number_format(($first_term_totals["english_language"] + $first_term_totals["english_literature"]) / 2),
                        "second_language"   => $first_term_totals["second_language"],
                        "mathematics"       => $first_term_totals["mathematics"],
                        "evs"               => $first_term_totals["evs"],
                        "computer"          => $first_term_totals["computer"]
                    ];
                    
                    $annual_term_percentage = [
                        "english"           => number_format(($annual_term_totals["english_language"] + $annual_term_totals["english_literature"]) / 2),
                        "second_language"   => $annual_term_totals["second_language"],
                        "mathematics"       => $annual_term_totals["mathematics"],
                        "evs"               => $annual_term_totals["evs"],
                        "computer"          => $annual_term_totals["computer"]
                    ];
                    
                    $first_total_percentage = $first_term_percentage["english"] + $first_term_percentage["second_language"] + $first_term_percentage["mathematics"] + $first_term_percentage["evs"] + $first_term_percentage["computer"] ;
                    $first_term_avg = number_format($first_total_percentage / 5);
                    
                    $annual_total_percentage = $annual_term_percentage["english"] + $annual_term_percentage["second_language"] + $annual_term_percentage["mathematics"] + $annual_term_percentage["evs"] + $annual_term_percentage["computer"] ;
                    $annual_term_avg = number_format($annual_term_percentage / 5);
                    
                    $total_avg = ($first_term_avg + $annual_term_avg) / 2;
                    
                    $division = "";
                    
                    if($total_avg >= 85 && $total_avg <= 100) {
                        $division = "1st Div";
                    }
                    elseif($total_avg >= 65 && $total_avg <= 84) {
                        $division = "2nd Div";
                    }
                    elseif($total_avg >= 45 && $total_avg <= 64) {
                        $division = "3rd Div";
                    }
                    elseif($total_avg < 45) {
                        $division = "Unsatisfactory";
                    }
                    else {
                        $division = "";
                    }
                    
                    
                    $numberOfSubjectMarksIsLessThan45 = 0;
                    
                    if($totals["english_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["english_literature"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["second_language"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["mathematics"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["evs"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    if($totals["computer"] < 45) {$numberOfSubjectMarksIsLessThan45++;}
                    
                    
                    // Direct Condidiotion
                    $passed = false;
                    $eligible_for_rank = false;
                    
                    if($percentage["english"] >= 45 && $percentage["second_language"] >= 25 && $percentage["mathematics"] >= 25) {
                        $passed = true;
                    }
                    else {
                        $passed = false;
                    }
                    
                    if($passed) {
                        if($numberOfSubjectMarksIsLessThan45 == 1 || $numberOfSubjectMarksIsLessThan45 == 2) {
                            $passed = true;
                            $eligible_for_rank = false;
                        }
                        else if($numberOfSubjectMarksIsLessThan45 >= 3) {
                            $passed = false;
                            $eligible_for_rank = false;
                        }
                        else {
                            $passed = true;
                            $eligible_for_rank = true;
                            $ranks[] = $total_percentage;
                        }
                    }
                    
    
                    $data = [
                        "name"                  => $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"],
                        "roll_no"               => $student["roll_no"],
                        "student_no"            => $student["student_no"],
                        "student_id"            => $student["id"],               
                        "remarks"               => $remark,
                        "unit_test1_marks"      => $unit_test1_marks,
                        "unit_test2_marks"      => $unit_test2_marks,
                        "first_term_marks"      => $first_term_marks,
                        "annual_term_marks"     => $annual_term_marks,
                        "evolution_grades"      => $grades,
                        "totals"                => $totals,
                        "percentage"            => $percentage,
                        "total_avg"             => $total_avg,
                        "points"                => $points,
                        "total_percentage"      => $total_percentage,
                        "total_avg_percentage"  => $total_avg_percentage,
                        "division"              => $division,
                        "attendence"            => $attendence,
                        "subject"               => $subject,
                        "passed"                => $passed,
                        "eligible_for_rank"     => $eligible_for_rank,
                        "grade_subjects"        => $grade_subjects,
                        "class_teacher"         => $class_teacher
                    ];
                    
                    $records[] = $data;
                }
                
                if($report_for != "all") {
                    $student_id = $this->input->post("student_id");
                    
                    $temp = [];
                    
                    foreach($records as $record) {
                        if($record["student_id"] == $student_id) {
                            $temp[] = $record;
                        }
                    }
                    
                    $records = $temp;
                }
                
                $class = $this->AcademyClass->get($class_id);
                $section = $this->Section->get($section_id);
                
                $all_ranks = array_unique($ranks);
                rsort($all_ranks);
            
                // echo "<pre>";
                // print_r($records);
                // echo "</pre>";
                
                $this->load->view("academics/annual_result/class_i_vi", ["students" => $records, "ranks" => $all_ranks, "class" => $class, "section" => $section]);
            }
            
            else {
                echo "Report Not Available";
            }
            //END
        }
    
}