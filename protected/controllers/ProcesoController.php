<?php

class ProcesoController extends Controller
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
				'actions'=>array('create','update','model','BuscarRecaudos', 'DeleteGrid', 'admin','delete', 'buscarCodigo'),
				'users'=>array('@'),
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

		$idProc=-1;
		if(isset($_POST['idProc']) )
			$idProc = $_POST['idProc'];

		$model = Proceso::model()->findByAttributes( array('codigo_proceso'=>$codigo) );
		
		if($model && $model->id_proceso!=$idProc)
		{

			$result = array('success' => false, 'message' => 'El código que ingresó ya se encuentra registrado.');	
			
		}		

		echo CJSON::encode($result);
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//$sqlIdRecaudo="SELECT array_to_string(array_agg(id_recaudo), ',') as id_recaudo from proceso_recaudo where id_proceso=".$id;
		//$idRecaudo = Yii::app()->db->createCommand($sqlIdRecaudo)->queryRow();

		$modelRecaudo=new CActiveDataProvider(ProcesoRecaudo::model(), array(
			'keyAttribute'=>'id_proceso_recaudo',
			'criteria'=>array(
				'with'=>array('idRecaudo'=>array('alias' => 'recaudo')),
				'condition'=>'id_proceso ='.$id,
				'order' => 'recaudo.nombre_recaudo asc',
			),
		));

		$modelDato=new CActiveDataProvider(ProcesoDatoAdicional::model(), array(
			'keyAttribute'=>'id_proceso_dato_adicional',
			'criteria'=>array(
				'with'=>array('idDatoAdicional'=>array('alias' => 'datoadicional')),
				'condition'=>'id_proceso='.$id,
				'order' => 'datoadicional.nombre_dato_adicional asc',
			),
		));

		$modelAct=new CActiveDataProvider(Actividad::model(), array(
			'keyAttribute'=>'id_actividad',
			'criteria'=>array(
				'select'=>"*, lpad(split_part(codigo_actividad, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as _codigo_2, lpad(split_part(codigo_actividad, '.', 3), 2, '0') as _codigo_3",
				'condition'=>'id_proceso='.$id,
				'order' => '_codigo_1, _codigo_2, _codigo_3 asc',
			),
		));

		$notificacion = Notificacion::model()->findAll();

		$sqlIdNotificacionTipoC="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_tipo_creacion'";
		$idNotificacionTipoC= Yii::app()->db->createCommand($sqlIdNotificacionTipoC)->queryRow();

		$sqlIdNotificacionTipoF="SELECT valor FROM configuracion WHERE variable = 'id_notificacion_tipo_finalizacion'";
		$idNotificacionTipoF= Yii::app()->db->createCommand($sqlIdNotificacionTipoF)->queryRow();

		$datoAdicional = VisDatoAdicional::model()->findAllByAttributes(array('id_proceso' => $id, 'dato_activo' => 1));
		

		if(isset($_GET['DatoAdicional'])){
			
			$model=new DatoAdicional('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['DatoAdicional'])){
				$model->attributes=$_GET['DatoAdicional'];
			}

			$this->renderPartial('grid_buscar_dato',array(
				'model'=>$model,
			));
		}
		else
		{
			$this->render('view',array(
				'model'=>$this->loadModel($id),
				'modelAct'=>$modelAct,
				'modelRecaudo'=>$modelRecaudo,
				'modelDato'=>$modelDato,
				'notificacion'=>$notificacion,
				'idNotificacionTipoC'=>$idNotificacionTipoC,
				'idNotificacionTipoF'=>$idNotificacionTipoF,
				'datoAdicional'=>$datoAdicional
			));
		}
	}

	public function actionBuscarDatoPorID($ID){

		$result = array('success' => false, 'message' => 'No se agregó ningún dato adicional.');			

		$model = DatoAdicional::model()->findByAttributes( array('id_dato_adicional' => $ID) );
		
		if($model){

			$result = array('success' => true, 'nombre' => $model->nombre_dato_adicional, 'id' => $model->id_dato_adicional, 'tipo' => $model->tipo_dato_adicional, 'message' => 'Dato Adicional seleccionado satistactoriamente.');
		}		

		echo CJSON::encode($result);
	}

	public function actionBuscarRecaudoPorID($ID){

		$result = array('success' => false, 'message' => 'No se agregó ningún recaudo.');			

		$model = Recaudo::model()->findByAttributes( array('id_recaudo' => $ID) );
		
		if($model)
		{
						/*if( ! ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$id_proceso, 'id_recaudo'=>$id_recaudo)) )
						{
							$commandPR = new ProcesoRecaudo();
							$commandPR->id_recaudo=$id_recaudo;
							$commandPR->id_proceso = $id_proceso;
							//$commandPR->obligatorio = $obligatorio;
							
							if($commandPR->save())
							{
								$transaction->commit();
								$result = array('success' => true, 'message' => '<p>Recaudo agregado satisfactoriamente.</p>');
							}
							else
							{
								$transaction->rollback();
								//$result = array('success' => false, 'message' => '<p>No se pudo agregar el dato adicional.</p>');
								$result = array('success' => false, 'message' => '<p>Recaudo ya registrado.</p>');
							}
						}
						else
						{
							$result = array('success' => false, 'message' => '<p>El recaudo que intenta agregar ya está asociado al proceso.</p>');
						}*/

			$result = array('success' => true, 'nombre' => $model->nombre_recaudo, 'id' => $model->id_recaudo, 'message' => 'Recaudo seleccionado satistactoriamente.');
		}		

		echo CJSON::encode($result);
	}

	public function actionUpdateRecord()
	{
		error_reporting(0);

		if(isset($_POST['name']) && $_POST['name'] == 'orden')
		{
			if($_POST['value']>0)
			{
				$idProceso = ProcesoDatoAdicional::model()->findByPk($_POST['pk']);
				$ordenExistente = ProcesoDatoAdicional::model()->find(array('condition'=>'id_proceso = '.$idProceso->id_proceso.' and id_proceso_dato_adicional <> '.$_POST['pk'].' and orden = '.$_POST['value']));
				if(!$ordenExistente)
				{
					try
					{
						$connection = yii::app()->db;
						$sql = "UPDATE proceso_dato_adicional SET orden = '";
						$sql = $sql.$_POST['value']."' WHERE id_proceso_dato_adicional =".$_POST['pk'];
						$command=$connection->createCommand($sql);
						$command->execute();
					}
					catch (Exception $e) 
					{
						throw new CHttpException(999, $e->getMessage());
					}
				}
				else
				{
					throw new CHttpException(600, 'Orden ya registrado');
				}
    		}
    		else
    		{
    			throw new CHttpException(602, 'Orden debe ser mayor o igual a 1');
    		}
		}
		
	}

	public function actionAgregarDatoAdicional()
	{
		$accion=$_POST['accion'];
		$id=$_POST['id'];
		$idProc=$_POST['idProc'];
		$nombre=$_POST['nombre'];
		$tipo=$_POST['tipo'];
		//$obligatorio=$_POST['obligatorio'];

		if($accion==1)
		{
			$result = array('success' => false, 'message' => 'No se pudo agregar el dato adicional.');

			$erroresIngreso="";
			
			if($nombre=="") 
			{
				$erroresIngreso.="<li>Nombre Dato Adicional no puede ser nulo.</li>";
			}
			else
			{
				//validar restricciones
			}
			
			if($tipo=="") 
				$erroresIngreso.="<li>Tipo no puede ser nulo.</li>";

			
			if($erroresIngreso=="")
			{
				$transaction=Yii::app()->db->beginTransaction();
				$commandPDA = new ProcesoDatoAdicional();

				if($id=="" && $nombre!="")
				{
					if( ! DatoAdicional::model()->find("LOWER(nombre_dato_adicional)='".strtolower($nombre)."'") )
					{
						$command = new DatoAdicional();
						$command->nombre_dato_adicional = $nombre;
						$command->tipo_dato_adicional = $tipo;

						if($command->save())
						{
							$commandPDA->id_dato_adicional=$command->id_dato_adicional;
						}
					}
					/*else
					{
						$result = array('success' => false, 'message' => '<p>Dato adicional ya registrado.</p>');
					}*/
				}
				else
				{
					$commandPDA->id_dato_adicional=$id;
				}

				if( ! ProcesoDatoAdicional::model()->findByAttributes(array('id_proceso'=>$idProc, 'id_dato_adicional'=>$commandPDA->id_dato_adicional)) )
				{
					$commandPDA->id_proceso = $idProc;
					//$commandPDA->obligatorio = $obligatorio;
					
					if($commandPDA->save())
					{
						$transaction->commit();
						$result = array('success' => true, 'message' => '<p>Dato adicional agregado satisfactoriamente.</p>');
					}
					else
					{
						$transaction->rollback();
						//$result = array('success' => false, 'message' => '<p>No se pudo agregar el dato adicional.</p>');
						$result = array('success' => false, 'message' => '<p>Dato adicional ya registrado.</p>');
					}
				}
				else
				{
					$result = array('success' => false, 'message' => '<p>El dato adicional que intenta agregar ya está asociado al proceso.</p>');
				}

			}
			else
			{
				$result = array('success' => false, 'message' => '<p>No se pudo agregar el dato adicional.</p><ul>'.$erroresIngreso.'</ul>');
			}
		}
		else
		{
			$result = array('success' => false, 'message' => 'No se pudo actualizar el dato adicional.');

				//$transaction=Yii::app()->db->beginTransaction();
				$commandPDA = ProcesoDatoAdicional::model()->findByAttributes(array('id_proceso'=>$idProc, 'id_dato_adicional'=>$id));
				//$commandPDA->obligatorio = $obligatorio;
				
				if($commandPDA->save())
				{
					//$transaction->commit();
					$result = array('success' => true, 'message' => '<p>Dato adicional actualizado satisfactoriamente.</p>');
				}
				else
				{
					//$transaction->rollback();
					$result = array('success' => false, 'message' => '<p>No se pudo actualizar el dato adicional.</p>');
				}

		}

		echo CJSON::encode($result);
	}
    
    public function actionModel_graph($id)
    {
        $model = $this->loadModel($id);
        
        $sqlActFin = "SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'"; 
	    $actFin = Yii::app()->db->createCommand($sqlActFin)->queryRow();
        
        $actividadModel = Actividad::model();
        $estadoActividadModel = EstadoActividad::model();
        
        $actividadOrigen=CHtml::listData($actividadModel->findAll(array('select'=>"*, lpad(split_part(codigo_actividad, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as _codigo_2, lpad(split_part(codigo_actividad, '.', 3), 2, '0') as _codigo_3", 'order'=>'_codigo_1, _codigo_2, _codigo_3', 'condition'=>'id_proceso = '.$model->id_proceso." and codigo_actividad <> '".$actFin['valor']."' and activo = 1")),'id_actividad','_codName');
        $estadoSalida=CHtml::listData($estadoActividadModel->findAll(array('order'=>'nombre_estado_actividad')),'id_estado_actividad','nombre_estado_actividad');
        $estadoInicial=CHtml::listData($estadoActividadModel->findAll(array('order'=>'nombre_estado_actividad')),'id_estado_actividad','nombre_estado_actividad');
        
        $modeloEstadoActividadModel = ModeloEstadoActividad::model();

        $this->render('model_graph',array(
			'model'=>$model,
			'modeloEstadoActividadModel'=>$modeloEstadoActividadModel,
            'actividadOrigen'=>$actividadOrigen,
            'estadoSalida' => $estadoSalida,
            'estadoInicial' => $estadoInicial,
            'labelActividad' => $modeloEstadoActividadModel->getAttributeLabel('nombreGenericoActividad'),
            'labelEstadoSalida' => $modeloEstadoActividadModel->getAttributeLabel('id_estado_actividad_salida'),
            'labelEstadoInicio' => $modeloEstadoActividadModel->getAttributeLabel('id_estado_actividad_inicial'),
		));
    }
    
    public function actionGetModeloByProceso()
    {
        $result = ['success' => false];
        if (isset($_POST['id']))
        {
            $modeloActividad = ModeloActividad::model()->findAllByAttributes(['id_proceso' => $_POST['id']]);
            $result = ['success' => true, 'modeloActividad' => $modeloActividad];
        }
        echo CJSON::encode($result);
    }
    
    public function actionEliminarTransicionAjax()
    {
        $result = ['success' => false, 'mensaje' => 'Error intentando eliminar la transición.'];
        if (isset($_POST['origen'], $_POST['destino'], $_POST['proceso']))
        {
            $origen = $_POST['origen'];
            $destino = $_POST['destino'];
            if ($_POST['destino'] == 'fin')
            {
                $actividadFin = Actividad::model()->findByAttributes(['nombre_actividad' => 'FIN', 'id_proceso' => $_POST['proceso']]);
                if ($actividadFin != null)
                {
                    $destino = $actividadFin->id_actividad;
                }
                else
                {
                    $result = ['success' => false, 'mensaje' => 'No se pudo eliminar la transición. No existe la actividad final'];
                    echo CJSON::encode($result);
                    return false;   
                }
            }
            $modeloEstadoActividad = ModeloEstadoActividad::model()->findByAttributes(['id_actividad_origen' => $origen, 'id_actividad_destino' => $destino]);
            if ($modeloEstadoActividad != null)
            {
                if ($modeloEstadoActividad->delete())
                {
                    $result = ['success' => true, 'mensaje' => 'Transición eliminada correctamente.'];
                }
                else
                {
                    $result = ['success' => false, 'mensaje' => 'No se pudo eliminar la transición.'];
                }
            }
        }
        echo CJSON::encode($result);
    }
    
    public function actionAsignarActividadComoInicialAjax()
    {
        $result = ['success' => false, 'mensaje' => 'Error intentando actualizar actividad.'];
        if(isset($_POST['actividad']))
        {
            $actividad = Actividad::model()->findByAttributes(['id_actividad' => $_POST['actividad']]);
            if($actividad != null)
            {
                $actividad->es_inicial = 1;
                $actividad->btn = 1; //quemado, no se para que se usa este campo en el modelo.
                if($actividad->save())
                {
                    $result = ['success' => true, 'mensaje' => 'Actividad actualizada exitosamente.'];
                }
                else
                {
                    $result = ['success' => false, 'mensaje' => 'No se pudo actualizar la actividad.', 'error' => $actividad->errors];
                }
            }
            else
            {
                $result = ['success' => false, 'mensaje' => 'No se pudo actualizar la actividad. No existe la actividad.'];
            }
        }
        echo CJSON::encode($result);
    }
    
    public function actionAsignarActividadComoNoInicialAjax()
    {
        $result = ['success' => false, 'mensaje' => 'Error intentando actualizar actividad.'];
        if(isset($_POST['actividad']))
        {
            $actividad = Actividad::model()->findByAttributes(['id_actividad' => $_POST['actividad']]);
            if($actividad != null)
            {
                $actividad->es_inicial = 0;
                $actividad->btn = 1; //quemado, no se para que se usa este campo en el modelo.
                if($actividad->save())
                {
                    $result = ['success' => true, 'mensaje' => 'Actividad actualizada exitosamente.'];
                }
                else
                {
                    $result = ['success' => false, 'mensaje' => 'No se pudo actualizar la actividad.', 'error' => $actividad->errors];
                }
            }
            else
            {
                $result = ['success' => false, 'mensaje' => 'No se pudo actualizar la actividad. No existe la actividad.'];
            }
        }
        echo CJSON::encode($result);
    }
    
    public function actionModelarProcesoAjax()
    {
        $result = ['success' => false, 'mensaje' => 'Error intentando guardar la transición.'];
        if (isset($_POST['id_actividad_origen'], $_POST['id_actividad_destino'], $_POST['id_estado_actividad_inicial'], $_POST['id_estado_actividad_salida'], $_POST['id_proceso']))
        {
            $modeloEstadoActividad = new ModeloEstadoActividad();
            if ($_POST['id_actividad_destino'] == 'fin')
            {
                $actividadFin = Actividad::model()->findByAttributes(['nombre_actividad' => 'FIN', 'id_proceso' => $_POST['id_proceso']]);
                if ($actividadFin != null)
                {
                    $modeloEstadoActividad->id_actividad_destino = $actividadFin->id_actividad;
                }
                else
                {
                    $result = ['success' => false, 'mensaje' => 'No se pudo crear la transición. No existe la actividad final'];
                    echo CJSON::encode($result);
                    return false;
                }
            }
            else
            {
                $modeloEstadoActividad->id_actividad_destino = $_POST['id_actividad_destino'];    
            }
            $modeloEstadoActividad->id_actividad_origen = $_POST['id_actividad_origen'];
            $modeloEstadoActividad->id_estado_actividad_inicial = $_POST['id_estado_actividad_inicial'];
            $modeloEstadoActividad->id_estado_actividad_salida = $_POST['id_estado_actividad_salida'];
            $modeloEstadoActividad->espera_destino = 0; //hardcoded por que no se utiliza este campo ¯\_(ツ)_/¯
			$transaction=Yii::app()->db->beginTransaction();
			
			if($modeloEstadoActividad->save())
			{
				$completado=true;
				if(isset($_POST['recaudos']) && $_POST['recaudos']!="")
				{
				    $recaudosString = rtrim($_POST['recaudos'],',');
					$recaudos=explode(",", $recaudosString);
					foreach ($recaudos as $value) 
					{
						$modelPR = ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$_POST['id_proceso'], 'id_recaudo'=>$value));

						$modelRAT = new RecaudoActividadTransicion();
						$modelRAT->id_proceso_recaudo = $modelPR->id_proceso_recaudo;
						$modelRAT->id_modelo_estado_actividad = $modeloEstadoActividad->id_modelo_estado_actividad;
						if(!$modelRAT->save())
						{
							$completado=false;
							break;
						}
					}
				}

				if(isset($_POST['datos']) && $_POST['datos']!="")
				{
				    $datosString = rtrim($_POST['datos'],',');
					$datos=explode(",", $datosString);
					foreach ($datos as $value) 
					{
						$modelPD = ProcesoDatoAdicional::model()->findByAttributes(array('id_proceso'=>$_POST['id_proceso'], 'id_dato_adicional'=>$value));

						$modelDAT= new DatoActividadTransicion();
						$modelDAT->id_proceso_dato_adicional=$modelPD->id_proceso_dato_adicional;
						$modelDAT->id_modelo_estado_actividad=$modeloEstadoActividad->id_modelo_estado_actividad;
						if(!$modelDAT->save())
						{
							$completado=false;
							break;
						}
					}
				}

				if($completado)
				{
					$transaction->commit();
                    $result = ['success' => true, 'mensaje' => 'Transición guardada satisfactoriamente.'];
				}
				else
				{
					$transaction->rollback();
                    $result = ['success' => false, 'mensaje' => 'Transición no se pudo guardar. Error al intentar guardar datos adicionales o recaudos'];
				}
			}
            else
            {
                $result = ['success' => false, 'mensaje' => 'Transición no se pudo guardar.', 'error' => $modeloEstadoActividad->errors];
            }
        }
        echo CJSON::encode($result);
    }
    
	/**
	 * Muestra la vista para hacer el modelado del proceso.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionModel($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['ModeloEstadoActividad']))
		{
			$modelModeloEstadoActividad = new ModeloEstadoActividad();
			$modelModeloEstadoActividad->attributes=$_POST['ModeloEstadoActividad'];

			//$recaudosAsociados=Recaudo::model()->findAllByAttributes(array('id_actividad'=>$modelModeloEstadoActividad->id_actividad_origen));

			//if($recaudosAsociados)

			$transaction=Yii::app()->db->beginTransaction();
			
			if($modelModeloEstadoActividad->save())
			{
				$completado=true;
				if($modelModeloEstadoActividad->_idRecaudos!="")
				{
					$recaudos=explode(",", $modelModeloEstadoActividad->_idRecaudos);
					foreach ($recaudos as $value) 
					{
						$modelPR = ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$model->id_proceso, 'id_recaudo'=>$value));

						$modelRAT = new RecaudoActividadTransicion();
						//$model = new ActividadRol();
						$modelRAT->id_proceso_recaudo = $modelPR->id_proceso_recaudo;
						$modelRAT->id_modelo_estado_actividad = $modelModeloEstadoActividad->id_modelo_estado_actividad;
						if(!$modelRAT->save())
						{
							$completado=false;
							break;
						}
					}
				}

				if($modelModeloEstadoActividad->_idDatos!="")
				{
					$datos=explode(",", $modelModeloEstadoActividad->_idDatos);
					foreach ($datos as $value) 
					{
						$modelPD = ProcesoDatoAdicional::model()->findByAttributes(array('id_proceso'=>$model->id_proceso, 'id_dato_adicional'=>$value));

						$modelDAT= new DatoActividadTransicion();
						$modelDAT->id_proceso_dato_adicional=$modelPD->id_proceso_dato_adicional;
						$modelDAT->id_modelo_estado_actividad=$modelModeloEstadoActividad->id_modelo_estado_actividad;
						if(!$modelDAT->save())
						{
							$completado=false;
							break;
						}
					}
				}

				if($completado)
				{
					$transaction->commit();
					Yii::app()->user->setFlash("success", "Transición guardada satisfactoriamente.");
				}
				else
				{
					$transaction->rollback();
					Yii::app()->user->setFlash("error", "Transición no se pudo guardar.");
				}

				$this->redirect(array('model', 'id'=>$id));
			}
		}

		$modelModeloAct=new CActiveDataProvider(ModeloActividad::model(), array(
			'keyAttribute'=>'id_modelo_estado_actividad',
			'criteria'=>array(
				'select'=>"*, lpad(split_part(codigo_actividad_origen, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad_origen, '.', 2), 2, '0') as _codigo_2, lpad(split_part(codigo_actividad_origen, '.', 3), 2, '0') as _codigo_3",
				'condition'=>'id_proceso='.$id,
				'order'=>'_codigo_1, _codigo_2, _codigo_3 ASC',
				//'order'=>'es_inicial DESC, codigo_actividad_origen ASC',
			),
			'pagination'=>array('pageSize'=>15),
		));
		
		$this->render('model',array(
			'model'=>$model,
			'modelModeloAct'=>$modelModeloAct,
		));
	}

	public function actionBuscarRecaudos()
	{
		$result = array('success' => false);

		/*$idRecaudos = ProcesoRecaudo::model()->find(array('select'=>"array_to_string(array_agg(id_recaudo), ',') as id_recaudo, array_to_string(array_agg(id_proceso_recaudo), ',') as id_proceso_recaudo", "condition"=>"id_proceso =".$_POST['idProc']));
		$idRecaudosEditables = RecaudoActividad::model()->find(array('select'=>"array_to_string(array_agg(id_proceso_recaudo), ',') as id_proceso_recaudo", 'condition'=>'id_proceso_recaudo IN('.$idRecaudos->id_proceso_recaudo.') AND id_actividad ='.$_POST['idAct']));*/

		
		$idRecaudosEditables = RecaudoActividad::model()->find(array('select'=>"array_to_string(array_agg(id_proceso_recaudo), ',') as id_proceso_recaudo", 'condition'=>'id_actividad ='.$_POST['idAct']));
		
		if($idRecaudosEditables && $idRecaudosEditables->id_proceso_recaudo!="")
		{
			$idRecaudos = ProcesoRecaudo::model()->find(array('select'=>"array_to_string(array_agg(id_recaudo), ',') as id_recaudo", "condition"=>"id_proceso_recaudo IN(".$idRecaudosEditables->id_proceso_recaudo.") AND id_proceso =".$_POST['idProc']));
			
			if($idRecaudos && $idRecaudos->id_recaudo!="")
			{
				$recaudosEditables=Recaudo::model()->findAll(array('condition'=>'id_recaudo IN('.$idRecaudos->id_recaudo.')'));

				if($recaudosEditables)
				{
					$modelRecaudo = ModeloEstadoActividad::model();
					$result = array('success' => true,

						'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodas()')),
						'recaudos' => CHtml::activeCheckBoxList($modelRecaudo, '_recaudos', //$consignados,
						   	CHtml::listData($recaudosEditables, 'id_recaudo', 'nombre_recaudo'),
						   	//$model->id_recaudo,
						   	array('separator'=>'',
						      	'style'=>'float:left; margin-right: 5px;',
						      	'onChange'=>'seleccionadas()',
						   	)
						         
						),

						'continuar' => CHtml::button('Continuar', array('onClick'=>'continuar()', 'class'=>'btn-primary')),
						'cancelar' => CHtml::button('Cancelar', array('onClick'=>'cancelar()', 'class'=>'btn-primary'))

					);
					
				}
			}
		}
		
		echo CJSON::encode($result);
	}

	public function actionBuscarDatosAdicionales()
	{
		$result = array('success' => false);

		$idDatosEditables = DatoActividad::model()->find(array('select'=>"array_to_string(array_agg(id_proceso_dato_adicional), ',') as id_proceso_dato_adicional", 'condition'=>'id_actividad ='.$_POST['idAct']));
		
		if($idDatosEditables && $idDatosEditables->id_proceso_dato_adicional!="")
		{
			$idDatos = ProcesoDatoAdicional::model()->find(array('select'=>"array_to_string(array_agg(id_dato_adicional), ',') as id_dato_adicional", "condition"=>"id_proceso_dato_adicional IN(".$idDatosEditables->id_proceso_dato_adicional.") AND id_proceso =".$_POST['idProc']));
			
			if($idDatos && $idDatos->id_dato_adicional!="")
			{
				$datosEditables=DatoAdicional::model()->findAll(array('condition'=>'id_dato_adicional IN('.$idDatos->id_dato_adicional.')'));

				if($datosEditables)
				{
					$modelDatos = ModeloEstadoActividad::model();
					$result = array('success' => true,

						'seleccionar' => CHtml::checkBox('_chequear',false, array ('onClick'=>'seleccionarTodosDA()')),
						'datosA' => CHtml::activeCheckBoxList($modelDatos, '_datos', 
						   	CHtml::listData($datosEditables, 'id_dato_adicional', 'nombre_dato_adicional'),
						   	//$model->id_recaudo,
						   	array('separator'=>'',
						      	'style'=>'float:left; margin-right: 5px;',
						      	'onChange'=>'seleccionadosDA()',
						   	)
						         
						),

						'continuar' => CHtml::button('Continuar', array('onClick'=>'continuarTransicion()', 'class'=>'btn-primary')),
						'cancelar' => CHtml::button('Cancelar', array('onClick'=>'cancelarTransicion()', 'class'=>'btn-primary'))

					);
					
				}
			}
		}
		
		echo CJSON::encode($result);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'admin' page.
	 */
	public function actionCreate()
	{
		$model=new Proceso;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Proceso']))
		{
			$model->attributes=$_POST['Proceso'];
			$model->_idProcesoCopia=-1;
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
				$this->redirect(array('admin'));
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCopy()
	{
		$model=new Proceso;

		$idOrganizacion = Organizacion::model()->find(array('order'=>'nombre_organizacion'));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Proceso']))
		{
			$model->attributes=$_POST['Proceso'];

			if($model->_idProcesoCopia != "")
			{
				$modelProcesoCopia = Proceso::model()->findByPk($model->_idProcesoCopia);

				$model->recurso_reconsideracion = $modelProcesoCopia->recurso_reconsideracion;
			}

			$transaction=Yii::app()->db->beginTransaction();
			if($model->save())
			{
				if(Yii::app()->db->createCommand('select insert_copia_actividad('.$modelProcesoCopia->id_proceso.', '.$model->id_proceso.')')->query())
				{
					if(Yii::app()->db->createCommand('select insert_copia_modelado('.$modelProcesoCopia->id_proceso.', '.$model->id_proceso.')')->query())
						if(Yii::app()->db->createCommand('select insert_copia_dato_adicional('.$modelProcesoCopia->id_proceso.', '.$model->id_proceso.')')->query())
							if(Yii::app()->db->createCommand('select insert_copia_recaudo('.$modelProcesoCopia->id_proceso.', '.$model->id_proceso.')')->query())
								$transaction->commit();
				}
				else
					$transaction->rollback();

				Yii::app()->user->setFlash('success', 'Registro copiado satisfactoriamente.');
				$this->redirect(array('admin'));
			}
				
		}

		$this->render('copy',array(
			'model'=>$model,
			'idOrganizacion'=>$idOrganizacion->id_organizacion,
		));
	}

	public function actionGetProcesos() 
	{
		$result = array('success' => false);

		$organizacion = $_POST['organizacion'];
	
		if($organizacion!="")
		{
			$procesos = Proceso::model();
			$procesosOrganizacion = $procesos->findAllByAttributes(array('id_organizacion'=>$organizacion), array("order"=>"nombre_proceso"));
			
			$result = array(
				'success' => true,
				'proceso' => CHtml::dropDownList('_idProcesoCopia', '',
						CHtml::listData($procesosOrganizacion, 'id_proceso', 'nombre_proceso'), 
						array('prompt' => '--Seleccione--', 
							'class' => (isset($_POST['class'])? $_POST['class'] : 'span7'), 
							'id' => (isset($_POST['procesoCopiaId'])? $_POST['procesoCopiaId']: 'Proceso__idProcesoCopia'), 
							'name' => (isset($_POST['procesoCopiaName'])? $_POST['procesoCopiaName']: 'Proceso[_idProcesoCopia]'))
				)
			);	
		}
		
		echo CJSON::encode($result);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Proceso']))
		{
			$model->attributes=$_POST['Proceso'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro actualizado satisfactoriamente.");
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$query="SELECT count(*) as _cant FROM instancia_proceso WHERE id_proceso = ".$id;
		$inst_proc = Yii::app()->db->createCommand($query)->queryRow();	

        if($inst_proc['_cant']>0) 
        {
        	Yii::app()->user->setFlash("error", "No se puede eliminar. El registro está siendo utilizado.");
        }
        else
        {
        	$delete=Yii::app()->db->createCommand('select delete_proceso('.$id.')')->query();
			Yii::app()->user->setFlash("success", "Registro eliminado satisfactoriamente.");
		}
			

		$this->redirect(array('admin'));

	}

	public function actionDeleteGrid($id)
	{
		$result = array('success' => false);

		$query="SELECT count(*) as _cant FROM instancia_proceso WHERE id_proceso = ".$id;
		$inst_proc = Yii::app()->db->createCommand($query)->queryRow();	

        if($inst_proc['_cant']>0) 
        	$result = array('success' => false, 'message' => 'No se puede eliminar. El registro está siendo utilizado.');
		else
		{
			$delete=Yii::app()->db->createCommand('select delete_proceso('.$id.')')->query();
			$result = array('success' => true, 'message'=>'Registro eliminado satisfactoriamente.');
		}
			
		echo CJSON::encode($result);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Proceso');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Proceso('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proceso']))
			$model->attributes=$_GET['Proceso'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Proceso the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Proceso::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Proceso $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='proceso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
