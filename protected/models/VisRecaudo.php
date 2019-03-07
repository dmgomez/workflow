<?php

/**
 * This is the model class for table "vis_recaudo".
 *
 * The followings are the available columns in table 'vis_recaudo':
 * @property integer $id_recaudo
 * @property string $nombre_recaudo
 * @property integer $id_proceso_recaudo
 * @property integer $id_proceso
 * @property integer $id_recaudo_actividad
 * @property integer $id_actividad
 */
class VisRecaudo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_recaudo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_recaudo, id_proceso_recaudo, id_proceso, id_recaudo_actividad, id_actividad', 'numerical', 'integerOnly'=>true),
			array('nombre_recaudo', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_recaudo, nombre_recaudo, id_proceso_recaudo, id_proceso, id_recaudo_actividad, id_actividad', 'safe', 'on'=>'search'),
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
			'id_recaudo' => 'Id Recaudo',
			'nombre_recaudo' => 'Nombre Recaudo',
			'id_proceso_recaudo' => 'Id Proceso Recaudo',
			'id_proceso' => 'Id Proceso',
			'id_recaudo_actividad' => 'Id Recaudo Actividad',
			'id_actividad' => 'Id Actividad',
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

		$criteria->compare('id_recaudo',$this->id_recaudo);
		$criteria->compare('nombre_recaudo',$this->nombre_recaudo,true);
		$criteria->compare('id_proceso_recaudo',$this->id_proceso_recaudo);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('id_recaudo_actividad',$this->id_recaudo_actividad);
		$criteria->compare('id_actividad',$this->id_actividad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisRecaudo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
