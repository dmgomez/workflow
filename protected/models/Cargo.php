<?php

/**
 * This is the model class for table "cargo".
 *
 * The followings are the available columns in table 'cargo':
 * @property integer $id_cargo
 * @property string $nombre_cargo
 * @property string $descripcion_cargo
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property Empleado[] $empleados
 */
class Cargo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cargo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_organizacion, nombre_cargo, descripcion_cargo, activo', 'required'),
			array('id_organizacion, activo', 'numerical', 'integerOnly'=>true),
			array('nombre_cargo', 'length', 'max'=>300),
			array('nombre_cargo','validar_nombre','on'=>array('insert', 'update')),
			array('nombre_cargo', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]+$/', 'message' => 'Nombre Cargo inválido. Sólo se permiten valores alfanuméricos.'),
			array('descripcion_cargo', 'length', 'max'=>500),
			array('descripcion_cargo', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/,.:\-\s]+$/', 'message' => 'Descripción Cargo inválida. Sólo se permiten los siguientes caracteres espciales: / , . - :.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cargo, id_organizacion, nombre_cargo, descripcion_cargo', 'safe', 'on'=>'search'),
		);
	}

	public function validar_nombre($attribute)
	{
		$buscar_nombre=Cargo::model()->findByAttributes(array('id_organizacion'=>$this->id_organizacion, 'nombre_cargo'=>$this->nombre_cargo));

		if($buscar_nombre && $buscar_nombre->id_cargo!=$this->id_cargo)
			$this->addError($attribute, "Nombre Cargo ya registrado.");
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'empleados' => array(self::HAS_MANY, 'Empleado', 'id_cargo'),
			'organizacion' => array(self::BELONGS_TO, 'Organizacion', 'id_organizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cargo' => 'Id Cargo',
			'id_organizacion' => 'Organización',
			'nombre_cargo' => 'Nombre',
			'descripcion_cargo' => 'Descripción',
			'activo' => 'Activo',
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

		$criteria->compare('id_cargo',$this->id_cargo);
		$criteria->with =array('organizacion');
		$criteria->addSearchCondition('LOWER(organizacion.nombre_organizacion)', strtolower($this->id_organizacion));
		$criteria->compare('LOWER(nombre_cargo)',strtolower($this->nombre_cargo),true);
		$criteria->compare('LOWER(descripcion_cargo)',strtolower($this->descripcion_cargo),true);

		$sort = new CSort();
		$sort->defaultOrder = 'organizacion.nombre_organizacion ASC, nombre_cargo ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cargo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
