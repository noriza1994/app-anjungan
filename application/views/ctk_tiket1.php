<?php

// Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

      // Page footer
      public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-31);
        // Set font
        $this->SetFont('times', 'I', 7);
        // Page number
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        $this->Cell(0, 10, 'Antrian RSIA Aceh : '.date('d/m/Y').'-'.$date->format('H:i:s').'', 0, false, 'C', 0, '', 0, false, 'T', 'M');
      }
    }

    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // ---------------------------------------------------------

    // add a page
    //$pdf->AddPage('21.59', '35.56');
    $style = array(
        'border' => false,
        'padding' => 0,
        'fgcolor' => array(100,10,5),
        'bgcolor' => false
    );

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(true, 0);

    $resolution= array(67, 60);
    $pdf->AddPage('P', $resolution);

    $pdf->Text(4, 3, '');
    $pdf->MultiCell(0, 2, '', 0, 'C', 0, 1, '', '', true, 0);

    $js = <<<EOD
        window.print();
        document.location.href = 'http://localhost/anjungan/';
    EOD;

    $pdf->Ln(1); 
    $pdf->Cell(0, 0, 'Rawat Jalan', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->Ln(5); 
    $pdf->Cell(0, 0, ''.date('d-m-Y').'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->Ln(5);
    $pdf->Cell(0, 0, 'Nomor Antrian', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->SetFont ('times', 'B', 32 , '', 'default', true );
    $pdf->Ln(10);
    $pdf->Cell(0, 0, ''.$tiket['numberprefix'].' '.$tiket['number'].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $pdf->Ln(10);
    $pdf->SetFont ('times', '', 14 , '', 'default', true );
    $pdf->Cell(0, 0, 'RSIA ACEH', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // force print dialog
    $js .= 'print(true);';
    $pdf->IncludeJS("autoprint=app.setTimeOut(\&quot;this.print()\&quot;,1);");


    // set javascript
    //$pdf->IncludeJS($js);
    $pdf->Output('Antrian.pdf', 'I');

