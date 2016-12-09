<!DOCTYPE html>
<html lang="en">
<title>ADL CRM | Key Facts Email</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="datatables/css/layoutcrm.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/styles/sweet-alert.min.css" />
<script src="/js/sweet-alert.min.js"></script>
</head>
<body>
    
    <?php
    include('includes/navbar.php');
    include('includes/adlfunctions.php');
        if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    ?>

  <div class="container">

      <?php email_sent_catch(); ?>

    <form class="form-horizontal" id="emailform" method="post" action="email/php/SendKeyFacts.php" enctype="multipart/form-data">

<div class="panel panel-primary">
  <div class="panel-heading">Key Facts Email 

<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#emailmodal"><span class="glyphicon glyphicon-envelope" data-></span> Generic Email</button>

<a href='email/TodayKFsfailed.php'><button type="button" class="btn btn-danger btn-sm pull-right"><span class="glyphicon glyphicon-remove-circle"></span> Check failed</button></a>

<a href='email/TodayKFs.php'><button type="button" class="btn btn-success btn-sm pull-right"><span class="glyphicon glyphicon-ok-circle"></span> Sent attempts</button></a> </div>
   <div class="panel-body">
   
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="bobross@gmail.com" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="recipient">Client Name</label>  
  <div class="col-md-4">
  <input id="recipient" name="recipient" placeholder="Mr Ross" class="form-control input-md" type="text">
    
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload">Add attachment</label>
  <div class="col-md-4">
    <input id="fileToUpload" name="fileToUpload" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload2">Add attachment (2)</label>
  <div class="col-md-4">
    <input id="fileToUpload2" name="fileToUpload2" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload3">Add attachment (3)</label>
  <div class="col-md-4">
    <input id="fileToUpload3" name="fileToUpload3" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload4">Add attachment (4)</label>
  <div class="col-md-4">
    <input id="fileToUpload4" name="fileToUpload4" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload5">Add attachment (5)</label>
  <div class="col-md-4">
    <input id="fileToUpload5" name="fileToUpload5" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload6">Add attachment (6)</label>
  <div class="col-md-4">
    <input id="fileToUpload6" name="fileToUpload6" class="input-file" type="file">
  </div>
</div>

<br>
<br>
 
<div class="form-group">
  <label class="col-md-4 control-label" for="Send Email"></label>
  <div class="col-md-4">
<button type="submit" class="btn btn-warning "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
  </div>
</div>

</fieldset>
</form> 
<!--<script>
$(document).ready(function(){
  $('#emailform').on('submit',function(e) { 
  $.ajax({
      url:'email/php/SendKeyFacts.php', 
      data:$(this).serialize(),
      type:'POST',
      success:function(data){
            timer: 5000,
      window.location.reload(true);
        console.log(data);
        
	    swal("Success!", "Message sent!", "success");
      },
      error:function(data){
       
	    swal("Oops...", "Something went wrong :(", "error");
      }
    });
    e.preventDefault();
  });
});
</script> -->
</div>
</div>
</div>


<!-- Modal -->
<div id="emailmodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Generic Email</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="genemailform" method="post" enctype="multipart/form-data">

<div class="panel panel-default">
  <div class="panel-heading">Send Email</div>
   <div class="panel-body">

<fieldset>


<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input id="email" name="email" placeholder="bobross@gmail.com" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="subject">Subject</label>  
  <div class="col-md-4">
  <input id="subject" name="subject" placeholder="" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="recipient">Recipient</label>  
  <div class="col-md-4">
  <input id="recipient" name="recipient" placeholder="Mr Ross" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="message">Message</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="message" name="message"></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload">Add attachment</label>
  <div class="col-md-4">
    <input id="fileToUpload" name="fileToUpload" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload2">Add attachment (2)</label>
  <div class="col-md-4">
    <input id="fileToUpload2" name="fileToUpload2" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload3">Add attachment (3)</label>
  <div class="col-md-4">
    <input id="fileToUpload3" name="fileToUpload3" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload4">Add attachment (4)</label>
  <div class="col-md-4">
    <input id="fileToUpload4" name="fileToUpload4" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload5">Add attachment (5)</label>
  <div class="col-md-4">
    <input id="fileToUpload5" name="fileToUpload5" class="input-file" type="file">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="fileToUpload6">Add attachment (6)</label>
  <div class="col-md-4">
    <input id="fileToUpload6" name="fileToUpload6" class="input-file" type="file">
  </div>
</div>

<br>
<br>
 
<div class="form-group">
  <label class="col-md-4 control-label" for="Send Email"></label>
  <div class="col-md-4">
<button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
  </div>
</div>

</fieldset>
</form> 

</div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function(){
  $('#genemailform').on('submit',function(e) { 
  $.ajax({
      url:'email/php/SendGeneric.php', 
      data:$(this).serialize(),
      type:'POST',
      success:function(data){
      timer: 5000,
      window.location.reload(true);
        console.log(data);
        
	    swal("Success!", "Message sent!", "success");
      },
      error:function(data){
       
	    swal("Oops...", "Something went wrong :(", "error");
      }
    });
    e.preventDefault();
  });
});
</script>
</body>
</html>
