<!DOCTYPE html>
<html>
<head>
    <title>Fee Head Wise Collection Report</title>
    <style>
    .BigHeader {
        text-align: center;
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        font-size: 18pt;
        margin-top: 20px;
        color: #333;
        padding: 15px 0;
    }
    
    .BigHeader span {
        font-size: 12pt;
        font-weight: normal;
        color: #555;
    }
    
    /* ======= Table ======= */
    .GridTable {
        border: 2px #000 solid;
        border-collapse: collapse;
        width: 94%;
        margin: 0 auto;
        margin-top: 30px;
    }
    
    /* ======= Table Header ======= */
    .GridTable th.thl,
    .GridTable th.thc,
    .GridTable th.thr {
        border: 1px #000 solid;
        padding: 5px;
        font-family: "Times New Roman", Georgia;
        font-size: 10pt;
        font-weight: bold;
        font-variant: small-caps;
        background: #EEE;
        color: #000;
        white-space: nowrap; /* ✅ Keep header text in one line */
    }
    
    .GridTable th.thc { text-align: center; }
    .GridTable th.thl { text-align: left; }
    .GridTable th.thr { text-align: right; }
    
    /* ======= Table Data ======= */
    .GridTable td {
        border: 1px #000 solid;
        padding: 4px 5px;
        font-family: "Courier New", Arial;
        font-size: 10pt;
        white-space: nowrap; /* ✅ Keep all cell text in one line */
    }
    
    .GridTable td.Tdc { text-align: center; }
    .GridTable td.Tdr { text-align: right; }
    .GridTable td.Tdl { text-align: left; }
    
    @media print {
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
        body { margin: 0; }
        .page-break { page-break-before: always; }
    }
    
    /* No Data Found style */
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

<?php if (empty($chunks)): ?>
    <!-- No data message if $chunks is empty -->
    <div class="no-data">
        No Data Found
    </div>
<?php else: ?>

<?php 
$school_name = "St. Francis School";
$branch = "Jorethang";
$sl = 1; 
$fee_heads = isset($fee_heads) ? $fee_heads : [];
$grand_totals = [
    'previous_year_due'  => 0,
    'gross_amount'       => 0,
    'other_charges'      => 0,
    'late_fine'          => 0,
    'concession'         => 0,
    'net_amount'         => 0
];

