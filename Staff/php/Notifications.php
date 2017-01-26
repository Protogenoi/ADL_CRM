<?php

$RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($RETURN)) {
    if($RETURN=='ClientEdit') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client details updated!</div>";
        
    }
    if($RETURN=='ClientAdded') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-user-plus fa-lg\"></i> Success:</strong> Client added!</div>";
        
    }
    
        if($RETURN=='ClientHired') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-user-plus fa-lg\"></i> Success:</strong> Employee rehired!</div>";
        
    }
    
        if($RETURN=='ClientFired') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Employee fired!</div>";
        
    }
    
            if($RETURN=='ClientNote') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o fa-lg\"></i> Success:</strong> Employee note added!</div>";
        
    }
    
    if($RETURN=='AppAdded') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-calendar-check-o fa-lg\"></i> Success:</strong> Appointment booked!</div>";
        
    }
    if($RETURN=='AppEdited') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-calendar-check-o fa-lg\"></i> Success:</strong> Appointment has been re-booked!</div>";
        
    }    
    if($RETURN=='AppStatus') {
        
        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o  fa-lg\"></i> Success:</strong> Appointment status has been updated!</div>";
        
    }
    
                                                    $fileuploaded= filter_input(INPUT_GET, 'fileuploaded', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($fileuploaded)){
                                                    $uploadtypeuploaded= filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-upload fa-lg\"></i> Success:</strong> $uploadtypeuploaded uploaded!</div>");
                                                    
                                                }
                                                
                                                $fileuploadedfail= filter_input(INPUT_GET, 'fileuploadedfail', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($fileuploadedfail)){
                                                    $uploadtypeuploaded= filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> $uploadtypeuploaded <b>upload failed!</b></div>");
                                                    
                                                }
                                                
}