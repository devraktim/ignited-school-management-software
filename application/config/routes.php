<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// Authentication Routes
$route["register"]["POST"] = "AuthController/register";
$route["login"]["POST"] = "AuthController/login";
$route["logout"]["GET"] = "AuthController/logout";
$route["change-password"]["GET"] = "AuthController/edit_password";
$route["change-password"]["POST"] = "AuthController/update_password";
$route["reset-user-password"]["POST"] = "AuthController/reset_user_password";

// Academy Session Routes
$route["masters/sessions"]["GET"] = "Master/SessionController/index";
$route["masters/sessions"]["POST"] = "Master/SessionController/store";
$route["masters/classes/update/(:any)"]["POST"] = "Master/ClassController/update/$1";
$route["masters/classes/delete/(:any)"]["GET"] = "Master/ClassController/delete/$1";
// Classes Routes
$route["masters/classes"]["GET"] = "Master/ClassController/index";
$route["masters/classes"]["POST"] = "Master/ClassController/store";
$route["masters/classes/update/(:any)"]["POST"] = "Master/ClassController/update/$1";
$route["masters/classes/delete/(:any)"]["GET"] = "Master/ClassController/delete/$1";
// Section Routes
$route["masters/sections"]["GET"] = "Master/SectionController/index";
$route["masters/sections"]["POST"] = "Master/SectionController/store";
$route["masters/sections/update/(:any)"]["POST"] = "Master/SectionController/update/$1";
$route["masters/sections/delete/(:any)"]["GET"] = "Master/SectionController/delete/$1";
// Houses Routes
$route["masters/houses"]["GET"] = "Master/HousesController/index";
$route["masters/houses"]["POST"] = "Master/HousesController/store";
$route["masters/houses/update/(:any)"]["POST"] = "Master/HousesController/update/$1";
$route["masters/houses/delete/(:any)"]["GET"] = "Master/HousesController/delete/$1";
// Category Routes
$route["masters/categories"]["GET"] = "Master/CategoryController/index";
$route["masters/categories"]["POST"] = "Master/CategoryController/store";
$route["masters/categories/update/(:any)"]["POST"] = "Master/CategoryController/update/$1";
$route["masters/categories/delete/(:any)"]["GET"] = "Master/CategoryController/delete/$1";
// Student Type Routes
$route["masters/student-types"]["GET"] = "Master/StudentTypeController/index";
$route["masters/student-types"]["POST"] = "Master/StudentTypeController/store";
$route["masters/student-types/update/(:any)"]["POST"] = "Master/StudentTypeController/update/$1";
$route["masters/student-types/delete/(:any)"]["GET"] = "Master/StudentTypeController/delete/$1";
// Religion Routes
$route["masters/religions"]["GET"] = "Master/ReligionController/index";
$route["masters/religions"]["POST"] = "Master/ReligionController/store";
$route["masters/religions/update/(:any)"]["POST"] = "Master/ReligionController/update/$1";
$route["masters/religions/delete/(:any)"]["GET"] = "Master/ReligionController/delete/$1";
// State Routes
$route["masters/states"]["GET"] = "Master/StateController/index";
$route["masters/states"]["POST"] = "Master/StateController/store";
$route["masters/states/update/(:any)"]["POST"] = "Master/StateController/update/$1";
$route["masters/states/delete/(:any)"]["GET"] = "Master/StateController/delete/$1";
// Nationality Routes
$route["masters/nationalities"]["GET"] = "Master/NationalityController/index";
$route["masters/nationalities"]["POST"] = "Master/NationalityController/store";
$route["masters/nationalities/update/(:any)"]["POST"] = "Master/NationalityController/update/$1";
$route["masters/nationalities/delete/(:any)"]["GET"] = "Master/NationalityController/delete/$1";
// Class Section Routes
$route["masters/class-section"]["GET"] = "Master/ClassSectionController/index";
$route["masters/class-section"]["POST"] = "Master/ClassSectionController/store";
$route["masters/class-section/update/(:any)"]["POST"] = "Master/ClassSectionController/update/$1";
$route["masters/class-section/delete/(:any)"]["GET"] = "Master/ClassSectionController/delete/$1";
// Departments Routes
$route["masters/departments"]["GET"] = "Master/DepartmentController/index";
$route["masters/departments"]["POST"] = "Master/DepartmentController/store";
$route["masters/departments/update/(:any)"]["POST"] = "Master/DepartmentController/update/$1";
$route["masters/departments/delete/(:any)"]["GET"] = "Master/DepartmentController/delete/$1";
// Designation Routes
$route["masters/designations"]["GET"] = "Master/DesignationController/index";
$route["masters/designations"]["POST"] = "Master/DesignationController/store";
$route["masters/designations/update/(:any)"]["POST"] = "Master/DesignationController/update/$1";
$route["masters/designations/delete/(:any)"]["GET"] = "Master/DesignationController/delete/$1";
// Employee Type Routes
$route["masters/employee-types"]["GET"] = "Master/EmployeeTypeController/index";
$route["masters/employee-types"]["POST"] = "Master/EmployeeTypeController/store";
$route["masters/employee-types/update/(:any)"]["POST"] = "Master/EmployeeTypeController/update/$1";
$route["masters/employee-types/delete/(:any)"]["GET"] = "Master/EmployeeTypeController/delete/$1";
// Job Status Routes
$route["masters/job-status"]["GET"] = "Master/JobStatusController/index";
$route["masters/job-status"]["POST"] = "Master/JobStatusController/store";
$route["masters/job-status/update/(:any)"]["POST"] = "Master/JobStatusController/update/$1";
$route["masters/job-status/delete/(:any)"]["GET"] = "Master/JobStatusController/delete/$1";
// Subject Routes
$route["masters/subjects"]["GET"] = "Master/SubjectController/index";
$route["masters/subjects"]["POST"] = "Master/SubjectController/store";
$route["masters/subjects/update/(:any)"]["POST"] = "Master/SubjectController/update/$1";
$route["masters/subjects/delete/(:any)"]["GET"] = "Master/SubjectController/delete/$1";
// Subject types Routes
$route["masters/subject-types"]["GET"] = "Master/SubjectTypeController/index";
$route["masters/subject-types"]["POST"] = "Master/SubjectTypeController/store";
$route["masters/subject-types/update/(:any)"]["POST"] = "Master/SubjectTypeController/update/$1";
$route["masters/subject-types/delete/(:any)"]["GET"] = "Master/SubjectTypeController/delete/$1";
// Exam Routes
$route["masters/exams"]["GET"] = "Master/ExamController/index";
$route["masters/exams"]["POST"] = "Master/ExamController/store";
$route["masters/exams/update/(:any)"]["POST"] = "Master/ExamController/update/$1";
$route["masters/exams/delete/(:any)"]["GET"] = "Master/ExamController/delete/$1";
// Component Routes
$route["masters/components"]["GET"] = "Master/ComponentController/index";
$route["masters/components"]["POST"] = "Master/ComponentController/store";
$route["masters/components/update/(:any)"]["POST"] = "Master/ComponentController/update/$1";
$route["masters/components/delete/(:any)"]["GET"] = "Master/ComponentController/delete/$1";
// Exam Grades Routes
$route["masters/exam-grades"]["GET"] = "Master/ExamGradeController/index";
$route["masters/exam-grades"]["POST"] = "Master/ExamGradeController/store";
$route["masters/exam-grades/update/(:any)"]["POST"] = "Master/ExamGradeController/update/$1";
$route["masters/exam-grades/delete/(:any)"]["GET"] = "Master/ExamGradeController/delete/$1";
// Evolution Grades Routes
$route["masters/evolution-grades"]["GET"] = "Master/EvolutionGradeController/index";
$route["masters/evolution-grades"]["POST"] = "Master/EvolutionGradeController/store";
$route["masters/evolution-grades/update/(:any)"]["POST"] = "Master/EvolutionGradeController/update/$1";
$route["masters/evolution-grades/delete/(:any)"]["GET"] = "Master/EvolutionGradeController/delete/$1";

