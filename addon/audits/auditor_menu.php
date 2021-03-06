<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/ 

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../includes/ADL_MYSQLI_CON.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /../../../CRMmain.php'); die;
    }

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
$result = $conn->query("select grade, count(grade) As Alert from closer_audits where date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND auditor='$hello_name' group by grade");

  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable = json_encode($table);

?>

<?php

$result = $conn->query("select grade, count(grade) As Alert from closer_audits WHERE date_submitted between DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) AND LAST_DAY(NOW()) AND auditor='$hello_name' group by grade");

  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable2 = json_encode($table);

?>

<?php

$result = $conn->query("select grade, count(grade) As Alert from closer_audits where date_submitted between DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH) AND DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())) DAY) AND auditor='$hello_name' group by grade");


  $results = array();
  $table = array();
  $table['cols'] = array(

    array('label' => 'grade', 'type' => 'string'),
    array('label' => 'Alert', 'type' => 'number')

);
    foreach($result as $r) {

      $temp = array();

      $temp[] = array('v' => (string) $r['grade']); 

      $temp[] = array('v' => (int) $r['Alert']); 
      $results[] = array('c' => $temp);
    }

$table['rows'] = $results;

$jsonTable4 = json_encode($table);

?>
<!DOCTYPE html>
<html>
<title>ADL | Legal and General Audits</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
    <script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">


    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
           title: 'This Weeks Grades',
			pieHole: 0.4,
			colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
backgroundColor: '#FFFFFF'
        };

      var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
      chart.draw(data, options);
    }
    </script>
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable2?>);
      var options = {
           title: 'This Months Grades',
			pieHole: 0.4,
			colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
backgroundColor: '#FFFFFF'
        };
      var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
      chart.draw(data, options);
    }
    </script>

<script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable4?>);
      var options = {
           title: 'Last Months Grades',
			pieHole: 0.4,
			colors: ['#DC3912', '#109618', '#FF9900', '#990099'],
backgroundColor: '#FFFFFF'
        };
      var chart = new google.visualization.PieChart(document.getElementById('previous_month_chart'));
      chart.draw(data, options);
    }
    </script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});
$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });
});
</script>
</head>
<body>

<?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="container">

<br>

<div class="column-left">
<div id="donutchart2"></div>
</div>
<div class="column-center">
<div id="donutchart"></div>
</div>
<div class="column-right">
<div id="previous_month_chart"></div>   
</div>

<?php
$RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
    
   if(isset($RETURN)) {
       if($RETURN=='ADDED') { 
               $GRADE = filter_input(INPUT_GET, 'grade', FILTER_SANITIZE_SPECIAL_CHARS);
    $TotalCorrect = filter_input(INPUT_GET, 'TotalCorrect', FILTER_SANITIZE_SPECIAL_CHARS);
           
           ?>

       <div class="editpolicy">
    <div class="notice notice-info">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success:</strong> Audit Added!
    </div>

<?php

 switch ($GRADE) {
    case "Red":
        $NOTICE_COLOR="danger";

        break;
    case "Amber":
        $NOTICE_COLOR="warning";
        break;
    case "Green":
        $NOTICE_COLOR="success";
        break;
    default:
        $NOTICE_COLOR="info";
       
}   ?>

       <div class="editpolicy">
    <div class="notice notice-<?php echo $NOTICE_COLOR; ?>">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Grade:</strong> <?php echo $GRADE; ?> | Total answered correctly: <?php echo "$TotalCorrect/54";?>.
    </div>
    
    <?php
           
       }
       if($RETURN=='FAILED') { ?>

<div class="editpolicy">
<div class="notice notice-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> Closer Audit Failed.
    </div>
</div>
        <?php   
       }
   }

    ?>


<center>
    <div class="btn-group">
        <a href="main_menu.php" class="btn btn-default"><i class="fas fa-arrow-left"></i> Audit Menu</a>
        <a href="CloserAudit.php" class="btn btn-primary"><i class="fa fa-plus"></i> Legal and General Audit</a>
        <a href="audit_search.php" class="btn btn-info "><span class="glyphicon glyphicon-search"></span> Search Audits</a>
    </div>
