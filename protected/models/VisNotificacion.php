<?php

/**
 * This is the model class for table "vis_notificacion".
 *
 * The followings are the available columns in table 'vis_notificacion':
 * @property integer $id_notificacion
 * @property string $nombre_notificacion
 * @property integer $id_tipo_notificacion
 * @property integer $es_dato_adicional
 * @property integer $id_notificacion_actividad
 * @property integer $id_actividad
 * @property integer $id_dato_notificacion_actividad
 * @property integer $id_proceso_dato_adicional
 */
class VisNotificacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_notificacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_notificacion, id_tipo_notificacion, es_dato_adicional, id_notificacion_actividad, id_actividad, id_dato_notificacion_actividad, id_proceso_dato_adicional', 'numerical', 'integerOnly'=>true),
			array('nombre_notificacion', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_notificacion, nombre_notificacion, id_tipo_notificacion, es_dato_adicional, id_notificacion_actividad, id_actividad, id_dato_notificacion_actividad, id_proceso_dato_adicional', 'safe', 'on'=>'search'),
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
			'id_notificacion' => 'Id Notificacion',
			'nombre_notificacion' => 'Nombre Notificacion',
			'id_tipo_notificacion' => 'Id Tipo Notificacion',
			'es_dato_adicional' => 'Es Dato Adicional',
			'id_notificacion_actividad' => 'Id Notificacion Actividad',
			'id_actividad' => 'Id Actividad',
			'id_dato_notificacion_actividad' => 'Id Dato Notificacion Actividad',
			'id_proceso_dato_adicional' => 'Id Proceso Dato Adicional',
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

		$criteria->compare('id_notificacion',$this->id_notificacion);
		$criteria->compare('nombre_notificacion',$this->nombre_notificacion,true);
		$criteria->compare('id_tipo_notificacion',$this->id_tipo_notificacion);
		$criteria->compare('es_dato_adicional',$this->es_dato_adicional);
		$criteria->compare('id_notificacion_actividad',$this->id_notificacion_actividad);
		$criteria->compare('id_actividad',$this->id_actividad);
		$criteria->compare('id_dato_notificacion_actividad',$this->id_dato_notificacion_actividad);
		$criteria->compare('id_proceso_dato_adicional',$this->id_proceso_dato_adicional);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisNotificacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
