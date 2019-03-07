<?php

/**
 * This is the model class for table "organizacion".
 *
 * The followings are the available columns in table 'organizacion':
 * @property integer $id_organizacion
 * @property string $nombre_organizacion
 * @property string $rif_organizacion
 * @property string $direccion_organizacion
 * @property string $telefono_organizacion
 * @property string $correo_organizacion
 * @property string $web_organizacion
 *
 * The followings are the available model relations:
 * @property Departamento[] $departamentos
 */
class Organizacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'organizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_organizacion, rif_organizacion, prefijo_rif, direccion_organizacion, telefono_organizacion', 'required'),
			array('nombre_organizacion', 'length', 'max'=>300),
			array('nombre_organizacion', 'unique', 'message' => 'Nombre Organización ya registrado.'),
			array('nombre_organizacion', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/´&,.:\-\s]+$/', 'message' => 'Nombre Organización inválido. Sólo se permiten los siguientes caracteres espciales: ´ / & , . - :.'),
			array('rif_organizacion', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{9}$/', 'message' => 'Rif Organización debe ser de 9 caracteres numéricos.'),
			array('direccion_organizacion', 'length', 'max'=>500),
			array('direccion_organizacion', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$/', 'message' => 'Dirección Organización inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :'),
			array('telefono_organizacion, correo_organizacion', 'length', 'max'=>50), 
			array('telefono_organizacion', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Telefono Organización debe ser de 11 caracteres numéricos.'),
			array('correo_organizacion', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9ñÑ_.@-]+$/', 'message' => 'Correo Organización inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @'),
			array('web_organizacion', 'length', 'max'=>100),
			array('web_organizacion', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9ñÑ_.&\/-]+$/', 'message' => 'Correo Organización inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_organizacion, nombre_organizacion, rif_organizacion, direccion_organizacion, telefono_organizacion, correo_organizacion, web_organizacion', 'safe', 'on'=>'search'),
		);
	}

	/**	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'departamentos' => array(self::HAS_MANY, 'Departamento', 'id_organizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_organizacion' => 'Id Organización',
			'nombre_organizacion' => 'Nombre Organización',
			'rif_organizacion' => 'Rif Organización',
			'direccion_organizacion' => 'Direccion Organización',
			'telefono_organizacion' => 'Telefono Organización',
			'correo_organizacion' => 'Correo Organización',
			'web_organizacion' => 'Web Organización',
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

		$criteria->compare('id_organizacion',$this->id_organizacion);
		$criteria->compare('LOWER(nombre_organizacion)',strtolower($this->nombre_organizacion),true);
		$criteria->compare('rif_organizacion',$this->rif_organizacion,true);
		$criteria->compare('LOWER(direccion_organizacion)',strtolower($this->direccion_organizacion),true);
		$criteria->compare('telefono_organizacion',$this->telefono_organizacion,true);
		$criteria->compare('LOWER(correo_organizacion)',strtolower($this->correo_organizacion),true);
		$criteria->compare('LOWER(web_organizacion)',strtolower($this->web_organizacion),true);

		$sort = new CSort();

		$sort->defaultOrder = 'prefijo_rif DESC, rif_organizacion ASC';


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function getRifCompleto()
	{
		return $this->prefijo_rif . "-". $this->rif_organizacion;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Organizacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
