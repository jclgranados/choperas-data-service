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
			// TODO: loguear este error
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			// TODO: loguear este error para debug
			return false;
		}

		return $result;
	}
}
