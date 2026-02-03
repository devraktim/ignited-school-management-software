<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Personnel Wise Fees Collection</title>
<style>
@media print {
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }
    body { margin: 0; }
    .page-break { page-break-before: always; }
}

.BigHeader {
    text-align: center;
    font-family: 'MS Sans Serif', Serif;
    font-weight: bold;
    font-size: 16pt;
    margin-top: 10px;
}

.GridTable {
    border: 2px #000 solid;
    border-collapse: collapse;
    width: 94%;
    margin: 0 auto;
    margin-top: 20px;
}

.GridTable colgroup col:nth-child(1) { width: 3%; }
.GridTable colgroup col:nth-child(2) { width: 8%; }
.GridTable colgroup col:nth-child(3) { width: 18%; }
.GridTable colgroup col:nth-child(4) { width: 8%; }
.GridTable colgroup col:nth-child(5) { width: 6%; }
.GridTable colgroup col:nth-child(6) { width: 8%; }
.GridTable colgroup col:nth-child(7) { width: 9%; }
.GridTable colgroup col:nth-child(8) { width: 7%; }
.GridTable colgroup col:nth-child(9) { width: 7%; }
.GridTable colgroup col:nth-child(10){ width: 6%; }
.GridTable colgroup col:nth-child(11){ width: 7%; }
.GridTable colgroup col:nth-child(12){ width: 6%; }
.GridTable colgroup col:nth-child(13){ width: 7%; }
.GridTable colgroup col:nth-child(14){ width: 8%; }
.GridTable colgroup col:nth-child(15){ width: 10%; }

.GridTable th {
    border: 1px #000 solid;
    padding: 5px;
    font-family: "Times New Roman", Georgia;
    font-size: 10pt;
    font-weight: bold;
    font-variant: small-caps;
    background: #EEE;
    color: #000;
    text-align: center;
    white-space: nowrap;
}

.GridTable td {
    border: 1px #000 solid;
    padding: 4px 5px;
    font-family: "Courier New", Arial;
    font-size: 10pt;
    white-space: nowrap;
}
.Tdc { text-align: center; }
.Tdr { text-align: right; }
.Tdl { text-align: left; }
</style>
</head>

<body>
<?php
$school_name = "St. Francis School";
$branch = "Jorethang";
$session_year = date('Y', strtotime($this->session->academy_session['current_session']['start'] ?? date('Y-m-d')));
$sl_no = 1;

$grand_totals = [
    'gross_amount'       => 0,
    'previous_year_due'  => 0,
    'late_fine'          => 0,
    'other_charges'      => 0,
    'concession'         => 0,
    'net_amount'         => 0,
];

$chunks = array_chunk($report, 25);
?>

<?php if (empty($report)): ?>
    <!-- No Data Found Message -->
    <div style="text-align:center; font-size:20px; padding:50px; background:#f7f7f7; border:1px solid #ccc; margin:50px auto; width:80%; color:#d9534f; font-weight:bold;">
        No Data Found
    </div>
