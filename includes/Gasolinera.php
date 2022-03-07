<?php

class Gasolinera {

	private $id;
	private $id_localidad;
	private $id_municipio;
	private $id_provincia;
	private $id_ccaa;
	private $horario;
	private $cp;
	private $direccion;
	private $rotulo;
	private $tipo_venta;
	private $margen;
	private $remision;
	private $latitud;
	private $longitud;
	private $entrada_antigua = null;

	public function __construct(
		$id 		= null, 
		$id_localidad 	= null, 
		$id_municipio 	= null, 
		$id_provincia 	= null, 
		$id_ccaa 	= null, 
		$horario	= null, 
		$cp 		= null, 
		$direccion 	= null, 
		$rotulo 	= null, 
		$tipo_venta 	= null, 
		$margen 	= null, 
		$remision 	= null, 
		$latitud 	= null, 
		$longitud 	= null
	){
		$this->set(
			$id, 
			$id_localidad, 
			$id_municipio, 
			$id_provincia, 
			$id_ccaa,
			$horario,
			$cp,
			$direccion,
			$rotulo,
			$tipo_venta,
			$margen,
			$remision,
			$latitud,
			$longitud
		);
	}

	public function set(
		$id,
		$id_localidad,
		$id_municipio,
		$id_provincia,
		$id_ccaa,
		$horario,
		$cp,
		$direccion,
		$rotulo,
		$tipo_venta,
		$margen,
		$remision,
		$latitud,
		$longitud
	){
		$this->id 		= $id;
		$this->id_localidad	= $id_localidad;
		$this->id_municipio 	= $id_municipio;
		$this->id_provincia 	= $id_provincia;
		$this->id_ccaa 		= $id_ccaa;
		$this->horario 		= $horario;
		$this->cp 		= $cp;
		$this->direccion 	= $direccion;
		$this->rotulo 		= $rotulo;
		$this->tipo_venta 	= $tipo_venta;
		$this->margen 		= $margen;
		$this->remision 	= $remision;
		$this->latitud 		= $latitud;
		$this->longitud 	= $longitud;
	}

	public function getId()
	{
		return $this->id;
	}

	public function existsInDb()
	{
		$sql = sprintf("SELECT * FROM gasolineras where id = '%s'", $this->id);
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Gasolinera - función existsInDb - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');
		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Gasolinera - función existsInDb - error en el select: ' . $sql . ' error_msyql: ' . mysqli_error($con));		
			return false;
		}

		$resultado = array();

		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){	
			$resultado[] = $row;
		}

		if (isset($resultado[0])){
			$this->entrada_antigua = $resultado[0];
		}
	
		return isset($resultado[0]);	
	}

	public function update()
	{
		if ( ! is_array($this->entrada_antigua) ){
			return false;
		}

		$datos_antiguos = $this->entrada_antigua;
		$update = 'no';
		$cambios = array();
		foreach ($datos_antiguos as $clave => $valor){
			if ($valor != $this->$clave){
				$update = 'yes';
				$cambios[] = $clave;
			}
		}

		if ($update === 'no'){
			return true;
		}
		
		$str_update = '';
		$str_log = '';
		foreach ($cambios as $cambio) {
			$str_update .= $str_update !== '' ? ', ' : ' ';
			$str_log .= $str_log !== '' ? ', ' : ' ';
			$str_update .= $cambio . " = '" . addslashes($this->$cambio) ."'";
			$str_log .= $cambio . ' ' . $datos_antiguos[$cambio] . ' por ' . $this->$cambio;
		}


		$sql = sprintf("UPDATE gasolineras SET %s WHERE id = '%s'", $str_update, $this->id);
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Gasolinera - función update - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');
		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Gasolinera - función update - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}
		$d = $datos_antiguos;
		cholog('ACTUALIZACION', "Actualizada gasolinera id: $this->id , " . $str_log);

		return $result;
	}

	public function save()
	{
		if ($this->existsInDb()){
			return $this->update();
		}
		$sql = sprintf("INSERT IGNORE INTO gasolineras VAlUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
					$this->id,
					$this->id_localidad,
					$this->id_municipio,
					$this->id_provincia,
					$this->id_ccaa,
					$this->horario,
					$this->cp,
					addslashes($this->direccion),
					addslashes($this->rotulo),
					$this->tipo_venta,
					$this->margen,
					$this->remision,
					$this->latitud,
					$this->longitud
				);

		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Gasolinera - función save - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Gasolinera - función save - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}

		cholog('NUEVO', "Añadida nueva gasolinera id: $this->id id_localidad: $this->id_localidad, id_municipio: $this->id_municipio  id_provincia: $this->id_provincia id_ccaa: $this->id_ccaa  horario: ".addslashes($this->horario)." cp; $this->cp direccion: ".addslashes($this->direccion)." rotulo: ".addslashes($this->rotulo)." tipo_venta: $this->tipo_venta margen: $this->margen remision: $this->remision latitud: $this->latitud longitud: $this->longitud ");

		return $result;
	}
}
