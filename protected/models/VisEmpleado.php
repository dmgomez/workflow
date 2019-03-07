<?php

/**
 * This is the model class for table "vis_empleado".
 *
 * The followings are the available columns in table 'vis_empleado':
 * @property integer $id_empleado
 * @property integer $id_departamento
 * @property integer $id_cargo
 * @property integer $superior_inmediato
 * @property integer $id_persona
 * @property integer $id_usuario
 * @property string $nombre_persona
 * @property string $cedula_persona
 * @property string $nombre_cargo
 * @property string $nombre_departamento
 * @property string $nombre_rol
 * @property string $nombre_superior
 */
class VisEmpleado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_empleado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_empleado, id_departamento, id_cargo, superior_inmediato, id_persona, id_usuario, id_organizacion', 'numerical', 'integerOnly'=>true),
			array('nombre_cargo, nombre_departamento, nombre_organizacion', 'length', 'max'=>300),
			array('nombre_persona, cedula_persona, id_rol, nombre_rol, nombre_superior', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_empleado, id_departamento, id_cargo, superior_inmediato, id_persona, id_usuario, nombre_persona, cedula_persona, nombre_cargo, nombre_departamento, id_organizacion, nombre_organizacion, nombre_rol, nombre_superior', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_empleado' => 'Id Empleado',
			'id_departamento' => 'Id Departamento',
			'id_cargo' => 'Id Cargo',
			'superior_inmediato' => 'Superior Inmediato id',
			'id_persona' => 'Id Persona',
			'id_usuario' => 'Id Usuario',
			'nombre_persona' => 'Nombre',
			'cedula_persona' => 'Cédula',
			'nombre_cargo' => 'Cargo',
			'nombre_departamento' => 'Departamento',
			'id_rol' => 'Id Rol',
			'nombre_rol' => 'Rol',
			'nombre_superior' => 'Superior Inmediato',
			'id_organizacion' => 'Id Organizacion',
			'nombre_organizacion' => 'Organización',
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

		$criteria->compare('id_empleado',$this->id_empleado);
		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->compare('id_cargo',$this->id_cargo);
		$criteria->compare('superior_inmediato',$this->superior_inmediato);
		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->addSearchCondition('LOWER(nombre_persona)',strtolower($this->nombre_persona),true);
		$criteria->compare('cedula_persona',$this->cedula_persona,true);
		$criteria->addSearchCondition('LOWER(nombre_cargo)',strtolower($this->nombre_cargo),true);
		$criteria->addSearchCondition('LOWER(nombre_departamento)',strtolower($this->nombre_departamento),true);
		$criteria->addSearchCondition('LOWER(nombre_organizacion)',strtolower($this->nombre_organizacion),true);
		$criteria->addSearchCondition('LOWER(nombre_rol)',strtolower($this->nombre_rol),true);
		$criteria->addSearchCondition('LOWER(nombre_superior)',strtolower($this->nombre_superior),true);

		$sort = new CSort();
		$sort->defaultOrder = 'nombre_organizacion, cedula_persona ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisEmpleado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
