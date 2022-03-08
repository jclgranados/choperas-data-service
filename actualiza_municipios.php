<?php

require_once(__DIR__ . '/load.php');
$municipios = json_decode(file_get_contents('https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/Municipios/'), true);

$errores = 0;
$arr_errores = array();

$logfile = __DIR__ . '/logs/actualizacion_municipios-' . date('d-m-y-h-i-s')  .'.log';

foreach ($municipios as $municipio){
	$municipio = new Municipio($municipio['IDMunicipio'], $municipio['IDProvincia'], $municipio['IDCCAA'], $municipio['Municipio']);
		if ( $municipio->save() === false ){
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






