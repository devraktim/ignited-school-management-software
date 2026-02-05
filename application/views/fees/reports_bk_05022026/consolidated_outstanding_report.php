<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        body {
            font-size: 10pt;
            margin: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            page-break-inside: auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
        }
        th {
            background: #eee;
            font-weight: bold;
        }
        .BigHeader {
            text-align: center;
            font-size: 16pt;
            margin-bottom: 10px;
        }
        .Tdl {
            text-align: left;
        }
        .page-break {
            page-break-after: always;
        }
        .totals-row {
            background: #f0f0f0;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            font-size: 20px;
            padding: 50px;
            background: #f7f7f7;
            border: 1px solid #ccc;
            margin: 50px auto;
            width: 80%;
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php 
    // Custom function for Indian Number Format with 2 decimal places
    function indian_number_format_with_crore($num) {
        $num = (string)$num; // Convert to string
        $arr = explode('.', $num); // Separate the number and the decimal part
        $num = $arr[0]; // Get the integer part
        $decimal = isset($arr[1]) ? '.' . substr($arr[1], 0, 2) : ''; // Get the decimal part and limit it to 2 decimal places
    
        // Ensure the number has 2 decimal points (even if the original number doesn't have decimals)
        if ($decimal === '') {
            $decimal = '.00';
        } else {
            $decimal = rtrim($decimal, '0'); // Remove trailing zeros if there are any
            if (strlen($decimal) < 3) {
                $decimal = str_pad($decimal, 3, '0'); // Ensure 2 decimal places
            }
        }
    
        $len = strlen($num);
        $result = '';
        $i = 0;
    
        // Separate the last three digits
        if ($len > 3) {
            $lastthree = substr($num, $len - 3, 3);
            $len -= 3;
            $result = ',' . $lastthree . $result;
        }
    
        // Explode the remaining digits in 2's format
        while ($len > 0) {
            $temp_len = ($len > 2) ? 2 : $len;
            $restunits = substr($num, $len - $temp_len, $temp_len);
            $len -= $temp_len;
            $result = $restunits . $result;
            if ($len > 0) {
                $result = ',' . $result;
            }
        }
    
        // Return the formatted number with the decimal part
        return $result . $decimal;
    }
?>

<?php 
$school_name = "St. Francis School";
$branch = "Jorethang";
$total_rows = count($report);
?>

<?php if ($total_rows == 0): ?>
    <div class="no-data">
        No Data Found
    </div>
<?php else: ?>
    <?php
    $rows_per_page = 30;
    $total_pages = ceil($total_rows / $rows_per_page);

    // Initialize grand totals
    $grand = [
        'school_prev_due' => 0,
        'school_payable' => 0,
        'payable_total' => 0,
        'school_received' => 0,
        'late_fee' => 0,
        'other_charges' => 0,
        'concession' => 0,
        'received_total' => 0,
        'school_outstanding' => 0,
        'outstanding_total' => 0
    ];
    ?>

    <?php for($page = 0; $page < $total_pages; $page++): ?>
        <!-- ===== HEADER ===== -->
        <table style="width:98%; border-collapse:collapse; margin:10px auto; border-bottom:2px solid #000;">
            <tbody>
                <tr>
                    <td rowspan="2" style="vertical-align:top; border:none;">
                        <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
                    </td>
                    <td style="text-align:center; vertical-align:top; border:none;">
                        <div style="font-family:Arial; font-size:28pt;"><?= $school_name ?></div>
                    </td>
                    <td rowspan="2" style="text-align:right; vertical-align:top; border:none;">
                        <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-family:Arial; font-size:10pt; font-style:italic; border:none;">
                        <?= $branch ?> | Page <?= ($page+1) ?> of <?= $total_pages ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="BigHeader">Consolidated Outstanding Report<br>As on <?= date('d-M-Y'); ?></div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Std No</th>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Class/Sec</th>
                    <th rowspan="2">Std Type</th>
                    <th rowspan="2">Phone</th>
                    <th rowspan="2">Prev Yr. Due</th>
                    <th rowspan="2">School Fees</th>
                    <th colspan="4">Total Received</th>
                    <th rowspan="2">Outstanding</th>
                </tr>
                <tr>
                    <th>School</th>
                    <th>L Fee</th>
                    <th>O/Chgs</th>
                    <th>Conc</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $start = $page * $rows_per_page;
            $end = min($start + $rows_per_page, $total_rows);

            // Initialize page totals
            $page_total = $grand;
            $sl = $start + 1;

            for($i = $start; $i < $end; $i++):
                $r = $report[$i];

                // Add to page totals
                foreach ($page_total as $key => $val) {
                    $page_total[$key] += $r[$key];
                }
            ?>
                <tr>
                    <td><?= $sl++; ?></td>
                    <td><?= $r['student_no']; ?></td>
                    <td class="Tdl"><?= htmlspecialchars($r['student_name']); ?></td>
                    <td><?= $r['class_sec']; ?></td>
                    <td><?= $r['student_type']; ?></td>
                    <td><?= htmlspecialchars($r['phone']); ?></td>
                    <td><?= indian_number_format_with_crore($r['school_prev_due']); ?></td>
                    <td><?= indian_number_format_with_crore($r['school_payable']); ?></td>
                    <td><?= indian_number_format_with_crore($r['school_received']); ?></td>
                    <td><?= indian_number_format_with_crore($r['late_fee']); ?></td>
                    <td><?= indian_number_format_with_crore($r['other_charges']); ?></td>
                    <td><?= indian_number_format_with_crore($r['concession']); ?></td>
                    <td><?= indian_number_format_with_crore($r['school_outstanding']); ?></td>
                </tr>
            <?php endfor; ?>

            <!-- ===== PAGE TOTAL ===== -->
            <tr class="totals-row">
                <td colspan="6">Page Total</td>
                <td><?= indian_number_format_with_crore($page_total['school_prev_due']); ?></td>
                <td><?= indian_number_format_with_crore($page_total['school_payable']); ?></td>
                <td><?= indian_number_format_with_crore($page_total['school_received']); ?></td>
                <td><?= indian_number_format_with_crore($page_total['late_fee']); ?></td>
                <td><?= indian_number_format_with_crore($page_total['other_charges']); ?></td>
                <td><?= indian_number_format_with_crore($page_total['concession']); ?></td>
                <td><?= indian_number_format_with_crore($page_total['school_outstanding']); ?></td>
            </tr>

            <!-- ===== GRAND TOTAL (LAST PAGE ONLY) ===== -->
            <?php
                foreach ($grand as $key => $val) {
                    $grand[$key] += $page_total[$key];
                }
            ?>
            <?php if ($page == $total_pages - 1): ?>
            <tr class="totals-row">
                <td colspan="6">Grand Total</td>
                <td><?= indian_number_format_with_crore($grand['school_prev_due']); ?></td>
                <td><?= indian_number_format_with_crore($grand['school_payable']); ?></td>
                <td><?= indian_number_format_with_crore($grand['school_received']); ?></td>
                <td><?= indian_number_format_with_crore($grand['late_fee']); ?></td>
                <td><?= indian_number_format_with_crore($grand['other_charges']); ?></td>
                <td><?= indian_number_format_with_crore($grand['concession']); ?></td>
                <td><?= indian_number_format_with_crore($grand['school_outstanding']); ?></td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <?php if ($page < $total_pages - 1): ?>
            <div class="page-break"></div>
        <?php endif; ?>

    <?php endfor; ?>
<?php endif; ?>

</body>
</html>
