<?php
include 'db_connection.php';
include 'resetEmail.php';

// DB Connection
$con1 = connectToDB();

//SQL requests *added 4/24/18
$techNames = "SELECT techName FROM tblTech order by techName asc;";
$roomNumbers = "SELECT Field1 FROM Inventory_location_lookup order by Field1 asc;";
$custodianNames = "SELECT DISTINCT [NAME] FROM dbo_tblCustodians order by [NAME] asc;";
$departments = "SELECT Field1 FROM tblDepts order by Field1 asc;";
$inventoryTag = "SELECT * FROM tblInventory WHERE TAG = '"; //needs to be accompanied by $end to close the statement.
$inventoryRoom = "SELECT * FROM tblInventory WHERE Location = '"; //needs to be accompanied by $end to close the statement.
$inventoryLocation= "SELECT DISTINCT Location FROM tblInventory order by Location asc;";
$end = "';";


// loads the read-only boxes with data.
if(isset($_REQUEST["idNum"]))
{
    $id = $_REQUEST["idNum"];
    checkForID($id, $inventoryTag, $end, $con1); //updated 4/24/18
}
else if(isset($_REQUEST["room"]))
{
    $room = $_REQUEST["room"];
    getInventoryForRoom($room, $inventoryRoom, $end, $con1); //updated 4/24/18
}
else if(isset($_REQUEST["check"]))
{
    $check = $_REQUEST["check"];
    checkForIdInRoom($check, $inventoryTag, $end, $con1); //updated 4/24/18
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

function checkForID($id, $query, $end, $con) //updated 4/24/18 moved the $query up to the top and renamed it
{
	// lookup all hints from array if $q is different from "" 
	if ($id !== "") 
	{
		$result = queryDB($con, $query.$id.$end); //updated 4/24/18 corrected the query variables
		
		if(count($result) > 0)
		{
			echo $result[0]['Model'] . "," . $result[0]['Location'] . "," . $result[0]['Owner'];  //updated 4/24/18
		}
		
		else echo "error";
	}
	
	else echo false;
}

function checkForIdInRoom($id, $query, $end, $con) //updated 4/24/18 moved the $query up to the top and renamed it
{
	// lookup all hints from array if $q is different from "" 
	if ($id !== "") 
	{
		$result = queryDB($con, $query.$id.$end); //updated 4/24/18 corrected the query variables
		
		if(count($result) > 0)
		{
			echo json_encode($result);
		}
		
		else echo "error";
	}
	
	else echo "error";
}

function getInventoryForRoom($room, $query, $end, $con) //updated 4/24/18 moved the $query up to the top and renamed it
{
	// lookup all hints from array if $q is different from ""
	if ($room !== "")
	{
		$result = queryDB($con, $query.$room.$end); //updated 4/24/18 corrected the query variables

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

        $mainUrl=$_SERVER['HTTP_HOST'];
        $temp = explode('/',$_SERVER['REQUEST_URI']);
        for($i=0;$i<count($temp)-1;$i++){
            $mainUrl.=$temp[$i].'/';
        }
        $mainUrl.='resetPassword.php';
        
        $passDateHash = urlencode( str_replace('%', '%25', exec('.\verification\scramblerVerify.exe -e "'.$pwdHash.$expireDate.'"')));
        $link = "$mainUrl?q1=$passDateHash&q2=$user";
        
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

function dropDowns($con1, $query) //created 4/24/18 this is the method that is being called by inventoryScan.php, inventory-transfers.php & m.inventory-transfers.php
{
    $options = queryDB( $con1, $query );

    foreach ($options as $row) {
        foreach ($row as $value) {
            echo "<option>" . $value . "</option>";
        }
    }
}

?>