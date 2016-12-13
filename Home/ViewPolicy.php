<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


include('../includes/adl_features.php');
include('../includes/adlfunctions.php');
            
            if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    include('../includes/Access_Levels.php');

        if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<title>View Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<style type="text/css">
	.policyview{
		margin: 20px;
	}
</style>
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');   
    include('../includes/ADL_PDO_CON.php');
    
$PID= filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_NUMBER_INT);
$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("SELECT client_id, id, client_name, sale_date, policy_number, premium, type, insurer, added_date, commission, status, added_by, updated_by, updated_date, closer, lead, cover  FROM home_policy WHERE id=:PID AND client_id=:CID");
$query->bindParam(':PID', $PID, PDO::PARAM_INT);
$query->bindParam(':CID', $CID, PDO::PARAM_INT);
$query->execute();
$data2=$query->fetch(PDO::FETCH_ASSOC);

$search=$data2['client_id'];

?>
    <div class="container">
        <div class="policyview">
            <div class="notice notice-info fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Note!</strong> You are now viewing <?php echo $data2['client_name']?>'s policy.
            </div>
        </div>
        
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">View Policy</div>
                <div class="panel-body">
                    <div class="column-right">


<form class="AddClient">
             <p>
<label for="created">Added By</label>
<input type="text" value="<?php echo $data2["added_by"];?>" class="form-control" readonly style="width: 200px">
</p>
<p>
<label for="created">Date Added</label>
<input type="text" value="<?php echo $data2["added_date"];?>" class="form-control" readonly style="width: 200px">
</p> 
<p>
<label for="created">Edited By</label>
<input type="text" value="<?php if (!empty($data2["updated_date"] && $data2["added_date"]!=$data2["updated_date"])) { echo $data2["updated_by"]; }?>" class="form-control" readonly style="width: 200px">
</p>   
<p>
<label for="created">Date Edited</label>
<input type="text" value="<?php if($data2["added_date"]!=$data2["updated_date"]) { echo $data2["updated_date"]; } ?>" class="form-control" readonly style="width: 200px">
</p>   
    <a href="ViewClient.php?CID=<?php echo $CID?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>

</form>                  
                    </div>
                    
                    <form class="AddClient">
                        <div class="column-left">

<p>
<label for="client_name">Policy Holder</label>
<input type="text" id="client_name" name="client_name" value="<?php echo $data2['client_name']?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="sale_date">Sale Date:</label>
<input type="text" id="sale_date" name="sale_date" value="<?php echo $data2["sale_date"]?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="policy_number">Policy Number</label>
<input type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="type">Type</label>
<input type="text" value="<?php echo $data2["type"];?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="insurer">Insurer</label>
<input type="text" value="<?php echo $data2["insurer"];?>" class="form-control" readonly style="width: 200px">
</p>


</div>
                        <div class="column-center">
<p>
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2[premium]?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2[commission]?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="cover">Cover Amount</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2['cover']?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cover" name="cover" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>


<p>
<label for="PolicyStatus">Policy Status</label>
  <input type="text" value="<?php echo $data2['status']?>" class="form-control" readonly style="width: 200px">
</select>
</p>

<p>
<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' value="<?php echo $data2["closer"]?>" class="form-control" readonly style="width: 200px">
</p>

<p>
<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' value="<?php echo $data2["lead"]?>" class="form-control" readonly style="width: 200px">
</p>

</form>
</div>

</div>
</div>
</div>

 </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script>var maxLength = 800;
$('textarea').keyup(function() {
  var length = $(this).val().length;
  var length = maxLength-length;
  $('#chars').text(length);
});</script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Save changes?",
                text: "You will not be able to recover any overwritten data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Complete!',
                        text: 'EWS updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No Changes have been submitted", "error");
                }
            });
        });

    </script>
<script src="/js/sweet-alert.min.js"></script>
</body>
</html>
