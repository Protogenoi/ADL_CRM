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
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
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
 * 
*/ 

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '/../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Tasks</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>
    
      <div class="container">
          
          <?php
          
          if(isset($EXECUTE) && $EXECUTE == 2 ) { ?>
          
    <div  class="text-center">
       <label class="label label-success">Incomplete Tasks (New Tasks)</label>
      <div id="bar-chart" ></div>
    </div>
  
          <br>
          
    <table id="task" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Deadline</th>
            </tr>
        </tfoot>
    </table>          
          
              
 <?php  } else {
          
           $taskassigned= filter_input(INPUT_GET, 'taskassigned', FILTER_SANITIZE_SPECIAL_CHARS);


if(isset($taskassigned)){
    
      $taskassigned= filter_input(INPUT_GET, 'taskassigned', FILTER_SANITIZE_SPECIAL_CHARS);
      $assignto= filter_input(INPUT_GET, 'assignto', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($taskassigned =='y') {

print("<br><div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa  fa-check-circle-o fa-lg\"></i> Success:</strong> Task assigned to $assignto!</div><br>");
    }

            if ($taskassigned =='failed') {

print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes have been made!</div><br>");
    }
}      
          
  ?>        
    
    <div  class="text-center">
       <label class="label label-success">Incomplete Tasks</label>
      <div id="bar-chart" ></div>
    </div>
  
          <br>
          
    <table id="task" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Deadline</th>
                <th>Update</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>ID</th>
                <th>Client Name</th>
                <th>Assigned</th>
                <th>Task</th>
                <th>Update</th>
            </tr>
        </tfoot>
    </table>
          
          <?php } ?>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js"></script>

<script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
<script type="text/javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

<?php if(isset($EXECUTE) && $EXECUTE == 2 ) { ?>
    
<script>
    
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': '/addon/Life/JSON/TaskChart.php<?php if(isset($hello_name) && $ACCESS_LEVEL <= 3) { echo "?EXECUTE=3&AGENT=$hello_name"; } elseif($ACCESS_LEVEL > 3) { echo "?EXECUTE=3"; } ?>>',
            'dataType': "json",
            'success': function (data) {
                json = data;
            }
        });
        return json;
    })
    ();
     
    config = {
      data: json,
      xkey: 'task',
      ykeys: ['Completed'],
      labels: ['Incompleted Tasks'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  };


config.element = 'bar-chart';
Morris.Bar(config);
</script>
<script type="text/javascript" language="javascript" >
$(document).ready(function() {
    var table = $('#task').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    if ( aData["deadline"] <= aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'red' );
    }
   else if ( aData["deadline"] >= aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'green' );

    }
},
"response":true,
					"processing": true,
"iDisplayLength": 500,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "/addon/Life/JSON/Tasks.php<?php if(isset($hello_name) && $ACCESS_LEVEL <= 3) { echo "?EXECUTE=3&AGENT=$hello_name"; } elseif($ACCESS_LEVEL > 3) { echo "?EXECUTE=3"; } ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_added" },
            { "data": "life_tasks_client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
            } },
            { "data": "name" },
            { "data": "life_tasks_assigned" },
            { "data": "life_tasks_task" },
            { "data": "deadline" }
         ],
        "order": [[6, 'asc']]
    } ); $('#min, #max').keyup( function() {
        table.draw();
    } );
     
    $('#task tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } ); 
} );
		</script>    
    
    
