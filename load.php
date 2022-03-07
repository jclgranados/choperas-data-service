<?php
/*
 * Todo lo necesario para cargar el script
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

$files_required = array(
	'config.php',
	'functions.php',
	'includes/Ccaa.php',
	'includes/Gasolinera.php',
	'includes/Localidad.php',
	'includes/Municipio.php',
	'includes/Provincia.php',
	'includes/Precio.php'
);

foreach ($files_required as $file_required) {
	if (file_exists(ABSPATH . $file_required)){
		require_once( ABSPATH . $file_required );
	}
}
