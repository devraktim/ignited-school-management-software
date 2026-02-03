<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Student extends CI_Model {

        private $table = "students";

        public function get($id = NULL) {
            if($id) {
                $record = $this->db->select("
                    students.*, 
                    student_session.session_id as session_id,
                    classes.name as class, 
                    sections.name as section, 
                    student_types.name as student_type, 
                    houses.name as house, 
                    categories.name as category, 
                    states.name as state, 
                    nationalities.name as nationality, 
                    religions.name as religion,
                    c.name as student_class_of_admission_name, 
                    student_session.session_id as student_session_session_id, 
                    student_session.class_id as student_session_class_id, 
                    sc.name as student_session_class_name, 
                    student_session.section_id as student_session_section_id"
                )
                ->from($this->table)
                ->join("student_session", "students.id = student_session.student_id")
                ->join("classes", "students.class_id = classes.id")
                ->join("classes as c", "students.class_of_admission = c.id")
                ->join("classes as sc", "student_session.class_id = sc.id")
                ->join("sections", "students.section_id = sections.id")
                ->join("student_types", "students.student_type_id = student_types.id")
                ->join("houses", "students.house_id = houses.id")
                ->join("categories", "students.category_id = categories.id")
                ->join("states", "students.state_id = states.id")
                ->join("nationalities", "students.nationality_id = nationalities.id")
                ->join("religions", "students.religion_id = religions.id")
                ->where(["students.id" => $id, "student_session.session_id" => $this->session->academy_session['current_session']['id'], "students.deleted" => 0])
                ->get()
                ->row_array();
                
                $record["class_id"] = $record["student_session_class_id"]; 
                $record["section_id"] = $record["student_session_section_id"]; 
                $record["session_id"] = $record["student_session_session_id"];
                
                $student_name_display_format = $this->db->from("settings")->where("key_name", "student_name_display_format")->get()->row_array();
                
                if($student_name_display_format['value'] == "l_f_m") {
                    $records[$i]["f_name"] = $l_name;
                    $records[$i]["m_name"] = $f_name;
                    $records[$i]["l_name"] = $m_name;
                }
                elseif($student_name_display_format['value'] == "l_m_f") {
                    $records[$i]["f_name"] = $l_name;
                    $records[$i]["m_name"] = $m_name;
                    $records[$i]["l_name"] = $f_name;
                }
            
                
                
                return $record;
            }
            else {
                $records = $this->db
                            ->select(
                                "students.*",
                                "student_session.session_id as session_id,
                                student_session.session_id as student_session_session_id, 
                                student_session.class_id as student_session_class_id, 
                                student_session.section_id as student_session_section_id"
                            )
                            ->from($this->table)
                            ->join("student_session", "student_session.student_id = students.id")
                            ->where(["students.deleted" => 0, "student_session.session_id" => $this->session->academy_session['current_session']['id']])->get()->result_array();
            
                for($i = 0; $i < count($records) ; $i++) {
                    $records[$i]["class_id"] = $records[$i]["student_session_class_id"];
                    $records[$i]["section_id"] = $records[$i]["student_session_section_id"];
                    $records[$i]["session_id"] = $records[$i]["student_session_session_id"];
                }
                
                $f_name = $records["f_name"];
                $m_name = $records["m_name"];
                $l_name = $records["l_name"];
                
         
                return $records;
            }
        }

        public function get_where($clauses) {
            // $clauses["students.deleted"] = 0;
            // $clauses["student_session.session_id"] = $this->session->academy_session['current_session']['id'];
         
         
            // Check if 'students.deleted' is not set or is empty
            if (!isset($clauses["students.deleted"]) || empty($clauses["students.deleted"])) {
                $clauses["students.deleted"] = 0;
            }
            
            // Check if 'student_session.session_id' is not set or is empty
            if (!isset($clauses["student_session.session_id"]) || empty($clauses["student_session.session_id"])) {
                $clauses["student_session.session_id"] = $this->session->academy_session['current_session']['id'];
            }


            // Promoted
            if(!array_key_exists('student_session.promoted', $clauses)) {
                $clauses["student_session.promoted"] = 0;
            }
            else if(array_key_exists('student_session.promoted', $clauses)) {
                if($clauses['student_session.promoted'] === "ANY")
                {
                    unset($clauses['student_session.promoted']);
                }
            }
            
            // Withdraw
            if (!array_key_exists('student_session.withdraw', $clauses)) {
                $clauses["student_session.withdraw"] = 0;
            }
            else if(array_key_exists('student_session.withdraw', $clauses)) {
                if($clauses['student_session.withdraw'] === "ANY")
                {
                    unset($clauses['student_session.withdraw']);
                }
            }
            
            // Passout
            if (!array_key_exists('student_session.passout', $clauses)) {
                $clauses["student_session.passout"] = 0;
            }
            else if(array_key_exists('student_session.passout', $clauses)) {
                if($clauses['student_session.passout'] === "ANY")
                {
                    unset($clauses['student_session.passout']);
                }
            }
            
            if (array_key_exists('class_id', $clauses)) {
                $clauses['student_session.class_id'] = $clauses['class_id'];
                unset($clauses['class_id']);
            }
            
            if (array_key_exists('section_id', $clauses)) {
                $clauses['student_session.section_id'] = $clauses['section_id'];
                unset($clauses['section_id']);
            }
            
            $student_session_new_session_id = "";
            
            if (array_key_exists('student_session.new_session_id', $clauses)) {
                $student_session_new_session_id = $clauses["student_session.new_session_id"];
                unset($clauses['student_session.new_session_id']);
            }
            
            $transformed = array();
            
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                    $transformed[$newKey] = $value;
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                    $transformed[$newKey] = $value;
                } else {
                    $transformed[$key] = $value;
                }
                
            }
            
            $sort_by = $this->db->from("settings")->where("key_name", "student_sort_by")->get()->row_array();
            $student_name_display_format = $this->db->from("settings")->where("key_name", "student_name_display_format")->get()->row_array();
            
            // $records = $this->db
            //             ->select(
            //                 "students.*, 
            //                 student_session.session_id as student_session_session_id, 
            //                 student_session.class_id as student_session_class_id, 
            //                 student_session.section_id as student_session_section_id"
            //             )
            //             ->from($this->table)
            //             ->join("student_session", "student_session.student_id = students.id")
            //             ->where($transformed);
            
            $records = $this->db
                            ->select(
                                "students.*, 
                                student_session.session_id as student_session_session_id, 
                                student_session.class_id as student_session_class_id, 
                                student_session.section_id as student_session_section_id, 
                                houses.name as house_name, 
                                categories.name as category_name, 
                                student_types.name as student_type_name, 
                                religions.name as religion_name, 
                                nationalities.name as nationality_name, 
                                states.name as state_name"
                            )
                            ->from($this->table)
                            ->join("student_session", "student_session.student_id = students.id", "left")
                            ->join("houses", "houses.id = students.house_id", "left")
                            ->join("categories", "categories.id = students.category_id", "left")
                            ->join("student_types", "student_types.id = students.student_type_id", "left")
                            ->join("religions", "religions.id = students.religion_id", "left")
                            ->join("nationalities", "nationalities.id = students.nationality_id", "left")
                            ->join("states", "states.id = students.state_id", "left")
                            ->where($transformed);
                            
            if($sort_by['value'] == "student_no") {
                $records = $records->order_by('students.student_no', 'ASC');
            }
            elseif($sort_by['value'] == "first_name") {
               $records = $records->order_by('students.f_name', 'ASC');
            } 
            elseif($sort_by['value'] == "last_name") {
               $records = $records->order_by('students.l_name', 'ASC');
            } 
            elseif($sort_by['value'] == "day_scholar") {
                // Adjust the order by to prioritize student_type_id = 1, then student_type_id = 3
                $records = $records->order_by('students.student_type_id', 'ASC');
            } 
            elseif($sort_by['value'] == "boarders") {
                // Adjust the order by to prioritize student_type_id = 3, then student_type_id = 1
                $records = $records->order_by('students.student_type_id', 'DESC');
            } 
            else {}
            
            $records = $records->get()->result_array();

            if($student_session_new_session_id != "") {
                
                $data = [];
                
                foreach($records as $record) {
                    
                    $row = $this->db->from("student_session")
                                    ->where("student_session.session_id", ($student_session_new_session_id - 1))
                                    ->where("student_session.student_id", $record['id'])
                                    ->get()
                                    ->row_array();
                                    
                    if (empty($row)) {
                        $data[] = $record;
                    }
                    
                }
            
                $records = $data;
            }
            

            for($i = 0; $i < count($records) ; $i++) {
                $records[$i]["class_id"] = $records[$i]["student_session_class_id"];
                $records[$i]["section_id"] = $records[$i]["student_session_section_id"];
                $records[$i]["session_id"] = $records[$i]["student_session_session_id"];
                
                $f_name = $records[$i]["f_name"];
                $m_name = $records[$i]["m_name"];
                $l_name = $records[$i]["l_name"];
                
                if($student_name_display_format['value'] == "l_f_m") {
                    $records[$i]["f_name"] = $l_name;
                    $records[$i]["m_name"] = $f_name;
                    $records[$i]["l_name"] = $m_name;
                }
                elseif($student_name_display_format['value'] == "l_m_f") {
                    $records[$i]["f_name"] = $l_name;
                    $records[$i]["m_name"] = $m_name;
                    $records[$i]["l_name"] = $f_name;
                }
                else {}
            }

            return $records;
        }

        public function search($parameteres) {
            $parameteres["deleted"] = 0;
            $parameteres["student_session.session_id"] = $this->session->academy_session['current_session']['id'];
            
            $f_name = "";
            
            if(in_array("f_name", $parameteres)) {
                $f_name = $parameteres['f_name'];
                unset($parameteres['f_name']);
            }
            
            // $students = $this->db
            //                 ->select(
            //                     "students.*,
            //                     student_session.session_id as student_session_session_id, 
            //                     student_session.class_id as student_session_class_id, 
            //                     student_session.section_id as student_session_section_id"
            //                 )
            //                 ->from($this->table)
            //                 ->join("student_session", "student_session.student_id = students.id")
            //                 ->where($parameteres)
            //                 ->get()
            //                 ->result_array();
            
            $students = $this->db
                ->select(
                    "students.*,
                    student_session.session_id as student_session_session_id, 
                    student_session.class_id as student_session_class_id, 
                    student_session.section_id as student_session_section_id"
                )
                ->from($this->table)
                ->join("student_session", "student_session.student_id = students.id");
            
            // Check if $f_name is not empty
            if (!empty($f_name)) {
                $this->db->like('students.f_name', $f_name, 'after'); 
            }
            
            $students = $this->db
                ->where($parameteres) // Maintain existing parameters
                ->get()
                ->result_array();

            for($i = 0 ; $i < count($students) ; $i++) {
                $students[$i]               = $this->get($students[$i]["id"]);
                $students[$i]["class_id"]   = $students[$i]["student_session_class_id"];
                $students[$i]["section_id"] = $students[$i]["student_session_section_id"];
                $students[$i]["session_id"] = $students[$i]["student_session_session_id"];
            }

            return $students;
        }
        
        public function is_student_no_exist($student_no) {
            $this->db->from('students');
            $this->db->where('student_no', $student_no);
            $query = $this->db->get();
    
            return $query->num_rows() > 0;
        }


        public function get_the_last_insert_id() {
            $record = $this->db->order_by("id", "DESC")->get($this->table)->row_array();
            
            $number_of_digits = strlen($record['student_no']);
            $student_no = (int)$record['student_no'] + 1;
            $next_student_no = sprintf('%0'.$number_of_digits.'d',$student_no);
            return $next_student_no;
        }

        public function insert($data) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

        public function update($id, $data) {
            $this->db->where(["id" => $id, "deleted" => 0])->update($this->table, $data);
            
            $this->db->where([
                "student_id" => $id,
                "session_id" => $this->session->academy_session['current_session']['id']
            ])->update("student_session", ["class_id" => $data["class_id"], "section_id" => $data["section_id"]]);
        }

        public function update_batch($data, $student_session_data) {
            $this->db->update_batch($this->table, $data, "id");
            
            foreach($student_session_data as $student) {
                $this->db->where(['student_id' => $student['id'], 'class_id' => $student['class_id'], 'session_id' => $student['session_id']])->update("student_session", ['section_id' => $student['section_id']]);
            }
        }

        public function create_student_academy_session($data) {
            return $this->db->insert("student_session", $data);
        }
        
        public function create_student_academy_session_batch_inserts($data) {
            return $this->db->insert_batch("student_session", $data);
        }
        
        public function update_student_academy_session_batch($data) {
            return $this->db->update_batch("student_session", $data, "student_id");
        }
        
        public function passout_student_academy_session_batch($data) {
            foreach($data as $d) {
                return $this->db->where($d)->update("student_session", ["passout" => 1]); 
            }
        }
        
        public function back_students_to_last_session($data) {
            $current_session_id = $this->session->academy_session['current_session']['id'];
            
            foreach ($data as $d) {
                $this->db->where("student_id", $d)->where("session_id", $current_session_id);
                $this->db->delete("student_session");
                
                $this->db->where(["student_id" => $d, "session_id" => 1])->update("student_session", ["promoted" => 0]);
            }
            
            return;
        }
        
        public function get_passout_student_date($data) {
            return $this->db->from("passout_students")->where($data)->get()->result_array();
        }
        
        public function store_passout_student_date($data) {
            
            $is_saved = $this->db->where([
                "class_id" => $data["class_id"],
                "section_id" => $data["section_id"],
                "session_id" => $data["session_id"],
                "student_id" => $data["student_id"],
            ])->get("passout_students")->result();
            
            if($is_saved) {
                return $this->db->where([
                    "class_id" => $data["class_id"],
                    "section_id" => $data["section_id"],
                    "session_id" => $data["session_id"],
                    "student_id" => $data["student_id"],
                ])->update("passout_students", ["tc_no" => $data["tc_no"], "tc_date" => $data["tc_date"], "date_of_leaving" => $data["date_of_leaving"]]);
            }
            else {
                return $this->db->insert("passout_students", $data);
            }
        }
        
        public function delete($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 1]);
        }

        public function restore($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 0]);
        }
        
        // public function class_wise_breakup() {
        //     // Get all distinct class and section combinations
        //     $distinct_combinations_query = $this->db->query('
        //         SELECT DISTINCT c.id AS class_id, c.name AS class_name, s.id AS section_id, s.name AS section_name
        //         FROM classes c
        //         CROSS JOIN sections s
        //     ');
    
        //     $distinct_combinations = $distinct_combinations_query->result_array();
    
        //     // Fetch student counts for each class and section combination
        //     $session_id = $this->session->academy_session['current_session']['id'];
        //     $student_counts_query = $this->db->query("
        //         SELECT c.id AS class_id, c.name AS class_name, s.id AS section_id, s.name AS section_name, COUNT(DISTINCT ss.student_id) AS num_students
        //         FROM classes c
        //         CROSS JOIN sections s
        //         LEFT JOIN student_session ss ON c.id = ss.class_id AND s.id = ss.section_id AND ss.session_id = $session_id
        //         GROUP BY c.id, s.id
        //     ");
    
        //     $student_counts = $student_counts_query->result_array();
    
        //     // Create an associative array to hold class details and student counts
        //     $class_student_details = [];
        //     foreach ($distinct_combinations as $combination) {
        //         $class_id = $combination['class_id'];
        //         $section_id = $combination['section_id'];
        //         $class_name = $combination['class_name'];
        //         $section_name = $combination['section_name'];
    
        //         // Initialize student count to 0
        //         $num_students = 0;
    
        //         // Find student count if available
        //         foreach ($student_counts as $count) {
        //             if ($count['class_id'] == $class_id && $count['section_id'] == $section_id) {
        //                 $num_students = $count['num_students'];
        //                 break;
        //             }
        //         }
    
        //         // Update class details
        //         if (!isset($class_student_details[$class_id])) {
        //             $class_student_details[$class_id] = [
        //                 'class_name' => $class_name,
        //                 'total_students' => 0,
        //                 'sections' => []
        //             ];
        //         }
    
        //         // Update section details
        //         $class_student_details[$class_id]['sections'][$section_name] = $num_students;
        //         $class_student_details[$class_id]['total_students'] += $num_students;
        //     }
    
        //     // Convert associative array to required format
        //     $result = [];
        //     foreach ($class_student_details as $class_id => $class_details) {
        //         $class_result = [
        //             'class_name' => $class_details['class_name']
        //         ];
    
        //         foreach ($class_details['sections'] as $section_name => $num_students) {
        //             $class_result[$section_name] = $num_students;
        //         }
    
        //         $class_result['total_students'] = $class_details['total_students'];
    
        //         $result[] = $class_result;
        //     }
    
        //     return $result;
        // }
        
        public function breakup_class($clauses) {
            // Fetch the section names dynamically
            $this->db->select('name');
            $this->db->from('sections');
            
            if (array_key_exists("ss.section_id", $clauses)) {
                $this->db->where("id", $clauses['ss.section_id']);
            }
            
            $query_sections = $this->db->get();
            $sections = $query_sections->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($sections as $section) {
                $section_name = $section['name'];
                $escaped_section_name = str_replace(" ", "_", $section_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN sec.name = '$section_name' THEN 1 ELSE 0 END) as $escaped_section_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('sections sec', 'ss.section_id = sec.id', 'left');
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if (isset($clauses["ss.class_id"])) {
                $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if (isset($clauses["ss.section_id"])) {
                $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if (isset($clauses["s.student_type_id"])) {
                $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if (isset($clauses["s.house_id"])) {
                $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if (isset($clauses["sex"])) {
                $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if (isset($clauses["medical_status"])) {
                $this->db->where('s.medical_status', $clauses["medical_status"]);
            }
            
            if (isset($clauses["s.religion_id"])) {
                $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if (isset($clauses["s.nationality_id"])) {
                $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if (isset($clauses["s.state_id"])) {
                $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();
                
            // echo "<pre>";
            // print_r($result);
            // echo "</pre>";
            // exit();
            return $result;
        }
        
        public function breakup_student_type($clauses)
        {

            // Fetch the student type names dynamically
            $this->db->select('name');
            $this->db->from('student_types');
            
            if(array_key_exists("s.student_type_id", $clauses)) {
                $this->db->where("id", $clauses['s.student_type_id']);
            }
            
            $query_student_types = $this->db->get();
            $student_types = $query_student_types->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($student_types as $student_type) {
                $student_type_name = $student_type['name'];
                $escaped_student_type_name = str_replace(" ", "_", $student_type_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN st.name = '$student_type_name' THEN 1 ELSE 0 END) as $escaped_student_type_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('student_types st', 's.student_type_id = st.id', 'left');
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if(isset($clauses["ss.class_id"])) {
               $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if(isset($clauses["ss.section_id"])) {
               $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if(isset($clauses["s.student_type_id"])) {
               $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if(isset($clauses["s.house_id"])) {
               $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if(isset($clauses["sex"])) {
               $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if(isset($clauses["medical_status"])) {
               $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            
            if(isset($clauses["s.religion_id"])) {
               $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if(isset($clauses["s.nationality_id"])) {
               $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if(isset($clauses["s.state_id"])) {
               $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();
            
            return $result;
        }
        
        public function breakup_house($clauses)
        {
            // Fetch the house names dynamically
            $this->db->select('name');
            $this->db->from('houses');
            
            if(array_key_exists("s.house_id", $clauses)) {
                $this->db->where("id", $clauses['s.house_id']);
            }
            
            $query_house_names = $this->db->get();
            $house_names = $query_house_names->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($house_names as $house) {
                $house_name = $house['name'];
                $escaped_house_name = str_replace(" ", "_", $house_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN st.name = '$house_name' THEN 1 ELSE 0 END) as $escaped_house_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('houses st', 's.house_id = st.id', 'left');
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if(isset($clauses["ss.class_id"])) {
               $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if(isset($clauses["ss.section_id"])) {
               $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if(isset($clauses["s.student_type_id"])) {
               $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if(isset($clauses["s.house_id"])) {
               $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if(isset($clauses["sex"])) {
               $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if(isset($clauses["medical_status"])) {
               $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            
            if(isset($clauses["s.religion_id"])) {
               $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if(isset($clauses["s.nationality_id"])) {
               $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if(isset($clauses["s.state_id"])) {
               $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();
            
            return $result;
        }
        
        public function breakup_category($clauses)
        {
            // Fetch the category names dynamically
            $this->db->select('name');
            $this->db->from('categories'); // Changed table name from 'houses' to 'categories'
            
            if(array_key_exists("s.category_id", $clauses)) {
                $this->db->where("id", $clauses['s.category_id']);
            }
            
            $query_category_names = $this->db->get();
            $category_names = $query_category_names->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($category_names as $category) {
                $category_name = $category['name'];
                $escaped_category_name = str_replace(" ", "_", $category_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN st.name = '$category_name' THEN 1 ELSE 0 END) as $escaped_category_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('categories st', 's.category_id = st.id', 'left'); // Changed join table name from 'houses' to 'categories'
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if(isset($clauses["ss.class_id"])) {
               $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if(isset($clauses["ss.section_id"])) {
               $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if(isset($clauses["s.student_type_id"])) {
               $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if(isset($clauses["s.house_id"])) {
               $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if(isset($clauses["sex"])) {
               $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if(isset($clauses["medical_status"])) {
               $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            
            if(isset($clauses["s.religion_id"])) {
               $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if(isset($clauses["s.nationality_id"])) {
               $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if(isset($clauses["s.state_id"])) {
               $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();
        
            return $result;
        }
        
        public function breakup_religion($clauses)
        {
            // Fetch the religion names dynamically
            $this->db->select('name');
            $this->db->from('religions'); // Changed table name from 'categories' to 'religions'
            
            if(array_key_exists("s.religion_id", $clauses)) {
                $this->db->where("id", $clauses['s.religion_id']);
            }
            
            $query_religion_names = $this->db->get();
            $religion_names = $query_religion_names->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($religion_names as $religion) {
                $religion_name = $religion['name'];
                $escaped_religion_name = str_replace(" ", "_", $religion_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN st.name = '$religion_name' THEN 1 ELSE 0 END) as $escaped_religion_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('religions st', 's.religion_id = st.id', 'left'); // Changed join table name from 'categories' to 'religions'
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if(isset($clauses["ss.class_id"])) {
               $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if(isset($clauses["ss.section_id"])) {
               $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if(isset($clauses["s.student_type_id"])) {
               $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if(isset($clauses["s.house_id"])) {
               $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if(isset($clauses["sex"])) {
               $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if(isset($clauses["medical_status"])) {
               $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            
            if(isset($clauses["s.religion_id"])) {
               $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if(isset($clauses["s.nationality_id"])) {
               $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if(isset($clauses["s.state_id"])) {
               $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();
            
            return $result;
        }
        
        public function breakup_state($clauses)
        {
            // Fetch the state names dynamically
            $this->db->select('name');
            $this->db->from('states'); // Changed table name from 'religions' to 'states'
            
            if(array_key_exists("s.state_id", $clauses)) {
                $this->db->where("id", $clauses['s.state_id']);
            }
            
            $query_state_names = $this->db->get();
            $state_names = $query_state_names->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($state_names as $state) {
                $state_name = $state['name'];
                $escaped_state_name = str_replace(" ", "_", $state_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN st.name = '$state_name' THEN 1 ELSE 0 END) as $escaped_state_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('states st', 's.state_id = st.id', 'left'); // Changed join table name from 'religions' to 'states'
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if(isset($clauses["ss.class_id"])) {
               $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if(isset($clauses["ss.section_id"])) {
               $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if(isset($clauses["s.student_type_id"])) {
               $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if(isset($clauses["s.house_id"])) {
               $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if(isset($clauses["sex"])) {
               $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if(isset($clauses["medical_status"])) {
               $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            
            if(isset($clauses["s.religion_id"])) {
               $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if(isset($clauses["s.nationality_id"])) {
               $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if(isset($clauses["s.state_id"])) {
               $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();
            
            return $result;
        }
        
        public function breakup_nationality($clauses)
        {
            // Fetch the nationality names dynamically
            $this->db->select('name');
            $this->db->from('nationalities'); // Changed table name from 'states' to 'nationalities'
            
            if(array_key_exists("s.nationality_id", $clauses)) {
                $this->db->where("id", $clauses['s.nationality_id']);
            }
            
            $query_nationality_names = $this->db->get();
            $nationality_names = $query_nationality_names->result_array();
            
            // Construct the query dynamically
            $this->db->select('c.name as class_name');
            foreach ($nationality_names as $nationality) {
                $nationality_name = $nationality['name'];
                $escaped_nationality_name = str_replace(" ", "_", $nationality_name); // Replace spaces with underscores
                $this->db->select("SUM(CASE WHEN st.name = '$nationality_name' THEN 1 ELSE 0 END) as $escaped_nationality_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->join('nationalities st', 's.nationality_id = st.id', 'left'); // Changed join table name from 'states' to 'nationalities'
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            $this->db->where('ss.withdraw', 0);
            $this->db->where('ss.passout', 0);
            $this->db->where('s.deleted', 0);
            
            if(isset($clauses["ss.class_id"])) {
               $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            
            if(isset($clauses["ss.section_id"])) {
               $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            
            if(isset($clauses["s.student_type_id"])) {
               $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            
            if(isset($clauses["s.house_id"])) {
               $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            
            if(isset($clauses["sex"])) {
               $this->db->where('s.sex', $clauses["sex"]);
            }
            
            if(isset($clauses["medical_status"])) {
               $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            
            if(isset($clauses["s.religion_id"])) {
               $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            
            if(isset($clauses["s.nationality_id"])) {
               $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            
            if(isset($clauses["s.state_id"])) {
               $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
            
            $this->db->group_by('c.id');
            $query = $this->db->get();
            
            $result = $query->result_array();

            return $result;
        }
        
        // public function breakup_sex()
        // {
        //     $data = [];
        //     $classes = ["UKG", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
            
        //     for ($i = 0; $i < count($classes); $i++) {
                
        //         $males = $this->db->select('COUNT(*) as count')
        //             ->from('student_session')
        //             ->join('students', 'students.id = student_session.student_id')
        //             ->where('students.sex', 'male')
        //             ->where('student_session.class_id', 1 + $i)
        //             ->get()
        //             ->row()
        //             ->count;
                
        //         $females = $this->db->select('COUNT(*) as count')
        //             ->from('student_session')
        //             ->join('students', 'students.id = student_session.student_id')
        //             ->where('students.sex', 'female')
        //             ->where('student_session.class_id', 1 + $i)
        //             ->get()
        //             ->row()
        //             ->count;
        
        //         $data[] = [
        //             "class_name"    => $classes[$i],
        //             "Male"          => $males,
        //             "Female"        => $females,
        //             "total_students"=> $males + $females
        //         ];
        //     }
            
        //     return $data;
        // }
        
        public function breakup_sex($clauses)
        {
            // Fetch the class names dynamically
            $this->db->select('c.name as class_name');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            // Apply additional filters based on clauses
            if(isset($clauses["ss.class_id"])) {
                $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            if(isset($clauses["ss.section_id"])) {
                $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            if(isset($clauses["s.student_type_id"])) {
                $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            if(isset($clauses["s.house_id"])) {
                $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            if(isset($clauses["s.sex"])) {
                $this->db->where('s.sex', $clauses["s.sex"]);
            }
            if(isset($clauses["s.medical_status"])) {
                $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            if(isset($clauses["s.religion_id"])) {
                $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            if(isset($clauses["s.nationality_id"])) {
                $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            if(isset($clauses["s.state_id"])) {
                $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
        
            $this->db->group_by('c.id');
            $query_classes = $this->db->get();
            $classes = $query_classes->result_array();
        
            // Construct the query dynamically to get counts of males and females
            $this->db->select('c.name as class_name');
            foreach ($classes as $class) {
                $class_name = $class['class_name'];
                $escaped_class_name = str_replace(" ", "_", $class_name); // Replace spaces with underscores
                
                // Count males
                $this->db->select("SUM(CASE WHEN s.sex = 'male' THEN 1 ELSE 0 END) as males_$escaped_class_name", false);
                
                // Count females
                $this->db->select("SUM(CASE WHEN s.sex = 'female' THEN 1 ELSE 0 END) as females_$escaped_class_name", false);
            }
            $this->db->select('COALESCE(COUNT(s.id), 0) as total_students');
            $this->db->from('classes c');
            $this->db->join('student_session ss', 'ss.class_id = c.id', 'left');
            $this->db->join('students s', 'ss.student_id = s.id', 'left');
            $this->db->where('ss.session_id', $this->session->academy_session['current_session']['id']);
            
            // Apply additional filters based on clauses
            if(isset($clauses["ss.class_id"])) {
                $this->db->where('ss.class_id', $clauses["ss.class_id"]);
            }
            if(isset($clauses["ss.section_id"])) {
                $this->db->where('ss.section_id', $clauses["ss.section_id"]);
            }
            if(isset($clauses["s.student_type_id"])) {
                $this->db->where('s.student_type_id', $clauses["s.student_type_id"]);
            }
            if(isset($clauses["s.house_id"])) {
                $this->db->where('s.house_id', $clauses["s.house_id"]);
            }
            if(isset($clauses["s.sex"])) {
                $this->db->where('s.sex', $clauses["s.sex"]);
            }
            if(isset($clauses["s.medical_status"])) {
                $this->db->where('s.medical_status', $clauses["s.medical_status"]);
            }
            if(isset($clauses["s.religion_id"])) {
                $this->db->where('s.religion_id', $clauses["s.religion_id"]);
            }
            if(isset($clauses["s.nationality_id"])) {
                $this->db->where('s.nationality_id', $clauses["s.nationality_id"]);
            }
            if(isset($clauses["s.state_id"])) {
                $this->db->where('s.state_id', $clauses["s.state_id"]);
            }
        
            $this->db->group_by('c.id');
            $query = $this->db->get();
        
            $result = $query->result_array();
        
            // Format the result
            $data = [];
            foreach ($result as $row) {
                $class_name = $row['class_name'];
                $data[] = [
                    "class_name"    => $class_name,
                    "Male"          => $row["males_" . str_replace(" ", "_", $class_name)],
                    "Female"        => $row["females_" . str_replace(" ", "_", $class_name)],
                    "total_students"=> $row["total_students"]
                ];
            }
        
            return $data;
        }

        
        public function generate_id_cards($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            return $this->get_where($transformed);
        }
        
        // Function to get student by student_no
        public function generate_individual_id_card($student_no) 
        {
            // Escape the input to prevent SQL injection
            $student_no = $this->db->escape_str($student_no);
            
            // Query the database
            $query = $this->db->get_where('students', array('student_no' => $student_no));
            
            // Check if the student exists and return the result
            if ($query->num_rows() > 0) {
                $row =  $query->row_array(); // return the student record as an associative array
                    
                $record = $this->get($row['id']);
               
                return array($record);
                
            } else {
                return NULL; // return NULL if no student is found
            }
        }
        
        public function report_promotion($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            $transformed['student_session.promoted'] = "ANY";
            $transformed['student_session.withdraw'] = 0;
            $transformed['student_session.passout'] = "ANY";
            
            $records = $this->get_where($transformed);
            $data = [];
            
            foreach($records as $record) {
                
                $this->db->from('student_session');
                $this->db->where('student_id', $record['id']);
                $this->db->where('session_id', $this->session->academy_session['current_session']['id'] + 1);
                
                // Execute the query and get the result
                $query = $this->db->get();
                
                // Fetch the result (if needed)
                $next_session_data = $query->row_array();
                
                $this->db->from('student_session');
                $this->db->where('student_id', $record['id']);
                $this->db->where('session_id', $this->session->academy_session['current_session']['id']); // Use current session ID
               
                // Execute the query and get the result
                $query = $this->db->get();
                
                // Fetch the result (if needed)
                $current_session_data = $query->row_array();
                
                // Determine where to assign the class and section based on the comparison
                if (isset($next_session_data['class_id']) && isset($current_session_data['class_id'])) {
                    if ($next_session_data['class_id'] == $current_session_data['class_id']) {
                        $continue_to_class = $current_session_data['class_id'];
                        $continue_to_section = $current_session_data['section_id'];
                        $promoted_to_class = "";
                        $promoted_to_section = "";
                    } else {
                        $continue_to_class = "";
                        $continue_to_section = "";
                        $promoted_to_class = $next_session_data['class_id'];
                        $promoted_to_section = $next_session_data['section_id'];
                    }
                } else {
                    // Handle cases where previous or current session data might be missing
                    $continue_to_class = "";
                    $continue_to_section = "";
                    $promoted_to_class = "";
                    $promoted_to_section = "";
                }
                
                // Fill the $student_ids array
                $data[] = [
                    "student_name" => $record["f_name"] . ' ' . $record["m_name"] . ' ' . $record["l_name"],
                    "student_no" => $record["student_no"],
                    "student_type_id" => $record["student_type_id"],
                    "promoted_form" => [
                        "class" => isset($current_session_data['class_id']) ? $current_session_data['class_id'] : "",
                        "section" => isset($current_session_data['section_id']) ? $current_session_data['section_id'] : ""
                    ],
                    "continute_to" => [
                        "class" => $continue_to_class,
                        "section" => $continue_to_section
                    ],
                    "promoted_to" => [
                        "class" => $promoted_to_class,
                        "section" => $promoted_to_section
                    ],
                    "passout" => isset($current_session_data['passout']) ? $current_session_data['passout'] : 0
                ];
            }
            
            return $data;
        }
        
        public function report_passout($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            $transformed['student_session.promoted'] = "ANY";
            $transformed['student_session.withdraw'] = "ANY";
            $transformed['student_session.passout'] = 1;
            
            $records = $this->get_where($transformed);
 
            return $records;
        }
        
        public function student_subject_list($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            $transformed['student_session.promoted'] = "ANY";
            
            $records = $this->get_where($transformed);
            
            $data = [];

            foreach($records as $record) {
                $rows = $this->StudentSubject->get_where_v2([
                    'student_id'            => $record['id'],
                    'current_session_id'    => $this->session->academy_session['current_session']['id'],
                ]);
                
                $subjects = [];
                
                foreach($rows as $row) {
                    $subjects[] = [
                        'subject_type'      => $this->SubjectType->get($row['subject_type_id'])['name'],
                        'subject'           => $this->Subject->get($row['subject_id'])['name']    
                    ];        
                }
                
                
                $data[] = [
                    'name' => $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name'],
                    'student_no' => $record['student_no'],
                    'student_session_class_id' => $record['student_session_class_id'],
                    'student_session_section_id' => $record['student_session_section_id'],
                    'subjects' => $subjects
                ];
            
            }
    
            return $data;
        }
        
        public function report_withdraw($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            $transformed['student_session.promoted'] = "ANY";
            $transformed['student_session.withdraw'] = 1;
            $transformed['student_session.passout'] = "ANY";
            
            $records = $this->get_where($transformed);
 
            return $records;
        }
        
        public function appraisal_extra_curricular($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            unset($transformed['students.participated.in']);
            
            $data = [];
            $records = $this->get_where($transformed);
            
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                    'participated_in' => $clauses['participated.in']
                ];

                $r = $this->db->where($params)->get("appraisal_extra_curricular")->row_array();

                if($r) {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        "participated_in"                       => $r['participated_in'],
                        "result"                                => $r['result'],
                        "remarks"                               => $r['remarks']   
                    ];
                }
                else {
            
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        "participated_in"                       => "",
                        "result"                                => "",
                        "remarks"                               => ""   
                    ];
                }
            }
            
          
            return $data;
        }
        
        public function store_appraisal_extra_curricular($rows)
        {
            foreach($rows as $row) {
                $clauses = [
                    'session_id' => $row['session_id'],
                    'student_id' => $row['student_id'],
                    "participated_in" => $row["participated_in"], 
                ];

                $r = $this->db->where($clauses)->get("appraisal_extra_curricular")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("appraisal_extra_curricular", [
                        "participated_in" => $row["participated_in"], 
                        "result" => $row["result"], 
                        "remarks" => $row["remarks"]
                    ]);
                }
                else {
                    $this->db->insert("appraisal_extra_curricular", $row);
                }
            }
        }
    
        public function appraisal_game_sports($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            unset($transformed['students.participated.in']);
            
            $data = [];
            $records = $this->get_where($transformed);
            
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                    'participated_in' => $clauses['participated.in']
                ];

                $r = $this->db->where($params)->get("appraisal_game_and_sports")->row_array();

                if($r) {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        "participated_in"                       => $r['participated_in'],
                        "result"                                => $r['result'],
                        "remarks"                               => $r['remarks']   
                    ];
                }
                else {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        "participated_in"                       => "",
                        "result"                                => "",
                        "remarks"                               => ""   
                    ];
                }
            }
            
            return $data;
        }
        
        public function store_appraisal_game_sports($rows)
        {
            
            foreach($rows as $row) {
                $clauses = [
                    'session_id' => $row['session_id'],
                    'student_id' => $row['student_id'],
                    "participated_in" => $row["participated_in"], 
                ];

                $r = $this->db->where($clauses)->get("appraisal_game_and_sports")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("appraisal_game_and_sports", [
                        "participated_in" => $row["participated_in"], 
                        "result" => $row["result"], 
                        "remarks" => $row["remarks"]
                    ]);
                }
                else {
                    $this->db->insert("appraisal_game_and_sports", $row);
                }
            }
        }
        
        public function appraisal_others($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            $data = [];
            $records = $this->get_where($transformed);
            
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                ];

                $r = $this->db->where($params)->get("appraisal_others")->row_array();

                if($r) {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        "particular"                            => $r['particular'],
                        "remarks"                               => $r['remarks']   
                    ];
                }
                else {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        "particular"                            => "",
                        "remarks"                               => ""   
                    ];
                }
            }
            
            return $data;
        }
        
        public function store_appraisal_others($rows)
        {
            
            foreach($rows as $row) {
                $clauses = [
                    'session_id' => $row['session_id'],
                    'student_id' => $row['student_id'],
                ];

                $r = $this->db->where($clauses)->get("appraisal_others")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("appraisal_others", [
                        "particular"    => $row["particular"], 
                        "remarks"       => $row["remarks"]
                    ]);
                }
                else {
                    $this->db->insert("appraisal_others", $row);
                }
            }
        }
        
        public function appraisal_discipline($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            $data = [];
            $records = $this->get_where($transformed);
            
            foreach($records as $record) {
                $clauses = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                ];

                $r = $this->db->where($clauses)->get("apprisal_discipline")->row_array();

                if($r) {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        
                        "conduct_id"                            => $r['conduct_id'],
                        "behaviour_id"                          => $r['behaviour_id'],
                        "punctuality_id"                        => $r['punctuality_id'],
                        "attendence_id"                         => $r['attendence_id'],
                        "leadership_id"                         => $r['leadership_id'],
                        "interaction_id"                        => $r['interaction_id'],
                        "expressiveness_id"                     => $r['expressiveness_id'],
                        "participation_id"                      => $r['participation_id']
                    ];
                }
                else {
                    $data[] = [
                        "id"                                    => $record['id'],
                        "f_name"                                => $record['f_name'],
                        "m_name"                                => $record['m_name'],
                        "l_name"                                => $record['l_name'],
                        "student_session_class_id"              => $record['student_session_class_id'],
                        "student_session_section_id"            => $record['student_session_section_id'],
                        "student_no"                            => $record['student_no'],
                        
                        "conduct_id"                            => "",
                        "behaviour_id"                          => "",
                        "punctuality_id"                        => "",
                        "attendence_id"                         => "",
                        "leadership_id"                         => "",
                        "interaction_id"                        => "",
                        "expressiveness_id"                     => "",
                        "participation_id"                      => "" 
                    ];
                }
            }
            
            return $data;
        }
        
        public function store_appraisal_discipline($rows)
        {

            foreach($rows as $row) {
                $clauses = [
                    'session_id' => $row['session_id'],
                    'student_id' => $row['student_id'],
                ];

                $r = $this->db->where($clauses)->get("apprisal_discipline")->row_array();

                if($r) {
                    $this->db->where($clauses)->update("apprisal_discipline", [
                        'conduct_id' => $row['conduct_id'],
                        'behaviour_id' => $row['behaviour_id'],
                        'punctuality_id' => $row['punctuality_id'],
                        'attendence_id' => $row['attendence_id'],
                        'leadership_id' => $row['leadership_id'],
                        'interaction_id' => $row['interaction_id'],
                        'expressiveness_id' => $row['expressiveness_id'],
                        'participation_id' => $row['participation_id'],
                    ]);
                }
                else {
                    $this->db->insert("apprisal_discipline", $row);
                }
            }
        }
        
     
        public function download_extra_curricular($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            unset($transformed['students.participated.in']);
            
            $data = [];
            
            $transformed["student_session.promoted"] = "ANY";
          
            $records = $this->get_where($transformed);
            
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                ];

                $this->db->select('extra_curriculars.name, appraisal_extra_curricular.result, appraisal_extra_curricular.remarks');
                $this->db->from('appraisal_extra_curricular');
                $this->db->join('extra_curriculars', 'extra_curriculars.id = appraisal_extra_curricular.participated_in', 'inner');
                $this->db->where($params);
                
                // Add the condition for result or remarks not being blank
                $this->db->group_start()
                         ->where('appraisal_extra_curricular.result !=', '')
                         ->or_where('appraisal_extra_curricular.remarks !=', '')
                         ->group_end();
         
         
                $data[] = [
                    "id"                                    => $record['id'],
                    "f_name"                                => $record['f_name'],
                    "m_name"                                => $record['m_name'],
                    "l_name"                                => $record['l_name'],
                    "student_session_class_id"              => $record['student_session_class_id'],
                    "student_session_section_id"            => $record['student_session_section_id'],
                    "student_no"                            => $record['student_no'],
                    "student_type_name"                     => $record['student_type_name'],
                    "data"                                  => $this->db->get()->result_array()
                ];
            }
            
            return $data;
        }
        
        public function download_game_sports($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            unset($transformed['students.participated.in']);
            
            $data = [];
            
            $transformed["student_session.promoted"] = "ANY";
            
            $records = $this->get_where($transformed);
        
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                ];

                $this->db->select('games.name, appraisal_game_and_sports.result, appraisal_game_and_sports.remarks');
                $this->db->from('appraisal_game_and_sports');
                $this->db->join('games', 'games.id = appraisal_game_and_sports.participated_in', 'inner');
                $this->db->where($params);
                
                // Add the condition for result or remarks not being blank
                $this->db->group_start()
                         ->where('appraisal_game_and_sports.result !=', '')
                         ->or_where('appraisal_game_and_sports.remarks !=', '')
                         ->group_end();

                $data[] = [
                    "id"                                    => $record['id'],
                    "f_name"                                => $record['f_name'],
                    "m_name"                                => $record['m_name'],
                    "l_name"                                => $record['l_name'],
                    "student_session_class_id"              => $record['student_session_class_id'],
                    "student_session_section_id"            => $record['student_session_section_id'],
                    "student_no"                            => $record['student_no'],
                    "student_type_name"                     => $record['student_type_name'],
                    "data"                                  => $this->db->get()->result_array()
                ];
            }
   
            return $data;
        }
        
        public function download_appraisal_others($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
            
            unset($transformed['students.participated.in']);
            
            $data = [];
            
            $transformed["student_session.promoted"] = "ANY";
            
            $records = $this->get_where($transformed);
        
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                ];

                $this->db->select('appraisal_others.particular, appraisal_others.remarks');
                $this->db->from('appraisal_others');
                $this->db->where($params);

                $data[] = [
                    "id"                                    => $record['id'],
                    "f_name"                                => $record['f_name'],
                    "m_name"                                => $record['m_name'],
                    "l_name"                                => $record['l_name'],
                    "student_session_class_id"              => $record['student_session_class_id'],
                    "student_session_section_id"            => $record['student_session_section_id'],
                    "student_no"                            => $record['student_no'],
                    "student_type_name"                     => $record['student_type_name'],
                    "data"                                  => $this->db->get()->row_array()
                ];
            }

            return $data;
        }
        
        public function download_discipline($clauses)
        {
            $transformed = array();
    
            foreach ($clauses as $key => $value) {
                if (strpos($key, 'ss.') === 0) {
                    // Replace 'ss.' with 'student_session.'
                    $newKey = 'student_session.' . substr($key, 3);
                } elseif (strpos($key, 's.') === 0) {
                    // Replace 's.' with 'students.'
                    $newKey = 'students.' . substr($key, 2);
                } else {
                    // For normal keys, prefix with 'students.'
                    $newKey = 'students.' . $key;
                }
                
                $transformed[$newKey] = $value;
            }
        
            unset($transformed['students.participated.in']);
            
            $data = [];
            
            $transformed["student_session.promoted"] = "ANY";
            
            $records = $this->get_where($transformed);
        
            foreach($records as $record) {
                $params = [
                    'session_id' => $this->session->academy_session['current_session']['id'],
                    'student_id' => $record['id'],
                ];

                $this->db->select('conducts.name as conduct_name, 
                                   behaviours.name as behaviour_name, 
                                   punctualities.name as punctuality_name, 
                                   attendances.name as attendance_name, 
                                   leaderships.name as leadership_name, 
                                   interactions.name as interaction_name, 
                                   expressivenesses.name as expressiveness_name, 
                                   participations.name as participation_name');
                                   
                $this->db->from('apprisal_discipline');
                
                $this->db->join('conducts', 'conducts.id = apprisal_discipline.conduct_id', 'left');
                $this->db->join('behaviours', 'behaviours.id = apprisal_discipline.behaviour_id', 'left');
                $this->db->join('punctualities', 'punctualities.id = apprisal_discipline.punctuality_id', 'left');
                $this->db->join('attendances', 'attendances.id = apprisal_discipline.attendence_id', 'left');
                $this->db->join('leaderships', 'leaderships.id = apprisal_discipline.leadership_id', 'left');
                $this->db->join('interactions', 'interactions.id = apprisal_discipline.interaction_id', 'left');
                $this->db->join('expressivenesses', 'expressivenesses.id = apprisal_discipline.expressiveness_id', 'left');
                $this->db->join('participations', 'participations.id = apprisal_discipline.participation_id', 'left');
                
                $this->db->where($params);
 
                $data[] = [
                    "id"                                    => $record['id'],
                    "f_name"                                => $record['f_name'],
                    "m_name"                                => $record['m_name'],
                    "l_name"                                => $record['l_name'],
                    "student_session_class_id"              => $record['student_session_class_id'],
                    "student_session_section_id"            => $record['student_session_section_id'],
                    "student_no"                            => $record['student_no'],
                    "student_type_name"                     => $record['student_type_name'],
                    "data"                                  => $this->db->get()->row_array()
                ];
            }
            
            return $data;
        }
    }