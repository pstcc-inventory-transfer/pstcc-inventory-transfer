<!-- Designer(s): Jon Knight, Matthew Ratliff, (Zachary Mitchell - minor edit), Jacob Simms (SQL queries)
  -- Date last modified: 4/9/2018
  -- Dependices: Stylesheet = "mobile.css", JS = "manipulate_transfers_mobile.js"
  -->

<?php
    session_start();
	include("phpFunctions.php");

    if(!$_SESSION['auth'])
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
        <link rel="stylesheet" href="style/mobile.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    </head>
    <body>

        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li>
                    <select class="form-control" id="technician">
                        <?php
                            dropDowns($con1, $techNames); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                        ?>
                    </select>
                </li>
                <li class="active"><button class="btn btn-success btn-block" onclick="submitFinal()">Submit Transfer</button></li>
                <li><button class="btn btn-danger btn-block" onclick="window.location.href='logout.php'">Logout</button></li>
            </ul>
          </div>
        </nav>

        <div class="container-fluid mobile">

          <div id="items">
            <button id="add-item" data-toggle="modal" data-target="#Add_Modal"><span class="glyphicon glyphicon-plus"></span></button>

          </div>
        </div>

		<!-- Transfer Modal start -->
        <div id="Add_Modal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Transfer Modal content start -->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Transfer Details</h4>
              </div>
              <div class="modal-body">
                  
                <div class="form-group">
                    <h4>PSCC ID#</h4>
                    <div class="input-group">
                        <input class="form-control" name="ID" id="IDAdd" placeholder="Please enter/scan ID" value="" onkeyup="getInfoFromTag(this.value)">
                        <span class="barcode input-group-addon" onclick="barcodeScan(IDAdd)"><span class="glyphicon glyphicon-barcode"></span></span>
                    </div>
                </div>

                <div class="form-group">
                    <h4>New Room</h4>
                    <select id="newRoom" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                        <option value="none" selected disabled>Please choose room...</option>
                        <?php
                            dropDowns($con1, $roomNumbers); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                        ?>
                    </select>
                </div>
                  
                <div class="form-group">
                    <h4>New Owner</h4>
                    <select id="newOwner" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                        <option value="none" selected disabled>Please choose owner...</option>
                        <?php
                            dropDowns($con1, $custodianNames); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <h4>New Department</h4>
                    <select id="newDept" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                        <option value="none" selected disabled>Please choose dept...</option>
                        <?php
                            dropDowns($con1, $departments); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <h4>Notes</h4>
                    <textarea class="form-control" id="notes" name="notes"></textarea>
                </div>

                <div class="form-group" >
                    <h4>Model</h4>
                    <input class="form-control" id="model" name="model" readonly>
                </div>
                <div class="form-group" >
                    <h4>Previous Room</h4>
                    <input class="form-control" id="pre_room" name="pre_room" value=" " readonly>
                </div>
                <div class="form-group" >
                    <h4>Previous Owner</h4>
                    <input class="form-control" id="pre_owner" name="pre_owner" value=" " readonly>
                </div>
                <div class="form-group" >
                    <h4>Previous Department</h4>
                    <input class="form-control" id="pre_dept" name="pre_dept" value=" " readonly>
                </div>

                </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submit()">Save Changes</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Add Modal end -->

        <div id="alertModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header alert-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="alert-modal-title"></h4>
                    </div>
                    <div id="alert_ModalBody" class="modal-body">
                        <p id="alert-modal-body"></p>
                    </div>
                </div>
            </div>
        </div>

        <script src="manipulate_transfers.js"></script>

        <script>
        var android = false;
        var barcodeScripts = [document.createElement("script")];
            //lulz stole some of Jon's code ;P
            if(navigator.userAgent.match(/Android/i)){
                android = true;
                barcodeScripts[0].src="barcode/scannerAndroid.js";
                document.body.appendChild(barcodeScripts[0]);
            }
            else{
                barcodeScripts[0].src="barcode/quagga/dist/quagga.js";
                barcodeScripts[1] = document.createElement("script");
                barcodeScripts[1].src="barcode/scanner.js";
                document.body.appendChild(barcodeScripts[0]);
                document.body.appendChild(barcodeScripts[1]);
            }
            function barcodeScan(){
                if(android)
                    getScan();
                else scan(arguments[0]);
            }

        </script>
    </body>
</html>
