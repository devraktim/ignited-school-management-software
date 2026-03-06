
<html>
    <head>
        <!-- <title>Charecter Certificate</title> -->
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
            
            .DispTable td.FldL, .DispTable td.FldR
            {
                font-style: italic;
            }
        </style>
        <script>
            function setValues()
            {
                var vSex = 2;
                var strSex1;
                var strSex2;                
                
                if (vSex == 1)
                {
                    strSex1 = "Master";
                    strSex2 = "Son";                    
                }
                else
                {
                    strSex1 = "Miss";
                    strSex2 = "Daughter";                    
                }
                
                document.getElementById("SpnSex1").innerHTML = strSex1;
                document.getElementById("SpnSex2").innerHTML = strSex2;
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
                Character Certificate
            </div>
            <div class="BigHeader" style="font-size:16pt; margin: 0 auto; margin-top:30px">
                To Whom It May Concern
            </div>
            
            <div style="margin-left:40px; width:90%; ">
                <table class="DispTable" style="width:90%; margin-top:40px">
                    <tr>
                        <td class="FldL">This is to Certify that <span id="SpnSex1"></span></td>
                        <td class="Dta" style="width:62%"><?php echo $data["field_1"] ?></td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%;">
                    <tr>
                        <td class="FldL"><span id="SpnSex2"></span> of </td>
                        <td class="Dta" style="width:80%"><?php echo $data["field_2"] ?></td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%;">
                    <tr>
                        <td class="FldL">resident of </td>
                        <td class="Dta" style="width:85%"><?php echo $data["field_3"] ?></td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%;">
                    <tr>
                        <td class="FldL">was a bona-fide student of this institution.</td>                        
                    </tr>
                </table>
                
                <table class="DispTable" style="width:90%; margin-top:30px">
                    <tr>
                        <td class="FldL">The Character of the above student was </td>
                        <td class="Dta" style="width:20%"><?php echo $data["field_4"] ?></td>
                        <td class="FldL" style="width:30%">&nbsp;</td>
                    </tr>
                </table>
                <table class="DispTable" style="width:90%;">
                    <tr>
                        <td class="FldL">Academically the student was </td>
                        <td class="Dta" style="width:25%"><?php echo $data["field_5"] ?></td>
                        <td class="FldL" style="width:35%">&nbsp;</td>
                    </tr>
                </table>
                
                <table class="DispTable" style="width:90%;  margin-top:60px">
                    <tr>
                        <td class="FldL"> Date </td>
                        <td class="Dta" style="width:18%"><?php echo $data["field_6"] ?></td>
                        <td class="Fld" style="width:32%">&nbsp;</td>
                        <td class="Fld" style="border-bottom: 1px #000 solid; width:45%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="FldL" colspan="3">&nbsp;</td>
                        <td class="FldR" style="text-align: center">Director / Principal <br>ST. Joseph's Convent School</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>