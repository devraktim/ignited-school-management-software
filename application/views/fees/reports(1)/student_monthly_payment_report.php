<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-size: 11px; margin: 10px; }
        table { border-collapse: collapse; width: 95%; margin: 10px auto; }
        th, td { border: 1px solid #000; padding: 4px 6px; text-align: center; }
        th { background: #eee; text-transform: uppercase; }
        h2 { text-align: center; font-size: 14pt; margin-top: 20px; }
        .BigHeader { text-align:center; font-weight:bold; font-size:16pt; margin-bottom:10px; }
        .Tdr { text-align:right; }
    </style>
</head>
<body>
    
<?php 
$school_name = "St. Francis School";
$branch = "Jorethang";
?>

<!-- ===== Report Header ===== -->
<table style="width:98%; border-collapse:collapse; margin:10px auto; border-bottom:2px solid #000;">
    <tbody>
        <tr>
            <td rowspan="2" style="vertical-align:top; border: none;">
                <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
            </td>
            <td style="text-align:center; vertical-align:top; border: none;">
                <div style="font-family:Arial; font-size:28pt;"><?= $school_name ?></div>
            </td>
            <td rowspan="2" style="text-align:right; vertical-align:top; border: none;">
                <img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; font-family:Arial; font-size:10pt; font-style:italic; border: none;"><?= $branch ?></td>
        </tr>
    </tbody>
</table>

<div class="BigHeader">
    Student No. <?php echo $student['student_no'] ?>&nbsp;&nbsp;&nbsp;&nbsp;Class/ Section. <?php echo $student['student_session_class_name'] . '/A' ?>&nbsp;&nbsp;&nbsp;&nbsp;Student Type. <?php echo $student['student_type'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <br> <br>
    Name. <?php echo $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name']?>&nbsp;&nbsp;&nbsp;&nbsp;Roll No. <?php echo $student['roll_no'] ?>
</div>
<hr>

<!-- ========== 1️⃣ TOTAL AMOUNT PAYABLE ========== -->
<h2>TOTAL AMOUNT PAYABLE</h2>
<table>
    <thead>
        <tr>
            <th rowspan="3">#</th>
            <th rowspan="3">Particulars</th>
            <th colspan="12">Month-wise Amount</th>
            <th rowspan="3">Net Payable</th>
        </tr>
        <tr>
            <?php foreach ($report['payable']['months'] as $m): ?>
                <th><?= date('M \'y', mktime(0, 0, 0, $m + 1, 10)); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($report['payable']['months'] as $m): ?>
                <th><?= !empty($report['payable']['due_dates'][$m]) ? date('d.m.y', strtotime($report['payable']['due_dates'][$m])) : '-'; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        $sl = 1;
        foreach ($report['payable']['fee_heads'] as $head => $months):
            echo "<tr><td>{$sl}</td><td class='Tdl'>{$head}</td>";
            $head_total = 0;
            foreach ($report['payable']['months'] as $m) {
                $val = isset($months[$m]) ? number_format($months[$m], 2) : '0.00';
                echo "<td>{$val}</td>";
            }
            echo "<td class='Tdr' style='text-align: center;'>".number_format($report['payable']['headwise_total'][$head], 2)."</td></tr>";
            $sl++;
        endforeach;
        ?>
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;">
            <td colspan="14" class="Tdr">TOTAL</td>
            <td ><?= number_format($report['payable']['grand_payable'], 2); ?></td>
        </tr>
    </tfoot>
</table>

<!-- ========== 2️⃣ TOTAL NET AMOUNT PAID ========== -->
<h2>TOTAL NET AMOUNT PAID</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Receipt No</th>
            <th>Receipt Date</th>
            <th>Payment Period</th>
            <th>Payment Details</th>
            <th>Net Amount Paid (₹)</th>
        </tr>
    </thead>
    <tbody>
        <?php $sl=1; foreach($report['paid']['rows'] as $r): ?>
        <tr>
            <td><?= $sl++; ?></td>
            <td><?= $r['receipt_id']; ?></td>
            <td><?= $r['receipt_date']; ?></td>
            <td>
                <?php
                    $months = json_decode($r['months'], true);
                    if (!empty($months)) {
                        $uniqueMonths = array_unique($months);
                        $monthNames = array_map(function($m) {
                            return date('F', mktime(0, 0, 0, $m + 1, 10));
                        }, $uniqueMonths);
                        echo implode(', ', $monthNames);
                    } else {
                        echo '-';
                    }
                ?>
            </td>
            
            <?php
            $summary = json_decode($r['summary'], true); // Decode JSON into an associative array
            $filtered_keys = []; // Initialize an array to store the keys to be printed
            
            // Iterate over the summary and collect keys except for those with a value of 0 or excluded keys
            foreach ($summary as $key => $value) {
                if ($value != 0 && !in_array($key, ['Previous Year Due!', 'Late Fine!', 'Concession!'])) {
                    $filtered_keys[] = $key; // Store only the key if its value is not 0
                }
            }
            
            // Print the keys as comma-separated within a single <td> element
            echo "<td>" . implode(", ", $filtered_keys) . "</td>";
            ?>

            <td><?= number_format($r['paid'],2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;">
            <td colspan="5" class="Tdr">TOTAL</td>
            <td><?= number_format($report['paid']['total_paid'],2); ?></td>
        </tr>
    </tfoot>
</table>

<!-- ========== 3️⃣ SUMMARY REPORT ========== -->
<h2>SUMMARY REPORT</h2>
<table>
    <thead>
        <tr>
            <th>Gross Payable</th>
            <th>Previous Year Due</th>
            <th>Concession</th>
            <th>Net Payable</th>
            <th>Paid</th>
            <th>Outstanding</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= number_format($report['summary']['gross_payable'], 2); ?></td>
            <td><?= number_format($report['summary']['previous_due'], 2); ?></td>
            <td><?= number_format($report['summary']['concession'], 2); ?></td>
            <td><?= number_format($report['summary']['net_payable'], 2); ?></td>
            <td><?= number_format($report['summary']['total_paid'], 2); ?></td>
            <td><?= number_format($report['summary']['outstanding'], 2); ?></td>
        </tr>
    </tbody>
</table>



</body>
</html>
