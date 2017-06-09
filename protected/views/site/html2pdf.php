<?php
    ob_start();
//    print_r($model);die;
//    echo $this->renderPartial('htmlpage', array('model' => $model)); 
    echo $this->renderPartial('htmlpage', array(
            'allResult' => $allResult,
            'allExp' => $allExp,
            'allTraining' => $allTraining,
            'allStaffDetails' => $allStaffDetails,
        ));
    $content = ob_get_clean();

     Yii::import('application.extensions.tcpdf.html2pdf.HTML2PDF');

    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content,false);
        $html2pdf->Output("invoice.pdf");
        
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>