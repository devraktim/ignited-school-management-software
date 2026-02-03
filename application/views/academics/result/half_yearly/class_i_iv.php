<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Half Yearly Progress Report 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .a4-page {
            width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            margin: 10mm auto; /* Center with some margin */
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10mm; /* Internal padding for the content */
            box-sizing: border-box; /* Include padding in width/height */
            page-break-after: always; /* Ensure each page breaks after itself for printing */
        }

        /* Adjustments for print */
        @media print {
            body {
                background-color: white;
            }
            .a4-page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: none;
                page-break-after: always;
            }
            .a4-page:last-child {
                page-break-after: avoid; /* No page break after the last student */
            }
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 70px; /* Adjust as needed */
            margin-right: 20px;
        }
        .header-text h1 {
            font-size: 1.8rem;
            margin-bottom: 0;
            line-height: 1.2;
            font-weight: bold;
        }
        .header-text p {
            font-size: 1.1rem;
            margin-top: 5px;
            font-weight: 500;
        }
        .report-title {
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .student-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        .student-info div {
            flex: 1;
        }
        .student-info div:last-child {
            text-align: right;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        table th, table td {
            /*border: 1px solid #000;*/
            padding: 6px 8px;
            vertical-align: middle;
            font-size: 0.85rem;
        }
        table thead th {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        table tbody td {
            text-align: left;
        }
        table .text-center {
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            text-align: center;
            background-color: #f0f0f0;
        }

        .evaluation-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .evaluation-section > div {
            flex: 1;
            padding: 0 10px;
        }
        .evaluation-section .left-panel,
        .evaluation-section .right-panel {
            /*border: 1px solid #000;*/
            padding-right: 10px;
        }

        .minor-subjects-table th, .minor-subjects-table td {
            /*border: 1px solid #000;*/
            padding: 5px 8px;
            font-size: 0.85rem;
        }
        .minor-subjects-table th {
            text-align: left;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .minor-subjects-table .grade-col {
            width: 30%;
            text-align: center;
        }

        .evaluation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .evaluation-table td {
            border: 1px solid #dbd7d7;
            padding: 5px 8px;
            font-size: 0.85rem;
        }
        .evaluation-table td:first-child {
            width: 40%;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .class-teacher-remark {
            border: 1px solid #dbd7d7;
            padding: 10px;
            margin-top: 20px;
            min-height: 80px; /* Adjust as needed for space */
            font-size: 0.9rem;
        }
        .class-teacher-remark p {
            margin-bottom: 0;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px;
            text-align: center;
        }

        .principal-signature {
            text-align: right;
            margin-top: 40px;
            font-weight: bold;
            font-size: 0.95rem;
        }
        .invisible-placeholder {
            visibility: <?php echo ($header === "yes") ? "visible" : "hidden"; ?>;
        }
    </style>
</head>
<body>
    <?php foreach ($students as $student): ?>
    <div class="a4-page">
        <!-- HEADER -->
        <div class="header">
            <img src="https://ignitedsoft.in/stfrancis/assets/sfs_new_logo.png" alt="School Logo" class="invisible-placeholder">
            <div class="header-text invisible-placeholder">
                <h1>ST. FRANCIS' SCHOOL</h1>
                <p>JORETHANG, SOUTH SIKKIM</p>
            </div>
        </div>
    
        <!-- REPORT TITLE -->
        <div class="report-title">
            HALF YEARLY PROGRESS REPORT 2025<br>
            CLASS <?php echo $class_detail['name'] . ' ' . $section_detail['name'] ?>
        </div>
    
        <!-- STUDENT INFO -->
        <div style="padding: 10px;">
            <table class="table" style="padding: 10px;">
                <tr>
                    <td style="width: 33.33%;">
                        <strong>Student No</strong> <?= $student['student_no'] ?>
                    </td>
                    <td style="width: 33.33%;">
                        <strong>Name</strong> <?= $student['name'] ?>
                    </td>
                    <td style="width: 33.33%;">
                        <strong>Class</strong> <?php echo $class_detail['name'] . ' ' . $section_detail['name'] ?>
                    </td>
                </tr>
            </table>
        </div>
    
        <!-- MARKS TABLE -->
        <div style="padding: 10px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: left;">Major Subjects</th>
                        <th class="text-center">UT1 (20)</th>
                        <th class="text-center">MID T (80)</th>
                        <th class="text-center">TOTAL (100)</th>
                        <th class="text-center">HALF YEARLY (100)</th>
                        <th class="text-center">GRADE</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Major Subjects -->
                    <?php foreach ($student['subject_type_ids'] as $id): ?>
                        <?php
                            $subject_name = $student['subjects']["s$id"] ?? 'Subject';
                            $ut1 = $student['unit_test_marks']["s$id"] ?? 0;
                            $mid = $student['mid_term_marks']["s$id"] ?? 0;
                            $total = $student['totals']["s$id"] ?? 0;
                
                            // Grade logic
                            if ($total >= 91)       $grade = '1';
                            elseif ($total >= 81)   $grade = '2';
                            elseif ($total >= 71)   $grade = '3';
                            elseif ($total >= 61)   $grade = '4';
                            elseif ($total >= 51)   $grade = '5';
                            elseif ($total >= 41)   $grade = '6';
                            elseif ($total >= 35)   $grade = '7';
                            elseif ($total >= 25)   $grade = '8';
                            elseif ($total >= 1)    $grade = '9';
                            else                    $grade = '-';
                        ?>
                        <tr>
                            <td><?= $subject_name ?></td>
                            <td class="text-center"><?= $ut1 ?></td>
                            <td class="text-center"><?= $mid ?></td>
                            <td class="text-center"><?= $total ?></td>
                            <td class="text-center"><?= $total ?></td>
                            <td class="text-center"><?= $grade ?></td>
                        </tr>
                    <?php endforeach; ?>
                
                    <!-- Special Subjects Section Title -->
                    <?php if (!empty($student['special_subject_type_ids'])): ?>
                        <tr>
                            <td class="section-title text-left" colspan="10" style="text-align: left;">Special Subjects</td>
                        </tr>
                
                        <!-- Loop over Special Subjects -->
                        <?php foreach ($student['special_subject_type_ids'] as $index => $id): ?>
                            <?php
                                $key = "sps" . ($index + 1);
                                $subject_name = $student['special_subjects'][$key] ?? 'Special Subject';
                                $ut1 = $student['special_unit_test_marks'][$key] ?? 0;
                                $mid = $student['special_mid_term_marks'][$key] ?? 0;
                                $total = $student['special_totals'][$key] ?? 0;
                
                                // Grade logic
                                if ($total >= 91)       $grade = '1';
                                elseif ($total >= 81)   $grade = '2';
                                elseif ($total >= 71)   $grade = '3';
                                elseif ($total >= 61)   $grade = '4';
                                elseif ($total >= 51)   $grade = '5';
                                elseif ($total >= 41)   $grade = '6';
                                elseif ($total >= 35)   $grade = '7';
                                elseif ($total >= 25)   $grade = '8';
                                elseif ($total >= 1)    $grade = '9';
                                else                    $grade = '-';
                            ?>
                            <tr>
                                <td><?= $subject_name ?></td>
                                <td class="text-center"><?= $ut1 ?></td>
                                <td class="text-center"><?= $mid ?></td>
                                <td class="text-center"><?= $total ?></td>
                                <td class="text-center"><?= $total ?></td>
                                <td class="text-center"><?= $grade ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                
                    <!-- Grand Total -->
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="text-center fw-bold">
                            <?= array_sum($student['totals']) + array_sum($student['special_totals'] ?? []) ?>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="evaluation-section">
            <div class="left-panel">
                <p class="section-title mb-2" style="padding: 5px;">PERSONAL EVALUATION</p>
                <table class="table table-bordered minor-subjects-table w-100">
                    <thead>
                        <tr>
                            <th>Minor Subjects</th>
                            <th class="grade-col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($student['minor_subjects'])): ?>
                            <?php foreach ($student['minor_subjects'] as $label => $grade): ?>
                                <tr>
                                    <td><?= htmlspecialchars($label) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($grade) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">No minor subjects available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="right-panel">
                <p class="section-title mb-2" style="padding: 5px;">EVALUATION</p>
                <table class="table table-bordered evaluation-table w-100">
                    <tbody>
                        <tr>
                            <td>RESULT</td>
                            <td>
                                <?php 
                                    if($student['ut1_absent'] > 0 || $student['mid_absent'] > 0) 
                                    {
                                        if($student['ut1_absent'] > 0) {
                                            echo $student['result'];
                                        }
                                        
                                        if($student['mid_absent'] > 0) {
                                            echo "INC";
                                        }
                                    } 
                                    else {
                                        echo $student['result'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>PERCENTAGE</td>
                            <td><?= isset($student['percentage']) ? $student['percentage'] . '%' : '' ?></td>
                        </tr>
                        <tr>
                            <td>RANK</td>
                            <td>
                                <?php 
                                    if($student['ut1_absent'] > 0 || $student['mid_absent'] > 0) 
                                    {
                                        if($student['ut1_absent'] > 0) {
                                            echo "";
                                        }
                                        
                                        if($student['mid_absent'] > 0) {
                                            echo "N/A";
                                        }
                                    } 
                                    else {
                                        echo $student['rank'];
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>ATTENDENCE</td>
                            <td><?= !empty($student['attendence']) ? $student['attendence'] . '%' : '' ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="class-teacher-remark mt-4">
                    <p>CLASS TEACHER'S REMARK</p>
                    <div style="min-height: 40px;">
                        <h6 class="text-center"><?php echo $student['remark'] ?></h6>
                    </div> 
                </div>
            </div>
        </div>

        <div class="principal-signature">
            <img src="https://ignitedsoft.in/stfrancis/assets/sfs_principal_signature.jpg" class="invisible-placeholder" alt="School Logo">
            <br>
            Principal
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>