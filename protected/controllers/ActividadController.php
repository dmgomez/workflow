<?php

class ActividadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function filters()
	{
		return array(array('CrugeAccessControlFilter'));
	}

	/**
	 * @return array action filters
	 */
	/*
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}
	*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','cargarComboDestino', 'DeleteGrid'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update', 'buscarCodigo'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/
	
	public function actionBuscarCodigo()
	{
		$result = array('success' => true);
		
		$codigo = $_POST['codigo'];
		$idProceso = $_POST['idProceso'];

		$idActividad=-1;
		if(isset($_POST['idActividad']) )
			$idActividad = $_POST['idActividad'];

		$model = Actividad::model()->findByAttributes( array('codigo_actividad'=>$codigo, 'id_proceso'=>$idProceso) );
		
		if($model && $model->id_actividad!=$idActividad)
		{

			$result = array('success' => false, 'message' => 'El código que ingresó ya se encuentra registrado para este Proceso.');	
			
		}		

		echo CJSON::encode($result);
	}

	public function actionCargarComboDestino()
	{
		$data=Actividad::model()->findAllBySql(
		"select * from actividad where id_proceso
		=:keyword order by nombre_actividad asc",
		// Aquí buscamos las diferentes actividades que pertenecen al proceso elegido
		array(':keyword'=>$_POST['Actividad']['id_proceso']));
		$data=CHtml::listData($data,'id_actividad','nombre_actividad');
		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		$modelRec=new CActiveDataProvider(Recaudo::model(), array(
			'keyAttribute'=>'id_recaudo',
			'criteria'=>array(
				'condition'=>'id_actividad='.$id,
			),
		));

		$modelDatoA=new CActiveDataProvider(DatoAdicional::model(), array(
			'keyAttribute'=>'id_dato_adicional',
			'criteria'=>array(
				'condition'=>'id_actividad='.$id,
			),
		));
		
		$mod = $this->loadModel($id);
		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$mod->id_proceso);
		
		$this->render('view',array(
			'model'=>$mod,
			'modelRec'=>$modelRec,
			'modelDatoA'=>$modelDatoA,
			'codigoProceso'=>$proc->codigo_proceso,
			'nombreProceso'=>$proc->nombre_proceso,
		));
		
		//$this->redirect(array('view', 'model'=>$this->loadModel($id)));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'admin' page.
	 */
	public function actionCreate($idProceso)
	{
		

		$model=new Actividad;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				
		if(isset($_POST['Actividad']))
		{
			$model->attributes=$_POST['Actividad'];

			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro creado satisfactoriamente.");

				if($model->btn==1)
					$this->redirect(array('proceso/'.$idProceso));
				else
					$this->redirect(array('actividad/'.$model->id_actividad));
			}
		}
		
		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$idProceso);

		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);

		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);

		$horasLaborables=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);
		
		$this->render('create',array(
			'model'=>$model,
			'idProceso'=>$idProceso,
			'codigoProceso'=>$proc->codigo_proceso,
			'nombreProceso'=>$proc->nombre_proceso,
			'horasLaborables'=>$horasLaborables,
			'idOrganizacion'=>$proc->id_organizacion,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$modelRec=new CActiveDataProvider(Recaudo::model(), array(
			'keyAttribute'=>'id_recaudo',
			'criteria'=>array(
				'condition'=>'id_actividad='.$id,
			),
		));

		$modelDatoA=new CActiveDataProvider(DatoAdicional::model(), array(
			'keyAttribute'=>'id_dato_adicional',
			'criteria'=>array(
				'condition'=>'id_actividad='.$id,
			),
		));
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Actividad']))
		{
			$model->attributes=$_POST['Actividad'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro actualizado satisfactoriamente.");
				//$this->redirect(array('proceso/'.$model->id_proceso));

				if($model->btn==1)
					$this->redirect(array('proceso/'.$model->id_proceso));
				else
					$this->redirect(array('actividad/'.$model->id_actividad));
			}
		}

		//Obtengo el registros de procesos para tener los datos que le voy a pasar a la ventana de actividades
		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$model->id_proceso);

		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);

		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);

		$horasLaborables=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);

		$this->render('update',array(
			'model'=>$model,
			'modelRec'=>$modelRec,
			'modelDatoA'=>$modelDatoA,
			'idProceso'=>$model->id_proceso,
			'codigoProceso'=>$proc->codigo_proceso,
			'nombreProceso'=>$proc->nombre_proceso,
			'horasLaborables'=>$horasLaborables,
			'idOrganizacion'=>$proc->id_organizacion,
		));
	}

	public function actionListarRecaudo($id, $idProceso)
	{
		$result = array('success' => false);

		$idRecaudoActividad = RecaudoActividad::model()->find(array('select'=>"array_to_string(array_agg(id_proceso_recaudo), ',') as id_proceso_recaudo", 'condition'=>'id_actividad = '.$id));

		if(!$idRecaudoActividad || $idRecaudoActividad->id_proceso_recaudo=="")
		{
			$idRecaudos = ProcesoRecaudo::model()->find(array('select'=>"array_to_string(array_agg(id_recaudo), ',') as id_recaudo", "condition"=>"id_proceso = ".$idProceso));

			if($idRecaudos && $idRecaudos->id_recaudo!="")
				$recaudosNoAsociados=Recaudo::model()->findAll(array('condition'=>'id_recaudo IN('.$idRecaudos->id_recaudo.')'));
		}
		else
		{
			$idRecaudos = ProcesoRecaudo::model()->find(array('select'=>"array_to_string(array_agg(id_recaudo), ',') as id_recaudo", "condition"=>"id_proceso = ".$idProceso." AND id_proceso_recaudo not IN(".$idRecaudoActividad->id_proceso_recaudo.")"));
			$idRecaudosAsociados = ProcesoRecaudo::model()->find(array('select'=>"array_to_string(array_agg(id_recaudo), ',') as id_recaudo", "condition"=>"id_proceso_recaudo IN(".$idRecaudoActividad->id_proceso_recaudo.")"));

			if($idRecaudos && $idRecaudos->id_recaudo!="")
				$recaudosNoAsociados=Recaudo::model()->findAll(array('condition'=>'id_recaudo IN('.$idRecaudos->id_recaudo.')'));

			if($idRecaudosAsociados)
				$recaudosAsociados=Recaudo::model()->findAll(array('condition'=>'id_recaudo IN('.$idRecaudosAsociados->id_recaudo.')'));
		}

		if(isset($recaudosNoAsociados) && isset($recaudosAsociados))
		{
			$modelRecaudo = Actividad::model();
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodoRecaudo('.$id.','.$idProceso.')')),
				'recaudos' => CHtml::activeCheckBoxList($modelRecaudo, '_recaudos',
				   	CHtml::listData($recaudosNoAsociados, 'id_recaudo', 'nombre_recaudo'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"seleccionarRecaudo($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				'recaudosSeleccionados' => CHtml::activeCheckBoxList($modelRecaudo, '_recaudosSeleccionados',
				   	CHtml::listData($recaudosAsociados, 'id_recaudo', 'nombre_recaudo'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"deseleccionarRecaudo($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				
			);
			
		}
		else if(isset($recaudosNoAsociados))
		{
			$modelRecaudo = Actividad::model();
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodoRecaudo('.$id.','.$idProceso.')')),
				'recaudos' => CHtml::activeCheckBoxList($modelRecaudo, '_recaudos',
				   	CHtml::listData($recaudosNoAsociados, 'id_recaudo', 'nombre_recaudo'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"seleccionarRecaudo($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				'recaudosSeleccionados' => '<i>No se ha seleccionado ningún recaudo</i>',
				
			);
		}
		else if(isset($recaudosAsociados))
		{
			$modelRecaudo = Actividad::model();
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodoRecaudo('.$id.','.$idProceso.')')),
				'recaudos' => '<i>No hay recaudos disponibles</i>',
				'recaudosSeleccionados' => CHtml::activeCheckBoxList($modelRecaudo, '_recaudosSeleccionados',
				   	CHtml::listData($recaudosAsociados, 'id_recaudo', 'nombre_recaudo'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"deseleccionarRecaudo($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				
			);
		}
		else
		{
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false),
				'recaudos' => '<i>No hay recaudos disponibles</i>',
				'recaudosSeleccionados' => '<i>No se ha seleccionado ningún recaudo</i>',
				
			);
		}
		
		echo CJSON::encode($result);
	}

	public function actionAsociarRecaudo()
	{
		$result = array('success' => false);

		$idRecaudo = explode(',', $_POST['idRecaudo']);
		$idActividad = $_POST['idActividad'];
		$idProceso = $_POST['idProceso'];

		$flag=0;

		foreach ($idRecaudo as $key => $value) 
		{
		
			$modelProcesoRecaudo = ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$idProceso, 'id_recaudo'=>$value));

			if($modelProcesoRecaudo)
			{
				$command = new RecaudoActividad();
				$command->id_proceso_recaudo = $modelProcesoRecaudo->id_proceso_recaudo;
				$command->id_actividad = $idActividad;

				if(!$command->save())
				{
					//$result = array('success' => true);
					$flag=1;
				}
			}
		}

		if($flag==0)
		{
			$result = array('success' => true);
		}

		echo CJSON::encode($result);
	}

	public function actionDesasociarRecaudo()
	{
		$result = array('success' => false);

		$idRecaudo = $_POST['idRecaudo'];
		$idActividad = $_POST['idActividad'];
		$idProceso = $_POST['idProceso'];

		$modelProcesoRecaudo = ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$idProceso, 'id_recaudo'=>$idRecaudo));

		if($modelProcesoRecaudo)
		{

			if(RecaudoActividad::model()->deleteAllByAttributes(array('id_proceso_recaudo'=>$modelProcesoRecaudo->id_proceso_recaudo, 'id_actividad'=>$idActividad)))
			{
				$result = array('success' => true);
			}
		}

		echo CJSON::encode($result);
	}

	public function actionListarDato($id, $idProceso)
	{
		$result = array('success' => false);

		$idDatoActividad = DatoActividad::model()->find(array('select'=>"array_to_string(array_agg(id_proceso_dato_adicional), ',') as id_proceso_dato_adicional", 'condition'=>'id_actividad = '.$id));

		if(!$idDatoActividad || $idDatoActividad->id_proceso_dato_adicional=="")
		{
			$idDatos = ProcesoDatoAdicional::model()->find(array('select'=>"array_to_string(array_agg(id_dato_adicional), ',') as id_dato_adicional", "condition"=>"id_proceso = ".$idProceso));

			if($idDatos && $idDatos->id_dato_adicional!="")
				$datosNoAsociados=DatoAdicional::model()->findAll(array('condition'=>'id_dato_adicional IN('.$idDatos->id_dato_adicional.')'));
		}
		else
		{
			$idDatos = ProcesoDatoAdicional::model()->find(array('select'=>"array_to_string(array_agg(id_dato_adicional), ',') as id_dato_adicional", "condition"=>"id_proceso = ".$idProceso." AND id_proceso_dato_adicional not IN(".$idDatoActividad->id_proceso_dato_adicional.")"));
			$idDatosAsociados = ProcesoDatoAdicional::model()->find(array('select'=>"array_to_string(array_agg(id_dato_adicional), ',') as id_dato_adicional", "condition"=>"id_proceso_dato_adicional IN(".$idDatoActividad->id_proceso_dato_adicional.")"));

			if($idDatos && $idDatos->id_dato_adicional!="")
				$datosNoAsociados=DatoAdicional::model()->findAll(array('condition'=>'id_dato_adicional IN('.$idDatos->id_dato_adicional.')'));

			if($idDatosAsociados && $idDatosAsociados->id_dato_adicional!="")
				$datosAsociados=DatoAdicional::model()->findAll(array('condition'=>'id_dato_adicional IN('.$idDatosAsociados->id_dato_adicional.')'));
		}

		if(isset($datosNoAsociados) && isset($datosAsociados))
		{
			$modelDato = Actividad::model();
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodoDato('.$id.','.$idProceso.')')),
				'datos' => CHtml::activeCheckBoxList($modelDato, '_datos',
				   	CHtml::listData($datosNoAsociados, 'id_dato_adicional', 'nombre_dato_adicional'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"seleccionarDato($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				'datosSeleccionados' => CHtml::activeCheckBoxList($modelDato, '_datosSeleccionados',
				   	CHtml::listData($datosAsociados, 'id_dato_adicional', 'nombre_dato_adicional'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"deseleccionarDato($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				
			);
			
		}
		else if(isset($datosNoAsociados))
		{
			$modelDato = Actividad::model();
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodoDato('.$id.','.$idProceso.')')),
				'datos' => CHtml::activeCheckBoxList($modelDato, '_datos',
				   	CHtml::listData($datosNoAsociados, 'id_dato_adicional', 'nombre_dato_adicional'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"seleccionarDato($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				'datosSeleccionados' => '<i>No se ha seleccionado ningún dato adicional</i>',
				
			);
		}
		else if(isset($datosAsociados))
		{
			$modelDato = Actividad::model();
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodoDato('.$id.','.$idProceso.')')),
				'datos' => '<i>No hay datos adicionales disponibles</i>',
				'datosSeleccionados' => CHtml::activeCheckBoxList($modelDato, '_datosSeleccionados',
				   	CHtml::listData($datosAsociados, 'id_dato_adicional', 'nombre_dato_adicional'),
				   	array('separator'=>'',
				      	'style'=>'float:left; margin-right: 5px;',
				      	'onChange'=>"deseleccionarDato($(this).attr('value'),".$id.",".$idProceso.")",
				   	)       
				),
				
			);
		}
		else
		{
			$result = array('success' => true,

				'seleccionar' => CHtml::checkBox('_chequear',false),
				'datos' => '<i>No hay datos adicionales disponibles</i>',
				'datosSeleccionados' => '<i>No se ha seleccionado ningún dato adicional</i>',
				
			);
		}
		
		echo CJSON::encode($result);
	}

	public function actionListarNotificacion($id, $idProceso)
	{
		$result = array('success' => false, 'idActividad' => $id, 'idProceso' => $idProceso);

		$idNotificacionActividad = NotificacionActividad::model()->find(array('select'=>"array_to_string(array_agg(id_notificacion), ',') as id_notificacion, array_to_string(array_agg(id_notificacion_actividad), ',') as id_notificacion_actividad", 'condition'=>'id_actividad = '.$id));

		if($idNotificacionActividad && $idNotificacionActividad->id_notificacion!="")		
		{
			$idTipoNotificacion = Notificacion::model()->find(array('select' => 'id_tipo_notificacion', 'condition'=>'id_notificacion IN('.$idNotificacionActividad->id_notificacion.')'));

			if(isset($idTipoNotificacion))
			{
				//$notificacion = explode(',', $idNotificacionActividad->id_notificacion);
				$correo = DatoNotificacionActividad::model()->find(array('select' => 'id_proceso_dato_adicional', 'condition'=>'id_notificacion_actividad IN('.$idNotificacionActividad->id_notificacion_actividad.')'));

				if(isset($correo))
				{
					$idCorreo = $correo->id_proceso_dato_adicional;
				}
				else
				{
					$idCorreo = "";
				}

				$result = array(
					'success' => true,
					'idTipoNotificacion' => $idTipoNotificacion->id_tipo_notificacion,
					'idNotificacion' => $idNotificacionActividad->id_notificacion,
					'idActividad' => $id,
					'idProceso' => $idProceso,
					'idCorreo' => $idCorreo
				);
			}
		}
		
		echo CJSON::encode($result);
	}


	public function actionAsociarNotificacion()
	{
		$result = array('success' => false);

		$idNotificacion = explode(',', $_POST['idNotificacion']);
		$correo = $_POST['correo'];
		$idActividad = $_POST['idActividad'];
		$idProceso = $_POST['idProceso'];

		$flag=0;

		$transaction=Yii::app()->db->beginTransaction();

		$notificacionActvidad = NotificacionActividad::model()->find(array('select'=>"array_to_string(array_agg(id_notificacion_actividad), ',') as id_notificacion_actividad", 'condition'=>'id_actividad = '.$idActividad));

		if($notificacionActvidad && $notificacionActvidad->id_notificacion_actividad!="")		
		{
			DatoNotificacionActividad::model()->deleteAll('id_notificacion_actividad in('.$notificacionActvidad->id_notificacion_actividad.')'/*, array('notificacionActvidad' => $notificacionActvidad->id_notificacion_actividad)*/);
			
			if(!NotificacionActividad::model()->deleteAllByAttributes(array('id_actividad'=>$idActividad)))
			{
				$result = array('success' => false, 'message' => 'No se pudo eliminar las notificaciones asociadas a la actividad.');
				$flag = 1;
			}
		}

		if($_POST['idNotificacion'] != "")
		{	
			foreach ($idNotificacion as $key => $value) 
			{
				$command = new NotificacionActividad();
				$command->id_notificacion = $value;
				$command->id_actividad = $idActividad;

				if($command->save())
				{
					$notificacion = Notificacion::model()->findByPk($value);

					if($notificacion && $notificacion->es_dato_adicional==1)
					{
						$sql="INSERT into dato_notificacion_actividad (id_notificacion_actividad, id_proceso_dato_adicional) 
									values ('$command->id_notificacion_actividad', '$correo')";
							
						if(!Yii::app()->db->createCommand($sql)->execute())
						{
							$result = array('success' => false, 'message' => 'No se pudo actualizar el correo asociado a la notificación.');
							$flag=1;
						}
					} 
				}
				else
				{
					$result = array('success' => false, 'message' => 'No se pudo actualizar las notificaiones asociadas a la actividad.');
					$flag = 1;
				}
				
			}
		}

		if($flag==0)
		{
			$transaction->commit();
			$result = array('success' => true);
		}
		else
		{
			$transaction->rollback();
		}

		echo CJSON::encode($result);
	}


	public function actionAsociarDato()
	{
		$result = array('success' => false);

		$idDato = explode(',', $_POST['idDato']);
		$idActividad = $_POST['idActividad'];
		$idProceso = $_POST['idProceso'];

		$flag=0;

		foreach ($idDato as $key => $value) 
		{
			$modelProcesoDato = ProcesoDatoAdicional::model()->findByAttributes(array('id_proceso'=>$idProceso, 'id_dato_adicional'=>$value));

			if($modelProcesoDato)
			{
				$command = new DatoActividad();
				$command->id_proceso_dato_adicional = $modelProcesoDato->id_proceso_dato_adicional;
				$command->id_actividad = $idActividad;

				if(!$command->save())
				{
					$flag=1;
				}
			}
		}

		if($flag==0)
		{
			$result = array('success' => true);
		}

		echo CJSON::encode($result);
	}


	public function actionDesasociarDato()
	{
		$result = array('success' => false);

		$idDato = $_POST['idDato'];
		$idActividad = $_POST['idActividad'];
		$idProceso = $_POST['idProceso'];

		$modelProcesoDato = ProcesoDatoAdicional::model()->findByAttributes(array('id_proceso'=>$idProceso, 'id_dato_adicional'=>$idDato));

		if($modelProcesoDato)
		{

			if(DatoActividad::model()->deleteAllByAttributes(array('id_proceso_dato_adicional'=>$modelProcesoDato->id_proceso_dato_adicional, 'id_actividad'=>$idActividad)))
			{
				$result = array('success' => true);
			}
		}

		echo CJSON::encode($result);
	}

	

	public function actionDelete2($id)
	{
		$result = array('success' => false);

		$model=$this->loadModel($id);

		if(Yii::app()->request->isPostRequest)
		{
			$sqlActFin = "SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'"; 
	    	$actFin = Yii::app()->db->createCommand($sqlActFin)->queryRow();	
			
	    	$actividades = Actividad::model()->find(array("select"=>"array_to_string(array_agg(id_actividad), ',') as id_actividad", "condition"=>"id_proceso = ".$model->id_proceso));
	    	
	    	if($actividades && $actividades['id_actividad']!="")
				$procModelado=ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones", "condition"=>"id_actividad_origen in(".$actividades['id_actividad'].") and id_actividad_destino in(".$actividades['id_actividad'].")"));
			
			$query="SELECT count(*) as _cant FROM instancia_proceso WHERE id_proceso = ".$model->id_proceso;
			$inst_proc = Yii::app()->db->createCommand($query)->queryRow();	


			$modelado=ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones, array_to_string(array_agg(id_modelo_estado_actividad), ',') as id_modelo_estado_actividad, array_to_string(array_agg(id_actividad_origen), ',') as id_actividad_origen", "condition"=>"id_actividad_destino = ".$id));


			if($modelado && $modelado['_transiciones']>1)
			{
				$result = array('success' => false, 'message' => 'No se puede eliminar el registro. La actividad está siendo utilizada como "Actividad Destino" en mas de 1 transición');
			}
			else if ($inst_proc['_cant']>0 ) 
			{
				$result = array('success' => false, 'message' => 'No se puede eliminar el registro. Existen procesos iniciados que utilizan la actividad');
			}
			else if ( (isset($procModelado) && $procModelado['_transiciones']>0 && ($model->es_inicial==1 || $model->es_inicial_reconsideracion==1 )) ) 
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. Es una actividad inicial');
			}
			else if ($model->codigo_actividad==$actFin['valor']) 
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. Es una actividad final');
			}
			else
			{
				$sqlActPendiente = "SELECT valor FROM configuracion WHERE variable = 'id_estado_actividad_pendiente'"; 
	    		$actPendiente = Yii::app()->db->createCommand($sqlActPendiente)->queryRow();	

				$transiciones = ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones, array_to_string(array_agg(id_modelo_estado_actividad), ',') as id_modelo_estado_actividad, array_to_string(array_agg(id_actividad_destino), ',') as id_actividad_destino", "condition"=>"id_actividad_origen = ".$id));
				

				if($transiciones['_transiciones']>1)
				{

					$result = array('success' => true, 'modal' => true,
						'transicion' => CHtml::radioButtonList('_transicion', '',
							CHtml::listData(Actividad::model()->findAll(array('condition'=>'id_actividad in('.$transiciones['id_actividad_destino'].')')), 'id_actividad', 'nombre_actividad'),
							array('separator'=>'',
								'style'=>'float:left; margin-right: 5px;',
								'onChange'=>'actividadSeleccionada()',
							)	
						),

						'continuar' => CHtml::button('Continuar', array('onClick'=>'continuar('.$modelado->id_modelo_estado_actividad.','.$id.')', 'class'=>'btn-primary', 'disabled'=>true, 'style'=>'cursor: default; opacity: 0.6', 'id'=>'btn-continuar')),
						'cancelar' => CHtml::button('Cancelar', array('onClick'=>'cancelar()', 'class'=>'btn-primary'))
					);

				}
				else if($transiciones['_transiciones']==1)
				{
					$transaction=Yii::app()->db->beginTransaction();

					if($modelado && $modelado['_transiciones']>0)
					{
						$update = ModeloEstadoActividad::model()->updateByPk($modelado->id_modelo_estado_actividad, array('id_actividad_destino' => $transiciones['id_actividad_destino'], 'id_estado_actividad_inicial' => $actPendiente['valor']) );
					}
					
					$deleteTransicion = Yii::app()->db->createCommand('select delete_transicion('.$transiciones['id_modelo_estado_actividad'].')')->query();
					
					$delete = Yii::app()->db->createCommand('select delete_actividad('.$id.')')->query();

					if( (($modelado['_transiciones']>0 && $update) || $modelado['_transiciones']==0 ) && $deleteTransicion && $delete)
					{
						$transaction->commit();

						$result = array('success' => true, 'message' => 'Registro eliminado satisfactoriamente.');
					}
					else
					{
						$transaction->rollback();
					}

				}
				else
				{
					$delete=Yii::app()->db->createCommand('select delete_actividad('.$id.')')->query();

					$result = array('success' => true, 'message'=>'Registro eliminado satisfactoriamente.');
				}

				
			}

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

		echo CJSON::encode($result);
	}

	public function actionDeleteTransicion()
	{
		$result = array('success' => false, 'message' => 'No se puede eliminar el registro.');

		$id_modelo = $_POST['id_modelo'];
		$id_actividad = $_POST['id_actividad'];
		$id_actividad_destino = $_POST['id_actividad_destino'];

		$sqlActPendiente = "SELECT valor FROM configuracion WHERE variable = 'id_estado_actividad_pendiente'"; 
	    $actPendiente = Yii::app()->db->createCommand($sqlActPendiente)->queryRow();	
		
		$transaction=Yii::app()->db->beginTransaction();

		$update = ModeloEstadoActividad::model()->updateByPk($id_modelo, array('id_actividad_destino' => $id_actividad_destino, 'id_estado_actividad_inicial' => $actPendiente['valor']) );

		$transiciones = ModeloEstadoActividad::model()->findAll(array("condition"=>"id_actividad_origen = ".$id_actividad));

		$deleteTransicion = true;
		if($transiciones)
		{
			foreach ($transiciones as $key => $value) 
			{
				$delete=Yii::app()->db->createCommand('select delete_transicion('.$value['id_modelo_estado_actividad'].')')->query();

				if(!$delete)
				{
					$deleteTransicion = false;
				}
			}
		}

		$delete2=Yii::app()->db->createCommand('select delete_actividad('.$id_actividad.')')->query();

		if($update && $deleteTransicion && $delete2)
		{
			$transaction->commit();

			$result = array('success' => true, 'message' => 'Registro eliminado satisfactoriamente.');
		}
		else
		{
			$transaction->rollback();
		}

		echo CJSON::encode($result);

	}

	/**
	 * Suspencion de actividades
	 */
	public function actionSuspender($id)
	{
		$result = array('success' => false);

		$model=$this->loadModel($id);

		if(Yii::app()->request->isPostRequest)
		{
			$sqlActFin = "SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'"; 
	    	$actFin = Yii::app()->db->createCommand($sqlActFin)->queryRow();	
			
			// PARA NO SUSPENDER CUANDO EXISTA UNA INSTANCIA PENDIENTE
			$instanciaActividadPendiente = InstanciaActividad::model()->findByAttributes(array("id_actividad"=>$id, "ejecutada"=>0));
		
			$modelado=ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones, array_to_string(array_agg(id_modelo_estado_actividad), ',') as id_modelo_estado_actividad, array_to_string(array_agg(id_actividad_origen), ',') as id_actividad_origen, array_to_string(array_agg(id_estado_actividad_salida), ',') as id_estado_actividad_salida, array_to_string(array_agg(transicion_temporal), ',') as transicion_temporal", "condition"=>"id_actividad_destino = ".$id." and activo_transicion = 1"));
			

			if($modelado && $modelado['_transiciones']>1)
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. La actividad está siendo utilizada como "Actividad Destino" en mas de 1 transición');
			}
			else if($model->es_inicial==1)
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. Es una actividad inicial');
			}
			/*else if ($model->es_inicial_reconsideracion==1) 
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. Es una actividad inicial de Recurso de Reconsideración');
			}*/
			else if ($model->codigo_actividad==$actFin['valor']) 
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. Es una actividad final');
			}
			else if($instanciaActividadPendiente)
			{
				$result = array('success' => false, 'message' => 'No se puede suspender. Existen actividades en ejecución');
			}
			else
			{
				$sqlActPendiente = "SELECT valor FROM configuracion WHERE variable = 'id_estado_actividad_pendiente'"; 
	    		$actPendiente = Yii::app()->db->createCommand($sqlActPendiente)->queryRow();	

				$transiciones = ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones, array_to_string(array_agg(id_modelo_estado_actividad), ',') as id_modelo_estado_actividad, array_to_string(array_agg(id_actividad_destino), ',') as id_actividad_destino, array_to_string(array_agg(transicion_temporal), ',') as transicion_temporal", "condition"=>"id_actividad_origen = ".$id." and activo_transicion = 1"));
				

				if($transiciones['_transiciones']>1)
				{
					if($modelado->id_modelo_estado_actividad == "")
						$modelado->id_modelo_estado_actividad = -1;

					$result = array('success' => true, 'modal' => true,
						'transicion' => CHtml::radioButtonList('_transicion', '',
							CHtml::listData(Actividad::model()->findAll(array('condition'=>'id_actividad in('.$transiciones['id_actividad_destino'].')')), 'id_actividad', 'nombre_actividad'),
							array('separator'=>'',
								'style'=>'float:left; margin-right: 5px;',
								'onChange'=>'actividadSeleccionada()',
							)	
						),

						'continuar' => CHtml::button('Continuar', array('onClick'=>'continuarSuspension('.$modelado->id_modelo_estado_actividad.','.$id.')', 'class'=>'btn-primary', 'disabled'=>true, 'style'=>'cursor: default; opacity: 0.6', 'id'=>'btn-continuar')),
						'cancelar' => CHtml::button('Cancelar', array('onClick'=>'cancelar()', 'class'=>'btn-primary'))
					);

				}
				else if($transiciones['_transiciones']==1)
				{
					$transaction=Yii::app()->db->beginTransaction();

					if($modelado && $modelado['_transiciones']>0)
					{
						//update actividad y modelo_estado_actividad
						
						if($modelado->transicion_temporal!=1)
						{
							$updateTransicion = ModeloEstadoActividad::model()->updateByPk($modelado->id_modelo_estado_actividad, array('activo_transicion'=>0, 'id_actividad_suspendida'=>$id));
						}
						else
						{
							$updateTransicion = ModeloEstadoActividad::model()->updateByPk($modelado->id_modelo_estado_actividad, array('activo_transicion'=>0));
						}

						$transicionExistente = ModeloEstadoActividad::model()->findByAttributes(array('id_actividad_origen'=>$modelado['id_actividad_origen'], 'id_actividad_destino'=>$transiciones['id_actividad_destino']));
						
						if(!$transicionExistente)
						{
							$transicionTemp = new ModeloEstadoActividad();
							$transicionTemp->id_actividad_origen = $modelado['id_actividad_origen'];
							$transicionTemp->id_actividad_destino = $transiciones['id_actividad_destino'];
							$transicionTemp->id_estado_actividad_salida = $modelado['id_estado_actividad_salida'];
							$transicionTemp->id_estado_actividad_inicial = $actPendiente['valor'];
							$transicionTemp->activo_transicion = 1;
							$transicionTemp->id_actividad_suspendida = $id;
							$transicionTemp->transicion_temporal = 1;
							$transicionTemp->espera_destino = 0;
						}

					}
					else //NUEVO POR CREAR NUEVA TRANS ASI ORIGEN = 0
					{
				    	$modelado2=ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones, array_to_string(array_agg(id_actividad_origen), ',') as id_actividad_origen, array_to_string(array_agg(id_estado_actividad_salida), ',') as id_estado_actividad_salida", "condition"=>"id_actividad_destino = ".$id_actividad." and activo_transicion = 0"));

				    	if($modelado2 && $modelado2->_transiciones==1)
				    	{

				    		$transicionExistente = ModeloEstadoActividad::model()->findByAttributes(array('id_actividad_origen'=>$modelado2['id_actividad_origen'], 'id_actividad_destino'=>$transiciones['id_actividad_destino']));
						
							if(!$transicionExistente)
							{

					    		$transicionTemp = new ModeloEstadoActividad();
								$transicionTemp->id_actividad_origen = $modelado2['id_actividad_origen'];
								$transicionTemp->id_actividad_destino = $transiciones['id_actividad_destino'];
								$transicionTemp->id_estado_actividad_salida = $modelado2['id_estado_actividad_salida'];
								$transicionTemp->id_estado_actividad_inicial = $actPendiente['valor'];
								$transicionTemp->activo_transicion = 0;
								$transicionTemp->id_actividad_suspendida = $id;
								$transicionTemp->transicion_temporal = 1;
								$transicionTemp->espera_destino = 0;
							}
				    	}//AGREGAR TRANS TEM
					}

					if($transiciones->transicion_temporal!=1)
					{
						$updateTransicion2 = ModeloEstadoActividad::model()->updateByPk($transiciones->id_modelo_estado_actividad, array('activo_transicion'=>0, 'id_actividad_suspendida'=>$id));
					}
					else
					{
						$updateTransicion2 = ModeloEstadoActividad::model()->updateByPk($transiciones->id_modelo_estado_actividad, array('activo_transicion'=>0));
					}

					$updateAct = Actividad::model()->updateByPk($id, array('activo'=>0));


					if( ( ($modelado['_transiciones']>0 && $updateTransicion && ( (!$transicionExistente && $transicionTemp->save()) || $transicionExistente )) || (/*$modelado['_transiciones']==0 &&*/ $modelado2->_transiciones==1 && ((!$transicionExistente && $transicionTemp->save()) || $transicionExistente ) ) || $modelado['_transiciones']==0) && $updateTransicion2 && $updateAct)
					{
						$transaction->commit();

						$result = array('success' => true, 'message' => 'Registro suspendido satisfactoriamente.');
					}
					else
					{
						$transaction->rollback();
						$result = array('success' => false, 'message' => 'No se pudo suspender el registro.');
					}

				}
				else
				{
					$updateAct = Actividad::model()->updateByPk($id, array('activo'=>0));

					$result = array('success' => true, 'message'=>'Registro suspendido satisfactoriamente.');
				}

				
			}

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

		echo CJSON::encode($result);
	}


	public function actionSuspenderTransicion()
	{
		$result = array('success' => false, 'message' => 'No se puede suspender el registro.');

		$id_modelo = $_POST['id_modelo'];
		$id_actividad = $_POST['id_actividad'];
		$id_actividad_destino = $_POST['id_actividad_destino'];

		$sqlActPendiente = "SELECT valor FROM configuracion WHERE variable = 'id_estado_actividad_pendiente'"; 
	    $actPendiente = Yii::app()->db->createCommand($sqlActPendiente)->queryRow();	

	    $actTemp = 1;
	    if($id_modelo == -1)
	    {
	    	$actTemp = 0;
	    	$modelado=ModeloEstadoActividad::model()->find(array("select"=>"count(*) as _transiciones, array_to_string(array_agg(id_modelo_estado_actividad), ',') as id_modelo_estado_actividad", "condition"=>"id_actividad_destino = ".$id_actividad." and activo_transicion = 0"));

	    	if($modelado && $modelado->_transiciones==1)
	    	{
	    		$id_modelo = $modelado->id_modelo_estado_actividad;
	    	}
	    }

	    $modelo = ModeloEstadoActividad::model()->findByPk($id_modelo);
		
		$transaction=Yii::app()->db->beginTransaction();


		if($modelo)
		{
			$transicionTemp = new ModeloEstadoActividad();
			$transicionTemp->id_actividad_origen = $modelo->id_actividad_origen;
			$transicionTemp->id_actividad_destino = $id_actividad_destino;

			$transicionTemp->id_estado_actividad_salida = $modelo->id_estado_actividad_salida;
			$transicionTemp->id_estado_actividad_inicial = $actPendiente['valor'];
			$transicionTemp->activo_transicion = $actTemp;
			$transicionTemp->id_actividad_suspendida = $id_actividad;
			$transicionTemp->transicion_temporal = 1;
			$transicionTemp->espera_destino = 0;
		}


		$transiciones = ModeloEstadoActividad::model()->findAll(array("condition"=>"id_actividad_origen = ".$id_actividad." or id_actividad_destino = ".$id_actividad));


		$suspenderTransicion = true;
		if($transiciones)
		{
			foreach ($transiciones as $key => $value) 
			{
				if($value['transicion_temporal']!=1)
				{
					$updateTransicion = ModeloEstadoActividad::model()->updateByPk($value['id_modelo_estado_actividad'], array('activo_transicion'=>0, 'id_actividad_suspendida'=>$id_actividad));
				}
				else 
				{
					$updateTransicion = ModeloEstadoActividad::model()->updateByPk($value['id_modelo_estado_actividad'], array('activo_transicion'=>0));
				}

				if(!$updateTransicion)
				{
					$suspenderTransicion = false;
				}
			}
		}

		$transicion = ModeloEstadoActividad::model()->findAll(array('condition' =>  'id_actividad_destino = '.$id_actividad.' and transicion_temporal = 1'));

		if($transicion)
			$updatetransicion = ModeloEstadoActividad::model()->updateAll(array('activo_transicion'=>0), 'id_actividad_destino = '.$id_actividad.' and transicion_temporal = 1');


		$updateAct = Actividad::model()->updateByPk($id_actividad, array('activo'=>0));

		if( (($modelo && $transicionTemp->save()) || !$modelo) && $suspenderTransicion && (($transicion && $updatetransicion) || !$transicion) && $updateAct)
		{
			$transaction->commit();

			$result = array('success' => true, 'message' => 'Registro suspendido satisfactoriamente.');
		}
		else
		{
			$transaction->rollback();
		}

		echo CJSON::encode($result);

	}

	public function actionActivar($id)
	{
		$result = array('success' => false);

		$model=$this->loadModel($id);

		// 1. activar no temp con ID (origen/destino != 0) 	
		// 2. activar temp donde destino = ID 				
		// 3. modificar temp origen = no temp 				
		// 4. quitar ID cuando no temp = 1					
		// 5. borrar temp con ID = ID 						
		// 6. activar no temp donde origen/destino = 1
		// 7. activar temp donde origen = ID

		$transiciones = ModeloEstadoActividad::model()->findAll(array("condition"=>"id_actividad_suspendida = ".$id));

		$transaction=Yii::app()->db->beginTransaction();

		$updateAct = Actividad::model()->updateByPk($id, array('activo'=>1));

		$activarTransicion = true;
		$origenNoTemp = "";

		foreach ($transiciones as $key => $value) 
		{
			if($value['transicion_temporal'] == 0)// ITEM 1
			{
				$origenNoTemp .= $value['id_actividad_origen'] .",";
				$actOrigen = Actividad::model()->findByPk($value['id_actividad_origen']);
				$actDestino = Actividad::model()->findByPk($value['id_actividad_destino']);

				if($actOrigen->activo == 1 && $actDestino->activo == 1)
				{
					$expression = new CDbExpression('NOW("null")'); //ITEM 4
					$updateTransicion = ModeloEstadoActividad::model()->updateByPk($value['id_modelo_estado_actividad'], array('activo_transicion'=>1, 'id_actividad_suspendida'=>null));

					if(!$updateTransicion)
					{
						$activarTransicion = false;
					}
				}

			}
			else //ITEM 5
			{
				$delete=Yii::app()->db->createCommand('select delete_transicion('.$value['id_modelo_estado_actividad'].')')->query();

				if(!$delete)
				{
					$activarTransicion = false;
				}
		
			}

		}


		//ITEM 2 Y 7
		$transicionTemp = ModeloEstadoActividad::model()->findAll(array('condition' =>  '(id_actividad_origen = '.$id.' or id_actividad_destino = '.$id.') and transicion_temporal = 1'));

		if($transicionTemp)
			$updateTransicionTemp = ModeloEstadoActividad::model()->updateAll(array('activo_transicion'=>1), '(id_actividad_origen = '.$id.' or id_actividad_destino = '.$id.') and transicion_temporal = 1'); //ModeloEstadoActividad::model()->findAll(array("condition"=>"transicion_temporal = 1 and id_actividad_destino = ".$id));


		//ITEM 3
		if($origenNoTemp != "")
		{
			$origenNoTemp = substr($origenNoTemp, 0, -1);

			$transicionTemp2 = ModeloEstadoActividad::model()->findAll(array("condition" => "id_actividad_origen in(".$origenNoTemp.") and transicion_temporal = 1"));
			
			if($transicionTemp2)
				$updateTransicionTemp2 = ModeloEstadoActividad::model()->updateAll(array('id_actividad_origen'=>$id), 'id_actividad_origen in('.$origenNoTemp.') and transicion_temporal = 1'); 
		}

			
		//ITEM 6
		$transicionesSusp = ModeloEstadoActividad::model()->findAll(array("condition"=>"(id_actividad_origen = ".$id." or id_actividad_destino = ".$id.") and activo_transicion = 0  and transicion_temporal = 0"));
		$activarTransicion2 = true;

		if($transicionesSusp)
		{
			foreach ($transicionesSusp as $key => $value) 
			{
				$actOrigen = Actividad::model()->findByPk($value['id_actividad_origen']);
				$actDestino = Actividad::model()->findByPk($value['id_actividad_destino']);

				if($actOrigen->activo == 1 && $actDestino->activo == 1)
				{
					$updateTransicion = ModeloEstadoActividad::model()->updateByPk($value['id_modelo_estado_actividad'], array('activo_transicion'=>1, 'id_actividad_suspendida'=>null));

					if(!$updateTransicion)
					{
						$activarTransicion2 = false;
					}
				}
			}
		}

			

		if($updateAct && $activarTransicion && $activarTransicion2 && (($transicionTemp && $updateTransicionTemp) || !$transicionTemp) && ((isset($transicionTemp2) && $transicionTemp2 && $updateTransicionTemp2) || (!isset($transicionTemp2) || !$transicionTemp2)) )
		{
			$transaction->commit();

			$result = array('success' => true, 'message' => 'Registro activado satisfactoriamente.');
		}
		else
		{
			$transaction->rollback();

			$result = array('success' => false, 'message' => 'No se puede activar el registro.');
		}


		echo CJSON::encode($result);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Actividad');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Actividad('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Actividad']))
			$model->attributes=$_GET['Actividad'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Actividad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Actividad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Actividad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='actividad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
