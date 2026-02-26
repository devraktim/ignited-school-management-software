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
    $classTitle = $classList[$class_id] . ' ' . $sectionList[$section_id];
} elseif ($class_id) {
    $classTitle = $classList[$class_id];
} else {
    $classTitle = "All Class";
}

// // ==== Get session months from current session ====
// $currentSession = $this->session->academy_session['current_session'];
// $sessionStartMonth = (int)date('n', strtotime($currentSession['start']));
// $sessionEndMonth   = (int)date('n', strtotime($currentSession['end']));

// // Determine session-based month order
// $months_to_show = [];
// if ($sessionStartMonth <= $sessionEndMonth) {
//     // Same year: simple range
//     $months_to_show = range($sessionStartMonth, $sessionEndMonth);
// } else {
//     // Different year: wrap around
//     $months_to_show = array_merge(range($sessionStartMonth, 12), range(1, $sessionEndMonth));
// }

// // Override if user has selected specific months
// // if (!empty($installments)) {
// //     $months_to_show = array_map(function($v){ return (int)preg_replace('/\D/', '', $v); }, $installments);
// //     sort($months_to_show);
// // }

// // Override if month range is provided
// if (!empty($month_from) && !empty($month_to)) {
//     $month_from = (int) $month_from;
//     $month_to   = (int) $month_to;

//     // Ensure valid month numbers (1–12)
//     if ($month_from >= 1 && $month_from <= 12 && 
//         $month_to >= 1 && $month_to <= 12) {

//         if ($month_from <= $month_to) {
//             // Normal range (e.g., 3 to 7)
//             $months_to_show = range($month_from, $month_to);
//         } else {
//             // Cross-year range (e.g., 10 to 3)
//             $months_to_show = array_merge(
//                 range($month_from, 12),
//                 range(1, $month_to)
//             );
//         }
//     }
// }


// ==== Get session months from current session ====
$currentSession     = $this->session->academy_session['current_session'];
$sessionStartMonth  = (int) date('n', strtotime($currentSession['start']));
$sessionEndMonth    = (int) date('n', strtotime($currentSession['end']));

// Build full session month order
if ($sessionStartMonth <= $sessionEndMonth) {
    $sessionMonthsOrder = range($sessionStartMonth, $sessionEndMonth);
} else {
    // Cross-year session (e.g. April to March)
    $sessionMonthsOrder = array_merge(
        range($sessionStartMonth, 12),
        range(1, $sessionEndMonth)
    );
}

// Default: show full session
$months_to_show = $sessionMonthsOrder;


// ==== Override if month range is provided ====
if (!empty($month_from) && !empty($month_to)) {

    $month_from = (int) $month_from;
    $month_to   = (int) $month_to;

    if ($month_from >= 1 && $month_from <= 12 &&
        $month_to >= 1 && $month_to <= 12) {

        // Generate selected range (calendar logic first)
        if ($month_from <= $month_to) {
            $selectedMonths = range($month_from, $month_to);
        } else {
            $selectedMonths = array_merge(
                range($month_from, 12),
                range(1, $month_to)
            );
        }

        // Reorder selected months based on session order
        $months_to_show = array_values(
            array_intersect($sessionMonthsOrder, $selectedMonths)
        );
    }
}



// Title suffix based on months
$title_suffix = (!empty($installments) ? "Selected Months (" . implode(', ', array_map(function($m) {
    return date('M', mktime(0,0,0,$m,10));
}, $months_to_show)) . ")" : " - (" . date('M', mktime(0,0,0,$months_to_show[0],10)) . " - " . date('M', mktime(0,0,0,end($months_to_show),10)) . ")");

?>

<?php 
// Custom function for Indian Number Format with 2 decimal places
function indian_number_format_with_crore($num) {
    $num = (string)$num;
    $arr = explode('.', $num);
    $num = $arr[0];
    $decimal = isset($arr[1]) ? '.' . substr($arr[1], 0, 2) : '.00';
    $len = strlen($num);
    $result = '';
    if ($len > 3) {
        $lastthree = substr($num, $len - 3, 3);
        $len -= 3;
        $result = ',' . $lastthree . $result;
    }
    while ($len > 0) {
        $temp_len = ($len > 2) ? 2 : $len;
        $restunits = substr($num, $len - $temp_len, $temp_len);
        $len -= $temp_len;
        $result = $restunits . $result;
        if ($len > 0) $result = ',' . $result;
    }
    return $result . $decimal;
}
?>

