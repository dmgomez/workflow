<?php

class DatoAdicionalController extends Controller
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
				'actions'=>array('create','update', 'DeleteGrid', 'admin','delete'),
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
		$model = $this->loadModel($id);

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
		$model=new DatoAdicional;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DatoAdicional']))
		{
			$model->attributes=$_POST['DatoAdicional'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro creado satisfactoriamente.");
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionDatoEnUso()
	{
		$result = array('enUso' => false);

		$id=$_POST['id'];

		if($id != "")
		{
			$esta_asociado = ProcesoDatoAdicional::model()->findByAttributes(array('id_dato_adicional' => $id));
			if($esta_asociado)
				$result = array('enUso' => true);
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

		if(isset($_POST['DatoAdicional']))
		{
			$model->attributes=$_POST['DatoAdicional'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro actualizado satisfactoriamente.");
				$this->redirect(array('admin'));
				//$this->redirect(array('actividad/'.$model->id_actividad));
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
		try 
		{			
			$this->loadModel($id)->delete();
		}
		catch (Exception $e) 
		{
			if(strpos($e, 'Foreign key violation'))
		  	{
		  		Yii::app()->user->setFlash("error", "No se puede eliminar. El registro está siendo utilizado.");
		  		$this->redirect(array('admin'));
		  	}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Yii::app()->user->setFlash("success", "Dato Adicional eliminado satisfactoriamente.");
			$this->redirect(array('admin'));
		}
	}

	public function actionDeleteGrid($id)
	{
		$result = array('success' => false);

		if(Yii::app()->request->isPostRequest)
		{
			try 
			{
				// we only allow deletion via POST request
				$this->loadModel($id)->delete();
				$result = array('success' => true, 'message'=>'Dato Adicional eliminado satisfactoriamente.');
				
			} 
			catch (Exception $e) 
			{
				if(strpos($e, 'Foreign key violation'))
			  	{
			  		$result = array('success' => false, 'message' => 'No se puede eliminar. El registro está siendo utilizado.');
			  	}
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

		echo CJSON::encode($result);
	}

	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DatoAdicional');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DatoAdicional('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DatoAdicional']))
			$model->attributes=$_GET['DatoAdicional'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DatoAdicional the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DatoAdicional::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DatoAdicional $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='dato-adicional-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
