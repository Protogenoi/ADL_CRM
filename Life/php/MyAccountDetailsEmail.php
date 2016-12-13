<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


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
         case "Roxy":
             $hello_name_full="Roxanne Studholme";
             break;
         case "Nicola":
             $hello_name_full="Nicola Griffiths";
             break;
         case "Rhibayliss":
             $hello_name_full="Rhiannon Bayliss";
             break;
         case "Amelia":
             $hello_name_full="Amelia Pike";
             break;
         case "Abbiek":
             $hello_name_full="Abbie Kenyon";
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
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }
require_once('../../PHPMailer_5.2.0/class.phpmailer.php');
include('../../includes/ADL_PDO_CON.php');
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            
                            $companynamere=$companydetailsq['company_name'];    

$keyfactsr="Key Facts";

        
        $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, email_accounts.password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailtype=:emailtypeholder");
        $query->bindParam(':emailtypeholder', $keyfactsr, PDO::PARAM_STR);
        $query->execute()or die(print_r($query->errorInfo(), true));
        $queryr=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb=$queryr['emailfrom'];
        $emailbccdb=$queryr['emailbcc'];
        $emailreplydb=$queryr['emailreply'];
        
 if($companynamere=='The Review Bureau') {       
        $emailsubjectdb="The Review Bureau - My Account Details";
 }
  elseif($companynamere=='Assura') {       
        $emailsubjectdb="Assura - My Account Details";
 }
 
 else {
$emailsubjectdb="My Account Details";
 }
        
        $emailsmtpdb=$queryr['smtp'];
        $emailsmtpportdb=$queryr['smtpport'];
        $emaildisplaynamedb=$queryr['displayname'];
        $passworddb=$queryr['password'];
        $emaildb=$queryr['email'];
        $signat=$queryr['sig'];
        
                $closerq = $pdo->prepare("select closer from client_policy where client_id=:id limit 1");
                $closerq->bindParam(':id', $search, PDO::PARAM_STR);
                $closerq->execute()or die(print_r($closerq->errorInfo(), true));
                $closer_name=$closerq->fetch(PDO::FETCH_ASSOC);

$closer_name=$closer_name['closer'];
        
        
    
        
if($companynamere=='The Review Bureau') {

        
error_reporting(E_ALL);
ini_set('display_errors',1);


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
    echo "FAIL";
    $uploadOk = 0;
}

$email = $_GET['email'] ;
$recipient = $_GET['recipient'] ;
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
                        <h1>The Review Bureau</h1>

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
                        <p>Thank you for choosing to set your policy up through The Review Bureau.</p>
                        <p>If you have any issues or queries please don’t hesitate to contact us.</p>
                        <p><em>– $hello_name_full</em></p>
<img src='cid:logo' >
                        <center><strong>The Review Bureau</strong><center>
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
                        <p>Sent by <a href='#'>The Review Bureau</a>. The Review Bureau Ltd. Registered in England and Wales with registered number 08519932.  Registered Office: The Post House, Adelaide Street, Swansea, SA1 1SB.  The Review Bureau Ltd may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring.
</p>
                        <p><a href='mailto:'>info@thereviewbureau.com</a> </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>";


$body = $message;
$body .= $sig;

$mail             = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->CharSet = 'UTF-8';
$mail->Host       = "$emailsmtpdb"; // SMTP server

$mail->SMTPAuth   = true;   
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $emailsmtpportdb;    
$mail->Username   = "$emaildb"; 
$mail->Password   = "$passworddb";  


$mail->AddEmbeddedImage('../../img/MyAccountDetailsLogo.jpg', 'logo');
$mail->SetFrom("$emailfromdb", "$emaildisplaynamedb");

$mail->AddReplyTo("$emailreplydb","$emaildisplaynamedb");
#$mail->AddBCC("$emailbccdb", "$emaildisplaynamedb");
$mail->Subject    = "$emailsubjectdb";
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 


$address = $email;
$mail->AddAddress($address, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
  header('Location: ../ViewClient.php?search='.$search.'&EmailMAD=0'); die;
  
} 

}

if($companynamere=='Assura') {
    
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
    echo "<div class=\"notice notice-info fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.
    </div>";
    $uploadOk = 0;
}

$email = $_GET['email'] ;
$recipient = $_GET['recipient'] ;
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
                        <p>Thank you for choosing to set your policy up through The Review Bureau.</p>
                        <p>If you have any issues or queries please don’t hesitate to contact us.</p>
                        <p><em>– $hello_name_full</em></p>
<img src='cid:logo'>
                       
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
                        <p>Sent by <a href='#'>Assura</a>. Assura is a trading name of CJTD Limited investments. CJTD Investments Limited registered in England and Wales with registered number 08403633. Registered office: Churchill house, 120 Bunns Lane, London, NW7 2AS.
CJTD Investments Limited may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring.
</p>
                        <p><a href='mailto:'>info@assura-uk.com</a> </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>";


$body = $message;
$body .= $sig;

$mail             = new PHPMailer();


$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$emailsmtpdb";                      
$mail->SMTPAuth   = true;                
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $emailsmtpportdb;                    
$mail->Username   = "$emaildb";
$mail->Password   = "$passworddb";        

$mail->AddEmbeddedImage('../../img/assuralogo.png', 'logo');

if (isset($_FILES["fileToUpload"]) &&
    $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload"]["tmp_name"],
                         $_FILES["fileToUpload"]["name"]);
}

if (isset($_FILES["fileToUpload2"]) &&
    $_FILES["fileToUpload2"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload2"]["tmp_name"],
                         $_FILES["fileToUpload2"]["name"]);
}

if (isset($_FILES["fileToUpload3"]) &&
    $_FILES["fileToUpload3"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload3"]["tmp_name"],
                         $_FILES["fileToUpload3"]["name"]);
}

if (isset($_FILES["fileToUpload4"]) &&
    $_FILES["fileToUpload4"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload4"]["tmp_name"],
                         $_FILES["fileToUpload4"]["name"]);
}

if (isset($_FILES["fileToUpload5"]) &&
    $_FILES["fileToUpload5"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload5"]["tmp_name"],
                         $_FILES["fileToUpload5"]["name"]);
}

if (isset($_FILES["fileToUpload6"]) &&
    $_FILES["fileToUpload6"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload6"]["tmp_name"],
                         $_FILES["fileToUpload6"]["name"]);
}



$mail->SetFrom("$emailfromdb", "$emaildisplaynamedb");

$mail->AddReplyTo("$emailreplydb","$emaildisplaynamedb");
$mail->AddBCC("$emailbccdb", "$emaildisplaynamedb");
$mail->Subject    = "$emailsubjectdb";
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test


$address = $email;
$mail->AddAddress($address, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
  header('Location: ../ViewClient.php?search='.$search.'&EmailMAD=0'); die;
  
} 


    
    
}

$notetype="Email Sent";
$message="My Account details email sent ($email)";
$ref= "$recipient";


                $noteq = $pdo->prepare("INSERT into client_note set client_id=:id, note_type=:type, client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':id', $search, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':type', $notetype, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $ref, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));


header('Location: ../ViewClient.php?search='.$search.'&EmailMAD=1&emailto='.$email); die;
    ?>



