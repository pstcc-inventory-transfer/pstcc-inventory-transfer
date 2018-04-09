<!-- Designer(s): Jon Knight
  -- Date last modified: 2/8/2018
  -- Modified page for room-scan feature
  -- Dependices: Stylesheet = "desktop.css"
  -->
<?php
    session_start();
	include("phpFunctions.php");
	$con1 = connectToDB();

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
        <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>.
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
                    <select class="form-control" id="roomSelection">
                        <!-- possibly make this auto-filled with database stuff -->
                        <?php
                        $query= "SELECT DISTINCT Location FROM [Complete Active inventory list 52914];";
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
                </li>

                <li style="margin-left: 50px;"><button class="btn btn-success btn-block" onclick="generateWorkingList()">Generate Inventory List</button></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li style="margin-right: 50px;"><button class="btn btn-danger btn-block" onclick="window.location.href='logout.php'">Logout</button></li>
              </ul>
          </div>
        </nav>

        <div class="content-main container-fluid">

            <table class="table table-condensed table-striped">
                <thead>
                    <th>PSCC ID</th>
                    <th>Serial Num</th>
					<th>Custodian</th>
                    <th>Location</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Acquired Date</th>
                    <th></th>
                </thead>
                <tbody class="content-area">

                </tbody>
            </table>
        </div>
		
		

        <script src="manipulate_transfers.js"></script>
    </body>
</html>