// Evolution Subjets Routes
$route["masters/evolution-subjects"]["GET"] = "Master/EvolutionSubjectController/index";
$route["masters/evolution-subjects"]["POST"] = "Master/EvolutionSubjectController/store";
$route["masters/evolution-subjects/update/(:any)"]["POST"] = "Master/EvolutionSubjectController/update/$1";
$route["masters/evolution-subjects/delete/(:any)"]["GET"] = "Master/EvolutionSubjectController/delete/$1";

// Withdrawn Students Routes
$route["masters/withdrawal-reason"]["GET"] = "Master/WithdrawnReasonController/index";
$route["masters/withdrawal-reason"]["POST"] = "Master/WithdrawnReasonController/store";
$route["masters/withdrawal-reason/update/(:any)"]["POST"] = "Master/WithdrawnReasonController/update/$1";
$route["masters/withdrawal-reason/delete/(:any)"]["GET"] = "Master/WithdrawnReasonController/delete/$1";

// Conducts Students Routes
$route["masters/conducts"]["GET"] = "Master/ConductController/index";
$route["masters/conducts"]["POST"] = "Master/ConductController/store";
$route["masters/conducts/update/(:any)"]["POST"] = "Master/ConductController/update/$1";
$route["masters/conducts/delete/(:any)"]["GET"] = "Master/ConductController/delete/$1";

