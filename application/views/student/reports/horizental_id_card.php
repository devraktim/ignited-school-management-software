
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <style>
    @charset "UTF-8";
/**
* Eric Meyer's Reset CSS v2.0
*/

/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure,
footer, header, menu, nav, section, time {
  display: block;
}

body {
  line-height: 1;
  color: black;
  background: white;
}

a {
  color: inherit;
  text-decoration: none;
}

ol, ul {
  list-style: none;
}

blockquote, q {
  quotes: none;
}

blockquote:before, blockquote:after,
q:before, q:after {
  content: '';
  content: none;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
}

/* meyerweb css reset end */

textarea:focus, input:focus {
  outline: 0;
}

input {
  border-width: 0;
}

em {
  font-style: italic;
}

h1, h2, h3, h4, h5, h6 {
  font-weight: bold;
  margin-top: 0;
  margin-bottom: 0;
}

.group:before,
.group:after {
  content: " ";
  display: table;
}

.group:after {
  clear: both;
}

.group {
  zoom: 1; /* ie 6/7 */
}

embed,
img,
object,
video {
  max-width: 100%;
}
sup {
  font-size: 58.3%;
  vertical-align: text-top;
}
sub {
  font-size: 58.3%;
  vertical-align: text-bottom;
}
.no-space-between-inline-blocks {
  *letter-spacing: normal; /*reset IE < 8*/
  letter-spacing: -0.31em; /*webkit*/
  word-spacing: -0.43em; /*IE < 8 && gecko*/
}
/*restore spacing on inner elements*/
.no-space-between-inline-blocks > * {
  letter-spacing: normal;
  word-spacing: normal;
}
.displace {
  left: -5000px;
  position: absolute;
}
html {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
*,
*:after,
*:before {
  -webkit-box-sizing: inherit;
  -moz-box-sizing: inherit;
  box-sizing: inherit;
}
html {
  font-size: 16px;
}
body {
  color: #ffffff;
  font-family: Outfit, serif;
  font-size: 33.33333px;
  font-style: normal;
  font-weight: normal;
  letter-spacing: 0.005em;
  text-decoration: none;
  margin: 0px;
}
.global_container_ {
  float: none;
  height: auto;
  /*margin: 0 auto;*/
  position: relative;
  width: 1011px;
  margin: -111px -253px;
}

.col {
  height: 530px;
  padding: 11px 0 10px;
  position: relative;
  width: 1011px;
  background: url(https://ignitedsoft.in/stfrancis/assets/media/student_horizental_id_card/layer_1.png) no-repeat;
}

.row {
  margin: 0 33px;
  position: relative;
}

.layer-5 {
  float: left;
  margin: 0 35px 0 0;
}

.text {
  margin: 7px 0 0;
  line-height: 1.2;
  text-align: center;
}

.wrapper-3 {
  height: 338px;
  left: 29px;
  margin: 8px auto 0;
  position: relative;
  width: 953px;
}

.row-2 {
  left: 50%;
  height: 100%;
  padding: 18px 73px 20px 205px;
  position: absolute;
  top: 0;
  width: 899px;
  background: url(https://ignitedsoft.in/stfrancis/assets/media/student_horizental_id_card/layer_2.png) no-repeat;
  margin-left: -422.5px;
}

.col-4 {
  float: left;
  position: relative;
  width: 472px;
}

.identity-card {
  display: block;
  margin: 0 auto;
}

.row-3 {
  margin: 26px auto 0;
  position: relative;
}

.text-2 {
  float: left;
  color: #052e71;
  font-weight: 500;
  
  font-size: 18px;
  line-height: 49.33333px; 
  display: block; 
  width: 100%;
  margin: 0px;
}

.text-3 {
  float: right;
  margin: 2px 0 0;
  width: 338px;
  color: #181818;
  font-weight: 600;
  line-height: 58.33333px;
}

.col-2 {
  float: right;
  margin: 203px 0 0;
  position: relative;
  width: 106px;
}

.layer-6 {
  display: block;
  margin: 0 auto;
}

.principal {
  margin: 4px 0 0;
  color: #010101;
  font-family: MyriadPro, serif;
  font-size: 25px;
  font-style: italic;
  font-weight: bold;
  letter-spacing: 0;
}

.layer-3 {
  height: 100%;
  left: 50%;
  position: absolute;
  top: 91px;
  width: 197px;
  margin-left: -476.5px;
}

.text-4 {
  margin: 8px 0 0;
  font-size: 25px;
  font-weight: 300;
  text-align: center;
}

.text-style {
  font-size: 58.33333px;
  font-weight: bold;
}
</style>
    <!--[if IE 6]>
	<style type="text/css">
		* html .group {
			height: 1%;
		}
	</style>
  <![endif]--> 
    <!--[if IE 7]>
	<style type="text/css">
		*:first-child+html .group {
			height: 1px;
		}
	</style>
  <![endif]--> 
    <!--[if lt IE 9]> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script> 
  <![endif]--> 
  </head>
  <body>
    <?php 
        $class_map = [
                     1 => "NURSERY", 2 => "LKG", 3 => "UKG", 4 => "I", 5 => "II", 
                    6 => "III", 7 => "IV", 8 => "V", 9 => "VI", 10 => "VI", 
                    11 => "VIII", 12 => "IX", 13 => "X", 14=>"XI", 15=>"XII"
        ];
    ?>
    
    <?php foreach($records as $record) { 
        
        $fullName = $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name'];
        $classId = $record['class_id'];
        $studentNo = $record['student_no'];
        $dob = $record['dob'];
        // $address = $record['local_address'] . ' ' . $record['permanent_address'];
        $address = $record['local_address'];
        $parentName = $record['father_name'];
        $phone = $record['local_phone'];
        $bloodGroup = $record['blood_group'] ?: 'Not Provided';
    
    ?>
        <div class="global_container_" style="transform: scale(0.5);">
          <div class="col">
            <div class="row group">
              <img class="layer-5" src="https://ignitedsoft.in/stfrancis/assets/media/student_horizental_id_card/layer_5.png" alt="" width="127" height="130">
              <p class="text"><strong class="text-style">ST. FRANCIS’ SCHOOL</strong><br>JORETHANG, NAMCHI-737121</p>
            </div>
            <div class="wrapper-3">
              <div class="row-2 group">
                <div class="col-4">
                  <img class="identity-card" src="https://ignitedsoft.in/stfrancis/assets/media/student_horizental_id_card/identity_card.jpg" alt="" width="210" height="31">
                  <div class="row-3 group">
                      <p class="text-2">Name: <?php echo ($fullName) ?></p>
                      
                      <br>
                      
                      <p class="text-2">Class: <?php echo($class_map[$classId])?></p>
                      
                      <br>
                      
                      <p class="text-2">Address: <?php echo($address) ?></p>
                      
                      <br>
                      
                      <p class="text-2">DOB: <?php echo($dob) ?></p>
                      
                      <br>
                      
                      <p class="text-2">Contact: <?php echo($phone)?></p>
                  </div>
                </div>
                <div class="col-2 group">
                  <img class="layer-6" src="https://ignitedsoft.in/stfrancis/assets/media/student_horizental_id_card/layer_6.png" alt="" width="104" height="66">
                  <p class="principal">Principal</p>
                </div>
              </div>
              <div class="layer-3">
                <?php if($record["image"]) { ?>
                    <img class="img-fluid" src="<?php echo base_url('storage/students/') . $record['image'] ?>" style="height: 219px; width: 197px;">
                <?php } else { ?>
                    <img class="img-fluid" src="<?php echo base_url('assets/media/avatar/') ?><?php echo $record['sex'] == 'male' ? 'male.jpg' : 'female.jpg' ?>" style="height: 200px; width: fit-content;">
                <?php } ?>
              </div>
            </div>
            <p class="text-4">ACADEMIC SESSION: 2025</p>
          </div>
        </div>
    <?php } ?>
  </body>
</html>