
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/cus-jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.sortable.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
         <style>ul.source, ul.target {
  min-height: 50px;
  margin: 0px 25px 10px 0px;
  padding: 2px;
  border-width: 1px;
  border-style: solid;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  list-style-type: none;
  list-style-position: inside;
}
ul.source {
  border-color: #f8e0b1;
}
ul.target {
  border-color: #add38d;
}
.source li, .target li {
  margin: 5px;
  padding: 5px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
}
.source li {
  background-color: #fcf8e3;
  border: 1px solid #fbeed5;
  color: #c09853;
}
.target li {
  background-color: #ebf5e6;
  border: 1px solid #d6e9c6;
  color: #468847;
}
.sortable-dragging {
  border-color: #ccc !important;
  background-color: #fafafa !important;
  color: #bbb !important;
}
.sortable-placeholder {
  height: 40px;
}
.source .sortable-placeholder {
  border: 2px dashed #f8e0b1 !important;
  background-color: #fefcf5 !important;
}
.target .sortable-placeholder {
  border: 2px dashed #add38d !important;
  background-color: #f6fbf4 !important;
</style>
    </head>
    <body>
                
        <?php 
        include('includes/navbar.php');
        include('includes/PDOcon.php');
        ?>
        
        <div class="container">
        
        <?php
if(isset($_POST["submit"])) {
	$id_ary = explode(",",$_POST["row_order"]);
	for($i=0;$i<count($id_ary);$i++) {
	$query = $pdo->prepare("UPDATE php_interview_questions SET row_order='" . $i . "' WHERE id=". $id_ary[$i]);
        $query->execute();
	}
}
?>
      <?php
$query = $pdo->prepare("SELECT * FROM php_interview_questions ORDER BY row_order");
$query->execute();

?>
<form name="frmQA" method="POST" />
	<input type = "hidden" name="row_order" id="row_order" /> 
	<ul class="source connected" id="sortable-row">
		<?php
                if ($query->rowCount()>0) {
		while ($result=$query->fetch(PDO::FETCH_ASSOC)){
		?>
		<li id=<?php echo $result["id"]; ?>><?php echo $result["question"]; ?></li>
		<?php 
		}
                }
		?>  
	</ul>
        
        <ul class="target connected" id="sortable-row">
		<?php
                if ($query->rowCount()>0) {
		while ($result=$query->fetch(PDO::FETCH_ASSOC)){
		?>
		<li id=<?php echo $result["id"]; ?>><?php echo $result["question"]; ?></li>
		<?php 
		}
                }
		?>  
	</ul>
	<input type="submit" class="btnSave" name="submit" value="Save Order" onClick="saveOrder();" />
</form>
            </div>
        
        <script>
                  $(function () {
        $(".source, .target").sortable({
          connectWith: ".connected"
         }).bind("sortupdate", function() {
    updateValues();
  });
});
  $(function() {
    $( "#sortable-row" ).sortable();
  });
  
  function saveOrder() {
	var selectedLanguage = new Array();
	$('ul#sortable-row li').each(function() {
	selectedLanguage.push($(this).attr("id"));
	});
	document.getElementById("row_order").value = selectedLanguage;
  }
</script>
    </body>
</html>
