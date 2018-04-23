<!-- Designer(s): Jon Knight
  -- Date last modified: 2/2/2018
  -- Dependices: Stylesheet = "desktop.css"
  -->
<?php
    session_start();
    include("phpFunctions.php");

    if (!$_SESSION['auth'])
    {
        header('Location: index.php');
        die();
    }
?>
<html lang="en">
    <head>
        <title>PSTCC Transfer</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="style/desktop.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" style="height: 100px;"><img style="height: 100%;" src="img_assets/pelli_full.svg"/></a>
            </div>
            <ul class="nav navbar-nav">
                <li>
                    <select class="form-control" id="technician">
                    <?php
                        dropDowns($con1, $techNames); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                    ?>
                    </select>
                </li>

                <li style="margin-left: 25px;"><button data-toggle="modal" data-target="#Add_Modal" class="btn btn-block" id="addBtn">Add Item</button></li>
                <li style="margin-left: 50px;"><button class="btn btn-success btn-block" onclick="submitFinal()">Submit Transfer</button></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li style="margin-right: 50px;"><button class="btn btn-danger btn-block" onclick="window.location.href='logout.php'">Logout</button></li>
              </ul>
          </div>
        </nav>

<div class="content-main  container-fluid">

    <table class="table table-condensed table-striped">
        <thead>
        <th>PSCC ID</th>
        <th>Model</th>
        <th>Current Room</th>
        <th>Current Owner</th>
        <th>Current Dept.</th>
        <th>New Room</th>
        <th>New Owner</th>
        <th>New Dept.</th>
        <th>Notes</th>
        <th></th>
        </thead>
        <tbody class="content-area">

        </tbody>
    </table>
</div>


<!-- Add Modal start -->
<div id="Add_Modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Add Modal content start -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Transfer Details</h4>
            </div>
            <div class="modal-body container-fluid">

                <div class="col-sm-6">
                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>PSCC ID#</h4>
                        <input class="form-control" name="ID" id="IDAdd" placeholder="Please enter/scan ID"
                               onkeyup="getInfoFromTag(this.value)" style="text-transform: uppercase">
                    </div>

                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>New Room</h4>
                        <select class="form-control selectpicker" id="newRoom" data-show-subtext="true"
                                data-live-search="true">                          
                            <option value="none" selected disabled>Please choose owner...</option>
                            <?php
                                dropDowns($con1, $roomNumbers); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>New Owner</h4>
                        <select class="form-control selectpicker" id="newOwner" data-show-subtext="true"
                                data-live-search="true">
                            <option value="none" selected disabled>Please choose owner...</option>
                            <?php
                                dropDowns($con1, $custodianNames); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                            ?>
                        </select>
                    </div>

                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>New Department</h4>
                        <select class="form-control selectpicker" id="newDept" data-show-subtext="true"
                                data-live-search="true">
                            <option value="none" selected disabled>Please choose dept...</option>
                            <?php
                                dropDowns($con1, $departments); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <h4>Notes</h4>
                        <textarea maxlength="255" class="form-control" name="notes" id="notes"></textarea>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>Model</h4>
                        <input class="form-control" id="model" name="model" readonly>
                    </div>
                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>Previous Room</h4>
                        <input class="form-control" id="pre_room" name="pre_room" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>Previous Owner</h4>
                        <input class="form-control" id="pre_owner" name="pre_owner" readonly>
                    </div>
                    <div class="form-group" style="text-align: left; margin: 0 auto;">
                        <h4>Previous Department</h4>
                        <input class="form-control" id="pre_dept" name="pre_dept" readonly>
                    </div>
                </div>

            </div>
            <!-- Add Modal content end -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submit();">Save Changes</button>
            </div>
        </div>

    </div>
</div>
<!-- Add Modal end -->
        
<div id="alertModal" class="modal fade" role="dialog" style="color: black; text-align: left;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="alert-modal-title"></h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p id="alert-modal-body"></p>
            </div>
        </div>
    </div>
</div>

<script src="manipulate_transfers.js"></script>
</body>
</html>