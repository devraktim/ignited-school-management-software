<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>State Wise Outstanding Report</title>
    <style>
        .BigHeader { text-align:center; font-weight:bold; font-size:16pt; }
        .GridTable { border:2px #000 solid; border-collapse:collapse; width:94%; margin:0 auto; margin-top:30px; }
        .GridTable th, .GridTable td { border:1px #000 solid; padding:4px 5px; font-size:10pt; white-space:nowrap; }
        .GridTable th { background:#EEE; font-variant:small-caps; font-weight:bold; }
        .Tdc { text-align:center; } .Tdr { text-align:right; } .Tdl { text-align:left; }
    </style>
</head>
<body>
<?php
    $school_name = "St. Francis School";
    $branch = "Jorethang";
    $sl = 1;
    $grand_total = 0; // Initialize Grand Total
    $report = $report ?? []; // Ensure $report exists
    $chunks = array_chunk($report, 25);
    $total_chunks = count($chunks);
    $current_chunk_index = 0;
?>

<?php
// === Filters from GET (moved outside chunk loop since they don't change per page) ===
$class_id    = $_GET['class_id'] ?? '';
$section_id  = $_GET['section_id'] ?? '';
$state_id    = $_GET['state_id'] ?? '';
$current_date = date('d/m/Y');

// === Resolve Class ===
$class_name = 'All Classes';
if (!empty($classes)) {
    foreach ($classes as $c) {
        if ($c['id'] == $class_id) { $class_name = $c['name']; break; }
    }
}

// === Resolve Section ===
$section_name = 'All Sections';
if (!empty($sections)) {
    foreach ($sections as $s) {
        if ($s['id'] == $section_id) { $section_name = $s['name']; break; }
    }
}

// === Resolve State ===
$state_name = '';
if (!empty($states)) {
    foreach ($states as $st) {
        if ($st['id'] == $state_id) { $state_name = $st['name']; break; }
    }
}
?>

<?php if (empty($chunks)): ?>
    <div style="text-align:center; font-size:20px; padding:50px; background:#f7f7f7; border:1px solid #ccc; margin:50px auto; width:80%; color:#d9534f; font-weight:bold;">
        No Data Found
    </div>
<?php endif; ?>


<?php foreach ($chunks as $chunk):
    $current_chunk_index++;
    $is_last_chunk = ($current_chunk_index === $total_chunks);
?>
<?php
    // --- Page total for each chunk (recalculated) ---
    $page_total = 0;
    foreach ($chunk as $r) {
        $page_total += (float)$r['outstanding'];
        $grand_total += (float)$r['outstanding'];
    }
    // We only need to accumulate grand_total once, so we'll adjust the loop
    // to prevent double-counting if this code were rerun outside the context of the initial loop.
    // For this fixed block, the original calculation for grand_total is fine since it runs once per chunk.
?>
<table style="width:98%; border-collapse:collapse; margin-bottom:20px;">
    <tr>
        <td rowspan="2"><img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;"></td>
        <td style="text-align:center;">
            <div style="font-family:Arial; font-size:28pt;"><?= htmlspecialchars($school_name) ?></div>
            <div style="font-family:Arial; font-size:12pt;">State Wise Outstanding Report</div>
        </td>
        <td rowspan="2" style="text-align:right;"><img src="<?= base_url('assets/media/logos/logol.png') ?>" style="height:70px;width:70px;"></td>
    </tr>
</table>
<hr>

<div style="text-align:center; font-family:Georgia,serif; margin-bottom:10px;">
    <div style="font-size:16px; font-weight:bold; text-transform:uppercase;">
        Outstanding Report of
        <?= htmlspecialchars($class_name) ?>
        <?= ($section_name && $section_name !== 'All Sections') ? ' - ' . htmlspecialchars($section_name) : '' ?>
    </div>
    <div style="font-size:13px; margin-top:4px;">
        State Name: <strong><?= htmlspecialchars($state_name ?: 'All States') ?></strong>
        as on <?= $current_date ?>
    </div>
</div>

<table class="GridTable">
    <thead>
        <tr>
            <th class="thc">Sl</th>
            <th class="thc">Std No</th>
            <th class="thl">Student Name</th>
            <th class="thc">Class/Sec</th>
            <th class="thc">Std/Type</th>
            <th class="thl">Father Name</th>
            <th class="thc">Father Ph No</th>
            <th class="thl">Mother Name</th>
            <th class="thc">Mother Ph No</th>
            <th class="thr">Outstanding</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($chunk as $row): ?>
            <tr>
                <td class="Tdc"><?= $sl++ ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['student_no']); ?></td>
                <td class="Tdl"><?= htmlspecialchars($row['student_name']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['class_name'].'/'.$row['section_name']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['student_type']); ?></td>
                <td class="Tdl"><?= htmlspecialchars($row['father_name']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['father_mobile']); ?></td>
                <td class="Tdl"><?= htmlspecialchars($row['mother_name']); ?></td>
                <td class="Tdc"><?= htmlspecialchars($row['mother_mobile']); ?></td>
                <td class="Tdr" style="font-weight:bold;"><?= number_format((float)$row['outstanding'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr style="font-weight:bold; background:#f4f4f4;">
            <td colspan="9" class="Tdr">Page Total :</td>
            <td class="Tdr"><?= number_format($page_total, 2); ?></td>
        </tr>
        <?php if ($is_last_chunk): ?>
        <tr style="font-weight:bold; background:#dcdcdc;">
            <td colspan="9" class="Tdr">Grand Total :</td>
            <td class="Tdr"><?= number_format($grand_total, 2); ?></td>
        </tr>
        <?php endif; ?>
    </tfoot>
</table>

<div style="page-break-before:always;">&nbsp;</div>
<?php endforeach; ?>

<?php
// The separate Grand Total table at the end is removed as it's now in the last chunk's <tfoot>.
// The check for empty data is now at the beginning.
// The empty chunk check inside the loop is removed since the outer check handles it,
// and the inner check caused an issue when $chunk was empty but $report wasn't (e.g., if array_chunk resulted in an empty final element, which is unlikely with the current logic, but safe to remove).
?>

</body>
</html>
