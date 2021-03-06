<?php
include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
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
$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
$recipient= filter_input(INPUT_GET, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
        
    $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailaccount='account3'");
    $query->bindParam(':key', $EN_KEY, PDO::PARAM_STR);
    $query->execute()or die(print_r($query->errorInfo(), true));
    $queryr=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb=$queryr['emailfrom'];
        $emailbccdb=$queryr['emailbcc'];
        $emailreplydb=$queryr['emailreply'];
        $emailsubjectdb=$queryr['emailsubject'];
        $emailsmtpdb=$queryr['smtp'];
        $emailsmtpportdb=$queryr['smtpport'];
        $emaildisplaynamedb=$queryr['displayname'];
        $passworddb=$queryr['password'];
        $emaildb=$queryr['email'];
        $signat=  html_entity_decode($queryr['sig']);
        
        
$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            $companynamere=$companydetailsq['company_name'];        
        
if($companynamere=='Bluestone Protect') {

$target_dir = filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_FILES["fileToUpload"]["size"] > 700000) {
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" ) {

    $uploadOk = 0;
}

$message ="<img src='cid:KeyFacts'>";
$sig = "<br>-- \n
<br>
<br>
<br>

$signat";
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

$mail->AddEmbeddedImage(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/img/Key Facts - Bluestone Protect.png', 'KeyFacts');
$mail->AddEmbeddedImage(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/img/bluestone_protect_logo.png', 'logo');

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
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->AddAddress($email, $recipient);
$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
   $message="Closer KeyFacts email failed ($email)!";
  
                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Failed', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));  
                
  header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=0&CLIENT_EMAIL=Closer Keyfacts&EMAIL_SENT_TO='.$email); die;  
  
} else {
       
   $INSERT = $pdo->prepare("INSERT INTO keyfactsemail set keyfactsemail_email=:email, keyfactsemail_added_by=:hello");
   $INSERT->bindParam(':email', $email, PDO::PARAM_STR);
   $INSERT->bindParam(':hello', $hello_name, PDO::PARAM_STR);
   $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
   
   $message="Closer KeyFacts email sent ($email)";

                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Sent', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));

header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=1&CLIENT_EMAIL=Closer Keyfacts&EMAIL_SENT_TO='.$email); die;
  
}

}

if($companynamere=='First Priority Group') {

$target_dir = filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_FILES["fileToUpload"]["size"] > 700000) {
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" ) {

    $uploadOk = 0;
}

$message ="<img src='cid:KeyFacts'>";
$sig = "<br>-- \n
<br>
<br>
<br>

$signat";
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
$mail->SMTPDebug  = 2; 

$mail->AddEmbeddedImage(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/img/Key Facts - First Priority Group.png', 'KeyFacts');
$mail->AddEmbeddedImage(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/img/fpg_logo.png', 'logo');

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
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->AddAddress($email, $recipient);
$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
   $message="Closer KeyFacts email failed ($email)!";
  
                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Failed', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));  
                
  //header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=0&CLIENT_EMAIL=Closer Keyfacts&EMAIL_SENT_TO='.$email); die;  
  
} else {
       
   $INSERT = $pdo->prepare("INSERT INTO keyfactsemail set keyfactsemail_email=:email, keyfactsemail_added_by=:hello");
   $INSERT->bindParam(':email', $email, PDO::PARAM_STR);
   $INSERT->bindParam(':hello', $hello_name, PDO::PARAM_STR);
   $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
   
   $message="Closer KeyFacts email sent ($email)";

                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Sent', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));

header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=1&CLIENT_EMAIL=Closer Keyfacts&EMAIL_SENT_TO='.$email); die;
  
}

}
?>