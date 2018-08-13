<?php

include("Smalot/PdfParser/PDFObject.php");
require("Smalot/PdfParser/Parser.php");



// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('86e7c27c1a9487d6b5e580047b40e35230628a59799c.pdf');
 
$text = $pdf->getText();
echo $text;




?>