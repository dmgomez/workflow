<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property integer $id_persona
 * @property string $nombre_persona
 * @property string $apellido_persona
 * @property string $nacionalidad_persona
 * @property string $cedula_persona
 * @property string $direccion_persona
 * @property string $telefono_hab_persona
 * @property string $telefono_cel_persona
 * @property string $telefono_aux_persona
 *
 * The followings are the available model relations:
 * @property Empleado[] $empleados
 */
class Persona extends CActiveRecord
{
	const titulo = "Persona";
    const tituloPlural = "Personas";
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
		return 'persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_persona, apellido_persona, nacionalidad_persona, cedula_persona, telefono_cel_persona', 'required'),
			array('nombre_persona, apellido_persona, correo_persona', 'length', 'max'=>50),
			array('nombre_persona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-ZñÑáéíóúñÁÉÍÓÚÑ\s]+$/', 'message' => 'Nombre inválido. Sólo se permiten caracteres alfabéticos.'),
			array('apellido_persona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-ZñÑáéíóúñÁÉÍÓÚÑ\s]+$/', 'message' => 'Apellido inválido. Sólo se permiten caracteres alfabéticos.'),
			array('nacionalidad_persona', 'length', 'max'=>1),
			array('cedula_persona, telefono_hab_persona, telefono_cel_persona, telefono_aux_persona', 'length', 'max'=>15),
			array('cedula_persona','validar_cedula','on'=>array('insert', 'update')),
			//array('cedula_persona', 'unique', 'message'=>'Cédula ya registrada.'),
			array('direccion_persona', 'length', 'max'=>500),
			array('direccion_persona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:-\s]+$/', 'message' => 'Dirección inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :'),
			array('telefono_hab_persona', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Teléfono Hab. debe ser de 11 caracteres numéricos.'),
			array('telefono_cel_persona', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Teléfono Cel. debe ser de 11 caracteres numéricos.'),
			array('telefono_aux_persona', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]{11}$/', 'message' => 'Teléfono Aux. debe ser de 11 caracteres numéricos.'),			
			array('correo_persona', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9ñÑ_.@-]+$/', 'message' => 'Correo Electrónico inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_persona, nombre_persona, apellido_persona, nacionalidad_persona, cedula_persona, direccion_persona, telefono_hab_persona, telefono_cel_persona, telefono_aux_persona', 'safe', 'on'=>'search'),
		);
	}

	public function validar_cedula($attribute)
	{
		if($this->cedula_persona!="")
		{
			if($this->nacionalidad_persona == "V")
			{
				if( !preg_match('/^[0-9]{6,8}$/', $this->cedula_persona))
					$this->addError($attribute,"Cédula inválida. Mínimo 6 y máximo 8 caracteres numéricos para cédulas venezolanas.");
			}			
			elseif($this->nacionalidad_persona == "E")
			{	
				if( !preg_match('/^[0-9]{6,15}$/', $this->cedula_persona))
					$this->addError($attribute,"Cédula inválida. Mínimo 6 y máximo 15 caracteres numéricos para cédulas extranjeras.");
			}
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
			'instanciaProcesos' => array(self::HAS_MANY, 'InstanciaProceso', 'solicitante_persona'),
			'empleados' => array(self::HAS_MANY, 'Empleado', 'id_persona'),
			'empresas' => array(self::HAS_MANY, 'Empresa', 'id_persona_representante'),
			'usuarioPersonas' => array(self::HAS_MANY, 'UsuarioPersona', 'id_persona'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_persona' => 'Id Persona',
			'nombre_persona' => 'Nombre',
			'apellido_persona' => 'Apellido',
			'nacionalidad_persona' => 'Nacionalidad',
			'cedula_persona' => 'Cédula',
			'direccion_persona' => 'Dirección',
			'telefono_hab_persona' => 'Teléfono Hab.',
			'telefono_cel_persona' => 'Teléfono Cel.',
			'telefono_aux_persona' => 'Teléfono Aux.',
			'correo_persona' => 'Correo Electrónico',
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

		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('LOWER(nombre_persona)',strtolower($this->nombre_persona),true);
		$criteria->compare('LOWER(apellido_persona)',strtolower($this->apellido_persona),true);
		//$criteria->compare('nacionalidad_persona',$this->nacionalidad_persona,true);
		$criteria->compare('cedula_persona',$this->cedula_persona,true);
		$criteria->compare('LOWER(direccion_persona)',strtolower($this->direccion_persona),true);
		$criteria->compare('telefono_hab_persona',$this->telefono_hab_persona,true);
		$criteria->compare('telefono_cel_persona',$this->telefono_cel_persona,true);
		$criteria->compare('telefono_aux_persona',$this->telefono_aux_persona,true);

		$sort = new CSort();
		$sort->defaultOrder = 'nacionalidad_persona DESC, cedula_persona ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
	
	public function getCedulaCompleta()
	{
		return $this->nacionalidad_persona . "-". $this->cedula_persona;
	}

	public function getNombreCompleto()
	{
		return $this->nombre_persona . " ". $this->apellido_persona;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Persona the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
