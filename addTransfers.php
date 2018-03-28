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
<<<<<<< HEAD
   if (isset($_GET['json'])){
     $json=json_decode($_GET['json'], true);
     if ( is_array( $json )) {
         $arraySize = count($json);
         for ($i = 0; $i < $arraySize; $i++) {

             $Tech = 'You are';
             //$Date = date(date_timestamp_get())      // figure out how to get data and time
             $Tag = $json[$i]['itemID'];
             $Model = $json[$i]['model'];
             $From = $json[$i]['preRoom'];
             $Previous = $json[$i]['preOwner'];
             $DeptFrom = $json[$i]['preDept'];
             $To = $json[$i]['newRoom'];
             $New = $json[$i]['newOwner'];
             $NewOwnerPnum = pnumLookUp($dbCon, $json[$i]['newOwner']);
             $DeptTo = $json[$i]['newDept'];
             $Notes = $json[$i]['notes'];
             $Instance = $i + 1;
             $InstanceID = $i + 1;
             $Submit = '';
             $Hold = 'Yes';

             $sql =  "INSERT INTO tblTransTemp(Tech, Tag, Model, [From], Previous, DeptFrom, [To], New, NewOwnerPnum, DeptTo, Notes, Instance, InstanceID, Submit, Hold) VALUES ('".$Tech."', '".$Tag."','".$Model."','".$From."','".$Previous."','".$DeptFrom."','".$To."','".$New."','".$NewOwnerPnum."','".$DeptTo."','".$Notes."','".$Instance."','".$InstanceID."','".$Submit."',".$Hold.");";

             //echo $New . '    '.$NewOwnerPnum;

             insertTransfers($dbCon, $sql);
         }
     } else {
         echo "ERROR in the is_array if statement.";
     }
   } else {
       echo "No transfers to add";
=======
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
>>>>>>> ea951edbf8292ed7e3bbd597e2d4cd021efefde0
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

<<<<<<< HEAD
       if (!is_array($pNumAnsr)) {
         echo "Is array";
       }
       foreach($pNumAnsr as $key => $value) {
         echo "PNum: " . $pNumAnsr . "\nKey: " . $key . "\nValue: " . $value;
       }

       }*/
       echo $pNumAnsr[0]['ID'];
       //print_r( $pNumAnsr[1]);
       return $pNumAnsr;
=======
    foreach($reply as $value){
        return $value;
    }
>>>>>>> ea951edbf8292ed7e3bbd597e2d4cd021efefde0
}

?>
