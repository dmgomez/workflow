<?php

/**
 * This is the model class for table "rol".
 *
 * The followings are the available columns in table 'rol':
 * @property integer $id_rol
 * @property string $nombre_rol
 * @property string $descripcion_rol
 *
 * The followings are the available model relations:
 * @property EmpleadoRol[] $empleadoRols
 * @property ActividadRol[] $actividadRols
 */
class Rol extends CActiveRecord
{
	private $_actividadesAsociadas;
	private $_empleadosAsociados;

	const titulo = "Rol";
    const tituloPlural = "Roles";
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
		return 'rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_rol, descripcion_rol', 'required'),
			array('nombre_rol', 'length', 'max'=>300),
			array('nombre_rol', 'unique', 'message'=>'Este rol ya eatá registrado.'),
			array('nombre_rol', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\s]+$/', 'message' => 'Nombre Rol inválido. Sólo se permiten caracteres alfanuméricos'),
			array('descripcion_rol', 'length', 'max'=>500),
			array('descripcion_rol', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/,.:\-\s]+$/', 'message' => 'Descripción Rol inválida. Sólo se permiten los siguientes caracteres espciales: / , . - :.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_rol, nombre_rol, descripcion_rol', 'safe', 'on'=>'search'),
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
			'empleadoRols' => array(self::HAS_MANY, 'EmpleadoRol', 'id_rol'),
			'actividadRols' => array(self::HAS_MANY, 'ActividadRol', 'id_rol'),
			'actividad'=>array(self::MANY_MANY, 'Actividad', 'actividad_rol(id_actividad, id_rol)'),
			'empleado'=>array(self::MANY_MANY, 'Empleado', 'empleado_rol(id_empleado, id_rol)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_rol' => 'Id Rol',
			'nombre_rol' => 'Nombre Rol',
			'descripcion_rol' => 'Descripción Rol',
			'_actividadesAsociadas' => 'Actividades Vinculadas',
			'_empleadosAsociados' => 'Empleados Vinculados',
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

		$criteria->compare('id_rol',$this->id_rol);
		$criteria->addSearchCondition('LOWER(nombre_rol)',strtolower($this->nombre_rol),true);
		$criteria->compare('LOWER(descripcion_rol)',strtolower($this->descripcion_rol),true);

		$sort = new CSort();
		$sort->defaultOrder = 'nombre_rol ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function get_actividadesAsociadas()
	{
	    if ($this->_actividadesAsociadas === null)
		{	
		    foreach ($this->actividad as $value) 
			{
				
				$this->_actividadesAsociadas = $this->_actividadesAsociadas.', '.$value->nombre_actividad;

			}

			$this->_actividadesAsociadas = substr($this->_actividadesAsociadas, 2);
		}

	    return $this->_actividadesAsociadas;
	}

	public function get_empleadosAsociados()
	{
	    if ($this->_empleadosAsociados === null)
		{	
		    foreach ($this->empleado as $value) 
			{
				$nombre=Persona::model()->findByPk($value->id_persona);
				$cargo=Cargo::model()->findByPk($value->id_cargo);
				$this->_empleadosAsociados = $this->_empleadosAsociados.', '.$nombre->nombre_persona.' '.$nombre->apellido_persona.' ('.$cargo->nombre_cargo.')';
			}

			$this->_empleadosAsociados = substr($this->_empleadosAsociados, 2);
		}

	    return $this->_empleadosAsociados;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
