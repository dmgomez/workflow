<?php

/**
 * This is the model class for table "inmueble".
 *
 * The followings are the available columns in table 'inmueble':
 * @property integer $id_inmueble
 * @property string $direccion_inmueble
 * @property integer $id_parroquia
 *
 * The followings are the available model relations:
 * @property Parroquia $idParroquia
 */
class Inmueble extends CActiveRecord
{
	const titulo = "Inmueble";
    const tituloPlural = "Inmuebles";
    const sexo = "m";

    public $_municipio;

    private $_nombreParroquia;
	
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
		return 'inmueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('direccion_inmueble, id_parroquia', 'required'),
			array('id_parroquia', 'numerical', 'integerOnly'=>true),
			array('direccion_inmueble', 'length', 'max'=>500),
			array('direccion_inmueble', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑº,.:-\s]+$/', 'message' => 'Dirección Inmueble inválida. Sólo se permiten los siguientes caracteres espciales: , . - º :'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_inmueble, direccion_inmueble, id_parroquia, nombreParroquia', 'safe', 'on'=>'search'),
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
			'idParroquia' => array(self::BELONGS_TO, 'Parroquia', 'id_parroquia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_inmueble' => 'Id Inmueble',
			'direccion_inmueble' => 'Dirección del Inmueble',
			'id_parroquia' => 'Parroquia',
			'_municipio' => 'Municipio',
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
		$criteria->with = array("idParroquia"=>array('alias' => 'parroquia'));

		$criteria->compare('id_inmueble',$this->id_inmueble);
		$criteria->addSearchCondition('LOWER(direccion_inmueble)',strtolower($this->direccion_inmueble),true);
		$criteria->addSearchCondition('LOWER(parroquia.nombre_parroquia)',strtolower($this->nombreParroquia),true);
		//$criteria->compare('id_parroquia',$this->id_parroquia);

		$sort = new CSort();
		$sort->attributes = array(

		    'direccion_inmueble'=>array(
		        'asc'=>'direccion_inmueble',
		        'desc'=>'direccion_inmueble desc',
		    ),
		    'nombreParroquia'=>array(
		        'asc'=>'parroquia.nombre_parroquia',
		        'desc'=>'parroquia.nombre_parroquia desc',
		    ),
		);

		$sort->defaultOrder = 'direccion_inmueble ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function getnombreParroquia(){

	    if ($this->_nombreParroquia === null && $this->idParroquia !== null){

	        $this->_nombreParroquia = $this->idParroquia->nombre_parroquia;
	    }

	    return $this->_nombreParroquia;
	}

	public function setnombreParroquia($value){

		$this->_nombreParroquia = $value;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inmueble the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
