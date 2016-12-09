<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 

$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$url = $_POST['url'];

include('../includes/ADL_PDO_CON.php');

$sql = "INSERT INTO evenement (title, start, end, url, assigned_to) VALUES (:title, :start, :end, :url, :assigned_to)";
$q = $pdo->prepare($sql);
$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end,  ':url'=>$url, ':assigned_to'=>$hello_name));
?>
