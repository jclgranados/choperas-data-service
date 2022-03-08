<?php

class Ccaa {
	private $id;
	private $nombre;

	public function __construct($id = null, $nombre = null) 
	{
		$this->setCcaa($id, $nombre);
	}

	public function setCcaa($id, $nombre) 
	{
		$this->id	= $id;
		$this->nombre 	= strtoupper($nombre);
	}

	public function save()
	{
		$sql = sprintf("INSERT IGNORE INTO ccaas VAlUES ('%s', '%s')", $this->id, addslashes($this->nombre));
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Ccaa - función save - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Ccaa - función save - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}

		cholog('NUEVO', "Añadida nueva ccaa id: $this->id  nombre: " . addslashes($this->nombre));

		return $result;
	}
}
