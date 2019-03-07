<?php

/**
 * This is the model class for table "instancia_actividad".
 *
 * The followings are the available columns in table 'instancia_actividad':
 * @property integer $id_instancia_actividad
 * @property integer $id_instancia_proceso
 * @property integer $consecutivo_actividad
 * @property string $fecha_ini_actividad
 * @property string $hora_ini_actividad
 * @property string $fecha_fin_actividad
 * @property string $hora_fin_actividad
 * @property integer $id_estado_actividad
 * @property integer $id_empleado
 * @property integer $id_actividad
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
class InstanciaActividad extends CActiveRecord
{
	/*******RECAUDO*******/
	private $_id_recaudo;
	private $_consignado;

	private $_recaudoEditable;
	public $_recaudosSeleccionados;

	/***DATO ADICIONAL***/
	private $_array_datos_adicionales;
	private $_datoEditable;
	private $_itemLista;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'instancia_actividad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_instancia_proceso, consecutivo_actividad, fecha_ini_actividad, hora_ini_actividad, id_estado_actividad, id_empleado, fecha_ini_estado_actividad, hora_ini_estado_actividad', 'required'),
			array('id_instancia_proceso, consecutivo_actividad, id_estado_actividad, id_empleado, id_actividad, ejecutada', 'numerical', 'integerOnly'=>true),
			array('observacion_instancia_actividad, _recaudosSeleccionados', 'length', 'max'=>500),
			array('fecha_fin_actividad, hora_fin_actividad, pendiente_asignacion, array_datos_adicionales', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_instancia_actividad, id_instancia_proceso, consecutivo_actividad, fecha_ini_actividad, hora_ini_actividad, fecha_fin_actividad, hora_fin_actividad, id_estado_actividad, id_empleado, id_actividad, fecha_ini_estado_actividad, hora_ini_estado_actividad, observacion_instancia_actividad, pendiente_asignacion, ejecutada', 'safe', 'on'=>'search'),
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
			//'instanciaRecaudos' => array(self::HAS_MANY, 'InstanciaRecaudo', 'instancia_actividad_id'),
			//'instanciaDatoAdicionalls' => array(self::HAS_MANY, 'InstanciaDatoAdicionall', 'instancia_actividad_id'),
			'histEstadoInstanciaActividads' => array(self::HAS_MANY, 'HistEstadoInstanciaActividad', 'id_instancia_actividad'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_instancia_actividad' => 'Id Instancia Actividad',
			'id_instancia_proceso' => 'Id Instancia Proceso',
			'consecutivo_actividad' => 'Consecutivo Actividad',
			'fecha_ini_actividad' => 'Fecha Ini Actividad',
			'hora_ini_actividad' => 'Hora Ini Actividad',
			'fecha_fin_actividad' => 'Fecha Fin Actividad',
			'hora_fin_actividad' => 'Hora Fin Actividad',
			'id_estado_actividad' => 'Estado de la Actividad',
			'id_empleado' => 'Id Empleado',
			'id_actividad' => 'Id Actividad',
			'fecha_ini_estado_actividad' => 'Fecha Ini Estado Actividad',
			'hora_ini_estado_actividad' => 'Hora Ini Estado Actividad',
			'observacion_instancia_actividad' => 'Observación de la Actividad',
			'pendiente_asignacion' => 'Pendiente Asignacion',
			'ejecutada' => 'Ejecutada',
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
		$criteria->compare('consecutivo_actividad',$this->consecutivo_actividad);
		$criteria->compare('fecha_ini_actividad',$this->fecha_ini_actividad,true);
		$criteria->compare('hora_ini_actividad',$this->hora_ini_actividad,true);
		$criteria->compare('fecha_fin_actividad',$this->fecha_fin_actividad,true);
		$criteria->compare('hora_fin_actividad',$this->hora_fin_actividad,true);
		$criteria->compare('id_estado_actividad',$this->id_estado_actividad);
		$criteria->compare('id_empleado',$this->id_empleado);
		$criteria->compare('id_actividad',$this->id_actividad);
		$criteria->compare('fecha_ini_estado_actividad',$this->fecha_ini_estado_actividad,true);
		$criteria->compare('hora_ini_estado_actividad',$this->hora_ini_estado_actividad,true);
		$criteria->compare('observacion_instancia_actividad',$this->observacion_instancia_actividad,true);
		$criteria->compare('pendiente_asignacion',$this->pendiente_asignacion);
		$criteria->compare('ejecutada',$this->ejecutada);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getEmpleadosAsig($idInstanciaActividad)
	{
		
		$sql = "SELECT 	e.id_empleado, p.id_persona, p.nombre_persona, p.apellido_persona
			FROM empleado e
			INNER JOIN cargo c ON e.id_cargo = c.id_cargo
			INNER JOIN persona p ON p.id_persona = e.id_persona
			INNER JOIN empleado_rol er ON e.id_empleado = er.id_empleado
			INNER JOIN actividad_rol ar ON ar.id_rol = er.id_rol
			WHERE id_actividad = (	SELECT id_actividad 
									FROM instancia_actividad 
									WHERE id_instancia_actividad = ".$idInstanciaActividad.") AND e.activo = 1";
		
		if((!Yii::app()->user->isSuperAdmin) && (!Funciones::usuarioEsDirector()))
		{
			$sql = $sql." AND id_departamento = (	SELECT id_departamento 
									FROM empleado 
									WHERE id_usuario = ".Yii::app()->user->id_usuario.")";
		}

		$connection=Yii::app()->db; 
		$command = $connection->createCommand($sql);
		//$rowCount=$command->execute(); // execute the non-query SQL
		$dataReader=$command->query(); // execute a query SQL

		$r = array(array('value'=> 0, 'text' => '-- Seleccione --'));

		foreach($dataReader as $item)
		{
    		//process each item here
    		array_push($r, array('value'=> $item['id_empleado'], 'text' => $item['nombre_persona']." ".$item['apellido_persona']));
		}

		return $r;
	}

	public function getid_recaudo()
	{

	    if ($this->_id_recaudo === null && $this->idInstanciaProceso->instanciaRecaudos!==null)
		{
		    foreach ($this->idInstanciaProceso->instanciaRecaudos as $value)
			{
				$nombre_recaudo=Recaudo::model()->findByPk($value->idProcesoRecaudo->id_recaudo);
				$this->_id_recaudo[$value->id_instancia_recaudo] = $nombre_recaudo->nombre_recaudo;

			}
		}

		return $this->_id_recaudo;
	}

	public function getconsignado()
	{

	    if ($this->_consignado === null && $this->idInstanciaProceso->instanciaRecaudos!==null)
		{
		    foreach ($this->idInstanciaProceso->instanciaRecaudos as $value)
			{
				$this->_consignado[$value->id_instancia_recaudo] = $value->consignado;
			}

		}

		return $this->_consignado;
	}

	public function getrecaudoEditable()
	{
		if ($this->_recaudoEditable === null && $this->idActividad!==null && $this->idActividad->recaudoActividads!==null)
		{
			foreach ($this->idActividad->recaudoActividads as $value) 
			{
				foreach ($this->idInstanciaProceso->instanciaRecaudos as $value2) 
				{
					if($value->id_proceso_recaudo === $value2->id_proceso_recaudo)
					$this->_recaudoEditable[$value2->id_instancia_recaudo] = true;
				}
				
			}
		    	
		}

		return $this->_recaudoEditable;
	}

	public function getarray_datos_adicionales(){
		if($this->_array_datos_adicionales === null && $this->idInstanciaProceso->instanciaDatoAdicionals!==null)
		{
			foreach ($this->idInstanciaProceso->instanciaDatoAdicionals as $value)
			{
				$datos = DatoAdicional::model()->findByPk($value->idProcesoDatoAdicional->id_dato_adicional);
				if($datos->activo)
				{
					$this->_array_datos_adicionales[$value->id_instancia_dato_adicional][0] = $datos->nombre_dato_adicional;
					$this->_array_datos_adicionales[$value->id_instancia_dato_adicional][1] = $datos->tipo_dato_adicional;
					$this->_array_datos_adicionales[$value->id_instancia_dato_adicional][2] = $value->valor_dato_adicional;
					$this->_array_datos_adicionales[$value->id_instancia_dato_adicional][3] = $datos->id_dato_adicional;
				}
			}
		}
		return $this->_array_datos_adicionales;
	}


	public function setarray_datos_adicionales($valor){

		if(is_array($this->array_datos_adicionales)){
			foreach ($this->array_datos_adicionales as $key2 => $value2) {

				foreach ($valor as $key => $value) {

					if($key2 == $key and isset($value[2]))
						$this->_array_datos_adicionales[$key2][2]=$value[2];
				}			 
			}		
		}		
	}

	public function put_array_datos_adicionales($indice, $valor){

		$this->_array_datos_adicionales[$indice][2] = $valor;	
	}

	public function getdatoEditable()
	{
		if ($this->_datoEditable === null && $this->idActividad!==null && $this->idActividad->datoActividads!==null)
		{
			foreach ($this->idActividad->datoActividads as $value) 
			{
				foreach ($this->idInstanciaProceso->instanciaDatoAdicionals as $value2) 
				{
					if($value->id_proceso_dato_adicional === $value2->id_proceso_dato_adicional)
					$this->_datoEditable[$value2->id_instancia_dato_adicional] = true;
				}
				
			}
		    	
		}

		return $this->_datoEditable;
	}

	public function get_nombreTipo($idTipo)
	{
		$tipo = TipoDato::model()->findByPk($idTipo);

		return $tipo->nombre_tipo_dato;
	}

	public function getitemLista(){

		if($this->_itemLista === null && $this->idInstanciaProceso->instanciaDatoAdicionals!==null)
		{
			foreach ($this->idInstanciaProceso->instanciaDatoAdicionals as $value)
			{
				$itemsLista =  ItemLista::model()->findAllByAttributes(array('id_dato_adicional'=>$value->idProcesoDatoAdicional->id_dato_adicional));

				if($itemsLista)
				{
					$lista = array();
					foreach ($itemsLista as $key2 => $value2) 
					{
						$lista[$value2['id_item_lista']] = $value2['nombre_item_lista'];
					}
					$this->_itemLista[$value->id_instancia_dato_adicional] = $lista;
				}
				
			}
		}
		return $this->_itemLista;
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