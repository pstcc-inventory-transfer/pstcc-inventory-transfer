<!-- Designer(s): Jon Knight
  -- Date last modified: 2/2/2018
  -- Dependices: Stylesheet = "desktop.css"
  -->
  
<?php
	include("phpFunctions.php");
	$con1 = connectToDB();
?>

<html lang="en">
    <head>
        <title>UI Demo 4</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>.
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="style/desktop.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('.delete-btn').click(function(event) {
                  event.preventDefault();
                  $(this).closest('tr').remove();
                });
            });
        </script>
        
    </head>
    <body>
        
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" style="height: 100px;" href="#"><img class="thumbnail" style="height: 100%;" src="img_assets/pellissippilogo.png"/></a>
            </div>
            <ul class="nav navbar-nav">
                <li>
                    <select class="form-control">
                        <option>jmknight2@pstcc.edu</option>
                        <option>lbates@pstcc.edu</option>
                    </select>
                </li>
                
                <li><button data-toggle="modal" data-target="#Add_Modal" class="btn btn-block" style="color: white; background-color: #FCD955">Add Item</button></li>
                <li class="active"><button class="btn btn-success btn-block" style="">Submit Transfer</button></li>
                <li><button class="btn btn-danger btn-block" style="">Clear Items</button></li>
            </ul>
          </div>
        </nav>
        
        <div class="content-main container-fluid">
                
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
                <tbody>
                
                    
                    <!--
                      -- The following commented <tr> is template layout for every row in the table. Every row sholud be laid out this way.
                      -->
                    
                    <!--
                    <tr>
                        <td>
                            <input class="form-control" style="max-width: 100px;" name="model" placeholder="Please enter/scan ID" value="1004">
                        </td>
                        <td>Dell Optiplex 980</td>
                        <td>MC329</td>
                        <td>Jon Knight</td>
                        <td>CITC</td>
                        <td>
                            <select class="form-control selectpicker" style="min-width: 0px;" data-show-subtext="true" data-live-search="true">
                                <option>MC235</option>
                                <option>MC236</option>
                                <option>MC237</option>
                                <option>DV205</option>
                                <option>DV206</option>
                                <option>DV207</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                <option>Jon Knight</option>
                                <option>Jacob Simms</option>
                                <option>Zachary Mitchell</option>
                                <option>Ben Millsaps</option>
                                <option>Matthew Ratliff</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                <option>CITC</option>
                                <option>BUSN</option>
                                <option>CHEM</option>
                            </select>
                        </td>
                        <td>Notes...</td>
                        <td><button class="btn btn-danger btn-sm delete-btn"><span class="glyphicon glyphicon-trash"></span></button></td>
                    </tr>
                    -->
                    
                    
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
                <h4 class="modal-title">New Transfer</h4>
              </div>
              <div class="modal-body">
                <form class="form" action="#">
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>PSCC ID#</h4>
                    <input class="form-control" name="ID" id="ID" placeholder="Please enter/scan ID" value="1004">
                </div>
                
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>New Room</h4>
					<select class="form-control selectpicker" id="roomNum" data-show-subtext="true" data-live-search="true">
						<option>Please choose room...</option>
						<?php
							$query= "SELECT DISTINCT Location FROM inv;";
							$options = queryDB($con1, $query);
							
							foreach($options as $row) 
							{
								foreach($row as $value) 
								{
									echo "<option>" . $value . "</option>";
								}
							}
						?>
					</select>
                </div>
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>New Owner</h4>
                    <select class="form-control selectpicker" id="newOwner" data-show-subtext="true" data-live-search="true">
                        <option>Please choose owner...</option>
						<?php
							$query= "SELECT DISTINCT Custodian FROM inv;";
							$options = queryDB($con1, $query);
							
							foreach($options as $row) 
							{
								foreach($row as $value) 
								{
									echo "<option>" . $value . "</option>";
								}
							}
						?>
                    </select>
                </div>
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>New Department</h4>
                    <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                        <option>Please choose dept. ...</option>
						<?php
							$query= "SELECT DISTINCT DeptTo FROM tblTransTemp_072017;";
							$options = queryDB($con1, $query);
							
							foreach($options as $row) 
								foreach($row as $value) 
									echo "<option>" . $value . "</option>";
						?>
                    </select>
                </div>
                
                <div class="form-group">
                    <h4>Notes</h4>
                    <textarea class="form-control" name="notes">
                    
                    </textarea>
                </div>    
                    
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>Model</h4>
                    <input class="form-control" name="model" value=" " readonly>
                </div>
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>Previous Room</h4>
                    <input class="form-control" name="pre_room" value=" " readonly>
                </div>
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>Previous Owner</h4>
                    <input class="form-control" name="pre_owner" value=" " readonly>
                </div>
                <div class="form-group" style="text-align: left; margin: 0 auto;">
                    <h4>Previous Department</h4>
                    <input class="form-control" name="pre_dept" value=" " readonly>
                </div>
                
              </form>
                
              </div>
              <!-- Add Modal content end -->  
                  
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Save Changes</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Add Modal end -->
        
    </body>
</html>