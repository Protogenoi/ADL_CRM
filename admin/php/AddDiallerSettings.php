<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } 
    }

include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');

$db= filter_input(INPUT_GET, 'db', FILTER_SANITIZE_SPECIAL_CHARS);
$telvar= filter_input(INPUT_GET, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($db)) {
    
$dbsqlpass= filter_input(INPUT_POST, 'dbsqlpass', FILTER_SANITIZE_SPECIAL_CHARS);
$dbsqluser= filter_input(INPUT_POST, 'dbsqluser', FILTER_SANITIZE_SPECIAL_CHARS);
$dbserverpass= filter_input(INPUT_POST, 'dbserverpass', FILTER_SANITIZE_SPECIAL_CHARS);
$dbserveruser= filter_input(INPUT_POST, 'dbserveruser', FILTER_SANITIZE_SPECIAL_CHARS);
$dbserverurl= filter_input(INPUT_POST, 'dbserverurl', FILTER_SANITIZE_SPECIAL_CHARS);

$servertype="Database";

$dupcheck = "Select id from vicidial_accounts WHERE servertype='Database'";
$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {

    $UPDATE = $pdo->prepare("UPDATE vicidial_accounts set url=:urlholder, added_by=:helloholder, username=:userholder, password=:passholder, sqlpass=:sqlpassholder, sqluser=:sqluserholder WHERE servertype='Database'");
        $UPDATE->bindParam(':sqlpassholder', $dbsqlpass, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':sqluserholder', $dbsqluser, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':passholder', $dbserverpass, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':userholder', $dbserveruser, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':urlholder', $dbserverurl, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
        $UPDATE->execute()or die(print_r($UPDATE->errorInfo(), true));
}

if ($duperaw->num_rows <= 0) {
    
    $INSERT = $pdo->prepare("INSERT INTO vicidial_accounts set url=:urlholder, added_by=:helloholder, servertype=:typeholder, username=:userholder, password=:passholder, sqlpass=:sqlpassholder, sqluser=:sqluserholder");
        $INSERT->bindParam(':sqlpassholder', $dbsqlpass, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':sqluserholder', $dbsqluser, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':passholder', $dbserverpass, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':userholder', $dbserveruser, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':urlholder', $dbserverurl, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':helloholder', $hello_name, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':typeholder', $servertype, PDO::PARAM_STR, 500);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
        
}
    
                    if(isset($fferror)) {
    if($fferror=='0') {
        
    header('Location: ../../admin/Admindash.php?vicidialaccount=database&Vicidial=y'); die;
    }
                    }
}

if (isset($telvar)) {
    
    
$telserverpass= filter_input(INPUT_POST, 'telserverpass', FILTER_SANITIZE_SPECIAL_CHARS);
$telserveruser= filter_input(INPUT_POST, 'telserveruser', FILTER_SANITIZE_SPECIAL_CHARS);
$telserverurl= filter_input(INPUT_POST, 'telserverurl', FILTER_SANITIZE_SPECIAL_CHARS);

$servertype2="Telephony";

$dupcheck = "Select id from vicidial_accounts WHERE servertype='Telephony'";
$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
   
    $UPDATE = $pdo->prepare("UPDATE vicidial_accounts set url=:urlholder2, added_by=:helloholder2, username=:userholder2, password=:passholder2 WHERE servertype='Telephony'");
    $UPDATE->bindParam(':passholder2', $telserverpass, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':userholder2', $telserveruser, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':urlholder2', $telserverurl, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':helloholder2', $hello_name, PDO::PARAM_STR, 500);
        $UPDATE->execute()or die(print_r($UPDATE->errorInfo(), true));
        
}

if ($duperaw->num_rows <= 0) {
 
        $INSERT = $pdo->prepare("INSERT INTO vicidial_accounts set url=:urlholder2, added_by=:helloholder2, servertype=:typeholder2, username=:userholder2, password=:passholder2");
        $INSERT->bindParam(':passholder2', $telserverpass, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':userholder2', $telserveruser, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':urlholder2', $telserverurl, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':helloholder2', $hello_name, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':typeholder2', $servertype2, PDO::PARAM_STR, 500);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
    
}
        
                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../../admin/Admindash.php?vicidialaccount=telephony&Vicidial=y'); die;
    }
                }
}



$datavar= filter_input(INPUT_GET, 'data', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($datavar)) {

    $dbserverpass= filter_input(INPUT_POST, 'dbserverpass', FILTER_SANITIZE_SPECIAL_CHARS);
    $dbserveruser= filter_input(INPUT_POST, 'dbserveruser', FILTER_SANITIZE_SPECIAL_CHARS);
    $dbserverurl= filter_input(INPUT_POST, 'dbserverurl', FILTER_SANITIZE_SPECIAL_CHARS);
$servertype="Web";

$dupcheck = "Select id from connex_accounts";
$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {

     $UPDATE = $pdo->prepare("UPDATE connex_accounts set url=:url, added_by=:hello, servertype=:type, username=:user, password=:pass");
        $UPDATE->bindParam(':pass', $dbserverpass, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':user', $dbserveruser, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':url', $dbserverurl, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':hello', $hello_name, PDO::PARAM_STR, 500);
        $UPDATE->bindParam(':type', $servertype, PDO::PARAM_STR, 500);
        $UPDATE->execute()or die(print_r($UPDATE->errorInfo(), true));   
}
if ($duperaw->num_rows <= 0) {
    
    $INSERT = $pdo->prepare("INSERT INTO connex_accounts set url=:url, added_by=:hello, servertype=:type, username=:user, password=:pass");
        $INSERT->bindParam(':pass', $dbserverpass, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':user', $dbserveruser, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':url', $dbserverurl, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':hello', $hello_name, PDO::PARAM_STR, 500);
        $INSERT->bindParam(':type', $servertype, PDO::PARAM_STR, 500);
        $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
        
}
    
                    if(isset($fferror)) {
    if($fferror=='0') {
        
    header('Location: ../../admin/Admindash.php?connexaccount=database&Connex=y'); die;
    }
                    }
}


else {
                if(isset($fferror)) {
    if($fferror=='0') {
    header('Location: ../../admin/Admindash.php?connexaccount=failed&Connex=y'); die;
    }
                }
}


?>