<?php } else { ?>
<script>
    
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': '/addon/Life/JSON/TaskChart.php<?php if(isset($hello_name) && $ACCESS_LEVEL <= 3) { echo "?EXECUTE=1&AGENT=$hello_name"; } elseif($ACCESS_LEVEL > 3) { echo "?EXECUTE=2"; } ?>>',
            'dataType': "json",
            'success': function (data) {
                json = data;
            }
        });
        return json;
    })
    ();
     
    config = {
      data: json,
      xkey: 'Task',
      ykeys: ['Completed'],
      labels: ['Incompleted Tasks'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  };


config.element = 'bar-chart';
Morris.Bar(config);
</script>
<script type="text/javascript" language="javascript" >
function format ( d ) {

    return '<form action="/addon/Life/php/Tasks.php?EXECUTE=1" method="post"><table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Re-assigned to:</td>'+
            '<td><input type="hidden" name="taskid" value="'+d.id+'"><select name="assigned"><option value="'+d.assigned+'">'+d.assigned+'</option></select><button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-ok"></span> Assign</button></form></td>'+
        '</tr>'+
    '</table>';
}


$(document).ready(function() {
    var table = $('#task').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    if ( aData["deadline"] <= aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'red' );
    }
   else if ( aData["deadline"] >= aData["today"] )  {
          $('td', nRow).eq(6).addClass( 'green' );

    }
},
"response":true,
					"processing": true,
"iDisplayLength": 500,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "/addon/Life/JSON/Tasks.php<?php if(isset($hello_name) && $ACCESS_LEVEL <= 3) { echo "?EXECUTE=1&AGENT=$hello_name"; } elseif($ACCESS_LEVEL > 3) { echo "?EXECUTE=2"; } ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_added" },
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/app/Client.php?search=' + data + '">View</a>';
            } },
            { "data": "name" },
            { "data": "assigned" },
            { "data": "Task" },
            { "data": "deadline" },
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a class="btn btn-sm btn-default" href="?EXECUTE=1&REF=' + data + '"><i class="fa fa-check-circle-o "> Yes</a>';
            } }
         ],
        "order": [[6, 'asc']]
    } ); $('#min, #max').keyup( function() {
        table.draw();
    } );
     
    $('#task tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } ); 
} );
		</script>
<?php 
$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$REF= filter_input(INPUT_GET, 'REF', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($EXECUTE)) {                 
      if($EXECUTE=='1') { 
?>
        <script type="text/javascript">
$(document).ready(function () {

    $('#myModal').modal('show');

});
</script> 
<?php           
      }
  } ?>                
                
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Client Task</h4>
      </div>
      <div class="modal-body">
<?php
            $database = new Database();
            $database->beginTransaction();
            
        $database->query("select Task, Upsells, PitchTrust, PitchTPS, RemindDD, CYDReturned, DocsArrived, HappyPol FROM Client_Tasks where client_id=:REF");
        $database->bind(':REF', $REF); 
        $database->execute();
        $result=$database->single();
        
        $HappyPol=$result['HappyPol'];
        $DocsArrived=$result['DocsArrived'];
        $CYDReturned=$result['CYDReturned'];
        $RemindDD=$result['RemindDD'];
        $PitchTPS=$result['PitchTPS'];
        $PitchTrust=$result['PitchTrust'];
        $Upsells=$result['Upsells'];         
        $Taskoption=$result['Task']; 
        
        $database->endTransaction();
    ?>
                <center>
                    <br><br>
                    
                    <div class="btn-group">
                        <button data-toggle="collapse" data-target="#HappyPol" class="<?php if(empty($HappyPol)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Happy with Policy <br><?php echo $HappyPol;?></button>                 
                 <button data-toggle="collapse" data-target="#DocsArrived" class="<?php if(empty($DocsArrived)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Docs Emailed? <br><?php echo $DocsArrived;?></button>
                 <button data-toggle="collapse" data-target="#CYDReturned" class="<?php if(empty($CYDReturned)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">CYD Returned? <br><?php echo $CYDReturned;?></button>
                 <button data-toggle="collapse" data-target="#RemindDD" class="<?php if(empty($RemindDD)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Remind/Cancel Old/New DD <br><?php echo $RemindDD;?></button>
                 <button data-toggle="collapse" data-target="#PitchTPS" class="<?php if(empty($PitchTPS)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Pitch TPS <br><?php echo $PitchTPS;?></button>
                 <button data-toggle="collapse" data-target="#PitchTrust" class="<?php if(empty($PitchTrust)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Pitch Trust <br><?php echo $PitchTrust;?></button>
                 <button data-toggle="collapse" data-target="#Upsells" class="<?php if(empty($Upsells)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Upsells <br><?php echo $Upsells;?></button>
                </div>

                    <br><br>
