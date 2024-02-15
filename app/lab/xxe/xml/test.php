<?php
// $xmlfile = file_get_contents('php://input');
$xmlfile = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input'); // Considera la compatibilidad con ciertas configuraciones

$dom = new DOMDocument();

if ($xmlfile) {
    $dom->loadXML($xmlfile);
    echo $dom->textContent;
} else {
    echo "No se recibió XML válido.";
}
?>