// Behaviours Students Routes
$route["masters/behaviours"]["GET"] = "Master/BehaviourController/index";
$route["masters/behaviours"]["POST"] = "Master/BehaviourController/store";
$route["masters/behaviours/update/(:any)"]["POST"] = "Master/BehaviourController/update/$1";
$route["masters/behaviours/delete/(:any)"]["GET"] = "Master/BehaviourController/delete/$1";

// Punctualities Students Routes
$route["masters/punctualities"]["GET"] = "Master/PunctualityController/index";
$route["masters/punctualities"]["POST"] = "Master/PunctualityController/store";
$route["masters/punctualities/update/(:any)"]["POST"] = "Master/PunctualityController/update/$1";
$route["masters/punctualities/delete/(:any)"]["GET"] = "Master/PunctualityController/delete/$1";

// Attendances Students Routes
$route["masters/attendances"]["GET"] = "Master/AttendanceController/index";
$route["masters/attendances"]["POST"] = "Master/AttendanceController/store";
$route["masters/attendances/update/(:any)"]["POST"] = "Master/AttendanceController/update/$1";
$route["masters/attendances/delete/(:any)"]["GET"] = "Master/AttendanceController/delete/$1";

// Interactions Students Routes
$route["masters/interactions"]["GET"] = "Master/InteractionController/index";
$route["masters/interactions"]["POST"] = "Master/InteractionController/store";
$route["masters/interactions/update/(:any)"]["POST"] = "Master/InteractionController/update/$1";
$route["masters/interactions/delete/(:any)"]["GET"] = "Master/InteractionController/delete/$1";

// Leaderships Students Routes
$route["masters/leaderships"]["GET"] = "Master/LeadershipController/index";
$route["masters/leaderships"]["POST"] = "Master/LeadershipController/store";
$route["masters/leaderships/update/(:any)"]["POST"] = "Master/LeadershipController/update/$1";
$route["masters/leaderships/delete/(:any)"]["GET"] = "Master/LeadershipController/delete/$1";

// Expressivenesses Students Routes
$route["masters/expressivenesses"]["GET"] = "Master/ExpressivenessController/index";
$route["masters/expressivenesses"]["POST"] = "Master/ExpressivenessController/store";
$route["masters/expressivenesses/update/(:any)"]["POST"] = "Master/ExpressivenessController/update/$1";
$route["masters/expressivenesses/delete/(:any)"]["GET"] = "Master/ExpressivenessController/delete/$1";

// Participations Students Routes
$route["masters/participations"]["GET"] = "Master/ParticipationController/index";
$route["masters/participations"]["POST"] = "Master/ParticipationController/store";
$route["masters/participations/update/(:any)"]["POST"] = "Master/ParticipationController/update/$1";
$route["masters/participations/delete/(:any)"]["GET"] = "Master/ParticipationController/delete/$1";

// Participations Students Routes
$route["masters/extracurriculars"]["GET"] = "Master/ExtraCurricularController/index";
$route["masters/extracurriculars"]["POST"] = "Master/ExtraCurricularController/store";
$route["masters/extracurriculars/update/(:any)"]["POST"] = "Master/ExtraCurricularController/update/$1";
$route["masters/extracurriculars/delete/(:any)"]["GET"] = "Master/ExtraCurricularController/delete/$1";

// Participations Students Routes
$route["masters/games"]["GET"] = "Master/GameController/index";
$route["masters/games"]["POST"] = "Master/GameController/store";
$route["masters/games/update/(:any)"]["POST"] = "Master/GameController/update/$1";
$route["masters/games/delete/(:any)"]["GET"] = "Master/GameController/delete/$1";

// Participations Students Routes
$route["masters/apprisal-others"]["GET"] = "Master/ApprisalOtherController/index";
$route["masters/apprisal-others"]["POST"] = "Master/ApprisalOtherController/store";
$route["masters/apprisal-others/update/(:any)"]["POST"] = "Master/ApprisalOtherController/update/$1";
$route["masters/apprisal-others/delete/(:any)"]["GET"] = "Master/ApprisalOtherController/delete/$1";

// Resignations Students Routes
$route["masters/resignations"]["GET"] = "Master/ResignationController/index";
$route["masters/resignation"]["POST"] = "Master/ResignationController/store";
$route["masters/resignation/update/(:any)"]["POST"] = "Master/ResignationController/update/$1";
$route["masters/resignation/delete/(:any)"]["GET"] = "Master/ResignationController/delete/$1";

// Absent Reasons Routes
$route["masters/absent-reasons"]["GET"] = "Master/AbsentReasonController/index";
$route["masters/absent-reasons"]["POST"] = "Master/AbsentReasonController/store";
$route["masters/absent-reasons/update/(:any)"]["POST"] = "Master/AbsentReasonController/update/$1";
$route["masters/absent-reasons/delete/(:any)"]["GET"] = "Master/AbsentReasonController/delete/$1";

