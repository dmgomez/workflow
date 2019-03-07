<?php

/**
 * This is the model class for table "empleado".
 *
 * The followings are the available columns in table 'empleado':
 * @property integer $id_empleado
 * @property integer $id_departamento
 * @property integer $id_cargo
 * @property integer $superior_inmediato
 * @property integer $id_persona
 *
 * The followings are the available model relations:
 * @property EmpleadoRol[] $empleadoRols
 * @property InstanciaActividad[] $instanciaActividads
 * @property HistEstadoInstanciaActividad[] $histEstadoInstanciaActividads
 * @property Cargo $idCargo
 * @property Departamento $idDepartamento
 * @property Empleado $superiorInmediato
 * @property Empleado[] $empleados
 * @property Persona $idPersona
 */

class Empleado extends CActiveRecord
{
	const titulo = "Empleado";
    const tituloPlural = "Empleados";
    const sexo = "m";

	private $_nombrePersona;
	private $_apellidoPersona;
	private $_nombreEmpleado;
	private $_nacionalidadPersona;
	private $_cedulaPersona;
	private $_direccionPersona;
	private $_telefonoHab;
	private $_telefonoCel;
	private $_telefonoAux;
	private $_correoPersona;
	private $_nombreCargo;
	private $_nombreUsuario;
	private $_nombreRol;
	private $_username;
	private $_password;
	private $_idOrganizacion;
	public $_activoAccion;
	public $_empleadoAccion;


