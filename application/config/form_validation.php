<?php 

$config = array(
    "signin" => array(
        array(
            'field' => 'username',
            'label' => 'username',
            'rules' => 'trim|required',
            'errors' => array(
                "required" => "Enter your %s"
            )
        ),
        array(
            'field' => 'password',
            'label' => 'pssword',
            'rules' => 'trim|required',
            'errors' => array(
                "required" => "Enter your %s"
            )
        ),
        array(
            'field' => 'session',
            'label' => 'academy session',
            'rules' => 'trim|required',
            'errors' => array(
                "required" => "select %s"
            )
        )
    ),
    "session" => array(
        array(
            'field' => 'display_format',
            'label' => 'display format',
            'rules' => 'trim|required',
            'errors' => array(
                "required" => "Please select %s"
            )
        ),
        array(
            'field' => 'start',
            'label' => 'start from',
            'rules' => 'trim|required',
            'errors' => array(
                "required" => "Please select session %s"
            )
        ),
        array(
            'field' => 'end',
            'label' => 'end at',
            'rules' => 'trim|required',
            'errors' => array(
                "required" => "Please select session %s"
            )
        )
    ),
    "class" => array(
        array(
            'field' => 'class',
            'label' => 'class name',
            'rules' => 'trim|required',
        )
    ),
    "section" => array(
        array(
            'field' => 'section',
            'label' => 'section name',
            'rules' => 'trim|required',
        )
    ),
    "house" => array( 
        array(
            'field' => 'house',
            'label' => 'house name',
            'rules' => 'trim|required',
        )
    ),
    "student_type" => array( 
        array(
            'field' => 'student_type',
            'label' => 'student type',
            'rules' => 'trim|required',
        )
    ),
    "category" => array( 
        array(
            'field' => 'category',
            'label' => 'category name',
            'rules' => 'trim|required',
        )
    ),
    "religion" => array( 
        array(
            'field' => 'religion',
            'label' => 'religion name',
            'rules' => 'trim|required',
        )
    ),
    "state" => array( 
        array(
            'field' => 'state',
            'label' => 'state name',
            'rules' => 'trim|required',
        )
    ),
    "nationality" => array( 
        array(
            'field' => 'nationality',
            'label' => 'nationality name',
            'rules' => 'trim|required',
        )
    ),
    "department" => array( 
        array(
            'field' => 'department',
            'label' => 'department name',
            'rules' => 'trim|required',
        )
    ),
    "designation" => array( 
        array(
            'field' => 'designation',
            'label' => 'designation name',
            'rules' => 'trim|required',
        )
    ),
    "employee_type" => array( 
        array(
            'field' => 'employee_type',
            'label' => 'employee type',
            'rules' => 'trim|required',
        )
    ),
    "job_status" => array( 
        array(
            'field' => 'job_status',
            'label' => 'job status',
            'rules' => 'trim|required',
        )
    ),
    "subject" => array( 
        array(
            'field' => 'subject',
            'label' => 'subject name',
            'rules' => 'trim|required',
        )
    ),
    "subject_type" => array( 
        array(
            'field' => 'subject_type',
            'label' => 'subject type name',
            'rules' => 'trim|required',
        )
    ),
    "component" => array( 
        array(
            'field' => 'component',
            'label' => 'component name',
            'rules' => 'trim|required',
        )
    ),
    "exam_grade" => array( 
        array(
            'field' => 'exam_grade',
            'label' => 'exam grade',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'short_name',
            'label' => 'short name',
            'rules' => 'trim|required',
        ),
    ),
    "evolution_grade" => array( 
        array(
            'field' => 'evolution_grade',
            'label' => 'evolution grade',
            'rules' => 'trim|required',
        )
    ),
    "evolution_subject" => array( 
        array(
            'field' => 'evolution_subject',
            'label' => 'evolution subject',
            'rules' => 'trim|required',
        )
    ),
    "withdrawal_reason" => array( 
        array(
            'field' => 'withdrawal_reason',
            'label' => 'withdrawal reason',
            'rules' => 'trim|required',
        )
    ),
    "exam" => array( 
        array(
            'field' => 'exam',
            'label' => 'exam name',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'short_name',
            'label' => 'short name',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'component',
            'label' => 'component name',
            'rules' => 'trim|required',
        )
    ),
    "student" => array(
        array(
            'field' => 'student_no',
            'label' => 'student no',
            'rules' => 'trim|required|is_unique[students.student_no]',
            'errors' => array(
                "is_unique" => "Student No. is already exist"
            )
        ),
        array(
            'field' => 'roll_no',
            'label' => 'roll no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'admission_date',
            'label' => 'admission date',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'f_name',
            'label' => 'first name',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'class_of_admission',
            'label' => 'class of admission',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'm_name',
            'label' => 'middle name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'l_name',
            'label' => 'last name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'sex',
            'label' => 'sex',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'dob',
            'label' => 'DOB',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'blood_group',
            'label' => 'blood group',
            'rules' => 'trim',
        ),
        array(
            'field' => 'house_id',
            'label' => 'house',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'category_id',
            'label' => 'category',
            'rules' => 'trim|required',
         ),
        array(
            'field' => 'student_type_id',
            'label' => 'student type',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'religion_id',
            'label' => 'religion',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'nationality_id',
            'label' => 'nationality',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'state_id',
            'label' => 'state',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'medical_status',
            'label' => 'medical status',
            'rules' => 'trim',
        ),
        array(
            'field' => 'class_id',
            'label' => 'class',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'section_id',
            'label' => 'section',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'ssid',
            'label' => 'SSID',
            'rules' => 'trim',
        ),
        array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'email',
            'label' => 'email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'board_registration_no',
            'label' => 'board registration no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'aadhaar_no',
            'label' => 'AADHAAR no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_no',
            'label' => 'Passport no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_date_of_issue',
            'label' => 'Passport date of issue',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_valid_from',
            'label' => 'Passport valid from',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_valid_to',
            'label' => 'Passport valid to',
            'rules' => 'trim',
        ),
        array(
            'field' => 'status',
            'label' => 'status',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_name',
            'label' => 'father name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_name',
            'label' => 'mother name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_emp_no',
            'label' => 'father emp no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_emp_no',
            'label' => 'mother emp no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_school_stuff',
            'label' => 'father school stuff',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_school_stuff',
            'label' => 'mother school stuff',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_profession',
            'label' => 'father profession',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_profession',
            'label' => 'mother profession',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_education',
            'label' => 'father education',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_education',
            'label' => 'mother education',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_year_of_passing',
            'label' => 'father year of passing',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_year_of_passing',
            'label' => 'mother year of passing',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_board',
            'label' => 'father board',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_board',
            'label' => 'mother board',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_ex_student',
            'label' => 'father ex student',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_ex_student',
            'label' => 'mother ex student',
            'rules' => 'trim',
        ),

        array(
            'field' => 'father_mobile',
            'label' => 'father mobile',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_mobile',
            'label' => 'mother mobile',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_email',
            'label' => 'father email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_no',
            'label' => 'father passport no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_date_of_issue',
            'label' => 'father passport date of issue',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_valid_from',
            'label' => 'father passport valid from',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_valid_to',
            'label' => 'father passport valid to',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_email',
            'label' => 'mother email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_no',
            'label' => 'mother passport no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_date_of_issue',
            'label' => 'mother passport date of issue',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_valid_from',
            'label' => 'mother passport valid from',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_valid_to',
            'label' => 'mother passport valid to',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_address',
            'label' => 'local address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'permanent_address',
            'label' => 'permanent address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_phone',
            'label' => 'local phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'permanent_phone',
            'label' => 'permanent phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_name',
            'label' => 'local gurdian name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_mobile',
            'label' => 'local gurdian mobile',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_address',
            'label' => 'local gurdian address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_email',
            'label' => 'local gurdian email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_name',
            'label' => 'previous school name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_address',
            'label' => 'previous school address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_phone',
            'label' => 'previous school phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_last_class_attend',
            'label' => 'previous school last class attend',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_year_of_leaving',
            'label' => 'previous school year of leaving',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_remarks',
            'label' => 'previous school remarks',
            'rules' => 'trim',
        ),
    ),
    "student_edit" => array(
        array(
            'field' => 'student_no',
            'label' => 'student no',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'roll_no',
            'label' => 'roll no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'admission_date',
            'label' => 'admission date',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'f_name',
            'label' => 'first name',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'm_name',
            'label' => 'middle name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'l_name',
            'label' => 'last name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'sex',
            'label' => 'sex',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'dob',
            'label' => 'DOB',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'blood_group',
            'label' => 'blood group',
            'rules' => 'trim',
        ),
        array(
            'field' => 'house_id',
            'label' => 'house',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'category_id',
            'label' => 'category',
            'rules' => 'trim|required',
         ),
        array(
            'field' => 'student_type_id',
            'label' => 'student type',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'religion_id',
            'label' => 'religion',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'nationality_id',
            'label' => 'nationality',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'state_id',
            'label' => 'state',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'medical_status',
            'label' => 'medical status',
            'rules' => 'trim',
        ),
        array(
            'field' => 'class_id',
            'label' => 'class',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'section_id',
            'label' => 'section',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'ssid',
            'label' => 'SSID',
            'rules' => 'trim',
        ),
        array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'email',
            'label' => 'email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'board_registration_no',
            'label' => 'board registration no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'aadhaar_no',
            'label' => 'AADHAAR no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_no',
            'label' => 'Passport no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_date_of_issue',
            'label' => 'Passport date of issue',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_valid_from',
            'label' => 'Passport valid from',
            'rules' => 'trim',
        ),
        array(
            'field' => 'passport_valid_to',
            'label' => 'Passport valid to',
            'rules' => 'trim',
        ),
        array(
            'field' => 'status',
            'label' => 'status',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_name',
            'label' => 'father name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_name',
            'label' => 'mother name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_emp_no',
            'label' => 'father emp no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_emp_no',
            'label' => 'mother emp no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_school_stuff',
            'label' => 'father school stuff',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_school_stuff',
            'label' => 'mother school stuff',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_profession',
            'label' => 'father profession',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_profession',
            'label' => 'mother profession',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_education',
            'label' => 'father education',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_education',
            'label' => 'mother education',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_year_of_passing',
            'label' => 'father year of passing',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_year_of_passing',
            'label' => 'mother year of passing',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_board',
            'label' => 'father board',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_board',
            'label' => 'mother board',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_ex_student',
            'label' => 'father ex student',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_ex_student',
            'label' => 'mother ex student',
            'rules' => 'trim',
        ),

        array(
            'field' => 'father_mobile',
            'label' => 'father mobile',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_mobile',
            'label' => 'mother mobile',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_email',
            'label' => 'father email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_no',
            'label' => 'father passport no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_date_of_issue',
            'label' => 'father passport date of issue',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_valid_from',
            'label' => 'father passport valid from',
            'rules' => 'trim',
        ),
        array(
            'field' => 'father_passport_valid_to',
            'label' => 'father passport valid to',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_email',
            'label' => 'mother email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_no',
            'label' => 'mother passport no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_date_of_issue',
            'label' => 'mother passport date of issue',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_valid_from',
            'label' => 'mother passport valid from',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother_passport_valid_to',
            'label' => 'mother passport valid to',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_address',
            'label' => 'local address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'permanent_address',
            'label' => 'permanent address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_phone',
            'label' => 'local phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'permanent_phone',
            'label' => 'permanent phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_name',
            'label' => 'local gurdian name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_mobile',
            'label' => 'local gurdian mobile',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_address',
            'label' => 'local gurdian address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_gurdian_email',
            'label' => 'local gurdian email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_name',
            'label' => 'previous school name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_address',
            'label' => 'previous school address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_phone',
            'label' => 'previous school phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_last_class_attend',
            'label' => 'previous school last class attend',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_year_of_leaving',
            'label' => 'previous school year of leaving',
            'rules' => 'trim',
        ),
        array(
            'field' => 'previous_school_remarks',
            'label' => 'previous school remarks',
            'rules' => 'trim',
        ),
    ),
    "employee" => array(
        array(
            'field' => 'f_name',
            'label' => 'first name',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'm_name',
            'label' => 'middle name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'l_name',
            'label' => 'last name',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'emp_code',
            'label' => 'employee code',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'sex',
            'label' => 'sex',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'dob',
            'label' => 'date of birth',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'since',
            'label' => 'since',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'emp_type_id',
            'label' => 'employee type',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'department_id',
            'label' => 'department',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'designation_id',
            'label' => 'designation',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'job_status_id',
            'label' => 'job status',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'mobile_no',
            'label' => 'mobile phone',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'email',
            'label' => 'email address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'category_id',
            'label' => 'category',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'father',
            'label' => 'father name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mother',
            'label' => 'mother name',
            'rules' => 'trim',
        ),
        array(
            'field' => 'marital_status',
            'label' => 'marital status',
            'rules' => 'trim',
        ),
        array(
            'field' => 'spouse',
            'label' => 'spouse',
            'rules' => 'trim',
        ),
        array(
            'field' => 'religion_id',
            'label' => 'religion',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'nationality_id',
            'label' => 'nationality',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'pan_no',
            'label' => 'pan no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'voter_id',
            'label' => 'voter id',
            'rules' => 'trim',
        ),
        array(
            'field' => 'aadhar_no',
            'label' => 'aadhar no',
            'rules' => 'trim',
        ),
        array(
            'field' => 'status',
            'label' => 'status',
            'rules' => 'trim',
        ),
        array(
            'field' => 'miscellaneous',
            'label' => 'miscellaneous',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_address',
            'label' => 'local address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'local_phone',
            'label' => 'local phone',
            'rules' => 'trim',
        ),
        array(
            'field' => 'permanent_address',
            'label' => 'permanent address',
            'rules' => 'trim',
        ),
        array(
            'field' => 'permanent_phone',
            'label' => 'permanent phone',
            'rules' => 'trim',
        ),
    ),
    "permissions" => array(
        array(
            'field' => 'employee_id',
            'label' => 'employee',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'username',
            'label' => 'employee',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'student_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'academics_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'fees_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'hostel_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'personnel_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'leave_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'payroll_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'library_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'inventory_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'mess_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'infirmary_module',
            'label' => 'user',
            'rules' => 'trim',
        ),
        array(
            'field' => 'system_administrator',
            'label' => 'user',
            'rules' => 'trim',
        ),
    )
);