// Fees Type Routes
$route["masters/fees-types"]["GET"] = "Master/FeesTypeController/index";
$route["masters/fees-types"]["POST"] = "Master/FeesTypeController/store";
$route["masters/fees-types/update/(:any)"]["POST"] = "Master/FeesTypeController/update/$1";
$route["masters/fees-types/delete/(:any)"]["GET"] = "Master/FeesTypeController/delete/$1";

// Fees Type Routes
$route["masters/assign-fees-types"]["GET"] = "Master/FeesTypeController/class_student_fees_index";
$route["masters/assign-fees-types-list"]["GET"] = "Master/FeesTypeController/class_student_get_fees";
$route["masters/assign-fees-types"]["POST"] = "Master/FeesTypeController/class_student_fees_store";
$route["masters/assign-fees-types/update/(:any)"]["POST"] = "Master/FeesTypeController/class_student_fees_update/$1";
$route["masters/assign-fees-types/change-status/(:any)"]["GET"] = "Master/FeesTypeController/class_student_fees_change_status/$1";
$route["masters/assign-fees-types/delete/(:any)"]["GET"] = "Master/FeesTypeController/class_student_fees_delete/$1";

// Fees Plan Routes
$route["master/payment-plan"]["GET"] = "Fees/FeesController/payment_plan_view";
$route["master/payment-plan/create"]["GET"] = "Fees/FeesController/payment_plan_create";
$route["master/payment-plan/edit"]["GET"] = "Fees/FeesController/payment_plan_edit";
$route["master/payment-plan/store"]["POST"] = "Fees/FeesController/payment_plan_store";

// Holidays
$route["masters/holidays"]["GET"] = "Master/TeacherHolidayController/index";
$route["masters/holidays"]["POST"] = "Master/TeacherHolidayController/store";
$route["masters/holidays/update/(:num)"]["POST"] = "Master/TeacherHolidayController/update/$1";
$route["masters/holidays/delete/(:num)"]["POST"] = "Master/TeacherHolidayController/delete/$1";



// Student Routes
$route["students"]["GET"] = "Student/StudentController/index";
$route["students/create"]["GET"] = "Student/StudentController/create";
$route["students/search"]["GET"] = "Student/StudentController/search";
$route["students/store"]["POST"] = "Student/StudentController/store";
$route["students/show/(:any)"]["GET"] = "Student/StudentController/show/$1";
$route["students/batch/edits"]["GET"] = "Student/StudentController/batch_edits";
$route["students/edit/(:any)"]["GET"] = "Student/StudentController/edit/$1";
$route["students/update"]["POST"] = "Student/StudentController/update";
$route["students/batch/updates"]["POST"] = "Student/StudentController/batch_updates";
$route["students/passport"]["GET"] = "Student/StudentController/passport";
$route["students/passport"]["POST"] = "Student/StudentController/passport";
$route["students/passport/update"]["POST"] = "Student/StudentController/passport_update";
$route["students/passport/show/(:any)"]["GET"] = "Student/StudentController/passport_show/$1";
$route["students/passport/report"]["GET"] = "Student/StudentController/report";
$route["students/settings/create"]["GET"] = "Student/SettingController/create";
$route["students/settings/store"]["POST"] = "Student/SettingController/store";
$route["students/check-duplicate/student-no"]["GET"] = "Student/StudentController/is_student_no_exist";

// Student Withdrawn Routes
$route["students/withdrawn-students"]["GET"] = "Student/StudentController/get_withdrawn_students_list";
$route["students/withdrawn-students"]["POST"] = "Student/StudentController/get_withdrawn_students_list";
$route["students/all-withdrawn-students"]["GET"] = "Student/StudentController/get_all_withdrawn_students_list";
$route["students/all-withdrawn-students"]["POST"] = "Student/StudentController/get_all_withdrawn_students_list";
$route["students/new-withdrawal"]["GET"] = "Student/StudentController/new_withdrawn_student";
$route["students/new-withdrawal"]["POST"] = "Student/StudentController/withdrawn_student";
$route["students/delete/withdrawn"]["POST"] = "Student/StudentController/delete_withdrawn_student";
$route["students/withdrawn/generate/transfer-certificate"]["GET"] = "Student/StudentController/generate_transfer_certificate";
$route["students/withdrawn/generate/transfer-certificate"]["POST"] = "Student/StudentController/store_transfer_certificate";
$route["students/withdrawn/generate/charecter-certificate"]["GET"] = "Student/StudentController/generate_charecter_certificate";
$route["students/withdrawn/generate/charecter-certificate"]["POST"] = "Student/StudentController/store_charecter_certificate";

