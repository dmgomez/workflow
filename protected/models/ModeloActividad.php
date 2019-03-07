<?php

/**
 * This is the model class for view "vis_modelo_actividad".
 *
 * The followings are the available columns in table 'vis_modelo_actividad':
 * @property integer $id_modelo_estado_actividad
 * @property integer $id_proceso
 * @property integer $id_actividad_origen
 * @property string $codigo_actividad_origen
 * @property integer $es_inicial
 * @property string $nombre_actividad_origen
 * @property integer $id_estado_actividad_inicial
 * @property string $nombre_estado_actividad_inicial
 *
 */
class ModeloActividad extends CActiveRecord
{
	private $_imagenActivo;
	private $_observaciones;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_modelo_actividad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	/*
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_organizacion, rif_organizacion', 'required'),
			array('nombre_organizacion', 'length', 'max'=>300),
			array('rif_organizacion', 'length', 'max'=>20),
			array('direccion_organizacion', 'length', 'max'=>500),
			array('telefono_organizacion, correo_organizacion', 'length', 'max'=>50),
			array('web_organizacion', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_organizacion, nombre_organizacion, rif_organizacion, direccion_organizacion, telefono_organizacion, correo_organizacion, web_organizacion', 'safe', 'on'=>'search'),
		);
	}
*/
	/**
	 * @return array relational rules.
	 */
	/*
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'departamentos' => array(self::HAS_MANY, 'Departamento', 'id_organizacion'),
		);
	}
	*/
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_modelo_estado_actividad' => 'Id Modelo Actividad',
			'id_proceso' => 'Id Proceso',
			'id_actividad_origen' => 'Id Actividad Origen',
			'codigo_actividad_origen' => 'Código Actividad Origen',
			'es_inicial' => 'Es Inicial',
			'nombre_actividad_origen' => 'Nombre Actividad Origen',
			'id_estado_actividad_inicial' => 'Id Estado Incial Actividad Destino',
			'nombre_estado_inicial_actividad' => 'Estado Incial Actividad Destino',
			'id_estado_actividad_salida' => 'Id Estado de Transición',
			'nombre_estado_actividad_salida' => 'Estado de Transición',
			'id_actividad_destino' => 'Id Actividad Destino',
			'codigo_actividad_destino' => 'Código Actividad Destino',
			'nombre_actividad_destino' => 'Nombre Actividad Destino',
			'espera_destino' => 'Espera Destino',
			'activo_transicion' => 'Activo Transicion',
            'id_actividad_suspendida' => 'Id Actividad Suspendida',
            'transicion_temporal' => 'Transicion Temporal',
            'imagenActivo' => 'Estado',
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

	public function getimagenActivo(){

		if($this->_imagenActivo===null)
		{
			if($this->activo_transicion == 0)
				$this->_imagenActivo=Yii::app()->getBaseUrl(true).'/images/inactivo2.png';
			else if($this->transicion_temporal == 1)
				$this->_imagenActivo=Yii::app()->getBaseUrl(true).'/images/alerta.png';
		}

		return $this->_imagenActivo;
	}

	public function getobservaciones()
	{
		if($this->_observaciones === null)
		{
			if($this->activo_transicion == 0)
				$this->_observaciones="Desabilitada por suspención de actividad";
			else if($this->transicion_temporal == 1)
				$this->_observaciones="Temporal por suspención de actividad";

		}
		return $this->_observaciones;
	}

	public function setobservaciones($value){

		$this->_observaciones = $value;
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

		$criteria->compare('id_modelo_estado_actividad',$this->id_modelo_estado_actividad);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('id_actividad_origen',$this->id_actividad_origen);
		$criteria->compare('codigo_actividad_origen',$this->codigo_actividad_origen,true);
		$criteria->compare('es_inicial',$this->es_inicial);
		$criteria->compare('nombre_actividad_origen',$this->nombre_actividad_origen,true);
		$criteria->compare('id_estado_actividad_inicial',$this->id_estado_actividad_inicial);
		$criteria->compare('nombre_estado_inicial_actividad',$this->web_organizacion,true);

		$sort = new CSort();
		
		$sort->attributes = array(

		    'es_inicial'=>array(
		        'asc'=>'es_inicial',
		        'desc'=>'es_inicial desc',
		    ),
		    /*
		    'codigo_actividad'=>array(
		        'asc'=>'codigo_actividad',
		        'desc'=>'codigo_actividad desc',
		    ),
		    */
		);

		$sort->defaultOrder = 'es_inicial DESC, codigo_actividad_origen ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'sort'=>$sort,
		));

		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Organizacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
