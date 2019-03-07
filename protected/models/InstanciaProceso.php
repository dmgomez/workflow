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
class InstanciaProceso extends CActiveRecord
{
	public $_archivo;
	private $_archivoG;

	public $_cant;
	public $_datoAdicional;
	public $_valorDatoAdicional;

	public $_actInic;
	public $_actInicAnt;
	//public $_solicitante;
	public $_nombre;
	public $_busqueda;
	private $_nombreEstado;
	private $_nombreProceso;

	/*******RECAUDO*******/
	private $_id_recaudo;
	private $_consignado;

	public $_recaudosConsignados;
	public $_recaudosSeleccionados;

	/***DATO ADICIONAL***/
	private $_array_datos_adicionales;
	public $array_valor_datos_adicionales;

	private $_itemLista;

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
			array('_archivo, archivoG, id_proceso, codigo_instancia_proceso, fecha_ini_proceso, hora_ini_proceso, array_valor_datos_adicionales, _actInic', 'required'),
			array('id_proceso, id_usuario, id_estado_instancia_proceso, _actInic', 'numerical', 'integerOnly'=>true),
			array('codigo_instancia_proceso, nombreEstado', 'length', 'max'=>50),
			array('nombreProceso, _recaudosSeleccionados, _datoAdicional, _valorDatoAdicional', 'length', 'max'=>250),
			array('codigo_instancia_proceso', 'CRegularExpressionValidator', 'pattern' => '/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ-\s]+$/', 'message' => 'Código Proceso inválido. Sólo se permiten caracteres alfabéticos.'),
			array('_archivo, archivoG','file','types'=>'jpg, jpeg, png, bmp, txt, doc, docx, xls, xlsx, ppt, pptx, pdf'), 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_instancia_proceso, id_proceso, id_usuario, codigo_instancia_proceso, id_estado_instancia_proceso, _busqueda, fecha_ini_proceso, fecha_fin_proceso, array_datos_adicionales, nombreEstado, _datoAdicional, _valorDatoAdicional', 'safe', 'on'=>'search'),
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
			'instanciaActividads' => array(self::HAS_MANY, 'InstanciaActividad', 'id_instancia_proceso'),			
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
			'id_instancia_proceso' => 'Id Instancia Proceso',
			'id_proceso' => 'Id Proceso',
			'id_usuario' => 'Id Usuario',
			'codigo_instancia_proceso' => 'Número de Solicitud',
			'id_estado_instancia_proceso' => 'Estado del Trámite',
			'_actInic' => 'Iniciar por',
			'fecha_anulacion' => 'Fecha de Anulación'
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
		$criteria->with = array("idEstadoInstanciaProceso"=>array('alias' => 'estadoinstanciaproceso'), 'idProceso'=>array('alias' => 'proceso'), );

		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->addSearchCondition('LOWER(codigo_instancia_proceso)',strtolower($this->codigo_instancia_proceso),true);
		$criteria->addSearchCondition('LOWER(proceso.nombre_proceso)',strtolower($this->nombreProceso),true);
		$criteria->compare('t.id_estado_instancia_proceso',$this->id_estado_instancia_proceso);

		$sort = new CSort();
		$sort->attributes = array(

		    'codigo_instancia_proceso'=>array(
		        'asc'=>'codigo_instancia_proceso',
		        'desc'=>'codigo_instancia_proceso desc',
		    ),
		    'nombreProceso'=>array(
		        'asc'=>'proceso.nombre_proceso',
		        'desc'=>'proceso.nombre_proceso desc',
		    ),
		    'id_estado_instancia_proceso'=>array(
		        'asc'=>'t.id_estado_instancia_proceso',
		        'desc'=>'t.id_estado_instancia_proceso desc',
		    ),
		);

