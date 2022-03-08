<?php

// Url del endpoint de donde obtenemos datos
define('ENDPOINT_URL_PRICES_TODAY', 'https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/');
define('ENDPOINT_URL_PRICES_BY_DATE', 'https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestresHist/');

// Datos de acceso a la b ase de datos
define('DB_HOST', 'localhost');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASSWORD', '');

$logfile = __DIR__ . '/logs/log_choperas.log';
