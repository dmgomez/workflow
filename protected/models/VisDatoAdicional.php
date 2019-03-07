<?php

/**
 * This is the model class for table "vis_dato_adicional".
 *
 * The followings are the available columns in table 'vis_dato_adicional':
 * @property integer $id_dato_adicional
 * @property string $nombre_dato_adicional
 * @property integer $tipo_dato_adicional
 * @property string $nombre_tipo_dato
 * @property integer $dato_activo
 * @property integer $id_proceso_dato_adicional
 * @property integer $id_proceso
 * @property integer $orden
 * @property integer $id_dato_actividad
 * @property integer $id_actividad
 */
class VisDatoAdicional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_dato_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_dato_adicional, tipo_dato_adicional, dato_activo, id_proceso_dato_adicional, id_proceso, orden, id_dato_actividad, id_actividad', 'numerical', 'integerOnly'=>true),
			array('nombre_dato_adicional', 'length', 'max'=>250),
			array('nombre_tipo_dato', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dato_adicional, nombre_dato_adicional, tipo_dato_adicional, nombre_tipo_dato, dato_activo, id_proceso_dato_adicional, id_proceso, orden, id_dato_actividad, id_actividad', 'safe', 'on'=>'search'),
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
			'id_dato_adicional' => 'Id Dato Adicional',
			'nombre_dato_adicional' => 'Nombre Dato Adicional',
			'tipo_dato_adicional' => 'Tipo Dato Adicional',
			'nombre_tipo_dato' => 'Nombre Tipo Dato',
			'dato_activo' => 'Dato Activo',
			'id_proceso_dato_adicional' => 'Id Proceso Dato Adicional',
			'id_proceso' => 'Id Proceso',
			'orden' => 'Orden',
			'id_dato_actividad' => 'Id Dato Actividad',
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

		$criteria->compare('id_dato_adicional',$this->id_dato_adicional);
		$criteria->compare('nombre_dato_adicional',$this->nombre_dato_adicional,true);
		$criteria->compare('tipo_dato_adicional',$this->tipo_dato_adicional);
		$criteria->compare('nombre_tipo_dato',$this->nombre_tipo_dato,true);
		$criteria->compare('dato_activo',$this->dato_activo);
		$criteria->compare('id_proceso_dato_adicional',$this->id_proceso_dato_adicional);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('id_dato_actividad',$this->id_dato_actividad);
		$criteria->compare('id_actividad',$this->id_actividad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisDatoAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
