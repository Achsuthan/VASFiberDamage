<?php
header("Access-Control-Allow-Origin: *");


$from=htmlentities($_POST["from"]);
$to=htmlentities($_POST["to"]);
$wip=htmlentities($_POST["wip"]);
$new=htmlentities($_POST["new"]);
$completed=htmlentities($_POST["completed"]);

/*
require('fpdf.php');

class PDF extends FPDF
{

// Page header
    function Header()
    {
        // Logo
        $this->Image('dialog.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Times','B',25);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Fiber Cable Damage Details',0,0,'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,iconv("UTF-8", "ISO-8859-1", "©").' 2017 - Developed by VAS Operations, Dialog Axiata PLC.         Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

// Load data
function LoadData($file)
{
	// Read file lines
	$lines = file($file);
	$data = array();
	foreach($lines as $line)
		$data[] = explode(';',trim($line));
	return $data;
}
// Colored table
function FancyTable($from,$to,$wip,$new,$completed)
{
	// Colors, line width and bold font
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');

    $this->Cell(25,7,"Ref Number",1,0,'C',true);
    $this->Cell(20,7,"Date",1,0,'C',true);
    $this->Cell(20,7,"Time",1,0,'C',true);
    $this->Cell(20,7,"UserID",1,0,'C',true);
    $this->Cell(25,7,"Lat,Lng",1,0,'C',true);
    $this->Cell(75,7,"Usercomment",1,0,'C',true);
    $this->Cell(30,7,"CurrentStatus",1,0,'C',true);
    $this->Cell(20,7,"WIP Date",1,0,'C',true);
    $this->Cell(75,7,"WIP Comment",1,0,'C',true);
    $this->Cell(20,7,"Comp Date",1,0,'C',true);
    $this->Cell(75,7,"Complete Comment",1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;




//$salt=openssl_random_pseudo_bytes(20);
//$securedpassword=sha1($password.$salt);

    $file=parse_ini_file("Test.ini");

    $host=trim($file["dbhost"]);
    $user=trim($file["dbuser"]);
    $pass=trim($file["dbpass"]);
    $dbname=trim($file["dbname"]);

    require ("Secure/access.php");

    $access=new access($host,$user,$pass,$dbname);
    $access->connect();

    $result=$access->get_damage_details_pdf($from,$to,$wip,$new,$completed);
    if($result)
    {
        $access->disconnect();
        //echo json_encode($result);
        $w = array(25, 20, 20, 20, 25, 75, 30, 20, 75, 20, 75);
        foreach($result as $row)
        {
            $lat_lng=round($row["lat"],4).",".round($row["lng"],4);
            $this->Cell(25,6,$row["dam_id"],'LR',0,'L',$fill);
            $this->Cell(20,6,$row["date"],'L',0,'L',$fill);
            $this->Cell(20,6,$row["time"],'L',0,'L',$fill);
            $this->Cell(20,6,$row["user_id"],'L',0,'L',$fill);
            $this->Cell(25,6,$lat_lng,'LR',0,'L',$fill);
            $this->Cell(75,6,$row["comment"],'L',0,'L',$fill);
            $this->Cell(30,6,$row["current_status"],'L',0,'L',$fill);
            $this->Cell(20,6,$row["wip_date"],'L',0,'L',$fill);
            $this->Cell(75,6,$row["wip_comment"],'L',0,'L',$fill);
            $this->Cell(20,6,$row["completed_date"],'L',0,'L',$fill);
            $this->Cell(75,6,$row["completed_comment"],'L',0,'L',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w),0,'','T');
        
    }
}
}









//$from=htmlentities($_POST["from"]);
//$to=htmlentities($_POST["to"]);
//$wip=htmlentities($_POST["wip"]);
//$new=htmlentities($_POST["new"]);
//$completed=htmlentities($_POST["completed"]);

$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->AddPage('L','A3');
//$pdf->BasicTable($header,$data);
//$pdf->AddPage();
//$pdf->ImprovedTable($header,$data);
//$pdf->AddPage();
$pdf->FancyTable($from,$to,$wip,$new,$completed);
$pdf->Output("/var/www/html/MyGalaxy/Fiber/uploads/output.pdf",'F');
*/

$file=parse_ini_file("Test.ini");

    $host=trim($file["dbhost"]);
    $user=trim($file["dbuser"]);
    $pass=trim($file["dbpass"]);
    $dbname=trim($file["dbname"]);

    require ("Secure/access.php");

    $access=new access($host,$user,$pass,$dbname);
    $access->connect();

    $result=$access->get_damage_details_pdf($from,$to,$wip,$new,$completed);
    if($result)
    {
		$column=array();
        
        array_push($column,"dam_id");
        array_push($column,"Ref_ID");
        array_push($column,"Pic_Path");
        array_push($column,"User Comment");
        array_push($column,"lat");
        array_push($column,"lng");
        array_push($column,"User_ID");
        array_push($column,"User_Added_Date");
        array_push($column,"Time");
        array_push($column,"Cuurent_Status");
        array_push($column,"WIP_Date");
        array_push($column,"WIP_Comment");
        array_push($column,"Completed_Date");
        array_push($column,"Completed_Comment");
		array_push($column,"Deleted_Comment");
        array_push($column,"Deleted_Date");
        
        
        $file = fopen('uploads/output.csv', 'w');
        chmod("uploads/output.csv", 0777);
        
        fputcsv($file, $column);
        for ($j = 0; $j < count($result); $j++) {
            fputcsv($file, $result[$j]);
        }
        fclose($file);
	}
echo "http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/uploads/output.csv";
?>