// Initialize grand totals for each fee head
foreach ($fee_heads as $head) {
    $grand_totals[$head['name']] = 0;
}
?>

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

    <div class="BigHeader">
        Fee Head Wise Collection Report
        <br>
        <span>
            From: <?= date('d-m-y', strtotime($filters['from_date'] ?? '')) ?> 
            To: <?= date('d-m-y', strtotime($filters['to_date'] ?? '')) ?>
        </span>
    </div>

    <br>

    <!-- ====== Report Table ====== -->
    <table class="GridTable" style="width:94%; margin:0 auto;">
        <thead>
            <tr>
                <th class="thc">Sl</th>
                <th class="thc">Std No</th>
                <th class="thl">Student Name</th>
                <th class="thc">Class/Sec</th>
                <th class="thc">Std/Type</th>
                <th class="thc">R. No.</th>
                <th class="thc">R. Date</th>
                <?php foreach ($fee_heads as $head): ?>
                    <th class="thc"><?= htmlspecialchars($head['name']); ?></th>
                <?php endforeach; ?>
                <th class="thc">Pr. Yr. Due</th>
                <th class="thc">Gross</th>
                <th class="thc">O/Chg</th>
                <th class="thc">L/Fine</th>
                <th class="thc">Conc</th>
                <th class="thr">Net</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $page_totals = [
                'previous_year_due'  => 0,
                'gross_amount'       => 0,
                'other_charges'      => 0,
                'late_fine'          => 0,
                'concession'         => 0,
                'net_amount'         => 0
            ];

            // Initialize page totals for each fee head
            foreach ($fee_heads as $head) {
                $page_totals[$head['name']] = 0;
            }

            if (!empty($chunk)): 
                foreach ($chunk as $row): 
                    foreach ($page_totals as $key => $value) {
                        $page_totals[$key] += $row[$key];
                        $grand_totals[$key] += $row[$key];
                    }
                    // Adding fee head totals dynamically
                    foreach ($fee_heads as $head) {
                        $head_name = $head['name'];
                        $amount = isset($row['fee_heads'][$head_name]) ? $row['fee_heads'][$head_name] : 0;
                        $page_totals[$head_name] += $amount;
                        $grand_totals[$head_name] += $amount;
                    }
            ?>
            <tr>
                <td class="Tdc"><?= $sl++ ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['student_no']); ?></td>
                <td class="Tdl"><?= htmlspecialchars($row['student_name']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['class_name'].'/'.$row['section_name']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['student_type']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['receipt_id']); ?></td>
                <td class="Tdc"><?= date('d-m-Y', strtotime($row['receipt_date'])); ?></td>

                <!-- Dynamic Fee Head columns -->
                <?php foreach ($fee_heads as $head): 
                    $head_name = $head['name'];
                    $amount = isset($row['fee_heads'][$head_name]) ? $row['fee_heads'][$head_name] : 0; ?>
                    <td class="Tdr"><?= number_format($amount, 2); ?></td>
                <?php endforeach; ?>

                <td class="Tdr"><?= number_format($row['previous_year_due'], 2); ?></td>
                <td class="Tdr"><?= number_format($row['gross_amount'], 2); ?></td>
                <td class="Tdr"><?= number_format($row['other_charges'], 2); ?></td>
                <td class="Tdr"><?= number_format($row['late_fine'], 2); ?></td>
                <td class="Tdr"><?= number_format($row['concession'], 2); ?></td>
                <td class="Tdr" style="font-weight:bold;"><?= number_format($row['net_amount'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="<?= 13 + count($fee_heads) ?>" class="Tdc" style="color:red;">No Records Found</td>
            </tr>
            <?php endif; ?>
        </tbody>

        <!-- Page Total Row -->
        <tfoot>
            <tr style="font-weight:bold; background:#f7f7f7;">
                <td colspan="7" class="Tdr">Page Total:</td>
                <?php foreach ($fee_heads as $head): ?>
                    <td class="Tdr"><?= number_format($page_totals[$head['name']], 2); ?></td>
                <?php endforeach; ?>
                <td class="Tdr"><?= number_format($page_totals['previous_year_due'], 2); ?></td>
                <td class="Tdr"><?= number_format($page_totals['gross_amount'], 2); ?></td>
                <td class="Tdr"><?= number_format($page_totals['other_charges'], 2); ?></td>
                <td class="Tdr"><?= number_format($page_totals['late_fine'], 2); ?></td>
                <td class="Tdr"><?= number_format($page_totals['concession'], 2); ?></td>
                <td class="Tdr"><?= number_format($page_totals['net_amount'], 2); ?></td>
            </tr>

            <?php if ($chunk_index === count($chunks) - 1): ?>
            <!-- Grand Total (only on the last chunk) -->
            <tr style="font-weight:bold; background:#f7f7f7;">
                <td colspan="7" class="Tdr">Grand Total:</td>
                <?php foreach ($fee_heads as $head): ?>
                    <td class="Tdr"><?= number_format($grand_totals[$head['name']], 2); ?></td>
                <?php endforeach; ?>
                <td class="Tdr"><?= number_format($grand_totals['previous_year_due'], 2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['gross_amount'], 2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['other_charges'], 2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['late_fine'], 2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['concession'], 2); ?></td>
                <td class="Tdr"><?= number_format($grand_totals['net_amount'], 2); ?></td>
            </tr>
            <?php endif; ?>
        </tfoot>
    </table>

<?php endforeach; ?>

<?php endif; ?>
</body>
</html>
