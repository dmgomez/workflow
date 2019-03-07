<?php

class EmpleadoRolController extends Controller
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
				'actions'=>array('create','update', 'admin', 'delete', 'ActivarEmpleados', 'AsociarEmpleado', 'EmpleadosAsociados', 'DesasociarEmpleado'),
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
		$model=new EmpleadoRol;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$empleados = Empleado::model()->findAll();

		$empleadoArr[]="";
		if ($empleados) 
		{
			foreach ($empleados as $key => $value) 
			{
				$nombre=Persona::model()->findByPk($value['id_persona']);
				$empleadoArr[$key]=array('id'=>$value['id_empleado'],'nombre'=>$nombre->nombre_persona.' '.$nombre->apellido_persona);
			}
		}
		$array[]=array('id'=>'-1', 'nombre'=>'Todos');
		$cargos = Cargo::model()->findAll(array('order' => 'nombre_cargo'));

		if ($cargos) 
		{
			foreach ($cargos as $key => $value) 
			{
				$array2[$key]=array('id'=>$value['id_cargo'],'nombre'=>$value['nombre_cargo']);
			}
		}

		$arrayCargo = array_merge($array, $array2);

		$this->render('create',array(
			'model'=>$model,
			'idRol'=>$idRol,
			'nombreRol'=>$nombreRol,
			'empleadoArr'=>$empleadoArr,
			'arrayCargo'=>$arrayCargo,
		));
	}

	public function actionActivarEmpleados()
	{
		$empleados = Empleado::model();

		$cargo=$_POST['idCargo'];
		
		if($cargo==-1)
		{
			$empleadosCargo = $empleados->findAll();
		}
		else
		{
			$empleadosCargo = $empleados->findAll(array('condition'=>'id_cargo = '.(int) $_POST['idCargo']));
		}

		$empleadoArr[]="";
		if ($empleadosCargo) 
		{
			foreach ($empleadosCargo as $key => $value) 
			{
				$nombre=Persona::model()->findByPk($value['id_persona']);
				$empleadoArr[$key]=array('id'=>$value['id_empleado'],'nombre'=>$nombre->nombre_persona.' '.$nombre->apellido_persona);
			}
		}
		
		$keys = EmpleadoRol::model()->findAll(array('condition'=>'id_rol = '.(int) $_POST['idRol']));
		$selected_keys = array_keys(CHtml::listData($keys, 'id_empleado', 'id_empleado' ));
		
		if(count($empleadoArr)>1 || (count($empleadoArr)==1 && $empleadoArr[0]!=""))
		{
			$result = array(
				'empleado' => CHtml::checkBoxList('_empleado', $selected_keys,
					CHtml::listData($empleadoArr, 'id', 'nombre'),
					array('separator'=>'',
						'style'=>'float:left; margin-right: 5px;',
						'onChange'=>'seleccionados()',
					)
						
				)
			);
		}
		else
		{
			$result = array('empleado' => '<i>No se encontraron empleados para el cargo seleccionado.</i>');
		}
		echo CJSON::encode($result);
	}

	public function actionAsociarEmpleado()
	{
		$result = array('success'=>false, 'message'=>'Debe seleccionar los empleados a vincular.');

		$empleados=$_POST['empleados'];
		$rol=$_POST['rol'];
		$idCargo=$_POST['idCargo'];

		if($empleados!="" && $rol!="")
		{
			$empleadoAct=EmpleadoRol::model()->findAllByAttributes(array('id_rol'=>$rol));
			if ($empleadoAct) 
			{
				$empleadoTemp="";
				foreach ($empleadoAct as $value) 
				{
					if(Empleado::model()->findByAttributes(array('id_empleado'=>$value['id_empleado'], 'id_cargo'=>$idCargo)))
					{
						$empleadoTemp.=$value['id_empleado'].',';
					}
				}
				$empleadoTemp=substr($empleadoTemp, 0, -1);

				if($empleadoTemp!="") 
				{
					EmpleadoRol::model()->deleteAll('id_rol IN (' . $rol . ') AND id_empleado IN (' . $empleadoTemp . ')');
				}
			}
		

			$empleados=explode(",", $empleados);
			foreach ($empleados as $value) 
			{
				$model = new EmpleadoRol();
				$model->id_rol=$rol;
				$model->id_empleado=$value;
				$model->save();
			}
			$result = array('success'=>true, 'message'=>'Empleados vinculados satisfactoriamente.');
		}
		
		echo CJSON::encode($result);
	}

	public function actionEmpleadosAsociados()
	{
		$idRol=$_POST['idRol'];

		$empleadoRol = EmpleadoRol::model();
		$empleadosAsosiados = EmpleadoRol::model()->findAll(array('condition'=>'id_rol = '.$idRol));

		$empleados[]="";
		if ($empleadosAsosiados) 
		{
			foreach ($empleadosAsosiados as $key => $value) 
			{
				$empleado = Empleado::model()->findByPk($value['id_empleado']);
				$cargo = Cargo::model()->findByPk($empleado->id_cargo);
				$persona= Persona::model()->findByPk($empleado->id_persona);
				$empleados[$key] = array('id'=>$value['id_empleado'],'nombre'=>$persona->nombre_persona.' '.$persona->apellido_persona.' - '.$cargo->nombre_cargo);
			}

			$result = array(
				'empleado' => CHtml::activeCheckBoxList($empleadoRol, '_empleadosAsociados', 
						CHtml::listData($empleados, 'id', 'nombre'),
						array('separator'=>'',
							'style'=>'float:left; margin-right: 5px;',
							'onChange'=>'seleccionadosBorrar()',
						)
						
				)
			);

			echo CJSON::encode($result);
		}
		
		
	}

	public function actionDesasociarEmpleado()
	{
		$result = array('success'=>false, 'message'=>'Debe seleccionar los empleados a desvincular.');

		$empleadosA=$_POST['empleados'];
		$rol=$_POST['rol'];

		if($empleadosA!="" && $rol!="")
		{
			EmpleadoRol::model()->deleteAll('id_rol IN (' . $rol . ') AND id_empleado IN (' . $empleadosA . ')');

			$result = array('success'=>true, 'message'=>'Empleados desvinculados satisfactoriamente.');
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

		if(isset($_POST['EmpleadoRol']))
		{
			$model->attributes=$_POST['EmpleadoRol'];
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
		$dataProvider=new CActiveDataProvider('EmpleadoRol');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EmpleadoRol('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EmpleadoRol']))
			$model->attributes=$_GET['EmpleadoRol'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EmpleadoRol the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EmpleadoRol::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EmpleadoRol $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='empleado-rol-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
