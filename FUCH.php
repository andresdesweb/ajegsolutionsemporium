<?php

 	
//ini_set('display_errors', 1);
require('fpdf/fpdf.php');
//include "../workshop/servicios/administrativos/coreFiles/dbStuff/conectStrings.php";
class PDF extends FPDF
{
function TextWithDirection($x, $y, $txt, $direction='R')
{
    if ($direction=='R')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='L')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='U')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='D')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    else
        $s=sprintf('BT %.2F %.2F Td (%s) Tj ET', $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}
function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
{
    $font_angle+=90+$txt_angle;
    $txt_angle*=M_PI/180;
    $font_angle*=M_PI/180;

    $txt_dx=cos($txt_angle);
    $txt_dy=sin($txt_angle);
    $font_dx=cos($font_angle);
    $font_dy=sin($font_angle);

    $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}
function myCell($w, $h, $x, $t){
        $height = $h/4;
        $first = $height+2;
        $second = $height+$height+$height+3;
        $third = $height+$height+$height+$height+6;
        $len = strlen($t);
        if($len >= 80){
            $txt = str_split($t,80);
            $this->SetX($x);
            $this->Cell($w,$first,utf8_decode($txt[0]),'','','');
            $this->SetX($x);
            $this->Cell($w,$second,utf8_decode($txt[1]),'R','','');
            $this->SetX($x);
            $this->Cell($w,$third, utf8_decode($txt[2]),'R','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','',0,'',0);
        }else{
            $this->SetX($x);
            $this->Cell($w,$h,utf8_decode($t),'LBTR',0,'L',0);
        }
    }
function myCellind($w, $h, $x, $t, $accion){
        $height = $h/4;
        $first = $height+2  ;
        $second = $height+$height+$height+3;
        $third = $height+$height+$height+$height+6;
        $len = strlen($t);
		if($accion == 1){
			if($len >= 100){
				$txt = str_split($t,100);
				$this->SetX($x);
				$this->Cell($w,$first,utf8_decode($txt[0]),'T','','');
				$this->SetX($x);
				$this->Cell($w,$second,utf8_decode($txt[1]),'R','','');
				//$this->SetX($x);
				//$this->Cell($w,$third, utf8_decode($txt[2]),'R','','');
				$this->SetX($x);
				$this->Cell($w,$h,'','B',0,'',0);
			}else{
				$this->SetX($x);
				$this->Cell($w,$h,utf8_decode($t),'LBTR',0,'L',0);
			}
		}elseif($accion == 2){
			if($len >= 105){
				$txt = str_split($t,105);
				$this->SetX($x);
				$this->Cell($w,$first,utf8_decode($txt[0]),'T','','');
				$this->SetX($x);
				$this->Cell($w,$second,utf8_decode($txt[1]),'R','','');
				//$this->SetX($x);
				//$this->Cell($w,$third, utf8_decode($txt[2]),'R','','');
				$this->SetX($x);
				$this->Cell($w,$h,'','',0,'',0);
			}else{
				$this->SetX($x);
				$this->Cell($w,$h,utf8_decode($t),'LBTR',0,'L',0);
			}
		}elseif($accion == 3){
			if($len >= 109){
				$txt = str_split($t,109);
				$this->SetX($x);
				$this->Cell($w,$first,utf8_decode($txt[0]),'T','','');
				$this->SetX($x);
				$this->Cell($w,$second,utf8_decode($txt[1]),'R','','');
				//$this->SetX($x);
				//$this->Cell($w,$third, utf8_decode($txt[2]),'R','','');
				$this->SetX($x);
				$this->Cell($w,$h,'','',0,'',0);
			}else{
				$this->SetX($x);
				$this->Cell($w,$h,utf8_decode($t),'LBTR',0,'L',0);
			}
		}
    }
