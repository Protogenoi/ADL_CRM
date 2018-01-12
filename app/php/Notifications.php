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

if(isset($ffsms) && $ffsms=='1') {
    
                $database->query("SELECT 
    sms_inbound_id, sms_inbound_client_id, sms_inbound_phone, sms_inbound_msg, sms_inbound_date, sms_inbound_type
FROM
    sms_inbound
WHERE
        sms_inbound_type = 'SMS Failed' AND sms_inbound_phone=:PHONE");
            $database->bind(':PHONE', $Single_Client['phone_number']);
            $database->execute();
            $database->single();
            
                 if ($database->rowCount()>0) {  ?>
         
    <div class="notice notice-danger" role="alert" id="HIDELGKEY"><strong><i class="fa fa-exclamation"></i> Info:</strong> <?php echo $Single_Client["phone_number"]; ?> has a failed SMS delivery response! The number may no longer be active, if the client cannot be contacted via phone either. 
          <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>  
          
          <?php
          
          
                 }
          
          $CHECKSMS_FAILED="SMS has failed to be delivered to $Single_Client[phone_number]";
         
                $database->query("SELECT 
    note_id
FROM
    client_note
WHERE
        note_type='SMS Failed' AND message=:PHONE");
            $database->bind(':PHONE', $CHECKSMS_FAILED);
            $database->execute();
            $database->single();
            
                 if ($database->rowCount()>0) {  ?>
         
    <div class="notice notice-danger" role="alert" id="HIDELGKEY"><strong><i class="fa fa-mobile-phone"></i> Info:</strong> <?php echo $Single_Client["phone_number"]; ?> has a failed SMS delivery response! The number may no longer be active, if the client cannot be contacted via phone either. 
          <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>            
          
   <?php  $NUMBER_BAD='1'; 
   
                 }
   
                $database->query("SELECT 
    note_id
FROM
    client_note
WHERE
    note_type = 'Sent SMS: Welcome'
        AND client_id = :CID
        OR note_type = 'Sent SMS'
        AND message = 'Welcome'
        AND client_id =:CID2");
            $database->bind(':CID', $search);
            $database->bind(':CID2', $search);
            $database->execute();
            $database->single();
            
                 if ($database->rowCount()<=0) {  ?>
         
    <div class="notice notice-warning" role="alert" id="HIDELGKEY"><strong><i class="fa fa-mobile-phone"></i> Alert:</strong> No Welcome SMS has been sent to this client! 
          <a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>  
         
   <?php  }   
    
    
}

if(isset($WHICH_COMPANY)){     
    if($WHICH_COMPANY=='TRB WOL') {

 if(empty($WOL_CLOSER_AUDIT)) {
     echo "<div class='notice notice-info' role='alert' id='HIDECLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No WOL Closer audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSER'>&times;</a></div>";   }

  if(empty($WOL_LEAD_AUDIT)) {
     echo "<div class='notice notice-info' role='alert' id='HIDELEAD'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No WOL Lead Gen audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEAD'>&times;</a></div>";   
     
 }        
        
    }

//TRB    
    if($WHICH_COMPANY=='Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') {
        if (in_array($hello_name,$Level_8_Access, true)) {
        $database->query("select count(id) AS id from ews_data where policy_number IN(select policy_number from client_policy WHERE client_id=:CID) AND warning like '%NEW' ");
        $database->bind(':CID', $search);
        $database->execute(); 
        $EWS_COUNT_RESULT=$database->single(); 
        if ($database->rowCount()>=1) {
            $EWS_COUNT=$EWS_COUNT_RESULT['id'];
            if(isset($EWS_COUNT)) { if($EWS_COUNT>=1) {
                ?>
<div class="notice notice-danger" role="alert" id='HIDELGKEY'><strong><i class="fa fa-exclamation-circle fa-lg"></i> EWS:</strong> This client has <?php if(isset($EWS_COUNT)) { if($EWS_COUNT>=2) { echo "$EWS_COUNT policies on EWS"; } else { echo "1 policy on EWS"; } } ?> <i>(action required).</i>  </div>              
    <?php
    
}

            }

}

}

 if(empty($closeraudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDECLOSER'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Closer audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSER'>&times;</a></div>";   }

 if(empty($leadaudit)) {
     echo "<div class='notice notice-info' role='alert' id='HIDELEAD'><strong><i class='fa fa-headphones fa-lg'></i> Alert:</strong> No Lead Gen audit!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEAD'>&times;</a></div>";   
     
 }
    

            $database->query("select uploadtype from tbl_uploads where uploadtype='LGkeyfacts' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Legal & General Keyfacts not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
    $database->query("select uploadtype from tbl_uploads where uploadtype='LGpolicy' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGAPP'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Legal & General App not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGAPP'>&times;</a></div>";    
         
     }

     if($ffkeyfactsemail=='1') {
     if($client_date_added >= "2016-06-17 16:00:00" && $client_date_added <= "2017-04-24 11:54:00") {
         
         $database->query("select email_address from KeyFactsEmails where email_address=:email");
         $database->bind(':email', $clientonemail);
         $database->execute();
         $database->single();
         if ($database->rowCount()<=0) {  
         
    echo "<div class='notice notice-danger' role='alert' id='HIDECLOSERKF'><strong><i class='fa fa-envelope-o  fa-lg'></i> Alert:</strong> Keyfacts Email not sent <i>(Send from Files & Uploads tab)</i>!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>";     
         
     }      
     
     }      
     
}
    }
//END TRB


}

if(in_array($WHICH_COMPANY,$NEW_COMPANY_ARRAY,true) || in_array($WHICH_COMPANY,$OLD_COMPANY_ARRAY)) {
    
          if($client_date_added >= "2017-04-24 11:55:00") {
         
         $database->query("select keyfactsemail_email from keyfactsemail where keyfactsemail_email=:email");
         $database->bind(':email', $clientonemail);
         $database->execute();
         $database->single();
         if ($database->rowCount()<=0) {  
         
    echo "<div class='notice notice-danger' role='alert' id='HIDECLOSERKF'><strong><i class='fa fa-envelope-o  fa-lg'></i> Alert:</strong> Keyfacts Email not sent <i>(Send from Files & Uploads tab)</i>!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDECLOSERKF'>&times;</a></div>";    
         
     }      
     
     }    

    
     if($client_date_added <= "2017-03-07 16:25:00") {
        if(empty($leadid1)) {
        echo "<div class='notice notice-danger' role='alert' id='HIDELEADID'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Alert:</strong> No Recording ID added!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELEADID'>&times;</a></div>";
        
     } } else {


    $database->query("select uploadtype from tbl_uploads where uploadtype='Closer Call Recording' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-danger\" role=\"alert\" id='HIDEDEALSHEET'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Alert:</strong> Closer call recording not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDEALSHEET'>&times;</a></div>";    
         
     }
    $database->query("select uploadtype from tbl_uploads where uploadtype='Agent Call Recording' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-danger\" role=\"alert\" id='HIDEDEALSHEET'><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Alert:</strong> Agent call recording not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDEALSHEET'>&times;</a></div>";    
         
     }

     
     }
     
     
    if(!isset($dealsheet_id)) {
    $database->query("select uploadtype from tbl_uploads where uploadtype='Dealsheet' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDEDEALSHEET'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Dealsheet not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDEALSHEET'>&times;</a></div>";    
         
     }
}
}
     $dupepolicy= filter_input(INPUT_GET, 'dupepolicy', FILTER_SANITIZE_SPECIAL_CHARS);
     
     if(isset($dupepolicy)) {
         if(!empty($dupepolicy)) {
   $origpolicy= filter_input(INPUT_GET, 'origpolicy', FILTER_SANITIZE_SPECIAL_CHARS);
     
    echo "<div class='notice notice-danger' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Warning:</strong> Duplicate $origpolicy number found! Policy number changed to $dupepolicy<br><br><strong><i class='fa fa-exclamation-triangle fa-lg'></i> $hello_name:</strong> If you are replacing an old policy change old policy to $origpolicy OLD and remove DUPE from the newer updated policy.<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  

         }
     }      
           
            $Callback= filter_input(INPUT_GET, 'Callback', FILTER_SANITIZE_SPECIAL_CHARS);
            if(isset($Callback)){   
                $Callback= filter_input(INPUT_GET, 'Callback', FILTER_SANITIZE_SPECIAL_CHARS);
                if ($Callback =='y') {
                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-calendar\"></i> Success:</strong> Callback Set!</div>");
                    
                }
                if ($Callback =='fail') {
                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes were made!</div>");
                    
                }
                
                }
                        
                        $policydetailsadded= filter_input(INPUT_GET, 'policydetailsadded', FILTER_SANITIZE_SPECIAL_CHARS);
                        if(isset($policydetailsadded)){
                            $policydetailsadded= filter_input(INPUT_GET, 'policydetailsadded', FILTER_SANITIZE_SPECIAL_CHARS);
                            if ($policydetailsadded =='y') {
                                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client Pension Details Added!</div>");
                                
                            }
                            if ($policydetailsadded =='failed') {
                                print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> No changes were made!</div>");

                                
                            }
                            
                            }
                            
                            $taskedited= filter_input(INPUT_GET, 'taskedited', FILTER_SANITIZE_SPECIAL_CHARS);
                            if(isset($taskedited)){
                                $taskedited= filter_input(INPUT_GET, 'taskedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                if ($taskedited =='y') {
                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Task notes updated!</div>");
                                    
                                }
                                if ($taskedited =='n') {
                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Task notes NOT updated!</div>");
                                    
                                }
                                
                                }
                                
                                $policyedited= filter_input(INPUT_GET, 'policyedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                if(isset($policyedited)){
                                    $policyedited= filter_input(INPUT_GET, 'policyedited', FILTER_SANITIZE_SPECIAL_CHARS);
                                    if ($policyedited =='y') {
                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Policy details updated!</div>");
                                        
                                    }
                                    if ($policyedited =='n') {
                                        print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Policy details updated!</div>");
                                        
                                    }
                                    
                                    }
                                        
                                        $checklistupdated= filter_input(INPUT_GET, 'checklistupdated', FILTER_SANITIZE_SPECIAL_CHARS);
                                        if(isset($checklistupdated)){
                                            $checklistupdatedd= filter_input(INPUT_GET, 'checklistupdated', FILTER_SANITIZE_SPECIAL_CHARS);
                                            if ($checklistupdatedd =='y') {
                                                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Checklist updated!</div>");
                                                
                                            }
                                            if ($checklistupdatedd =='n') {
                                                print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Checklist not updated!</div>");
                                                
                                            } 
                                            
                                            }
                                            
                   $Addcallback= filter_input(INPUT_GET, 'Addcallback', FILTER_SANITIZE_SPECIAL_CHARS);
                                                
        
        if(isset($Addcallback)) {
            
            $callbackcompletedid= filter_input(INPUT_GET, 'callbackid', FILTER_SANITIZE_NUMBER_INT);
            
            if($Addcallback=='complete') {
                
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Callback $callbackcompletedid completed!</div>";
                
            }
            
            if($Addcallback=='incomplete') {
                
                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Callback set to incomplete!</div>";
                
            }
            
        }              
                   
                                                $taskcompleted= filter_input(INPUT_GET, 'taskcompleted', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($taskcompleted)){
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Task completed!</div>");
                                                    
                                                }
                                                
                                                $CLIENT_NOTE= filter_input(INPUT_GET, 'CLIENT_NOTE', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($CLIENT_NOTE)){
                                                    if($CLIENT_NOTE == 'ADDED') {
                                                    echo '<div class="notice notice-success" role="alert"><strong><i class="fa fa-pencil fa-lg"></i> Success:</strong> Client notes added!</div>';
                                                    }
                                                }
                                                
                                                    $emailsent= filter_input(INPUT_GET, 'emailsent', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    
                                                    if(isset($emailsent)){
                                                        
                                                        $emailtype= filter_input(INPUT_GET, 'emailtype', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        $emailto= filter_input(INPUT_GET, 'emailto', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        if(isset($emailtype)) {
                                                            if($emailtype="CloserKeyFacts"){
                                                          echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> Closer KeyFacts Email sent to <b>$emailto</b> !</div>";
                                                            }
                                                        }
                                                        
                                                        else 
                                                        {
                                                        $emailaddress= filter_input(INPUT_GET, 'emailto', FILTER_SANITIZE_EMAIL);
                                                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> Email sent to <b>$emailaddress</b> !</div>");
                                                        }
                                                    }                                                                                                      
                                                
                                                $workflow= filter_input(INPUT_GET, 'workflow', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($workflow)){
                                                    $stepcom= filter_input(INPUT_GET, 'workflow', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Success:</strong>  $stepcom updated</div>");
                                                    
                                                }
                                            
                                                
                                                $deletedpolicy= filter_input(INPUT_GET, 'deletedpolicy', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($deletedpolicy)){
                                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Policy deleted</strong></div>");
                                                    
                                                }

                                                $CallbackSet = filter_input(INPUT_GET, 'CallbackSet', FILTER_SANITIZE_NUMBER_INT);
                                                    if(isset($CallbackSet)){
                                                      if($CallbackSet=='1') {
                                                          
                                                        $CallbackTime= filter_input(INPUT_GET, 'CallbackTime', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        $CallbackDate= filter_input(INPUT_GET, 'CallbackDate', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Callback set for $CallbackTime $CallbackDate</strong></div>";

                               
                                                      }
                                                      
                                                      if($CallbackSet=='0') {
                                                          
                                                          echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> No call back changes made</strong></div>";
       
                                                                }
                                                    }
                                                    
//NEW NOTIFICATIONS //        
                                                $CLIENT_UPLOAD= filter_input(INPUT_GET, 'CLIENT_UPLOAD', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($CLIENT_UPLOAD)){
                                                    
                                                    $CLIENT_FILE= filter_input(INPUT_GET, 'CLIENT_FILE', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $CLIENT_FILE_COUNT= filter_input(INPUT_GET, 'CLIENT_FILE_COUNT', FILTER_SANITIZE_NUMBER_INT);
                                                    
                                                    if($CLIENT_UPLOAD== 1) {
                                                print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-upload fa-lg\"></i> Success:</strong> $CLIENT_FILE uploaded!</div>");        
                                                    }
                                                    if($CLIENT_UPLOAD== 0) {
                                                print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> $CLIENT_FILE <b>upload failed!</b></div>");   
                                                } 
                                                    if($CLIENT_UPLOAD== 2) {
                                                print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-cloud-upload fa-lg\"></i> UPLOAD FAILED:</strong> $CLIENT_FILE <b>File size to big!</b></div>");   
                                                }  
                                                    if($CLIENT_UPLOAD== 3) {
                                                echo("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> File ($CLIENT_FILE_COUNT) $CLIENT_FILE deleted</strong></div>\n");
                                                    }          
                                                    if($CLIENT_UPLOAD== 4) {
                                                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error file $CLIENT_FILE NOT deleted</strong></div>";
                                                } 
                                                
                                                }
                                                
                                                $CLIENT_TASK= filter_input(INPUT_GET, 'CLIENT_TASK', FILTER_SANITIZE_SPECIAL_CHARS);
                                                
                                                if(isset($CLIENT_TASK)){  
                                                    if ($CLIENT_TASK =='CYD') {
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> CYD Task Updated!</div>";   
                                                        
                                                    }
                                                    if ($CLIENT_TASK =='5 day') { 
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 5 Day Task Updated!</div>";  
                                                        
                                                    }
                                                    if ($CLIENT_TASK =='24 48') {
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 24-48 Day Task Updated!</div>";
                                                        
                                                    } 
                                                    if ($CLIENT_TASK =='18 day') {
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 18 Day Task Updated!</div>"; 
                                                        
                                                    }
                                                    
                                                    }  
                                                    
                                    $CLIENT_EDIT= filter_input(INPUT_GET, 'CLIENT_EDIT', FILTER_SANITIZE_SPECIAL_CHARS);
                                    if(isset($CLIENT_EDIT)){
                                        if ($CLIENT_EDIT == 1 ) {
                                            print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client details updated!</div>");
                                            
                                        }
                                        if ($CLIENT_EDIT == 0 ) {
                                            print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> Client details not updated!</div>");
                                            
                                        }
                                        
                                        }                                                   
                
                                                $CLIENT_POLICY= filter_input(INPUT_GET, 'CLIENT_POLICY', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($CLIENT_POLICY)){
                                                    $CLIENT_POLICY_POL_NUM= filter_input(INPUT_GET, 'CLIENT_POLICY_POL_NUM', FILTER_SANITIZE_NUMBER_INT);
                                                    if($CLIENT_POLICY==1){
                                                    print("<div class=\"notice notice-success\" role=\"alert\" id='HIDENEWPOLICY'><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Success:</strong> Policy $CLIENT_POLICY_POL_NUM added<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDENEWPOLICY'>&times;</a></div>");                                                   
                                                    }
                                                    if($CLIENT_POLICY==2){
                                                    print("<div class=\"notice notice-success\" role=\"alert\" id='HIDENEWPOLICY'><strong><i class=\"fa fa-exclamation-circle fa-lg\"></i> Success:</strong> Policy $CLIENT_POLICY_POL_NUM updated!<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDENEWPOLICY'>&times;</a></div>");                                                   
                                                    }                                                    
                                                }    
                                                

                $CLIENT_EWS= filter_input(INPUT_GET, 'CLIENT_EWS', FILTER_SANITIZE_SPECIAL_CHARS);
                
                if(isset($CLIENT_EWS)){  
                    $CLIENT_POLICY_POL_NUM= filter_input(INPUT_GET, 'CLIENT_POLICY_POL_NUM', FILTER_SANITIZE_NUMBER_INT);
                if ($CLIENT_EWS =='1') {
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> EWS Updated for policy $CLIENT_POLICY_POL_NUM!</div>";
                    
                }
                 
                }    
                
                                                    $EMAIL_SENT= filter_input(INPUT_GET, 'EMAIL_SENT', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    
                                                    if(isset($EMAIL_SENT)){
                                                        $CLIENT_EMAIL= filter_input(INPUT_GET, 'CLIENT_EMAIL', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        $EMAIL_SENT_TO= filter_input(INPUT_GET, 'EMAIL_SENT_TO', FILTER_SANITIZE_SPECIAL_CHARS);
                                                        if($EMAIL_SENT == 1) {
                                                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Email:</strong> $CLIENT_EMAIL sent to <b>$EMAIL_SENT_TO</b>!</div>";                                                            
                                                        }
                                                        if($EMAIL_SENT == 0) {
                                                        echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Email:</strong> $CLIENT_EMAIL failed to <b>$EMAIL_SENT_TO</b>!</div>";                                                            
                                                        }                                                        
                                                    }
                                                    
                                                 $CLIENT_SMS= filter_input(INPUT_GET, 'CLIENT_SMS', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($CLIENT_SMS)){
                                                    if($CLIENT_SMS == 1 ) {
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> SMS sent!</div>");
                                                    }
                                                }                                                       
                                                
$TSK_QRY = $pdo->prepare("select task from Client_Tasks WHERE client_id=:CID and complete ='0' and deadline <= CURDATE()");
$TSK_QRY->bindParam(':CID', $search, PDO::PARAM_INT);
                            $TSK_QRY->execute();
                            if ($TSK_QRY->rowCount()>0) { 
                            while ($result=$TSK_QRY->fetch(PDO::FETCH_ASSOC)){    ?>

         
    <div class="notice notice-default" role="alert" id='HIDELGKEY'><strong><i class="fa fa-tasks fa-lg"></i> Tasks To Do:</strong> <?php 
foreach ($result as $value) {
    echo "$value ";
}
?> deadline expired<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>   
         
                          <?php  }   }      
                          
if($WHICH_COMPANY=='Zurich') {
    
           $database->query("select uploadtype from tbl_uploads where uploadtype='Zurichkeyfacts' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Zurich Keyfacts not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
    $database->query("select uploadtype from tbl_uploads where uploadtype='Zurichpolicy' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGAPP'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Zurich App not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGAPP'>&times;</a></div>";    
         
     }    
}  

if($WHICH_COMPANY=='Scottish Widows') {
    
           $database->query("select uploadtype from tbl_uploads where uploadtype='SWkeyfacts' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Scottish Widows Keyfacts not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
    $database->query("select uploadtype from tbl_uploads where uploadtype='SWpolicy' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGAPP'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Scottish Widows App not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGAPP'>&times;</a></div>";    
         
     }    
}

if($WHICH_COMPANY=='Vitality') {
    
           $database->query("select uploadtype from tbl_uploads where uploadtype='Vitalitykeyfacts' and file like :search");
            $database->bind(':search', $likesearch);
            $database->execute();
            $database->single();
                
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGKEY'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Vitality Keyfacts not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGKEY'>&times;</a></div>";    
         
     }
     
    $database->query("select uploadtype from tbl_uploads where uploadtype='Vitalitykeyfacts' and file like :search");
    $database->bind(':search', $likesearch);
    $database->execute();
    $database->single();
     if ($database->rowCount()<=0) {  
         
    echo "<div class=\"notice notice-warning\" role=\"alert\" id='HIDELGAPP'><strong><i class=\"fa fa-upload fa-lg\"></i> Alert:</strong> Vitality App not uploaded!"
            . "<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDELGAPP'>&times;</a></div>";    
         
     }    
}
                                                                ?>