// Student Passout Routes
$route["students/passout-students"]["GET"] = "Student/StudentController/get_passout_students_list";
$route["students/passout-students"]["POST"] = "Student/StudentController/store_passout_students_data";
$route["students/delete/passout"]["POST"] = "Student/StudentController/delete_passout_student";
$route["students/passout/generate/transfer-certificate"]["GET"] = "Student/StudentController/generate_transfer_certificate_for_passout";
$route["students/passout/generate/transfer-certificate"]["POST"] = "Student/StudentController/store_transfer_certificate_for_passout";
$route["students/passout/generate/charecter-certificate"]["GET"] = "Student/StudentController/generate_charecter_certificate_for_passout";
$route["students/passout/generate/charecter-certificate"]["POST"] = "Student/StudentController/store_charecter_certificate_for_passout";

// Student Reports Routes
$route["students/reports"]["GET"] = "Student/StudentReportController";

$route["students/user-defined-report"]["GET"] = "Student/StudentReportController/user_defined_report";
$route["students/user-defined-report"]["POST"] = "Student/StudentReportController/generate_user_defined_report";
$route["students/user-defined-report/get-students"]["GET"] = "Student/StudentReportController/user_defined_report_get_students";

$route["students/reports/student-list"]["POST"] = "Student/StudentReportController/student_list_report";
$route["students/reports/new-admission"]["POST"] = "Student/StudentReportController/student_new_admission_report";
$route["students/reports/inactive-student"]["POST"] = "Student/StudentReportController/student_inactive_report";
$route["students/reports/student-password"]["POST"] = "Student/StudentReportController/student_password_report";

$route["students/reports/breakup-class"]["GET"] = "Student/StudentReportController/breakup_class";
$route["students/reports/breakup-student-type"]["GET"] = "Student/StudentReportController/breakup_student_type";
$route["students/reports/breakup-house"]["GET"] = "Student/StudentReportController/breakup_house";
$route["students/reports/breakup-sex"]["GET"] = "Student/StudentReportController/breakup_sex";
$route["students/reports/breakup-category"]["GET"] = "Student/StudentReportController/breakup_category";
$route["students/reports/breakup-religion"]["GET"] = "Student/StudentReportController/breakup_religion";
$route["students/reports/breakup-state"]["GET"] = "Student/StudentReportController/breakup_state";
$route["students/reports/breakup-nationality"]["GET"] = "Student/StudentReportController/breakup_nationality";

$route["students/reports/download-appraisal-academic"]["POST"] = "Student/StudentReportController/download_appraisal_academic";
$route["students/reports/download-appraisal-extra-curricular"]["POST"] = "Student/StudentReportController/download_appraisal_extra_curricular";
$route["students/reports/download-appraisal-game-and-sports"]["POST"] = "Student/StudentReportController/download_appraisal_game_and_sports";
$route["students/reports/download-appraisal-discipline"]["POST"] = "Student/StudentReportController/download_appraisal_discipline";
$route["students/reports/download-appraisal-others"]["POST"] = "Student/StudentReportController/download_appraisal_others";

$route["students/reports/generate-appraisal-academic"]["GET"] = "Student/StudentReportController/appraisal_academic";
$route["students/reports/generate-appraisal-extra-curricular"]["GET"] = "Student/StudentReportController/appraisal_extra_curricular";
$route["students/reports/generate-appraisal-game-and-sports"]["GET"] = "Student/StudentReportController/appraisal_game_and_sports";
$route["students/reports/generate-appraisal-discipline"]["GET"] = "Student/StudentReportController/appraisal_discipline";
$route["students/reports/generate-appraisal-others"]["GET"] = "Student/StudentReportController/appraisal_others";

$route["students/reports/appraisal-academic"]["POST"] = "Student/StudentReportController/appraisal_academic";
$route["students/reports/appraisal-extra-curricular"]["POST"] = "Student/StudentReportController/store_appraisal_extra_curricular";
$route["students/reports/appraisal-game-and-sports"]["POST"] = "Student/StudentReportController/store_appraisal_game_and_sports";
$route["students/reports/appraisal-discipline"]["POST"] = "Student/StudentReportController/store_appraisal_discipline";
$route["students/reports/appraisal-others"]["POST"] = "Student/StudentReportController/store_appraisal_others";

$route["students/reports/student-biodata"]["POST"] = "Student/StudentReportController/biodata";

$route["students/reports/generate-horizental-id-cards"]["POST"] = "Student/StudentReportController/generate_horizental_id_cards";
$route["students/reports/generate-individual-horizental-id-card"]["POST"] = "Student/StudentReportController/generate_individual_horizental_id_card";

$route["students/reports/generate-vertical-id-cards"]["POST"] = "Student/StudentReportController/generate_vertical_id_cards";
$route["students/reports/generate-individual-vertical-id-card"]["POST"] = "Student/StudentReportController/generate_individual_vertical_id_card";



$route["students/reports/generate-all-biodata"]["POST"] = "Student/StudentReportController/generate_all_biodata";
$route["students/reports/generate-individual-biodata"]["POST"] = "Student/StudentReportController/generate_individual_biodata";


