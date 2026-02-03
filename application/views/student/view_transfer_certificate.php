
<html>
    <head>
        <title>Transfer Certificate</title>
        <link href="https://ignitedschoolsoft2.com/himalikur/css/GenCss.css" rel="stylesheet" type="text/css">
        <link href="https://ignitedschoolsoft2.com/himalikur/css/Orch2Print.css" rel="stylesheet" type="text/css">    
        <script src="https://ignitedschoolsoft2.com/himalikur/js/GenJS.js" type="text/javascript"></script>
        <script src="https://ignitedschoolsoft2.com/himalikur/js/jquery-1.9.1.js" type="text/javascript"></script>
        <style>
            .DispTable td.Dta, .DispTable td.FldL, .DispTable td.FldR
            {
                padding-top:10px;
                padding-bottom: 2px;
            }
        </style>
        <script>
            function setValues()
            {
                var vSex = 1;
                var strSex1;
                var strSex2;
                var strSex3;
                var strSex4;
                
                if (vSex == 1)
                {
                    strSex1 = "Son";
                    strSex2 = "He";
                    strSex3 = "his";
                    strSex4 = "His";
                }
                else
                {
                    strSex1 = "Daughter";
                    strSex2 = "She";
                    strSex3 = "her";
                    strSex4 = "Her";
                }
                
                document.getElementById("SpnSex1").innerHTML = strSex1;
                document.getElementById("SpnSex2").innerHTML = strSex2;
                document.getElementById("SpnSex3").innerHTML = strSex3;
                document.getElementById("SpnSex4").innerHTML = strSex4;
            }
        </script>
    </head>
    <body onload="javascript:setValues()">
        <div style="width:90%; margin-top:130px; margin-left:50px">
		<!--
            <table style="width:96%; border-collapse: collapse">
                <tr>
                    <td rowspan="2" style="width:20%; vertical-align: top">
                        <img src="../images/school/Logo_Col.jpg" style="height:90px">
                    </td>
                    <td style="text-align: center"><div class="BigHeader" style="font-size:28pt">Himali Boarding School</div></td>
                </tr>
                <tr>
                    <td style="text-align:center; vertical-align: top; font-family:Arial; font-size:9pt">Kurseong, Dist. Darjeeling                        </td>
                </tr>
            </table>
            -->
            <div class="BigHeader" style="font-size:20pt; margin: 0 auto; margin-top:50px">
                <!-- Transfer Certificate -->
            </div>
            
            <div style="margin-left:20px">
                <table class="DispTable" style="width:90%;  margin-top:40px">
                    <tr>
                        <td class="FldL">TC No</td>
                        <td class="Dta"><?php echo $tc_no ?></td>
                        <td class="FldL" style="width:40%">&nbsp;</td>
                        <td class="FldR">Student No</td>
                        <td class="Dta"><?php echo $student_data["student_no"] ?></td>
                    </tr>
                </table>

                <table class="DispTable" style="width:90%;  margin-top:40px">
                    <tr>
                        <td class="FldL">THIS IS TO CERTIFY THAT</td>
                        <td class="Dta" style="width:65%"><?php echo $data["field_1"] ?></td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%; ">
                    <tr>
                        <td class="FldL"><span id="SpnSex1"></span> of</td>
                        <td class="Dta" style="width:85%"><?php echo $data["field_2"] ?></td>                    
                    </tr>
                </table>
                <table class="DispTable" style="width:90%; ">
                    <tr>
                        <td class="FldL">was admitted into this school on</td>
                        <td class="Dta" style="width:60%"><?php echo $data["field_3"] ?></td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%; ">
                    <tr>
                        <td class="FldL"> on a transfer from</td>
                        <td class="Dta" style="width:77%"><?php echo $data["field_4"] ?></td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%; ">
                    <tr>
                        <td class="FldL">and left on</td>
                        <td class="Dta" style="width:33%"><?php echo $data["field_5"] ?></td>
                        <td class="FldR">with a </td>
                        <td class="Dta" style="width:25%"><?php echo $data["field_6"] ?></td>
                        <td class="FldL">character.</td>
                    </tr>
                </table>

                <table class="DispTable" style="width:90%;  margin-top:20px">
                    <tr>
                        <td class="FldL"><span id="SpnSex2"></span> was then studying in the </td>
                        <td class="Dta" style="width:10%"><?php echo $data["field_7"] ?></td>
                        <td class="FldR"> class of the </td>
                        <td class="Dta" style="width:30%"><?php echo $data["field_8"] ?></td>
                        <td class="FldL">stream, </td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%; ">
                    <tr>
                        <td class="FldL">the school year being from </td>
                        <td class="Dta" style="width:30%"><?php echo $data["field_9"] ?></td>                    
                        <td class="FldR"> to </td>
                        <td class="Dta" style="width:30%"><?php echo $data["field_10"] ?></td>
                        
                    </tr>
                </table>

                <table class="DispTable" style="width:90%;  margin-top:20px">
                    <tr>
                        <td class="FldL">All sums due to this school on <span id="SpnSex3"></span> account has been remitted or satisfactorily arranged for.</td>
                    </tr>
                </table>

                <table class="DispTable" style="width:90%;  margin-top:20px">
                    <tr>
                        <td class="FldL"><span id="SpnSex4"></span> date of birth, according to the Admission Register, is</td>
                        <td class="Dta" style="width:30%"><?php echo $data["field_11"] ?></td>
                    </tr>
                    <?php 
                        $dob = date_create($data["field_11"]);
                        $dob = date_format($dob, "Y-m-d");
                    ?>
                    <tr>
                        <td class="Dta" colspan="2">(<?php echo date("jS F, Y", strtotime($data["field_11"])) ?>)</td>
                    </tr>
                </table>

                <table class="DispTable" style="width:90%;  margin-top:20px">
                    <tr>
                        <td class="FldL"> Promotion has been </td>
                        <td class="Dta" style="width:30%"><?php echo $data["field_12"] ?></td>
                        <td class="Fld" style="width:45%">&nbsp;</td>
                    </tr>
                </table>
				
					<table class="DispTable" style="width:90%;  margin-top:60px">
                    <tr>
                        <td class="FldL"> Reason of Leaving </td>
                        <td class="Dta" style="width:70%"><?php echo $reason ?></td>
                        <td class="Fld" style="width:5%">&nbsp;</td>
                    </tr>
                </table>
	
                <table class="DispTable" style="width:90%;  margin-top:30px">
                    <tr>
                        <td class="FldL"> Date </td>
                        <td class="Dta" style="width:15%"><?php echo date("d-m-Y", time()) ?></td>
                        <td class="Fld" style="width:35%">&nbsp;</td>
                        <td class="Fld" style="border-bottom: 1px #000 solid; width:45%">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>