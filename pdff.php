<?php
require ('FPDF/fpdf.php');
session_start();

require("dbinfo.inc");

$firstName;
$lastName;
$email = $_SESSION['UserData']['Username'];
$address;
$userId;
$Name;

global $servername, $database, $username, $password;
	 global $log;
	 
	 $myHandle;
	try{
		$myHandle = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	
	}catch(PDOException $e){
	
		$err .="Connection failed: " . $e->getMessage(). "\n";
	}

	if($myHandle){
		
		$myStmt = "SELECT firstName, lastName, address,uid FROM User WHERE email='$email'";
		$rslt = $myHandle->query($myStmt);

		$log = $myStmt;
		if(count($rslt) > 0){
			foreach($rslt as $row){
				$firstName = $row['firstName'];
				$lastName = $row['lastName'];
				$address = $row['address'];
				$userId = $row['uid'];
			}
		}
	}

if($myHandle){

    $query1 = "select * from Course, enrolledCourses where Course.cid = enrolledCourses.cid";
    $rslt = $myHandle->query($query1);

    $log = $query1;
    if(count($rslt) > 0){
        foreach($rslt as $row){
            $Name = $row['name'];
            $fee = $row['fee'];
//            $lastName = $row['lastName'];
//            $address = $row['address'];
        }
    }
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
//$pdf->SetFont('Arial', 'B', 14);
//$pdf->Cell(130, 5, 'Totall Real and Not Fake University', 1, 0);
//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130 ,5,'Totally Real and Not Fake University',0,0);
$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130 ,5,'[900 Fifth St]',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(130 ,5,'[Nanaimo, BC]',0,0);
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,'[01/01/2020]',0,1);//end of line

$pdf->Cell(130 ,5,'Phone [+12345678]',0,0);
$pdf->Cell(25 ,5,'Invoice #',0,0);
$pdf->Cell(34 ,5,'[1234567]',0,1);//end of line

$pdf->Cell(130 ,5,'Fax [+12345678]',0,0);
$pdf->Cell(25 ,5,'Student ID',0,0);
$pdf->Cell(34 ,5,$userId,0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$firstName.' '.$lastName,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$address,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$email,0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(130 ,5,'Course Name',1,0);
$pdf->Cell(25 ,5,'Taxable',1,0);
$pdf->Cell(34 ,5,'Amount',1,1);//end of line

$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter
$pdf->Cell(130 ,5,$Name,1,0);
//$pdf->Cell(130 ,5,$Name,1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,$fee,1,1,'R');//end of line

$pdf->Cell(130 ,5,'CSCI 311',1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,'2,200',1,1,'R');//end of line

$pdf->Cell(130 ,5,'ACT 100',1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,'2,200',1,1,'R');//end of line

//summary
$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Subtotal',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'6,600',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Taxable',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'0',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Tax Rate',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'0%',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Total Due',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'6,660',1,1,'R');//end of line

$pdf->Output();
?>