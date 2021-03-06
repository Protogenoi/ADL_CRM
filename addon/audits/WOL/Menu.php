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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html>
<title>ADL | WOL Menu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/templates/fontawesome/svg-with-js/js/fontawesome-all.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>

<?php require_once(__DIR__ . '/../../../includes/navbar.php');

    $QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    $return= filter_input(INPUT_GET, 'return', FILTER_SANITIZE_SPECIAL_CHARS);
?>
    
    <div class="container">
        <div class="notice notice-default" role="alert"><strong><center><span class="label label-warning"></span> Whole of Life Audits</center></strong></div>
        
        <?php
        if(isset($return)) {
            if($return=='Edit'){
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-edit fa-lg\"></i> Success:</strong> Whole of Life Audit Updated!</div>";
                
            }
            if($return=='Add') {
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> Whole of Life Audit Added!</div>";
                
            }
        }
        ?>
        
        <br>
        <center>
            <div class="btn-group">
                <a href="/addon/audits/main_menu.php" class="btn btn-default"><i class="fas fa-arrow-left"></i> Audit Menu</a>
                <a href="/addon/audits/WOL/Audit.php" class="btn btn-primary"><i class="fa fa-plus"></i> WOL Audit</a>
                <a href="Search.php" class="btn btn-info "><i class="fa fa-search"></i> Search Audits</a>
            </div>
        </center>
<br>
    
    <?php 
    $query = $pdo->prepare("select count(wol_id) AS wol_id from audit_wol where grade ='SAVED' and added_by =:hello");
    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
    $query->execute();
    if ($query->rowCount()>0) {
        while ($result=$query->fetch(PDO::FETCH_ASSOC)){
            $savedcount = $result['wol_id'];
            if ($savedcount >=1){
                echo "<div class=\"notice notice-danger\" role=\"alert\"><strong>You have <span class=\"label label-warning\">$savedcount</span> incomplete audit(s)</strong><button type=\"button\" class=\"btn btn-danger pull-right\" data-toggle=\"modal\" data-target=\"#savedaudits\"><span class=\"glyphicon glyphicon-exclamation-sign\"></span> Saved Audits</button></div>";
                
            }
            
            }
            
            }
               
                $query = $pdo->prepare("SELECT policy_number, wol_id, added_date, closer, added_by, grade, updated_by, updated_date from audit_wol where added_by =:hello and added_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or updated_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND updated_by =:hello ORDER BY added_date DESC");
                $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);                
                $query->execute();
                $i=0;
                if ($query->rowCount()>0) {
                                    echo "<table align=\"center\" class=\"table\">";
                
                echo "<thead>
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
                    while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                        $i++;
                        $WOL_ID=$result['wol_id'];
                        
                        switch( $result['grade'] ) {
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
                                echo "<td>".$result['wol_id']."</td>";
                                echo "<td>".$result['policy_number']."</td>";
                                echo "<td>".$result['added_date']."</td>";
                                echo "<td>".$result['closer']."</td>";
                                echo "<td>".$result['added_by']."</td>";
                                echo "<td>".$result['grade']."</td>";
                                echo "<td>".$result['updated_by']."</td>";
                                echo "<td>".$result['updated_date']."</td>";
   echo "<td><a href='Edit.php?EXECUTE=Edit&WOLID=$WOL_ID' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span></a></td>";
   echo "<td><a href='View.php?query=View&WOLID=$WOL_ID' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span></a></td>";
    echo "</tr>";
	}echo "</table>";
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Whole of Life Audits found</div>";
}

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
$query = $pdo->prepare("SELECT policy_number, wol_id, added_date, closer, added_by, grade from audit_wol where added_by = :hello and grade = 'SAVED' ORDER BY added_date DESC");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
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
	echo "<td>".$result['wol_id'] ."</td>";
	echo "<td>".$result['added_date']."</td>";
	echo "<td>".$result['closer']."</td>";
	echo "<td>".$result['added_by']."</td>";
	echo "<td>".$result['grade']."</td>";
	   echo "<td>
      <form action='closer_form_edit.php' method='POST' name='form'>
	<input type='hidden' name='search' value='".$result['wol_id'] ."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
   echo "<td>
      <form action='closer_form_view.php' method='POST' name='formview'>
	<input type='hidden' name='search' value='".$result['wol_id'] ."' >
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
  <section class="pfblock pfblock-gray" id="skills">
		
			<div class="container">
			
				<div class="row skills">
					
					<div class="row">

                        <div class="col-sm-6 col-sm-offset-3">

                            <div class="pfblock-header wow fadeInUp">
                                <h2 class="pfblock-title">My Skills</h2>
                                <div class="pfblock-line"></div>
                                <div class="pfblock-subtitle">
                                    BLAH
                                </div>
                            </div>

                        </div>

                    </div>
					
					<div class="col-sm-6 col-md-3 text-center">
						<span data-percent="80" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">80</span>
                        </span>
						<h3 class="text-center">Green</h3>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<span data-percent="90" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">90</span>
                        </span>
						<h3 class="text-center">Amber</h3>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<span data-percent="95" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">95</span>
                        </span>
						<h3 class="text-center">Red</h3>
					</div>	
				</div>
			
			</div>
		
    </section>
  
</div>
   
</div>

</body>
</html>
