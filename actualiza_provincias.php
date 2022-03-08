<?php

require_once(__DIR__ . '/load.php');
$provincias = json_decode(file_get_contents('https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/Provincias/'), true);

$errores = 0;
$arr_errores = array();

$logfile = __DIR__ . '/logs/actualizacion_provincias-' . date('d-m-y-h-i-s')  .'.log';
foreach ($provincias as $provincia){
	$provincia['IDProvincia'] = isset($provincia['IDPovincia']) ? $provincia['IDPovincia'] : $provincia['IDProvincia'];
	$provincia = new Provincia($provincia['IDProvincia'], $provincia['IDCCAA'], $provincia['Provincia']);
		if ( $provincia->save() === false ){
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






