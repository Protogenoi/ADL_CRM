<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

<title>ADL | Post Code</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/jquery.postcodes.min.js"></script>
<style>
/* Just some plain styling (not important!) */
form {
    margin-bottom: 20px;
}
fieldset {
    margin-bottom: 20px;
}
input[type="text"], input[type="password"], input[type="email"], textarea, select {
    border: 1px solid #ccc;
    padding: 6px 4px;
    outline: none;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    font: 13px"HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #777;
    margin: 0;
    width: 210px;
    max-width: 100%;
    display: block;
    margin-bottom: 20px;
    background: #fff;
}
select {
    padding: 0;
}
input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus, textarea:focus {
    border: 1px solid #aaa;
    color: #444;
    -moz-box-shadow: 0 0 3px rgba(0, 0, 0, .2);
    -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .2);
    box-shadow: 0 0 3px rgba(0, 0, 0, .2);
}
textarea {
    min-height: 60px;
}
label, legend {
    display: block;
    font-weight: bold;
    font-size: 13px;
}
select {
    width: 220px;
}
input[type="checkbox"] {
    display: inline;
}
label span, legend span {
    font-weight: normal;
    font-size: 13px;
    color: #444;
}
.button, button, input[type="submit"], input[type="reset"], input[type="button"] {
    background: #eee;
    /* Old browsers */
    background: #eee -moz-linear-gradient(top, rgba(255, 255, 255, .2) 0%, rgba(0, 0, 0, .2) 100%);
    /* FF3.6+ */
    background: #eee -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(255, 255, 255, .2)), color-stop(100%, rgba(0, 0, 0, .2)));
    /* Chrome,Safari4+ */
    background: #eee -webkit-linear-gradient(top, rgba(255, 255, 255, .2) 0%, rgba(0, 0, 0, .2) 100%);
    /* Chrome10+,Safari5.1+ */
    background: #eee -o-linear-gradient(top, rgba(255, 255, 255, .2) 0%, rgba(0, 0, 0, .2) 100%);
    /* Opera11.10+ */
    background: #eee -ms-linear-gradient(top, rgba(255, 255, 255, .2) 0%, rgba(0, 0, 0, .2) 100%);
    /* IE10+ */
    background: #eee linear-gradient(top, rgba(255, 255, 255, .2) 0%, rgba(0, 0, 0, .2) 100%);
    /* W3C */
    border: 1px solid #aaa;
    border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    color: #444;
    display: inline-block;
    font-size: 11px;
    font-weight: bold;
    text-decoration: none;
    text-shadow: 0 1px rgba(255, 255, 255, .75);
    cursor: pointer;
    margin-bottom: 20px;
    line-height: normal;
    padding: 8px 10px;
    font-family:"HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.button:hover, button:hover, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
    color: #222;
    background: #ddd;
    /* Old browsers */
    background: #ddd -moz-linear-gradient(top, rgba(255, 255, 255, .3) 0%, rgba(0, 0, 0, .3) 100%);
    /* FF3.6+ */
    background: #ddd -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(255, 255, 255, .3)), color-stop(100%, rgba(0, 0, 0, .3)));
    /* Chrome,Safari4+ */
    background: #ddd -webkit-linear-gradient(top, rgba(255, 255, 255, .3) 0%, rgba(0, 0, 0, .3) 100%);
    /* Chrome10+,Safari5.1+ */
    background: #ddd -o-linear-gradient(top, rgba(255, 255, 255, .3) 0%, rgba(0, 0, 0, .3) 100%);
    /* Opera11.10+ */
    background: #ddd -ms-linear-gradient(top, rgba(255, 255, 255, .3) 0%, rgba(0, 0, 0, .3) 100%);
    /* IE10+ */
    background: #ddd linear-gradient(top, rgba(255, 255, 255, .3) 0%, rgba(0, 0, 0, .3) 100%);
    /* W3C */
    border: 1px solid #888;
    border-top: 1px solid #aaa;
    border-left: 1px solid #aaa;
}
.button:active, button:active, input[type="submit"]:active, input[type="reset"]:active, input[type="button"]:active {
    border: 1px solid #666;
    background: #ccc;
    /* Old browsers */
    background: #ccc -moz-linear-gradient(top, rgba(255, 255, 255, .35) 0%, rgba(10, 10, 10, .4) 100%);
    /* FF3.6+ */
    background: #ccc -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(255, 255, 255, .35)), color-stop(100%, rgba(10, 10, 10, .4)));
    /* Chrome,Safari4+ */
    background: #ccc -webkit-linear-gradient(top, rgba(255, 255, 255, .35) 0%, rgba(10, 10, 10, .4) 100%);
    /* Chrome10+,Safari5.1+ */
    background: #ccc -o-linear-gradient(top, rgba(255, 255, 255, .35) 0%, rgba(10, 10, 10, .4) 100%);
    /* Opera11.10+ */
    background: #ccc -ms-linear-gradient(top, rgba(255, 255, 255, .35) 0%, rgba(10, 10, 10, .4) 100%);
    /* IE10+ */
    background: #ccc linear-gradient(top, rgba(255, 255, 255, .35) 0%, rgba(10, 10, 10, .4) 100%);
    /* W3C */
}
.button.full-width, button.full-width, input[type="submit"].full-width, input[type="reset"].full-width, input[type="button"].full-width {
    width: 100%;
    padding-left: 0 !important;
    padding-right: 0 !important;
    text-align: center;
}
button::-moz-focus-inner, input::-moz-focus-inner {
    border: 0;
    padding: 0;
}

body {
		background: #fff;
		font: 14px/21px "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
		color: #444;
		-webkit-font-smoothing: antialiased; /* Fix for webkit rendering */
		-webkit-text-size-adjust: 100%;
 }
</style>
<body>

<?php include('includes/navbar.php'); ?>

    <div class="container">

<div id="lookup_field"></div> 
<!-- The above empty div tag will allow the plugin to create the lookup fields -->



<!-- The above empty div tag will allow the plugin to create the lookup fields -->

<!-- Below are your existing input fields -->
<label>Address Line One</label> 
<input id="first_line" type="text">

<label>Address Line Two</label>
<input id="second_line" type="text">

<label>Address Line Three</label>
<input id="third_line" type="text">

<label>Post Town</label>
<input id="post_town" type="text">

<label>Postcode</label>
<input id="postcode" type="text">

<script>
$('#lookup_field').setupPostcodeLookup({
  api_key: 'ak_icezvspdMslKjLb9FOJL9rfwOZ31O',
  output_fields: {
    line_1: '#first_line',  
    line_2: '#second_line',         
    line_3: '#third_line',
    post_town: '#post_town',
    postcode: '#postcode'
  }
});
</script>

</div>
</body>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.postcodes.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</html>