</center>
<br>

<?php 

$query = $pdo->prepare("select count(id) AS id from closer_audits where grade ='SAVED' and auditor = :hello ");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

$savedcount = $result['id'];
if ($savedcount >=1){
	echo "<div class=\"notice notice-danger\" role=\"alert\"><strong>You have <span class=\"label label-warning\">$savedcount</span> incomplete audit(s)</strong><button type=\"button\" class=\"btn btn-danger pull-right\" data-toggle=\"modal\" data-target=\"#savedaudits\"><span class=\"glyphicon glyphicon-exclamation-sign\"></span> Saved Audits</button></div>";
}
else {

}
}
}
?>

<?php
$query = $pdo->prepare("SELECT policy_number, id, date_submitted, closer, auditor, grade, edited, date_edited from closer_audits where auditor = :hello and date_submitted between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or date_edited between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND edited =:hello ORDER BY date_submitted DESC");

$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);

echo "<table align=\"center\" class=\"table\">";

echo 
	"<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
    	<tr>
	<th>ID</th>
	<th>Policy Number</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th>Edited By</th>
	<th>Date Edited</th>
	<th colspan='5'>Options</th>
	</tr>
	</thead>";

$query->execute();
 $i=0;
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
    $i++;

switch( $result['grade'] )
    {
      case("Red"):
         $class = 'Red';
          break;
        case("Green"):
          $class = 'Green';
           break;
        case("Amber"):
          $class = 'Amber';
           break;
       case("SAVED"):
            $class = 'Purple';
          break;
        default:
 }
	echo '<tr class='.$class.'>';
	echo "<td>".$result['id']."</td>";
         echo "<td>".$result['policy_number']."</td>";
	echo "<td>".$result['date_submitted']."</td>";
	echo "<td>".$result['closer']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	echo "<td>".$result['edited']."</td>";
	echo "<td>".$result['date_edited']."</td>";
   echo "<td>
      <form action='closer_form_edit.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='closer_form_view.php' method='POST' name='formview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>";
	echo "</tr>";
        ?>
    <?php
	}
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
}
echo "</table>";
?>

    
<div id="savedaudits" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Incomplete (saved) audits</h4>
      </div>
      <div class="modal-body">
<?php
$query = $pdo->prepare("SELECT policy_number, id, date_submitted, closer, auditor, grade from closer_audits where auditor = :hello and grade = 'SAVED' ORDER BY date_submitted DESC");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR);
echo "<table align=\"center\" class=\"table\">";

echo 
	"<thead>
	<tr>
	<th>ID</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th colspan='3'></th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

switch( $result['grade'] )
    {
      case("Red"):
         $class = 'Red';
          break;
        case("Green"):
          $class = 'Green';
           break;
        case("Amber"):
          $class = 'Amber';
           break;
       case("SAVED"):
            $class = 'Purple';
          break;
        default:
 }
	echo '<tr class='.$class.'>';
	echo "<td>".$result['id']."</td>";
	echo "<td>".$result['date_submitted']."</td>";
	echo "<td>".$result['closer']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	   echo "<td>
      <form action='closer_form_edit.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='closer_form_view.php' method='POST' name='formview'>
	<input type='hidden' name='search' value='".$result['id']."' >
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>"; 
	echo "</tr>";
    }
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No incomplete/saved audits</div>";
}
echo "</table>";

?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
  
</div>

</div>
       </div>
</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
    <?php
    require_once(__DIR__ . '/../../app/Holidays.php');

    if (isset($hello_name)) {

            if ($XMAS == 'December' || $XMAS=='November') {
                $SANTA_TIME = date("H");
                
                ?>
                <audio autoplay>
                    <source src="/app/sounds/<?php echo $XMAS_ARRAY[$RAND_XMAS_ARRAY[0]]; ?>" type="audio/mpeg">
                </audio>  
                <?php
          
            }
            
            if($HALLOWEEN=='31st of October') {  ?>

                <audio autoplay>
                    <source src="/app/sounds/halloween/<?php echo $RAND_HALLOWEEN_ARRAY; ?>" type="audio/mpeg">
                </audio>    
            <?php } }

    ?>  
</body>
</html>