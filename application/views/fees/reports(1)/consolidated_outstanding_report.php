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
            font-family: Georgia, serif;
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
                    <td><?= number_format($r['school_prev_due'],2); ?></td>
                    <td><?= number_format($r['school_payable'],2); ?></td>
                    <td><?= number_format($r['school_received'],2); ?></td>
                    <td><?= number_format($r['late_fee'],2); ?></td>
                    <td><?= number_format($r['other_charges'],2); ?></td>
                    <td><?= number_format($r['concession'],2); ?></td>
                    <td><?= number_format($r['school_outstanding'],2); ?></td>
                </tr>
            <?php endfor; ?>

            <!-- ===== PAGE TOTAL ===== -->
            <tr class="totals-row">
                <td colspan="6">Page Total</td>
                <td><?= number_format($page_total['school_prev_due'],2); ?></td>
                <td><?= number_format($page_total['school_payable'],2); ?></td>
                <td><?= number_format($page_total['school_received'],2); ?></td>
                <td><?= number_format($page_total['late_fee'],2); ?></td>
                <td><?= number_format($page_total['other_charges'],2); ?></td>
                <td><?= number_format($page_total['concession'],2); ?></td>
                <td><?= number_format($page_total['school_outstanding'],2); ?></td>
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
                <td><?= number_format($grand['school_prev_due'],2); ?></td>
                <td><?= number_format($grand['school_payable'],2); ?></td>
                <td><?= number_format($grand['school_received'],2); ?></td>
                <td><?= number_format($grand['late_fee'],2); ?></td>
                <td><?= number_format($grand['other_charges'],2); ?></td>
                <td><?= number_format($grand['concession'],2); ?></td>
                <td><?= number_format($grand['school_outstanding'],2); ?></td>
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
