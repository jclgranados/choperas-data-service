<?php

class Precio {

	private $id;
	private $id_gasolinera;
	private $fecha;
	private $biodiesel;
	private $bioetanol;
	private $gas_natural_comprimido;
	private $gas_natural_licuado;
	private $gases_licuados_del_petroleo;
	private $gasoleo_a;
	private $gasoleo_b;
	private $gasoleo_premium;
	private $gasolina_95_e10;
	private $gasolina_95_e5;
	private $gasolina_95_e5_premium;
	private $gasolina_98_e10;
	private $gasolina_98_e5;
	private $hidrogeno;
	private $porcentaje_bioetanol;
	private $porcentaje_ester_metilico;
	private $entrada_antigua = null;

	public function __construct(
			$id 				= null,
			$id_gasolinera 			= null,
			$fecha 				= null,
			$biodiesel 			= null,
			$bioetanol 			= null,
			$gas_natural_comprimido 	= null,
			$gas_natural_licuado 		= null,
			$gases_licuados_del_petroleo 	= null,
			$gasoleo_a 			= null,
			$gasoleo_b 			= null,
			$gasoleo_premium 		= null,
			$gasolina_95_e10 		= null,
			$gasolina_95_e5 		= null,
			$gasolina_95_e5_premium 	= null,
			$gasolina_98_e10 		= null,
			$gasolina_98_e5 		= null,
			$hidrogeno 			= null,
			$porcentaje_bioetanol 		= null,
			$porcentaje_ester_metilico 	= null
	){
		$this->set(
			$id,
			$id_gasolinera, 
			$fecha, 
			$biodiesel, 
			$bioetanol, 
			$gas_natural_comprimido, 
			$gas_natural_licuado, 
			$gases_licuados_del_petroleo, 
			$gasoleo_a, 
			$gasoleo_b, 
			$gasoleo_premium, 
			$gasolina_95_e10, 
			$gasolina_95_e5, 
			$gasolina_95_e5_premium, 
			$gasolina_98_e10, 
			$gasolina_98_e5, 
			$hidrogeno, 
			$porcentaje_bioetanol, 
			$porcentaje_ester_metilico
		);
	}

	public function set(
		$id, 
		$id_gasolinera, 
		$fecha, 
		$biodiesel, 
		$bioetanol, 
		$gas_natural_comprimido, 
		$gas_natural_licuado, 
		$gases_licuados_del_petroleo, 
		$gasoleo_a, 
		$gasoleo_b, 
		$gasoleo_premium, 
		$gasolina_95_e10, 
		$gasolina_95_e5, 
		$gasolina_95_e5_premium, 
		$gasolina_98_e10, 
		$gasolina_98_e5, 
		$hidrogeno, 
		$porcentaje_bioetanol, 
		$porcentaje_ester_metilico
	){
		$this->id				= $id;
		$this->id_gasolinera 			= $id_gasolinera;
		$this->fecha				= $fecha;
		$this->biodiesel			= to_decimal($biodiesel);
		$this->bioetanol			= to_decimal($bioetanol);
		$this->gas_natural_comprimido		= to_decimal($gas_natural_comprimido);
		$this->gas_natural_licuado		= to_decimal($gas_natural_licuado);
		$this->gases_licuados_del_petroleo	= to_decimal($gases_licuados_del_petroleo);
		$this->gasoleo_a			= to_decimal($gasoleo_a);
		$this->gasoleo_b			= to_decimal($gasoleo_b);
		$this->gasoleo_premium			= to_decimal($gasoleo_premium);
		$this->gasolina_95_e10			= to_decimal($gasolina_95_e10);
		$this->gasolina_95_e5			= to_decimal($gasolina_95_e5);
		$this->gasolina_95_e5_premium		= to_decimal($gasolina_95_e5_premium);
		$this->gasolina_98_e10			= to_decimal($gasolina_98_e10);
		$this->gasolina_98_e5			= to_decimal($gasolina_98_e5);
		$this->hidrogeno			= to_decimal($hidrogeno);
		$this->porcentaje_bioetanol		= to_decimal($porcentaje_bioetanol, 1);
		$this->porcentaje_ester_metilico	= to_decimal($porcentaje_ester_metilico, 1);
	}

	public function getId()
	{
		return $this->id;
	}

	public function existsInDb()
	{
		$sql = sprintf("SELECT * FROM precios where id_gasolinera = '%s' AND fecha = '%s'", $this->id_gasolinera, $this->fecha);
		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Precio - función existsInDb - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');
		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Precio - función existsInDb - error en el select: ' . $sql . ' error_msyql: ' . mysqli_error($con));		
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

	public function save(){
		if ($this->existsInDb()){
			return true;
		}
		$sql = sprintf("INSERT IGNORE INTO precios (
			id_gasolinera, 
			fecha, 
			biodiesel, 
			bioetanol, 
			gas_natural_comprimido, 
			gas_natural_licuado, 
			gases_licuados_del_petroleo, 
			gasoleo_a, 
			gasoleo_b, 
			gasoleo_premium, 
			gasolina_95_e10, 
			gasolina_95_e5, 
			gasolina_95_e5_premium, 
			gasolina_98_e10, 
			gasolina_98_e5, 
			hidrogeno, 
			porcentaje_bioetanol, 
			porcentaje_ester_metilico
		) VAlUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
		$this->id_gasolinera,
		$this->fecha,
		$this->biodiesel,
		$this->bioetanol,
		$this->gas_natural_comprimido,
		$this->gas_natural_licuado,
		$this->gases_licuados_del_petroleo,
		$this->gasoleo_a,
		$this->gasoleo_b,
		$this->gasoleo_premium,
		$this->gasolina_95_e10,
		$this->gasolina_95_e5,
		$this->gasolina_95_e5_premium,
		$this->gasolina_98_e10,
		$this->gasolina_98_e5,
		$this->hidrogeno,
		$this->porcentaje_bioetanol,
		$this->porcentaje_ester_metilico,
	);

		if ( ! $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)){
			cholog('ERROR', 'Clase Precios - función save - No se ha podido realizar la conexión a la base de datos');
			return false;
		}

		mysqli_set_charset( $con, 'utf8');

		if ( ! $result = mysqli_query($con, $sql)){
			cholog('ERROR', 'Clase Precios - función save - error en el insert: ' . $sql . ' error_msyql: ' . mysqli_error($con));
			return false;
		}
		$id = mysqli_insert_id($con);

		cholog('NUEVO', "Añadido nuevo precio para EESS: $this->id_gasolinera");

		return $result;
	}
}
