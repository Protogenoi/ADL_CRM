<?php
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

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

require_once(__DIR__ . '/../../../resources/lib/PHPMailer_5.2.0/class.phpmailer.php');

$CID= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_GET, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            $companynamere=$companydetailsq['company_name'];    
        
        $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailaccount='account3'");
        $query->bindParam(':key', $EN_KEY, PDO::PARAM_STR);
        $query->execute()or die(print_r($query->errorInfo(), true));
        $queryr=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb=$queryr['emailfrom'];
        $emailbccdb=$queryr['emailbcc'];
        $emailreplydb=$queryr['emailreply'];
        
 if($companynamere=='Bluestone Protect') {       
        $emailsubjectdb="Bluestone Protect - My Account Details";
 }
 else {
$emailsubjectdb="My Account Details";
 }
        
        $emailsmtpdb=$queryr['smtp'];
        $emailsmtpportdb=$queryr['smtpport'];
        $emaildisplaynamedb=$queryr['displayname'];
        $passworddb=$queryr['password'];
        $emaildb=$queryr['email'];
        $signat=  html_entity_decode($queryr['sig']);
    
    if(isset($hello_name)) {
    
     switch ($hello_name) {
         case "Michael":
             $hello_name_full="Michael Owen";
             break;
         case "Jakob":
             $hello_name_full="Jakob Lloyd";
             break;
         case "leighton":
             $hello_name_full="Leighton Morris";
             break;
         case "Nicola":
             $hello_name_full="Nicola Griffiths";
             break;
         case "carys":
             $hello_name_full="Carys Riley";
             break;
         case "Matt":
             $hello_name_full="Matthew Jones";
             break;
         case "Tina":
             $hello_name_full="Tina Dennis";
             break;
         case "Nick":
             $hello_name_full="Nick Dennis";
             break;
         case "Ryan":
             $hello_name_full="Ryan Lloyd";
             break;         
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }

$target_dir = "../../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_FILES["fileToUpload"]["size"] > 700000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" ) {
    $uploadOk = 0;
}

