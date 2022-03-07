<?php

require_once(__DIR__ . '/load.php');
$datos = get_data();
$gasolineras = $datos['ListaEESSPrecio'];
$fecha = parse_fecha($datos['Fecha']);

$errores = 0;
$arr_errores = array();

$logfile = __DIR__ . '/logs/ejecucion-' . date('d-m-y-h-i-s')  .'.log';

foreach ($gasolineras as $arr){

	// Añadir Municipio si no existe
	$municipio = new Municipio($arr['IDMunicipio'], $arr['IDProvincia'], $arr['IDCCAA'], $arr['Municipio']);
	if ( $municipio->save() === false ){
		$errores++;
		$arr_errores[] = $arr;
	}

	// Añadir localidad si no existe y recoger el ID
	$localidad = new Localidad();
	if ( ! $localidad_id = $localidad->getId($arr['Localidad'], $arr['IDMunicipio'])){
		$errores++;
		$arr_errores[] = $arr;
	}
	if ($localidad_id === 'no'){
		$localidad->set('', $arr['IDMunicipio'], $arr['IDProvincia'], $arr['IDCCAA'], $arr['Localidad']);
		if ( !$localidad_id = $localidad->save()){
			$errores++;
			$arr_errores[] = $arr;
		}

	}

	// Añadir gasolinera si no existe y/o actualizar si hay cambios

	$gasolinera = new Gasolinera(	$arr['IDEESS'],
					$localidad_id,
					$arr['IDMunicipio'],
					$arr['IDProvincia'],
					$arr['IDCCAA'],
					$arr['Horario'],
					$arr['C.P.'],
					$arr['Dirección'],
					$arr['Rótulo'],
					$arr['Tipo Venta'],
					$arr['Margen'],
					$arr['Remisión'],
					$arr['Latitud'],
					$arr['Longitud (WGS84)']
	);

	if ( $gasolinera->save() === false ){
		$errores++;
		$arr_errores[] = $arr;
	}


	$precio = new Precio(
		'',
		$arr['IDEESS'],
		$fecha,
		$arr['Precio Biodiesel'],
		$arr['Precio Bioetanol'],
		$arr['Precio Gas Natural Comprimido'],
		$arr['Precio Gas Natural Licuado'],
		$arr['Precio Gases licuados del petróleo'],
		$arr['Precio Gasoleo A'],
		$arr['Precio Gasoleo B'],
		$arr['Precio Gasoleo Premium'],
		$arr['Precio Gasolina 95 E10'],
		$arr['Precio Gasolina 95 E5'],
		$arr['Precio Gasolina 95 E5 Premium'],
		$arr['Precio Gasolina 98 E10'],
		$arr['Precio Gasolina 98 E5'],
		$arr['Precio Hidrogeno'],
		$arr['% BioEtanol'],
		$arr['% Éster metílico'],
	);
	if ( $precio->save() === false ){
		$errores++;
		$arr_errores[] = $arr;
	}
}


echo PHP_EOL . "En total ha habido $errores errores." . PHP_EOL;

print_r($arr_errores);
//print_r($datos);






