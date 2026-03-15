<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <h1>Generate Transfer Certificate</h1>
</div>

<?php 
if($saved_data->transfer_certificate != "") {
    $saved_data = json_decode($saved_data->transfer_certificate);
}
?>

<div class="card card-flush h-xl-100">
<div class="card-body py-9">

<?php echo form_open(
    base_url("students/withdrawn/generate/transfer-certificate"),
    array(
        "method" => "POST",
        "target" => "print_popup",
        "onsubmit"=> "window.open('about:blank','print_popup','width=1000,height=500');"
    )
); ?>

<div class="table-responsive">

<table class="table table-bordered">
<tbody>

<tr>
<td>TC No.</td>
<td>
<input class="form-control form-sm" type="text"
value="<?php echo $tc_no ?>" disabled />
</td>

<td>Student No.</td>
<td>
<input class="form-control form-sm" type="text"
value="<?php echo $student_data['student_no'] ?>" disabled />
</td>
</tr>

<tr>
<td>APAAR ID</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_13"
value="<?php if(isset($saved_data->field_13)) echo $saved_data->field_13; ?>" />
</td>

<td>UDISE PEN</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_14"
value="<?php if(isset($saved_data->field_14)) echo $saved_data->field_14; ?>" />
</td>
</tr>

<tr>
<td>THIS IS TO CERTIFY THAT</td>
<td>
<input class="form-control form-sm" type="text"
name="field_1"
value="<?php echo $student_data["f_name"]." ".$student_data["m_name"]." ".$student_data["l_name"] ?>"
readonly />
</td>

<td><?php echo $student_data["sex"] == "male" ? "Son" : "Daughter" ?> of</td>
<td>
<input class="form-control form-sm" type="text"
name="field_2"
value="<?php echo $student_data["father_name"] ?>"
readonly />
</td>
</tr>

<tr>
<td>was admitted into this school on</td>
<td>
<input class="form-control form-sm" type="text"
name="field_3"
value="<?php echo date("d-m-Y", strtotime($student_data["admission_date"])) ?>"
readonly />
</td>

<td>on a transfer from</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_4"
value="<?php if(isset($saved_data->field_4)) echo $saved_data->field_4; ?>" />
</td>
</tr>

<tr>
<td>and left on</td>
<td>
<input class="form-control form-sm"
type="date"
name="field_5"
value="<?php echo $date_of_leaving ?>"
readonly />
</td>

<td>with a</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_6"
value="<?php if(isset($saved_data->field_6)) echo $saved_data->field_6; ?>" />
</td>
</tr>

<tr>
<td><?php echo $student_data["sex"] == "male" ? "He" : "She" ?> was studying in the</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_7"
value="<?php if(isset($saved_data->field_7)) echo $saved_data->field_7; ?>" />
</td>

<td>class of the</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_8"
value="<?php if(isset($saved_data->field_8)) echo $saved_data->field_8; ?>" />
</td>
</tr>

<tr>
<td>the school year being from</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_9"
value="<?php if(isset($saved_data->field_9)) echo $saved_data->field_9; ?>" />
</td>

<td>to</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_10"
value="<?php if(isset($saved_data->field_10)) echo $saved_data->field_10; ?>" />
</td>
</tr>

<tr>
<td rowspan="1">
All sums due to this school on his account has been remitted or satisfactorily arranged for.
</td>
</tr>

<tr>
<td>His date of birth, according to the Admission Register is</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_11"
value="<?php echo date("d-m-Y", strtotime($student_data["dob"])) ?>"
readonly />
</td>

<td>Promotion has been</td>
<td>
<input class="form-control form-sm"
type="text"
name="field_12"
value="<?php if(isset($saved_data->field_12)) echo $saved_data->field_12; ?>" />
</td>
</tr>

</tbody>
</table>

</div>

<input type="text" class="d-none" name="student_id" value="<?php echo $student_id; ?>" />
<input type="text" class="d-none" name="tc_no" value="<?php echo $tc_no; ?>" />
<input type="text" class="d-none" name="tc_date" value="<?php echo $tc_date; ?>" />
<input type="text" class="d-none" name="date_of_leaving" value="<?php echo $date_of_leaving; ?>" />
<input type="text" class="d-none" name="reason" value="<?php echo $reason; ?>" />
<input type="text" class="d-none" name="version" value="<?php echo $version; ?>" />

<button class="btn btn-success" type="submit">Save</button>

<?php echo form_close() ?>

</div>
</div>

<?php $this->load->view("inc/app_footer.php"); ?>
