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
		$this->nombre 	= $nombre;
	}

	public function save()
	{
		$sql = sprintf("INSERT IGNORE INTO ccaas VAlUES ('%s', '%s')", $this->id, addslashes($this->nombre));
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
