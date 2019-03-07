<?php

/**
 * This is the model class for table "vis_instancia_dato_adicional".
 *
 * The followings are the available columns in table 'vis_instancia_dato_adicional':
 * @property integer $id_instancia_dato_adicional
 * @property integer $id_proceso_dato_adicional
 * @property integer $id_instancia_proceso
 * @property string $nombre_dato_adicional
 * @property integer $tipo_dato_adicional
 * @property string $valor_dato_adicional
 */
class VisInstanciaDatoAdicional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_instancia_dato_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_instancia_dato_adicional, id_proceso_dato_adicional, id_instancia_proceso, tipo_dato_adicional', 'numerical', 'integerOnly'=>true),
			array('nombre_dato_adicional', 'length', 'max'=>250),
			array('valor_dato_adicional', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_instancia_dato_adicional, id_proceso_dato_adicional, id_instancia_proceso, nombre_dato_adicional, tipo_dato_adicional, valor_dato_adicional', 'safe', 'on'=>'search'),
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
			'id_instancia_dato_adicional' => 'Id Instancia Dato Adicional',
			'id_proceso_dato_adicional' => 'Id Proceso Dato Adicional',
			'id_instancia_proceso' => 'Id Instancia Proceso',
			'nombre_dato_adicional' => 'Nombre Dato Adicional',
			'tipo_dato_adicional' => 'Tipo Dato Adicional',
			'valor_dato_adicional' => 'Valor Dato Adicional',
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

		$criteria->compare('id_instancia_dato_adicional',$this->id_instancia_dato_adicional);
		$criteria->compare('id_proceso_dato_adicional',$this->id_proceso_dato_adicional);
		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
		$criteria->compare('nombre_dato_adicional',$this->nombre_dato_adicional,true);
		$criteria->compare('tipo_dato_adicional',$this->tipo_dato_adicional);
		$criteria->compare('valor_dato_adicional',$this->valor_dato_adicional,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisInstanciaDatoAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
