<?php
/**
 * Created by PhpStorm.
 * User: Jacob Simms
 * Date: 3/1/2018
 * Time: 8:40 PM
 */

include 'phpFunctions.php';
include 'email.php';
require 'fpdf/wordwrap.php';

date_default_timezone_set("US/Eastern");


date_default_timezone_set("US/Eastern");

//DB Connection
$dbCon=connectToDB();

//tblTransTemp

$Tech = ''; //tech making the move
$Date = ''; //date of transaction
$Tag = ''; //Pellissippi Asset tag number
$Model = ''; //model number
$From = ''; //previous room
$Previous = ''; //previous owner
$DeptFrom = ''; //previous department
$To = ''; //new room
$New = ''; //new owner
$NewOwnerPnum = ''; //new owners P number
$DeptTo = ''; //new department
$Notes = ''; //Notes
$Instance = ''; //transfer number ????? maybe serial number
$InstanceID = ''; //??????
$Submit = ''; //????????
$Hold = ''; // YES or NO are the only answers allowed

$GLOBALS['readyToSend'] = false;

//JSON Parsing and SQL insert statement string creator.
   if (isset($_GET['json'])){
     $json=json_decode($_GET['json'], true);
     if ( is_array( $json )) {
        $i=0;
         foreach($json as $string) {
             $Tech = $json[$i]['custodian'];
             $Date = date("m/d/Y");   // figure out how to get data and time
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
             $Hold = 'No';

             $sql =  "INSERT INTO tblTransTemp(Tech, Tag, Model, [From], Previous, DeptFrom, [To], New, NewOwnerPnum, DeptTo, Notes, Instance, InstanceID, Submit, Hold) VALUES ('".$Tech."', '".$Tag."','".$Model."','".$From."','".$Previous."','".$DeptFrom."','".$To."','".$New."','".$NewOwnerPnum."','".$DeptTo."','".$Notes."','".$Instance."','".$InstanceID."','".$Submit."',".$Hold.")";$sql =  "INSERT INTO tblTransTemp(Tech, [Date], Tag, Model, [From], Previous, DeptFrom, [To], New, NewOwnerPnum, DeptTo, Notes, Instance, InstanceID, Submit, Hold) VALUES ('".$Tech
             ."','".$Date."','".$Tag."','".$Model."','".$From."','".$Previous."','".$DeptFrom."','".$To."','".$New."','".$NewOwnerPnum
             ."','".$DeptTo."','".$Notes."','".$Instance."','".$InstanceID."','".$Submit."',".$Hold.");";

             if(insertTransfers($sql))
                 $GLOBALS['readyToSend'] = true;
         }
     }
     if($GLOBALS['readyToSend']){
        sendEmail($_GET['json'], (generatePDF($json)?true:false));
        echo "Records added successfully";
     }
   } else {
       echo "No transfers to add";
}

function insertTransfers($uname) {
    $con=connectToDB();
    //$sql = "INSERT INTO dbo_tblCustodians(ID, NAME, FFBMAST_CUSTODIAN_PIDM) VALUES ('P1234567', '" . $uname ."', 12345)";
    //This will help us know if we can send an email:
    odbc_exec($con,$uname);
    if (odbc_error()){
    echo odbc_errormsg($con);
    return false;
    }
	
	else return true;
}

function pnumLookUp($con, $newName) {

    $pNumNew = "SELECT [ID] FROM dbo_tblCustodians where [NAME] = '".$newName."';";
    $pNumAnsr = odbc_exec($con, $pNumNew);
    $reply = odbc_fetch_array($pNumAnsr);

    foreach($reply as $value){
        return $value;
    }
       $pNumAnsr = odbc_exec($con, $pNumNew);
       $reply = odbc_fetch_array($pNumAnsr);
       foreach($reply as $value){
        return $value;
    }
}

function generatePDF($jsonArr)
{
	$pdf = new FPDF();
	$pdf->AddPage();
	createTitle($pdf);
	$pdf->SetFont('Arial','B',6);
	
	$header = array('PSCC ID', 'Model', 'Current Room', 'Current Owner', 'Current Dept.', 'Rew Room', 'New Owner', 'New Dept.', 'Notes');
	
	FancyTable($pdf, $header, $jsonArr);
	
	$pdf->Output("./emailClient/transferlist.pdf", "F");
	
	if(!file_exists("./emailClient/transferlist.pdf"))
	{
        echo "Failed to create pdf file.";
        return false;
    }
    else return true;
}

function FancyTable($pdf, $header, $data)
{
    // Colors, line width and bold font
    $pdf->SetFillColor(0,75,142);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(128,0,0);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('','B');
	
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell(21,7,$header[$i],1,0,'C',true);
    $pdf->Ln();
	
    // Color and font restoration
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
	
    // Data
    $fill = false;
    foreach($data as $row)
    {
		formatAndGenerateRow($pdf, $fill, $row['itemID']);
		formatAndGenerateRow($pdf, $fill, $row['model']);
		formatAndGenerateRow($pdf, $fill, $row['preRoom']);
		formatAndGenerateRow($pdf, $fill, $row['preOwner']);
		formatAndGenerateRow($pdf, $fill, $row['preDept']);
		formatAndGenerateRow($pdf, $fill, $row['newRoom']);
		formatAndGenerateRow($pdf, $fill, $row['newOwner']);
		formatAndGenerateRow($pdf, $fill, $row['newDept']);
		formatAndGenerateRow($pdf, $fill, $row['notes']);
			
		$pdf->Ln();
		$fill = !$fill;
    }
	
    // Closing line
    $pdf->Cell(array_sum($w),0,'','T');
}

function createTitle($pdf)
{
    // Logo
    $pdf->Image('img_assets/pelli_full.png',10,6,30);
    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Move to the right
    $pdf->Cell(50);
    // Title
    $pdf->Cell(100,10,'PSCC Inventory Transfer List',1,0,'C');
    // Line break
    $pdf->Ln(15);
	$pdf->Cell(75);
	// Date
	$pdf->Cell(50,10,date("m/d/Y"),1,0,'C');
	
	$pdf->Ln(35);
}

function formatAndGenerateRow($pdf, $fill, $str)
{
	if(strlen($str) > 7)
	{
		$strFormatted = substr($str, 0, 13);
		$pdf->Cell(21,6,$strFormatted,'LRB',0,'L',$fill);
	}
			
	else $pdf->Cell(21,6,$str,'LRB',0,'L',$fill);
}

?>
