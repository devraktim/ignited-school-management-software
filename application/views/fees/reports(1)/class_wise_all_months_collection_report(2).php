<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        @media print {
            @page { size: A4; margin: 12mm; }
            .page-break { page-break-after: always; }
        }
        body { font-size: 11px; margin: 10px; }
        .BigHeader { text-align:center; font-weight:bold; font-size:16pt; margin-bottom:10px; }

        .GridTable {
            width: 98%;
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid #000;
            font-size: 10pt;
        }
        .GridTable th, .GridTable td {
            border: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
            white-space: nowrap;
        }
        .GridTable th { background: #f0f0f0; font-variant: small-caps; }
        .Tdr { text-align: right; }
        .Tdl { text-align: left; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

<?php 
$school_name = "St. Francis School";
$branch = "Jorethang";
$rowLimit = 30;

// ==== Dynamic Month Logic ==== 
$month_from = isset($_GET['month_from']) && is_numeric($_GET['month_from']) ? (int)$_GET['month_from'] : 1;
$month_to   = isset($_GET['month_to']) && is_numeric($_GET['month_to']) ? (int)$_GET['month_to'] : 12;
$installments = isset($_GET['installment']) ? $_GET['installment'] : [];

// Incoming filters for class_id and section_id
$class_id    = isset($_GET['class_id']) && is_numeric($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$section_id  = isset($_GET['section_id']) && is_numeric($_GET['section_id']) ? (int)$_GET['section_id'] : 0;

// Convert class array to lookup: id => name
$classList = [];
foreach ($classes as $c) {
    $classList[$c['id']] = $c['name'];
}

// Convert section array to lookup: id => name
$sectionList = [];
foreach ($sections as $s) {
    $sectionList[$s['id']] = $s['name'];
}

// Dynamic Title Logic for Class & Section
if ($class_id && $section_id) {
    // Class + Section
    $classTitle = $classList[$class_id] . ' ' . $sectionList[$section_id];
}
elseif ($class_id) {
    // Only Class selected
    $classTitle = $classList[$class_id];
}
else {
    // No Class selected
    $classTitle = "All Class";
}

// Determine the months to show
if (!empty($installments)) {
    $months_to_show = array_map(function($v){ return (int)preg_replace('/\D/', '', $v); }, $installments);
    sort($months_to_show);
    $title_suffix = "Selected Months (" . implode(', ', array_map(function($m) {
        return date('M', mktime(0,0,0,$m,10));
    }, $months_to_show)) . ")";
}
elseif (!empty($month_from) && !empty($month_to) && ($month_from != 1 || $month_to != 12)) {
    $months_to_show = range($month_from, $month_to);
    $title_suffix = " - (" . date('M', mktime(0,0,0,$month_from,10)) . " - " . date('M', mktime(0,0,0,$month_to,10)) . ")";
} else {
    $months_to_show = range(1, 12);
    $title_suffix = " - All Months";
}
?>

<?php if (!empty($report)) {
    $grandTotals = ['gross'=>0,'prev_due'=>0,'conc'=>0,'net'=>0,'paid'=>0,'outstanding'=>0];
    $grandMonthPayable = array_fill(1, 12, 0);

    $pageTotals = ['gross'=>0,'prev_due'=>0,'conc'=>0,'net'=>0,'paid'=>0,'outstanding'=>0];
    $pageMonthPayable = array_fill(1, 12, 0);
    $rows = 0;

    foreach ($report as $i => $r):
        // === PAGE START ===
        if ($rows % $rowLimit == 0) {
            if ($rows > 0) { ?>
                <tr style="font-weight:bold; background:#eaeaea;">
                    <td colspan="5">Page Total</td>
                    <?php foreach ($months_to_show as $m): ?>
                        <td><?= number_format($pageMonthPayable[$m], 2); ?></td>
                    <?php endforeach; ?>
                    <td><?= number_format($pageTotals['gross'],2); ?></td>
                    <td><?= number_format($pageTotals['prev_due'],2); ?></td>
                    <td><?= number_format($pageTotals['conc'],2); ?></td>
                    <td><?= number_format($pageTotals['net'],2); ?></td>
                    <td><?= number_format($pageTotals['paid'],2); ?></td>
                    <td><?= number_format($pageTotals['outstanding'],2); ?></td>
                </tr>
                </tbody></table>
                <div class="page-break"></div>
            <?php 
                $pageTotals = ['gross'=>0,'prev_due'=>0,'conc'=>0,'net'=>0,'paid'=>0,'outstanding'=>0];
                $pageMonthPayable = array_fill(1, 12, 0);
            } ?>

            <!-- ====== PAGE HEADER ====== -->
            <table style="width:98%; border-collapse:collapse; margin:10px auto;">
                <tr>
                    <td style="width:20%; text-align:left;">
                        <img src="<?= base_url('assets/media/logos/logol.png') ?>" height="60">
                    </td>
                    <td style="text-align:center;">
                        <div style="font-family:Arial; font-size:22pt;"><?= $school_name ?></div>
                        <div style="font-size:11pt; font-style:italic;"><?= $branch ?></div>
                        <div class="BigHeader"><?= $classTitle ?> <?= $title_suffix ?> Collection - Session 2025</div>
                    </td>
                    <td style="width:20%; text-align:right;">
                        <img src="<?= base_url('assets/media/logos/logol.png') ?>" height="60">
                    </td>
                </tr>
            </table>

            <table class="GridTable">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Student No</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Class & Section</th>
                        <th rowspan="2">Std Type</th>
                        <th colspan="<?= count($months_to_show); ?>">Fee Details by Month</th>
                        <th rowspan="2">Gross Payable</th>
                        <th rowspan="2">Prev. Due</th>
                        <th rowspan="2">Conc.</th>
                        <th rowspan="2">Net Payable</th>
                        <th rowspan="2">Paid</th>
                        <th rowspan="2">Outstanding</th>
                    </tr>
                    <tr>
                        <?php foreach($months_to_show as $m): ?>
                            <th><?= date('M', mktime(0,0,0,$m,10)); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
        <?php } // end table header ?>

        <tr>
            <td><?= $i+1 ?></td>
            <td><?= $r['student_no']; ?></td>
            <td class="Tdl"><?= htmlspecialchars($r['student_name']); ?></td>
            <td><?= $r['class_name'].' '.$r['section_name']; ?></td>
            <td><?= $r['student_type']; ?></td>

            <?php foreach($months_to_show as $m): 
                $p = $r['monthly_payable'][$m];
                $val = is_numeric($p) ? (float)$p : 0;
            ?>
                <td><?= number_format($val, 2); ?></td>
            <?php 
                $pageMonthPayable[$m] += $val;
                $grandMonthPayable[$m] += $val;
            endforeach; ?>

            <td><?= number_format($r['gross_payable'],2); ?></td>
            <td><?= number_format($r['previous_due'],2); ?></td>
            <td><?= number_format($r['concession'],2); ?></td>
            <?php 
                $net_payable = ($r['gross_payable'] + $r['previous_due']) - $r['concession'];
            ?>
            <td><?= number_format($net_payable,2); ?></td>
            <td><?= number_format($r['paid'],2); ?></td>
            <td><?= number_format($r['outstanding'],2); ?></td>
        </tr>

        <?php
        // Accumulate totals
        $pageTotals['gross'] += $r['gross_payable'];
        $pageTotals['prev_due'] += $r['previous_due'];
        $pageTotals['conc'] += $r['concession'];
        $pageTotals['net'] += $net_payable;
        $pageTotals['paid'] += $r['paid'];
        $pageTotals['outstanding'] += $r['outstanding'];

        $grandTotals['gross'] += $r['gross_payable'];
        $grandTotals['prev_due'] += $r['previous_due'];
        $grandTotals['conc'] += $r['concession'];
        $grandTotals['net'] += $net_payable;
        $grandTotals['paid'] += $r['paid'];
        $grandTotals['outstanding'] += $r['outstanding'];

        $rows++;
    endforeach;
?>

<tr style="font-weight:bold; background:#eaeaea;">
    <td colspan="5">Page Total</td>
    <?php foreach ($months_to_show as $m): ?>
        <td><?= number_format($pageMonthPayable[$m], 2); ?></td>
    <?php endforeach; ?>
    <td><?= number_format($pageTotals['gross'],2); ?></td>
    <td><?= number_format($pageTotals['prev_due'],2); ?></td>
    <td><?= number_format($pageTotals['conc'],2); ?></td>
    <td><?= number_format($pageTotals['net'],2); ?></td>
    <td><?= number_format($pageTotals['paid'],2); ?></td>
    <td><?= number_format($pageTotals['outstanding'],2); ?></td>
</tr>

<tr style="font-weight:bold; border-top:2px solid #000;">
    <td colspan="5">Grand Total</td>
    <?php foreach ($months_to_show as $m): ?>
        <td><?= number_format($grandMonthPayable[$m], 2); ?></td>
    <?php endforeach; ?>
    <td><?= number_format($grandTotals['gross'],2); ?></td>
    <td><?= number_format($grandTotals['prev_due'],2); ?></td>
    <td><?= number_format($grandTotals['conc'],2); ?></td>
    <td><?= number_format($grandTotals['net'],2); ?></td>
    <td><?= number_format($grandTotals['paid'],2); ?></td>
    <td><?= number_format($grandTotals['outstanding'],2); ?></td>
</tr>

</tbody></table>

<?php } else { ?>
    <p style="text-align:center; margin-top:50px;">No records found for selected filters.</p>
<?php } ?>

</body>
</html>
