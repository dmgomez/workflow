<?php

class InstanciaActividadController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update', 'admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = VisInstanciaActividad::model()->findByAttributes(array('id_instancia_actividad' => $id));
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'admin' page.
	 */
	public function actionCreate()
	{
		$model=new InstanciaActividad;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InstanciaActividad']))
		{
			$model->attributes=$_POST['InstanciaActividad'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionGetEmpleadoAsig($id)
	{

		$model = new InstanciaActividad();
    	$r = $model->getEmpleadosAsig($id);
    	//$r = array(array('value'=> 0, 'text' => '-- Seleccione --'));
		echo json_encode($r);
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateRecord()
	{
		
		if(isset($_POST['name']) && $_POST['name'] == 'id_empleado')
		{
			try
			{
				$connection = yii::app()->db;
				$sql = "UPDATE instancia_actividad SET id_empleado = '";
				$sql = $sql.$_POST['value']."' WHERE id_instancia_actividad =".$_POST['pk'];
				$command=$connection->createCommand($sql);
				$command->execute();
			}
			catch (Exception $e) 
			{
				throw new CHttpException(999, $e->getMessage());
			}
    		
		}
		
	}

	private function actualizarRecaudos($modelInstanciaProceso, $model)
	{
		if($model->consignado!=null)
			InstanciaRecaudo::model()->updateAll(array('consignado' =>'0'), 'id_instancia_proceso='.$modelInstanciaProceso->id_instancia_proceso);//, 'id_instancia_recaudo IN ('.$model2->consignado.')' );WHERE INSTANCIA_ACTIVIDAD
		if($model->_recaudosSeleccionados!="")
			InstanciaRecaudo::model()->updateAll(array('consignado' =>'1'), 'id_instancia_recaudo IN ('.$model->_recaudosSeleccionados.')' );

	}

	private function buscarEmpleadoActividad($idEmpleadoAct, $estadoTransicion, $model)
	{
		$idEmpleado="";

		$rolAct = ActividadRol::model()->findAllByAttributes(array('id_actividad'=>$estadoTransicion['id_actividad_destino']));

		if($rolAct)
		{
			foreach ($rolAct as $value) 
			{
				$idRol[]=$value['id_rol'];
			}
			
			if($idEmpleadoAct)
			{
				$empleadoRol = EmpleadoRol::model()->findByAttributes(array('id_empleado'=>$idEmpleadoAct->id_empleado, 'id_rol'=>$idRol));
			}

			if($empleadoRol)
			{
				$idEmpleado=$empleadoRol->id_empleado;
			}

			else
			{
				$rolString = implode(',', $idRol);
				$empleadoRol = EmpleadoRol::model()->find(array("select"=>"array_to_string(array_agg(id_empleado), ',') as _empleado", "condition"=>"id_rol in (".$rolString.")"));

				if($empleadoRol && $empleadoRol->_empleado!="")
				{
					$prioridadEmpleado = InstanciaActividad::model()->find('id_instancia_proceso = '.$model->id_instancia_proceso.' AND id_empleado IN('.$empleadoRol->_empleado.')');
				}

				if(isset($prioridadEmpleado) && $prioridadEmpleado)
				{
					$usuario = Empleado::model()->findByPk($prioridadEmpleado['id_empleado']);

					if($usuario)
					{
						$queryUsuarioActivo="SELECT state from cruge_user where iduser = ".$usuario->id_usuario;
						$usuarioActivo = Yii::app()->db->createCommand($queryUsuarioActivo)->queryRow();

						if($usuarioActivo && $usuarioActivo['state']==1)
							$idEmpleado = $prioridadEmpleado['id_empleado'];
					}

					
				}
				//else
				if($idEmpleado=="")
				{

					$empleadoRol = EmpleadoRol::model()->findAllByAttributes(array('id_rol'=>$idRol));

					if($empleadoRol) 
					{
						$cargaEmpleado=-1;
						foreach ($empleadoRol as $value) 
						{
							$result = InstanciaActividad::model()->findAllByAttributes(array("ejecutada" => "0", "id_empleado" => $value['id_empleado']));
							if ($result) 
							{
								$count=count($result);
							}
							else
							{
								$count=0;
							}

							$usuario = Empleado::model()->findByPk($value['id_empleado']);

							if($usuario)
							{
								$queryUsuarioActivo="SELECT state from cruge_user where iduser = ".$usuario->id_usuario;
								$usuarioActivo = Yii::app()->db->createCommand($queryUsuarioActivo)->queryRow();

								if(($cargaEmpleado>$count || $cargaEmpleado==-1) && ($usuarioActivo && $usuarioActivo['state']==1))
								{
									$cargaEmpleado=$count;
									$idEmpleado=$value['id_empleado'];
								}
							}
						}
					}
				}
			}
		}

		return $idEmpleado;
		
	}

	public function SendMail($model, $nombre, $tipo, $email, $tipo_mensaje)
    { 
    	set_time_limit (0);
    	$sqlCabecera="SELECT * from cabecera_reporte";
		$cabecera = Yii::app()->db->createCommand($sqlCabecera)->queryRow();


    	if($tipo==1)
    	{
    		$estado = 'Iniciada';
    	}  
    	else
    	{
    		$estado = 'Finalizada';
    	}

        $message = new YiiMailMessage;

       	$image = Swift_Image::fromPath(dirname(Yii::app()->getBasePath()) . '/images/logos/logo_CFP.jpg');
        $cid = $message->embed($image); 
        $imageS = Swift_Image::fromPath(dirname(Yii::app()->getBasePath()) . '/images/logos/'.$cabecera['ubicacion_logo']);
        $cidS = $message->embed($imageS); 
		$message->view = "notificacion";
        $params              = array('model'=>$model, 'nombre'=>$nombre, 'estado'=>$estado, 'tipo'=>$tipo_mensaje, 'cabecera'=>$cabecera, 'logo_cfp'=>$cid, 'logo'=>$cidS);
        $message->subject    = 'Notificación: Actividad '.$estado;
        $message->setBody($params, 'text/html');                
        $message->addTo($email);
        $message->from = 'pruebasistema@adamantium.com.ve';
        Yii::app()->mail->send($message);   



      /*  $message = new YiiMailMessage;
	    // Assumes 'someimage.jpg' exists in your 'images' directory.
	    $image = Swift_Image::fromPath(dirname(Yii::app()->getBasePath()) . '/images/someimage.jpg');
	    $cid = $message->embed($image);    
	    $message->view = 'test';
	    $message->setBody(array('cid' => $cid), 'text/html');
	    $message->subject = 'Example of embedded inline image';
	    $message->addTo('you@youremailaddress.com');
	    $message->from = Yii::app()->params['adminEmail'];    
	    Yii::app()->mail->send($message);   */ 
    }

	private function enviarNotificacion($notificacion, $id_instancia_actividad)
	{
		$model = VisInstanciaActividad::model()->findByAttributes(array('id_instancia_actividad'=>$id_instancia_actividad));
		$nombre = "";
		$tipo = "";

		$sqlTipoEmpleado="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_empleado'";
		$tipoEmpleado= Yii::app()->db->createCommand($sqlTipoEmpleado)->queryRow();
		$arrayTipoEmpleado = explode(',', $tipoEmpleado['valor']);

		$sqlTipoSuperior="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_superior'";
		$tipoSuperior= Yii::app()->db->createCommand($sqlTipoSuperior)->queryRow();
		$arrayTipoSuperior = explode(',', $tipoSuperior['valor']);

		$sqlTipoDirector="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_director'";
		$tipoDirector= Yii::app()->db->createCommand($sqlTipoDirector)->queryRow();
		$arrayTipoDirector = explode(',', $tipoDirector['valor']);

		$sqlTipoCorreo="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_correo'";
		$tipoCorreo= Yii::app()->db->createCommand($sqlTipoCorreo)->queryRow();
		$arrayTipoCorreo = explode(',', $tipoCorreo['valor']);
		
		$modelEmpleado = VisEmpleado::model()->findByAttributes(array('id_empleado'=>$model->id_empleado));
		
		foreach ($notificacion as $key => $value) 
		{
			if(in_array($value['id_notificacion'], $arrayTipoEmpleado))
			{
				$correo = $modelEmpleado->correo_persona;
				$nombre = $modelEmpleado->nombre_persona;
				$tipo = "empleado";
			}
			else if(in_array($value['id_notificacion'], $arrayTipoSuperior))
			{
				$correo = $modelEmpleado->correo_superior_inmediato;
				$nombre = $modelEmpleado->nombre_superior;
				$tipo = "superior";
			}
			else if(in_array($value['id_notificacion'], $arrayTipoDirector))
			{
				$sqlCrugeDirector="SELECT valor FROM configuracion WHERE variable = 'cruge_itemname_director'";
				$crugeDirector= Yii::app()->db->createCommand($sqlCrugeDirector)->queryRow();
		
				$modelEmpleado2 = VisEmpleado::model()->findByAttributes(array('rol_sistema'=>$crugeDirector['valor']/*, 'id_departamento'=>$modelEmpleado->id_departamento*/));
				
				if($modelEmpleado2)
				{
					$correo = $modelEmpleado2->correo_persona;
					$nombre = $modelEmpleado2->nombre_persona;
					$tipo = "director";
				}
				
			}
			else if(in_array($value['id_notificacion'], $arrayTipoCorreo))
			{
				if($value['es_dato_adicional'] == 1)
				{
					$modelDato = VisInstanciaDatoAdicional::model()->findByAttributes(array('id_proceso_dato_adicional'=>$value['id_proceso_dato_adicional'], 'id_instancia_proceso'=>$model->id_instancia_proceso));

					if($modelDato)
					{
						$correo = $modelDato->valor_dato_adicional;
						$tipo = "correo";
					}
				}
			}
			if(isset($correo) && $correo != '')
			{
				if(preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $correo))
				{ 
					$this->SendMail($model, $nombre, $value['id_tipo_notificacion'], $correo, $tipo);
				}
			}
		}
		
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout='//layouts/column1';
		
		$model=$this->loadModel($id);
		$modelInformacionActividad = VisInstanciaActividad::model()->findByAttributes(array('id_instancia_actividad' => $id));

		$modelInstanciaProceso = InstanciaProceso::model()->findByPk($model->id_instancia_proceso);

		$estadosTransicion=ModeloEstadoActividad::model()->findAllByAttributes(array("id_actividad_origen"=>$model->id_actividad));

		//PARA LOS HISTORIALES
		$modelHistDatos=new CActiveDataProvider(VisInstanciaDatoAdicional::model(), array(
			'keyAttribute'=>'id_instancia_dato_adicional',
			'criteria'=>array(
				'condition'=>"id_instancia_proceso=".$model->id_instancia_proceso." AND valor_dato_adicional <> '' AND tipo_dato_adicional <> 6",
			),
		));

		$modelHistArchivos=new CActiveDataProvider(VisInstanciaDatoAdicional::model(), array(
			'keyAttribute'=>'id_instancia_dato_adicional',
			'criteria'=>array(
				'condition'=>"id_instancia_proceso=".$model->id_instancia_proceso." AND valor_dato_adicional <> '' AND tipo_dato_adicional = 6",
			),
		));

		$modelObsActs=new CActiveDataProvider(VisObservacion::model(), array(
			'keyAttribute'=>'id',
			'criteria'=>array(
				'condition'=>"id=".$model->id_instancia_proceso." AND id_instancia_actividad <> ".$id." AND observacion <> ''",
			),
		));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InstanciaActividad']) /*&& $model2->_valor_dato_adicional!=null*/)
		{
			$model->attributes=$_POST['InstanciaActividad'];

			$estadoSalida = ModeloEstadoActividad::model()->find(array("select" => "array_to_string(array_agg(id_modelo_estado_actividad), ',') as id_modelo_estado_actividad", "condition" => "id_estado_actividad_salida = ".$model->id_estado_actividad ." AND id_actividad_origen = ".$model->id_actividad));

			if($estadoSalida && $estadoSalida->id_modelo_estado_actividad!="")
			{
				$recaudos_datos_obligatorios = VisRecaudoDatoObligatorio::model()->findAll(array("condition" => "id_modelo_estado_actividad IN(".$estadoSalida['id_modelo_estado_actividad'].")", "order" => "cantidad_recaudos DESC, cantidad_dato_adicional DESC"));
			}
		
			/*****DATOS ADICIONALES*****/
			$error=false;

			if($model->array_datos_adicionales!=null)
			{
				foreach ($model->array_datos_adicionales as $key => $value) 
				{
					$validacion="";
					switch ($value[1]) 
					{
						case 1:
							$validacion='/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/,@.:\-\s]+$/';
							$mensaje='inválido. Sólo se permiten los siguientes caracteres espciales: / , . - :.';
							break;
						
						case 2:
							$validacion='/^[0-9]+$/';
							$mensaje='inválido. Debe ser numérico.';
							break;
						
						case 3:
							$validacion='/([0-9])(,|.)([0-9]){2}/';
							$mensaje='inválido. Debe ser un número decimal (con 2 decimales).';
							break;
						
						case 4:
							$validacion='/([0-9]){2}-([0-9]){2}-([0-9]){4}/';
							$mensaje='inválido. Debe seleccionar una fecha válida.';
							break;
						case 6:
							$model->put_array_datos_adicionales($key, CUploadedFile::getInstance($model,'array_datos_adicionales['.$key.'][2]'));
      
				            if(is_object($model->array_datos_adicionales[$key][2]))
							{
					            $ext=$model->array_datos_adicionales[$key][2]->getExtensionName(); //print_r($ext); exit();
					            $valorDato= $model->idInstanciaProceso->codigo_instancia_proceso.'-'.$value[3].'-'.$value[0]/*.'.'.$ext*/;
					            
								if($ext=='png' || $ext=='jpg' || $ext=='jpeg' || $ext=='bmp' || $ext=='txt' || $ext=='doc' || $ext=='docx' 
				            		|| $ext=='xls' || $ext=='xlsx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')  
				            	{
				            		$model->array_datos_adicionales[$key][2]->saveAs('files/'.$valorDato.'.'.$ext);
				            	}
				            	else
				            	{
				            		$error=true;
									$model->addError('array_datos_adicionales['.$key.'][2]', $value[0].' Los formatos permitidos son: .png, .jpg, .jpeg, .bmp, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf');	//MENSAJE = EXTENSIENES
				            	}
							}
							break;
					}
					if($validacion!="" && $value[2]!="" && !preg_match($validacion, $value[2]))
					{
						$error=true;
						$model->addError('array_datos_adicionales['.$key.'][2]', $value[0].' '.$mensaje);
					}
					else
					{
						if($value[1] == 3)
						{
							$dato_valor = str_replace(",", ".", $value[2]);
						}
						if($value[1] == 6 && isset($valorDato))
						{
							$dato_valor = $valorDato.'.'.$ext;
						}
						else
						{
							$dato_valor = $value[2];
						}

						if($dato_valor != null)
						{
							InstanciaDatoAdicional::model()->updateByPk($key, array('valor_dato_adicional' =>$dato_valor));
						}
					}					
				}				
			}
	

			/*****RECAUDOS*****/
			$this->actualizarRecaudos($modelInstanciaProceso, $model);

			$recSeleccionados=explode(',', $model->_recaudosSeleccionados);

			if(isset($recaudos_datos_obligatorios) && $recaudos_datos_obligatorios)
			{
				foreach ($recaudos_datos_obligatorios as $key => $value) 
				{
					$recaudosCompletos=true;

					if($value['cantidad_recaudos']>0)
					{
						$idInstanciaRO=InstanciaRecaudo::model()->find(array("select" => "array_to_string(array_agg(id_instancia_recaudo), ',') as id_instancia_recaudo", "condition" => "id_instancia_proceso = ".$modelInstanciaProceso->id_instancia_proceso." AND id_proceso_recaudo IN(".$value['id_proceso_recaudo'].")"));

						if($idInstanciaRO)
						{
							$arrayInstRec = explode(',', $idInstanciaRO->id_instancia_recaudo);


							foreach($model->id_recaudo as $key2 => $value2) 
							{
								if(in_array($key2, $arrayInstRec) && !in_array($key2, $recSeleccionados))
								{
									$recaudosCompletos=false;
							

									if($key==0)
									{
										$model->addError('_recaudosConsignados['.$key2.']', $value2.' es necesario para avanzar a la siguiente actividad.');

									}
							
								}
							}
						}
					}

					$completo=true;
					
					if($value['cantidad_dato_adicional']>0)
					{
								
						$idInstanciaDO=InstanciaDatoAdicional::model()->find(array("select" => "array_to_string(array_agg(id_instancia_dato_adicional), ',') as id_instancia_dato_adicional", "condition" => "id_instancia_proceso = ".$modelInstanciaProceso->id_instancia_proceso." AND id_proceso_dato_adicional IN(".$value['id_proceso_dato_adicional'].")"));

						if($idInstanciaDO)
						{
							$arrayInsDatoAdic = explode(',', $idInstanciaDO->id_instancia_dato_adicional);

							if($model->array_datos_adicionales!=null)
							{
								foreach ($model->array_datos_adicionales as $key2 => $value2) 
								{

									if($value2[2]=="" && in_array($key2, $arrayInsDatoAdic))
									{
										if($value2[1] == 6)
										{
											$instancia_dato = InstanciaDatoAdicional::model()->findByPk($key2);
											if($instancia_dato->valor_dato_adicional == null || $instancia_dato->valor_dato_adicional == "")
											{
												$completo = false;
											}
										}
										else
										{
											$completo = false;
											
										}

										if(!$completo && $key==0)
										{
											$model->addError('array_datos_adicionales['.$key2.'][2]',$value2[0].' es necesario para avanzar a la siguiente actividad.');
										}
									}			
								}
							}
						}
					}



					if($recaudosCompletos && $completo)
					{
						$modelo_estado_actividad = ModeloEstadoActividad::model()->findByAttributes(array("id_modelo_estado_actividad" => $value['id_modelo_estado_actividad']));

						$estadoTransicion['id_modelo'] = $modelo_estado_actividad->id_modelo_estado_actividad;
						$estadoTransicion['id_actividad_destino'] = $modelo_estado_actividad->id_actividad_destino;
						$estadoTransicion['id_estado_actividad_inicial'] = $modelo_estado_actividad->id_estado_actividad_inicial;
						break;
					}

				}
			}
			else
			{
				if($estadoSalida && $estadoSalida->id_modelo_estado_actividad!="")
				{
					$modelo_estado_actividad = ModeloEstadoActividad::model()->findByAttributes(array("id_modelo_estado_actividad" => $estadoSalida['id_modelo_estado_actividad']));
					$estadoTransicion['id_modelo'] = $modelo_estado_actividad->id_modelo_estado_actividad;
					$estadoTransicion['id_actividad_destino'] = $modelo_estado_actividad->id_actividad_destino;
					$estadoTransicion['id_estado_actividad_inicial'] = $modelo_estado_actividad->id_estado_actividad_inicial;
				}
			}


			if($error==true || (isset($completo) && $completo==false && $estadoSalida && $estadoSalida->id_modelo_estado_actividad!="") || (isset($recaudosCompletos) && $recaudosCompletos==false))
			{
				/*$model=InstanciaActividad::model()->findByPk($id);
				$model->attributes=$_POST['InstanciaActividad'];
				$errores=$model2->getErrors();
				$model->addErrors($errores);*/

			}
			else
			{
				date_default_timezone_set('America/Caracas');

				$model->fecha_ini_estado_actividad=date('Y-m-d');
				$model->hora_ini_estado_actividad = date('H:i:s');

				//if($estadoSalida)
				if($estadoSalida && $estadoSalida->id_modelo_estado_actividad!="")
				{
					$model->fecha_fin_actividad=date('Y-m-d');
					$model->hora_fin_actividad = date('H:i:s');
					$model->ejecutada=1;

					$transaction=Yii::app()->db->beginTransaction();
					

					$idUser=Yii::app()->user->id_usuario;
					$idEmpleadoAct = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));

					$idEmpleado = $this->buscarEmpleadoActividad($idEmpleadoAct, $estadoTransicion, $model);


					$sqlCodigoActFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
					$codigoActFin= Yii::app()->db->createCommand($sqlCodigoActFin)->queryRow();
					
					$codigoAct = Actividad::model()->findByPk($estadoTransicion['id_actividad_destino']);

					if($codigoActFin['valor']==$codigoAct->codigo_actividad)
					{
						$consecutivo = $model->consecutivo_actividad+1;
						$sql="INSERT into instancia_actividad (id_instancia_proceso, consecutivo_actividad, id_estado_actividad, id_actividad, fecha_ini_actividad, hora_ini_actividad, fecha_ini_estado_actividad, hora_ini_estado_actividad, ejecutada, id_empleado, fecha_fin_actividad, hora_fin_actividad) 
								values ('$model->id_instancia_proceso', '$consecutivo', '".$estadoTransicion['id_estado_actividad_inicial']."', '".$estadoTransicion['id_actividad_destino']."', '".date('Y-m-d')."', '".date('H:i:s')."', '".date('Y-m-d')."', '".date('H:i:s')."', '1', '$idEmpleadoAct->id_empleado', '".date('Y-m-d')."', '".date('H:i:s')."')";
						
						if(Yii::app()->db->createCommand($sql)->execute())
						{
							$sqlEstado="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_finalizado'";
							$estado= Yii::app()->db->createCommand($sqlEstado)->queryRow();

							InstanciaProceso::model()->updateByPk($model->id_instancia_proceso, array('id_estado_instancia_proceso' => $estado['valor'], 'fecha_fin_proceso' => $model->fecha_fin_actividad, 'hora_fin_proceso' => $model->hora_fin_actividad, 'ejecutado' =>1) );				
							
							$registroRepetido = InstanciaActividad::model()->findByAttributes(array('id_instancia_proceso'=>$model->id_instancia_proceso, 'id_actividad'=>$model->id_actividad, 'id_estado_actividad'=>$model->id_estado_actividad, 'consecutivo_actividad'=>$model->consecutivo_actividad));

							if($model->save())
							{
								
								if($registroRepetido)
								{
									$transaction->rollback();
								}
								else
								{ //**********AQUI IRIA ENVIO DE NOTIFICACION DE FINALIZACION
									$transaction->commit();

									$sqlNotificacionF="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_tipo_finalizacion'";
									$notificacionF= Yii::app()->db->createCommand($sqlNotificacionF)->queryRow();

									$notificacion = VisNotificacion::model()->findAllByAttributes(array('id_tipo_notificacion'=>$notificacionF['valor'], 'id_actividad'=>$model->id_actividad));

									if($notificacion)
									{
										$this->enviarNotificacion($notificacion, $model->id_instancia_actividad);
									}
									
								}

								Yii::app()->user->setFlash("success", "Estatus actualizado satisfactoriamente. Trámite finalizado.");
								$this->redirect(array('admin'));
							}
							
						}
						else
						{
							Yii::app()->user->setFlash("error", "Estatus no actualizado. Ha ocurrido un problema al iniciar la siguiente actividad. Por favor intente nuevamente.");
						}

					}
					else
					{
						$sqlEstado="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_en_proceso'";
						$estado= Yii::app()->db->createCommand($sqlEstado)->queryRow();

						InstanciaProceso::model()->updateByPk($model->id_instancia_proceso, array('id_estado_instancia_proceso' => $estado['valor']) );

						$command = new InstanciaActividad();
						$command->id_instancia_proceso = $model->id_instancia_proceso;
						$command->consecutivo_actividad = $model->consecutivo_actividad+1;
						$command->id_estado_actividad = $estadoTransicion['id_estado_actividad_inicial'];
						$command->id_actividad = $estadoTransicion['id_actividad_destino'];
						$command->fecha_ini_actividad = date('Y-m-d');
						$command->hora_ini_actividad = date('H:i:s');
						$command->fecha_ini_estado_actividad = date('Y-m-d');
						$command->hora_ini_estado_actividad = date('H:i:s');
						$command->ejecutada = 0;
						$command->id_empleado = $idEmpleado;					

						if($command->save())
						{//**********AQUI IRIA ENVIO DE NOTIFICACION DE CREACION
							$registroRepetido = InstanciaActividad::model()->findByAttributes(array('id_instancia_proceso'=>$model->id_instancia_proceso, 'id_actividad'=>$model->id_actividad, 'id_estado_actividad'=>$model->id_estado_actividad, 'consecutivo_actividad'=>$model->consecutivo_actividad));
							
							if($model->save())
							{
								
								if($registroRepetido)
								{
									$transaction->rollback();
								}
								else
								{//**********AQUI IRIA ENVIO DE NOTIFICACION DE FINALIZACION
									$transaction->commit();

									$sqlNotificacionC="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_tipo_creacion'";
									$notificacionC= Yii::app()->db->createCommand($sqlNotificacionC)->queryRow();

									$notificacion = VisNotificacion::model()->findAllByAttributes(array('id_tipo_notificacion'=>$notificacionC['valor'], 'id_actividad'=>$command->id_actividad));

									if($notificacion)
									{
										$this->enviarNotificacion($notificacion, $command->id_instancia_actividad);
									}
									
									$sqlNotificacionF="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_tipo_finalizacion'";
									$notificacionF= Yii::app()->db->createCommand($sqlNotificacionF)->queryRow();

									$notificacion = VisNotificacion::model()->findAllByAttributes(array('id_tipo_notificacion'=>$notificacionF['valor'], 'id_actividad'=>$model->id_actividad));

									if($notificacion)
									{
										$this->enviarNotificacion($notificacion, $model->id_instancia_actividad);
									}
									
								}

								Yii::app()->user->setFlash("success", "Estatus actualizado satisfactoriamente. La siguiente actividad ha sido asignada.");
								$this->redirect(array('admin'));
							}
						}
						else
						{
							$transaction->rollback();
							if($idEmpleado=="")
								Yii::app()->user->setFlash("error", "Estatus no actualizado. Siguiente actividad no se puede iniciar porque ningún empleado \"Activo\" tiene perfil para ejecutarla.");
							else
								Yii::app()->user->setFlash("error", "Estatus no actualizado. Siguiente actividad no se puedo iniciar.");
							
						}
					}
				}
				else
				{
					if($model->save())
					{

						Yii::app()->user->setFlash("success", "Actividad actualizada satisfactoriamente.");

						$this->redirect(array('admin'));
					}
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'modelInformacionActividad'=>$modelInformacionActividad,
			'modelInstanciaProceso'=>$modelInstanciaProceso,
			'estadosTransicion'=>$estadosTransicion,
			'modelHistDatos'=>$modelHistDatos,
			'modelHistArchivos'=>$modelHistArchivos,
			'modelObsActs'=>$modelObsActs,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout='//layouts/column1';

		$idUser=Yii::app()->user->id_usuario;

		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));

		if($idEmpleado)
		{
			$model=new VisInstanciaActividad('search');

			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['ViInstanciaActividad']))
				$model->attributes=$_GET['ViInstanciaActividad'];

			$this->render('admin',array(
				'model'=>$model,
			));
		}
		else
		{
			throw new CHttpException(999,'El usuario no está asociado a ningún Empleado');	
		}
	}

