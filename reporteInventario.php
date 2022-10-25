<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit;
    }
    include "conexion.php";
    include "fpdf/fpdf.php";

	class miPDF extends FPDF {
		function Header() {
			$this->SetFont('Arial','B',12);
			$this->Ln(1);
		}

		function Footer() {
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
		}

		function ChapterTitle($num, $label) {
			$this->SetFont('Arial','',12);
			$this->SetFillColor(255,255,255);
			$this->SetDrawColor(192,192,192);
			$this->Cell(30,7,$num,1,0,'L',0);
			$this->Cell(160,7,$label,1,1,'L',0);
			$this->Ln(0);
		}
		
		function ChapterTitle2($num, $label) {
			$this->SetFont('Arial','',12);
			$this->SetFillColor(249,249,249);
			$this->Cell(0,6,"$num $label",1,1,'L',true);
			$this->Ln(0);
		}
		
		function ChapterTitle3($num1, $label1, $num2, $label2) {
			$this->SetFont('Arial','',12);
			$this->SetFillColor(255,255,255);
			$this->SetDrawColor(192,192,192);
			$this->Cell(30,7,$num1,1,0,'L',0);
			$this->Cell(65,7,$label1,1,0,'L',0);
			$this->Cell(30,7,$num2,1,0,'L',0);
			$this->SetTextColor(255, 0 , 0);
			$this->SetFont('Arial','B',14);
			$this->Cell(65,7,$label2,1,1,'C',0);
			$this->SetTextColor(0, 0 , 0);
			$this->SetFont('Arial','',14);
			$this->Ln(0);
		}
    }

    $pdf = new miPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',20);
    $pdf->SetTextColor(32);
    $pdf->Cell(0,10,"Cafetería Super Nova",0,1,'L');
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,8,"Reporte de Inventario Productos",0,1,'L');
    $pdf->Cell(0,6,"",0,1,'L');

    // Imagen
    $pdf->Image("imgs/SN_COFFE.jpg", 150, 12, 25, 20);

    $pdf->SetFont('Arial', '', 14);
    $res = mysqli_query($conexion, "SELECT idProducto,producto, codigo, cantidad,precio, descripcion, PRD.idTipoProducto, 
                                        TP_PRD.tipoProducto FROM productos PRD 
                                    INNER JOIN tipo_producto TP_PRD ON TP_PRD.idTipoProducto = PRD.idTipoProducto
                                    ORDER BY idProducto;") or die(mysqli_error($conexion));
    /*SELECT TP_PRD.tipoProducto, SUM(cantidad)  FROM productos PRD INNER JOIN tipo_producto TP_PRD
                                                            ON TP_PRD.idTipoProducto = PRD.idTipoProducto
                                                       GROUP BY PRD.idTipoProducto*/
    while ($reg = mysqli_fetch_array($res)) {
        $idProducto   = $reg[0];
        $producto     = $reg[1];
        $codigo       = $reg[2];
        $cantidad     = $reg[3];
        $precio       = $reg[4];
        $descripcion  = $reg[5];
        $idTipo       = $reg[6];
        $tipo         = $reg[7];

        $pdf->Cell(10, 7, $idProducto, 1, 0, 'L');
        $pdf->Cell(20, 7, " ".$producto, 0, 1, 'L');
        $pdf->Cell(20, 8, "Código: ".$codigo, 0, 1, 'L');
        $pdf->Cell(20, 8, "Cantidad: ".$cantidad, 0, 1, 'L');
        $pdf->Cell(20, 8, "Precio: ".$precio, 0, 1, 'L');
        $pdf->Cell(20, 8, "Descripción: ".$descripcion, 0, 1, 'L');
        $pdf->Cell(20, 8, "ID Tipo: ".$idTipo, 0, 0, 'L');
        $pdf->Cell(20, 8, "   ".$tipo, 0, 1, 'L');
    }
    $correoUser = $_SESSION['email'];
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 6, "Preparado por Admin $correoUser", 0, 1, 'C');

    $filename  = "inventario.pdf";
    $pdf->Output($filename,'I'); //para mandarlo al navegador

?>