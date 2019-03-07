<?php

class ModeloEstadoActividadController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $idProc)
	{
		$result = array('success' => false);

		$query="SELECT count(*) as _cant FROM instancia_proceso WHERE id_proceso = ".$idProc;
		$inst_proc = Yii::app()->db->createCommand($query)->queryRow();	

        if($inst_proc['_cant']>0) 
        {
        	$result = array('success' => false, 'message' => 'No se puede eliminar. El registro está siendo utilizado.');
        }
        else
        {
        	$delete=Yii::app()->db->createCommand('select delete_transicion('.$id.')')->query();
			$result = array('success' => true, 'message'=>'Transición eliminada satisfactoriamente.');

		}
		
		echo CJSON::encode($result);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ModeloEstadoActividad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ModeloEstadoActividad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ModeloEstadoActividad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='modelo-estado-actividad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
