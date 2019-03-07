<?php

/**
 * This is the model class for table "vis_instancia_actividad".
 *
 * The followings are the available columns in table 'vis_instancia_actividad':
 * @property integer $id_instancia_actividad
 * @property integer $id_instancia_proceso
 * @property string $codigo_instancia_proceso
 * @property string $codigo_proceso
 * @property string $nombre_proceso
 * @property string $descripcion_proceso
 * @property integer $consecutivo_actividad
 * @property string $fecha_ini_actividad
 * @property string $hora_ini_actividad
 * @property string $fecha_fin_actividad
 * @property string $hora_fin_actividad
 * @property integer $id_estado_actividad
 * @property string $nombre_estado_actividad
 * @property integer $id_empleado
 * @property integer $id_persona
 * @property string $cedula_persona
 * @property string $nombre_persona
 * @property string $apellido_persona
 * @property integer $id_actividad
 * @property string $codigo_actividad
 * @property string $nombre_actividad
 * @property string $fecha_ini_estado_actividad
 * @property string $hora_ini_estado_actividad
 * @property string $observacion_instancia_actividad
 * @property boolean $pendiente_asignacion
 * @property integer $ejecutada
 *
 * The followings are the available model relations:
 * @property Actividad $idActividad
 * @property Empleado $idEmpleado
 * @property EstadoActividad $idEstadoActividad
 * @property InstanciaProceso $idInstanciaProceso
 * @property InstanciaRecaudo[] $instanciaRecaudos
 * @property InstanciaDatoAdicionall[] $instanciaDatoAdicionalls
 * @property HistEstadoInstanciaActividad[] $histEstadoInstanciaActividads
 */
class VisInstanciaActividad extends CActiveRecord
{
	private $_observaciones;
	private $_image;
	private $nombreCompleto;
	private $_inTime;
	//private $_tiempo_restante;

	private $_fecha_estimada_fin;

	public $tit;

