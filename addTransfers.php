<?php
/**
 * Created by PhpStorm.
 * User: Jacob Simms
 * Date: 3/1/2018
 * Time: 8:40 PM
 * Last Updated: 4/6/2018
 */

include 'phpFunctions.php';
include 'email.php';
require 'fpdf/wordwrap.php';
//Create DB exceptions
class InsertException extends Exception{}

//Create date format
date_default_timezone_set("US/Eastern");


//DB Connection
$dbCon=connectToDB();

$GLOBALS['readyToSend'] = false;

//JSON Parsing and SQL insert statement string creator.
if (isset($_POST['json']))
{
    $json=json_decode($_POST['json'], true);
    if ( is_array( $json ))
    {
        $i = 1; //iNumIncrease($dbCon);
        foreach($json as $string)
        {
            $tech = $string['technician'];
            $date = 'date()';
            $tag = $string['itemID'];
            $model = $string['model'];
            $from = $string['preRoom'];
            $previous = $string['preOwner'];
            $deptFrom = $string['preDept'];
            $to = $string['newRoom'];
            $new = $string['newOwner'];
            $newOwnerPnum = pnumLookUp($dbCon, $string['newOwner']);
            $deptTo = $string['newDept'];
            $notes = $string['notes'];
            $instance = $i;
            $instanceID = "{$tag}{$to}".date("jdY");

            $sql =  "INSERT INTO tblTransTemp(Tech, [Date], Tag, Model, [From], Previous, DeptFrom, [To], New, NewOwnerPnum, DeptTo, Notes, Instance, InstanceID) VALUES (
                    '$tech', $date, '$tag', '$model', '$from', '$previous', '$deptFrom', '$to', '$new', '$newOwnerPnum', '$deptTo', '$notes', $instance, '$instanceID');";

            if (insertTransfers($dbCon, $sql) == true) {
                $GLOBALS['readyToSend'] = true;
            }
        }
    }
    if($GLOBALS['readyToSend']){
        echo 'true';
        sendEmail($_POST['json'], (generatePDF($json)?true:false));
    }
}
else
{
    echo "No transfers to add";
}

function insertTransfers($con, $sqlStatement)
{
    Try {
      if ( !odbc_exec( $con, $sqlStatement )){
          throw new InsertException( odbc_errormsg($con)." The tables could be locked by other users or forms.");
      } else {
          return true;
      }
  }
  catch (InsertException $ex){
      echo ' Error: '.$ex->getMessage();
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

function generatePDF($jsonArr)
{
	$pdf = new FPDF();
	$pdf->AddPage();
	createTitle($pdf);
	$pdf->SetFont('Arial','B',6);
	
	$header = array('Transfer Tech', 'PSCC ID', 'Model', 'Current Room', 'Current Owner', 'New Room', 'New Owner', 'New Dept.', 'Notes');
	
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
		formatAndGenerateRow($pdf, $fill, $row['technician'], 0);
		formatAndGenerateRow($pdf, $fill, $row['itemID'], 0);
		formatAndGenerateRow($pdf, $fill, $row['model'], 0);
		formatAndGenerateRow($pdf, $fill, $row['preRoom'], 0);
		formatAndGenerateRow($pdf, $fill, $row['preOwner'], 0);
		formatAndGenerateRow($pdf, $fill, $row['newRoom'], 0);
		formatAndGenerateRow($pdf, $fill, $row['newOwner'], 0);
		formatAndGenerateRow($pdf, $fill, $row['newDept'], 0);
		formatAndGenerateRow($pdf, $fill, $row['notes'], 1);
		
		$pdf->Ln();
		$fill = !$fill;
    }

    // Closing line
    $pdf->Cell(array_sum($w),0,'','T');
}

function createTitle($pdf)
{
    // Logo
    $pdf->Image('img_assets/pellissippilogo.png',5,5);
    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Move to the right
	$pdf->Ln(15);
    $pdf->Cell(64);
    // Title
    $pdf->Cell(100,10,'Inventory Transfer List');
    // Line break
    $pdf->Ln(10);
	$pdf->Cell(80);
	// Date
	$pdf->Cell(50,10,date("m/d/Y"));
	$pdf->Ln(25);
}

function formatAndGenerateRow($pdf, $fill, $str, $isNotes)
{
	if(strlen($str) > 7)
	{
		if($isNotes == 1)
			$strFormatted = (substr($str, 0, 13)) . '...';
		
		else $strFormatted = substr($str, 0, 13);
		
		$pdf->Cell(21,6,$strFormatted,'LRB',0,'L',$fill);
	}

	else $pdf->Cell(21,6,$str,'LRB',0,'L',$fill);
}

?>