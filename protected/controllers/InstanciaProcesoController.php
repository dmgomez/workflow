<?php

class InstanciaProcesoController extends Controller
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
				'actions'=>array('create','update', 'admin','delete', 'ListaSolicitante', 'BuscarSolicitante', 'AgregarPersona', 'AgregarEmpresa', 'BuscarPersonaPorCedula', 'CargarSolicitante', 'AdminConsulta', 'BusquedaAvanzada', 'renderizarGrid', 'BuscarInmueblePorID', 'AgregarInmueble', 'IniciarTramite', 'Comprobante'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		//$this->layout='//layouts/column1';
		$modelObsActs=new CActiveDataProvider(VisObservacion::model(), array(
			'keyAttribute'=>'id',
			'criteria'=>array(
				'condition'=>"id=".$id." AND observacion <> ''",
			),
		));

		$modelHistDatos=new CActiveDataProvider(VisInstanciaDatoAdicional::model(), array(
			'keyAttribute'=>'id_instancia_dato_adicional',
			'criteria'=>array(
				'condition'=>"id_instancia_proceso=".$id." AND valor_dato_adicional <> ''  AND tipo_dato_adicional <> 6",
			),
		));

		$modelHistArchivos=new CActiveDataProvider(VisInstanciaDatoAdicional::model(), array(
			'keyAttribute'=>'id_instancia_dato_adicional',
			'criteria'=>array(
				'condition'=>"id_instancia_proceso=".$id." AND valor_dato_adicional <> '' AND tipo_dato_adicional = 6",
			),
		));

		$model = $this->loadModel($id);

		$proceso = Proceso::model()->findByPk($model->id_proceso);
		$organizacion = Organizacion::model()->findByPk($proceso->id_organizacion);


		$this->render('view',array(
			'model'=>$model,
			'modelObsActs'=>$modelObsActs,
			'modelHistDatos'=>$modelHistDatos,
			'modelHistArchivos'=>$modelHistArchivos,
			'organizacion'=>$organizacion,

		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'admin' page.
	 */
	public function actionCreate($idProceso, $nombreProceso)
	{
		$model=new InstanciaProceso;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InstanciaProceso']))
		{
			$model->attributes=$_POST['InstanciaProceso'];

			date_default_timezone_set('America/Caracas');

			$model->fecha_ini_proceso=date('Y-m-d');
			$model->hora_ini_proceso=date('H:i:s');

			$transaction=Yii::app()->db->beginTransaction();

			$sqlInsProc="INSERT into instancia_proceso (id_proceso,id_usuario,codigo_instancia_proceso,id_estado_instancia_proceso,fecha_ini_proceso,hora_ini_proceso,ejecutado) 
						values ($model->id_proceso, $model->id_usuario, '".$model->codigo_instancia_proceso."',$model->id_estado_instancia_proceso,'".$model->fecha_ini_proceso."','".$model->hora_ini_proceso."',0)";

			$model2= Yii::app()->db->createCommand($sqlInsProc)->execute();
 

			if($model2)
			{
				

				$sqlEstadoAct="SELECT valor FROM configuracion WHERE variable = 'id_estado_actividad_pendiente'";
				$estadoAct= Yii::app()->db->createCommand($sqlEstadoAct)->queryRow();

				$rolAct = ActividadRol::model()->findAllByAttributes(array('id_actividad'=>$model->_actInic));
				
				if($rolAct)
				{
					foreach ($rolAct as $value) 
					{
						$idRol[]=$value['id_rol'];
					}


					$idUser=Yii::app()->user->id_usuario;

					$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));

					if($idEmpleado)
					{
						$empleadoRol = EmpleadoRol::model()->findByAttributes(array('id_empleado'=>$idEmpleado->id_empleado, 'id_rol'=>$idRol));
					}
					if(isset($empleadoRol) && $empleadoRol)
					{
						$idEmpleado=$empleadoRol->id_empleado;
					}

					else //SI EL EMPLEADO QUE INICIA NO PUEDE REALIZAR LA PRIMERA ACTIVIDAD
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


				$recaudo = ProcesoRecaudo::model()->findAllByAttributes(array('id_proceso'=>$model->id_proceso));
				
			
				$sql_id_instancia_proceso = "SELECT max(id_instancia_proceso) as id FROM instancia_proceso";
				$id_instancia_proceso= Yii::app()->db->createCommand($sql_id_instancia_proceso)->queryRow();

				$command = new InstanciaActividad();
				$command->id_instancia_proceso = $id_instancia_proceso['id'];
				$command->consecutivo_actividad = 1;
				$command->id_estado_actividad = $estadoAct['valor'];
				$command->id_actividad = $model->_actInic;
				$command->fecha_ini_actividad = date('Y-m-d');
				$command->hora_ini_actividad = date('H:i:s');
				$command->fecha_ini_estado_actividad = date('Y-m-d');
				$command->hora_ini_estado_actividad = date('H:i:s');
				$command->ejecutada = 0;
				$command->id_empleado = $idEmpleado;

					
				if($command->save())
				{
					$flag_dato=0;
					$flag_recaudo=0;
					
					if($model->array_datos_adicionales!=null)
					{
						foreach ($model->array_datos_adicionales as $key => $value) 
						{
							$validacion="";
							switch ($value[1]) 
							{
								case 1:
									$validacion='/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/,.:\-\s]+$/';
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

									$model->array_valor_datos_adicionales[$key]=CUploadedFile::getInstance($model,'array_valor_datos_adicionales['.$key.']');
	            
						            if(is_object($model->array_valor_datos_adicionales[$key]))
									{
							            $ext=$model->array_valor_datos_adicionales[$key]->getExtensionName(); //print_r($ext); exit();
							            $valorDato= $model->codigo_instancia_proceso.'-'.$value[3].'-'.$value[4].'.'.$ext;
							            
										if($ext=='png' || $ext=='jpg' || $ext=='jpeg' || $ext=='bmp' || $ext=='txt' || $ext=='doc' || $ext=='docx' 
						            		|| $ext=='xls' || $ext=='xlsx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')  
						            	{
						            		$model->array_valor_datos_adicionales[$key]->saveAs('files/'.$valorDato.'.'.$ext);
						            	}
						            	else
						            	{
						            		$flag_dato = 1;
											$model->addError('array_datos_adicionales['.$key.'][2]', $value[4].' Los formatos permitidos son: .png, .jpg, .jpeg, .bmp, .txt, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf');	
						            	}
					
									}

									break;

								default:
									# code...
									break;
							}
							if($validacion!="" && $value[2]!="" && !preg_match($validacion, $value[2]))
							{
								$flag_dato = 1;
								$model->addError('array_datos_adicionales['.$key.'][2]', $value[4].' '.$mensaje);
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
								$dato_existente = InstanciaDatoAdicional::model()->findByAttributes(array('id_proceso_dato_adicional'=>$value[0], 'id_instancia_proceso'=>$id_instancia_proceso['id']));
								if(!$dato_existente)
								{
									$sql="INSERT into instancia_dato_adicional (id_proceso_dato_adicional, id_instancia_proceso, valor_dato_adicional) values ('".$value[0]."', ".$id_instancia_proceso['id'].", '".$dato_valor."')";

									if(!Yii::app()->db->createCommand($sql)->execute())
									{
										$flag_dato=1;
										break;
									}
								}
								elseif ($dato_existente->valor_dato_adicional == '' || $dato_existente->valor_dato_adicional == null) {
									//InstanciaDatoAdicional::model()->updateByPk($key, array('valor_dato_adicional' =>$dato_valor));
									$upd = InstanciaDatoAdicional::model()->updateAll(array('valor_dato_adicional' => $dato_valor), 'id_proceso_dato_adicional = '.$value[0].' and id_instancia_proceso = '.$id_instancia_proceso['id']);

									if(!$upd)
									{
										$flag_dato=1;
										break;
									}
								}

								
							}
							
						}
						
					}


					if($recaudo)
					{
						foreach ($recaudo as $key => $value) 
						{
							$command_recaudo = new InstanciaRecaudo();
							$command_recaudo->id_instancia_proceso = $id_instancia_proceso['id'];
							$command_recaudo->id_proceso_recaudo = $value['id_proceso_recaudo'];
							$command_recaudo->consignado = '0';

							if(!$command_recaudo->save())
							{
								$flag_recaudo=1;
								break;

							}
						}
					}

					if($model->_recaudosSeleccionados!="")
					{
						InstanciaRecaudo::model()->updateAll(array('consignado' =>'1'), 'id_proceso_recaudo IN ('.$model->_recaudosSeleccionados.')' );
					}


					if($flag_recaudo==0 && $flag_dato==0)
					{
						
						$proceso=Proceso::model()->findByPk($model->id_proceso);
						$fTram=date('Ym');
						$codigoProc=$proceso->codigo_proceso.'-'.$fTram.''.$id_instancia_proceso['id'];
						
						InstanciaProceso::model()->updateByPk($id_instancia_proceso['id'], array('codigo_instancia_proceso' => $codigoProc) );


						

						$transaction->commit();
						Yii::app()->user->setFlash("success", "Trámite iniciado satisfactoriamente.");
						$this->redirect(array('instanciaproceso/admin'));
			
						//$result = array('success' => true, 'codigoProc' => $codigoProc, 'proceso' => $proceso->nombre_proceso, 'organizacion'=>$organizacion->nombre_organizacion, 'fecha'=>$fecha_ini, 'hora'=>$hora_ini, 'message' => 'Proceso iniciado satisfactoriamente.');
					}
					else
					{
						$transaction->rollback();
						//$result = array('success' => false, 'message' => 'Proceso no iniciado.');
						Yii::app()->user->setFlash("error", "Proceso no iniciado.");
					}
				}
				else
				{
					$transaction->rollback();
					//$result = array('success' => false, 'message' => 'Proceso no iniciado.');
					Yii::app()->user->setFlash("error", "Proceso no iniciado.");
				}


			}


		}

		$proc=Proceso::model()->findByPk($idProceso);

		$datoAdicional = VisDatoAdicional::model()->findAll(array('condition' => 'id_proceso = '. $proc->id_proceso .'and dato_activo = 1', 'order' => 'id_actividad, orden ASC'));
		$recaudo = VisRecaudo::model()->findAll(array('condition' => 'id_proceso = '. $proc->id_proceso, 'order' => 'id_actividad ASC'));

		$idTemp=InstanciaProceso::model()->find(array('select'=>'max(id_instancia_proceso) as id_instancia_proceso'));

		date_default_timezone_set('America/Caracas');

		$fTram=date('Ym');

		$codTemp=$proc->codigo_proceso.'-'.$fTram.''.($idTemp->id_instancia_proceso+1);

		$sqlEstado="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_pendiente'";
		$estado= Yii::app()->db->createCommand($sqlEstado)->queryRow();

		
		$this->render('create',array(
			'model'=>$model,
			'idProceso'=>$idProceso,
			'nombreProceso'=>$nombreProceso,
			'estado'=>$estado['valor'],
			'descProc'=>$proc->descripcion_proceso,
			'codProc'=>$codTemp,
			'datoAdicional'=>$datoAdicional,
			'recaudo'=>$recaudo
		));
	}



	/*public function actionRenderizarTramitesInmueble() 
	{
		$idInmueble = $_POST['idInmueble'];
		if(isset($_POST['estado']))
		{
			$estado = $_POST['estado'];
		}
		else
		{
			$estado = "";
		}
		if($estado != "")
		{
			$condicion = "AND id_estado_instancia_proceso='".$estado."'";
		}
		else
		{
			$condicion = "";
		}

		$model=new CActiveDataProvider(InstanciaProceso::model(), array(
			'keyAttribute'=>'id_instancia_proceso',
			'criteria'=>array(
				'condition'=>'id_inmueble='.$idInmueble.' '.$condicion,
				'order'=>'codigo_instancia_proceso ASC',
			),
		));

		$gridTramitesInmueble = $this->widget('bootstrap.widgets.TbGridView', array(
			'type'=>'striped bordered condensed',
			'id'=>'instancia-proceso',
			'template'=>"{summary}{items}{pager}{summary}",
			'dataProvider'=>$model,
			'enableSorting'=>false,
			'columns'=>array(
				'nombreProceso',
				'codigo_instancia_proceso',
				'nombre_solicitante',
				array(
					'name'=>'fecha_ini_proceso', 
					'value'=>'Funciones::invertirFecha($data->fecha_ini_proceso)',			
				),
				array(
					'name'=>'fecha_fin_proceso', 
					'value'=>'$data->mostrarFechaFin()',			
				),
				'nombreEstado',
			),
		), true); 

		$result = array('gridTramitesInmueble' => $gridTramitesInmueble);
		echo CJSON::encode($result);
		
	}*/


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		date_default_timezone_set('America/Caracas');

		$model=$this->loadModel($id);

		$inmueble = Inmueble::model()->findByPk($model->id_inmueble);
		$parroquia = Parroquia::model()->findByPk($inmueble->id_parroquia);
		$municipio = Municipio::model()->findByPk($parroquia->id_municipio);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InstanciaProceso']))
		{
			$model->attributes=$_POST['InstanciaProceso'];
			//$model->ejecutado = 0;
			//$model->fecha_ini_reconsideracion = date('Y-m-d');
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
			//'idProceso'=>$idProceso,
			//'nombreProceso'=>$nombreProceso,
			'direccionInmueble'=>$inmueble->direccion_inmueble,
			'parroquia'=>$parroquia->nombre_parroquia,
			'municipio'=>$municipio->nombre_municipio,
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('InstanciaProceso');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout='//layouts/column1';
		
		$idProc="";

		$idUser=Yii::app()->user->id_usuario;

		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));

		if($idEmpleado)
		{
			$rolEmpleado = EmpleadoRol::model()->findAllByAttributes(array('id_empleado'=>$idEmpleado->id_empleado));

			if($rolEmpleado)
			{
				foreach ($rolEmpleado as $value) 
				{
					$idRol[]=$value['id_rol'];
				};

				$actividadRol = ActividadRol::model()->findAllByAttributes(array('id_rol'=>$idRol));
				

				if($actividadRol)
				{
					foreach ($actividadRol as $value) 
					{
						$idActividad[]=$value['id_actividad'];
					}
					
					$procActInic=Actividad::model()->findAllByAttributes(array('es_inicial'=>1, 'id_actividad'=>$idActividad));

					foreach ($procActInic as $value) 
					{
						$idProc.=$value['id_proceso'].',';
					}
					$idProc=substr($idProc, 0, -1);
				}
			}
		}

		$modelProceso=new Proceso('search');
		$modelProceso->unsetAttributes();  // clear any default values
		if(isset($_GET['Proceso']))
			$modelProceso->attributes=$_GET['Proceso'];

		$this->render('admin',array(
			'modelProceso'=>$modelProceso,
			'idProc'=>$idProc,
		));
	}

	public function actionAdminConsulta()
	{
		$this->layout='//layouts/column1';

		/*$sqlEstado="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_pendiente'";
		$estado= Yii::app()->db->createCommand($sqlEstado)->queryRow();*/

		$model=new CActiveDataProvider(InstanciaProceso::model(), array(
			'keyAttribute'=>'id_instancia_proceso',
			'criteria'=>array(
				'with'=>array('idProceso'=>array('alias' => 'proceso'), ),
				'condition'=>'id_instancia_proceso=0',
				'order'=>'codigo_instancia_proceso ASC',
			),			
		));

		$this->render('adminConsulta',array(
			'model'=>$model,
		));
	}

	

	public function actionBusquedaAvanzada()
	{
		$this->layout='//layouts/column1';

		$datos[] = "";
		$datosProceso = "";
		$proc = Proceso::model()->find(array('order' => 'nombre_proceso'));
		if($proc)
		{
			
			$modelDato = VisDatoAdicional::model()->findAll(array('select' => 'id_proceso_dato_adicional, nombre_dato_adicional', 'condition' => 'id_proceso = '.$proc->id_proceso, 'group' => 'id_proceso_dato_adicional, nombre_dato_adicional'));
			
			foreach ($modelDato as $key => $value) 
			{
				$datos[$key] = array('id'=>$value['id_proceso_dato_adicional'], 'nombre' => $value->nombre_dato_adicional);
				$datosProceso .= $value['id_proceso_dato_adicional'].',';
			}

			$datosProceso = substr($datosProceso, 0, -1);

		}

		$model = new InstanciaProceso('searchBusquedaAvanzada');
        
        $model->id_instancia_proceso=-1;
        if (isset($_GET['InstanciaProceso'])){
        	$model->unsetAttributes();  // borrar los valores predeterminados
            $model->setAttributes($_GET['InstanciaProceso'], true);

			//print_r($model);
            $datos[] = array('id'=>'', 'nombre' => '');
			$datosProceso = "";

			$modelDato = VisDatoAdicional::model()->findAll(array('select' => 'id_proceso_dato_adicional, nombre_dato_adicional', 'condition' => 'id_proceso ='.$model->id_proceso, 'group' => 'id_proceso_dato_adicional, nombre_dato_adicional'));

			if($modelDato)
			{
				foreach ($modelDato as $key => $value) 
				{
					$datos[$key] = array('id'=>$value['id_proceso_dato_adicional'], 'nombre' => $value->nombre_dato_adicional);
					$datosProceso .= $value['id_proceso_dato_adicional'].',';
				}

				$datosProceso = substr($datosProceso, 0, -1);
			}

		}

		$this->render('busquedaAvanzada',array(
			'model'=>$model,
			//'estado'=>$estado['valor'],
			'datos'=>$datos,
			'datosProceso'=>$datosProceso,
			'_datoAdicional'=>$model->_datoAdicional,
			'_valorDatoAdicional'=>$model->_valorDatoAdicional,
		));
	}

	public function actionGetDatosAdicionales()
	{

		$idProceso = $_POST['idProceso'];
		$datos = "";
		$tabla = "";
		
		$modelDato = VisDatoAdicional::model()->findAll(array('select' => 'id_proceso_dato_adicional, nombre_dato_adicional', 'condition' => 'id_proceso ='.$idProceso, 'group' => 'id_proceso_dato_adicional, nombre_dato_adicional'));
		

		if($modelDato)
		{
			$tabla .= "<table id='tblData', style='margin-right: 6px;'>";
			foreach ($modelDato as $key => $value) 
			{
				$model = InstanciaProceso::model();
				$tabla .= "<tr> <td width='5%'>";
				$tabla .= CHtml::checkBox('_checkDatoAdicional', false,
					array('separator'=>'',
						'style'=>'float:left; margin-right: 5px;',
						'onClick'=>'datosSeleccionados()',
						'value'=>$value['id_proceso_dato_adicional']					
					));

				$tabla .= "</td> <td width='30%'>";
				$tabla .= $value['nombre_dato_adicional'];
				$tabla .= "</td> <td width='60%'>";
				$tabla .= CHtml::textField('_datoBuscar', '', array('id'=>$value['id_proceso_dato_adicional'], 'class'=>'span4', 'style'=>'margin-left: 5px;', 'readonly'=>'readonly', 'onblur'=>'valorDatos()'));
				$tabla .= "</td> </tr>";

				$datos .= $value['id_proceso_dato_adicional'] .",";
			}
			$tabla .= "</table>";

			$datos = substr($datos, 0, -1);
		}
	
		$result = array('datos' => $tabla, 'datosProceso' => $datos);

		echo CJSON::encode($result);
	}


	public function actionRenderizarGrid() 
	{
		if(isset($_POST['busqueda']) && isset($_POST['estado']))
		{
			$busqueda = $_POST['busqueda'];
			$estado = $_POST['estado'];
		}
		else
		{
			$busqueda = "";
			$estado = "";
		}
		if($estado != "")
		{
			$condicion = "AND id_estado_instancia_proceso='".$estado."'";
		}
		else
		{
			$condicion = "";
		}

		$model=new CActiveDataProvider(InstanciaProceso::model(), array(
			'keyAttribute'=>'id_instancia_proceso',
			'criteria'=>array(
				'with'=>array('idProceso'=>array('alias' => 'proceso'),),
				'condition'=>'(lower(proceso.nombre_proceso) like \'%'.strtolower($busqueda).'%\' OR lower(codigo_instancia_proceso) like \'%'.strtolower($busqueda).'%\') '.$condicion,
				'order'=>'codigo_instancia_proceso ASC',
			),
			'sort' => array(),
		));

 
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
 
        $this->renderPartial('adminConsulta', array('model' => $model, 'busqueda' => $busqueda, 'estado' => $estado));
	}


	public function actionAdminTramite()
	{
		$this->layout='//layouts/column1';

		
		$model = new InstanciaProceso('search');
        $model->unsetAttributes();  // borrar los valores predeterminados
        if (isset($_GET['InstanciaProceso'])){
            $model->setAttributes($_GET['InstanciaProceso'], true);
        }
        
        $this->render('adminTramite', array(
            'model' => $model,
            //'esAbogado' => $esAbogado,
        ));
	}


	public function actionAnularTramite($id)
	{
		$model = InstanciaProcesoAnular::model()->findByPk($id);

		if(isset($_POST['InstanciaProcesoAnular']))
		{
			$model->attributes=$_POST['InstanciaProcesoAnular'];

			$sqlEstado="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_anulado'";
			$estado= Yii::app()->db->createCommand($sqlEstado)->queryRow();


			date_default_timezone_set('America/Caracas');


			$fecha=date('Y-m-d');
			$hora=date('H:i:s');

			$model->id_estado_instancia_proceso = $estado['valor'];
			$model->fecha_anulacion = $fecha;
			$model->hora_anulacion = $hora;


			if($model->save())
			{
				$update = InstanciaActividad::model()->updateAll(array('ejecutada' => 1), 'id_instancia_proceso = '.$id);

				Yii::app()->user->setFlash("success", "Proceso anulado satisfactoriamente.");
				$this->redirect(array('adminTramite'));
			}
		
		}

		$this->render('anularTramite', array(
			'model'=>$model
		));
	}


	public function actionEliminarTramite($id)
	{
		$result = array('success' => false, 'message' => 'Trámite no eliminado.');

		$act_ejecutada = InstanciaActividad::model()->findByAttributes(array('id_instancia_proceso'=>$id, 'ejecutada'=>1));

		$model=$this->loadModel($id);

		if(!$act_ejecutada)
		{
			$delete = Yii::app()->db->createCommand('select delete_tramite('.$id.')')->query();

			if($delete)
				$result = array('success' => true, 'message' => 'Trámite eliminado satisfactoriamente.');
		}
		else
		{
			$estadoTramite = EstadoInstanciaProceso::model()->findByPk($model->id_estado_instancia_proceso);

			$result = array('success' => false, 'message' => 'No se puede eliminar. El trámite que intenta eliminar está en curso'/*.Funciones::minuscula_utf8($estadoTramite->nombre_estado_instancia_proceso)*/);
		}

		echo CJSON::encode($result);
	}

	public function actionRegresarTramite($id)
	{
		$model=new Tramite;

		$tramite = $this->loadModel($id);

		$consecutivo = 1;
	
		
		$actividades = VisInstanciaActividad::model()->findAll(array("select"=>"id_instancia_actividad, (codigo_actividad::text || '. '::text) || nombre_actividad::text AS nombre_actividad",
															"condition"=>"id_instancia_proceso = ".$id.' and consecutivo_actividad > '.$consecutivo, "order"=>"consecutivo_actividad desc"));


		if(isset($_POST['Tramite']))
		{
			$model->attributes=$_POST['Tramite'];

			if($model->_actividad == "")
				$model->addError('_actividad', 'Actividad no puede ser nulo.');
			else
			{
				$transaction=Yii::app()->db->beginTransaction();

				if(Yii::app()->db->createCommand("select delete_instancia_actividad('".$model->_actividad."')")->query())
				{
					$instancia = VisInstanciaActividad::model()->findByAttributes(array('id_instancia_proceso'=>$id), array('order'=>'consecutivo_actividad desc'));

					if($instancia)
					{
						$sqlActvPendiente="SELECT valor FROM configuracion WHERE variable = 'id_estado_actividad_pendiente'";
						$actividadPendiente= Yii::app()->db->createCommand($sqlActvPendiente)->queryRow();

						$update = InstanciaActividad::model()->updateByPk($instancia->id_instancia_actividad, array('ejecutada' => 0, 'id_estado_actividad' => $actividadPendiente['valor']));

						if($instancia->consecutivo_actividad == $consecutivo)
						{
							$sqlProcPendiente="SELECT valor FROM configuracion WHERE variable = 'id_estado_proceso_pendiente'";
							$procesoPendiente= Yii::app()->db->createCommand($sqlProcPendiente)->queryRow();

							$update = InstanciaProceso::model()->updateByPk($id, array('id_estado_instancia_proceso' => $procesoPendiente['valor']));
						}

						if($update)
						{
							$transaction->commit();

							Yii::app()->user->setFlash("success", "Trámite regresado satisfactoriamente.");
							$this->redirect(array('adminTramite'));
						}
						else
						{
							$transaction->rollback();

							Yii::app()->user->setFlash("error", "Trámite no regresado.");
							$this->redirect(array('adminTramite'));
						}
					}
					else
					{
						$transaction->rollback();

						Yii::app()->user->setFlash("error", "Trámite no regresado.");
						$this->redirect(array('adminTramite'));
					}
				}
				else
				{
					$transaction->rollback();

					Yii::app()->user->setFlash("error", "Trámite no regresado.");
					$this->redirect(array('adminTramite'));
				}
			}
	
		}

		$this->render('regresarTramite', array(
            'model' => $model,
            'actividades' => $actividades,
            'tramite' => $tramite,
        ));
		
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InstanciaProceso the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InstanciaProceso::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InstanciaProceso $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='instancia-proceso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
