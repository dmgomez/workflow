<?php

class ActividadRolController extends Controller
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
				'actions'=>array('create','update', 'admin', 'delete', 'ActivarActividades', 'AsociarActividad', 'ActividadesAsociadas', 'ProcesosActividadesAsociadas', 'DesasociarActividad'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'admin' page.
	 */
	public function actionCreate($idRol, $nombreRol)
	{
		$model=new ActividadRol;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('create',array(
			'model'=>$model,
			'idRol'=>$idRol,
			'nombreRol'=>$nombreRol,
		));
	}

	public function actionActivarActividades()
	{
		$sqlActFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
		$actFin= Yii::app()->db->createCommand($sqlActFin)->queryRow();

		$actRol = ActividadRol::model();

		$sqlActividadesProceso="SELECT id_actividad, concat(codigo_actividad, ' - ', nombre_actividad) as nombre_actividad, lpad(split_part(codigo_actividad, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as _codigo_2, 
										lpad(split_part(codigo_actividad, '.', 3), 2, '0') as _codigo_3 FROM actividad WHERE id_proceso = ".(int) $_POST['idProceso']." AND codigo_actividad <> '".$actFin['valor']."' ORDER BY _codigo_1, _codigo_2, _codigo_3 ASC";
		$actividadesProceso= Yii::app()->db->createCommand($sqlActividadesProceso)->query();

		$keys = ActividadRol::model()->findAll(array('condition'=>'id_rol = '.(int) $_POST['idRol']));
		$selected_keys = array_keys(CHtml::listData($keys, 'id_actividad', 'id_actividad' ));
		
		if($actividadesProceso!="" && $actividadesProceso!=null)
		{
			$result = array(
				'actividad' => CHtml::checkBoxList('_actividad', $selected_keys,
						CHtml::listData($actividadesProceso, 'id_actividad', 'nombre_actividad'),
						array('separator'=>'',
							'style'=>'float:left; margin-right: 5px;',
							'onChange'=>'seleccionadas()',
						)
						
				)
			);
		}
		else
		{
			$result = array('actividad' => '<i>No se encontraron actividades para el proceso seleccionado.</i>');
		}
		echo CJSON::encode($result);
	}

	public function actionAsociarActividad()
	{
		$result = array('success'=>false, 'message'=>'Debe seleccionar las actividades a vincular.');

		$actividades=$_POST['actividades'];
		$rol=$_POST['rol'];
		$idProceso=$_POST['idProceso'];

		if($actividades!="" && $rol!="")
		{
			$actividadAct=ActividadRol::model()->findAllByAttributes(array('id_rol'=>$rol));
			if ($actividadAct) 
			{
				$actividadTemp="";
				foreach ($actividadAct as $value) 
				{
					if(Actividad::model()->findByAttributes(array('id_actividad'=>$value['id_actividad'], 'id_proceso'=>$idProceso)))
					{
						$actividadTemp.=$value['id_actividad'].',';
					}
				}
				$actividadTemp=substr($actividadTemp, 0, -1);

				if($actividadTemp) 
				{
					ActividadRol::model()->deleteAll('id_rol IN (' . $rol . ') AND id_actividad IN (' . $actividadTemp . ')');
				}
			}
		

			$actividades=explode(",", $actividades);
			foreach ($actividades as $value) 
			{
				$model = new ActividadRol();
				$model->id_rol=$rol;
				$model->id_actividad=$value;
				$model->save();
			}

			$result = array('success'=>true, 'message'=>'Actividades vinculadas satisfactoriamente.');
		}

		echo CJSON::encode($result);

	}

	public function actionProcesosActividadesAsociadas()
	{
		$result=array('success' => false);

		$idRol=$_POST['idRol'];

		$actRol = ActividadRol::model();

		$sqlProcesos="SELECT id_proceso, nombre_proceso FROM proceso WHERE id_proceso IN(SELECT id_proceso FROM actividad WHERE id_actividad IN(SELECT id_actividad FROM actividad_rol WHERE id_rol = ".$idRol.")) ORDER BY nombre_proceso";
		$procesos= Yii::app()->db->createCommand($sqlProcesos)->queryAll();

		if($procesos)
		{

			$result=array('success' => true, 'proceso' => CHtml::activeDropDownList($actRol, '_procesosVinculados', 
									CHtml::listData($procesos, 'id_proceso', 'nombre_proceso'), array('onChange'=>'refrescarActividadesAsociadas()', 'class'=>'span9', /*'options' => array($idP=>array('selected'=>'selected'))*/ )) );
		}

		echo CJSON::encode($result);
		
	}

	public function actionActividadesAsociadas()
	{
		$idProc=$_POST['idProc'];
		$idRol=$_POST['idRol'];

		$actRol = ActividadRol::model();

		$sqlActAsociadas="SELECT id_actividad, concat(codigo_actividad, ' - ', nombre_actividad)as actividad, lpad(split_part(codigo_actividad, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as _codigo_2, 
						lpad(split_part(codigo_actividad, '.', 3), 2, '0') as _codigo_3 FROM actividad WHERE id_actividad IN(SELECT id_actividad FROM actividad_rol WHERE id_rol= ".$idRol." AND id_actividad IN(SELECT id_actividad 
						FROM actividad WHERE id_proceso = ".$idProc.")) ORDER BY _codigo_1, _codigo_2, _codigo_3";
		$actAsosiadas= Yii::app()->db->createCommand($sqlActAsociadas)->query();


		$actividades[]="";
		if ($actAsosiadas) 
		{
			foreach ($actAsosiadas as $key => $value) 
			{
				$actividad = Actividad::model()->findByPk($value['id_actividad']);
				$proceso = Proceso::model()->findByPk($actividad->id_proceso);
				$actividades[$key] = array('id'=>$value['id_actividad'],'nombre'=>$actividad->codigo_actividad.' - '.$actividad->nombre_actividad);
			}

			$result = array(
				'actividad' => CHtml::activeCheckBoxList($actRol, '_actividadesAsociadas', 
						CHtml::listData($actividades, 'id', 'nombre'),
						array('separator'=>'',
							'style'=>'float:left; margin-right: 5px;',
							'onChange'=>'seleccionadasBorrar()',
						)
						
				)
			);

			echo CJSON::encode($result);
		}
		
		
	}

	public function actionDesasociarActividad()
	{
		$result = array('success'=>false, 'message'=>'Debe seleccionar las actividades a desvincular.');

		$actividadesA=$_POST['actividades'];
		$rol=$_POST['rol'];

		if($actividadesA!="" && $rol!="")
		{
			ActividadRol::model()->deleteAll('id_rol IN (' . $rol . ') AND id_actividad IN (' . $actividadesA . ')');

			$result = array('success'=>true, 'message'=>'Actividades desvinculadas satisfactoriamente.');
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

		if(isset($_POST['ActividadRol']))
		{
			$model->attributes=$_POST['ActividadRol'];
			if($model->save())
				$this->redirect(array('admin'));
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
		$dataProvider=new CActiveDataProvider('ActividadRol');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($idRol, $nombreRol)
	{
		$model=new ActividadRol('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ActividadRol']))
			$model->attributes=$_GET['ActividadRol'];

		$this->render('admin',array(
			'model'=>$model,
			'idRol'=>$idRol,
			'nombreRol'=>$nombreRol,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ActividadRol the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ActividadRol::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ActividadRol $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='actividad-rol-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
