<?php

/**
 * This is the model class for table "instancia_recaudo".
 *
 * The followings are the available columns in table 'instancia_recaudo':
 * @property integer $id_instancia_recaudo
 * @property integer $id_instancia_actividad //CAMBIADA (ANTERIORMENTE instancia_actividad_id)
 * @property integer $id_proceso_recaudo
 * @property boolean $consignado
 * @property string $observacion_instancia_recaudo
 * @property string $tag_instancia_recaudo
 *
 * The followings are the available model relations:
 * @property InstanciaActividad $instanciaActividad
 * @property Recaudo $idRecaudo
 */
class InstanciaRecaudo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'instancia_recaudo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_instancia_proceso, id_proceso_recaudo, consignado', 'required'),
			array('id_instancia_proceso, id_proceso_recaudo', 'numerical', 'integerOnly'=>true),
			array('observacion_instancia_recaudo', 'length', 'max'=>500),
			array('tag_instancia_recaudo', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_instancia_recaudo, id_instancia_proceso, id_proceso_recaudo, consignado, observacion_instancia_recaudo, tag_instancia_recaudo', 'safe', 'on'=>'search'),
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
			'idInstanciaProceso' => array(self::BELONGS_TO, 'InstanciaProceso', 'id_instancia_proceso'),
            'idProcesoRecaudo' => array(self::BELONGS_TO, 'ProcesoRecaudo', 'id_proceso_recaudo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_instancia_recaudo' => 'Id Instancia Recaudo',
			'id_instancia_proceso' => 'Instancia Proceso',
			'id_proceso_recaudo' => 'Id Proceso Recaudo',
			'consignado' => 'Consignado',
			'observacion_instancia_recaudo' => 'Observacion Instancia Recaudo',
			'tag_instancia_recaudo' => 'Tag Instancia Recaudo',
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

		$criteria->compare('id_instancia_recaudo',$this->id_instancia_recaudo);
		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
        $criteria->compare('id_proceso_recaudo',$this->id_proceso_recaudo);
		$criteria->compare('consignado',$this->consignado);
		$criteria->compare('observacion_instancia_recaudo',$this->observacion_instancia_recaudo,true);
		$criteria->compare('tag_instancia_recaudo',$this->tag_instancia_recaudo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InstanciaRecaudo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
