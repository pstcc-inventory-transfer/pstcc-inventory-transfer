<?php
include 'db_connection.php';

// DB Connection
$con1 = connectToDB();

// checks for
if(isset($_REQUEST["idNum"]))
{
    $id = $_REQUEST["idNum"];
    checkForID($id, $con1);
}

if(isset($_REQUEST["room"]))
{
    $room = $_REQUEST["room"];
    getInventoryForRoom($room, $con1);
}


// ------ START OF FUNCTIONS ------

function getInfo($id)
{
	// lookup all hints from array if $q is different from "" 
	if ($id !== "") 
	{
		$query= "SELECT * FROM [Complete Active inventory list 52914] WHERE TAG = '$id'";
		echo "this is a test";
	}
}

function checkForID($id, $con)
{
	// lookup all hints from array if $q is different from "" 
	if ($id !== "") 
	{
		$query = "SELECT * FROM [Complete Active inventory list 52914] WHERE TAG = '$id'";
		$result = queryDB($con, $query);
		
		if(count($result) > 0)
		{
			echo $result[0]['Model'] . "," . $result[0]['Location'] . "," . $result[0]['Custodian'];
		}
		
		else echo "error";
	}
	
	else echo false;
}

function getInventoryForRoom($room, $con)
{
	// lookup all hints from array if $q is different from ""
	if ($room !== "")
	{
		$query = "SELECT * FROM [Complete Active inventory list 52914] WHERE Location = '$room'";
		$result = queryDB($con, $query);

		if(count($result) > 0)
		{
			echo json_encode($result);
		}

		else echo "error";
	}

	else echo false;
}
?>



