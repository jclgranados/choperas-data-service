<?php

require_once(__DIR__ . '/load.php');
$ccaas = json_decode(file_get_contents('https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/ComunidadesAutonomas/'), true);

$errores = 0;
$arr_errores = array();

$logfile = __DIR__ . '/logs/actualizacion_ccaas-' . date('d-m-y-h-i-s')  .'.log';

foreach ($ccaas as $ccaa){
	$ccaa = new Ccaa($ccaa['IDCCAA'], $ccaa['CCAA']);
		if ( $ccaa->save() === false ){
			$errores++;
			$arr_errores[] = $arr;
		}
}


if (count($arr_errores) !== 0){
	echo PHP_EOL . "En total ha habido $errores errores." . PHP_EOL;
	print_r($arr_errores);
	die();
}

print_r( PHP_EOL . "[OK] - Ejecutado sin errores" . PHP_EOL);






