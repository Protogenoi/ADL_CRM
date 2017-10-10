<?php
$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {


include('../includes/ADL_MYSQLI_CON.php');

$hello_name=$USER;
require_once(__DIR__ . '../../includes/Access_Levels.php');


$ClientSearch= filter_input(INPUT_GET, 'ClientSearch', FILTER_SANITIZE_NUMBER_INT);

if(isset($ClientSearch)) {
    include('../includes/ADL_PDO_CON.php');
    if($ClientSearch=='1') { 

        $query = $pdo->prepare("SELECT company, phone_number, submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code FROM client_details ORDER BY client_id DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
        }
        
        if($ClientSearch=='4') { 
            
                $sql = 'SELECT CONCAT(firstname, " ", lastname) AS Name, CONCAT (firstname2, " ", lastname2) AS Name2, submitted_date, tel, tel2, post_code, client_id FROM pba_client_details';
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
            
            }
            
    if($ClientSearch=='5') { 

        $query = $pdo->prepare("SELECT company, phone_number, submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code FROM client_details WHERE company='TRB Home Insurance' ORDER BY submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
echo json_encode($results);
        
        }              
        
    if($ClientSearch=='6') {

     if(in_array($USER, $EWS_SEARCH_ACCESS,true)) {

$query = $pdo->prepare("SELECT 
    ews_data.client_name AS Name,
    ' ' AS Name2,
    client_policy.insurer AS company,
    ews_data.post_code AS post_code,
    ews_data.date_added AS submitted_date,
    client_policy.client_id AS client_id
FROM
    ews_data
        LEFT JOIN
    client_policy ON client_policy.policy_number = ews_data.policy_number");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
    }   
    
    else {
        
$query = $pdo->prepare("SELECT company,submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code FROM client_details ORDER BY client_id DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }
        
        }  
        
   if($ClientSearch=='7') {
       
$query = $pdo->prepare("SELECT client_id, phone_number FROM client_details");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));  

echo json_encode($results);
       
   } 
   
   if($ClientSearch=='8') {
       
$query = $pdo->prepare("SELECT 
    client_id,
    client_name,
    sale_date,
    application_number,
    policy_number,
    type,
    insurer,
    submitted_by,
    commission,
    CommissionType,
    PolicyStatus,
    submitted_date
FROM
    client_policy
WHERE
    DATE(submitted_date) BETWEEN '2013-01-01' AND '2018-01-01'");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));  

echo json_encode($results);
       
   }  
   
   if($ClientSearch=='9') {
       if(in_array($USER, $AUDIT_SEARCH_ACCESS,true)) {
           
           $YEAR= date('Y');
           $ALL_YEAR= "2011-01-01";
       
       $query = $pdo->prepare("SELECT
               company,submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code 
               FROM client_details 
               WHERE DATE(submitted_date) >=:YEAR 
               ORDER BY client_id DESC");
       $query->bindParam(':YEAR', $ALL_YEAR, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
       
   }
   }
            
        }            
            
}

} else {

    header('Location: /../../CRMmain.php');
    die;
    
}
?>

