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
 * 
*/  

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/adl_features.php');

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../../../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isSET($fferror)) {
    if ($fferror == '0') {
        ini_SET('display_errors', 1);
        ini_SET('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {

    $CID = filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
    $INSURER = filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($EXECUTE == '1') {

        $CLIENT_NAME = filter_input(INPUT_POST, 'CLIENT_NAME', FILTER_SANITIZE_SPECIAL_CHARS);
        $POLICY_REF = filter_input(INPUT_POST, 'POLICY_REF', FILTER_SANITIZE_SPECIAL_CHARS);
        $PLAN = filter_input(INPUT_POST, 'PLAN', FILTER_SANITIZE_SPECIAL_CHARS);
        $TYPE = filter_input(INPUT_POST, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        $COVER = filter_input(INPUT_POST, 'COVER', FILTER_SANITIZE_SPECIAL_CHARS);
        $COVER_TYPE = filter_input(INPUT_POST, 'COVER_TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        $SIC_OPT = filter_input(INPUT_POST, 'SIC_OPT', FILTER_SANITIZE_SPECIAL_CHARS);
        $WELLNESS_OPT = filter_input(INPUT_POST, 'WELLNESS_OPT', FILTER_SANITIZE_SPECIAL_CHARS);
        $WELLNESS = filter_input(INPUT_POST, 'WELLNESS', FILTER_SANITIZE_SPECIAL_CHARS);
        $PREMIUM = filter_input(INPUT_POST, 'PREMIUM', FILTER_SANITIZE_SPECIAL_CHARS);
        $PREMIUM_SIC = filter_input(INPUT_POST, 'PREMIUM_SIC', FILTER_SANITIZE_SPECIAL_CHARS);
        $COMM_TYPE = filter_input(INPUT_POST, 'COMMS_TYPE', FILTER_SANITIZE_SPECIAL_CHARS);
        $COMMS = filter_input(INPUT_POST, 'COMM', FILTER_SANITIZE_SPECIAL_CHARS);
        $NON_INDEM_COMM = filter_input(INPUT_POST, 'NON_INDEM_COMM', FILTER_SANITIZE_SPECIAL_CHARS);
        $COVER_AMOUNT = filter_input(INPUT_POST, 'COVER_AMOUNT', FILTER_SANITIZE_SPECIAL_CHARS);
        $TERM = filter_input(INPUT_POST, 'TERM', FILTER_SANITIZE_SPECIAL_CHARS);
        $CB_TERM = filter_input(INPUT_POST, 'CB_TERM', FILTER_SANITIZE_SPECIAL_CHARS);
        $DRIP = filter_input(INPUT_POST, 'DRIP', FILTER_SANITIZE_SPECIAL_CHARS);
        $CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
        $AGENT = filter_input(INPUT_POST, 'AGENT', FILTER_SANITIZE_SPECIAL_CHARS);
        $SALE_DATE = filter_input(INPUT_POST, 'SALE_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
        $SUB_DATE = filter_input(INPUT_POST, 'SUB_DATE', FILTER_SANITIZE_SPECIAL_CHARS);
        $POLICY_STATUS = filter_input(INPUT_POST, 'POLICY_STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $KID_NAME_1 = filter_input(INPUT_POST, 'KID_NAME_1', FILTER_SANITIZE_SPECIAL_CHARS);
        $KID_DOB_1 = filter_input(INPUT_POST, 'KID_DOB_1', FILTER_SANITIZE_SPECIAL_CHARS);
        $KID_AMOUNT_1 = filter_input(INPUT_POST, 'KID_AMOUNT_1', FILTER_SANITIZE_SPECIAL_CHARS);
        $KID_OPT_1 = filter_input(INPUT_POST, 'KID_OPT_1', FILTER_SANITIZE_SPECIAL_CHARS);    
        
        $CID=133888;

        if ($POLICY_STATUS == "Awaiting" || $POLICY_REF=="TBC") {
            $sale_date = "TBC";
            $DATE = date("Y/m/d h:i:s");
            $DATE_FOR_TBC_POL = preg_replace("/[^0-9]/", "", $DATE);
            $POLICY_STATUS="Awaiting";

            $POLICY_REF = "TBC $DATE_FOR_TBC_POL";
        }
        
        if(isset($INSURER)) {

        $database = new Database(); 
        $database->beginTransaction();   
            
            if($INSURER == 'Vitality') {
                
        $database->query("SELECT vitality_policy_ref from vitality_policy where vitality_policy_ref=:REF");
        $database->bind(':REF', $POLICY_REF);
        $database->execute();           
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupepol="$row[vitality_policy_ref] DUPE";

$database->query("INSERT INTO adl_policy SET 
 adl_policy_client_id_fk=:CID,
 adl_policy_ref=:REF,
 adl_policy_insurer=:INSURER,
 adl_policy_policy_holder=:HOLDER,
 adl_policy_added_by=:WHO,
 adl_policy_closer=:CLOSER,
 adl_policy_agent=:AGENT,
 adl_policy_sale_date=:SALE_DATE,
 adl_policy_sub_date=:SUB_DATE,
 adl_policy_status=:STATUS");
            $database->bind(':CID', $CID);
            $database->bind(':REF', $dupepol);
            $database->bind(':INSURER', $INSURER);
            $database->bind(':HOLDER',$CLIENT_NAME);
            $database->bind(':WHO',$hello_name);
            $database->bind(':CLOSER',$CLOSER);
            $database->bind(':AGENT',$AGENT);
            $database->bind(':SALE_DATE',$SALE_DATE);
            $database->bind(':SUB_DATE',$SUB_DATE);
            $database->bind(':STATUS', $POLICY_STATUS);
            $database->execute();
            $lastid =  $database->lastInsertId();     
            
     if ($database->rowCount()>=0) {         

            $database->query("INSERT INTO vitality_policy SET 
 vitality_policy_id_fk=:PID,
 vitality_policy_ref=:REF,
 vitality_policy_plan=:PLAN,
 vitality_policy_type=:TYPE,
 vitality_policy_cover=:COVER,
 vitality_policy_cover_Type=:COVER_TYPE,
 vitality_policy_sic_opt=:SIC_OPT,
 vitality_policy_term_prem=:TERM_PREM,
 vitality_policy_wellness=:WELLNESS,
 vitality_policy_premium=:PREMIUM,
 vitality_policy_premium_sic=:PREMIUM_SIC,
 vitality_policy_comms_type=:COMM_TYPE,
 vitality_policy_comms=:COMM,
 vitality_policy_non_indem_comms=:NON_IDEM_COMM,
 vitality_policy_cover_amount=:COVER_AMOUNT,
 vitality_policy_policy_term=:POLICY_TERM,
 vitality_policy_cb_term=:CB_TERM,
 vitality_policy_drip=:DRIP");
            $database->bind(':PID', $lastid);
            $database->bind(':REF', $dupepol);
            $database->bind(':PLAN', $PLAN);
            $database->bind(':TYPE',$TYPE);
            $database->bind(':COVER',$COVER);
            $database->bind(':COVER_TYPE',$COVER_TYPE);
            $database->bind(':SIC_OPT',$SIC_OPT);
            $database->bind(':TERM_PREM',$WELLNESS_OPT);
            $database->bind(':WELLNESS',$WELLNESS);
            $database->bind(':PREMIUM', $PREMIUM);
            $database->bind(':PREMIUM_SIC', $PREMIUM_SIC);
            $database->bind(':COMM_TYPE', $COMM_TYPE);
            $database->bind(':COMM', $COMMS);
            $database->bind(':NON_IDEM_COMM', $NON_INDEM_COMM);
            $database->bind(':COVER_AMOUNT', $COVER_AMOUNT);
            $database->bind(':POLICY_TERM', $TERM);
            $database->bind(':CB_TERM', $CB_TERM);
            $database->bind(':DRIP', $DRIP);
            $database->execute(); 
            $lastid =  $database->lastInsertId(); 
                
            $database->query("INSERT INTO vitality_policy_kids_sic SET 
 vitality_policy_kids_sic_id_fk=:REF,
 vitality_policy_kids_sic_name=:NAME,
 vitality_policy_kids_sic_dob=:DOB,
 vitality_policy_kids_sic_amount=:AMOUNT,
 vitality_policy_kids_sic_opt=:OPT");
            $database->bind(':REF', $lastid);
            $database->bind(':NAME', $KID_NAME_1);
            $database->bind(':DOB', $KID_DOB_1);
            $database->bind(':AMOUNT',$KID_AMOUNT_1);
            $database->bind(':OPT',$KID_OPT_1);
            $database->execute();     

            $messagedata = "Policy added $dupepol duplicate of $POLICY_REF";

            $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG");
            $query->bindParam(':CID', $CID, PDO::PARAM_INT);
            $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':HOLDER', $CLIENT_NAME, PDO::PARAM_STR, 500);
            $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
            $query->execute();

            $client_type = $pdo->prepare("UPDATE client_details SET client_type='Life' WHERE client_id =:client_id");
            $client_type->bindParam(':client_id', $CID, PDO::PARAM_STR);
            $client_type->execute();
            
            $database->endTransaction(); 

                    header('Location: ../../../app/Client.php?policyadded=y&search=' . $CID . '&dupepolicy=' . $dupepol . '&origpolicy=' . $POLICY_REF);
                    die;
                    
            }
            
        }
            
$database->query("INSERT INTO adl_policy SET 
 adl_policy_client_id_fk=:CID,
 adl_policy_ref=:REF,
 adl_policy_insurer=:INSURER,
 adl_policy_policy_holder=:HOLDER,
 adl_policy_added_by=:WHO,
 adl_policy_closer=:CLOSER,
 adl_policy_agent=:AGENT,
 adl_policy_sale_date=:SALE_DATE,
 adl_policy_sub_date=:SUB_DATE,
 adl_policy_status=:STATUS");
            $database->bind(':CID', $CID);
            $database->bind(':REF', $POLICY_REF);
            $database->bind(':INSURER', $INSURER);
            $database->bind(':HOLDER',$CLIENT_NAME);
            $database->bind(':WHO',$hello_name);
            $database->bind(':CLOSER',$CLOSER);
            $database->bind(':AGENT',$AGENT);
            $database->bind(':SALE_DATE',$SALE_DATE);
            $database->bind(':SUB_DATE',$SUB_DATE);
            $database->bind(':STATUS', $POLICY_STATUS);
            $database->execute();
            $lastid =  $database->lastInsertId();            
    
            if ($database->rowCount()>=0) { 

            $database->query("INSERT INTO vitality_policy SET 
 vitality_policy_id_fk=:PID,
 vitality_policy_ref=:REF,
 vitality_policy_plan=:PLAN,
 vitality_policy_type=:TYPE,
 vitality_policy_cover=:COVER,
 vitality_policy_cover_Type=:COVER_TYPE,
 vitality_policy_sic_opt=:SIC_OPT,
 vitality_policy_term_prem=:TERM_PREM,
 vitality_policy_wellness=:WELLNESS,
 vitality_policy_premium=:PREMIUM,
 vitality_policy_premium_sic=:PREMIUM_SIC,
 vitality_policy_comms_type=:COMM_TYPE,
 vitality_policy_comms=:COMM,
 vitality_policy_non_indem_comms=:NON_IDEM_COMM,
 vitality_policy_cover_amount=:COVER_AMOUNT,
 vitality_policy_policy_term=:POLICY_TERM,
 vitality_policy_cb_term=:CB_TERM,
 vitality_policy_drip=:DRIP");
            $database->bind(':PID', $lastid);
            $database->bind(':REF', $POLICY_REF);
            $database->bind(':PLAN', $PLAN);
            $database->bind(':TYPE',$TYPE);
            $database->bind(':COVER',$COVER);
            $database->bind(':COVER_TYPE',$COVER_TYPE);
            $database->bind(':SIC_OPT',$SIC_OPT);
            $database->bind(':TERM_PREM',$WELLNESS_OPT);
            $database->bind(':WELLNESS',$WELLNESS);
            $database->bind(':PREMIUM', $PREMIUM);
            $database->bind(':PREMIUM_SIC', $PREMIUM_SIC);
            $database->bind(':COMM_TYPE', $COMM_TYPE);
            $database->bind(':COMM', $COMMS);
            $database->bind(':NON_IDEM_COMM', $NON_INDEM_COMM);
            $database->bind(':COVER_AMOUNT', $COVER_AMOUNT);
            $database->bind(':POLICY_TERM', $TERM);
            $database->bind(':CB_TERM', $CB_TERM);
            $database->bind(':DRIP', $DRIP);
            $database->execute(); 
            $lastid =  $database->lastInsertId(); 
            
            $database->query("INSERT INTO vitality_policy_kids_sic SET 
 vitality_policy_kids_sic_id_fk=:REF,
 vitality_policy_kids_sic_name=:NAME,
 vitality_policy_kids_sic_dob=:DOB,
 vitality_policy_kids_sic_amount=:AMOUNT,
 vitality_policy_kids_sic_opt=:OPT");
            $database->bind(':REF', $lastid);
            $database->bind(':NAME', $KID_NAME_1);
            $database->bind(':DOB', $KID_DOB_1);
            $database->bind(':AMOUNT',$KID_AMOUNT_1);
            $database->bind(':OPT',$KID_OPT_1);            

        $messagedata = "Policy $POLICY_REF added";

        $query = $pdo->prepare("INSERT INTO client_note SET client_id=:CID, client_name=:HOLDER, sent_by=:SENT, note_type='Policy Added', message=:MSG");
        $query->bindParam(':CID', $CID, PDO::PARAM_INT);
        $query->bindParam(':SENT', $hello_name, PDO::PARAM_STR, 100);
        $query->bindParam(':HOLDER', $CLIENT_NAME, PDO::PARAM_STR, 500);
        $query->bindParam(':MSG', $messagedata, PDO::PARAM_STR, 2500);
        $query->execute();

        if(isset($POLICY_STATUS) && $POLICY_STATUS != 'On Hold') {  
                
        $database->query("SELECT adl_workflows_id FROM adl_workflows WHERE adl_workflows_client_id_fk=:CID");
        $database->bind(':CID', $CID);
        $database->execute();
        
        if ($database->rowCount() <=0 ) {
            
        if(isset($INSURER) && $INSURER == 'Vitality') {
            
        require_once(__DIR__ . '/../../../addon/Workflows/php/add_vitality_workflows.php');     
            
        }   else {            
            
        require_once(__DIR__ . '/../../../addon/Workflows/php/add_workflows.php'); 
        
        }
                            
        } 
        
        }
        
        $database->endTransaction(); 
        
       header('Location: /../../../../../app/Client.php?CLIENT_POLICY=1&search=' . $CID . '&CLIENT_POLICY_POL_NUM=' . $POLICY_REF);
       die;                      
            }           
                
                
                
            }
            
         
            
        }


} 

        }   
?>