<?php
include 'db_connection.php';
include 'resetEmail.php';

// DB Connection
$con1 = connectToDB();

// checks for
if(isset($_REQUEST["idNum"]))
{
    $id = $_REQUEST["idNum"];
    checkForID($id, $con1);
}
else if(isset($_REQUEST["room"]))
{
    $room = $_REQUEST["room"];
    getInventoryForRoom($room, $con1);
}
else if(isset($_REQUEST['user']) && isset($_REQUEST["newPwd"]))
{
    $user = $_REQUEST['user'];
    $newPwd = $_REQUEST["newPwd"];
    updatePassword($user, $newPwd, $con1);
}
else if(isset($_REQUEST["user"]))
{
    $user = $_REQUEST["user"];
    generateResetLink($user, $con1);
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

function generateResetLink($user, $con)
{
    if($user !== "")
    {
        date_default_timezone_set('UTC');
        
        $query = "SELECT password FROM tblUsers WHERE userName = '".($user == 'admin'?'Administrator':'Technician')."'";
        $result = queryDB($con, $query);
        
        $pwdHash = trim($result[0]['password']);
        
        $expireDate = date('m-d');

        $passDateHash = urlencode( str_replace('%', '%25', exec('.\verification\scramblerVerify.exe -e "'.$pwdHash.$expireDate.'"')));
        
        $link = "http://18.219.117.88/resetPassword.php?q1=$passDateHash&q2=$user";
        
        echo resetEmail(($user == 'admin'?'Administrator':'Technician'),$link);
    }
}

function updatePassword($user, $newPwd, $con)
{
    if($newPwd !== "")
    {
        $newPwd = exec('.\verification\scramblerVerify.exe -e "'. $newPwd.'"');
        
        $query = "UPDATE tblUsers SET password = '$newPwd' WHERE userName = '".($user == 'admin'?'Administrator':'Technician')."'";
        $result = odbc_exec($con, $query);
        
        if(odbc_error())
            echo 'Failure';
        else echo 'true';
    }
}
?>