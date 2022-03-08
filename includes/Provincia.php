<?php

class Provincia {
	private $id;
	private $id_ccaa;
	private $nombre;

	public function __construct($id = null, $id_ccaa, $nombre = null) 
	{
		$this->set($id, $id_ccaa, $nombre);
	}

	public function set($id, $id_ccaa, $nombre) 
	{
		$this->id	= $id;
		$this->id_ccaa  = $id_ccaa;
		$this->nombre 	= $nombre;
	}

	public function save()
	{
		$sql = sprintf("INSERT IGNORE INTO provincias VAlUES ('%s', '%s', '%s')", $this->id, $this->id_ccaa, addslashes($this->nombre));
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Provincia - función save - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Provincia - función save - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}

		cholog('NUEVO', "Añadido nueva provincia id: $this->id id_ccaa: $this->id_ccaa  nombre: " . addslashes($this->nombre));

		return $result;
	}
}
