<?php

/**
 * This is the model class for table "vis_act_rol".
 *
 * The followings are the available columns in table 'vis_act_rol':
 * @property integer $id_rol
 * @property integer $id_proceso
 * @property string $proceso
 * @property string $actividad
 * @property string $codigo_1
 * @property string $codigo_2
 * @property string $codigo_3
 */
class VisActRol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_act_rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rol, id_proceso', 'numerical', 'integerOnly'=>true),
			array('proceso', 'length', 'max'=>300),
			array('actividad, codigo_1, codigo_2, codigo_3', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_rol, id_proceso, proceso, actividad, codigo_1, codigo_2, codigo_3', 'safe', 'on'=>'search'),
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
			'id_rol' => 'Id Rol',
			'id_proceso' => 'Id Proceso',
			'proceso' => 'Proceso',
			'actividad' => 'Actividad',
			'codigo_1' => 'Codigo 1',
			'codigo_2' => 'Codigo 2',
			'codigo_3' => 'Codigo 3',
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

		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('proceso',$this->proceso,true);
		$criteria->compare('actividad',$this->actividad,true);
		$criteria->compare('codigo_1',$this->codigo_1,true);
		$criteria->compare('codigo_2',$this->codigo_2,true);
		$criteria->compare('codigo_3',$this->codigo_3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisActRol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
