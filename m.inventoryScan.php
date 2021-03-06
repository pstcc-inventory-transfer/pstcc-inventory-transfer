<!-- Designer(s): Jon Knight
  -- Date last modified: 2/8/2018
  -- Modified page for room-scan feature
  -- Dependices: Stylesheet = "desktop.css"
  -->
<?php
    session_start();
	include("phpFunctions.php");
	$con1 = connectToDB();

    if(!$_SESSION['auth'] || !$_SESSION['isAdmin'])
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
        <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>.
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="style/m.inventoryScan.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top" >
          <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li>
                    <select class="form-control" id="roomSelection">
                        <?php
                            dropDowns($con1, $inventoryLocation); //updated 4/24/18 moved the code into the dropDowns function in phpFunctions.php
                        ?>
                    </select>
                </li>

				        <li id="inputBox"><input type='text' style="width:94.8%;" onkeyup="updateInventory(this.value)"/></li>
                <li id="generateListBtn"><button class="btn btn-success btn-block" onclick="generateWorkingList()">Generate Inventory List</button></li>
				        <li id="resetBtn"><button class="btn btn-success btn-block" onclick="restartRoomSelection()">Select Another Room</button></li>
                <li id="logBtn"><button class="btn btn-danger btn-block" onclick="window.location.href='logout.php'">Logout</button></li>
			        </ul>
          </div>
        </nav>

        <div class="content-main container-fluid">

            <table class="table table-condensed" id="inventoryScanTable">
                <thead>
                    <th>PSCC ID</th>
                    <th>Serial Num</th>
                    <th>Location</th>
                    <th>Acquired Date</th>
					<!--<th>Change Quantity</th>-->
                </thead>
                <tbody class="content-area">
				<!-- Table body dynamically generated in manipulate_transfers.js -->
                </tbody>
            </table>
        </div>

        <script src="manipulate_transfers.js"></script>
		<script src="m.inventory_scan.js"></script>

		<div id="alertModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="alert-modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <p id="alert-modal-body"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