		$sort->defaultOrder = 'codigo_instancia_proceso ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function search2($idInstProc)
	{
		$condition="id_instancia_proceso = -1";

		if($idInstProc && $idInstProc!="")
		{
			$flag = 0;
			$idP=explode(',', $idInstProc);

			$conditionTemp="(";
			foreach($idP as $key => $value) 
			{
				$tiempoReconsideracion = $this->fechaTopeReconsideracion($value);

				if($tiempoReconsideracion == 1)
				{
					$conditionTemp.="id_instancia_proceso = ".$value." or ";
					$flag=1;
				}
		
			}

			if($flag==1)
			{
				$conditionTemp=substr($conditionTemp, 0, -3);

				$conditionTemp.=")";

				$condition = $conditionTemp;
			}

			
		}

		$condition.=" AND ejecutado = 1 AND fecha_ini_reconsideracion is null AND fecha_fin_reconsideracion is null";

		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with = array("idEstadoInstanciaProceso"=>array('alias' => 'estadoinstanciaproceso'), 'idProceso'=>array('alias' => 'proceso'), 'idInmueble'=>array('alias' => 'inmueble'), 'idInmueble.idParroquia'=>array('alias'=>'parroquia'));

		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->addSearchCondition('LOWER(codigo_instancia_proceso)',strtolower($this->codigo_instancia_proceso),true);
		$criteria->addSearchCondition('LOWER(proceso.nombre_proceso)',strtolower($this->nombreProceso),true);
		$criteria->addSearchCondition('LOWER(observacion_instancia_proceso)',strtolower($this->observacion_instancia_proceso),true);
		$criteria->compare('t.id_estado_instancia_proceso',$this->id_estado_instancia_proceso);
		$criteria->addSearchCondition('LOWER(estadoinstanciaproceso.nombre_estado_instancia_proceso)',strtolower($this->nombreEstado),true);
		$criteria->addSearchCondition('fecha_ini_proceso::text',Funciones::invertirFecha($this->fecha_ini_proceso));
		$criteria->addSearchCondition('fecha_fin_proceso::text',Funciones::invertirFecha($this->fecha_fin_proceso));
		$criteria->addCondition($condition);


		$sort = new CSort();
		$sort->attributes = array(

		    'codigo_instancia_proceso'=>array(
		        'asc'=>'codigo_instancia_proceso',
		        'desc'=>'codigo_instancia_proceso desc',
		    ),
		    'nombreProceso'=>array(
		        'asc'=>'proceso.nombre_proceso',
		        'desc'=>'proceso.nombre_proceso desc',
		    ),
		    'id_estado_instancia_proceso'=>array(
		        'asc'=>'t.id_estado_instancia_proceso',
		        'desc'=>'t.id_estado_instancia_proceso desc',
		    ),
		  /*  'nombreEstado'=>array(
		        'asc'=>'estadoinstanciaproceso.nombre_estado_instancia_proceso',
		        'desc'=>'estadoinstanciaproceso.nombre_estado_instancia_proceso desc',
		    ),*/
		    'fecha_ini_proceso'=>array(
		        'asc'=>'fecha_ini_proceso',
		        'desc'=>'fecha_ini_proceso desc',
		    ),
		    'fecha_fin_proceso'=>array(
		        'asc'=>'fecha_fin_proceso',
		        'desc'=>'fecha_fin_proceso desc',
		    ),
		);

		$sort->defaultOrder = 'codigo_instancia_proceso ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));

	}

