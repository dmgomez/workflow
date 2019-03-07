<?php

/**
 * This is the model class for table "actividad_rol".
 *
 * The followings are the available columns in table 'actividad_rol':
 * @property integer $id_actividad_rol
 * @property integer $id_rol
 * @property integer $id_actividad
 *
 * The followings are the available model relations:
 * @property Actividad $idActividad
 * @property Rol $idRol
 */
class ActividadRol extends CActiveRecord
{

	public $_proceso;
	public $_procesosVinculados;
	public $_actividad;
	public $_actividadesAsociadas;
	public $_seleccionadas;
	private $_nombreActividad;

	const titulo = "Actividad-Rol";
    const tituloPlural = "Actividades-Rol";
    const sexo = "f";

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
		return 'actividad_rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rol, id_actividad', 'required'),
			//array('id_rol, id_actividad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_actividad_rol, id_rol, id_actividad', 'safe', 'on'=>'search'),
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
			'idActividad' => array(self::BELONGS_TO, 'Actividad', 'id_actividad'),
			'idRol' => array(self::BELONGS_TO, 'Rol', 'id_rol'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_actividad_rol' => 'Actividad-Rol',
			'id_rol' => 'Rol',
			'id_actividad' => 'Actividad',
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
	public function search($idRol)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array("idActividad"=>array('alias' => 'actividad'));

		$criteria->compare('id_actividad_rol',$this->id_actividad_rol,true);
		$criteria->compare('id_rol',$this->id_rol,true);
		$criteria->compare('actividad.nombre_actividad',$this->nombreActividad,true);
		$criteria->condition='id_rol = '.$idRol;

		$sort = new CSort();
		$sort->attributes = array(

		    'nombreActividad'=>array(
		        'asc'=>'actividad.nombre_actividad',
		        'desc'=>'actividad.nombre_actividad desc',
		    ),
		);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));

	}


	/*SET redefinido para acceder a los campos virtuales agregados*/
	public function setactividadesAsociadas($value){

		$this->_actividadesAsociadas = $value;
	}

	public function getnombreActividad(){

	    if ($this->_nombreActividad === null && $this->idActividad !== null){

	        $this->_nombreActividad = $this->idActividad->nombre_actividad;
	    }

	    return $this->_nombreActividad;
	}

	/*SET redefinido para acceder a los campos virtuales agregados*/
	public function setnombreActividad($value){

		$this->_nombreActividad = $value;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActividadRol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
