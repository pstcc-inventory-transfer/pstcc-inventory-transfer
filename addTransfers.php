<?php
/**
 * Created by PhpStorm.
 * User: Jacob Simms
 * Date: 3/1/2018
 * Time: 8:40 PM
 */

include 'phpFunctions.php';

date_default_timezone_set("US/Eastern");

//DB Connection
$dbCon=connectToDB();

/*  ----- NOTES -----
$Tech = tech making the move
$Date = date of transaction
$Tag = Pellissippi Asset tag number
$Model = model number
$From = previous room
$Previous = previous owner
$DeptFrom = previous department
$To = new room
$New = new owner
$NewOwnerPnum = new owners P number
$DeptTo = new department
$Notes = Notes
$Instance = transfer number ????? maybe serial number
$InstanceID = ??????
$Submit = ????????
$Hold =  YES or NO are the only answers allowed */

//JSON Parsing and SQL insert statement string creator.
if (isset($_GET['json'])){
    $json=json_decode($_GET['json'], true);
    if ( is_array( $json )) {
        $arraySize = count($json);
        $errors[$arraySize];
        for ($i = 0; $i < $arraySize; $i++) {

            $Tech = $json[$i]['custodian'];
            $Date = date("m/d/Y");   // formatted as mm/dd/yyyy
            $Tag = $json[$i]['itemID'];    // sample IDs = F68963 & 5
            $Model = $json[$i]['model'];
            $From = $json[$i]['preRoom'];
            $Previous = $json[$i]['preOwner'];
            $DeptFrom = $json[$i]['preDept'];
            $To = $json[$i]['newRoom'];
            $New = $json[$i]['newOwner'];
            $NewOwnerPnum = pnumLookUp($dbCon, $json[$i]['newOwner']);
            $DeptTo = $json[$i]['newDept'];
            $Notes = $json[$i]['notes'];
            $Instance = $i + 1;        // What is an instance? A number? Random? Incremental?
            $InstanceID = $i + 1;      // What is an instanceID? A number? Random? Incremental?
            $Submit = '';
            $Hold = 'No';

            $sql =  "INSERT INTO tblTransTemp(Tech, [Date], Tag, Model, [From], Previous, DeptFrom, [To], New, NewOwnerPnum, DeptTo, Notes, Instance, InstanceID, Submit, Hold) VALUES ('".$Tech
                ."','".$Date."','".$Tag."','".$Model."','".$From."','".$Previous."','".$DeptFrom."','".$To."','".$New."','".$NewOwnerPnum
                ."','".$DeptTo."','".$Notes."','".$Instance."','".$InstanceID."','".$Submit."',".$Hold.");";

            $errors[$i] = insertTransfers($dbCon, $sql);
        }
        //implement a confirmation of successful or error message box.
        foreach($errors as $er){
            if ($er == true) {
                echo "Record(s) added successfully";
            } else {
                echo "Not a scalar";
            }
        }
    }
}

function insertTransfers($con, $insertString) {

    odbc_exec( $con, $insertString );

    if (odbc_errormsg($con))
    {
        return false;
    } else {
        return true;
    }

}

function pnumLookUp($con, $newName) {

    $pNumNew = "SELECT [ID] FROM dbo_tblCustodians where [NAME] = '".$newName."';";
    $pNumAnsr = odbc_exec($con, $pNumNew);
    $reply = odbc_fetch_array($pNumAnsr);

    foreach($reply as $value){
        return $value;
    }
}

?>