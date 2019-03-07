<?php

/**
 * This is the model class for table "recaudo_actividad".
 *
 * The followings are the available columns in table 'recaudo_actividad':
 * @property integer $id_recaudo_actividad
 * @property integer $id_proceso_recaudo
 * @property integer $id_actividad
 *
 * The followings are the available model relations:
 * @property Actividad $idActividad
 * @property ProcesoRecaudo $idProcesoRecaudo
 */
class RecaudoActividad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recaudo_actividad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_proceso_recaudo, id_actividad', 'required'),
			array('id_proceso_recaudo, id_actividad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_recaudo_actividad, id_proceso_recaudo, id_actividad', 'safe', 'on'=>'search'),
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
			'idActividad' => array(self::BELONGS_TO, 'Actividad', 'id_actividad'),
			'idProcesoRecaudo' => array(self::BELONGS_TO, 'ProcesoRecaudo', 'id_proceso_recaudo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_recaudo_actividad' => 'Id Recaudo Actividad',
			'id_proceso_recaudo' => 'Id Proceso Recaudo',
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

		$criteria->compare('id_recaudo_actividad',$this->id_recaudo_actividad);
		$criteria->compare('id_proceso_recaudo',$this->id_proceso_recaudo);
		$criteria->compare('id_actividad',$this->id_actividad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecaudoActividad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
