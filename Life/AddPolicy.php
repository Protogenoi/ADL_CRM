<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: ../CRMmain.php?AccessDenied');
    die;
}

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);


if (isset($EXECUTE)) {
    if ($EXECUTE == '1') {

        $query = $pdo->prepare("SELECT submitted_date, company, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from client_details where client_id = :CID");
        $query->bindParam(':CID', $search, PDO::PARAM_STR);
        $query->execute();
        $data2 = $query->fetch(PDO::FETCH_ASSOC);

        if (isset($data2['company']) && $data2['company'] == 'TRB Home Insurance' || $data2['company'] == 'Home Insurance' || $data2['company'] == 'CUS Home Insurance') {
            header('Location: ../Home/AddPolicy.php?Home=y&CID=' . $search);
            die;
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <title>ADL | Add Product</title>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
            <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
            <link  rel="stylesheet" href="/styles/sweet-alert.min.css" />
            <link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
            <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
            <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
            <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
            <script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
            <script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
            <script>
                $(function () {
                    $("#sale_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
                $(function () {
                    $("#submitted_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
            </script>
            <script>
                webshims.setOptions('forms-ext', {
                    replaceUI: 'auto',
                    types: 'number'
                });
                webshims.polyfill('forms forms-ext');
            </script>
            <style>

                .form-row input {
                    padding: 3px 1px;
                    width: 100%;
                }
                input.currency {
                    text-align: right;
                    padding-right: 15px;
                }
                .input-group .form-control {
                    float: none;
                }
                .input-group .input-buttons {
                    position: relative;
                    z-index: 3;
                }
            </style>
        </head>
        <body>

            <?php require_once(__DIR__ . '/../includes/navbar.php'); ?>

            <br>

            <div class="container">
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Add Product</div>
                        <div class="panel-body">



                            <form class="AddClient" action="php/AddPolicy.php?EXECUTE=1&CID=<?php echo $search; ?>" method="POST">

                                <div class="col-md-4">


                                    <p>
                                        <label for='client_name'>Client Name</label>
                                        <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                            <option value="<?php echo $data2['Name']; ?>"><?php echo $data2['Name']; ?></option>
                                            <option value="<?php echo $data2['Name2']; ?>"><?php echo $data2['Name2']; ?></option>
                                            <option value="<?php echo "$data2[Name] and  $data2[Name2]"; ?>"><?php echo "$data2[Name] and  $data2[Name2]"; ?></option>
                                        </select>
                                    </p>


                                    <p>
                                    <div class="form-group">
                                        <label for="soj">Single or Joint:</label>
                                        <select class="form-control" name="soj" id="soj" style="width: 170px" required>
                                            <option value="Single">Single</option>
                                            <option value="Joint">Joint</option>
                                        </select>
                                    </div>
                                    </p>



                                    <p>
                                        <label for="application_number">Application Number:</label>
                                        <?php if (isset($data2['company'])) { ?>

                                            <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" value="<?php
                                            if ($data2['company'] == 'TRB WOL') {
                                                echo "WOL";
                                            } if ($data2['company'] == 'TRB Royal London' || $data2['company'] == 'CUS Royal London') {
                                                echo "Royal London";
                                            }
                                            ?>" required>
                                               <?php } ?>
                                        <label for="application_number"></label>
                                    </p>
                                    <br>


                                    <p>
                                        <label for="policy_number">Policy Number:</label>
                                        <input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" <?php
                                        if ($data2['company'] == 'The Review Bureau' || $data2['company'] == 'ADL_CUS') {
                                            echo "maxlength='10'";
                                        }
                                        ?> placeholder="TBC">
                                    </p>
                                    <br>

                                    <p>
                                    <div class="form-group">
                                        <label for="type">Type:</label>
                                        <select class="form-control" name="type" id="type" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="LTA">LTA</option>
                                            <option value="TRB Archive" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB Archive') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> >TRB Archive</option>
                                                    <?php
                                                    if (isset($data2['company'])) {
                                                        if ($data2['company'] == 'TRB Vitality' || $data2['company'] == 'CUS Vitality') {
                                                            ?>
                                                    <option value="LTA SIC">LTA SIC (Vitality)</option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <option value="LTA CIC">LTA + CIC</option>
                                            <option value="DTA">DTA</option>
                                            <option value="DTA CIC">DTA + CIC</option>
                                            <option value="CIC">CIC</option>
                                            <option value="FPIP">FPIP</option>
                                            <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB Aviva' || $data2['company'] == 'CUS Aviva') {
                                                    ?> 
                                                    <option value="Income Protection">Income Protection</option>
                                                <?php }
                                            }
                                            ?>
                                            <option value="WOL" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB WOL' || $data2['company'] == 'CUS WOL') {
                                                    echo "selected";
                                                }
                                            }
                                            ?> >WOL</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="insurer">Insurer:</label>
                                        <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Legal and General" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'The Review Bureau' || $data2['company'] == 'TRB Archive' || $data2['company'] == 'ADL_CUS') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Legal & General</option>
                                            <option value="Vitality" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB WOL' || $data2['company'] == 'CUS WOL') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Vitality</option>
                                            <option value="Assura" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'Assura') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Assura</option>
                                            <option value="Bright Grey">Bright Grey</option>
                                            <option value="Royal London" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB Royal London' || $data2['company'] == 'CUS Royal London') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Royal London</option>
                                            <option value="One Family" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB WOL' || $data2['company'] == 'TRB WOL') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>One Family</option>
                                            <option value="Aviva" <?php
                                            if (isset($data2['company'])) {
                                                if ($data2['company'] == 'TRB Aviva' || $data2['company'] == 'CUS Aviva') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Aviva</option>
                                        </select>
                                    </div>
                                    </p>
                                </div>

                                <div class="col-md-4">


                                    <p>
                                    <div class="form-row">
                                        <label for="premium">Premium:</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input <?php
                                            if ($data2['company'] == 'TRB Archive') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="premium" name="premium" required/>
                                        </div> 
                                        </p>
        <?php $cal = 2400.00 / 100; ?>

                                        <p>
                                            <!--<div class="form-row">
                                                <div class="notice notice-info" role="alert"><strong><i class="fa fa-exclamation-triangle"></i> Commission calculates at 24%. Check OLP for correct amount, as it will differ by .0% </strong></div>
                                            -->

                                            <label for="commission">Commission</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input <?php
                                            if ($data2['company'] == 'TRB Archive') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
                                        </div> 
                                        </p>
                                        <!--
                                        <script>$(document).ready(function(){
                                            $(".premium").keyup(function(){
                                                  var val1 = +$(".value1").val();
                                                  var val2 = +$(".value2").val();
                                                  $("#commission").val(<?php echo $cal; ?>*val1);
                                           });
                                        });</script>
                                        
                                        -->
                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input <?php
                                                if ($data2['company'] == 'TRB Archive') {
                                                    echo "value='0'";
                                                }
                                                ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required/>
                                            </div> 
                                            </p>

                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input <?php
                                                    if ($data2['company'] == 'TRB Archive') {
                                                        echo "value='0'";
                                                    }
                                                    ?> style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" <?php
                                                        if (isset($data2['company'])) {
                                                            if ($data2['company'] == 'TRB WOL') {
                                                                echo "value='WOL'";
                                                            }
                                                        }
                                                        ?> required/>
                                                </div> 
                                                </p>

                                                <p>
                                                <div class="form-group">
                                                    <label for="CommissionType">Comms:</label>
                                                    <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Indemnity">Indemnity</option>
                                                        <option value="Non Idenmity">Non-Idemnity</option>
                                                        <option value="NA" <?php
                                                        if (isset($data2['company'])) {
                                                            if ($data2['company'] == 'TRB WOL' || $data2['company'] == 'CUS WOL') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>N/A</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-group">
                                                    <label for="comm_term">Clawback Term:</label>
                                                    <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="52">52</option>
                                                        <option value="51">51</option>
                                                        <option value="50">50</option>
                                                        <option value="49">49</option>
                                                        <option value="48">48</option>
                                                        <option value="47">47</option>
                                                        <option value="46">46</option>
                                                        <option value="45">45</option>
                                                        <option value="44">44</option>
                                                        <option value="43">43</option>
                                                        <option value="42">42</option>
                                                        <option value="41">41</option>
                                                        <option value="40">40</option>
                                                        <option value="39">39</option>
                                                        <option value="38">38</option>
                                                        <option value="37">37</option>
                                                        <option value="36">36</option>
                                                        <option value="35">35</option>
                                                        <option value="34">34</option>
                                                        <option value="33">33</option>
                                                        <option value="32">32</option>
                                                        <option value="31">31</option>
                                                        <option value="30">30</option>
                                                        <option value="29">29</option>
                                                        <option value="28">28</option>
                                                        <option value="27">27</option>
                                                        <option value="26">26</option>
                                                        <option value="25">25</option>
                                                        <option value="24">24</option>
                                                        <option value="23">23</option>
                                                        <option value="22">22</option>
                                                        <option value="12">12</option>
                                                        <option value="1 year">1 year</option>
                                                        <option value="2 year">2 year</option>
                                                        <option value="3 year">3 year</option>
                                                        <option value="4 year">4 year</option>
                                                        <option value="5 year">5 year</option>
                                                        <option <?php
                                                        if (isset($data2['company'])) {
                                                            if ($data2['company'] == 'TRB WOL' || $data2['company'] == 'CUS WOL' || $data2['company'] == 'TRB Archive') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="0">0</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Drip</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">£</span>
                                                        <input <?php
                                                        if ($data2['company'] == 'TRB Archive') {
                                                            echo "value='0'";
                                                        }
                                                        ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                    </div> 
                                                    </p>



                                                    <p>
                                                        <label for="closer">Closer:</label>
                                                        <input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
                                                    <script>var options = {
                                                            url: "../JSON/<?php
                                                        if ($companynamere == 'The Review Bureau') {
                                                            echo "CloserNames";
                                                        } else {
                                                            echo "CUS_CLOSERS";
                                                        }
                                                        ?>.json",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };

                                                        $("#closer").easyAutocomplete(options);</script>
                                                    <br>

                                                    <p>
                                                        <label for="lead">Lead Gen:</label>
                                                        <input type='text' id='lead' name='lead' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
                                                    <script>var options = {
                                                            url: "../JSON/<?php
                                                        if ($companynamere == 'The Review Bureau') {
                                                            echo "LeadGenNames";
                                                        } else {
                                                            echo "CUS_LEAD";
                                                        }
                                                        ?>.json",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };

                                                        $("#lead").easyAutocomplete(options);</script>

                                                </div>


                                            </div>



                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="alert alert-info"><strong>Sale Date:</strong> 
                                This is the sale date on the dealsheet. <br><br> <input type="text" id="submitted_date" name="submitted_date" value="<?php
                                if ($data2['company'] == 'TRB Archive') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>

                            </div>   


                            <div class="alert alert-info"><strong>Submitted Date:</strong> 
                                This is the policy live date on the insurers portal. <br> <br><input type="text" id="sale_date" name="sale_date" value="<?php
                                if ($data2['company'] == 'TRB Archive') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>
                            </div>                              
                            <div class="alert alert-info"><strong>Policy Status:</strong> 
                                For any policy where the submitted date is unknown. The policy status should be Awaiting. <br><br>     <div class="form-group">
                                    <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                        <option value="">Select...</option>
                                        <option value="Live">Live</option>
                                        <option value="Awaiting">Awaiting</option>
                                        <option value="Not Live">Not Live</option>
                                        <option value="NTU">NTU</option>
                                        <option value="Declined">Declined</option>
                                        <option value="Redrawn">Redrawn</option>
                                        <?php
                                        if (isset($companynamere)) {
                                            if ($companynamere == 'Assura') {
                                                echo "<option value='Underwritten'>Underwritten</option>";
                                            }
                                        }
                                        ?>
                                        <?php
                                        if (isset($companynamere)) {
                                            if ($companynamere == 'Assura') {
                                                echo "<option value='Awaiting Policy Cancellation Authority'>Awaiting Policy Cancellation Authority</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>

                            </div>                                    
 
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
                                <a href="ViewClient.php?search=<?php echo $search; ?>" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                            </div>                             
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
</body>
</html>
