<?php

/**
 * This is the model class for table "actividad".
 *
 * The followings are the available columns in table 'actividad':
 * @property integer $id_actividad
 * @property integer $id_proceso
 * @property string $descripcion_actividad
 * @property string $nombre_actividad
 * @property string $codigo_actividad
 * @property integer $es_inicial
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property Recaudo[] $recaudos
 * @property Proceso $idProceso
 * @property ModeloEstadoActividad[] $modeloEstadoActividads
 * @property ModeloEstadoActividad[] $modeloEstadoActividads1
 * @property InstanciaActividad[] $instanciaActividads
 * @property DatoAdicional[] $datoAdicionals
 * @property ActividadRol[] $actividadRols
 */
class Actividad extends CActiveRecord
{
	private $_esInicial;
	//private $_esInicialReconsideracion;
	private $_btn;
	private $_codName;

	private $_activoImage;

	public $_codigo_1;
	public $_codigo_2;
	public $_codigo_3;
	public $_recaudos;
	public $_recaudosSeleccionados;
	public $_datos;
	public $_datosSeleccionados;


	public function get_esInicial()
	{

	    if ($this->es_inicial == 1) {

	        $this->_esInicial = 'SI';
	    }
	    else
	    {
	    	$this->_esInicial = 'NO';
	    }

	    return $this->_esInicial;
	}


	public function get_codName()
	{
	    return $this->codigo_actividad.' - '.$this->nombre_actividad;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actividad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_proceso, nombre_actividad, codigo_actividad, descripcion_actividad es_inicial, activo, dias, horas, btn, activoImage, id_departamento', 'required'),
			//array('codigo_actividad', 'unique', 'message' => 'Código Actividad ya se encuentra registrado.'),
			array('id_proceso, es_inicial, activo, id_departamento', 'numerical', 'integerOnly'=>true),
			array('descripcion_actividad', 'length', 'max'=>1000),
			array('nombre_actividad', 'length', 'max'=>250),
			array('nombre_actividad', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$/', 'message' => 'Nombre Actividad inválido. Sólo se permiten los siguientes caracteres espciales: # º , . - :'),
			array('descripcion_actividad', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$/', 'message' => 'Descripción Actividad inválida. Sólo se permiten los siguientes caracteres espciales: # º , . - :'),
			array('codigo_actividad', 'length', 'max'=>20),
			array('dias, horas', 'length', 'max'=>2),
			array('horas','validar_tiempoEstimado','on'=>array('insert', 'update')),
			//array('dias', 'integerOnly' => true, 'max' => 20, 'min' => 0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_actividad, id_proceso, descripcion_actividad, nombre_actividad, codigo_actividad, es_inicial', 'safe', 'on'=>'search'),
		);
	}

	public function validar_tiempoEstimado($attribute)
	{
		if($this->dias==0 && $this->horas==0)
			$this->addError($attribute,"Debe ingresar el tiempo estimado de la actividad.");
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'recaudos' => array(self::HAS_MANY, 'Recaudo', 'id_actividad'),
			'idProceso' => array(self::BELONGS_TO, 'Proceso', 'id_proceso'),
			'modeloEstadoActividadDestino' => array(self::HAS_MANY, 'ModeloEstadoActividad', 'id_actividad_destino'),
			'modeloEstadoActividadOrigen' => array(self::HAS_MANY, 'ModeloEstadoActividad', 'id_actividad_origen'),
			'instanciaActividad' => array(self::HAS_MANY, 'InstanciaActividad', 'id_actividad'),
			'datoAdicional' => array(self::HAS_MANY, 'DatoAdicional', 'id_actividad'),
			'actividadRol' => array(self::HAS_MANY, 'ActividadRol', 'id_actividad'),
			'recaudoActividads' => array(self::HAS_MANY, 'RecaudoActividad', 'id_actividad'),
			'datoActividads' => array(self::HAS_MANY, 'DatoActividad', 'id_actividad'),
			'idDepartamento' => array(self::BELONGS_TO, 'Departamento', 'id_departamento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_actividad' => 'Id Actividad',
			'id_proceso' => 'Id Proceso',
			'descripcion_actividad' => 'Descripción Actividad',
			'nombre_actividad' => 'Nombre Actividad',
			'codigo_actividad' => 'Código Actividad',
			'es_inicial' => 'Es Inicial',
			'activo' => 'Activo',
			'dias' => 'Días',
			'horas' => 'Horas',
			'activoImage' => 'Activa',
			'id_departamento' => 'Departamento'
		);
	}

	/**
	* Retorna el valor para humanos del campo es inicial
	*/
	public function esInicial()
	{
		if($this->es_inicial == 1)
		{
			return "Sí";
		}
		else
		{
			return "No";
		}
	}

	public function esActiva()
	{
		if($this->activo == 1)
		{
			return "Sí";
		}
		else
		{
			return "No";
		}
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

		$criteria->compare('id_actividad',$this->id_actividad);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('descripcion_actividad',$this->descripcion_actividad,true);
		$criteria->compare('nombre_actividad',$this->nombre_actividad,true);
		$criteria->compare('codigo_actividad',$this->codigo_actividad,true);
		$criteria->compare('es_inicial',$this->es_inicial);
		$criteria->compare('activo',$this->activo);
		//$criteria->order ='codigo_actividad asc';
		$sort = new CSort();
		
		$sort->attributes = array(

		    '_esInicial'=>array(
		        'asc'=>'_esInicial',
		        'desc'=>'_esInicial desc',
		    ),
		    'codigo_actividad'=>array(
		        'asc'=>'codigo_actividad',
		        'desc'=>'codigo_actividad desc',
		    ),
		);

		$sort->defaultOrder = 'codigo_actividad ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'sort'=>$sort,
		));
	}

	public function getbtn()
	{
		return $this->_btn;
	}

	public function setbtn($value)
	{
		$this->btn=$value;
	}

	public function tiempoEstimado()
	{
		return $this->dias.' días '.$this->horas.' horas';
	}

	public function getactivoImage(){

		if($this->_activoImage===null)
		{
			if($this->activo == 1)
				$this->_activoImage=Yii::app()->getBaseUrl(true).'/images/activo.png';
			else
				$this->_activoImage=Yii::app()->getBaseUrl(true).'/images/inactivo2.png';
		}

		return $this->_activoImage;
	}

	public function get_visibilidad_disable()
	{
		if($this->activo==1)
			return true;
		else
			return false;
	}

	public function get_visibilidad_enable()
	{
		if($this->activo==0)
			return true;
		else
			return false;
	}

	public function es_fin(){

		if ($this->es_final == 1){

			return true;
		}
		else{

			return false;
		}
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Actividad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
