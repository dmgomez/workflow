<?php

/**
 * This is the model class for table "proceso_dato_adicional".
 *
 * The followings are the available columns in table 'proceso_dato_adicional':
 * @property integer $id_proceso_dato_adicional
 * @property integer $id_proceso
 * @property integer $id_dato_adicional
 * @property integer $obligatorio
 *
 * The followings are the available model relations:
 * @property Proceso $idProceso
 * @property DatoAdicional $idDatoAdicional
 */
class ProcesoDatoAdicional extends CActiveRecord
{
	private $_nombreDatoAdicional;
	private $_tipoDatoAdicional;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proceso_dato_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_proceso, id_dato_adicional, nombreDatoAdicional, tipoDatoAdicional', 'required'),
			array('id_proceso, id_dato_adicional, orden', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_proceso_dato_adicional, id_proceso, id_dato_adicional, nombreDatoAdicional, tipoDatoAdicional, orden', 'safe', 'on'=>'search'),
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
			'idProceso' => array(self::BELONGS_TO, 'Proceso', 'id_proceso'),
			'idDatoAdicional' => array(self::BELONGS_TO, 'DatoAdicional', 'id_dato_adicional'),

			'datoActividads' => array(self::HAS_MANY, 'DatoActividad', 'id_proceso_dato_adicional'),
            'instanciaDatoAdicionals' => array(self::HAS_MANY, 'InstanciaDatoAdicional', 'id_proceso_dato_adicional'),
            'datoActividadTransicions' => array(self::HAS_MANY, 'DatoActividadTransicion', 'id_proceso_dato_adicional'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_proceso_dato_adicional' => 'Id Proceso Dato Adicional',
			'id_proceso' => 'Id Proceso',
			'id_dato_adicional' => 'Id Dato Adicional',
			'nombreDatoAdicional' => 'Nombre Dato Adicional',
			'tipoDatoAdicional' => 'Tipo',
			'orden' => 'Orden',
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
		$criteria->with = array("idDatoAdicional"=>array('alias' => 'datoadicional'));

		$criteria->compare('id_proceso_dato_adicional',$this->id_proceso_dato_adicional);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('id_dato_adicional',$this->id_dato_adicional);
		$criteria->addSearchCondition('LOWER(datoadicional.nombre_dato_adicional)',strtolower($this->nombreDatoAdicional),true);
		$criteria->addSearchCondition('LOWER(datoadicional.tipoDatoAdicional())', strtolower($this->tipoDatoAdicional),true);

		$sort = new CSort();
		$sort->attributes = array(

		    'nombreDatoAdicional'=>array(
		        'asc'=>'datoadicional.nombre_dato_adicional',
		        'desc'=>'datoadicional.nombre_dato_adicional desc',
		    ),
		    'tipoDatoAdicional'=>array(
		        'asc'=>'datoadicional.tipoDatoAdicional()',
		        'desc'=>'datoadicional.tipoDatoAdicional() desc',
		    ),

		);

		$sort->defaultOrder = 'datoadicional.nombre_dato_adicional ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function getnombreDatoAdicional(){

	    if ($this->_nombreDatoAdicional === null && $this->idDatoAdicional !== null){

	        $this->_nombreDatoAdicional = $this->idDatoAdicional->nombre_dato_adicional;
	    }

	    return $this->_nombreDatoAdicional;
	}

	public function setnombreDatoAdicional($value){

		$this->_nombreDatoAdicional = $value;
	}

	public function gettipoDatoAdicional(){

	    if ($this->_tipoDatoAdicional === null && $this->idDatoAdicional !== null){

	        $this->_tipoDatoAdicional = $this->idDatoAdicional->tipoDatoAdicional();
	    }

	    return $this->_tipoDatoAdicional;
	}

	public function settipoDatoAdicional($value){

		$this->_tipoDatoAdicional = $value;
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcesoDatoAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
