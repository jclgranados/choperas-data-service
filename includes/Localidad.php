<?php

class Localidad {
	private $id;
	private $id_municipio;
	private $id_provincia;
	private $id_ccaa;
	private $nombre;

	public function __construct( 
		$id = null, 
		$id_municipio = null,
		$id_provincia = null,
		$id_ccaa = null,
		$nombre = null
	){
		$this->set($id, $id_municipio, $id_provincia, $id_ccaa, $nombre);
	}

	public function set($id, $id_municipio, $id_provincia, $id_ccaa, $nombre)
	{
		$this->id		= $id;
		$this->id_municipio	= $id_municipio;
		$this->id_provincia	= $id_provincia;
		$this->id_ccaa  	= $id_ccaa;
		$this->nombre 		= $nombre;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId($nombre, $id_municipio)
	{
		$nombre = addslashes($nombre);
		$sql = sprintf("SELECT id FROM localidades WHERE nombre = '%s' AND id_municipio = '%s' LIMIT 1", $nombre, $id_municipio);
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Localidad - función getId - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');
		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Localidad - función getId - error en el select: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}

		$resultado = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$resultado[] = $row;
		}

		if (!isset($resultado[0])){
			return 'no';
		} 

		return $resultado[0]['id'];
	}

	public function save(){
		$sql = sprintf(
			"INSERT IGNORE INTO localidades (id_municipio, id_provincia, id_ccaa, nombre) VAlUES ( '%s', '%s', '%s', '%s' )",
			$this->id_municipio,
			$this->id_provincia,
			$this->id_ccaa,
			addslashes($this->nombre)
		);

		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Localidad - función save - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Localidad - función save - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}

		$id =  mysqli_insert_id($con);
		$this->id = $id;
		cholog('NUEVO', "Añadido nueva localidad id: $id  id_municipio: $this->id_municipio id_provincia: $this->id_provincia id_ccaa: $this->id_ccaa  nombre: " . addslashes($this->nombre));

		return $id;
	}
}