<?php if (!empty($report)) {
    $grandTotals = ['gross'=>0,'prev_due'=>0,'conc'=>0,'net'=>0,'paid'=>0,'outstanding'=>0];
    $grandMonthPayable = array_fill(1, 12, 0);
    $pageTotals = ['gross'=>0,'prev_due'=>0,'conc'=>0,'net'=>0,'paid'=>0,'outstanding'=>0];
    $pageMonthPayable = array_fill(1, 12, 0);
    $rows = 0;

    foreach ($report as $i => $r):
        if ($rows % $rowLimit == 0) {
            if ($rows > 0) { ?>
                <tr style="font-weight:bold; background:#eaeaea;">
                    <td colspan="5">Page Total</td>
                    <?php foreach ($months_to_show as $m): ?>
                        <td><?= indian_number_format_with_crore($pageMonthPayable[$m]); ?></td>
                    <?php endforeach; ?>
                    <td><?= indian_number_format_with_crore($pageTotals['gross']); ?></td>
                    <td><?= indian_number_format_with_crore($pageTotals['prev_due']); ?></td>
                    <td><?= indian_number_format_with_crore($pageTotals['conc']); ?></td>
                    <td><?= indian_number_format_with_crore($pageTotals['net']); ?></td>
                    <td><?= indian_number_format_with_crore($pageTotals['paid']); ?></td>
                    <td><?= indian_number_format_with_crore($pageTotals['outstanding']); ?></td>
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

                        <?php
                        $startYear = date('Y', strtotime($currentSession['start']));
                        $endYear   = date('Y', strtotime($currentSession['end']));
                        $sessionYearDisplay = ($startYear == $endYear) ? $startYear : $startYear . ' - ' . $endYear;
                        ?>

                        <div class="BigHeader">
                            <?= $classTitle ?> <?= $title_suffix ?> Collection - Session <?= $sessionYearDisplay ?>
                        </div>
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
        <?php } ?>

        <tr>
            <td><?= $i+1 ?></td>
            <td><?= $r['student_no']; ?></td>
            <td class="Tdl"><?= htmlspecialchars($r['student_name']); ?></td>
            <td><?= $r['class_name'].' '.$r['section_name']; ?></td>
            <td><?= $r['student_type']; ?></td>

            <?php foreach($months_to_show as $m): 
                $val = isset($r['monthly_payable'][$m]) ? (float)$r['monthly_payable'][$m] : 0;
            ?>
                <td><?= indian_number_format_with_crore($val); ?></td>
            <?php 
                $pageMonthPayable[$m] += $val;
                $grandMonthPayable[$m] += $val;
            endforeach; ?>

            <td><?= indian_number_format_with_crore($r['gross_payable']); ?></td>
            <td><?= indian_number_format_with_crore($r['previous_due']); ?></td>
            <td><?= indian_number_format_with_crore($r['concession']); ?></td>
            <?php 
                $net_payable = ($r['gross_payable'] + $r['previous_due']) - $r['concession'];
            ?>
            <td><?= indian_number_format_with_crore($net_payable); ?></td>
            <td><?= indian_number_format_with_crore($r['paid']); ?></td>
            <td><?= indian_number_format_with_crore($r['outstanding']); ?></td>
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
        <td><?= indian_number_format_with_crore($pageMonthPayable[$m]); ?></td>
    <?php endforeach; ?>
    <td><?= indian_number_format_with_crore($pageTotals['gross']); ?></td>
    <td><?= indian_number_format_with_crore($pageTotals['prev_due']); ?></td>
    <td><?= indian_number_format_with_crore($pageTotals['conc']); ?></td>
    <td><?= indian_number_format_with_crore($pageTotals['net']); ?></td>
    <td><?= indian_number_format_with_crore($pageTotals['paid']); ?></td>
    <td><?= indian_number_format_with_crore($pageTotals['outstanding']); ?></td>
</tr>

<tr style="font-weight:bold; border-top:2px solid #000;">
    <td colspan="5">Grand Total</td>
    <?php foreach ($months_to_show as $m): ?>
        <td><?= indian_number_format_with_crore($grandMonthPayable[$m]); ?></td>
    <?php endforeach; ?>
    <td><?= indian_number_format_with_crore($grandTotals['gross']); ?></td>
    <td><?= indian_number_format_with_crore($grandTotals['prev_due']); ?></td>
    <td><?= indian_number_format_with_crore($grandTotals['conc']); ?></td>
    <td><?= indian_number_format_with_crore($grandTotals['net']); ?></td>
    <td><?= indian_number_format_with_crore($grandTotals['paid']); ?></td>
    <td><?= indian_number_format_with_crore($grandTotals['outstanding']); ?></td>
</tr>

</tbody></table>

<?php } else { ?>
    <p style="text-align:center; margin-top:50px;">No records found for selected filters.</p>
<?php } ?>

</body>
</html>
