<?php $this->load->view("inc/app_header.php"); ?>

<div id="kt_app_content_container" class="app-container container-fluid py-3">
    <div class="row mb-5">
        <h1>Edit Payment Plan</h1>
    </div>

    <div class="card card-flush h-xl-100 mb-4">
        <div class="card-body py-9">
            <div class="row">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="installments_months_key" value="installments_months" checked>
                      <label class="form-check-label" for="installments_months">Installments &amp; Months</label>
                    </div>
                    
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="installments_key" value="installments">
                      <label class="form-check-label" for="installments">Installments</label>
                    </div>
                    
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="months_key" value="months">
                      <label class="form-check-label" for="months">Month</label>
                    </div>
                </div>
        </div>
    </div>
                
    <div id="installments_months" style="display: block;">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <form action="https://ignitedsoft.in/stfrancis/master/payment-plan/store" method="POST">
                    <div class="row">
                        <input type="text" class="d-none" name="type" value="installments_months">
                        
                        <div class="col-md-4">
                            <label for="installmentsInput" class="form-label">How many installments?</label>
                            <input type="number" class="form-control w-100" id="installmentsInput" value="4">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success mt-4" id="installmentsBtn">Get Installments</button>
                        </div>
                </div>
                    
                    <div id="inscontainer" class="mt-4">
                        
                    <div class="row">
                            <div class="col-md-2">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="ins_1" checked="">
                                  <label class="form-check-label" for="flexCheckDefault">Installment 1</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_1" checked>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    January 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_2">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    February 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_3">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    March 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    April 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_5">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    May 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_6">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    June 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_7">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    July 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_8">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    August 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_9">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    September 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_10">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    October 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_11">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    November 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_1_12">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    December 2025                                                </label>
                                            </div>
                                        </div>
                                                                    </div>
                            </div>
                        </div>
                    <hr><div class="row">
                            <div class="col-md-2">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="ins_2" checked="">
                                  <label class="form-check-label" for="flexCheckDefault">Installment 2</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_1" checked>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    January 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_2">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    February 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_3">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    March 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    April 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_5">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    May 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_6">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    June 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_7">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    July 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_8">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    August 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_9">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    September 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_10">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    October 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_11">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    November 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_2_12" checked>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    December 2025                                                </label>
                                            </div>
                                        </div>
                                                                    </div>
                            </div>
                        </div>
                    <hr><div class="row">
                            <div class="col-md-2">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="ins_3" checked="">
                                  <label class="form-check-label" for="flexCheckDefault">Installment 3</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_1">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    January 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_2">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    February 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_3">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    March 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    April 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_5">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    May 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_6">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    June 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_7">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    July 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_8">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    August 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_9">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    September 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_10">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    October 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_11">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    November 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_3_12" checked="">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    December 2025                                                </label>
                                            </div>
                                        </div>
                                                                    </div>
                            </div>
                        </div>
                    <hr><div class="row">
                            <div class="col-md-2">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="ins_4" checked="">
                                  <label class="form-check-label" for="flexCheckDefault">Installment 4</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_1">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    January 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_2">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    February 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_3">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    March 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    April 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_5">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    May 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_6">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    June 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_7">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    July 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_8">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    August 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_9">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    September 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_10">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    October 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_11">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    November 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_4_12">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    December 2025                                                </label>
                                            </div>
                                        </div>
                                                                    </div>
                            </div>
                        </div>
                    <hr></div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success mt-5" style="margin-top: 25px !important;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="installments" style="display: none;">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <form action="https://ignitedsoft.in/stfrancis/master/payment-plan/store" method="POST">
                    <div class="row">
                    <input type="text" class="d-none" name="type" value="installments">
                    
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_1" id="installment_1">
                                <label class="form-check-label" for="installment_1">
                                    Installment 1                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_2" id="installment_2">
                                <label class="form-check-label" for="installment_2">
                                    Installment 2                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_3" id="installment_3">
                                <label class="form-check-label" for="installment_3">
                                    Installment 3                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_4" id="installment_4">
                                <label class="form-check-label" for="installment_4">
                                    Installment 4                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_5" id="installment_5">
                                <label class="form-check-label" for="installment_5">
                                    Installment 5                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_6" id="installment_6">
                                <label class="form-check-label" for="installment_6">
                                    Installment 6                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_7" id="installment_7">
                                <label class="form-check-label" for="installment_7">
                                    Installment 7                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_8" id="installment_8">
                                <label class="form-check-label" for="installment_8">
                                    Installment 8                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_9" id="installment_9">
                                <label class="form-check-label" for="installment_9">
                                    Installment 9                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_10" id="installment_10">
                                <label class="form-check-label" for="installment_10">
                                    Installment 10                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_11" id="installment_11">
                                <label class="form-check-label" for="installment_11">
                                    Installment 11                                </label>
                            </div>
                        </div>
                                            <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="installment_12" id="installment_12">
                                <label class="form-check-label" for="installment_12">
                                    Installment 12                                </label>
                            </div>
                        </div>
                                    </div>
                
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="months" style="display: none;">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <form action="https://ignitedsoft.in/stfrancis/master/payment-plan/store" method="POST">
                    <div class="row">
                        <input type="text" class="d-none" name="type" value="months">
                        
                        <h5>Session Start Month <span style="color: red;">01-2025</span></h5>
                        
                        <h5>Session End Month <span style="color: red;">12-2025</span></h5>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for radio buttons
            const radios = document.getElementsByName('exampleRadios');
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Hide all divs
                    document.getElementById('installments_months').style.display = 'none';
                    document.getElementById('installments').style.display = 'none';
                    document.getElementById('months').style.display = 'none';

                    // Show the selected div based on the radio button value
                    if (this.value === 'installments_months') {
                        document.getElementById('installments_months').style.display = 'block';
                    } else if (this.value === 'installments') {
                        document.getElementById('installments').style.display = 'block';
                    } else if (this.value === 'months') {
                        document.getElementById('months').style.display = 'block';
                    }
                });
            });
        });
    </script>
    
    <script>
        $("#installmentsBtn").click(function() {

            let number_of_installments = parseInt($("#installmentsInput").val())
            let html = ""
            
            for (let i = 1; i <= number_of_installments; i++) { 
                html+= `<div class="row">
                            <div class="col-md-2">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="ins_${i}" checked>
                                  <label class="form-check-label" for="flexCheckDefault">Installment ${i}</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_1">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    January 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_2">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    February 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_3">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    March 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_4">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    April 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_5">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    May 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_6">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    June 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_7">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    July 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_8">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    August 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_9">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    September 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_10">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    October 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_11">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    November 2025                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ins_${i}_12">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    December 2025                                                </label>
                                            </div>
                                        </div>
                                                                    </div>
                            </div>
                        </div>
                    <hr>`
            }
            
            $("#inscontainer").append(html)

        })
    </script>
                                </div>
<?php $this->load->view("inc/app_footer.php"); ?>