if($COMPANY_ENTITY == 'Bluestone Protect') {

$message ="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width'/>


    <style type='text/css'>
    {
  margin: 0;
  padding: 0;
  font-size: 100%;
  font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  line-height: 1.65; }

img {
  max-width: 100%;
  margin: 0 auto;
  display: block; }

body,
.body-wrap {
  width: 100% !important;
  height: 100%;
  background: #efefef;
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none; }

a {
  color: #3399ff;
  text-decoration: none; }

.text-center {
  text-align: center; }

.text-right {
  text-align: right; }

.text-left {
  text-align: left; }

.button {
  display: inline-block;
  color: black;
  background: #f0f0f5;
  border: solid #f0f0f5;
  border-width: 10px 20px 8px;
  font-weight: bold;
  border-radius: 4px; }

h1, h2, h3, h4, h5, h6 {
  margin-bottom: 20px;
  line-height: 1.25; }

h1 {
  font-size: 32px; }

h2 {
  font-size: 28px; }

h3 {
  font-size: 24px; }

h4 {
  font-size: 20px; }

h5 {
  font-size: 16px; }

p, ul, ol {
  font-size: 16px;
  font-weight: normal;
  margin-bottom: 20px; }

.container {
  display: block !important;
  clear: both !important;
  margin: 0 auto !important;
  max-width: 580px !important; }
  .container table {
    width: 100% !important;
    border-collapse: collapse; }
  .container .masthead {
    padding: 80px 0;
    background: #ffffff;
    color: black; }
    .container .masthead h1 {
      margin: 0 auto !important;
      max-width: 90%;
      text-transform: uppercase; }
  .container .content {
    background: white;
    padding: 30px 35px; }
    .container .content.footer {
      background: none; }
      .container .content.footer p {
        margin-bottom: 0;
        color: #888;
        text-align: center;
        font-size: 14px; }
      .container .content.footer a {
        color: #888;
        text-decoration: none;
        font-weight: bold; }
.bs-wizard {margin-top: 40px;}

.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
    </style>
</head>
<body>
<table class='body-wrap'>
    <tr>
        <td class='container'>

            <!-- Message start -->
            <table>
                <tr>
                    <td align='center' class='masthead'>
<img src='cid:logo' >
                        <h1>Bluestone Protect</h1>

                    </td>
                </tr>
                <tr>
                    <td class='content'>

                        <h2>Hi $recipient,</h2>

                        <p>As you discussed with my colleague you will now be able to access your policy information using Legal and Generals online system, we need you to check that the information you provided is correct as it could affect any claims. </p>
<p>You can do this by following the instructions below:</p>

 

<p>


                        
          <div class='row bs-wizard' style='border-bottom:0;'>              
<div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 1</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Follow the link <br><a href='http://www.legalandgeneral.com'>www.legalandgeneral.com</a></div>
                </div>
</div>



          <div class='row bs-wizard' style='border-bottom:0;'>              
<div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 2</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Top right corner \"Existing customers\".</div>
                </div>
                <br>
                <div class='col-xs-3 bs-wizard-step complete'><!-- complete -->
                  <div class='text-center bs-wizard-stepnum'>Step 3</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Register or log in \"My Account\".</div>
                </div>
</div>


                        <p>Your user ID is normally your email address unless you chose something else. If you have joint or separate policies you will need separate emails to create a “My Account”.</p>
                        

          <div class='row bs-wizard' style='border-bottom:0;'>              
<div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 4</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Click on \"Mailbox\" icon at the top of the screen.</div>
                </div>
                <br>
                <div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 5</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Click on \"Review your application\".</div>
                </div>
</div>

<p>Now that you have registered it is important you let us know if the answers given are correct.</p>
                        <p>This will open a document containing the information you gave us when you applied, once you have viewed the document you will have an option to either click “My answers are correct” or click “Change my answers” and complete the form provided to let us know the changes required.</p>
                        <p>If any changes made affect the policy you will be notified by www.legalandgeneral.com.</p>
                        <p>Thank you for choosing to set your policy up through the Review Bureau.</p>
                        <p>If you have any issues or queries please don’t hesitate to contact us.</p>
                        <p><em>– $hello_name_full</em></p>
<img src='cid:logo'>
                        <center><strong>Bluestone Protect</strong><center>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td class='container'>

            <table>
                <tr>
                    <td class='content footer' align='center'>
                        <p>Sent by <a href='#'>Bluestone Protect</a>. Bluestone Protect Ltd. Registered in England and Wales with registered number 08519932.  Registered Office: The Post House, Adelaide Street, Swansea, SA1 1SB.  Bluestone Protect Ltd may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring.
</p>
                        <p><a href='mailto:'>info@bluestoneprotect.com</a> </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>";

}