$route["students/reports/report-withdraw"]["POST"] = "Student/StudentReportController/report_withdraw";
$route["students/reports/report-promotion"]["POST"] = "Student/StudentReportController/report_promotion";
$route["students/reports/report-passout"]["POST"] = "Student/StudentReportController/report_passout";
$route["students/reports/subject-list"]["POST"] = "Student/StudentReportController/student_subject_list";


// Personnel Routes
$route["personnel/employee"]["GET"] = "Personnel/EmployeeController/index";
$route["personnel/employee/create"]["GET"] = "Personnel/EmployeeController/create";
$route["personnel/employee/store"]["POST"] = "Personnel/EmployeeController/store";
$route["personnel/employee/show/(:any)"]["GET"] = "Personnel/EmployeeController/show/$1";
$route["personnel/employee/edit/(:any)"]["GET"] = "Personnel/EmployeeController/edit/$1";
$route["personnel/employee/update"]["POST"] = "Personnel/EmployeeController/update";
$route["personnel/employee/search"]["GET"] = "Personnel/EmployeeController/search";
$route["personnel/employee/delete"]["GET"] = "Personnel/EmployeeController/delete";
$route["personnel/departments"]["GET"] = "Personnel/EmployeeController/departments";
$route["personnel/designations"]["GET"] = "Personnel/EmployeeController/designations";
$route["personnel/reports"]["GET"] = "Personnel/EmployeeController/reports";

$route["personnel/settings"]["GET"] = "Personnel/EmployeeController/settings";
$route["personnel/settings/create"]["GET"] = "Personnel/SettingController/create";
$route["personnel/settings/store"]["POST"] = "Personnel/SettingController/store";

$route["personnel/attendance"]["GET"] = "Personnel/EmployeeController/attendance";
$route["personnel/attendance"]["POST"] = "Personnel/EmployeeController/attendance_store";
$route["personnel/attendance/month-wise-report"]["GET"] = "Personnel/EmployeeReportController/month_wise_report";
$route["personnel/attendance/session-wise-report"]["GET"] = "Personnel/EmployeeReportController/year_wise_report";

$route["personnel/report"]["GET"] = "Personnel/EmployeeReportController/index";
$route["personnel/report/employee-list"]["GET"] = "Personnel/EmployeeReportController/employee_list";
$route["personnel/report/inactive-employee-list"]["GET"] = "Personnel/EmployeeReportController/inactive_employee_list";
$route["personnel/report/employee-personal-details"]["GET"] = "Personnel/EmployeeReportController/employee_personal_details";
$route["personnel/report/retired-employee-list"]["GET"] = "Personnel/EmployeeReportController/retired_employee_list";
$route["personnel/report/resigned-employee-list"]["GET"] = "Personnel/EmployeeReportController/resigned_employee_list";
$route["personnel/report/monthly-attendance-report"]["GET"] = "Personnel/EmployeeReportController/monthly_attendance_report";
$route["personnel/report/session-attendance-report"]["GET"] = "Personnel/EmployeeReportController/session_attendance_report";

$route["personnel/report/user-defined-report"]["GET"] = "Personnel/EmployeeReportController/user_defined_report";
$route["personnel/report/user-defined-report"]["POST"] = "Personnel/EmployeeReportController/generate_user_defined_report";
$route["personnel/report/user-defined-report/get-employees"]["GET"] = "Personnel/EmployeeReportController/user_defined_report_get_employees";


$route["personnel/resign-retire"]["GET"] = "Personnel/EmployeeController/resign_retire";
$route["personnel/resign-retire-list"]["GET"] = "Personnel/EmployeeController/resign_retire_list";
$route["personnel/resign-retire"]["POST"] = "Personnel/EmployeeController/resign_retire_store";


$route["personnel/leave"]["GET"] = "Personnel/EmployeeController/leave";
$route["personnel/leave-list"]["GET"] = "Personnel/EmployeeController/leave_list";
$route["personnel/leave"]["POST"] = "Personnel/EmployeeController/leave_store";
$route["personnel/leave/view/(:num)"]["GET"] = "Personnel/EmployeeController/leave_view/$1";
$route["personnel/leave/approve/(:num)"]["GET"] = "Personnel/EmployeeController/approve_leave/$1";
$route["personnel/leave/reject/(:num)"]["GET"] = "Personnel/EmployeeController/reject_leave/$1";
$route["personnel/leave/delete/(:num)"]["GET"] = "Personnel/EmployeeController/delete_leave/$1";


