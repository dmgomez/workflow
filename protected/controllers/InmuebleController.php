<?php

class InmuebleController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update', 'GetParroquias', 'admin','delete', 'DeleteGrid'),
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
		$modelTramites=new CActiveDataProvider(InstanciaProceso::model(), array(
			'keyAttribute'=>'id_instancia_proceso',
			'criteria'=>array(
				'with'=>array('idProceso'=>array('alias' => 'proceso'), 'idEstadoInstanciaProceso'=>array('alias' => 'estadoinstanciaproceso')),
				'condition'=>"id_inmueble=".$id,
				'order'=>'codigo_instancia_proceso ASC',
			),



			
			'sort' => array(
	            'defaultOrder' => 'codigo_instancia_proceso ASC',
	            'attributes' => array(
	                'codigo_instancia_proceso'=>array(
				        'asc'=>'codigo_instancia_proceso',
				        'desc'=>'codigo_instancia_proceso desc',
				    ),
				    'nombreProceso'=>array(
				        'asc'=>'proceso.nombre_proceso',
				        'desc'=>'proceso.nombre_proceso desc',
				    ),
				    'nombre_solicitante'=>array(
				        'asc'=>'nombre_solicitante',
				        'desc'=>'nombre_solicitante desc',
				    ),
				    'nombreEstado'=>array(
				        'asc'=>'estadoinstanciaproceso.nombre_estado_instancia_proceso',
				        'desc'=>'estadoinstanciaproceso.nombre_estado_instancia_proceso desc',
				    ),
				    'fecha_ini_proceso'=>array(
				        'asc'=>'fecha_ini_proceso',
				        'desc'=>'fecha_ini_proceso desc',
				    ),
				    'fecha_fin_proceso'=>array(
				        'asc'=>'fecha_fin_proceso',
				        'desc'=>'fecha_fin_proceso desc',
				    ),
	            ),
	        ),




		));

		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'modelTramites'=>$modelTramites,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'admin' page.
	 */
	public function actionCreate()
	{
		$sqlMunicipio="SELECT valor FROM configuracion WHERE variable = 'id_municipio'";
		$municipio= Yii::app()->db->createCommand($sqlMunicipio)->queryRow();

		$model=new Inmueble;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inmueble']))
		{
			$model->attributes=$_POST['Inmueble'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro creado satisfactoriamente.");
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'idMunicipio'=>$municipio['valor'],
		));
	}

	public function actionGetParroquias() {
		$parroquias = Parroquia::model();
		$inmueble = Inmueble::model();
		$parroquiasMunicipios = $parroquias->findAll('id_municipio=:id_municipio', array(':id_municipio' => (int) $_POST['municipio']));
		
		$result = array(
			'parroquia' => CHtml::activeDropDownList($inmueble, 'id_parroquia', 
					CHtml::listData($parroquiasMunicipios, 'id_parroquia', 'nombre_parroquia'), 
					array('prompt' => 'Seleccione', 
						'class' => (isset($_POST['class'])? $_POST['class'] : 'span4'), 
						'id' => (isset($_POST['parroquiaId'])? $_POST['parroquiaId']: 'Parroquia_id_parroquia'), 
						'name' => (isset($_POST['parroquiaName'])? $_POST['parroquiaName']: 'Parroquia[id_parroquia]'))
			)
		);
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

		$parroquia=Parroquia::model()->findBypk($model->id_parroquia);
		$municipio=Municipio::model()->findBypk($parroquia->id_municipio);
		$idMunicipio = $municipio->id_municipio;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inmueble']))
		{
			$model->attributes=$_POST['Inmueble'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Registro actualizado satisfactoriamente.");
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'idMunicipio'=>$idMunicipio,
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
			Yii::app()->user->setFlash("success", "Registro eliminado satisfactoriamente.");
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
				$result = array('success' => true, 'message'=>'Registro eliminado satisfactoriamente.');
				
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Inmueble');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Inmueble('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inmueble']))
			$model->attributes=$_GET['Inmueble'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inmueble the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inmueble::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inmueble $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inmueble-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
