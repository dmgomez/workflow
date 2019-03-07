<?php

class CabeceraReporteController extends Controller
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
	public function actionCreate()
	{
		
		$dataProvider=new CActiveDataProvider('CabeceraReporte');

		$dt=$dataProvider->getItemCount();
		$dtId=$dataProvider->getKeys();

		if($dt<=0)
		{
			$model=new CabeceraReporte;
		}
		else
		{
			$model=$this->loadModel($dtId);
			$img=CabeceraReporte::model()->findByPk($dtId);
		}

        if(isset($_POST['CabeceraReporte']))
        {
            $model->attributes=$_POST['CabeceraReporte'];
            $model->_imagenLogo=CUploadedFile::getInstance($model,'_imagenLogo');
            
            if(is_object($model->_imagenLogo))
			{
			    $size=$model->_imagenLogo->getSize();
	            $ext=$model->_imagenLogo->getExtensionName();
	            $model->ubicacion_logo='logo.'.$ext;

	            if($size<=2000000)
	            {
	            	if($ext=='png' || $ext=='jpg' || $ext=='jpeg')
	            	{
			            if($model->save())
			            {
			            	$ext=$model->_imagenLogo->getExtensionName();
			                $model->_imagenLogo->saveAs('images/logos/logo.'.$ext);
			                Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
			                $this->redirect(array('view','id'=>$model->id_cabecera_reporte));
			            }
			        }
			        else
		        	{
		                $model->addError('_imagenLogo','Imagen Logo inválida. Los formatos permitidos son: .png y .jpg');
		            }
	        	}
	        	else
	        	{
	                $model->addError('_imagenLogo','Imagen Logo debe ser de máximo 2MB.');
	            }
			}
			elseif (isset($img)) 
			{
				CabeceraReporte::model()->updateByPk($model->id_cabecera_reporte, array('titulo_reporte' =>  $model->titulo_reporte, 'subtitulo_1' =>  $model->subtitulo_1, 'subtitulo_2' =>  $model->subtitulo_2, 'subtitulo_3' =>  $model->subtitulo_3, 'subtitulo_4' =>  $model->subtitulo_4, 'alineacion_titulos' => $model->alineacion_titulos) );

				Yii::app()->user->setFlash('success', 'Cabecera configurada satisfactoriamente.');
				$this->redirect(array('view','id'=>$model->id_cabecera_reporte));
				
			}
			else
        	{
	            $model->addError('_imagenLogo','Imagen Logo no puede ser nulo.');
            }
            
        }
        $this->render('create', array('model'=>$model));
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

		if(isset($_POST['CabeceraReporte']))
		{
			$model->attributes=$_POST['CabeceraReporte'];
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
		
		$dataProvider=new CActiveDataProvider('CabeceraReporte');

		$dt=$dataProvider->getItemCount();
		$dtId=$dataProvider->getKeys();
		
		if($dt<=0)
		{
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
			));
		}
		else
		{
			$this->render('view',array(
				'model'=>$this->loadModel($dtId),
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CabeceraReporte('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CabeceraReporte']))
			$model->attributes=$_GET['CabeceraReporte'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CabeceraReporte the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CabeceraReporte::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CabeceraReporte $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cabecera-reporte-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