<?php else: ?>
    <?php foreach ($chunks as $chunk_index => $chunk): ?>

        <?php if ($chunk_index > 0): ?>
            <div class="page-break"></div>
        <?php endif; ?>

        <!-- ====== Report Header ====== -->
        <table style="width:98%; border-collapse:collapse; margin:10px auto; border-bottom:2px solid #000;">
            <tbody>
                <tr>
                    <td rowspan="2" style="vertical-align:top;">
                        <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
                    </td>
                    <td style="text-align:center; vertical-align:top;">
                        <div style="font-family:Arial; font-size:28pt;"><?= $school_name ?></div>
                    </td>
                    <td rowspan="2" style="text-align:right; vertical-align:top;">
                        <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-family:Arial; font-size:10pt; font-style:italic;"><?= $branch ?></td>
                </tr>
            </tbody>
        </table>

        <div class="BigHeader" style="width:90%; margin:0 auto; margin-top:15px;">
            School Fees Collection Report – By <br> Rahul Saha <br> From: <?= date('d-m-y', strtotime($filters['from_date'] ?? '')) ?> To: <?= date('d-m-y', strtotime($filters['to_date'] ?? '')) ?>
        </div>

        <!-- ====== Main Report Table ====== -->
        <table class="GridTable">
        <colgroup>
            <?php for($i=0;$i<15;$i++): ?><col><?php endfor; ?>
        </colgroup>

        <thead>
            <tr>
                <th>Sl</th>
                <th>Student No</th>
                <th>Student Name</th>
                <th>Class/Sec</th>
                <th>R.No</th>
                <th>R.Date</th>
                <th>P.Period</th>
                <th>Gross</th>
                <th>Pr.Yr.Due</th>
                <th>L.Fine</th>
                <th>O.Charges</th>
                <th>Conc</th>
                <th>Net</th>
                <th>Pay.Mode</th>
                <th>Details</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $page_totals = [
            'gross_amount'       => 0,
            'previous_year_due'  => 0,
            'late_fine'          => 0,
            'other_charges'      => 0,
            'concession'         => 0,
            'net_amount'         => 0,
        ];

        if (!empty($chunk)): 
            foreach ($chunk as $row): 
                foreach ($page_totals as $key => $v) {
                    $page_totals[$key] += $row[$key];
                    $grand_totals[$key] += $row[$key];
                }
        ?>
        <tr>
            <td class="Tdc"><?= $sl_no++; ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['student_no']); ?></td>
            <td class="Tdl"><?= htmlspecialchars($row['student_name']); ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['class_name'].'/'.$row['section_name']); ?></td>
            <td class="Tdc"><?= htmlspecialchars($row['receipt_id']); ?></td>
            <td class="Tdc"><?= date('d-m-Y', strtotime($row['receipt_date'])); ?></td>
            <td class="Tdl">
                <?php
                if (!empty($row['pay_period'])) {
                    $months = array_map('trim', explode(',', $row['pay_period']));
                    $monthNames = array_map(function($m) {
                        $m = (int)$m;
                        return date('M', mktime(0, 0, 0, $m, 10));
                    }, $months);
                    echo implode(', ', $monthNames);
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td class="Tdr"><?= number_format($row['gross_amount'],2); ?></td>
            <td class="Tdr"><?= number_format($row['previous_year_due'],2); ?></td>
            <td class="Tdr"><?= number_format($row['late_fine'],2); ?></td>
            <td class="Tdr"><?= number_format($row['other_charges'],2); ?></td>
            <td class="Tdr"><?= number_format($row['concession'],2); ?></td>
            <td class="Tdr" style="font-weight:bold;"><?= number_format($row['net_amount'],2); ?></td>
            <td class="Tdc"><?= ucfirst(str_replace('_',' ',$row['payment_method'])); ?></td>
            <td class="Tdl"><?= htmlspecialchars($row['details'] ?? '-'); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr><td colspan="15" class="Tdc" style="color:red;">No records found</td></tr>
        <?php endif; ?>
        </tbody>

        <tfoot>
        <tr style="font-weight:bold;">
            <td colspan="7" class="Tdr">Page Total :</td>
            <td class="Tdr"><?= number_format($page_totals['gross_amount'],2); ?></td>
            <td class="Tdr"><?= number_format($page_totals['previous_year_due'],2); ?></td>
            <td class="Tdr"><?= number_format($page_totals['late_fine'],2); ?></td>
            <td class="Tdr"><?= number_format($page_totals['other_charges'],2); ?></td>
            <td class="Tdr"><?= number_format($page_totals['concession'],2); ?></td>
            <td class="Tdr"><?= number_format($page_totals['net_amount'],2); ?></td>
            <td class="Tdc">&nbsp;</td>
            <td class="Tdc">&nbsp;</td>
        </tr>

        <?php if ($chunk_index === count($chunks) - 1): ?>
            <!-- Grand Total for the last page -->
            <tr style="font-weight:bold; background:#f7f7f7;">
                <td colspan="7" class="Tdr">Grand Total :</td>
                <td class="Tdr"><?= number_format($grand_totals['gross_amount'],2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['previous_year_due'],2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['late_fine'],2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['other_charges'],2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['concession'],2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['net_amount'],2); ?></td>
                <td class="Tdc">&nbsp;</td>
                <td class="Tdc">&nbsp;</td>
            </tr>
        <?php endif; ?>

        </tfoot>
        </table>

    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>
