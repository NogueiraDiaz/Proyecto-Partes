<?php 
require  "lib/dompdf/autoload.inc.php";

use Dompdf\Dompdf;


        
        $dompdf= new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper("A4");
        $dompdf->render();

        $dompdf->stream("Grupo" . $grupo["grupo_alumno"]);
        unset($dompdf);