function encabezados($w, $h, $x, $t){
        $height = $h/4;
        $first = $height+2  ;
        $second = $height+$height+$height+5;
        $third = $height+$height+$height+$height+6;
        $len = strlen($t);
        if($len >= 20){
            $txt = str_split($t,33);
            $this->SetX($x);
            $this->Cell($w,$first,utf8_decode($txt[0]),'','','');
            $this->SetX($x);
            $this->Cell($w,$second,utf8_decode($txt[1]),'','','');
            $this->SetX($x);
            $this->Cell($w,$third, utf8_decode($txt[2]),'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }else{
            $this->SetX($x);
            $this->Cell($w,$h,utf8_decode($t),'LBTRB',0,'L',0);
        }
    }
function inicial($w, $h, $x, $t){
        $height = $h/3;
        $first = $height+2  ;
        $second = $height+$height+$height+3;
        $third = $height+$height+$height+$height+6;
        $len = strlen($t);
        if($len >= 126){
            $txt = str_split($t,123);
            $this->SetX($x);
            $this->Cell($w,$first,utf8_decode($txt[0]),'','','');
			$this->ln(3);
            $this->SetX($x);
            $this->Cell($w,$second,utf8_decode($txt[1]),'','','');
			$this->ln(3);
            $this->SetX($x);
            $this->Cell($w,$third, utf8_decode($txt[2]),'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','',0,'L',0);
        }else{
            $this->SetX($x);
            $this->Cell($w,$h,utf8_decode($t),'LBTRB',0,'L',0);
        }
    }
function Header()
{
    global $title;
    $this->Image('universidad-cuahtemoc.jpg',70,8,75, 'JPG');
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Calculamos ancho y posición del título.
    $w = $this->GetStringWidth('Evaluación docente 2018-3')+6;
    $this->SetX((210-$w)/2);
    // Colores de los bordes, fondo y texto
    //$this->SetDrawColor(0,80,180);
    $this->SetFillColor(230,230,0);
    //$this->SetTextColor(220,50,50);
    // Ancho del borde (1 mm)
    $this->SetLineWidth(1);
    // Título
    // Salto de línea
    $this->Ln(10);
}
function estilo($texto){
    $w = $this->GetStringWidth($texto)+6;
    $this->SetX((210-$w)/2);
    $this->SetFillColor(255,255,255); 
    $this->SetLineWidth(1); 
    $this->Cell($w,10,'',0,1,'C');
}
/*function tablita($texto1, $texto2){

    $w = $this->GetStringWidth($texto1)+6;
    $this->SetX((210-$w)/2);
    $z = $this->GetStringWidth($texto2)+6;
    $this->SetX((210-$z)/2);
    $this->Cell($w,6,$texto1,'{T,B}',0,'C');
    $this->Cell($z,6,$texto1,'{T,B}',0,'C');
}*/
function Footer()
{
	if($this->PageNo()==2){
    // Posición a 1,5 cm del final
    $this->SetY(-30);
    // Arial itálica 8
   // $this->SetFont('Arial','I',8);
    // Color del texto en gris
    //$this->SetTextColor(128);
    // Número de página
	$this->SetFont('Times','',10);
		 $this->Image('CarlosUCARED.jpg',90,245,30,20,'JPG');	
		$this->Cell(63.33,10,utf8_decode(''),0,0,'C');
		$this->Cell(63.33,10,utf8_decode('Mtro. Eduardo Contreras Barba'),'T',0,'C');
		$this->Cell(63.33,10,utf8_decode(''),0,1,'C');
		$this->Cell(63.33,0,utf8_decode(''),0,0,'C');
		$this->Cell(63.33,0,utf8_decode('Director académico'),0,0,'C');
		$this->Cell(63.33,0,utf8_decode(''),0,0,'C');
		 $this->SetY(-15);
		 $this->SetFont('Arial','I',8);
 		$this->SetTextColor(128);
		 $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
	}else{
		$this->SetY(-15);
		// Arial itálica 8
		$this->SetFont('Arial','I',8);
		// Color del texto en gris
		$this->SetTextColor(128);
		$this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
	}
    
}

}
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddFont('Helvetica','','helvetica.php');
$pdf->AddPage();
$title = utf8_decode('REPORTE EVALUACIÓN DOCENTE');
$pdf->SetTitle($title);
$pdf->SetFont('Helvetica','',10);
//$pdf->Cell(0,10,utf8_decode('Catedrático: Eduardo García'),0,1, 'C');

$pdf->estilo($nombreCatedratico);
$pdf->ln(3);
$w = 0;
$h = 10;
$x = $pdf->GetX();
$pdf->Cell(63.33, 17,'',0,0,1);
$pdf->Cell(63.33, 10,'Aguascalientes, Ags, 18 de Enero de 2018',0,0,1);
$pdf->Cell(63.33, 17,'',0,1,1);

$pdf->Cell(190, 10,utf8_decode('FORMATO ÚNICO DE CAMBIO DE HORARIO'),0,0,'C',1);
$pdf->ln();
$pdf->Cell(50, 17,'NOMBRE',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Cell(50, 17,'DEPARTAMENTO',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Cell(50, 17,'CARGO',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Cell(50, 17,'HORARIO REGULAR',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Cell(50, 17,'HORARIO SOLICITADO',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Cell(50, 17,'FIJO/TEMPORAL',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Cell(50, 17,'MOTIVO',1,0,'C',1);
$pdf->Cell(140, 17,'',1,1,0);
$pdf->Ln();

$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'',1,0,1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'',1,0,1);
$pdf->Cell(10, 17,'',0,1,0);

$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'VoBo Jefe inmediato',0,0,'C',1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'Firma y Nombre del  Solicitante',0,0,'C',1);
$pdf->Cell(10, 17,'',0,1,0);


$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'',1,0,1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'',1,0,1);
$pdf->Cell(10, 17,'',0,1,0);

$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,'M.D.A. JUAN CAMILO MESA JARAMILLO',0,0,'C',1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(10, 17,'',0,0,1);
$pdf->Cell(75, 17,utf8_decode('LIC. ROGELIO MARTÍNEZ ROMO'),0,0,'C',1);
$pdf->Cell(10, 17,'',0,1,0);

$pdf->Cell(10, 1,'',0,0,1);
$pdf->Cell(75, 1,'RECTOR',0,0,'C',1);
$pdf->Cell(10, 1,'',0,0,1);
$pdf->Cell(10, 1,'',0,0,1);
$pdf->Cell(75, 1,'DIRECTOR OPERATIVO NACIONAL',0,0,'C',1);
$pdf->Cell(10, 1,'',0,1,0);





//$pdf->AddPage();

$pdf->Output();

?>