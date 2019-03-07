<?php

/**
 * This is the model class for table "tipo_dato".
 *
 * The followings are the available columns in table 'tipo_dato':
 * @property integer $id_tipo_dato
 * @property string $nombre_tipo_dato
 * @property integer $es_lista
 *
 * The followings are the available model relations:
 * @property ItemLista[] $itemListas
 */
class TipoDato extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_dato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_tipo_dato', 'required'),
			array('es_lista', 'numerical', 'integerOnly'=>true),
			array('nombre_tipo_dato', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tipo_dato, nombre_tipo_dato, es_lista', 'safe', 'on'=>'search'),
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
			'itemListas' => array(self::HAS_MANY, 'ItemLista', 'id_tipo_dato'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tipo_dato' => 'Id Tipo Dato',
			'nombre_tipo_dato' => 'Nombre Tipo Dato',
			'es_lista' => 'Es Lista',
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

		$criteria->compare('id_tipo_dato',$this->id_tipo_dato);
		$criteria->addSearchCondition('LOWER(nombre_tipo_dato)',strtolower($this->nombre_tipo_dato),true);
		$criteria->compare('es_lista',$this->es_lista);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function esLista()
	{
		if($this->es_lista == 1)
		{
			return "Sí";
		}
		else
		{
			return "No";
		}
	}

	/*public function get_visibilidad_lista()
	{
		if($this->es_lista==1)
			return true;
		else
			return false;
	}*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoDato the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
