<?php

/**
 * This is the model class for table "vis_recaudo_dato_obligatorio".
 *
 * The followings are the available columns in table 'vis_recaudo_dato_obligatorio':
 * @property integer $id_modelo_estado_actividad
 * @property string $cantidad_dato_adicional
 * @property string $id_proceso_dato_adicional
 * @property string $cantidad_recaudos
 * @property string $id_proceso_recaudo
 */
class VisRecaudoDatoObligatorio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_recaudo_dato_obligatorio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modelo_estado_actividad', 'numerical', 'integerOnly'=>true),
			array('cantidad_dato_adicional, id_proceso_dato_adicional, cantidad_recaudos, id_proceso_recaudo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_modelo_estado_actividad, cantidad_dato_adicional, id_proceso_dato_adicional, cantidad_recaudos, id_proceso_recaudo', 'safe', 'on'=>'search'),
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
			'id_modelo_estado_actividad' => 'Id Modelo Estado Actividad',
			'cantidad_dato_adicional' => 'Cantidad Dato Adicional',
			'id_proceso_dato_adicional' => 'Id Proceso Dato Adicional',
			'cantidad_recaudos' => 'Cantidad Recaudos',
			'id_proceso_recaudo' => 'Id Proceso Recaudo',
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

		$criteria->compare('id_modelo_estado_actividad',$this->id_modelo_estado_actividad);
		$criteria->compare('cantidad_dato_adicional',$this->cantidad_dato_adicional,true);
		$criteria->compare('id_proceso_dato_adicional',$this->id_proceso_dato_adicional,true);
		$criteria->compare('cantidad_recaudos',$this->cantidad_recaudos,true);
		$criteria->compare('id_proceso_recaudo',$this->id_proceso_recaudo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisRecaudoDatoObligatorio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
