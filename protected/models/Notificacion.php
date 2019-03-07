<?php

/**
 * This is the model class for table "notificacion".
 *
 * The followings are the available columns in table 'notificacion':
 * @property integer $id_notificacion
 * @property string $nombre_notificacion
 * @property integer $id_tipo_notificacion
 * @property integer $es_dato_adicional
 *
 * The followings are the available model relations:
 * @property TipoNotificacion $idTipoNotificacion
 * @property NotificacionActividad[] $notificacionActividads
 */
class Notificacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notificacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_notificacion, id_tipo_notificacion', 'required'),
			array('id_tipo_notificacion, es_dato_adicional', 'numerical', 'integerOnly'=>true),
			array('nombre_notificacion', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_notificacion, nombre_notificacion, id_tipo_notificacion, es_dato_adicional', 'safe', 'on'=>'search'),
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
			'idTipoNotificacion' => array(self::BELONGS_TO, 'TipoNotificacion', 'id_tipo_notificacion'),
			'notificacionActividads' => array(self::HAS_MANY, 'NotificacionActividad', 'id_notificacion'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notificacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