/**
	 * Manages all models.
	 */
	public function actionReasig()
	{
		$this->layout='//layouts/column1';

		$idUser=Yii::app()->user->id_usuario;

		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));


		if($idEmpleado)
		{


			if (Funciones::usuarioEsDirector() || Funciones::usuarioEsJefeDepartamento() || Yii::app()->user->isSuperAdmin)
			{
			 	$model=new VisInstanciaActividad('searchReasig');

			 	$modelEmpleado = VisEmpleado::model()->findAll(array('condition' => 'superior_inmediato = '.$idEmpleado->id_empleado.' or id_empleado = '.$idEmpleado->id_empleado, "order" => 'nombre_persona'));
			 	$empleado[0] = array("id_persona"=>0, "nombreEmpleado"=>"Ninguno");

			 	foreach ($modelEmpleado as $key => $value) 
			 	{
			 		$empleado[$key+1] = array("id_persona"=>$value['id_persona'], "nombreEmpleado"=>$value['nombre_persona']);
			 	}
				
				//$model->id_instancia_actividad=0;
				if(isset($_GET['VisInstanciaActividad']))
				{
					$model->unsetAttributes();  // clear any default values
					$model->attributes=$_GET['VisInstanciaActividad'];
					//print_r($model);
				}

				$this->render('reasig',array(
					'model'=>$model,
					//'idEmpleado'=>$idEmpleado->id_empleado,
					'empleado'=>$empleado,
				));	
			}
			else
			{

				throw new CHttpException(999,'El usuario no es Jefe de Departamento y no puede acceder a este módulo');	
			}
		}
		else
		{
			throw new CHttpException(999,'El usuario no está asociado a ningún Empleado');	
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InstanciaActividad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InstanciaActividad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InstanciaActividad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='instancia-actividad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
