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

require_once(__DIR__ . '/../../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../../includes/adlfunctions.php');

require_once(__DIR__ . '/../../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../../app/analyticstracking.php');
}

        require_once(__DIR__ . '/../../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$AID = filter_input(INPUT_GET, 'AID', FILTER_SANITIZE_NUMBER_INT);
$AIDFK = filter_input(INPUT_GET, 'AIDFK', FILTER_SANITIZE_NUMBER_INT);

if (isset($EXECUTE)) {
    if($EXECUTE=="1") {
        
    $CLOSER = filter_input(INPUT_POST, 'CLOSER', FILTER_SANITIZE_SPECIAL_CHARS);
    $AGENT = filter_input(INPUT_POST, 'AGENT', FILTER_SANITIZE_SPECIAL_CHARS);
    $REFERENCE = filter_input(INPUT_POST, 'REFERENCE', FILTER_SANITIZE_SPECIAL_CHARS);
    $GRADE = filter_input(INPUT_POST, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $INSURER='Royal London';
    
    $GRADE_ARRAY=array("Red","Amber","Green","Saved");
    
    if(isset($GRADE) && !in_array($GRADE,$GRADE_ARRAY)) {
        $GRADE="Saved";
    } 
    
    $UPDATE_AUDIT_QRY = $pdo->prepare("UPDATE
                                            adl_audits
                                        SET 
                                            adl_audits_auditor_edit=:HELLO,
                                            adl_audits_grade=:GRADE, 
                                            adl_audits_closer=:CLOSER, 
                                            adl_audits_agent=:AGENT, 
                                            adl_audits_ref=:PLAN
                                        WHERE
                                            adl_audits_insurer=:INSURER
                                        AND
                                            adl_audits_id=:AID");
    $UPDATE_AUDIT_QRY->bindParam(':AID', $AID, PDO::PARAM_INT);
    $UPDATE_AUDIT_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR, 100);
    $UPDATE_AUDIT_QRY->bindParam(':GRADE', $GRADE, PDO::PARAM_STR, 100);
    $UPDATE_AUDIT_QRY->bindParam(':CLOSER', $CLOSER, PDO::PARAM_STR, 100);
    $UPDATE_AUDIT_QRY->bindParam(':AGENT', $AGENT, PDO::PARAM_STR, 100);
    $UPDATE_AUDIT_QRY->bindParam(':PLAN', $REFERENCE, PDO::PARAM_STR, 100);
    $UPDATE_AUDIT_QRY->bindParam(':INSURER', $INSURER, PDO::PARAM_STR, 100);
    $UPDATE_AUDIT_QRY->execute()or die(print_r($UPDATE_AUDIT_QRY->errorInfo(), true));

    $OD_Q1 = filter_input(INPUT_POST, 'OD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q2 = filter_input(INPUT_POST, 'OD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q3 = filter_input(INPUT_POST, 'OD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q4 = filter_input(INPUT_POST, 'OD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_Q5 = filter_input(INPUT_POST, 'OD_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICN_Q1 = filter_input(INPUT_POST, 'ICN_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q2 = filter_input(INPUT_POST, 'ICN_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q3 = filter_input(INPUT_POST, 'ICN_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_Q4 = filter_input(INPUT_POST, 'ICN_Q4', FILTER_SANITIZE_SPECIAL_CHARS); 
    $ICN_Q5 = filter_input(INPUT_POST, 'ICN_Q5', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $CD_Q1 = filter_input(INPUT_POST, 'CD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q2 = filter_input(INPUT_POST, 'CD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q3 = filter_input(INPUT_POST, 'CD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q4 = filter_input(INPUT_POST, 'CD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q5 = filter_input(INPUT_POST, 'CD_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q6 = filter_input(INPUT_POST, 'CD_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q7 = filter_input(INPUT_POST, 'CD_Q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_Q8 = filter_input(INPUT_POST, 'CD_Q8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $OTHER_Q1 = filter_input(INPUT_POST, 'OTHER_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTHER_Q2 = filter_input(INPUT_POST, 'OTHER_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTHER_Q3 = filter_input(INPUT_POST, 'OTHER_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $L_Q1 = filter_input(INPUT_POST, 'L_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q2 = filter_input(INPUT_POST, 'L_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q3 = filter_input(INPUT_POST, 'L_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q4 = filter_input(INPUT_POST, 'L_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q5 = filter_input(INPUT_POST, 'L_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q6 = filter_input(INPUT_POST, 'L_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q7 = filter_input(INPUT_POST, 'L_Q7', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_Q8 = filter_input(INPUT_POST, 'L_Q8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $O_Q1 = filter_input(INPUT_POST, 'O_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $O_Q2 = filter_input(INPUT_POST, 'O_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $O_Q3 = filter_input(INPUT_POST, 'O_Q3', FILTER_SANITIZE_SPECIAL_CHARS);      
    
    $FAM_Q1 = filter_input(INPUT_POST, 'FAM_Q1', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $H_Q1 = filter_input(INPUT_POST, 'H_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_Q2 = filter_input(INPUT_POST, 'H_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_Q3 = filter_input(INPUT_POST, 'H_Q3', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $BD_Q1 = filter_input(INPUT_POST, 'BD_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_Q2 = filter_input(INPUT_POST, 'BD_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_Q3 = filter_input(INPUT_POST, 'BD_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_Q4 = filter_input(INPUT_POST, 'BD_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_Q5 = filter_input(INPUT_POST, 'BD_Q5', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $DEC_Q1 = filter_input(INPUT_POST, 'DEC_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_Q2 = filter_input(INPUT_POST, 'DEC_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_Q3 = filter_input(INPUT_POST, 'DEC_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_Q4 = filter_input(INPUT_POST, 'DEC_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_Q5 = filter_input(INPUT_POST, 'DEC_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_Q6 = filter_input(INPUT_POST, 'DEC_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_Q7 = filter_input(INPUT_POST, 'DEC_Q7', FILTER_SANITIZE_SPECIAL_CHARS);

    $QC_Q1 = filter_input(INPUT_POST, 'QC_Q1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q2 = filter_input(INPUT_POST, 'QC_Q2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q3 = filter_input(INPUT_POST, 'QC_Q3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q4 = filter_input(INPUT_POST, 'QC_Q4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q5 = filter_input(INPUT_POST, 'QC_Q5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q6 = filter_input(INPUT_POST, 'QC_Q6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_Q7 = filter_input(INPUT_POST, 'QC_Q7', FILTER_SANITIZE_SPECIAL_CHARS);  
    
    $OD_C1 = filter_input(INPUT_POST, 'OD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C2 = filter_input(INPUT_POST, 'OD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C3 = filter_input(INPUT_POST, 'OD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C4 = filter_input(INPUT_POST, 'OD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $OD_C5 = filter_input(INPUT_POST, 'OD_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $ICN_C1 = filter_input(INPUT_POST, 'ICN_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C2 = filter_input(INPUT_POST, 'ICN_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C3 = filter_input(INPUT_POST, 'ICN_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C4 = filter_input(INPUT_POST, 'ICN_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $ICN_C5 = filter_input(INPUT_POST, 'ICN_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $CD_C1 = filter_input(INPUT_POST, 'CD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C2 = filter_input(INPUT_POST, 'CD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C3 = filter_input(INPUT_POST, 'CD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C4 = filter_input(INPUT_POST, 'CD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C5 = filter_input(INPUT_POST, 'CD_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C6 = filter_input(INPUT_POST, 'CD_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C7 = filter_input(INPUT_POST, 'CD_C7', FILTER_SANITIZE_SPECIAL_CHARS);
    $CD_C8 = filter_input(INPUT_POST, 'CD_C8', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $OTHER_C1 = filter_input(INPUT_POST, 'OTHER_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTHER_C2 = filter_input(INPUT_POST, 'OTHER_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $OTHER_C3 = filter_input(INPUT_POST, 'OTHER_C3', FILTER_SANITIZE_SPECIAL_CHARS);   
    
    $O_C1 = filter_input(INPUT_POST, 'O_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $O_C2 = filter_input(INPUT_POST, 'O_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $O_C3 = filter_input(INPUT_POST, 'O_C3', FILTER_SANITIZE_SPECIAL_CHARS);  
    
    $L_C1 = filter_input(INPUT_POST, 'L_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C2 = filter_input(INPUT_POST, 'L_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $L_C3 = filter_input(INPUT_POST, 'L_C3', FILTER_SANITIZE_SPECIAL_CHARS);  
    $L_C4 = filter_input(INPUT_POST, 'L_C4', FILTER_SANITIZE_SPECIAL_CHARS); 
    $L_C5 = filter_input(INPUT_POST, 'L_C5', FILTER_SANITIZE_SPECIAL_CHARS); 
    $L_C6 = filter_input(INPUT_POST, 'L_C6', FILTER_SANITIZE_SPECIAL_CHARS); 
    $L_C7 = filter_input(INPUT_POST, 'L_C7', FILTER_SANITIZE_SPECIAL_CHARS); 
    $L_C8 = filter_input(INPUT_POST, 'L_C8', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $FAM_C1 = filter_input(INPUT_POST, 'FAMC1', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    $H_C1 = filter_input(INPUT_POST, 'H_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_C2 = filter_input(INPUT_POST, 'H_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $H_C3 = filter_input(INPUT_POST, 'H_C3', FILTER_SANITIZE_SPECIAL_CHARS); 
    $H_C4 = filter_input(INPUT_POST, 'H_C4', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $BD_C1 = filter_input(INPUT_POST, 'BD_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_C2 = filter_input(INPUT_POST, 'BD_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_C3 = filter_input(INPUT_POST, 'BD_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_C4 = filter_input(INPUT_POST, 'BD_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $BD_C5 = filter_input(INPUT_POST, 'BD_C5', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    $DEC_C1 = filter_input(INPUT_POST, 'DEC_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_C2 = filter_input(INPUT_POST, 'DEC_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_C3 = filter_input(INPUT_POST, 'DEC_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_C4 = filter_input(INPUT_POST, 'DEC_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_C5 = filter_input(INPUT_POST, 'DEC_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_C6 = filter_input(INPUT_POST, 'DEC_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $DEC_C7 = filter_input(INPUT_POST, 'DEC_C7', FILTER_SANITIZE_SPECIAL_CHARS);

    $QC_C1 = filter_input(INPUT_POST, 'QC_C1', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C2 = filter_input(INPUT_POST, 'QC_C2', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C3 = filter_input(INPUT_POST, 'QC_C3', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C4 = filter_input(INPUT_POST, 'QC_C4', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C5 = filter_input(INPUT_POST, 'QC_C5', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C6 = filter_input(INPUT_POST, 'QC_C6', FILTER_SANITIZE_SPECIAL_CHARS);
    $QC_C7 = filter_input(INPUT_POST, 'QC_C7', FILTER_SANITIZE_SPECIAL_CHARS);    
    
     $UPDATE_QUES_QRY = $pdo->prepare("UPDATE
                                            adl_audit_royal_london
                                        SET
  adl_audit_royal_london_ref=:REF,
  adl_audit_royal_london_od1=:OD1,
  adl_audit_royal_london_od2=:OD2,
  adl_audit_royal_london_od3=:OD3,
  adl_audit_royal_london_od4=:OD4,
  adl_audit_royal_london_od5=:OD5,
  adl_audit_royal_london_icn1=:ICN1,
  adl_audit_royal_london_icn2=:ICN2,
  adl_audit_royal_london_icn3=:ICN3,
  adl_audit_royal_london_icn4=:ICN4,
  adl_audit_royal_london_icn5=:ICN5,
  adl_audit_royal_london_cd1=:CD1,
  adl_audit_royal_london_cd2=:CD2,
  adl_audit_royal_london_cd3=:CD3,
  adl_audit_royal_london_cd4=:CD4,
  adl_audit_royal_london_cd5=:CD5,
  adl_audit_royal_london_cd6=:CD6,
  adl_audit_royal_london_cd7=:CD7,
  adl_audit_royal_london_cd8=:CD8,
  adl_audit_royal_london_other1=:OTHER1,
  adl_audit_royal_london_other2=:OTHER2,
  adl_audit_royal_london_other3=:OTHER3,
  adl_audit_royal_london_o1=:O1,
  adl_audit_royal_london_o2=:O2,
  adl_audit_royal_london_o3=:O3,
  adl_audit_royal_london_l1=:L1,
  adl_audit_royal_london_l2=:L2,
  adl_audit_royal_london_l3=:L3,
  adl_audit_royal_london_l4=:L4,
  adl_audit_royal_london_l5=:L5,
  adl_audit_royal_london_l6=:L6,
  adl_audit_royal_london_l7=:L7,
  adl_audit_royal_london_l8=:L8,
  adl_audit_royal_london_fam1=:FAM1,
  adl_audit_royal_london_h1=:H1,
  adl_audit_royal_london_h2=:H2,
  adl_audit_royal_london_h3=:H3,
  adl_audit_royal_london_bd1=:BD1,
  adl_audit_royal_london_bd2=:BD2,
  adl_audit_royal_london_bd3=:BD3,
  adl_audit_royal_london_bd4=:BD4,
  adl_audit_royal_london_bd5=:BD5,
  adl_audit_royal_london_dec1=:DEC1,
  adl_audit_royal_london_dec2=:DEC2,
  adl_audit_royal_london_dec3=:DEC3,
  adl_audit_royal_london_dec4=:DEC4,
  adl_audit_royal_london_dec5=:DEC5,
  adl_audit_royal_london_dec6=:DEC6,
  adl_audit_royal_london_dec7=:DEC7,
  adl_audit_royal_london_qc1=:QC1,
  adl_audit_royal_london_qc2=:QC2,
  adl_audit_royal_london_qc3=:QC3,
  adl_audit_royal_london_qc4=:QC4,
  adl_audit_royal_london_qc5=:QC5,
  adl_audit_royal_london_qc6=:QC6,
  adl_audit_royal_london_qc7=:QC7
  WHERE
    adl_audit_royal_london_id_fk=:ID_FK");
    $UPDATE_QUES_QRY->bindParam(':ID_FK', $AID, PDO::PARAM_INT);
    $UPDATE_QUES_QRY->bindParam(':REF', $REFERENCE, PDO::PARAM_INT);
    $UPDATE_QUES_QRY->bindParam(':OD1', $OD_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OD2', $OD_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OD3', $OD_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OD4', $OD_Q4, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OD5', $OD_Q5, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':ICN1', $ICN_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':ICN2', $ICN_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':ICN3', $ICN_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':ICN4', $ICN_Q4, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':ICN5', $ICN_Q5, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':CD1', $CD_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD2', $CD_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD3', $CD_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD4', $CD_Q4, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD5', $CD_Q5, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD6', $CD_Q6, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD7', $CD_Q7, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':CD8', $CD_Q8, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OTHER1', $OTHER_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OTHER2', $OTHER_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':OTHER3', $OTHER_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':O1', $O_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':O2', $O_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':O3', $O_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':L1', $L_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':L2', $L_Q2, PDO::PARAM_STR);   
    $UPDATE_QUES_QRY->bindParam(':L3', $L_Q3, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':L4', $L_Q4, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':L5', $L_Q5, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':L6', $L_Q6, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':L7', $L_Q7, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':L8', $L_Q8, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':FAM1', $FAM_Q1, PDO::PARAM_STR);  
    $UPDATE_QUES_QRY->bindParam(':H1', $H_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':H2', $H_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':H3', $H_Q3, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':BD1', $BD_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':BD2', $BD_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':BD3', $BD_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':BD4', $BD_Q4, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':BD5', $BD_Q5, PDO::PARAM_STR);   
    $UPDATE_QUES_QRY->bindParam(':DEC1', $DEC_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':DEC2', $DEC_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':DEC3', $DEC_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':DEC4', $DEC_Q4, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':DEC5', $DEC_Q5, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':DEC6', $DEC_Q6, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':DEC7', $DEC_Q7, PDO::PARAM_STR); 
    $UPDATE_QUES_QRY->bindParam(':QC1', $QC_Q1, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':QC2', $QC_Q2, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':QC3', $QC_Q3, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':QC4', $QC_Q4, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':QC5', $QC_Q5, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':QC6', $QC_Q6, PDO::PARAM_STR);
    $UPDATE_QUES_QRY->bindParam(':QC7', $QC_Q7, PDO::PARAM_STR);    
    $UPDATE_QUES_QRY->execute()or die(print_r($UPDATE_QUES_QRY->errorInfo(), true));   
    

$UPDATE_COM_QRY = $pdo->prepare("UPDATE
                                            adl_audit_royal_london_c
                                        SET 
  adl_audit_royal_london_c_od1=:OD1,
  adl_audit_royal_london_c_od2=:OD2,
  adl_audit_royal_london_c_od3=:OD3,
  adl_audit_royal_london_c_od4=:OD4,
  adl_audit_royal_london_c_od5=:OD5,
  adl_audit_royal_london_c_icn1=:ICN1,
  adl_audit_royal_london_c_icn2=:ICN2,
  adl_audit_royal_london_c_icn3=:ICN3,
  adl_audit_royal_london_c_icn4=:ICN4,
  adl_audit_royal_london_c_icn5=:ICN5,
  adl_audit_royal_london_c_cd1=:CD1,
  adl_audit_royal_london_c_cd2=:CD2,
  adl_audit_royal_london_c_cd3=:CD3,
  adl_audit_royal_london_c_cd4=:CD4,
  adl_audit_royal_london_c_cd5=:CD5,
  adl_audit_royal_london_c_cd6=:CD6,
  adl_audit_royal_london_c_cd7=:CD7,
  adl_audit_royal_london_c_cd8=:CD8,
  adl_audit_royal_london_c_other1=:OTHER1,
  adl_audit_royal_london_c_other2=:OTHER2,
  adl_audit_royal_london_c_other3=:OTHER3,
  adl_audit_royal_london_c_l1=:L1,
  adl_audit_royal_london_c_l2=:L2,
  adl_audit_royal_london_c_l3=:L3,
  adl_audit_royal_london_c_l4=:L4,
  adl_audit_royal_london_c_l5=:L5,
  adl_audit_royal_london_c_l6=:L6,
  adl_audit_royal_london_c_l7=:L7,
  adl_audit_royal_london_c_l8=:L8
  WHERE
    adl_audit_royal_london_c_id_fk=:FK");
    $UPDATE_COM_QRY->bindParam(':FK', $AIDFK, PDO::PARAM_INT);
    $UPDATE_COM_QRY->bindParam(':OD1', $OD_C1, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':OD2', $OD_C2, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':OD3', $OD_C3, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':OD4', $OD_C4, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':OD5', $OD_C5, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':ICN1', $ICN_C1, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':ICN2', $ICN_C2, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':ICN3', $ICN_C3, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':ICN4', $ICN_C4, PDO::PARAM_STR); 
    $UPDATE_COM_QRY->bindParam(':ICN5', $ICN_C5, PDO::PARAM_STR); 
    $UPDATE_COM_QRY->bindParam(':CD1', $CD_C1, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD2', $CD_C2, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD3', $CD_C3, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD4', $CD_C4, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD5', $CD_C5, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD6', $CD_C6, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD7', $CD_C7, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':CD8', $CD_C8, PDO::PARAM_STR);   
    $UPDATE_COM_QRY->bindParam(':OTHER1', $OTHER_C1, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':OTHER2', $OTHER_C2, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':OTHER3', $OTHER_C3, PDO::PARAM_STR);   
    $UPDATE_COM_QRY->bindParam(':L1', $L_C1, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L2', $L_C2, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L3', $L_C3, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L4', $L_C4, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L5', $L_C5, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L6', $L_C6, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L7', $L_C7, PDO::PARAM_STR);
    $UPDATE_COM_QRY->bindParam(':L8', $L_C8, PDO::PARAM_STR);   
    $UPDATE_COM_QRY->execute()or die(print_r($UPDATE_COM_QRY->errorInfo(), true));      
    
    $UPDATE_C_EXTRA_QRY = $pdo->prepare("UPDATE
                                            adl_audit_royal_london_ce
                                        SET
  adl_audit_royal_london_ce_o1=:O1,
  adl_audit_royal_london_ce_o2=:O2,
  adl_audit_royal_london_ce_o3=:O3,
  adl_audit_royal_london_ce_fam1=:FAM1,
  adl_audit_royal_london_ce_h1=:H1,
  adl_audit_royal_london_ce_h2=:H2,
  adl_audit_royal_london_ce_h3=:H3,
  adl_audit_royal_london_ce_bd1=:BD1,
  adl_audit_royal_london_ce_bd2=:BD2,
  adl_audit_royal_london_ce_bd3=:BD3,
  adl_audit_royal_london_ce_bd4=:BD4,
  adl_audit_royal_london_ce_bd5=:BD5,
  adl_audit_royal_london_ce_dec1=:DEC1,
  adl_audit_royal_london_ce_dec2=:DEC2,
  adl_audit_royal_london_ce_dec3=:DEC3,
  adl_audit_royal_london_ce_dec4=:DEC4,
  adl_audit_royal_london_ce_dec5=:DEC5,
  adl_audit_royal_london_ce_dec6=:DEC6,
  adl_audit_royal_london_ce_dec7=:DEC7,
  adl_audit_royal_london_ce_qc1=:QC1,
  adl_audit_royal_london_ce_qc2=:QC2,
  adl_audit_royal_london_ce_qc3=:QC3,
  adl_audit_royal_london_ce_qc4=:QC4,
  adl_audit_royal_london_ce_qc5=:QC5,
  adl_audit_royal_london_ce_qc6=:QC6,
  adl_audit_royal_london_ce_qc7=:QC7
  WHERE
     adl_audit_royal_london_ce_id_fk =:FK");
  $UPDATE_C_EXTRA_QRY->bindParam(':FK', $AIDFK, PDO::PARAM_INT);
  $UPDATE_C_EXTRA_QRY->bindParam(':O1', $O_C1, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':O2', $O_C2, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':O3', $O_C3, PDO::PARAM_STR); 
  $UPDATE_C_EXTRA_QRY->bindParam(':FAM1', $FAM_C1, PDO::PARAM_STR);  
  $UPDATE_C_EXTRA_QRY->bindParam(':H1', $H_C1, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':H2', $H_C2, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':H3', $H_C3, PDO::PARAM_STR);    
  $UPDATE_C_EXTRA_QRY->bindParam(':BD1', $BD_C1, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':BD2', $BD_C2, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':BD3', $BD_C3, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':BD4', $BD_C4, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':BD5', $BD_C5, PDO::PARAM_STR);   
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC1', $DEC_C1, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC2', $DEC_C2, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC3', $DEC_C3, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC4', $DEC_C4, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC5', $DEC_C5, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC6', $DEC_C6, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':DEC7', $DEC_C7, PDO::PARAM_STR); 
  $UPDATE_C_EXTRA_QRY->bindParam(':QC1', $QC_C1, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':QC2', $QC_C2, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':QC3', $QC_C3, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':QC4', $QC_C4, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':QC5', $QC_C5, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':QC6', $QC_C6, PDO::PARAM_STR);
  $UPDATE_C_EXTRA_QRY->bindParam(':QC7', $QC_C7, PDO::PARAM_STR);  
  $UPDATE_C_EXTRA_QRY->execute()or die(print_r($UPDATE_C_EXTRA_QRY->errorInfo(), true));     
        
    }

    if ($AID >= '1') {
        header('Location: ../../search_audits.php?RETURN=ADDED&GRADE=' . $GRADE.'&INSURER='.$INSURER);
        die;
    } else {
        header('Location: ../../search_audits.php?RETURN=AuditEditFailed&Error');
        die;
    }
}

?>