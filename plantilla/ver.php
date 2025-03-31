<?php
include_once 'parse.php';
// Simulación de HTML para pruebas
$html = file_get_contents('properties.html');
$properties = parseProperties($html);
print_r($properties);
