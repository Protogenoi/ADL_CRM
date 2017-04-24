<?php
require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($fflife == '1') {

    $NAVdate = date("Y-m-d");
    $hello_name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

    $navbar = $pdo->prepare("select count(deadline) AS badge from Client_Tasks where deadline=:date AND assigned =:navbarname and complete ='0'");
    $navbar->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar->bindParam(':date', $NAVdate, PDO::PARAM_STR, 25);
    $navbar->execute();
    $navbarresult = $navbar->fetch(PDO::FETCH_ASSOC);

    $navbar2 = $pdo->prepare("select count(deadline) AS badge from Client_Tasks where deadline <:date AND assigned =:navbarname and complete ='0'");
    $navbar2->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar2->bindParam(':date', $NAVdate, PDO::PARAM_STR, 25);
    $navbar2->execute();
    $navbarresult2 = $navbar2->fetch(PDO::FETCH_ASSOC);

    $set_timea = date("G:i", strtotime('-30 minutes'));
    $set_time_toa = date("G:i", strtotime('+20 minutes'));

    $query = $pdo->prepare("SELECT count(id) AS badge from scheduled_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
    $query->bindParam(':time', $set_timea, PDO::PARAM_STR);
    $query->bindParam(':timeto', $set_time_toa, PDO::PARAM_STR);
    $query->execute();
    $ACT_CBS = $query->fetch(PDO::FETCH_ASSOC);
}

if ($ffsms == '1') {

    $RPY_stmt = $pdo->prepare("SELECT 
    count(sms_inbound_id) AS badge 
FROM
    sms_inbound
WHERE
    sms_inbound_type = 'Client SMS Reply'");
    $RPY_stmt->execute();
    $RPY_stmtresult = $RPY_stmt->fetch(PDO::FETCH_ASSOC);

    $RPY_stmt2 = $pdo->prepare("SELECT 
    count(sms_inbound_id) AS badge 
FROM
    sms_inbound
WHERE
    sms_inbound_type = 'SMS Failed'");
    $RPY_stmt2->execute();
    $RPY_stmtresult2 = $RPY_stmt2->fetch(PDO::FETCH_ASSOC);
}

if($ffkeyfactsemail=='1') {

    $KFS_stmt = $pdo->prepare("SELECT 
    count(client_details.email) as badge
FROM
    client_details
WHERE
    client_details.submitted_date >= CURDATE()
        AND client_details.email NOT IN (SELECT 
            keyfactsemail_email
        FROM
            keyfactsemail
        WHERE
            keyfactsemail_added_date >= CURDATE())");
    $KFS_stmt->execute();
    $KFS_stmtresult = $KFS_stmt->fetch(PDO::FETCH_ASSOC);
    
    
}
?>

<ul class="nav navbar-nav navbar-right">
    <?php if ($ffcallbacks == '1') {
if ($ACT_CBS['badge'] > 0) { ?>
        <li><a href="/calendar/calendar.php">  <span class="badge alert-danger"><i class="fa fa-phone"></i>Active <?php echo $ACT_CBS['badge']; ?></span></a></li> <?php }

        } if ($fflife == '1') {

        if ($navbarresult['badge'] > 0) {
            ?>    <li><a href="/Life/Reports/Tasks.php"><span class="badge alert-success"><i class="fa fa-tasks"></i>  Today <?php echo $navbarresult['badge']; ?> </span></a></li> <?php }
    if ($navbarresult2['badge'] > 0) {
            ?>    <li><a href="/Life/Reports/Tasks.php"><span class="badge alert-danger"><i class="fa fa-tasks"></i>  Expired <?php echo $navbarresult2['badge']; ?> </span></a></li> <?php
        }
        
        if($ffkeyfactsemail=='1') {
            if ($KFS_stmtresult['badge'] >= '1') {
                ?>
        <li><a href="/Life/Reports/Keyfacts.php"> <span class="badge alert-info"> <i class='fa fa-envelope'></i> <?php echo $KFS_stmtresult['badge']; ?> </span></a></li>

                <?php
            }          
        }

        if ($ffsms == '1') {
            if ($RPY_stmtresult['badge'] >= '1') {
                ?>
                <li><a href="/Life/SMS/Report.php?SEARCH_BY=Responses"> <span class="badge alert-success"> <i class='fa fa-commenting-o'></i> <?php echo $RPY_stmtresult['badge']; ?> </span></a></li>

                <?php
            }
            if ($RPY_stmtresult2['badge'] >= '1') {
                ?>                <li><a href="/Life/SMS/Report.php?SEARCH_BY=Failed"> <span class="badge alert-danger"> <i class='fa fa-comment-o'></i> <?php echo $RPY_stmtresult2['badge']; ?> </span> </a></li>

                <?php
            }
        }
    } ?>

</ul>