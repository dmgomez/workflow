<?php

/**
 * This is the model class for table "instancia_proceso".
 *
 * The followings are the available columns in table 'instancia_proceso':
 * @property integer $id_instancia_proceso
 * @property integer $id_proceso
 * @property integer $id_usuario
 * @property string $codigo_instancia_proceso
 * @property string $tag_instancia_proceso
 * @property string $observacion_instancia_proceso
 * @property integer $id_estado_instancia_proceso
 * @property integer $solicitante_persona
 * @property integer $solicitante_empresa
 * @property integer $tipo_solicitante
 *
 * The followings are the available model relations:
 * @property EstadoInstanciaProceso $idEstadoInstanciaProceso
 * @property Proceso $idProceso
 * @property Usuario $idUsuario
 * @property Persona $solicitantePersona
 * @property Empresa $solicitanteEmpresa
 * @property InstanciaActividad[] $instanciaActividads
 */
class InstanciaProcesoAnular extends CActiveRecord
{
	const titulo = "Iniciar Trámite";
    const tituloPlural = "Iniciar Trámites";
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
		return 'instancia_proceso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('observacion_anulacion, fecha_anulacion, hora_anulacion', 'required'),
			array('id_estado_instancia_proceso', 'numerical', 'integerOnly'=>true),
			array('observacion_anulacion', 'length', 'max'=>1000),
			array('observacion_anulacion', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$/', 'message' => 'Observaciones de la Anulación del Proceso inválida. Sólo se permiten los siguientes caracteres espciales: # º , . - :'),

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
			'idEstadoInstanciaProceso' => array(self::BELONGS_TO, 'EstadoInstanciaProceso', 'id_estado_instancia_proceso'),
			'idProceso' => array(self::BELONGS_TO, 'Proceso', 'id_proceso'),
			'idUsuario' => array(self::BELONGS_TO, 'Usuario', 'id_usuario'),
			'solicitantePersona' => array(self::BELONGS_TO, 'Persona', 'solicitante_persona'),
			'solicitanteEmpresa' => array(self::BELONGS_TO, 'Empresa', 'solicitante_empresa'),
			'instanciaActividads' => array(self::HAS_MANY, 'InstanciaActividad', 'id_instancia_proceso'),
			'idInmueble' => array(self::BELONGS_TO, 'Inmueble', 'id_inmueble'),

			'instanciaRecaudos' => array(self::HAS_MANY, 'InstanciaRecaudo', 'id_instancia_proceso'),
            'instanciaDatoAdicionals' => array(self::HAS_MANY, 'InstanciaDatoAdicional', 'id_instancia_proceso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observacion_anulacion' => 'Observaciones de la Anulación del Proceso',
		);
	}




	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InstanciaProceso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
