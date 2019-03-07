<?php

/**
 * This is the model class for table "departamento".
 *
 * The followings are the available columns in table 'departamento':
 * @property integer $id_departamento
 * @property integer $id_organizacion
 * @property string $nombre_departamento
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property Empleado[] $empleados
 * @property Organizacion $organizacion
 */
class Departamento extends CActiveRecord
{
	private $_activo;
	public $tit;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'departamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_organizacion, nombre_departamento, activo', 'required'),
			array('id_organizacion, activo, id_departamento_rel', 'numerical', 'integerOnly'=>true),
			array('nombre_departamento', 'length', 'max'=>300),
			array('nombre_departamento', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/&,.:\-\s]+$/', 'message' => 'Nombre Departamento inválido. Sólo se permiten los siguientes caracteres espciales: / & , . - :'),
			array('nombre_departamento','validar_nombreDepartamento','on'=>array('insert'/*, 'update'*/)),
			//array('nombre_departamento','validar_nombreDepartamento','on'=>array('update')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_departamento, id_organizacion, id_departamento_rel, nombre_departamento, activo', 'safe', 'on'=>'search'),
		);
	}

	public function validar_nombreDepartamento($attribute)
	{
		if($this->id_departamento_rel!="" && $this->id_departamento_rel!=null)
			$buscar_departamento=Departamento::model()->findByAttributes(array('nombre_departamento'=>$this->nombre_departamento, 'id_organizacion'=>$this->id_organizacion, 'id_departamento_rel'=>$this->id_departamento_rel));
		else
			$buscar_departamento=Departamento::model()->findByAttributes(array('nombre_departamento'=>$this->nombre_departamento, 'id_organizacion'=>$this->id_organizacion));

		if($buscar_departamento && $buscar_departamento->id_departamento_rel==$this->id_departamento_rel && $buscar_departamento->id_departamento!=$this->id_departamento)
			$this->addError($attribute, "Nombre Departamento ya registrado.");
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'empleados' => array(self::HAS_MANY, 'Empleado', 'id_departamento'),
			'organizacion' => array(self::BELONGS_TO, 'Organizacion', 'id_organizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_departamento' => 'Id Departamento',
			'id_organizacion' => 'Organización',
			'nombre_departamento' => 'Nombre Departamento - Subdepartamento',
			'activo' => 'Activo',
			'id_departamento_rel' => 'Departamento al que Pertenece',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id_departamento',$this->id_departamento);
		$criteria->with =array('organizacion');
		$criteria->addSearchCondition('LOWER(organizacion.nombre_organizacion)', strtolower($this->id_organizacion));
		$criteria->addSearchCondition('LOWER(nombre_departamento)',strtolower($this->nombre_departamento),true);
		$criteria->compare('id_departamento_rel',$this->id_departamento_rel);

		$sort = new CSort();
		$sort->defaultOrder = 'organizacion.nombre_organizacion ASC, nombre_departamento ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function getNombreDepartamentoRel()
	{
		$dep=Departamento::model()->findByPk($this->id_departamento_rel);

		if($dep)
	    	return $dep->nombre_departamento;
	}

	public function get_activo()
	{

	    if ($this->activo == 1) {

	        $this->_activo = 'SI';
	    }
	    else
	    {
	    	$this->_activo = 'NO';
	    }

	    return $this->_activo;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Departamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
