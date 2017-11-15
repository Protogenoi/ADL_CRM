<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

include('../../includes/user_tracking.php'); 
include('../../includes/adl_features.php');
include('../../includes/Access_Levels.php');
include('../../includes/ADL_PDO_CON.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($EXECUTE)) {
    if($EXECUTE=='1') {
    
$EWS_STATUS= filter_input(INPUT_POST, 'EWS_STATUS', FILTER_SANITIZE_SPECIAL_CHARS);
$EWS_USER= filter_input(INPUT_POST, 'EWS_USER', FILTER_SANITIZE_SPECIAL_CHARS);

$dupe = $pdo->prepare("SELECT status FROM assign_ews_status WHERE status=:STATUS");
    
        $dupe->bindParam(':STATUS', $EWS_STATUS, PDO::PARAM_STR);
        $dupe->execute()or die(print_r($dupe->errorInfo(), true));
        if ($dupe->rowCount()<=0) {
            
            $INSERT = $pdo->prepare("INSERT INTO assign_ews_status set assigned=:assign, status=:STATUS");
            $INSERT->bindParam(':STATUS', $EWS_STATUS, PDO::PARAM_STR);
        $INSERT->bindParam(':assign', $EWS_USER, PDO::PARAM_STR);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));

            $INSERT_EWS = $pdo->prepare("UPDATE ews_data set assigned=:assign WHERE ews_status_status=:STATUS");
            $INSERT_EWS->bindParam(':STATUS', $EWS_STATUS, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':assign', $EWS_USER, PDO::PARAM_STR);
        $INSERT_EWS->execute()or die(print_r($INSERT_EWS->errorInfo(), true));        
        
        if ($INSERT->rowCount()>=1) {
            
            if(isset($fferror)) {
                if($fferror=='0') {
                    header('Location: /admin/Admindash.php?EWSassigned=y&EWSSelect=y&EWSassignedTo='.$EWS_USER.'&TASKUPDATED='.$EWS_STATUS); die;
                    }
                    }
            
        }
        
        }
        
        elseif ($dupe->rowCount()>=1) {
            
            $UPDATE = $pdo->prepare("UPDATE assign_ews_status set assigned=:assign WHERE status=:STATUS");
            $UPDATE->bindParam(':STATUS', $EWS_STATUS, PDO::PARAM_STR);
            $UPDATE->bindParam(':assign', $EWS_USER, PDO::PARAM_STR);
            $UPDATE->execute()or die(print_r($UPDATE->errorInfo(), true));
            

            $UPDATE_EWS = $pdo->prepare("UPDATE ews_data set assigned=:assign WHERE ews_status_status=:STATUS");
            $UPDATE_EWS->bindParam(':STATUS', $EWS_STATUS, PDO::PARAM_STR);
            $UPDATE_EWS->bindParam(':assign', $EWS_USER, PDO::PARAM_STR);
            $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));        
                    
            
            if(isset($fferror)) {
                if($fferror=='0') {
                    header('Location: /admin/Admindash.php?EWSassigned=y&EWSSelect=y&EWSassignedTo='.$EWS_USER.'&TASKUPDATED='.$EWS_STATUS); die;
                    }
                    }
        
        
        }

 
    

    }

}

else {

        if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: /admin/Admindash.php?EWSassigned=failed&EWSSelect=y'); die;
    }
        }


}

