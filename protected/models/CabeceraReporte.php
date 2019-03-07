<?php

/**
 * This is the model class for table "cabecera_reporte".
 *
 * The followings are the available columns in table 'cabecera_reporte':
 * @property integer $id_cabecera_reporte
 * @property string $ubicacion_logo
 * @property string $titulo_reporte
 * @property string $subtitulo_1
 * @property string $subtitulo_2
 * @property string $subtitulo_3
 * @property string $subtitulo_4
 * @property string $alineacion_titulos
 */
class CabeceraReporte extends CActiveRecord
{
	public $_imagenLogo;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cabecera_reporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('_imagenLogo, ubicacion_logo, alineacion_titulos', 'required'),
			array('ubicacion_logo', 'length', 'max'=>200),
			array('titulo_reporte, subtitulo_1, subtitulo_2, subtitulo_3, subtitulo_4', 'length', 'max'=>500),
			array('alineacion_titulos', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cabecera_reporte, ubicacion_logo, titulo_reporte, subtitulo_1, subtitulo_2, subtitulo_3, subtitulo_4, alineacion_titulos', 'safe', 'on'=>'search'),
			array('_imagenLogo','file','types'=>'jpg, jpeg, png'),
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
			'id_cabecera_reporte' => 'Cabecera Reporte',
			'ubicacion_logo' => 'Ubicacion Logo',
			'titulo_reporte' => 'Título Reporte',
			'subtitulo_1' => 'Subtítulo 1',
			'subtitulo_2' => 'Subtítulo 2',
			'subtitulo_3' => 'Subtítulo 3',
			'subtitulo_4' => 'Subtítulo 4',
			'imagenLogo' => 'Imagen Logo',	
			'alineacion_titulos' => 'Alineación Títulos',
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

		$criteria->compare('id_cabecera_reporte',$this->id_cabecera_reporte);
		$criteria->compare('ubicacion_logo',$this->ubicacion_logo,true);
		$criteria->compare('titulo_reporte',$this->titulo_reporte,true);
		$criteria->compare('subtitulo_1',$this->subtitulo_1,true);
		$criteria->compare('subtitulo_2',$this->subtitulo_2,true);
		$criteria->compare('subtitulo_3',$this->subtitulo_3,true);
		$criteria->compare('subtitulo_4',$this->subtitulo_4,true);
		$criteria->compare('alineacion_titulos',$this->alineacion_titulos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CabeceraReporte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