	//public $_archivo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_instancia_actividad';
	}

	//definición de la primaryKey en el modelo ya que se está generando a partir de un vista
	public function primaryKey()
	{
   		return 'id_instancia_actividad';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('array_datos_adicionales, valor_dato_adicional, observaciones, image', 'required'),
			array('valor_dato_adicional, observaciones, image', 'required'),
			array('id_instancia_actividad, id_instancia_proceso, consecutivo_actividad, id_estado_actividad, id_empleado, id_persona, id_actividad, ejecutada, dias, horas', 'numerical', 'integerOnly'=>true),
			array('codigo_instancia_proceso, nombre_persona, apellido_persona, correo_solicitante', 'length', 'max'=>50),
			array('nombre_solicitante', 'length', 'max'=>100),
			array('observacion_instancia_actividad', 'length', 'max'=>500),
			array('codigo_proceso, cedula_persona', 'length', 'max'=>15),
			array('nombre_proceso, nombre_estado_actividad', 'length', 'max'=>300),
			array('descripcion_proceso', 'length', 'max'=>1000),
			array('codigo_actividad', 'length', 'max'=>20),
			array('nombre_actividad, consignado, nombre_empleado, fecha_ini_estado_actividad_text', 'length', 'max'=>200),
			array('fecha_ini_actividad, hora_ini_actividad, fecha_fin_actividad, hora_fin_actividad, fecha_ini_estado_actividad, hora_ini_estado_actividad, pendiente_asignacion, fecha_estimada_fin', 'safe'),
			//array('_archivo','file','types'=>'jpg, jpeg, png'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_instancia_actividad, id_instancia_proceso, codigo_instancia_proceso, codigo_proceso, nombre_proceso, descripcion_proceso, consecutivo_actividad, fecha_ini_actividad, hora_ini_actividad, fecha_fin_actividad, hora_fin_actividad, id_estado_actividad, nombre_estado_actividad, id_empleado, id_persona, cedula_persona, nombre_persona, apellido_persona, nombre_empleado, nombre_solicitante, id_actividad, codigo_actividad, nombre_actividad, fecha_ini_estado_actividad, fecha_ini_estado_actividad_text, hora_ini_estado_actividad, hora_ini_estado_actividad_text, observacion_instancia_actividad, pendiente_asignacion, ejecutada', 'safe', 'on'=>'search'),
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
			'idEmpleado' => array(self::BELONGS_TO, 'Empleado', 'id_empleado'),
			'idEstadoActividad' => array(self::BELONGS_TO, 'EstadoActividad', 'id_estado_actividad'),
			'idInstanciaProceso' => array(self::BELONGS_TO, 'InstanciaProceso', 'id_instancia_proceso'),
			//'instanciaRecaudos' => array(self::HAS_MANY, 'InstanciaRecaudo', 'id_instancia_actividad'),
			//'instanciaDatoAdicional' => array(self::HAS_MANY, 'InstanciaDatoAdicional', 'id_instancia_actividad'),
			'histEstadoInstanciaActividads' => array(self::HAS_MANY, 'HistEstadoInstanciaActividad', 'id_instancia_actividad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_instancia_actividad' => 'Id Actividad',
			'id_instancia_proceso' => 'Id Instancia Trámite',
			'codigo_instancia_proceso' => 'Código del Trámite',
			'codigo_proceso' => 'Código Tipo de Trámite',
			'nombre_proceso' => 'Tipo de Trámite',
			'descripcion_proceso' => 'Descripción del Trámite Origen',
			'consecutivo_actividad' => 'Orden de la Actividad',
			'fecha_ini_actividad' => 'Fecha de Inicio',
			'hora_ini_actividad' => 'Hora de Inicio',
			'fecha_fin_actividad' => 'Fecha Fin',
			'hora_fin_actividad' => 'Hora Fin',
			'id_estado_actividad' => 'Estatus',
			'nombre_estado_actividad' => 'Estatus',
			'id_empleado' => 'Empleado a Asignar',
			'id_persona' => 'Empleado Asignado',
			'cedula_persona' => 'Cédula de la Persona',
			'nombre_persona' => 'Nombre de la Persona',
			'apellido_persona' => 'Apellido de la Persona',
			'nombre_empleado' => 'Empleado Asignado',
			'nombreCompleto' => 'Empleado Asignado',
			'nombre_solicitante' => 'Solicitante',
			'correo_solicitante' => 'Correo del Solicitante',
			'id_actividad' => 'Id Actividad',
			'codigo_actividad' => 'Código de la Actividad',
			'nombre_actividad' => 'Actividad',
			'fecha_ini_estado_actividad' => 'Fecha de Inicio Estatus Actividad',
			'hora_ini_estado_actividad' => 'Hora de Inicio Estatus Actividad',
			'observacion_instancia_actividad' => 'Observación de la Actividad',
			'pendiente_asignacion' => 'Pendiente Asignación',
			'ejecutada' => 'Ejecutada',
			'dias' => 'Dias',
			'horas' => 'Horas',
			'fecha_estimada_fin' => 'Fecha Estimada de Finalización',
			'image' => 'Observaciones',
			'fecha_ini_estado_actividad_text' => 'Fecha de Inicio Estatus Actividad',
			'hora_ini_estado_actividad_text' => 'Hora de Inicio Estatus Actividad',
			'fecha_ini_actividad_text' => 'Fecha de Inicio',
			'inTime' => 'Tiempo',
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

		$criteria->compare('id_instancia_actividad',$this->id_instancia_actividad);
		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
		$criteria->addSearchCondition('LOWER(codigo_instancia_proceso)',strtolower($this->codigo_instancia_proceso),true);
		$criteria->compare('codigo_proceso',$this->codigo_proceso,true);
		$criteria->addSearchCondition('LOWER(nombre_proceso)',strtolower($this->nombre_proceso),true);
		$criteria->compare('descripcion_proceso',$this->descripcion_proceso,true);
		$criteria->compare('consecutivo_actividad',$this->consecutivo_actividad);
		$criteria->compare('fecha_ini_actividad',$this->fecha_ini_actividad,true);
		$criteria->compare('hora_ini_actividad',$this->hora_ini_actividad,true);
		$criteria->compare('fecha_fin_actividad',$this->fecha_fin_actividad,true);
		$criteria->compare('hora_fin_actividad',$this->hora_fin_actividad,true);
		$criteria->compare('id_estado_actividad',$this->id_estado_actividad);
		$criteria->addSearchCondition('LOWER(nombre_estado_actividad)',strtolower($this->nombre_estado_actividad),true);
		$criteria->compare('id_empleado',$this->id_empleado);
		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('cedula_persona',$this->cedula_persona,true);
		$criteria->compare('nombre_persona',$this->nombre_persona,true);
		$criteria->compare('apellido_persona',$this->apellido_persona,true);
		//$criteria->addSearchCondition('LOWER(nombre_solicitante)',strtolower($this->nombre_solicitante),ture);
		$criteria->compare('id_actividad',$this->id_actividad);
		$criteria->compare('codigo_actividad',$this->codigo_actividad,true);
		$criteria->addSearchCondition('LOWER(nombre_actividad)',strtolower($this->nombre_actividad),true);
		$criteria->compare('fecha_ini_estado_actividad_text',$this->fecha_ini_estado_actividad_text,true);
		$criteria->compare('hora_ini_estado_actividad_text',$this->hora_ini_estado_actividad_text,true);
		$criteria->compare('observacion_instancia_actividad',$this->observacion_instancia_actividad,true);
		$criteria->compare('pendiente_asignacion',$this->pendiente_asignacion);
		$criteria->compare('ejecutada',$this->ejecutada);
		//$criteria->compare('observaciones',$this->observaciones);

		$idUser=Yii::app()->user->id_usuario;

		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));
		$condition="id_empleado = ".$idEmpleado->id_empleado." AND ejecutada = 0";
		$criteria->addCondition($condition);

		$sort = new CSort();
		$sort->defaultOrder = 'fecha_ini_actividad ASC, hora_ini_actividad ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
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
		

		

	public function searchReasig()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		/*if($this->codigo_instancia_proceso == null && $this->nombre_proceso == null && 
			$this->nombre_actividad == null && $this->nombre_estado_actividad == null  &&
			$this->fecha_ini_estado_actividad_text == null && $this->id_persona == null)
		{
			$this->id_instancia_actividad = -1;
		}

		else*/ if($this->id_persona == 0)
		{
			$this->pendiente_asignacion = 1;
			$this->id_persona = "";
		}

		$criteria=new CDbCriteria;

		$criteria->compare('id_instancia_actividad',$this->id_instancia_actividad);
		//$criteria->compare('codigo_instancia_proceso',$this->codigo_instancia_proceso,true);
		$criteria->addSearchCondition('LOWER(codigo_instancia_proceso)',strtolower($this->codigo_instancia_proceso),true);
		$criteria->compare('codigo_proceso',$this->codigo_proceso,true);
		//$criteria->compare('nombre_proceso',$this->nombre_proceso,true);
		$criteria->addSearchCondition('LOWER(nombre_proceso)',strtolower($this->nombre_proceso),true);
		//$criteria->compare('nombre_estado_actividad',$this->nombre_estado_actividad,true);
		$criteria->addSearchCondition('LOWER(nombre_estado_actividad)',strtolower($this->nombre_estado_actividad),true);
		$criteria->compare('id_empleado',$this->id_empleado);
		$criteria->compare('id_persona',$this->id_persona);
		//$criteria->addSearchCondition('LOWER(nombre_solicitante)',strtolower($this->nombre_solicitante));
		//$criteria->compare('nombre_actividad',$this->nombre_actividad,true);
		$criteria->addSearchCondition('LOWER(nombre_actividad)',strtolower($this->nombre_actividad),true);
		$criteria->compare('fecha_ini_estado_actividad_text',$this->fecha_ini_estado_actividad_text,true);
