<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
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

if ($fflife == '0') {

    header('Location: /../../../../CRMmain.php');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

    require_once(__DIR__ . '/../../classes/database_class.php');
    require_once(__DIR__ . '/../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->SelectToken();
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $CHECK_USER_LOGIN->CheckAccessLevel();
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }          
?>
<!DOCTYPE html>
<html>
    <title>ADL | Search Policy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <head>
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.css">
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>

        <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

        <div class="container">
            <div class="row">
                <div class="twelve columns">
                    <ul class="ca-menu">

                        <li>
                            <a href="/app/SearchClients.php">
                                <span class="ca-icon"><i class="fa fa-search"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Search<br/>Clients</h2>
                                    <h3 class="ca-sub"></h3>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>


            <?php
            if (isset($EXECUTE)) {
                if ($EXECUTE == 'Home') {
                    ?>

                    <table id="home" class="display" width="auto" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </tfoot>
                    </table>

                    <?php
                }
            }
            ?>

        </div>

        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
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
                            <h3>Populating client details... </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <?php
        if (isset($EXECUTE)) {
            if ($EXECUTE == 'Home') {
                ?>
                <script type="text/javascript" language="javascript" >
                    /* Formatting function for row details - modify as you need */
                    function format(d) {
                        // `d` is the original data object for the row
                        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                                '<tr>' +
                                '<td>Insurer:</td>' +
                                '<td>' + d.insurer + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Application Number:</td>' +
                                '<td>' + d.application_number + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Policy Type:</td>' +
                                '<td>' + d.type + ' </td>' +
                                '</tr>' +
                                '</table>';
                    }

                    $(document).ready(function () {
                        var table = $('#home').DataTable({
                            "response": true,
                            "processing": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
                            "language": {
                                "processing": "<div></div><div></div><div></div><div></div><div></div>"

                            },
                            "ajax": "/addon/Home/JSON/SearchPolicies.php?EXECUTE=Home&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                            "columns": [
                                {
                                    "className": 'details-control',
                                    "orderable": false,
                                    "data": null,
                                    "defaultContent": ''
                                },
                                {"data": "added_date"},
                                {"data": "client_name"},
                                {"data": "policy_number"},
                                {"data": "insurer"},
                                {"data": "status"},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="/Life/ViewClient.php?search=' + data + '">View</a>';
                                    }},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="Home/AddPolicy.php?Home=y&CID=' + data + '">Add Policy</a>';
                                    }},
                            ],
                            "order": [[1, 'asc']]
                        });

                        // Add event listener for opening and closing details
                        $('#policy tbody').on('click', 'td.details-control', function () {
                            var tr = $(this).closest('tr');
                            var row = table.row(tr);

                            if (row.child.isShown()) {
                                // This row is already open - close it
                                row.child.hide();
                                tr.removeClass('shown');
                            } else {
                                // Open this row
                                row.child(format(row.data())).show();
                                tr.addClass('shown');
                            }
                        });
                    });
                </script>
                <?php
            }
        }
        ?>
    </body>
</html>
