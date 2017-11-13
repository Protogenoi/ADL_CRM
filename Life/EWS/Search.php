<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 6);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../../includes/user_tracking.php'); 

require_once(__DIR__ . '../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

    require_once(__DIR__ . '../../../classes/database_class.php');
    require_once(__DIR__ . '../../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 6) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
    <title>ADL | Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php require_once(__DIR__ . '../../../includes/navbar.php'); ?>


        <div class="container">

            <?php

            if ($ffews == '1') {
                if(in_array($hello_name,$ADMIN_EWS_SEARCH_ACCESS)) {
              ?>
              
<div class='notice notice-primary' role='alert'><center><strong>Search clients</strong></center></div> 

                <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Post Code</th>
                            <th>Policy</th>
                            <th>Clawback Due</th>
                            <th>Clawback Date</th>
                            <th>Off Risk Date</th>
                            <th>Assigned</th>
                            <th>Warning</th>
                            <th>Colour</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Post Code</th>
                            <th>Policy</th>
                            <th>Clawback Due</th>
                            <th>Clawback Date</th>
                            <th>Off Risk Date</th>
                            <th>Assigned</th>
                            <th>Warning</th>
                            <th>Colour</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table>  
            <?php 
              } }
            ?>
          
        </div>

        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/DataTable/datatables.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 


        <script type="text/javascript">
            $(document).ready(function () {


                $('#LOADING').modal('show');
            })

                    ;

            $(window).load(function () {
                $('#LOADING').modal('hide');
            });
        </script> 
        <div class="modal modal-static fade" id="LOADING" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                            <br>
                            <h3>Loading EWS... </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
<?php 
            if ($ffews == '1') {
                if(in_array($hello_name,$ADMIN_EWS_SEARCH_ACCESS)) { ?>
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "datatables/EWS.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "date_added"},
                        {"data": "client_name"},
                        {"data": "post_code"},
                        {"data": "policy_number"},
                        {"data": "clawback_due"},
                        {"data": "clawback_date"},
                        {"data": "off_risk_date"},
                        {"data": "assigned"},
                        {"data": "warning"},
                        {"data": "color_status"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
                            }}
                    ]
                });

            });           
        </script>
        
            <?php 
            
                    } 
                    
                    } 
            ?>
    </body>
</html>