//		$criteria->compare('hora_ini_estado_actividad_text',$this->hora_ini_estado_actividad_text,true);
//		$criteria->compare('observacion_instancia_actividad',$this->observacion_instancia_actividad,true);
		$criteria->compare('pendiente_asignacion',$this->pendiente_asignacion);
		$criteria->compare('ejecutada',$this->ejecutada);
		//$criteria->compare('observaciones',$this->observaciones);

		$idUser=Yii::app()->user->id_usuario;

		$modelEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));
		$idEmpleado = $modelEmpleado->id_empleado;

		$condition="(id_empleado IN";
		$condition=$condition." (";
		$condition=$condition."		SELECT id_empleado FROM empleado WHERE superior_inmediato = ".$idEmpleado;
		$condition=$condition." ) OR id_empleado = ".$idEmpleado;
		//$condition=$condition."OR id_actividad IN(SELECT id_actividad FROM actividad_rol WHERE id_rol = (SELECT id_rol FROM empleado_rol WHERE id_empleado = ".$idEmpleado."))  ) AND ejecutada = 0";
		$condition=$condition."OR id_actividad IN(SELECT id_actividad FROM actividad WHERE id_departamento = ".$modelEmpleado->id_departamento.")  ) AND ejecutada = 0";

		$criteria->addCondition($condition);

		$sort = new CSort();
		$sort->defaultOrder = 'fecha_ini_actividad ASC, hora_ini_actividad ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}


	private function tiempoRestante()
	{
		date_default_timezone_set('America/Caracas');

		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);
		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);

		$horasDiaLaborable=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);

		$fechaA=date('Y-m-d');
		$horaA=date('H:i:s');

		$tiempo_restante=0;
		$tiempo_sobrante=0;

		$tiempo_estimado = ($this->dias*7*60)+($this->horas*60);

		$sqlTiempoAct = "SELECT tiempo_actividad('".$this->fecha_ini_actividad."', '".$fechaA."', '".$this->hora_ini_actividad."', '".$horaA."') AS tiempo_ejecucion";
		$tiempoAct = Yii::app()->db->createCommand($sqlTiempoAct)->queryRow();



		$tiempo_ejecucion = $tiempoAct['tiempo_ejecucion'];
		if($tiempo_ejecucion < 0)
			$tiempo_ejecucion = 0;


		$tiempo = $tiempo_estimado - $tiempo_ejecucion;
		if($tiempo<0)
		{
			$tiempo_sobrante=abs($tiempo);

			$tiempo_sobrante = ($tiempo_sobrante / 60) / $horasDiaLaborable;
			$dTemp = floor($tiempo_sobrante);
			$tiempo_sobrante = $tiempo_sobrante - $dTemp;
			$tiempo_sobrante = $tiempo_sobrante * $horasDiaLaborable;
			$hTemp = floor($tiempo_sobrante);

			$tiempo_sobrante = $dTemp.' dias - '.$hTemp.' horas';

			$tiempo_restante=-1;
		}
		else
		{
			$tiempo_restante = ($tiempo / 60) / $horasDiaLaborable;
			$dTemp = floor($tiempo_restante);
			$tiempo_restante = $tiempo_restante - $dTemp;
			$tiempo_restante = $tiempo_restante * $horasDiaLaborable;
			$hTemp = floor($tiempo_restante);
			$tiempo_restante = $dTemp.' dias - '.$hTemp.' horas';
		}

		

		return $tiempo_restante.'/'.$tiempo_sobrante;

	}

	public function getobservaciones()
	{
		if($this->_observaciones === null)
		{
			$tiempo_ejecucion = explode('/', $this->tiempoRestante());

			if($tiempo_ejecucion[0]==-1)
				$this->_observaciones="Agotado por: ".$tiempo_ejecucion[1];
			else
				$this->_observaciones=$tiempo_ejecucion[0];

		}
		return $this->_observaciones;
	}

	public function setobservaciones($value){

		$this->_observaciones = $value;
	}

	public function getimage(){

		if($this->_image===null)
		{

			$tiempo_ejecucion = explode('/', $this->tiempoRestante());

			if($tiempo_ejecucion[0]==-1)
				$this->_image=Yii::app()->getBaseUrl(true).'/images/alerta.png';
			else
				$this->_image=Yii::app()->getBaseUrl(true).'/images/tiempo.png';
		}

		return $this->_image;
	}

	public function getfecha_estimada_fin()
	{
		if($this->_fecha_estimada_fin===null)
		{
			$sumDias = floor(($this->dias / 5) * 7); 

			$fecha = date( $this->fecha_ini_actividad);
			$this->_fecha_estimada_fin = strtotime( '+'.$sumDias.' day' , strtotime($fecha));
			$this->_fecha_estimada_fin = date ( 'd-m-Y' , $this->_fecha_estimada_fin );
		}

		return $this->_fecha_estimada_fin;
	}

	public function setfecha_estimada_fin($value)
	{
		$this->_fecha_estimada_fin = $value;
	}


	public function getinTime()
	{
		if($this->_inTime===null)
		{
			$this->_inTime = $this->fecha_estimada_fin;
		}

	    return $this->_inTime;
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InstanciaActividad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
