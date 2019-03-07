<?php

/**
 * This is the model class for table "empresa".
 *
 * The followings are the available columns in table 'empresa':
 * @property integer $id_empresa
 * @property integer $id_persona_representante
 * @property string $rif_empresa
 * @property string $razon_social_empresa
 * @property string $nombre_comercial_empresa
 * @property string $direccion_empresa
 * @property string $telefono_hab_persona
 * @property string $telefono_aux_empresa
 * @property string $correo_empresa
 *
 * The followings are the available model relations:
 * @property InstanciaProceso[] $instanciaProcesos
 * @property Persona $idPersonaRepresentante
 * @property UsuarioEmpresa[] $usuarioEmpresas
 */
class Empresa extends CActiveRecord
{
	const titulo = "Empresa";
    const tituloPlural = "Empresas";
    const sexo = "f";
	
	private $_nombrePersona;
	private $_apellidoPersona;
	private $_nacionalidadPersona;
	private $_cedulaPersona;
	private $_direccionPersona;
	private $_telefonoHab;
	private $_telefonoCel;
	private $_telefonoAux;
	private $_correoPersona;
	private $_nombreCompletoRepresentante;

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
		return 'empresa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rif_empresa, razon_social_empresa, nombre_comercial_empresa, prefijo_rif, telefono_hab_persona, correo_empresa, cedulaPersona, nombrePersona, apellidoPersona, telefonoCel', 'required'),
			array('id_persona_representante, rif_empresa, cedulaPersona, telefonoHab, telefonoCel, telefonoAux', 'numerical', 'integerOnly'=>true),
			array('rif_empresa', 'unique', 'message' => 'El número de rif que ingreso ya se encuentra registrado.'),
			array('rif_empresa', 'length', 'max'=>9),
			array('nombrePersona, apellidoPersona, correoPersona', 'length', 'max'=>50),
			array('razon_social_empresa, nombre_comercial_empresa', 'length', 'max'=>200),
			//array('razon_social_empresa', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúÁÉÍÓÚ\/´&,.:-\s]+$/', 'message' => 'Razón Social inválida. Sólo se permiten los siguientes caracteres espciales: ´ / & , . - :.'),
			array('direccion_empresa', 'length', 'max'=>500),
			array('telefono_hab_persona, telefono_aux_empresa', 'length', 'max'=>15),
			array('correo_empresa', 'length', 'max'=>100),
			array('nacionalidadPersona', 'length', 'max'=>1),
			array('cedulaPersona, telefonoHab, telefonoCel, telefonoAux', 'length', 'max'=>15),
			array('direccionPersona', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_empresa, id_persona_representante, rif_empresa, razon_social_empresa, nombre_comercial_empresa, direccion_empresa, telefono_hab_persona, telefono_aux_empresa, correo_empresa, nombreCompletoRepresentante', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'instanciaProcesos' => array(self::HAS_MANY, 'InstanciaProceso', 'solicitante_empresa'),
			'idPersonaRepresentante' => array(self::BELONGS_TO, 'Persona', 'id_persona_representante'),
			//'persona' => array(self::BELONGS_TO, 'Persona', 'id_persona'),
			'usuarioEmpresas' => array(self::HAS_MANY, 'UsuarioEmpresa', 'id_empresa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_empresa' => 'Id Empresa',
			'id_persona_representante' => 'Id Persona Representante',
			'rif_empresa' => 'Rif',
			'razon_social_empresa' => 'Razón Social',
			'nombre_comercial_empresa' => 'Nombre Comercial',
			'direccion_empresa' => 'Dirección',
			'telefono_hab_persona' => 'Teléfono Oficina',
			'telefono_aux_empresa' => 'Teléfono Auxiliar',
			'correo_empresa' => 'Correo Electrónico',
			'nombrePersona' => 'Nombre',
			'apellidoPersona' => 'Apellido',
			'nacionalidadPersona' => 'Nacionalidad',
			'cedulaPersona' => 'Cédula',
			'direccionPersona' => 'Dirección',
			'telefonoHab' => 'Teléfono Habitación',
			'telefonoCel' => 'Teléfono Celular',
			'telefonoAux' => 'Teléfono Auxiliar',
			'correoPersona' => 'Correo Electrónico',
			'nombreCompletoRepresentante' => 'Nombre Representante',
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

		$criteria->with = array("idPersonaRepresentante"=>array('alias' => 'persona'));

		$criteria->compare('id_empresa',$this->id_empresa);
		$criteria->compare('id_persona_representante',$this->id_persona_representante);
		$criteria->compare('rif_empresa',$this->rif_empresa,true);
		$criteria->addSearchCondition('LOWER(razon_social_empresa)',strtolower($this->razon_social_empresa),true);
		$criteria->addSearchCondition('LOWER(nombre_comercial_empresa)',strtolower($this->nombre_comercial_empresa),true);
		$criteria->compare('direccion_empresa',$this->direccion_empresa,true);
		$criteria->compare('telefono_hab_persona',$this->telefono_hab_persona,true);
		$criteria->compare('telefono_aux_empresa',$this->telefono_aux_empresa,true);
		$criteria->compare('correo_empresa',$this->correo_empresa,true);
		$criteria->addSearchCondition('LOWER(persona.nombre_persona)',strtolower($this->nombreCompletoRepresentante),true);
		$criteria->addSearchCondition('LOWER(persona.apellido_persona)',strtolower($this->nombreCompletoRepresentante),true, 'OR');
		$criteria->compare('persona.cedula_persona',$this->cedulaPersona,true);
		
		$sort = new CSort();
		$sort->attributes = array(

		    'rif_empresa'=>array(
		        'asc'=>'rif_empresa',
		        'desc'=>'rif_empresa desc',
		    ),
		    'razon_social_empresa'=>array(
		        'asc'=>'razon_social_empresa',
		        'desc'=>'razon_social_empresa desc',
		    ),
		    'nombre_comercial_empresa'=>array(
		        'asc'=>'nombre_comercial_empresa',
		        'desc'=>'nombre_comercial_empresa desc',
		    ),
		    'nombreCompletoRepresentante'=>array(
		        'asc'=>'persona.nombre_persona',
		        'desc'=>'persona.nombre_persona desc',
		    ),
		    'cedulaPersona'=>array(
		        'asc'=>'persona.cedula_persona',
		        'desc'=>'persona.cedula_persona desc',
		    ),
		   
		);

		$sort->defaultOrder = 'prefijo_rif DESC, rif_empresa ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}

	public function getnombreCompletoRepresentante(){

	    if ($this->_nombreCompletoRepresentante === null && $this->idPersonaRepresentante !== null){

	        $this->_nombreCompletoRepresentante = $this->idPersonaRepresentante->nombre_persona.' '.$this->idPersonaRepresentante->apellido_persona;
	    }

	    return $this->_nombreCompletoRepresentante;
	}

	public function setnombreCompletoRepresentante($value){

		$this->_nombreCompletoRepresentante = $value;
	}

	public function getnombrePersona(){

	    if ($this->_nombrePersona === null && $this->idPersonaRepresentante !== null){

	        $this->_nombrePersona = $this->idPersonaRepresentante->nombre_persona;
	    }

	    return $this->_nombrePersona;
	}

	public function setnombrePersona($value){

		$this->_nombrePersona = $value;
	}

	public function getapellidoPersona(){

	    if ($this->_apellidoPersona === null && $this->idPersonaRepresentante !== null){

	        $this->_apellidoPersona = $this->idPersonaRepresentante->apellido_persona;
	    }

	    return $this->_apellidoPersona;
	}

	public function setapellidoPersona($value){

		$this->_apellidoPersona = $value;
	}

	public function getnacionalidadPersona(){

	    if ($this->_nacionalidadPersona === null && $this->idPersonaRepresentante !== null){

	        $this->_nacionalidadPersona = $this->idPersonaRepresentante->nacionalidad_persona;
	    }

	    return $this->_nacionalidadPersona;
	}

	public function setnacionalidadPersona($value){

		$this->_nacionalidadPersona = $value;
	}

	public function getcedulaPersona(){

	    if ($this->_cedulaPersona === null && $this->idPersonaRepresentante !== null){

	        $this->_cedulaPersona = $this->idPersonaRepresentante->cedula_persona;
	    }

	    return $this->_cedulaPersona;
	}

	public function setcedulaPersona($value){

		$this->_cedulaPersona = $value;
	}

	public function getdireccionPersona(){

	    if ($this->_direccionPersona === null && $this->idPersonaRepresentante !== null){

	        $this->_direccionPersona = $this->idPersonaRepresentante->direccion_persona;
	    }

	    return $this->_direccionPersona;
	}

	public function setdireccionPersona($value){

		$this->_direccionPersona = $value;
	}

	public function gettelefonoHab(){

	    if ($this->_telefonoHab === null && $this->idPersonaRepresentante !== null){

	        $this->_telefonoHab = $this->idPersonaRepresentante->telefono_hab_persona;
	    }

	    return $this->_telefonoHab;
	}

	public function settelefonoHab($value){

		$this->_telefonoHab = $value;
	}

	public function gettelefonoCel(){

	    if ($this->_telefonoCel === null && $this->idPersonaRepresentante !== null){

	        $this->_telefonoCel = $this->idPersonaRepresentante->telefono_cel_persona;
	    }

	    return $this->_telefonoCel;
	}

	public function settelefonoCel($value){

		$this->_telefonoCel = $value;
	}

	public function gettelefonoAux(){

	    if ($this->_telefonoAux === null && $this->idPersonaRepresentante !== null){

	        $this->_telefonoAux = $this->idPersonaRepresentante->telefono_aux_persona;
	    }

	    return $this->_telefonoAux;
	}

	public function settelefonoAux($value){

		$this->_telefonoAux = $value;
	}

	public function getcorreoPersona(){

	    if ($this->_correoPersona === null && $this->idPersonaRepresentante !== null){

	        $this->_correoPersona = $this->idPersonaRepresentante->correo_persona;
	    }

	    return $this->_correoPersona;
	}

	public function setcorreoPersona($value){

		$this->_correoPersona = $value;
	}

	public function getRifCompleto()
	{
		return $this->prefijo_rif . "-". $this->rif_empresa;
	}

	public function getCedulaCompleta()
	{
		if($this->nacionalidadPersona!="" && $this->cedulaPersona!="")
			return $this->nacionalidadPersona . "-". $this->cedulaPersona;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empresa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