// Security Routes
$route["security/users"]["GET"] = "Security/SecurityController/index";
$route["security/users/create"]["GET"] = "Security/SecurityController/create";
$route["security/users/store"]["POST"] = "Security/SecurityController/store";
$route["security/users/edit/(:any)"]["GET"] = "Security/SecurityController/edit/$1";
$route["security/users/update"]["POST"] = "Security/SecurityController/update";
$route["security/users/show/(:any)"]["GET"] = "Security/SecurityController/show/$1";
$route["security/users/generate-report"]["GET"] = "Security/SecurityController/generate_report";
$route["security/users/report"]["GET"] = "Security/SecurityController/report";
$route["security/users/delete"]["GET"] = "Security/SecurityController/delete";
// Academics Routes
$route["academics/student-subjects"]["GET"] = "Academics/StudentSubjectController/index";
$route["academics/student-subjects"]["POST"] = "Academics/StudentSubjectController/store";
$route["academics/set-examination-paper/create"]["GET"] = "Academics/ExamPaperController/create";
$route["academics/set-examination-paper"]["POST"] = "Academics/ExamPaperController/store";
$route["academics/set-examination-paper/search"]["GET"] = "Academics/ExamPaperController/search";
$route["academics/setting"]["GET"] = "Academics/SettingController/create";
$route["academics/setting"]["POST"] = "Academics/SettingController/store";
$route["academics/setting/assign-teacher-class"]["GET"] = "Academics/SettingController/assign_teacher_class_create";
$route["academics/setting/assign-teacher-class"]["POST"] = "Academics/SettingController/assign_teacher_class_store";
$route["academics/setting/show-class-teacher"]["GET"] = "Academics/SettingController/show_class_teacher";

// Examination Paper Routes
$route["academics/examination-paper"]["GET"] = "Academics/ExamPaperController/index";
$route["academics/examination-paper/edit/(:any)"]["GET"] = "Academics/ExamPaperController/edit/$1";
$route["academics/examination-paper/delete/(:any)"]["GET"] = "Academics/ExamPaperController/delete/$1";
$route["academics/examination-paper/remove-subject"]["GET"] = "Academics/ExamPaperController/remove_subject/";
$route["academics/get-exam-paper"]["GET"] = "Academics/ExamPaperController/get_exam_paper/";
$route["academics/exam-paper-student"]["POST"] = "Academics/ExamPaperController/exam_paper_student/";

// Evolution Paper Routes
$route["academics/evolution-paper"]["GET"] = "Academics/EvolutionPaperController/index";
$route["academics/set-evolution-paper"]["GET"] = "Academics/EvolutionPaperController/create";
$route["academics/set-evolution-paper"]["POST"] = "Academics/EvolutionPaperController/store";

$route["academics/set-evolution-paper/delete/(:any)"]["GET"] = "Academics/EvolutionPaperController/delete/$1";
$route["academics/set-evolution-paper/remove-subject"]["GET"] = "Academics/EvolutionPaperController/remove_subject";


// Grade Entry
$route["academics/grade-entry"]["GET"] = "Academics/GradeEntryController/index";
$route["academics/grade-store"]["POST"] = "Academics/GradeEntryController/grade_store";

// Teacher Remarks
$route["academics/teacher-remarks-entry"]["GET"] = "Academics/TeacherRemarksController/index";
$route["academics/teacher-remarks-entry"]["POST"] = "Academics/TeacherRemarksController/get_students";
$route["academics/teacher-remarks-store"]["POST"] = "Academics/TeacherRemarksController/teacher_remarks_store";

// Exam Attendence
$route["academics/exam-attendence-entry"]["GET"] = "Academics/ExamAttendenceController/index";
$route["academics/exam-attendence-entry"]["POST"] = "Academics/ExamAttendenceController/get_students";
$route["academics/exam-attendence-store"]["POST"] = "Academics/ExamAttendenceController/exam_attendence_store";

// Marks Entry
$route["academics/marks-entry"]["GET"] = "Academics/MarksEntryController/index";
$route["academics/marks-entry"]["POST"] = "Academics/MarksEntryController/get_students";
$route["academics/marks-store"]["POST"] = "Academics/MarksEntryController/marks_store";

// Evolution Entry
$route["academics/evolution-entry"]["GET"] = "Academics/EvolutionEntryController/index";
$route["academics/evolution-entry"]["POST"] = "Academics/EvolutionEntryController/get_students";
$route["academics/evolution-store"]["POST"] = "Academics/EvolutionEntryController/grade_store";


// Result
$route["academics/report"]["GET"] = "Academics/Result/ResultIndex/index";
$route["academics/report/get-students"]["GET"] = "Academics/Result/ResultIndex/get_students";
$route["academics/result/first_term"]["POST"] = "Academics/Result/HalfYearly/get_result";
$route["academics/result/annual_term"]["POST"] = "Academics/Result/AnnualTerm/get_result";


