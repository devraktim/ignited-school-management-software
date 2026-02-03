<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @media print {
                canvas {
                    page-break-inside: avoid; /* Prevent page breaks inside the canvas element */
                }
            }
                    canvas, .canvas-container {
                page-break-before: auto;
                page-break-after: auto;
                page-break-inside: auto;
            }

            canvas {
                display: block;
                width: 100%;
                height: auto;
            }

            .BigHeader {
                text-align:center;
                font-family: 'MS Sans Serif', Serif;
                font-weight:bold;
                font-size:16pt;
                
            }

            .SmallHeader
            {
                width:98%;
                text-align:center;
                font-family:Arial;
                font-size:12pt;    
                margin-left:10px;
                border-bottom: 1px #000 double;
            }

            .DispTable
            {
                border-collapse: collapse;
            }

            .DispTable TD.FldR
            {
                font-family:Georgia, "Times New Roman";
                font-size:9pt;
                font-weight: bold;
                text-align:right;
                padding-right:5px;
                padding-top:3px;
            }

            .DispTable TD.FldL
            {
                font-family:Georgia, "Times New Roman";
                font-size:9pt;
                font-weight: bold;
                text-align:left;
                padding-left:5px;
                padding-top:3px;
            }

            .DispTable TD.Dta
            {
                font-family:"Courier New", "Arial";
                font-size:10pt;
                text-align:left;
                padding-left:10px;
                padding-top:3px;
                border-bottom: 1px #000 dotted;
            }

            .DispTable TD.Hdr
            {
                font-family:"Georgia", "Times New Roman";
                font-size:12pt;
                font-variant: small-caps;
                text-align:left;
                padding-left:10px;
                padding-top:3px;     
                padding-bottom:5px;
            }

            .GridTable
            {
                border: 2px #000 solid;
                border-collapse: collapse;   
                border-radius: 15px;
            }

            .GridTable th.thl
            {
                border: 1px #000 solid;
                padding-left:5px;
                text-align:left;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable th.thr
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable th.thc
            {
                border: 1px #000 solid;
                text-align:center;
                font-family:"Times New Roman", Georgia;
                font-size:10pt;
                font-weight:bold;
                font-variant: small-caps;
                background: #EEE;
                color:#000;
            }

            .GridTable td
            {
                border: 1px #000 solid;
                padding-left:5px;
                text-align:left;
                font-family:"Courier New", Arial;
                font-size:10pt;    
            }

            .GridTable td.Tdr
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:  Arial, "Courier New";
                font-size:10pt;    
            }

            .GridTable td.Tdc
            {
                border: 1px #000 solid;
                text-align:center;
                font-family:"Courier New", Arial;
                font-size:10pt;    
            }

            .GridTable td.Fld
            {
                border: 1px #000 solid;
                text-align:left;
                font-family:Georgia, 'Times New Roman';
                font-size:10pt;
                font-weight:bold;    
            }

            .GridTable td.Srl
            {
                border: 1px #000 solid;
                padding-right:5px;
                text-align:right;
                font-family:  Arial, "Courier New";
                font-size:9pt;    
                background-color: #EFEFEF;
            }

            DIV.Info
            {
                margin-left: 30px;
                font-family: "Times New Roman", Arial;
                font-size: 16pt;
                font-weight: bold;
                font-variant: small-caps;
            }
        </style>
    </head>

    <body data-new-gr-c-s-check-loaded="14.1098.0" data-gr-ext-installed="">
        <?php 
            $sl_no = 0;
            $i = 0; 
            while($i <= count($records)) {
                $rows = array_slice($records, $i, 15);                   
                $i = $i + 15;
        ?>
            <table style="width: 98%; border-collapse: collapse; margin-left: 10px; border-bottom: 2px solid rgb(0, 0, 0); --darkreader-inline-border-bottom:#7e7669;" data-darkreader-inline-border-bottom="">
                <tbody>
                    <tr>
                        <td style="vertical-align:top" rowspan="2">
                            <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:70px; Width:70px">
                        </td>
                        <td style="text-align:center; vertical-align:top">
                            <div style="font-family:Arial; font-size:30pt">
                                St. Francis School
                            </div>
                        </td>
                        <td style="vertical-align:top; text-align: end;" rowspan="2">
                            <img src="<?php echo base_url()?>assets/media/logos/logol.png" style="Height:70px; Width:70px">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                            <table style="width:99%">
                                <tbody>
                                    <tr>
                                        <td style="font-size:10pt; font-family:Arial; text-align:center; font-style: italic">
                                            Jorethang
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="BigHeader" style="width:90%; margin: 0 auto; margin-top:20px">Apprisal Extra Curricular List <?php echo date('Y', strtotime($this->session->academy_session['current_session']['start'])) ?></div>
                        
            <table class="GridTable" style="width:94%; margin: 0 auto; margin-top:30px">
                <thead>
                    <tr>
                        <th class="Thc" style="width:3%">S.NO</th>
                        <th class="Thc">Student No</th>
                        <th class="Thc">Name</th>
                        <th class="Thc">Student Type</th>
                        <th class="Thc">Event</th>
                        <th class="Thc">Result</th>
                        <th class="Thc">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $student) {
                        $rowspan = count($student['data']);
                        $sl_no++;
                    ?>
                    
                       <?php 
                       if(count($student['data']) > 0) {
                            foreach ($student['data'] as $index => $event) { ?>
                                <tr>
                                    <?php if($index == 0) { ?>
                                    <td class="Tdc" rowspan="<?php echo $rowspan; ?>"><?php echo $sl_no; ?></td>
                                    <td class="Tdc" rowspan="<?php echo $rowspan; ?>"><?php echo $student['student_no']; ?></td>
                                    <td class="Tdc" rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name']; ?>
                                    </td>
                                    <td class="Tdc" rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $student['student_type_name']; ?>
                                    </td>
                                    <?php } ?>
                                    
                                    <td class="Tdc"><?php echo $event['name']; ?></td>
                                    <td class="Tdc"><?php echo $event['result']; ?></td>
                                    <td class="Tdc"><?php echo $event['remarks']; ?></td>
                                </tr>
                        <?php } } else { ?>
                                <tr>
                                    <td class="Tdc"><?php echo $sl_no; ?></td>
                                    <td class="Tdc"><?php echo $student['student_no']; ?></td>
                                    <td class="Tdc">
                                        <?php echo $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name']; ?>
                                    </td>
                                    <td class="Tdc">
                                        <?php echo $student['student_type_name']; ?>
                                    </td>
                                    
                                    <td class="Tdc"></td>
                                    <td class="Tdc"></td>
                                    <td class="Tdc"></td>
                                </tr>
                        <?php } ?>
                        
                        <tr>
                            <td colspan=7 style="height: 10px;"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div style="page-break-before:always">&nbsp;</div>
        <?php } ?>
        
        <div style="display: flex; justify-content: center; align-items: center;">
            <canvas id="myPieChart1" width="400" height="400"></canvas>
        </div>
        
        <div style="display: flex; justify-content: center; align-items: center;">
            <canvas id="myPieChart2" width="1000" height="1000"></canvas>
        </div>
    </body>

</html>