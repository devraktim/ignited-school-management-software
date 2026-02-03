<!DOCTYPE html>
<html>
<head>
<title><?= $title ?></title>
<style>
    body { font-size: 13px; }
    .GridTable { width: 95%; margin: auto; border-collapse: collapse; }
    .GridTable th, .GridTable td { border: 1px solid #333; padding: 4px; }
    .GridTable th { background: #f5f5f5; text-align: center; text-transform: uppercase; }
    .Tdr { text-align: right; }
    .Tdc { text-align: center; }
    .Tdl { text-align: left; }
    .BigHeader { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 10px; }
    .page-break { page-break-after: always; }
</style>
</head>
<body>

<?php
    $school_name = "St. Francis School";
    $branch = "Jorethang";
    // Assuming $records is passed to this view/file and is an array (even if empty)
    if (!isset($records)) {
        $records = [];
    }
?>

<?php if (empty($records)): ?>
    <div style="text-align:center; font-size:20px; padding:50px; background:#f7f7f7; border:1px solid #ccc; margin:50px auto; width:80%; color:#d9534f; font-weight:bold;">
        No Data Found
    </div>
<?php else: ?>
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
    
    <hr>
    
    <div class="BigHeader">Total Concession Report <br> Session 2025</div>

    <table class="GridTable">
        <thead>
            <tr>
                <th style="width:4%">SL</th>
                <th style="width:18%">Student Name</th>
                <th style="width:12%">Class/Sec</th>
                <th style="width:10%">Student Type</th>
                <?php for($m=1; $m<=12; $m++): ?>
                    <th style="width:4%"><?= date('M', mktime(0,0,0,$m,1)); ?></th>
                <?php endfor; ?>
                <th style="width:6%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl=0;
            $monthly_totals = array_fill(1, 12, 0);
            $grand_total = 0;

            foreach ($records as $row) {
                $sl++;
                echo "<tr>";
                echo "<td class='Tdc'>{$sl}</td>";
                echo "<td class='Tdl'>".htmlspecialchars($row['student_name'])."</td>";
                echo "<td class='Tdc'>".htmlspecialchars($row['class_name'])." / ".htmlspecialchars($row['section_name'])."</td>";
                echo "<td class='Tdc'>".htmlspecialchars($row['student_type'])."</td>";

                for ($m=1; $m<=12; $m++) {
                    $val = $row['months'][$m] ?? 0;
                    $monthly_totals[$m] += $val;
                    echo "<td class='Tdr'>".number_format($val,2)."</td>";
                }

                $grand_total += $row['total'];
                echo "<td class='Tdr'>".number_format($row['total'],2)."</td>";
                echo "</tr>";
            }
            ?>
            <tr style="font-weight:bold; border-top:2px solid #000;">
                <td colspan="4" class="Tdr">Grand Total :</td>
                <?php for($m=1;$m<=12;$m++): ?>
                    <td class="Tdr"><?= number_format($monthly_totals[$m], 2); ?></td>
                <?php endfor; ?>
                <td class="Tdr"><?= number_format($grand_total, 2); ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