	public static function getTitulo($articulo = false, $plural = false)
    {
        $pri = "";
        $seg = self::titulo;
        
        if ($articulo == true)
        {
            if (self::sexo == "f")
                $pri = Constantes::articulof. " ";
            else if (self::sexo == "m")
                $pri = Constantes::articulom. " ";
        }
        if ($plural == true)
        {
            $seg = self::tituloPlural;
            if ($articulo == true)
            {
                if (self::sexo == "f")
                    $pri = Constantes::articulosf. " ";
                else if (self::sexo == "m")
                    $pri = Constantes::articulosm. " ";
            }
        }
        return $pri . $seg;
        
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'empleado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_departamento, id_cargo, id_persona, nombrePersona, apellidoPersona, nombreEmpleado, nacionalidadPersona, cedulaPersona, telefonoCel, username, password, idOrganizacion', 'required'),
			array('id_persona', 'unique', 'message' => 'El número de cédula que ingreso ya se encuentra registrado como empleado.'),
			array('id_departamento, id_cargo, superior_inmediato, id_persona, id_usuario, activo, _activoAccion, _empleadoAccion', 'numerical', 'integerOnly'=>true),
			array('cedulaPersona','validar_cedula','on'=>array('insert', 'update')),
			array('nombrePersona, apellidoPersona', 'length', 'max'=>50),
			array('nombrePersona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', 'message' => 'Nombre inválido. Sólo se permiten caracteres alfabéticos.'),
			array('apellidoPersona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', 'message' => 'Apellido inválido. Sólo se permiten caracteres alfabéticos.'),
			array('nacionalidadPersona', 'length', 'max'=>1),
			array('cedulaPersona, telefonoHab, telefonoCel, telefonoAux', 'length', 'max'=>15),
			array('cedulaPersona, telefonoHab, telefonoCel, telefonoAux', 'numerical', 'integerOnly'=>true),
			array('telefonoHab', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Teléfono Hab. debe ser de 11 caracteres numéricos.'),
			array('telefonoCel', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Teléfono Cel. debe ser de 11 caracteres numéricos.'),
			array('telefonoAux', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Teléfono Aux. debe ser de 11 caracteres numéricos.'),
			array('direccionPersona', 'length', 'max'=>500),
			array('direccionPersona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúÁÉÍÓÚ#º,.:-\s]+$/', 'message' => 'Dirección inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :'),
			array('correoPersona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9_.@-]+$/', 'message' => 'Correo inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @'),
			//array('username', 'length', 'min'=>3),
			//array('username', 'length', 'max'=>45),
			//array('password', 'length', 'max'=>20),
			//array('username', 'unique'),
			//array('username', 'match', 'pattern' => '/^[a-zA-Z0-9\_\-\.]{3,45}$/', 'message' => 'Username inválido. Sólo se permiten los siguientes caracteres especiales: _ . -. La longitud debe ser entre 3 y 45 caracteres.'),
			//array('password', 'match', 'pattern' => '/^[a-zA-Z0-9@#$%\_\-\.]{6,20}$/', 'message' => 'Password inválida. Sólo se permiten los siguientes caracteres especiales: @ # $ %. La longitud debe ser entre 2 y 20 caracteres.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_empleado, id_departamento, id_cargo, superior_inmediato, id_persona, nombrePersona, apellido_persona, cedulaPersona, activo, username, password', 'safe', 'on'=>'search'),
		);
	}

	public function validar_cedula($attribute)
	{
		if($this->cedulaPersona!="")
		{
			if($this->nacionalidadPersona == "V")
			{
				if( !preg_match('/^[0-9]{6,8}$/', $this->cedulaPersona))
					$this->addError($attribute,"Cédula inválida. Mínimo 6 y máximo 8 caracteres numéricos para cédulas venezolanas.");
			}			
			elseif($this->nacionalidadPersona == "E")
			{	
				if( !preg_match('/^[0-9]{6,15}$/', $this->cedulaPersona))
					$this->addError($attribute,"Cédula inválida. Mínimo 6 y máximo 15 caracteres numéricos para cédulas extranjeras.");
			}
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'empleadoRols' => array(self::HAS_MANY, 'EmpleadoRol', 'id_empleado'),
			'rol'=>array(self::MANY_MANY, 'Rol', 'empleado_rol(id_rol, id_empleado)'),
			'instanciaActividads' => array(self::HAS_MANY, 'InstanciaActividad', 'id_empleado'),
			'histEstadoInstanciaActividads' => array(self::HAS_MANY, 'HistEstadoInstanciaActividad', 'id_empleado'),
			'idCargo' => array(self::BELONGS_TO, 'Cargo', 'id_cargo'),
			'idDepartamento' => array(self::BELONGS_TO, 'Departamento', 'id_departamento'),
			'superiorInmediato' => array(self::BELONGS_TO, 'Empleado', 'superior_inmediato'),
			'empleados' => array(self::HAS_MANY, 'Empleado', 'superior_inmediato'),
			'idPersona' => array(self::BELONGS_TO, 'Persona', 'id_persona'),
			'idUsuario' => array(self::BELONGS_TO, 'Cruge_User', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_empleado' => 'Id Empleado',
			'nombrePersona' => 'Nombre',
			'apellidoPersona' => 'Apellido',
			'nacionalidadPersona' => 'Nacionalidad',
			'cedulaPersona' => 'Cédula',
			'direccionPersona' => 'Dirección',
			'telefonoHab' => 'Teléfono Habitación',
			'telefonoCel' => 'Teléfono Celular',
			'telefonoAux' => 'Teléfono Auxiliar',
			'correoPersona' => 'Correo',
			'id_departamento' => 'Departamento',
			'id_cargo' => 'Cargo',
			'superior_inmediato' => 'Superior Inmediato',
			'id_persona' => 'Id Persona',
			'id_usuario' => 'Usuario',
			'NombreUsuario' => 'Usuario',
			'username' => 'Nombre de Usuario',
			'password' => 'Clave de Acceso',
			'idOrganizacion' => 'Organización',
			'activo' => 'Activo',
			'_activoAccion' => 'Opción de Reasignacion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array("idPersona"=>array('alias' => 'persona'), "idDepartamento"=>array('alias' => 'departamento'), "idCargo"=>array('alias' => 'cargo'), "empleados"=>array('alias' => 'empleado'));

		$criteria->compare('id_empleado',$this->id_empleado);
		$criteria->compare('id_persona',$this->id_persona,true);
		$criteria->addSearchCondition('LOWER(persona.nombre_persona)',strtolower($this->nombrePersona),true);
		$criteria->addSearchCondition('LOWER(persona.apellido_persona)',strtolower($this->apellidoPersona),true);
		$criteria->compare('persona.nacionalidad_persona',$this->nacionalidadPersona,true);
		$criteria->compare('persona.cedula_persona',$this->cedulaPersona,true);
		$criteria->compare('persona.direccion_persona',$this->direccionPersona,true);
		$criteria->compare('persona.telefono_hab_persona',$this->telefonoHab,true);
		$criteria->compare('persona.telefono_cel_persona',$this->telefonoCel,true);
		$criteria->compare('persona.telefono_aux_persona',$this->telefonoAux,true);
		$criteria->addSearchCondition('LOWER(departamento.nombre_departamento)',strtolower($this->id_departamento),true);
		$criteria->addSearchCondition('LOWER(cargo.nombre_cargo)',strtolower($this->id_cargo));
		$criteria->addSearchCondition('LOWER(rol.nombre_rol)',strtolower($this->nombreRol),true);
		$criteria->addSearchCondition('persona.nombre_persona',$this->superior_inmediato);
		//$criteria->addSearchCondition('persona.nombre_persona',$this->superior_inmediato);

		$sort = new CSort();
		$sort->attributes = array(

		    'cedulaPersona'=>array(
		        'asc'=>'persona.cedula_persona',
		        'desc'=>'persona.cedula_persona desc',
		    ),
		    'nombrePersona'=>array(
		        'asc'=>'persona.nombre_persona',
		        'desc'=>'persona.nombre_persona desc',
		    ),
		    'apellidoPersona'=>array(
		        'asc'=>'persona.apellido_persona',
		        'desc'=>'persona.apellido_persona desc',
		    ),
		    'id_departamento'=>array(
		        'asc'=>'departamento.id_departamento',
		        'desc'=>'departamento.id_departamento desc',
		    ),
		    'id_cargo'=>array(
		        'asc'=>'cargo.id_cargo',
		        'desc'=>'cargo.id_cargo desc',
		    ),
		    'superior_inmediato'=>array(
		        'asc'=>'superior_inmediato',
		        'desc'=>'superior_inmediato desc',
		    ),
		  /*  'rol'=>array(
		        'asc'=>'rol.nombre_rol',
		        'desc'=>'rol.nombre_rol desc',
		    ),*/
			/*'superior_inmediato'=>array(
		        'asc'=>'persona.nombre_persona',
		        'desc'=>'persona.nombre_persona desc',
		    ),*/
		);

		$sort->defaultOrder = 'persona.nacionalidad_persona DESC, persona.cedula_persona ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
		
	public function getnombrePersona(){

	    if ($this->_nombrePersona === null && $this->idPersona !== null){

	        $this->_nombrePersona = $this->idPersona->nombre_persona;
	    }

	    return $this->_nombrePersona;
	}

	public function setnombrePersona($value){

		$this->_nombrePersona = $value;
	}

	public function getapellidoPersona(){

	    if ($this->_apellidoPersona === null && $this->idPersona !== null){

	        $this->_apellidoPersona = $this->idPersona->apellido_persona;
	    }

	    return $this->_apellidoPersona;
	}

	public function setapellidoPersona($value){

		$this->_apellidoPersona = $value;
	}

	public function getnombreEmpleado(){

	    if ($this->_nombreEmpleado === null && $this->idPersona !== null){

	        $this->_nombreEmpleado = $this->idPersona->nombre_persona. ' ' .$this->idPersona->apellido_persona;
	    }

	    return $this->_nombreEmpleado;
	}

	public function setnombreEmpleado($value){

		$this->_nombreEmpleado = $value;
	}

	public function getnacionalidadPersona(){

	    if ($this->_nacionalidadPersona === null && $this->idPersona !== null){

	        $this->_nacionalidadPersona = $this->idPersona->nacionalidad_persona;
	    }

	    return $this->_nacionalidadPersona;
	}

	public function setnacionalidadPersona($value){

		$this->_nacionalidadPersona = $value;
	}

	public function getcedulaPersona(){

	    if ($this->_cedulaPersona === null && $this->idPersona !== null){

	        $this->_cedulaPersona = $this->idPersona->cedula_persona;
	    }

	    return $this->_cedulaPersona;
	}

	public function setcedulaPersona($value){

		$this->_cedulaPersona = $value;
	}

	public function getdireccionPersona(){

	    if ($this->_direccionPersona === null && $this->idPersona !== null){

	        $this->_direccionPersona = $this->idPersona->direccion_persona;
	    }

	    return $this->_direccionPersona;
	}

	public function setdireccionPersona($value){

		$this->_direccionPersona = $value;
	}

	public function gettelefonoHab(){

	    if ($this->_telefonoHab === null && $this->idPersona !== null){

	        $this->_telefonoHab = $this->idPersona->telefono_hab_persona;
	    }

	    return $this->_telefonoHab;
	}

	public function settelefonoHab($value){

		$this->_telefonoHab = $value;
	}

	public function gettelefonoCel(){

	    if ($this->_telefonoCel === null && $this->idPersona !== null){

	        $this->_telefonoCel = $this->idPersona->telefono_cel_persona;
	    }

	    return $this->_telefonoCel;
	}

	public function settelefonoCel($value){

		$this->_telefonoCel = $value;
	}

	public function gettelefonoAux(){

	    if ($this->_telefonoAux === null && $this->idPersona !== null){

	        $this->_telefonoAux = $this->idPersona->telefono_aux_persona;
	    }

	    return $this->_telefonoAux;
	}

	public function settelefonoAux($value){

		$this->_telefonoAux = $value;
	}

	public function getcorreoPersona(){

	    if ($this->_correoPersona === null && $this->idPersona !== null){

	        $this->_correoPersona = $this->idPersona->correo_persona;
	    }

	    return $this->_correoPersona;
	}

	public function setcorreoPersona($value){

		$this->_correoPersona = $value;
	}

	public function getusername(){

	    if ($this->_username === null && $this->idUsuario !== null){

	        $this->_username = $this->idUsuario->username;
	    }

	    return $this->_username;
	}

	public function setusername($value){

		$this->_username = $value;
	}

	public function getpassword(){

	    if ($this->_password === null && $this->idUsuario !== null){

	        $this->_password = $this->idUsuario->password;
	    }

	    return $this->_password;
	}

	public function setpassword($value){

		$this->_password = $value;
	}




	public function getCedulaCompleta()
	{
		return $this->nacionalidadPersona . "-". $this->cedulaPersona;
	}

	public function getNombreCompleto()
	{
		return $this->nombrePersona . " ". $this->apellidoPersona;
	}

	public function getNombreSuperior()
	{
		$idSupervisor=Empleado::model()->findByAttributes(array('id_empleado' => $this->superior_inmediato));
		if (is_object($idSupervisor)) 
		{
			$nombreSupervisor=Persona::model()->findByAttributes(array('id_persona' => $idSupervisor->id_persona));
			return $nombreSupervisor->nombre_persona.' '.$nombreSupervisor->apellido_persona;
		}	
	}

	public function getNombreUsuario()
	{
		if ($this->_nombreUsuario === null && $this->id_usuario !== null)
		{
			$user="SELECT username from cruge_user  where iduser = ".$this->id_usuario;
			$username = Yii::app()->db->createCommand($user)->queryRow();

			if ($username)
			{
				$this->_nombreUsuario=$username['username'];
				
			}
		}

		return $this->_nombreUsuario;
	}

	public function nombreSuperiorGrid()
	{
		$idSupervisor=Empleado::model()->findByAttributes(array('id_empleado' => $this->superior_inmediato));
		if (is_object($idSupervisor)) 
		{
			$nombreSupervisor=Persona::model()->findByAttributes(array('id_persona' => $idSupervisor->id_persona));
			return $nombreSupervisor->nombre_persona.' '.$nombreSupervisor->apellido_persona;
		}
	}

	public function getnombreRol(){

	    if ($this->_nombreRol === null)
		{
			$this->_nombreRol = "";	
		    foreach ($this->rol as $value) 
			{
				$this->_nombreRol .= $value->nombre_rol.', ';

			}
			$this->_nombreRol = substr($this->_nombreRol, 0, -2);
		}

		

	    return $this->_nombreRol;
	}

	public function getidOrganizacion(){

	    if ($this->_idOrganizacion === null && $this->idDepartamento !== null){

	        $this->_idOrganizacion = $this->idDepartamento->id_organizacion;
	    }

	    return $this->_idOrganizacion;
	}

	public function setidOrganizacion($value){

	   $this->_idOrganizacion = $value;
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empleado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