	public function searchBusquedaAvanzada($_datoA, $_valorDatoA)
	{

		$condition="id_instancia_proceso <> -1";

		if($_datoA !=  "" && $_datoA != null && $_valorDatoA !=  "" && $_valorDatoA != null)
		{
			$condition="id_instancia_proceso <> -2";
			$conditionDA = "";
			$id_datos = explode(',', $_datoA);
			$valor_datos = explode(',', $_valorDatoA);


			foreach ($id_datos as $key => $value) 
			{
				if($valor_datos[$key] != "")
				{
					if(!is_numeric($valor_datos[$key]))
					{
						$conditionTemp = "LOWER(valor_dato_adicional) like '%".Funciones::minuscula_utf8($valor_datos[$key])."%'";//$valor_datos[$key] = Funciones::minuscula_utf8($valor_datos[$key]);
					}
					else
					{
						$conditionTemp = "valor_dato_adicional like '%".$valor_datos[$key]."%'";
					}

					$conditionDA = "id_proceso_dato_adicional = ".$value." and ".$conditionTemp;
					
					$instDato = InstanciaDatoAdicional::model()->find(array("select"=>"array_to_string(array_agg(id_instancia_proceso), ',') as id_instancia_proceso", "condition"=>$conditionDA));

					if($instDato && $instDato->id_instancia_proceso!="")
					{

						$procTemp = explode(',', $instDato->id_instancia_proceso);

						if(isset($instProcesos))
						{
							$instProcesos = array_intersect($instProcesos, $procTemp);
						}
						else
						{
							$instProcesos = $procTemp;
						}
					}

				}
			}

			if(isset($instProcesos))
			{
				$instProcesos = implode(',', $instProcesos);

				$condition = 'id_instancia_proceso in('.$instProcesos.')';
			}
			else
			{
				$condition="id_instancia_proceso = -1";
			}

		}


		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array("idEstadoInstanciaProceso"=>array('alias' => 'estadoinstanciaproceso'), 'idProceso'=>array('alias' => 'proceso'));

		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
		$criteria->compare('t.id_proceso',$this->id_proceso);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->addSearchCondition('LOWER(codigo_instancia_proceso)',Funciones::minuscula_utf8($this->codigo_instancia_proceso),true);
		$criteria->addSearchCondition('LOWER(proceso.nombre_proceso)',Funciones::minuscula_utf8($this->nombreProceso),true);
		$criteria->compare('t.id_estado_instancia_proceso',$this->id_estado_instancia_proceso);
		$criteria->addSearchCondition('LOWER(estadoinstanciaproceso.nombre_estado_instancia_proceso)',Funciones::minuscula_utf8($this->nombreEstado),true);
		$criteria->addCondition($condition);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	private function fechaTopeReconsideracion($idInstProc)
	{
		$instProceso = InstanciaProceso::model()->findByPk($idInstProc);

		$retorno = 0;

		if($instProceso && $instProceso->ejecutado==1)
		{
			$fecha = strtotime ( '+2 month' , strtotime ( $instProceso->fecha_fin_proceso ) ) ;

			date_default_timezone_set('America/Caracas');
			$fechaAct =strtotime( date('Y-m-d'));

			if($fecha > $fechaAct)
				$retorno = 1;
		}

		return $retorno;

	}

	public function getnombreEstado(){

	    if ($this->_nombreEstado === null && $this->idEstadoInstanciaProceso !== null){

	        $this->_nombreEstado = $this->idEstadoInstanciaProceso->nombre_estado_instancia_proceso;
	    }

	    return $this->_nombreEstado;
	}

	/*SET redefinido para acceder a los campos virtuales agregados*/
	public function setnombreEstado($value){

		$this->_nombreEstado = $value;
	}

	public function getnombreProceso(){

	    if ($this->_nombreProceso === null && $this->idProceso !== null){

	        $this->_nombreProceso = $this->idProceso->nombre_proceso;
	    }

	    return $this->_nombreProceso;
	}

	/*SET redefinido para acceder a los campos virtuales agregados*/
	public function setnombreProceso($value){

		$this->_nombreProceso = $value;
	}

	public function actividadesPendientes()
	{
		$actividades="";

	    foreach ($this->instanciaActividads as $value) 
		{
			if($value->ejecutada==0)
			{
				$nombre_actividad=Actividad::model()->findByPk($value->id_actividad);
				$actividades = $actividades.''.$nombre_actividad->codigo_actividad.'. '.$nombre_actividad->nombre_actividad.',';

			}
		}
		$actividades=substr($actividades, 0, -1);
		return $actividades;
		
	}

	public function empleadoActividad()
	{
		$empleado="";

	    foreach ($this->instanciaActividads as $value) 
		{
			if($value->ejecutada==0)
			{
				$nombre_empleado=VisEmpleado::model()->find(array('condition'=>'id_empleado = '.$value->id_empleado));
				$empleado = $empleado.''.$nombre_empleado->nombre_persona;

			}
		}
		//$empleado=substr($empleado, 0, -1);
		return $empleado;
		
	}

	public function mostrarFechaFin()
	{
		if ($this->ejecutado==1) 
		{
			$fecha = Funciones::invertirFecha($this->fecha_fin_proceso);
		}
		else
		{
			$fecha = '-';
		}

		return $fecha;
	}


	public function get_visibilidad_anular()
	{
		$visible = false;

		$sqlEstadoFin="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_finalizado'";
		$estadoFin= Yii::app()->db->createCommand($sqlEstadoFin)->queryRow();

		$sqlEstadoAnulado="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_anulado'";
		$estadoAnulado= Yii::app()->db->createCommand($sqlEstadoAnulado)->queryRow();

		if(Yii::app()->user->isSuperAdmin && $this->id_estado_instancia_proceso!=$estadoFin['valor'] && $this->id_estado_instancia_proceso!=$estadoAnulado['valor'])
			$visible = true;

		return $visible;
	}

	public function get_visibilidad_delete()
	{
		$visible = false;
		$sqlEstadoPendiente="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_pendiente'";
		$estadoPendiente= Yii::app()->db->createCommand($sqlEstadoPendiente)->queryRow();

		
		if($this->id_estado_instancia_proceso==$estadoPendiente['valor'] && Yii::app()->user->isSuperAdmin)
		{
			$visible = true;
		}
		
		return $visible;
	}

	public function get_visibilidad_regresar_tramite()
	{
		$visible = false;

		$sqlEstadoProceso="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_en_proceso'";
		$estadoProceso= Yii::app()->db->createCommand($sqlEstadoProceso)->queryRow();

		if($this->id_estado_instancia_proceso==$estadoProceso['valor'] && Yii::app()->user->isSuperAdmin)
		{
			$visible = true;
		}


		return $visible;
	
	}


	public function getid_recaudo()
	{

	    if ($this->_id_recaudo === null && $this->idProceso/*->actividads*/!==null)
		{
			foreach ($this->idProceso->actividads as $actividad) {
				
			    foreach ($actividad->recaudoActividads as $value)
				{
					$nombre_recaudo=Recaudo::model()->findByPk($value->idProcesoRecaudo->id_recaudo);
					//$this->_id_recaudo[$value->id_instancia_recaudo] = $nombre_recaudo->nombre_recaudo;
					$recaudos_actividad[$value->id_instancia_recaudo] = $nombre_recaudo->nombre_recaudo;
				}

				$this->_id_recaudo[$actividad->id_actividad] = $recaudos_actividad;
			}
		}

		return $this->_id_recaudo;
	}


	public function getarray_datos_adicionales(){
		if($this->_array_datos_adicionales === null && $this->idProceso!==null)
		{
		
			$datos = VisDatoAdicional::model()->findAll(array('condition' => 'id_proceso = '. $this->idProceso->id_proceso .'and dato_activo = 1', 'order' => 'id_actividad, orden ASC'));

			foreach ($datos as $key => $value) {
				
				$this->_array_datos_adicionales[$key][0] = $value->id_proceso_dato_adicional;
				$this->_array_datos_adicionales[$key][1] = $value->tipo_dato_adicional;
				$this->_array_datos_adicionales[$key][2] = $this->array_valor_datos_adicionales[$key];
				$this->_array_datos_adicionales[$key][3] = $value->id_dato_adicional;
				$this->_array_datos_adicionales[$key][4] = $value->nombre_dato_adicional;
			}
	
		}
		return $this->_array_datos_adicionales;
	}

	public function setarray_datos_adicionales($valor){

		$this->_array_datos_adicionales = $valor;	
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
