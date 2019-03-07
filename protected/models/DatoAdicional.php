<?php

/**
 * This is the model class for table "dato_adicional".
 *
 * The followings are the available columns in table 'dato_adicional':
 * @property integer $id_dato_adicional
 * @property integer $id_actividad
 * @property string $nombre_dato_adicional
 * @property integer $tipo_dato_adicional
 * @property integer $obligatorio
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property InstanciaDatoAdicionall[] $instanciaDatoAdicionalls
 * @property Proceso $idProceso
 */
class DatoAdicional extends CActiveRecord
{

	public $tit;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dato_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_dato_adicional, tipo_dato_adicional, activo', 'required'),
			array('tipo_dato_adicional, activo', 'numerical', 'integerOnly'=>true),
			array('nombre_dato_adicional', 'length', 'max'=>250),
			array('nombre_dato_adicional','ValidarNombreDato', 'on'=>array('insert', 'update')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dato_adicional, nombre_dato_adicional, tipo_dato_adicional, activo', 'safe', 'on'=>'search'),
		);
	}

	/*
	* Valida que el nombre del dato adicional no este repetido.
	*/
	public function ValidarNombreDato($attribute){

		$dato = DatoAdicional::model()->find("LOWER(nombre_dato_adicional)='".strtolower($this->nombre_dato_adicional)."'");

		if($dato  && $this->id_dato_adicional!=$dato->id_dato_adicional )
		{
			$this->addError($attribute,"Dato adicional ya registrado.");
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
			'instanciaDatoAdicional' => array(self::HAS_MANY, 'InstanciaDatoAdicional', 'id_dato_adicional'),
            'tipoDatoAdicional' => array(self::BELONGS_TO, 'TipoDato', 'tipo_dato_adicional'),
            'itemListas' => array(self::HAS_MANY, 'ItemLista', 'id_dato_adicional'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_dato_adicional' => 'Dato Adicional',
			'nombre_dato_adicional' => 'Nombre del Dato',
			'tipo_dato_adicional' => 'Tipo de Dato',
			'activo' => 'Activo',
		);
	}

	public function tipoDatoAdicional()
	{
		return $this->tipoDatoAdicional->nombre_tipo_dato;
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
		$criteria->with = array("tipoDatoAdicional"=>array('alias' => 'tipodato'));

		$criteria->compare('id_dato_adicional',$this->id_dato_adicional);
		$criteria->addSearchCondition('LOWER(nombre_dato_adicional)',strtolower($this->nombre_dato_adicional),true);
		$criteria->addSearchCondition('LOWER(tipodato.nombre_tipo_dato)',strtolower($this->tipo_dato_adicional));
		$criteria->compare('activo',$this->activo);

		$sort = new CSort();
		$sort->defaultOrder = 'nombre_dato_adicional ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function get_visibilidad_lista()
	{
		if($this->tipoDatoAdicional->es_lista==1)
			return true;
		else
			return false;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DatoAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