// Promotion Students Routes
$route["academics/promotion"]["GET"] = "Academics/PromotionController/index";
$route["academics/promotion"]["POST"] = "Academics/PromotionController/promote";
$route["academics/edit-promotion"]["GET"] = "Academics/PromotionController/edit";
$route["academics/update-promotion"]["POST"] = "Academics/PromotionController/update";
// $route["masters/promotion"]["POST"] = "Master/WithdrawnReasonController/store";
// $route["masters/promotion/update/(:any)"]["POST"] = "Master/WithdrawnReasonController/update/$1";
// $route["masters/promotion/delete/(:any)"]["GET"] = "Master/WithdrawnReasonController/delete/$1";


// Fees Due Routes
$route["fees/fees-due/index"]["GET"] = "Fees/FeesController/fees_due_list";
$route["fees/fees-due/create"]["GET"] = "Fees/FeesController/fees_due_create";
$route["fees/fees-due/store"]["POST"] = "Fees/FeesController/fees_due_store";

// Fees Concession Routes
$route["fees/fees-concession/index"]["GET"] = "Fees/FeesController/fees_concession_list";
$route["fees/fees-concession/create"]["GET"] = "Fees/FeesController/fees_concession_create";
$route["fees/fees-concession/store"]["POST"] = "Fees/FeesController/fees_concession_store";
$route["fees/fees-concession/update"]["POST"] = "Fees/FeesController/fees_concession_update";

// Fees Concession Routes
$route["fees/school-fees/index"]["GET"]         = "Fees/FeesController/school_fees_list";
$route["fees/school-fees/create"]["GET"]        = "Fees/FeesController/school_fees_create";
$route["fees/school-fees/store"]["POST"]        = "Fees/FeesController/school_fees_store";
$route["fees/school-fees/edit"]["GET"]          = "Fees/FeesController/school_fees_edit";
$route["fees/school-fees/update"]["POST"]       = "Fees/FeesController/school_fees_update";
$route["fees/school-fees/delete/(:any)"]["GET"] = "Fees/FeesController/school_fees_delete/$1";

// Fees Collection Routes
$route["fees/fees-collection/index"]["GET"]         = "Fees/FeesController/fees_collection_list";
$route["fees/fees-collection/create"]["GET"]        = "Fees/FeesController/fees_collection_create";
$route["fees/fees-collection/store"]["POST"]        = "Fees/FeesController/fees_collection_store";
$route["fees/fees-collection/print"]["GET"]        = "Fees/FeesController/fees_collection_print";
$route["fees/fees-collection/delete"]["GET"]        = "Fees/FeesController/fees_collection_delete";


// ===============================
// Fees Reports Routes (All GET)
// ===============================
$route["fees/reports"]["GET"] = "Fees/FeesReportController/index";

// ===== School Fees Collection Reports =====
$route["fees/reports/fee-collection"]["GET"] = "Fees/FeesReportController/feeCollectionReport";
$route["fees/reports/fee-head-wise-collection"]["GET"] = "Fees/FeesReportController/feeHeadWiseCollectionReport";
$route["fees/reports/payment-wise-collection"]["GET"] = "Fees/FeesReportController/paymentWiseCollectionReport";
$route["fees/reports/personnel-wise-collection"]["GET"] = "Fees/FeesReportController/collectionPersonnelWiseCollectionReport";

// ===== Other Reports =====
$route["fees/reports/total-concession"]["GET"] = "Fees/FeesReportController/totalConcessionReport";
$route["fees/reports/concession-as-per-effectivity"]["GET"] = "Fees/FeesReportController/concessionAsPerEffectivityReport";

// ===== Payment & Outstanding Reports =====
$route["fees/reports/class-wise-monthly-collection"]["GET"] = "Fees/FeesReportController/classWiseMonthlyCollectionReport";
$route["fees/reports/class-wise-all-months-collection"]["GET"] = "Fees/FeesReportController/classWiseAllMonthsCollectionReport";
$route["fees/reports/class-wise-outstanding"]["GET"] = "Fees/FeesReportController/classWiseOutstandingReport";
$route["fees/reports/state-wise-outstanding"]["GET"] = "Fees/FeesReportController/stateWiseOutstandingReport";
$route["fees/reports/consolidated-outstanding"]["GET"] = "Fees/FeesReportController/consolidatedOutstandingReport";
$route["fees/reports/student-monthly-payment"]["GET"] = "Fees/FeesReportController/studentMonthlyPaymentReport";
$route["fees/reports/previous-year-outstanding"]["GET"] = "Fees/FeesReportController/previousYearOutstandingReport";
$route["fees/reports/students-monthly-payment"]["GET"] = "Fees/FeesReportController/studentMonthlyPaymentReport";


// Fees Setting
$route["fees/setting/create"]["GET"] = "Fees/FeesController/fees_setting_create";
$route["fees/setting/store"]["POST"] = "Fees/FeesController/fees_setting_store";