if($COMPANY_ENTITY == 'First Priority Group') {

$message ="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width'/>


    <style type='text/css'>
    {
  margin: 0;
  padding: 0;
  font-size: 100%;
  font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  line-height: 1.65; }

img {
  max-width: 100%;
  margin: 0 auto;
  display: block; }

body,
.body-wrap {
  width: 100% !important;
  height: 100%;
  background: #efefef;
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none; }

a {
  color: #3399ff;
  text-decoration: none; }

.text-center {
  text-align: center; }

.text-right {
  text-align: right; }

.text-left {
  text-align: left; }

.button {
  display: inline-block;
  color: black;
  background: #f0f0f5;
  border: solid #f0f0f5;
  border-width: 10px 20px 8px;
  font-weight: bold;
  border-radius: 4px; }

h1, h2, h3, h4, h5, h6 {
  margin-bottom: 20px;
  line-height: 1.25; }

h1 {
  font-size: 32px; }

h2 {
  font-size: 28px; }

h3 {
  font-size: 24px; }

h4 {
  font-size: 20px; }

h5 {
  font-size: 16px; }

p, ul, ol {
  font-size: 16px;
  font-weight: normal;
  margin-bottom: 20px; }

.container {
  display: block !important;
  clear: both !important;
  margin: 0 auto !important;
  max-width: 580px !important; }
  .container table {
    width: 100% !important;
    border-collapse: collapse; }
  .container .masthead {
    padding: 80px 0;
    background: #ffffff;
    color: black; }
    .container .masthead h1 {
      margin: 0 auto !important;
      max-width: 90%;
      text-transform: uppercase; }
  .container .content {
    background: white;
    padding: 30px 35px; }
    .container .content.footer {
      background: none; }
      .container .content.footer p {
        margin-bottom: 0;
        color: #888;
        text-align: center;
        font-size: 14px; }
      .container .content.footer a {
        color: #888;
        text-decoration: none;
        font-weight: bold; }
.bs-wizard {margin-top: 40px;}

.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
    </style>
</head>
<body>
<table class='body-wrap'>
    <tr>
        <td class='container'>

            <!-- Message start -->
            <table>
                <tr>
                    <td align='center' class='masthead'>
<img src='cid:logo' >
                        <h1>First Priority Group</h1>

                    </td>
                </tr>
                <tr>
                    <td class='content'>

                        <h2>Hi $recipient,</h2>

                        <p>As you discussed with my colleague you will now be able to access your policy information using Legal and Generals online system, we need you to check that the information you provided is correct as it could affect any claims. </p>
<p>You can do this by following the instructions below:</p>

 

<p>


                        
          <div class='row bs-wizard' style='border-bottom:0;'>              
<div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 1</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Follow the link <br><a href='http://www.legalandgeneral.com'>www.legalandgeneral.com</a></div>
                </div>
</div>



          <div class='row bs-wizard' style='border-bottom:0;'>              
<div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 2</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Top right corner \"Existing customers\".</div>
                </div>
                <br>
                <div class='col-xs-3 bs-wizard-step complete'><!-- complete -->
                  <div class='text-center bs-wizard-stepnum'>Step 3</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Register or log in \"My Account\".</div>
                </div>
</div>


                        <p>Your user ID is normally your email address unless you chose something else. If you have joint or separate policies you will need separate emails to create a “My Account”.</p>
                        

          <div class='row bs-wizard' style='border-bottom:0;'>              
<div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 4</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Click on \"Mailbox\" icon at the top of the screen.</div>
                </div>
                <br>
                <div class='col-xs-3 bs-wizard-step complete'>
                  <div class='text-center bs-wizard-stepnum'>Step 5</div>
                  <div class='progress'><div class='progress-bar'></div></div>
                  <a href='#' class='bs-wizard-dot'></a>
                  <div class='bs-wizard-info text-center'>Click on \"Review your application\".</div>
                </div>
</div>

<p>Now that you have registered it is important you let us know if the answers given are correct.</p>
                        <p>This will open a document containing the information you gave us when you applied, once you have viewed the document you will have an option to either click “My answers are correct” or click “Change my answers” and complete the form provided to let us know the changes required.</p>
                        <p>If any changes made affect the policy you will be notified by www.legalandgeneral.com.</p>
                        <p>Thank you for choosing to set your policy up through First Priority Group.</p>
                        <p>If you have any issues or queries please don’t hesitate to contact us.</p>
                        <p><em>– $hello_name_full</em></p>
<img src='cid:logo'>
                        <center><strong>First Priority Group</strong><center>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td class='container'>

            <table>
                <tr>
                    <td class='content footer' align='center'>
                        <p>Sent by <a href='#'>First Priority Group</a>. First Priority Group Ltd. FCA registered number 737871.  Registered Office: 5 Prospect Place, Swansea, SA1 1QP.  First Priority Group Ltd may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring.
</p>
                        <p><a href='mailto:'>idd@firstprioritygroup.co.uk</a> </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>";

}

$body = $message;

$mail             = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "$emailsmtpdb";
$mail->SMTPAuth   = true;   
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $emailsmtpportdb;    
$mail->Username   = "$emaildb"; 
$mail->Password   = "$passworddb";  
if($COMPANY_ENTITY == 'Bluestone Protect') {
$mail->AddEmbeddedImage(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/img/bluestone_protect_logo.png', 'logo');
}
if($COMPANY_ENTITY == 'First Priority Group') {
$mail->AddEmbeddedImage(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/img/fpg_logo.png', 'logo');
}
$mail->SetFrom("$emailfromdb", "$emaildisplaynamedb");
$mail->AddReplyTo("$emailreplydb","$emaildisplaynamedb");
$mail->Subject    = "$emailsubjectdb";
$mail->IsHTML(true); 
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
$mail->AddAddress($email, $recipient);
$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
   $message="My Account details email failed ($email)!";
  
                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Failed', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));  
                
  header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=0&CLIENT_EMAIL=My Account&EMAIL_SENT_TO='.$email); die;
  
} else {

$message="My Account details email sent ($email)";

                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Sent', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));
                
header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=1&CLIENT_EMAIL=My Account&EMAIL_SENT_TO='.$email); die;

}
?>