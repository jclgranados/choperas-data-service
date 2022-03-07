<?php

class Municipio {
	private $id;
	private $id_provincia;
	private $id_ccaa;
	private $nombre;

	public function __construct(
		$id 		= null,
		$id_provincia 	= null,
		$id_ccaa 	= null,
		$nombre 	= null
	){
		$this->set($id, $id_provincia, $id_ccaa, $nombre);
	}

	public function set($id, $id_provincia, $id_ccaa, $nombre)
	{
		$this->id		= $id;
		$this->id_provincia	= $id_provincia;
		$this->id_ccaa  	= $id_ccaa;
		$this->nombre 		= $nombre;
	}

	public function existsInDb()
	{
		$sql = sprintf("SELECT id from municipios WHERE id = '%s'", $this->id);
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Municipio - función existsInDb - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Municipio - función existsInDb - error en el select: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}
		$resultado = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$resultado[] = $row;
		}

		return isset($resultado[0]);
	}

	public function save()
	{
		// Si existe ya en base de datos, salgo
		if ($this->existsInDb()){
			return true;
		}

		$sql = sprintf("INSERT IGNORE INTO municipios VAlUES ('%s', '%s', '%s', '%s')", $this->id, $this->id_provincia, $this->id_ccaa, addslashes($this->nombre));
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Municipio - función save - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Municipio - función save - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}
		
		cholog('NUEVO', "Añadido nuevo municipio id: $this->id id_provincia: $this->id_provincia id_ccaa: $this->id_ccaa  nombre: " . addslashes($this->nombre));

		return $result;
	}
}
