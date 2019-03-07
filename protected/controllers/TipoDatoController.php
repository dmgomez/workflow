<?php

class TipoDatoController extends Controller
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
	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
	}*/

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
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TipoDato;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoDato']))
		{
			$model->attributes=$_POST['TipoDato'];
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoDato']))
		{
			$model->attributes=$_POST['TipoDato'];
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
		if(Yii::app()->request->isPostRequest)
		{
			try 
			{
				// we only allow deletion via POST request
				$this->loadModel($id)->delete();

				Yii::app()->user->setFlash("success", "Registro eliminado satisfactoriamente.");
			}

			catch (Exception $e) 
			{
				if(strpos($e, 'Foreign key violation'))
			  	{
			  		Yii::app()->user->setFlash("error", "No se puede eliminar. El registro está siendo utilizado.");
			  	}
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
				$result = array('success' => true, 'message'=>'Registro eliminado satisfactoriamente.');
				
			} 
			catch (Exception $e) 
			{
				if(strpos($e, 'Foreign key violation'))
			  	{
			  		$result = array('success' => false, 'message' => 'No se puede eliminar. El registro está ssiendo utilizado.');
			  	}
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

		echo CJSON::encode($result);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TipoDato('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TipoDato']))
			$model->attributes=$_GET['TipoDato'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TipoDato::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-dato-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
