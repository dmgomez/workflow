<?php

/**
 * This is the model class for table "proceso".
 *
 * The followings are the available columns in table 'proceso':
 * @property integer $id_proceso
 * @property string $codigo_proceso
 * @property string $nombre_proceso
 * @property string $descripcion_proceso
 *
 * The followings are the available model relations:
 * @property ModeloActividad[] $modeloActividads
 * @property InstanciaProceso[] $instanciaProcesos
 */
class Proceso extends CActiveRecord
{
	public $_idProcesoCopia = 0;

	/**
	 * @return string the associated database table name
	 */

	private $_tieneReconsideracion;

	public function tableName()
	{
		return 'proceso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_organizacion, _idProcesoCopia, codigo_proceso, nombre_proceso, descripcion_proceso', 'required'),
			array('id_organizacion, _idProcesoCopia', 'numerical', 'integerOnly'=>true),
			array('codigo_proceso', 'length', 'max'=>15),
			array('nombre_proceso', 'length', 'max'=>300),
			array('nombre_proceso', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$/', 'message' => 'Nombre Proceso inválido. Sólo se permiten los siguientes caracteres espciales: # º , . - :'),
			array('descripcion_proceso', 'length', 'max'=>500),
			array('descripcion_proceso', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$/', 'message' => 'Descripción Proceso inválida. Sólo se permiten los siguientes caracteres espciales: # º , . - :'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_proceso, id_organizacion, codigo_proceso, nombre_proceso, descripcion_proceso, _idProcesoCopia', 'safe', 'on'=>'search'),
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
			'organizacion' => array(self::BELONGS_TO, 'Organizacion', 'id_organizacion'),
			//'modeloActividad' => array(self::HAS_MANY, 'ModeloActividad', 'id_proceso'),
			'instanciaProceso' => array(self::HAS_MANY, 'InstanciaProceso', 'id_proceso'),
			'actividads' => array(self::HAS_MANY, 'Actividad', 'id_proceso'),
			'procesoDatoAdicionals' => array(self::HAS_MANY, 'ProcesoDatoAdicional', 'id_proceso'),
            'procesoRecaudos' => array(self::HAS_MANY, 'ProcesoRecaudo', 'id_proceso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_proceso' => 'Id Proceso',
			'id_organizacion' => 'Organización',
			'codigo_proceso' => 'Código',
			'nombre_proceso' => 'Nombre',
			'descripcion_proceso' => 'Descripción',
			'_idProcesoCopia' => 'Proceso a Copiar',
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

		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->with =array('organizacion');
		$criteria->addSearchCondition('LOWER(organizacion.nombre_organizacion)', strtolower($this->id_organizacion));
		$criteria->addSearchCondition('LOWER(codigo_proceso)', strtolower($this->codigo_proceso),true);
		$criteria->addSearchCondition('LOWER(nombre_proceso)', strtolower($this->nombre_proceso),true);
		$criteria->addSearchCondition('LOWER(descripcion_proceso)', strtolower($this->descripcion_proceso),true);
		$criteria->order ='organizacion.nombre_organizacion, codigo_proceso';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search2($idProc)
	{
		if($idProc && $idProc!="")
		{
			$idP=explode(',', $idProc);

			$condition="";
			foreach($idP as $key => $value) 
			{
				$condition.="id_proceso = ".$value." or ";
			}
			$condition=substr($condition, 0, -3);
		}
		else
			$condition="id_proceso = -1";

		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->with =array('organizacion');
		$criteria->addSearchCondition('LOWER(organizacion.nombre_organizacion)', strtolower($this->id_organizacion));
		$criteria->compare('LOWER(codigo_proceso)',strtolower($this->codigo_proceso),true);
		$criteria->addSearchCondition('LOWER(nombre_proceso)',strtolower($this->nombre_proceso),true);
		$criteria->addSearchCondition('LOWER(descripcion_proceso)',strtolower($this->descripcion_proceso),true);
		$criteria->addCondition($condition);

		$sort = new CSort();
		$sort->defaultOrder = 'codigo_proceso ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Proceso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
