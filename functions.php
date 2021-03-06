<?php
/*
 * Función para recoger los datos desde el Endpoint
 * */
function get_data($date = 'hoy'){
	if ($date === 'hoy'){
		$datos = file_get_contents(ENDPOINT_URL_PRICES_TODAY);
	} else {
		$datos = file_get_contents(ENDPOINT_URL_PRICES_BY_DATE . $date);
	}

	return json_decode($datos, true);
}

/*
 * Función para loguear en el fichero de log
 * */
function cholog($tag, $str){
	global $logfile;

	$ahora = date('d-m-y h:i:s');
	$strtolog = $ahora . ' ' . '[' . $tag . '] ' . $str . PHP_EOL;
	echo $strtolog;
	file_put_contents($logfile, $strtolog, FILE_APPEND);
}

function to_decimal($num, $decimals = 3){
	if ($num === ''){
		for ($i=0;$i<$decimals; $i++){
			$num .= '0';
		}
		$num = '0.' . $num;


	}
	$num = str_replace(",", ".", $num);
	return number_format($num, $decimals, '.', '');
}

function parse_fecha($fecha) {
	$arr = explode(" ", $fecha);
	$fecha_sin_hora =  $arr[0];

	$arr_fecha_sin_hora = explode("/", $fecha_sin_hora);

	return $arr_fecha_sin_hora[2] . "-" . $arr_fecha_sin_hora[1] . "-" . $arr_fecha_sin_hora[0];
}
