<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Fees extends CI_Model {

        private $table = "fees_type";

        public function get($id = NULL) {
            if($id) {
                return $this->db->where(["id" => $id, "deleted" => 0])->get($this->table)->row_array();
            }
            else {
                return $this->db->where("deleted", 0)->get($this->table)->result_array();
            }
        }

        public function insert($data) {
            return $this->db->insert($this->table, $data);
        }

        public function update($id, $data) {
            return $this->db->where(["id" => $id, "deleted" => 0])->update($this->table, $data);
        }

        public function delete($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 1]);
        }

        public function restore($id) {
            return $this->db->where("id", $id)->update($this->table, ["deleted" => 0]);
        }

        public function get_class_student_fees($classes, $student_types) {

                
                // echo "<pre>";
                // print_r($classes);
                // echo "</pre>";
              
                    
            $records = [];
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            foreach ($classes as $class) {
                $data = [];
                $data["class"] = $class;
                $data["student_types"] = [];
                
                foreach ($student_types as $student_type) {
                    // Fetch the relevant data from the database
                    $results = $this->db->select('fees_type.name, class_studentType_feesType.fees_type_id, class_studentType_feesType.status')
                        ->join('fees_type', 'fees_type.id = class_studentType_feesType.fees_type_id')
                        ->where([
                            "class_id" => $class['id'],
                            "student_type_id" => $student_type['id'], 
                            "class_studentType_feesType.session_id" => $academy_session_id, 
                        ])
                        ->get("class_studentType_feesType")
                        ->result_array();

                    // Loop through each result to check the delete permission
                    foreach ($results as $key => $fee) {
                        
                        // Check if there's a corresponding record in the 'fees' table
                        $fee_match = $this->db->select('id')
                            ->where('fees_head_id', $fee['fees_type_id'])
                            ->where('session_id', $academy_session_id)
                            ->get('fees')
                            ->row_array();
                        
                        // If a match is found, set delete_permission to 0, otherwise set it to 1
                        if ($fee_match) {
                            $results[$key]['delete_permission'] = 0;
                        } else {
                            $results[$key]['delete_permission'] = 1;
                        }
                    }
                    
                    // Store the results in the final data array
                    $data["student_types"][] = [
                        "type"          => $student_type,
                        "fees_heads"    => $results
                    ];
                }
                
                $records[] = $data;
            }
        
            return $records;
        }
        public function get_class_student_fees_data($classes, $student_types) {

                
                // echo "<pre>";
                // print_r($classes);
                // echo "</pre>";
              
                    
            $records = [];
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            foreach ($classes as $class) {
                $data = [];
                $data["class"] = $class;
                $data["student_types"] = [];
                
                foreach ($student_types as $student_type) {
                    // Fetch the relevant data from the database
                    $results = $this->db->select('fees_type.name, class_studentType_feesType.fees_type_id, class_studentType_feesType.status')
                        ->join('fees_type', 'fees_type.id = class_studentType_feesType.fees_type_id')
                        ->where([
                            "class_id" => $class,
                            "student_type_id" => $student_type, 
                            "class_studentType_feesType.session_id" => $academy_session_id, 
                        ])
                        ->get("class_studentType_feesType")
                        ->result_array();

                    // Loop through each result to check the delete permission
                    foreach ($results as $key => $fee) {
                        
                        // Check if there's a corresponding record in the 'fees' table
                        $fee_match = $this->db->select('id')
                            ->where('fees_head_id', $fee['fees_type_id'])
                            ->where('session_id', $academy_session_id)
                            ->get('fees')
                            ->row_array();
                        
                        // If a match is found, set delete_permission to 0, otherwise set it to 1
                        if ($fee_match) {
                            $results[$key]['delete_permission'] = 0;
                        } else {
                            $results[$key]['delete_permission'] = 1;
                        }
                    }
                    
                    // Store the results in the final data array
                    $data["student_types"][] = [
                        "type"          => $student_type,
                        "fees_heads"    => $results
                    ];
                }
                
                $records[] = $data;
            }
        
            return $records;
        }
        
        public function get_class_student_fees_for_entry($classes, $student_types) {
            $records = [];
            
            foreach ($classes as $class) {
                $data = [];
                $data["class"] = $class;
                $data["student_types"] = [];
                
                foreach ($student_types as $student_type) {
                    
                    $results = $this->db->select('fees_type.name, class_studentType_feesType.fees_type_id, class_studentType_feesType.status')
                    ->join('fees_type', 'fees_type.id = class_studentType_feesType.fees_type_id')
                    ->where([
                        "class_id" => $class['id'],
                        "student_type_id" => $student_type['id'],
                        "status"    => 1
                    ])
                    ->get("class_studentType_feesType")
                    ->result_array();
                    
                    $feesNames = array_column($results, 'name', 'fees_type_id', 'status');
                    
                    $data["student_types"][] = [
                        "type"          => $student_type,
                        "fees_heads"    => $results
                    ];
                    
                }
                
                $records[] = $data;
            }
        
            return $records;
        }
        
        public function get_fees_heads($data) {
            $records = $this->db->where($data)->get("class_studentType_feesType")->result_array();
            
            $list = [];
            
            foreach ($records as $record) {
                $list[] = $this->get($record['fees_type_id']);
            }
            
            return $list;
        }
        
        public function class_student_fees_change_status($data) {
            // Extract the parameters
            $class_id = $data[0];
            $student_type_id = $data[1];
            $fees_type_id = $data[2];
        
            // Query to get the current status of the entry
            $this->db->select('status'); // Assuming the column storing status is named 'status'
            $this->db->from('class_studentType_feesType');
            $this->db->where([
                'class_id' => $class_id,
                'student_type_id' => $student_type_id,
                'fees_type_id' => $fees_type_id
            ]);
        
            $query = $this->db->get();
        
            // Check if the record exists
            if ($query->num_rows() > 0) {
                // Get the current status
                $current_status = $query->row()->status;
        
                // Toggle the status (1 to 0, or 0 to 1)
                $new_status = ($current_status == 1) ? 0 : 1;
        
                // Prepare the update data
                $update_data = [
                    'status' => $new_status
                ];
        
                // Update the status in the database
                $this->db->where([
                    'class_id' => $class_id,
                    'student_type_id' => $student_type_id,
                    'fees_type_id' => $fees_type_id
                ]);
        
                return $this->db->update('class_studentType_feesType', $update_data);
            } else {
                // If no record is found, you can return false or handle the error accordingly
                return false;
            }
        }
        
        public function delete_class_student_fees($data) {
            // Define the condition for the deletion
            $this->db->where([
                "class_id" => $data[0], 
                "student_type_id" => $data[1], 
                "fees_type_id" => $data[2]
            ]);
        
            // Perform the delete operation
            return $this->db->delete('class_studentType_feesType');
        }

        public function update_class_student_fees($data) {

            $selected_class_id = $data[0];
            $student_type_id = $data[1];
            $fees_type_id = $data[2];
            
            $this->db->insert("class_studentType_feesType", [
                "class_id" => $selected_class_id,
                "student_type_id" => $student_type_id,
                "fees_type_id" => $fees_type_id,
                "session_id" => $this->session->academy_session['current_session']['id']
            ]);

            return;
        }
        
        // Outstanding Fees
        public function get_outstanding_fees($data) { 
            return $this->db->where($data)->get("student_outstanding_fees")->row_array();
        }
        
        public function insert_or_update_outstanding_fees($data) {
            // Check if record already exists with the combination of student_id and both session_ids
            $this->db->where('student_id', $data['student_id']);
            $this->db->where('previous_session_id', $this->session->academy_session['current_session']['id'] - 1);
            $this->db->where('current_session_id', $this->session->academy_session['current_session']['id']);
            $query = $this->db->get('student_outstanding_fees');
            
            // If the record exists, update the amount
            if ($query->num_rows() > 0) {
                $this->db->where('student_id', $data['student_id']);
                $this->db->where('previous_session_id', $this->session->academy_session['current_session']['id'] - 1);
                $this->db->where('current_session_id', $this->session->academy_session['current_session']['id']);
                $this->db->update('student_outstanding_fees', [
                    'amount' => $data['amount']
                ]);
            } else {
                // If the record does not exist, insert a new record
                $this->db->insert("student_outstanding_fees", [
                    "student_id"            => $data['student_id'],
                    "previous_session_id"   => $this->session->academy_session['current_session']['id'] - 1,
                    "current_session_id"    => $this->session->academy_session['current_session']['id'],
                    "amount"                => $data['amount']
                ]);
            }
        }
        
        // Concession Fees
        public function get_concession_fees($sid) {
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            
            return $this->db->get_where('fees_concession', [
                'student_id' => $sid,
                'session_id' => $academy_session_id
            ])->result_array();
        }
        
        public function store_concession_fees($ins_id, $amount, $sid) {
  
            return $this->db->insert("fees_concession", [
                "student_id"        => $sid,
                "amount"            => $amount,
                "installment_id"    => $ins_id,
                "session_id"        => $this->session->academy_session['current_session']['id']
            ]);
        }
        
        public function update_concession_fees($ins_id, $amount, $sid) {
            // Check if the record already exists
            $this->db->where(["student_id" => $sid, "installment_id" => $ins_id, "session_id" => $this->session->academy_session['current_session']['id']]);
            $query = $this->db->get("fees_concession");
        
            if ($query->num_rows() > 0) {
                // If record exists, update the record
                $this->db->where(["student_id" => $sid, "installment_id" => $ins_id, "session_id" => $this->session->academy_session['current_session']['id']])
                         ->update("fees_concession", ["amount" => $amount]);
            } else {
                // If record doesn't exist, insert a new record
                $data = [
                    "student_id" => $sid,
                    "installment_id" => $ins_id,
                    "amount" => $amount,
                    "session_id" => $this->session->academy_session['current_session']['id']
                ];
                $this->db->insert("fees_concession", $data);
            }
        
            return;
        }
        
        // Monthly Fees        
        public function get_fees($data) {
            if($data) {
                return $this->db->where($data)->get("fees")->row_array();
            }
            else {
                return $this->db->get("fees")->result_array();
            }
        }
        
        public function get_all_fees($data) {

            if($data) {
                return $this->db->where($data)->get("fees")->result_array();
            }
            else {
                return $this->db->get("fees")->result_array();
            }
        }


        public function insert_update_fees($data) {
            if (empty($data)) {
                return false;
            }
        
            $insert_data = [];
            $updated_rows = 0;
            $inserted_rows = 0;
        
            $i = 0;
            foreach ($data as $row) {
                
                if($i == 0) {
                    $this->db->where([
                        'student_id'       => $row['student_id'],
                        'class_id'         => $row['class_id'],
                        'section_id'       => $row['section_id'],
                        'student_type_id'  => $row['student_type_id'],
                        'session_id'       => $row['session_id'],
                        'month'            => $row['month']
                    ]);
                    
                    $this->db->delete('fees');
                    
                    $i++;
                }
                
                // Build the condition (excluding amount and due_date)
                $this->db->where([
                    'student_id'       => $row['student_id'],
                    'class_id'         => $row['class_id'],
                    'section_id'       => $row['section_id'],
                    'student_type_id'  => $row['student_type_id'],
                    'session_id'       => $row['session_id'],
                    'month'            => $row['month'],
                    'fees_head_id'     => $row['fees_head_id']
                ]);
        
                $existing = $this->db->get('fees')->row();
        
                if ($existing) {
                    // Update the existing record
                    $this->db->where('id', $existing->id);
                    $this->db->update('fees', [
                        'amount'   => $row['amount'],
                        'due_date' => $row['due_date']
                    ]);
                    $updated_rows += $this->db->affected_rows();
                } else {
                    // Add to insert array
                    $insert_data[] = $row;
                }
            }
        
            // Batch insert new records
            if (!empty($insert_data)) {
                $this->db->insert_batch('fees', $insert_data);
                $inserted_rows = $this->db->affected_rows();
            }
        
            // Return total affected rows (optional)
            return $updated_rows + $inserted_rows;
        }
    
        function delete_student_month_fees($data) {
            $this->db->where([
                'student_id'       => $data['student_id'],
                'class_id'         => $data['class_id'],
                'section_id'       => $data['section_id'],
                'student_type_id'  => $data['student_type_id'],
                'session_id'       => $data['session_id'],
                'month'            => $data['month']
            ]);
            
            $this->db->delete('fees');

            return;
        }
                
        public function delete_fees($id) {
            // Ensure the record exists first
            $exists = $this->db->get_where('fees', ['id' => $id])->row();
        
            if ($exists) {
                // Delete the record
                $this->db->where('id', $id)->delete('fees');
                return $this->db->affected_rows() > 0;
            }
        
            return false;
        }
        
        
                
        public function get_collection_adjusted_fees($data) {
            $academy_session_id = $this->session->academy_session['current_session']['id'];
        
            // Step 1: Get all expected fee installments (unaggregated)
            $installments = $this->db
                ->where($data)
                ->get("fees")
                ->result_array();
        
            if (empty($installments)) {
                return [];
            }
        
            // Step 2: Fetch total paid amounts per month + fee_head_id for the student
            $student_id = $installments[0]['student_id']; // assumed consistent
        
            $paid_rows = $this->db
                ->select('sfci.month, sfci.fee_head_id, SUM(sfci.amount) as paid_amount')
                ->from('student_fee_collections sfc')
                ->join('student_fee_collection_installments sfci', 'sfc.id = sfci.collection_id')
                ->where('sfc.student_id', $student_id)
                ->where('sfc.session_id', $academy_session_id)
                ->group_by(['sfci.month', 'sfci.fee_head_id'])
                ->get()
                ->result_array();
        
            // Step 3: Build a map of paid amounts for quick lookup
            $paid_map = [];
            foreach ($paid_rows as $row) {
                $key = $row['month'] . '_' . $row['fee_head_id'];
                $paid_map[$key] = (float)$row['paid_amount'];
            }
        
            // Step 4: Merge paid and due into original installments (without aggregating)
            foreach ($installments as &$inst) {
                $key = $inst['month'] . '_' . $inst['fees_head_id'];
                $amount = (float)$inst['amount'];
                $paid = isset($paid_map[$key]) ? $paid_map[$key] : 0.00;
        
                // Apply paid for this record and adjust paid_map to avoid double use
                $this_paid = min($amount, $paid); // avoid over-assigning
                $paid_map[$key] -= $this_paid;
        
                $inst['paid'] = round($this_paid, 2);
                $inst['due'] = round($amount - $this_paid, 2);
            }
        
            return $installments;
        }
        
       
        public function get_collection_adjusted_fees_other($data) {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // Start by building the SQL query to fetch the necessary data
            $this->db->select('sfc.receipt_date, sfco.name, sfco.month, sfco.amount');
            $this->db->from('student_fee_collections sfc');
            $this->db->join('student_fee_collection_other sfco', 'sfco.collection_id = sfc.id', 'inner');
            $this->db->where('sfc.session_id', $academy_session_id);
            
            if (!empty($data['student_id'])) {
                $this->db->where('sfc.student_id', $data['student_id']);
            }
         
            // Order by receipt_date if needed, for example, to get the latest first or by month.
            $this->db->order_by('sfc.receipt_date', 'ASC');
        
            // Execute the query and return the result
            $query = $this->db->get();
        
            // Check if any results are returned
            if ($query->num_rows() > 0) {
                return $query->result_array(); // Return the results as an associative array
            }
        
            // Return an empty array if no results are found
            return [];
        }

        
        public function get_fees_collection($student_id, $from_date, $to_date) {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            $this->db->from('student_fee_collections');
            $this->db->where('student_id', $student_id);
            $this->db->where('session_id', $academy_session_id);
        
            // Only add date filter if both dates are provided
            if (!empty($from_date) && !empty($to_date)) {
                $this->db->where("DATE(receipt_date) >=", $from_date);
                $this->db->where("DATE(receipt_date) <=", $to_date);
            }
        
            $query = $this->db->get();
            $result = $query->result_array();
        
            return !empty($result) ? $result : false;
        }
        
        public function get_fees_by_receipt($receipt) {

           return $this->db->get_where('student_fee_collections', ['receipt_id' => $receipt])->row_array();

        }
        
        public function new_fees_collection($data) {
            $inserted = $this->db->insert('student_fee_collections', $data);

            if ($inserted) {
                return $this->db->insert_id(); // return the new ID
            } else {
                return null;
            }
        }
        
        public function new_fees_collection_installments($data) {
            
            return $this->db->insert_batch('student_fee_collection_installments', $data);
        
            
        }
        
        public function new_fees_collection_other($data) {
        
            return $this->db->insert_batch('student_fee_collection_other', $data);
        
        }
        
        public function delete_collection($receipt_id) {
           
            $data = $this->db->get_where('student_fee_collections', ['receipt_id' => $receipt_id])->row_array();
            
            $this->db->delete('student_fee_collections', ['id' => $data['id']]);
            $this->db->delete('student_fee_collection_installments', ['collection_id' => $data['id']]);
            $this->db->delete('student_fee_collection_other', ['collection_id' => $data['id']]);
            $this->db->delete('student_fee_collection_payment', ['collection_id' => $data['id']]);
            
            return;
        }
        
        // Report
        public function feeCollectionReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // ---------------------------
            // Step 1: Base Query (receipt-wise collections)
            // ---------------------------
            $this->db->select('
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                c.name AS class_name,
                sec.name AS section_name,
                s.roll_no,
                col.receipt_id,
                col.receipt_date,
                col.payment_method,
                col.gross_amount,
                col.net_amount,
                col.summary,
                ws.id AS ws_id,
                GROUP_CONCAT(DISTINCT inst.month ORDER BY inst.month ASC SEPARATOR ",") AS pay_period
            ');

            $this->db->from('student_fee_collections AS col');

            $this->db->join(
                'students AS s',
                's.id = col.student_id',
                'inner'
            );

            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id AND ses.session_id = ' . $academy_session_id,
                'inner'
            );

            // 🔽 CHANGED JOINS HERE
            $this->db->join(
                'classes AS c',
                'c.id = ses.class_id',
                'left'
            );

            $this->db->join(
                'sections AS sec',
                'sec.id = ses.section_id',
                'left'
            );

            $this->db->join(
                'student_fee_collection_installments AS inst',
                'inst.collection_id = col.id',
                'left'
            );

            // Include withdrawn students, but only transactions before withdrawal date
            $this->db->join(
                'withdrawn_students AS ws',
                'ws.student_id = s.id AND col.receipt_date <= ws.date_of_leaving',
                'left'
            );

            // ---------------------------
            // Step 2: Filters
            // ---------------------------
            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $this->db->where('col.receipt_date >=', $filters['from_date']);
                $this->db->where('col.receipt_date <=', $filters['to_date']);
            }

            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            if (!empty($filters['payment_mode'])) {
                $this->db->where_in('col.payment_method', (array)$filters['payment_mode']);
            }

            $this->db->where('col.session_id', $academy_session_id);

            // ---------------------------
            // Step 3: Grouping & Sorting
            // ---------------------------
            $this->db->group_by('col.id');
            $this->db->order_by('col.receipt_date', 'ASC');

            $rows = $this->db->get()->result_array();

            // ---------------------------
            // Step 4: Load active fee heads
            // ---------------------------
            $fee_heads = $this->db->select('name')
                ->from('fees_type')
                ->where('is_active', 1)
                ->where('deleted', 0)
                ->get()
                ->result_array();

            $fee_head_names = array_column($fee_heads, 'name');

            // ---------------------------
            // Step 5: Decode JSON & compute fee components
            // ---------------------------
            $final = [];

            foreach ($rows as $r) {

                $summary = json_decode($r['summary'], true);

                $late_fine = 0;
                $previous_year_due = 0;
                $concession = 0;
                $other_charges = 0;
                $fee_breakdown = [];

                if (is_array($summary)) {
                    foreach ($summary as $key => $value) {
                        $amount = (float)$value;

                        if (in_array($key, $fee_head_names)) {
                            $fee_breakdown[$key] =
                                ($fee_breakdown[$key] ?? 0) + $amount;
                        } elseif (stripos($key, 'Previous Year Due') !== false) {
                            $previous_year_due += $amount;
                        } elseif (stripos($key, 'Concession') !== false) {
                            $concession += $amount;
                        } elseif (stripos($key, 'Late Fine') !== false) {
                            $late_fine += $amount;
                        } else {
                            $other_charges += $amount;
                        }
                    }
                }

                $final[] = [
                    'student_no'        => $r['student_no'],
                    'student_name'      => !empty($r['ws_id'])
                                            ? $r['student_name'] . ' (W)'
                                            : $r['student_name'],
                    'class_name'        => $r['class_name'],
                    'section_name'      => $r['section_name'],
                    'roll_no'           => $r['roll_no'],
                    'receipt_id'        => $r['receipt_id'],
                    'receipt_date'      => $r['receipt_date'],
                    'payment_method'    => $r['payment_method'],
                    'pay_period'        => $r['pay_period'],
                    'gross_amount'      => $r['gross_amount'],
                    'net_amount'        => $r['net_amount'],
                    'previous_year_due' => $previous_year_due,
                    'concession'        => $concession,
                    'late_fine'         => $late_fine,
                    'other_charges'     => $other_charges,
                    'fee_breakdown'     => $fee_breakdown
                ];
            }

            return $final;
        }

        public function feeHeadWiseCollectionReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // -----------------------------
            // Step 1: Base Query
            // -----------------------------
            $this->db->select('
                s.id AS student_id,
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                c.name AS class_name,
                sec.name AS section_name,
                st.name AS student_type,
                s.roll_no,
                col.receipt_date,
                col.payment_method,
                col.gross_amount,
                col.net_amount,
                col.summary,
                ws.id AS ws_id,
                ws.date_of_leaving
            ');

            $this->db->from('student_fee_collections AS col');

            $this->db->join(
                'student_session AS ss',
                'ss.student_id = col.student_id 
                AND ss.session_id = ' . (int)$academy_session_id,
                'inner'
            );

            $this->db->join('students AS s', 's.id = ss.student_id', 'left');
            $this->db->join('classes AS c', 'c.id = ss.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ss.section_id', 'left');
            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');

            // Withdrawn students: include only payments before leaving date
            $this->db->join(
                'withdrawn_students AS ws',
                'ws.student_id = s.id AND col.receipt_date <= ws.date_of_leaving',
                'left'
            );

            // -----------------------------
            // Step 2: Filters
            // -----------------------------
            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $this->db->where('col.receipt_date >=', $filters['from_date']);
                $this->db->where('col.receipt_date <=', $filters['to_date']);
            }

            // 🔹 IMPORTANT: filters moved to student_session
            if (!empty($filters['class_id'])) {
                $this->db->where('ss.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ss.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            if (!empty($filters['payment_mode'])) {
                $this->db->where_in('col.payment_method', (array)$filters['payment_mode']);
            }

            $this->db->where('col.session_id', $academy_session_id);

            $rows = $this->db->get()->result_array();

            // -----------------------------
            // Step 3: Fee Heads
            // -----------------------------
            $fee_heads = $this->db->select('name')->get('fees_type')->result_array();
            $fee_head_names = array_column($fee_heads, 'name');

            // -----------------------------
            // Step 4: Group by student
            // -----------------------------
            $final = [];

            foreach ($rows as $r) {

                $student_id = $r['student_id'];

                if (!isset($final[$student_id])) {
                    $final[$student_id] = [
                        'student_no'        => $r['student_no'],
                        'student_name'      => !empty($r['ws_id']) ? $r['student_name'] . ' (W)' : $r['student_name'],
                        'class_name'        => $r['class_name'],
                        'section_name'      => $r['section_name'],
                        'student_type'      => $r['student_type'],
                        'roll_no'           => $r['roll_no'],
                        'receipt_date'      => $r['receipt_date'],
                        'gross_amount'      => 0,
                        'net_amount'        => 0,
                        'previous_year_due' => 0,
                        'concession'        => 0,
                        'late_fine'         => 0,
                        'other_charges'     => 0,
                        'fee_heads'         => []
                    ];
                }

                $final[$student_id]['gross_amount'] += $r['gross_amount'];
                $final[$student_id]['net_amount']   += $r['net_amount'];

                $summary = json_decode($r['summary'], true);

                if (is_array($summary)) {
                    foreach ($summary as $key => $value) {
                        $amount = (float)$value;

                        if (in_array($key, $fee_head_names)) {
                            $final[$student_id]['fee_heads'][$key] =
                                ($final[$student_id]['fee_heads'][$key] ?? 0) + $amount;
                        } elseif (stripos($key, 'Previous Year Due') !== false) {
                            $final[$student_id]['previous_year_due'] += $amount;
                        } elseif (stripos($key, 'Concession') !== false) {
                            $final[$student_id]['concession'] += $amount;
                        } elseif (stripos($key, 'Late Fine') !== false) {
                            $final[$student_id]['late_fine'] += $amount;
                        } else {
                            $final[$student_id]['other_charges'] += $amount;
                        }
                    }
                }
            }

            return array_values($final); // reindex array
        }

        public function paymentWiseCollectionReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // ---------------------------
            // Step 1: Fetch raw collection data (receipt-wise)
            // ---------------------------
            $this->db->select('
                col.id,
                col.summary,
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                c.name AS class_name,
                sec.name AS section_name,
                st.name AS student_type,
                col.receipt_id,
                col.receipt_date,
                col.payment_method,
                col.gross_amount,
                col.net_amount,
                ws.id AS ws_id
            ');

            $this->db->from('student_fee_collections AS col');

            $this->db->join('students AS s', 's.id = col.student_id', 'inner');

            // 🔹 student_session → current session only
            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id AND ses.session_id = ' . (int)$academy_session_id,
                'inner'
            );

            // 🔹 class & section must come from student_session
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');

            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');

            // Withdrawn students: allow payments only before leaving date
            $this->db->join(
                'withdrawn_students AS ws',
                'ws.student_id = s.id AND col.receipt_date <= ws.date_of_leaving',
                'left'
            );

            // ---------------------------
            // Filters
            // ---------------------------
            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $this->db->where('col.receipt_date >=', $filters['from_date']);
                $this->db->where('col.receipt_date <=', $filters['to_date']);
            }

            // 🔹 FIXED: class & section filters via student_session
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            if (!empty($filters['payment_mode'])) {
                $this->db->where_in('col.payment_method', (array)$filters['payment_mode']);
            }

            $this->db->where('col.session_id', $academy_session_id);

            // 🔹 guarantee 1 row per receipt
            $this->db->group_by('col.id');

            $result = $this->db->get()->result_array();


            // ---------------------------
            // Step 2: Fetch active fee heads
            // ---------------------------
            $fee_heads = $this->db->select('TRIM(name) AS name')
                ->from('fees_type')
                ->where('is_active', 1)
                ->where('deleted', 0)
                ->get()
                ->result_array();

            $fee_head_names = array_column($fee_heads, 'name');

            // ---------------------------
            // Step 3: Process data
            // ---------------------------
            $final = [];

            foreach ($result as $row) {

                $receiptKey = $row['receipt_id'];

                if (!isset($final[$receiptKey])) {
                    $final[$receiptKey] = [
                        'student_no'   => $row['student_no'],
                        'student_name' => !empty($row['ws_id'])
                                            ? $row['student_name'] . ' (W)'
                                            : $row['student_name'],
                        'class_name'   => $row['class_name'],
                        'section_name' => $row['section_name'],
                        'student_type' => $row['student_type'],
                        'receipt_id'   => $row['receipt_id'],
                        'receipt_date' => $row['receipt_date'],

                        // payment modes
                        'cash'         => 0,
                        'debit_card'   => 0,
                        'credit_card'  => 0,
                        'qr_code'      => 0,
                        'cheque'       => 0,
                        'neft'         => 0,
                        'bank_deposit' => 0,

                        'gross_amount' => $row['gross_amount'],
                        'net_amount'   => $row['net_amount'],

                        'previous_year_due' => 0,
                        'late_fine'         => 0,
                        'concession'        => 0,
                        'other_charges'     => 0,
                    ];
                }

                // Decode summary
                $summaryData = json_decode($row['summary'], true);
                if (is_array($summaryData)) {
                    foreach ($summaryData as $keyName => $val) {
                        $val = (float)$val;
                        $keyName = trim($keyName);

                        if (in_array($keyName, $fee_head_names)) {
                            continue;
                        } elseif (strcasecmp($keyName, 'Previous Year Due') === 0) {
                            $final[$receiptKey]['previous_year_due'] += $val;
                        } elseif (strcasecmp($keyName, 'Late Fine') === 0) {
                            $final[$receiptKey]['late_fine'] += $val;
                        } elseif (strcasecmp($keyName, 'Concession') === 0) {
                            $final[$receiptKey]['concession'] += $val;
                        } else {
                            $final[$receiptKey]['other_charges'] += $val;
                        }
                    }
                }

                // ✅ Payment method mapping (now safe)
                $method = strtolower(trim($row['payment_method']));
                if (isset($final[$receiptKey][$method])) {
                    $final[$receiptKey][$method] = $row['net_amount'];
                }
            }

            return array_values($final);
        }

       
        public function stateWiseOutstandingReport($filters)
        {
            // Current academic session
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // === 1. Fetch Students with Class, Section, and State Info ===
            $this->db->select('
                s.id AS student_id,
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                s.father_name,
                s.father_mobile,
                s.mother_name,
                s.mother_mobile,
                st.name AS student_type,
                c.name AS class_name,
                sec.name AS section_name,
                state.name AS state_name,
                ws.date_of_leaving
            ');

            $this->db->from('students AS s');

            // 🔹 Join student_session (current session)
            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id AND ses.session_id = ' . (int)$academy_session_id,
                'inner'
            );

            // 🔹 FIXED: class & section via student_session
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');

            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');
            $this->db->join('states AS state', 'state.id = s.state_id', 'left');

            // --------------------
            // Filters (FIXED)
            // --------------------
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            if (!empty($filters['state_id'])) {
                $this->db->where('s.state_id', $filters['state_id']);
            }


            // Withdrawn in CURRENT session only
            
            $this->db->join(
                'withdrawn_students AS ws',
                'ws.student_id = s.id AND ws.session_id = ' . (int)$academy_session_id,
                'left'
            );
            
            // Execute
            $students = $this->db->get()->result_array();

            $final = [];
        
            foreach ($students as $row) {
                $student_id = $row['student_id'];
        
                // === Call studentMonthlyPaymentReport to get the full report ===
                $student_report = $this->studentMonthlyPaymentReport($student_id);
        
                // Extract outstanding from summary
                $outstanding = $student_report['summary']['outstanding'];
        
                // Append (W) if student is withdrawn
                $student_name = $row['student_name'];
                if (!empty($row['date_of_leaving'])) {
                    $student_name .= ' (W)';
                }
        
                // Add to the final result
                $final[] = [
                    'student_no'    => $row['student_no'],
                    'student_name'  => $student_name,
                    'father_name'   => $row['father_name'],
                    'father_mobile' => $row['father_mobile'],
                    'mother_name'   => $row['mother_name'],
                    'mother_mobile' => $row['mother_mobile'],
                    'student_type'  => $row['student_type'],
                    'class_name'    => $row['class_name'],
                    'section_name'  => $row['section_name'],
                    'state_name'    => $row['state_name'],
                    'outstanding'   => $outstanding,
                ];
            }
        
            return $final;
        }
        
        public function classWiseOutstandingReport($filters)
        {
            // Current academic session
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // === 1. Fetch Students with Class & Section Info ===
            $this->db->select('
                s.id AS student_id,
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                s.father_name,
                s.father_mobile,
                s.mother_name,
                s.mother_mobile,
                st.name AS student_type,
                c.name AS class_name,
                sec.name AS section_name,
                ws.date_of_leaving
            ');

            $this->db->from('students AS s');

            // 🔹 Join ONLY current session students
            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id AND ses.session_id = ' . (int)$academy_session_id,
                'inner'
            );

            // 🔹 FIXED: class & section via student_session
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');

            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');

            // Withdrawn info (current session only)
            $this->db->join(
                'withdrawn_students AS ws',
                'ws.student_id = s.id AND ws.session_id = ' . (int)$academy_session_id,
                'left'
            );

            $this->db->where('s.deleted', 0);

            // === Filters (FIXED) ===
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            // === Prevent duplicates ===
            $this->db->group_by('s.id');

            // Sorting
            $this->db->order_by('c.name ASC, sec.name ASC, s.f_name ASC');

            // Execute
            $students = $this->db->get()->result_array();

            $final = [];

            foreach ($students as $row) {

                // Full payment report
                $student_report = $this->studentMonthlyPaymentReport($row['student_id']);

                $outstanding = $student_report['summary']['outstanding'] ?? 0;

                // Append (W) if withdrawn
                $student_name = $row['student_name'];
                if (!empty($row['date_of_leaving'])) {
                    $student_name .= ' (W)';
                }

                $final[] = [
                    'student_no'    => $row['student_no'],
                    'student_name'  => $student_name,
                    'father_name'   => $row['father_name'],
                    'father_mobile' => $row['father_mobile'],
                    'mother_name'   => $row['mother_name'],
                    'mother_mobile' => $row['mother_mobile'],
                    'student_type'  => $row['student_type'],
                    'class_name'    => $row['class_name'],
                    'section_name'  => $row['section_name'],
                    'outstanding'   => $outstanding,
                ];
            }

            return $final;
        }


        public function previousYearOutstandingReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            $this->db->select('
                s.id AS student_id,
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                s.phone,
                st.name AS student_type,
                c.name AS class_name,
                sec.name AS section_name
            ');

            $this->db->from('students AS s');

            // 🔹 Session mapping (current academic session)
            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id AND ses.session_id = ' . (int)$academy_session_id,
                'inner'
            );

            // 🔹 Class & section via student_session
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');

            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');

            $this->db->where('s.deleted', 0);

            // --------------------
            // Filters (FIXED)
            // --------------------
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            // Optional safety checks
            // $this->db->where('ses.passout', 0);
            // $this->db->where('ses.withdraw', 0);

            $students = $this->db->get()->result_array();


            $final = [];
            foreach ($students as $row) {
                // Base payable from student_outstanding_fees
                $payable = 0;
                $this->db->select('SUM(amount) AS amount');
                $this->db->from('student_outstanding_fees');
                $this->db->where('student_id', $row['student_id']);
                $this->db->where('student_outstanding_fees.current_session_id', $academy_session_id);
                $pay_row = $this->db->get()->row_array();
                if (!empty($pay_row['amount'])) {
                    $payable = (float)$pay_row['amount'];
                }
    
                if($payable > 0) {
                    $final[] = [
                        'student_no'   => $row['student_no'],
                        'student_name' => $row['student_name'],
                        'class_name'   => $row['class_name'],
                        'section_name' => $row['section_name'],
                        'student_type' => $row['student_type'],
                        'phone'        => $row['phone'],
                        'payable'      => $payable,
                        'paid'         => $paid,
                        'outstanding'  => $payable,
                    ];
                }
            }
    
            return $final;
        }
        
        public function totalConcessionReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            $this->db->select('
                s.id AS student_id,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                c.name AS class_name,
                sec.name AS section_name,
                st.name AS student_type,
                fc.installment_id,
                SUM(fc.amount) AS total_amount
            ');

            $this->db->from('fees_concession AS fc');

            // Student master
            $this->db->join('students AS s', 's.id = fc.student_id', 'left');

            // 🔹 Session mapping (current session only)
            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id AND ses.session_id = ' . (int)$academy_session_id,
                'inner'
            );

            // 🔹 Class & section must come from student_session
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');

            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');

            $this->db->where('s.deleted', 0);

            // --------------------
            // Filters (FIXED)
            // --------------------
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            // --------------------
            // Exclude withdrawn students (current session)
            // --------------------
            $this->db->join(
                'withdrawn_students AS ws',
                'ws.student_id = s.id AND ws.session_id = ' . (int)$academy_session_id,
                'left'
            );

            $this->db->where('ws.id IS NULL');

            // --------------------
            // Group & session filter
            // --------------------
            $this->db->group_by(['s.id', 'fc.installment_id']);
            $this->db->where('fc.session_id', $academy_session_id);

            // Execute
            $rows = $this->db->get()->result_array();
            
            // Transform rows → pivot months
            $students = [];
            foreach ($rows as $r) {
                $month_no = (int)str_replace('ins_', '', $r['installment_id']);
                if (!isset($students[$r['student_id']])) {
                    $students[$r['student_id']] = [
                        'student_name' => $r['student_name'],
                        'class_name' => $r['class_name'],
                        'section_name' => $r['section_name'],
                        'student_type' => $r['student_type'],
                        'months' => array_fill(1, 12, 0),
                        'total' => 0
                    ];
                }
                $students[$r['student_id']]['months'][$month_no] += $r['total_amount'];
                $students[$r['student_id']]['total'] += $r['total_amount'];
            }

            return $students;
        }
        
        public function classWiseAllMonthsCollectionReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // === 1. Fetch Students with Class, Section & Withdrawal Info ===
            $this->db->select('
                s.id AS student_id,
                s.student_no,
                CONCAT(s.f_name, " ", s.l_name) AS student_name,
                c.name AS class_name,
                sec.name AS section_name,
                st.name AS student_type,
                ws.date_of_leaving
            ');
            $this->db->from('students AS s');
            $this->db->join('student_session AS ses', 'ses.student_id = s.id', 'left');
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');  // Use class_id from student_session
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');  // Use section_id from student_session
            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');
            $this->db->join('withdrawn_students AS ws', 'ws.student_id = s.id', 'left');
            $this->db->where('s.deleted', 0);

            // Filter by session
            $this->db->where('ses.session_id', $academy_session_id);

            // Filters
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);  // filter by student_session.class_id
            }
            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);  // filter by student_session.section_id
            }
            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            // Order
            $this->db->order_by('c.name ASC, sec.name ASC, s.f_name ASC');

            // Get all students
            $students = $this->db->get()->result_array();

            $final = [];
        
            foreach ($students as $stu) {
                $student_id = $stu['student_id'];
                $withdrawal_date = !empty($stu['date_of_leaving']) ? $stu['date_of_leaving'] : null;
        
                // Add (W) after student name if withdrawn
                $student_name = $stu['student_name'];
                if ($withdrawal_date) {
                    $student_name .= ' (W)';
                }
        
                // Initialize 12 months arrays
                $monthly_payable = array_fill(1, 12, 0);
                $monthly_paid = array_fill(1, 12, 0);
        
                // --- Get Payable from fees table
                $this->db->select('month, SUM(amount) AS total_amount');
                $this->db->from('fees');
                $this->db->where('student_id', $student_id);
                if ($withdrawal_date) {
                    // Only include months before withdrawal
                    $withdrawal_month = (int)date('m', strtotime($withdrawal_date)) - 1;
                    $this->db->where('month <=', $withdrawal_month);
                }
                $this->db->group_by('month');
                $this->db->where('session_id', $academy_session_id);
                $payable_rows = $this->db->get()->result_array();
        
                foreach ($payable_rows as $p) {
                    $month = (int)$p['month'] + 1; // 0–11 → 1–12
                    if ($month >= 1 && $month <= 12) {
                        $monthly_payable[$month] = (float)$p['total_amount'];
                    }
                }
        
                // --- Get monthly Paid (student_fee_collection_installments)
                $this->db->select('inst.month, SUM(inst.net_amount) AS total_paid');
                $this->db->from('student_fee_collection_installments AS inst');
                $this->db->join('student_fee_collections AS col', 'col.id = inst.collection_id', 'left');
                $this->db->where('col.student_id', $student_id);
                if ($withdrawal_date) {
                    $this->db->where('col.receipt_date <=', $withdrawal_date);
                }
                $this->db->group_by('inst.month');

                $this->db->where('col.session_id', $academy_session_id);
                $paid_rows = $this->db->get()->result_array();
        
                foreach ($paid_rows as $pr) {
                    $month = (int)$pr['month']; // 1–12
                    if ($month >= 1 && $month <= 12) {
                        $monthly_paid[$month] = (float)$pr['total_paid'];
                    }
                }
        
                // --- Gross Payable
                $gross_payable = array_sum($monthly_payable);
        
                // --- Paid total (receipt-level)
                $this->db->select('SUM(net_amount) AS total_net_paid');
                $this->db->from('student_fee_collections');
                $this->db->where('student_id', $student_id);
                if ($withdrawal_date) {
                    $this->db->where('receipt_date <=', $withdrawal_date);
                }

                $this->db->where('student_fee_collections.session_id', $academy_session_id);
                $net_paid_row = $this->db->get()->row_array();
                $paid_total = !empty($net_paid_row['total_net_paid']) ? (float)$net_paid_row['total_net_paid'] : 0;
        
                // --- Concession
                $this->db->select('SUM(amount) AS total_concession');
                $this->db->from('fees_concession');
                $this->db->where('student_id', $student_id);
                $this->db->where('fees_concession.session_id', $academy_session_id);
                $con_row = $this->db->get()->row_array();
                $concession_total = !empty($con_row['total_concession']) ? (float)$con_row['total_concession'] : 0;
        
                // --- Previous Year Due
                $this->db->select('SUM(amount) AS total_due');
                $this->db->from('student_outstanding_fees');
                $this->db->where('student_id', $student_id);
                $this->db->where('student_outstanding_fees.current_session_id', $academy_session_id);
                $due_row = $this->db->get()->row_array();
                $previous_year_due = !empty($due_row['total_due']) ? (float)$due_row['total_due'] : 0;
        
                // --- Final Computations
                $net_payable = $gross_payable - $concession_total;
                $outstanding = ($gross_payable + $previous_year_due - $concession_total) - $paid_total;
        
                $final[] = array_merge($stu, [
                    'student_name'    => $student_name,
                    'monthly_payable' => $monthly_payable,
                    'monthly_paid'    => $monthly_paid,
                    'gross_payable'   => $gross_payable,
                    'previous_due'    => $previous_year_due,
                    'concession'      => $concession_total,
                    'net_payable'     => $net_payable,
                    'paid'            => $paid_total,
                    'outstanding'     => $outstanding
                ]);
            }
        
            return $final;
        }

        public function studentMonthlyPaymentReport($student_id)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];
            $report = [];
        
            // ==================== 1️⃣ GROSS AMOUNT PAYABLE ====================
            $this->db->select('f.month, f.due_date, f.fees_head_id, ft.name AS fee_head, SUM(f.amount) AS amount');
            $this->db->from('fees AS f');
            $this->db->join('fees_type AS ft', 'ft.id = f.fees_head_id', 'left');
            $this->db->where('f.student_id', $student_id);
            $this->db->group_by(['f.month', 'f.fees_head_id']);
            $this->db->where('f.session_id', $academy_session_id);
            $rows = $this->db->get()->result_array();
        
            $months = range(0, 11);
            $fee_heads = [];
            $due_dates = [];
        
            foreach ($rows as $r) {
                $m = (int)$r['month'];
                $fee_heads[$r['fee_head']][$m] = (float)$r['amount'];
                if (!isset($due_dates[$m])) {
                    $due_dates[$m] = $r['due_date'];
                }
            }
        
            $headwise_total = [];
            $gross_payable = 0;
        
            foreach ($fee_heads as $head => $month_data) {
                $head_total = 0;
                foreach ($months as $m) {
                    $head_total += isset($month_data[$m]) ? $month_data[$m] : 0;
                }
                $headwise_total[$head] = $head_total;
                $gross_payable += $head_total;
            }
        
            $report['payable'] = [
                'months' => $months,
                'due_dates' => $due_dates,
                'fee_heads' => $fee_heads,
                'headwise_total' => $headwise_total,
                'gross_total' => $gross_payable
            ];
        
            // ==================== 2️⃣ TOTAL NET AMOUNT PAID ====================
            $this->db->select('col.receipt_id, col.receipt_date, col.months, col.summary, inst.month, col.net_amount AS paid');
            $this->db->from('student_fee_collections AS col');
            $this->db->join('student_fee_collection_installments AS inst', 'inst.collection_id = col.id', 'left');
            $this->db->join('fees_type AS ft', 'ft.id = inst.fee_head_id', 'left');
            $this->db->where('col.student_id', $student_id);
            $this->db->where('col.session_id', $academy_session_id);
            $this->db->group_by('col.id');
            $paid_rows = $this->db->get()->result_array();
        
            $paid_total = 0;
            foreach ($paid_rows as &$p) {
                $p['month_name'] = date('M \'y', mktime(0, 0, 0, $p['month'], 10));
                $p['receipt_date'] = date('d-m-Y', strtotime($p['receipt_date']));
                $paid_total += $p['paid'];
            }
        
            $report['paid'] = [
                'rows' => $paid_rows,
                'total_paid' => $paid_total
            ];
        
            // ==================== 3️⃣ CONCESSION ====================
            $this->db->select('SUM(amount) AS total_concession');
            $this->db->from('fees_concession');
            $this->db->where('student_id', $student_id);
            $this->db->where('fees_concession.session_id', $academy_session_id);
            $con_row = $this->db->get()->row_array();
            $concession_total = !empty($con_row['total_concession']) ? (float)$con_row['total_concession'] : 0;
        
            // ==================== 4️⃣ PREVIOUS YEAR DUE ====================
            $this->db->select('SUM(amount) AS total_due');
            $this->db->from('student_outstanding_fees');
            $this->db->where('student_id', $student_id);
            $this->db->where('student_outstanding_fees.current_session_id', $academy_session_id);
            $due_row = $this->db->get()->row_array();
            $previous_due = !empty($due_row['total_due']) ? (float)$due_row['total_due'] : 0;
        
            // ==================== 5️⃣ SUMMARY REPORT ====================
            $net_payable = $gross_payable + $previous_due - $concession_total;
            $outstanding = $net_payable - $paid_total;
        
            $report['summary'] = [
                'gross_payable' => $gross_payable,        // Fees before adjustments
                'previous_due' => $previous_due,          // Added previous session due
                'concession' => $concession_total,        // Subtracted concession
                'net_payable' => $net_payable,            // Final amount payable
                'total_paid' => $paid_total,              // Total paid
                'outstanding' => $outstanding             // Remaining balance
            ];
        
            return $report;
        }
       
        public function consolidatedOutstandingReport($filters)
        {
            $academy_session_id = $this->session->academy_session['current_session']['id'];

            // === 1️⃣ Get all active students (current session) ===
            $this->db->select('
                s.id AS student_id,
                s.student_no,
                CONCAT_WS(" ", s.f_name, s.m_name, s.l_name) AS student_name,
                c.name AS class_name,
                sec.name AS section_name,
                st.name AS student_type,
                s.father_mobile,
                s.mother_mobile
            ');

            $this->db->from('students AS s');

            // 🔹 Join student_session (CURRENT session + not withdrawn)
            $this->db->join(
                'student_session AS ses',
                'ses.student_id = s.id 
                AND ses.session_id = ' . (int)$academy_session_id . '
                AND ses.withdraw != 1',
                'inner'
            );

            // 🔹 FIXED: class & section via student_session
            $this->db->join('classes AS c', 'c.id = ses.class_id', 'left');
            $this->db->join('sections AS sec', 'sec.id = ses.section_id', 'left');
            $this->db->join('student_types AS st', 'st.id = s.student_type_id', 'left');

            $this->db->where('s.deleted', 0);

            // --------------------
            // Filters (FIXED)
            // --------------------
            if (!empty($filters['class_id'])) {
                $this->db->where('ses.class_id', $filters['class_id']);
            }

            if (!empty($filters['section_id'])) {
                $this->db->where('ses.section_id', $filters['section_id']);
            }

            if (!empty($filters['student_type_id'])) {
                $this->db->where('s.student_type_id', $filters['student_type_id']);
            }

            // Optional safety
            // $this->db->where('ses.passout', 0);

            $students = $this->db->get()->result_array();

            $final = [];
        
            foreach ($students as $stu) {
                $student_id = $stu['student_id'];
        
                // --- Gross Payable from monthly fees
                $payable_school = $this->studentMonthlyPaymentReport($student_id)['summary']['gross_payable'];
        
                // --- Paid total from student_fee_collections.net_amount
                $this->db->select('SUM(net_amount) AS total_net_paid');
                $this->db->from('student_fee_collections');
                $this->db->where('student_id', $student_id);
                $this->db->where('student_fee_collections.session_id', $academy_session_id);
                $net_paid_row = $this->db->get()->row_array();
                $paid_total = !empty($net_paid_row['total_net_paid']) ? (float)$net_paid_row['total_net_paid'] : 0;
        
                // --- Concession from fees_concession table
                $this->db->select('SUM(amount) AS total_concession');
                $this->db->from('fees_concession');
                $this->db->where('student_id', $student_id);
                $this->db->where('fees_concession.session_id', $academy_session_id);
                $con_row = $this->db->get()->row_array();
                $concession_total = !empty($con_row['total_concession']) ? (float)$con_row['total_concession'] : 0;
        
                // --- Previous Year Due from student_outstanding_fees
                $this->db->select('SUM(amount) AS total_due');
                $this->db->from('student_outstanding_fees');
                $this->db->where('student_id', $student_id);
                $this->db->where('student_outstanding_fees.current_session_id', $academy_session_id);
                $due_row = $this->db->get()->row_array();
                $previous_year_due = !empty($due_row['total_due']) ? (float)$due_row['total_due'] : 0;
        
                // === Compute outstanding, prevent negative
                $outstanding_school = max(0, ($payable_school + $previous_year_due) - ($paid_total + $concession_total));
                
                $final[] = [
                    'student_no' => $stu['student_no'],
                    'student_name' => $stu['student_name'],
                    'class_sec' => $stu['class_name'] . ' ' . $stu['section_name'],
                    'student_type' => $stu['student_type'],
                    'board_prev_due' => 0,
                    'school_prev_due' => $previous_year_due,
                    'board_payable' => 0,
                    'school_payable' => $payable_school,
                    'payable_total' => $payable_school,
                    'board_received' => 0,
                    'school_received' => $paid_total,
                    'late_fee' => 0,
                    'other_charges' => 0,
                    'concession' => $concession_total,
                    'received_total' => $paid_total,
                    'board_outstanding' => 0,
                    'school_outstanding' => $outstanding_school,
                    'outstanding_total' => $outstanding_school,
                    'phone' => $stu['father_mobile'] ?: $stu['mother_mobile']
                ];
            }
        
            return $final;
        }
    }