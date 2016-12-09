<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('includes/Access_Levels.php');
include('includes/adl_features.php');

      if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;
} 
?>

<!DOCTYPE html>
<html lang="en">
<title>Export Data</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#VITfrom" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#VITto" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
<script>
  $(function() {
    $( "#datefrom2" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto2" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#datefrom3" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto3" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
  <script>
  $(function() {
    $( "#datefrom4" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto4" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#datefrom5" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto5" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#datefrom6" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto6" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
   <script>
  $(function() {
    $( "#datefrom7" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
 <script>
  $(function() {
    $( "#dateto7" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
	</head>
	<body>
            
            <?php include('includes/navbar.php'); 
                    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
            ?>

<div class="container">

<div class="column-left">

<form class="AddClient" action="/export/Export.php?query=LIFE" method="post">
<h3>Export Business Register</h3>

<p>
<label for="Select" required>Select Policies that</label>
<select name="Select">
<option value="submitted_date">Were Added</option>
<option value="sale_date">Were Sold</option>
</select>
</p>
<br>

<p>
<label for="datefrom">From:</label>
<input type="text" id="datefrom2" name="datefrom" value="<?php echo $datefrom ?>" required>
</p>

<p>
<label for="dateto">To:</label>
<input type="text" id="dateto2" name="dateto" value="<?php echo $dateto ?>" required>
</p>

<p>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-save"></span> Export</button>
</p>
</form>
    
<form class="AddClient" action="/export/Export.php?query=HOME" method="post">
<h3>Export Home Business Register</h3>


<p>
<label for="datefrom">From:</label>
<input type="text" id="datefrom7" name="datefrom" value="<?php echo $datefrom ?>" required>
</p>

<p>
<label for="dateto">To:</label>
<input type="text" id="dateto7" name="dateto" value="<?php echo $dateto ?>" required>
</p>

<p>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-save"></span> Export</button>
</p>
</form> 
    
<form class="AddClient" action="/export/Export.php?query=VITALITYLIFE" method="post">
<h3>Export Vitality Business Register</h3>


<p>
<label for="datefrom">From:</label>
<input type="text" id="VITfrom" name="datefrom" value="<?php echo $datefrom ?>" required>
</p>

<p>
<label for="dateto">To:</label>
<input type="text" id="VITto" name="dateto" value="<?php echo $dateto ?>" required>
</p>

<p>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-save"></span> Export</button>
</p>
</form>       


</div>

<div class="column-center">

</div>
    
    <div class="column-right">
    <form class="AddClient" action="export/Export.php?query=LIFEFINANCIALS" method="post">
<h3>Export Financial Database</h3>

<p>
<label for="Select">Select</label>
<select name="Select" required>
<option value="comm_date">COMM Date</option>
<option value="sale_date">Sale Date</option>
</select>
</p>
<br>

<p>
<label for="datefrom">From:</label>
<input type="text" id="datefrom3" name="datefrom" value="<?php echo $datefrom ?>" required>
</p>

<p>
<label for="dateto">To:</label>
<input type="text" id="dateto3" name="dateto" value="<?php echo $dateto ?>" required>
</p>

<p>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-save"></span> Export</button>
</p>

</form>


<form class="AddClient" action="/export/exportews.php" method="post">
<h3>Export EWS Database</h3>

<p>
<label for="Select">Select</label>
<select name="Select" required>
<option value="date_added">Date Added</option>
</select>
</p>
<br>

<p>
<label for="datefrom">From:</label>
<input type="text" id="datefrom4" name="datefrom" value="<?php echo $datefrom ?>" required>
</p>

<p>
<label for="dateto">To:</label>
<input type="text" id="dateto4" name="dateto" value="<?php echo $dateto ?>" required>
</p>

<p>
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-save"></span> Export</button>
</p>

</form>



</div>
</div>
</body>

</html>
