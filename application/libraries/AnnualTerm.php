<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnnualTerm {
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
        


    
}