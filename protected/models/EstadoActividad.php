<?php

/**
 * This is the model class for table "estado_actividad".
 *
 * The followings are the available columns in table 'estado_actividad':
 * @property integer $id_estado_actividad
 * @property string $nombre_estado_actividad
 *
 * The followings are the available model relations:
 * @property ModeloEstadoActividad[] $modeloEstadoActividads
 * @property InstanciaActividad[] $instanciaActividads
 * @property HistEstadoInstanciaActividad[] $histEstadoInstanciaActividads
 */
class EstadoActividad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'estado_actividad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_estado_actividad', 'required'),
			array('nombre_estado_actividad', 'length', 'max'=>300),
			array('nombre_estado_actividad', 'unique', 'message'=>'Nombre Estado Actividad ya existente'),
			array('nombre_estado_actividad', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ.\s]+$/', 'message' => 'Nombre Estado Actividad inválido. Sólo se permiten caracteres alfabéticos'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_estado_actividad, nombre_estado_actividad', 'safe', 'on'=>'search'),
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
			'modeloEstadoActividads' => array(self::HAS_MANY, 'ModeloEstadoActividad', 'id_estado_actividad'),
			'instanciaActividads' => array(self::HAS_MANY, 'InstanciaActividad', 'id_estado_actividad'),
			'histEstadoInstanciaActividads' => array(self::HAS_MANY, 'HistEstadoInstanciaActividad', 'id_estado_actividad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_estado_actividad' => 'Id Estado Actividad',
			'nombre_estado_actividad' => 'Nombre Estado Actividad',
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

		$criteria->compare('id_estado_actividad',$this->id_estado_actividad);
		$criteria->compare('LOWER(nombre_estado_actividad)',strtolower($this->nombre_estado_actividad),true);

		$sort = new CSort();
		$sort->defaultOrder = 'nombre_estado_actividad ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EstadoActividad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