<form name="ClientTaskForm" id="ClientTaskForm" class="form-horizontal" method="POST" action="/addon/Life/php/Tasks.php?search=<?php echo "$REF";?>&EXECUTE=2">
                                        
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <select id="Taskoption" class="form-control" name="Taskoption" required>
        <option value="">Select Task</option>
                                        <option value="24 48">24-48</option>
                                            <option value="5 day">5-day</option>
                                                <option value="18 day">18-day</option>
                                                    <option value="CYD">CYD</option>
                                                    <option value="Trust">Trust</option>
    </select>
 
</div>   
</div>
                        <div class="form-group">
                                                        
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
                 <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Update</button>
                  
  </div>
</div>
                   
<div id="HappyPol" class="collapse">
    
<div class="form-group">
  <label class="col-md-4 control-label" for="HappyPol">Happy with Policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="HappyPol-0">
      <input name="HappyPol" id="HappyPol-0" value="No" type="radio" <?php if(isset($HappyPol)) { if($HappyPol=='No') { echo "checked='checked'";}}?>>
      No
    </label> 
    <label class="radio-inline" for="HappyPol-1">
      <input name="HappyPol" id="HappyPol-1" value="Yes" type="radio" <?php if(isset($HappyPol)) { if($HappyPol=='Yes') { echo "checked='checked'";}}?>>
      Yes
    </label>
  </div>
</div>
    
</div>
                
<div id="DocsArrived" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="DocsArrived">Emailed?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="DocsArrived-0">
      <input name="DocsArrived" id="DocsArrived-0" value="No"  type="radio" <?php if(isset($DocsArrived)) { if($DocsArrived=='No') { echo "checked='checked'";}}?>>
      No
    </label> 
    <label class="radio-inline" for="DocsArrived-1">
      <input name="DocsArrived" id="DocsArrived-1" value="Yes" type="radio" <?php if(isset($DocsArrived)) { if($DocsArrived=='Yes') { echo "checked='checked'";}}?>>
      Yes
    </label>
          <label class="radio-inline" for="DocsArrived-3">
      <input name="DocsArrived" id="DocsArrived-3" value="Not Checked" type="radio" <?php if(isset($DocsArrived)) { if($DocsArrived=='Not Checked') { echo "checked='checked'";}}?>>
      Not Checked
    </label>
  </div>
</div>
    
</div>

<div id="CYDReturned" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="CYDReturned">CYD Returned?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="CYDReturned-0">
      <input name="CYDReturned" id="CYDReturned-0" value="Yes complete with Legal and General"  type="radio" <?php if(isset($CYDReturned)) { if($CYDReturned=='Yes complete with Legal and General') { echo "checked='checked'";}}?>>
      Yes complete with Legal and General
    </label> 
    <label class="radio-inline" for="CYDReturned-1">
      <input name="CYDReturned" id="CYDReturned-1" value="Yes Legal and General not received" type="radio" <?php if(isset($CYDReturned)) { if($CYDReturned=='Yes Legal and General not received') { echo "checked='checked'";}}?>>
      Yes Legal and General not received
    </label> 
    <label class="radio-inline" for="CYDReturned-2">
      <input name="CYDReturned" id="CYDReturned-2" value="No" type="radio" <?php if(isset($CYDReturned)) { if($CYDReturned=='No') { echo "checked='checked'";}}?>>
      No
    </label>
  </div>
</div>
    
</div>

