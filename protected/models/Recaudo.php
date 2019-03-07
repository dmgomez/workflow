<?php

/**
 * This is the model class for table "recaudo".
 *
 * The followings are the available columns in table 'recaudo':
 * @property integer $id_recaudo
 * @property integer $id_actividad
 * @property string $nombre_recaudo
 *
 * The followings are the available model relations:
 * @property Actividad $idActividad
 * @property InstanciaRecaudo[] $instanciaRecaudos
 */
class Recaudo extends CActiveRecord
{

	public $tit;

	public $_checkRecaudos;
	public $_recaudos_faltantes;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recaudo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_recaudo', 'required'),
			array('nombre_recaudo', 'length', 'max'=>300),
			array('nombre_recaudo', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.():\-\s]+$/', 'message' => 'Nombre Recaudo inválido. Sólo se permiten los siguientes caracteres espciales: # º , . - : ( )'),
			array('nombre_recaudo','ValidarNombreRecaudo', 'on'=>array('insert', 'update')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_recaudo, nombre_recaudo', 'safe', 'on'=>'search'),
		);
	}

	/*
	* Valida que el nombre del recaudo no este repetido.
	*/
	public function ValidarNombreRecaudo($attribute){

		$recaudo = Recaudo::model()->find("LOWER(nombre_recaudo)='".strtolower($this->nombre_recaudo)."'");

		if($recaudo  && $this->id_recaudo!=$recaudo->id_recaudo )
		{
			$this->addError($attribute,"Recaudo ya registrado.");
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'instanciaRecaudos' => array(self::HAS_MANY, 'InstanciaRecaudo', 'id_recaudo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_recaudo' => 'Id Recaudo',
			'nombre_recaudo' => 'Nombre Recaudo',
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

		$criteria->compare('id_recaudo',$this->id_recaudo);
		$criteria->addSearchCondition('LOWER(nombre_recaudo)',strtolower($this->nombre_recaudo),true);

		$sort = new CSort();
		$sort->defaultOrder = 'nombre_recaudo ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recaudo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
