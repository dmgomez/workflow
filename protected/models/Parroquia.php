<?php

/**
 * This is the model class for table "parroquia".
 *
 * The followings are the available columns in table 'parroquia':
 * @property integer $id_parroquia
 * @property integer $id_municipio
 * @property string $nombre_parroquia
 *
 * The followings are the available model relations:
 * @property Municipio $idMunicipio
 * @property Inmueble[] $inmuebles
 */
class Parroquia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'parroquia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_municipio, nombre_parroquia', 'required'),
			array('id_municipio', 'numerical', 'integerOnly'=>true),
			array('nombre_parroquia', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_parroquia, id_municipio, nombre_parroquia', 'safe', 'on'=>'search'),
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
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'inmuebles' => array(self::HAS_MANY, 'Inmueble', 'id_parroquia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_parroquia' => 'Id Parroquia',
			'id_municipio' => 'Id Municipio',
			'nombre_parroquia' => 'Nombre Parroquia',
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

		$criteria->compare('id_parroquia',$this->id_parroquia);
		$criteria->compare('id_municipio',$this->id_municipio);
		$criteria->compare('nombre_parroquia',$this->nombre_parroquia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Parroquia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
