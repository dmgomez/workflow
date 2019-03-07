<?php

/**
 * This is the model class for table "item_lista".
 *
 * The followings are the available columns in table 'item_lista':
 * @property integer $id_item_lista
 * @property integer $id_tipo_dato
 * @property string $nombre_item_lista
 *
 * The followings are the available model relations:
 * @property TipoDato $idTipoDato
 */
class ItemLista extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_lista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_dato_adicional, nombre_item_lista', 'required'),
			array('id_dato_adicional', 'numerical', 'integerOnly'=>true),
			array('nombre_item_lista', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_item_lista, id_dato_adicional, nombre_item_lista', 'safe', 'on'=>'search'),
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
			'idDatoAdicional' => array(self::BELONGS_TO, 'DatoAdicional', 'id_dato_adicional'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_item_lista' => 'Id Item Lista',
			'id_dato_adicional' => 'Id Tipo Dato',
			'nombre_item_lista' => 'Nombre Item',
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

		$criteria->compare('id_item_lista',$this->id_item_lista);
		$criteria->compare('id_dato_adicional',$this->id_dato_adicional);
		$criteria->compare('nombre_item_lista',$this->nombre_item_lista,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemLista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