<div id="RemindDD" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="RemindDD">Remind/Cancel Old/New DD</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="RemindDD-0">
      <input name="RemindDD" id="RemindDD-0" value="Old DD Cancelled"  type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Old DD Cancelled') { echo "checked='checked'";}}?>>
      Old DD Cancelled
    </label> 
    <label class="radio-inline" for="RemindDD-1">
      <input name="RemindDD" id="RemindDD-1" value="Old DD Not Cancelled" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Old DD Not Cancelled') { echo "checked='checked'";}}?>>
      Old DD Not Cancelled
    </label> 
    <label class="radio-inline" for="RemindDD-2">
      <input name="RemindDD" id="RemindDD-2" value="Replacing Legal and General" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Replacing Legal and General') { echo "checked='checked'";}}?>>
      Replacing Legal and General
    </label> 
    <label class="radio-inline" for="RemindDD-3">
      <input name="RemindDD" id="RemindDD-3" value="Keeping Old Policy" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Keeping Old Policy') { echo "checked='checked'";}}?>>
      Keeping Old Policy
    </label>
          <label class="radio-inline" for="RemindDD-4">
      <input name="RemindDD" id="RemindDD-4" value="New Policy" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='New Policy') { echo "checked='checked'";}}?>>
      New Policy
    </label>
  </div>
</div>
    
</div>

<div id="PitchTPS" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="PitchTPS">Pitch TPS</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="PitchTPS-0">
      <input name="PitchTPS" id="PitchTPS-0" value="Wants"  type="radio" <?php if(isset($PitchTPS)) { if($PitchTPS=='Wants') { echo "checked='checked'";}}?>>
      Wants
    </label> 
    <label class="radio-inline" for="PitchTPS-1">
      <input name="PitchTPS" id="PitchTPS-1" value="Doesnt Want" type="radio" <?php if(isset($PitchTPS)) { if($PitchTPS=='Doesnt Want') { echo "checked='checked'";}}?>>
      Doesnt Want
    </label>
  </div>
</div>
    
</div>

<div id="PitchTrust" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="PitchTrust">Pitch Trust</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="PitchTrust-0">
      <input name="PitchTrust" id="PitchTrust-0" value="Wants by Post"  type="radio" <?php if(isset($PitchTrust)) { if($PitchTrust=='Wants by Post') { echo "checked='checked'";}}?>>
      Wants by Post
    </label> 
    <label class="radio-inline" for="PitchTrust-1">
      <input name="PitchTrust" id="PitchTrust-1" value="Wants by Email" type="radio" <?php if(isset($PitchTrust)) { if($PitchTrust=='Wants by Email') { echo "checked='checked'";}}?>>
      Wants by Email
    </label> 
    <label class="radio-inline" for="PitchTrust-2">
      <input name="PitchTrust" id="PitchTrust-2" value="Doesnt Want" type="radio" <?php if(isset($PitchTrust)) { if($PitchTrust=='Doesnt Want') { echo "checked='checked'";}}?>>
      Doesnt Want
    </label> 
    <label class="radio-inline" for="PitchTrust-3">
      <input name="PitchTrust" id="PitchTrust-3" value="Both" type="radio"<?php if(isset($PitchTrust)) { if($PitchTrust=='Both') { echo "checked='checked'";}}?>>
      Both
    </label>
  </div>
</div>
    
</div>

<div id="Upsells" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="Upsells">Upsells</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Upsells-0">
      <input name="Upsells" id="Upsells-0" value="No"  type="radio" <?php if(isset($Upsells)) { if($Upsells=='No') { echo "checked='checked'";}}?>>
      No
    </label> 
    <label class="radio-inline" for="Upsells-1">
      <input name="Upsells" id="Upsells-1" value="Yes" type="radio" <?php if(isset($Upsells)) { if($Upsells=='Yes') { echo "checked='checked'";}}?>>
      Yes
    </label>
  </div>
</div>
    
</div>                

                </form> 
   </center>       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>    
<?php } ?>
</body>
</html>