<?php

/**
 * This is the model class for table "estado_instancia_proceso".
 *
 * The followings are the available columns in table 'estado_instancia_proceso':
 * @property integer $id_estado_instancia_proceso
 * @property string $nombre_estado_instancia_proceso
 * @property string $descripcion_estado_instancia_pr
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property InstanciaProceso[] $instanciaProcesos
 */
class EstadoInstanciaProceso extends CActiveRecord
{
	private $_activo;

	const titulo = "Estado de Proceso";
    const tituloPlural = "Estados de Proceso";
    const sexo = "m";
	
	public static function getTitulo($articulo = false, $plural = false)
    {
        $pri = "";
        $seg = self::titulo;
        
        if ($articulo == true)
        {
            if (self::sexo == "f")
                $pri = Constantes::articulof. " ";
            else if (self::sexo == "m")
                $pri = Constantes::articulom. " ";
        }
        if ($plural == true)
        {
            $seg = self::tituloPlural;
            if ($articulo == true)
            {
                if (self::sexo == "f")
                    $pri = Constantes::articulosf. " ";
                else if (self::sexo == "m")
                    $pri = Constantes::articulosm. " ";
            }
        }
        return $pri . $seg;
        
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'estado_instancia_proceso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_estado_instancia_proceso, activo', 'required'),
			array('activo', 'numerical', 'integerOnly'=>true),
			array('nombre_estado_instancia_proceso', 'length', 'max'=>50),
			array('nombre_estado_instancia_proceso', 'unique', 'message'=>'Nombre Estado Proceso ya existente'),
			array('nombre_estado_instancia_proceso', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]+$/', 'message' => 'Nombre Estado Proceso inválido. Sólo se permiten caracteres alfanuméricos'),
			array('descripcion_estado_instancia_pr', 'length', 'max'=>200),
			array('descripcion_estado_instancia_pr', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/,.:\-\s]+$/', 'message' => 'Descripción Estado Proceso inválida. Sólo se permiten los siguientes caracteres espciales: / , . - :.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_estado_instancia_proceso, nombre_estado_instancia_proceso, descripcion_estado_instancia_pr, activo', 'safe', 'on'=>'search'),
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
			'instanciaProcesos' => array(self::HAS_MANY, 'InstanciaProceso', 'id_estado_instancia_proceso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_estado_instancia_proceso' => 'Id Estado Instancia Proceso',
			'nombre_estado_instancia_proceso' => 'Nombre Estado de Proceso',
			'descripcion_estado_instancia_pr' => 'Descripción Estado de Proceso',
			'activo' => 'Activo',
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

		$criteria->compare('id_estado_instancia_proceso',$this->id_estado_instancia_proceso);
		$criteria->addSearchCondition('LOWER(nombre_estado_instancia_proceso)',strtolower($this->nombre_estado_instancia_proceso),true);
		$criteria->addSearchCondition('LOWER(descripcion_estado_instancia_pr)',strtolower($this->descripcion_estado_instancia_pr),true);
		$criteria->compare('activo',$this->activo);

		$sort = new CSort();
		$sort->defaultOrder = 'nombre_estado_instancia_proceso ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
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
	 * @return EstadoInstanciaProceso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
