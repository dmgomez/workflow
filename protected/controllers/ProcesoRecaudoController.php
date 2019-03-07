<?php

class ProcesoRecaudoController extends Controller
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
				'actions'=>array('create','update', 'buscarRecaudoPorId'),
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
		$model = $this->loadModel($id);

		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$model->id_proceso);

		$this->render('view',array(
			'model'=>$model,
			'idProceso'=>$model->id_proceso,
			'codigoProceso'=>$proc->codigo_proceso,
			'nombreProceso'=>$proc->nombre_proceso,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate($idProceso)
	{
		$model=new ProcesoRecaudo;

		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$idProceso);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProcesoRecaudo']))
		{
			$model->attributes=$_POST['ProcesoRecaudo'];

			if(($model->id_recaudo=="" || $model->id_recaudo==null) && $model->nombreRecaudo!="")
			{
				$command = new Recaudo();
				$command->nombre_recaudo = $model->nombreRecaudo;

				if($command->save())
				{
					$model->id_recaudo=$command->id_recaudo;
				}
			}

			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Recaudo agregado satisfactoriamente.');
				$this->redirect(array('proceso/view','id'=>$idProceso));
				//$this->redirect(array('view','id'=>$model->id_proceso_recaudo));
			}
		}

		if(isset($_GET['Recaudo'])){
			
			$model=new Recaudo('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['Recaudo'])){
				$model->attributes=$_GET['Recaudo'];
			}

			$this->renderPartial('grid_buscar_recaudo',array(
				'model'=>$model,
			));
		}
		else
		{
			$this->render('create',array(
				'model'=>$model,
				'idProceso'=>$idProceso,
				'codigoProceso'=>$proc->codigo_proceso,
			));
		}
	}*/

	function actionAgregarRecaudo()
	{
		$accion=$_POST['accion'];
		$id=$_POST['id'];
		$idProc=$_POST['idProc'];
		$nombre=$_POST['nombre'];
		//$obligatorio=$_POST['obligatorio'];

		if($accion==1)
		{
			$result = array('success' => false, 'message' => 'No se pudo agregar el recaudo.');

			$erroresIngreso="";
			
			if($nombre=="") 
			{
				$erroresIngreso.="<li>Nombre Recaudo no puede ser nulo.</li>";
			}
			else
			{
				//validar restricciones
			}
			
			if($erroresIngreso=="")
			{
				$transaction=Yii::app()->db->beginTransaction();
				$commandPR = new ProcesoRecaudo();

				if($id=="" && $nombre!="")
				{
					if( ! Recaudo::model()->find("LOWER(nombre_recaudo)='".strtolower($nombre)."'") )
					{
						$command = new Recaudo();
						$command->nombre_recaudo = $nombre;

						if($command->save())
						{
							$commandPR->id_recaudo=$command->id_recaudo;
						}
					}
					/*else
					{
						$result = array('success' => false, 'message' => '<p>Dato adicional ya registrado.</p>');
					}*/
				}
				else
				{
					$commandPR->id_recaudo=$id;
				}

				if( ! ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$idProc, 'id_recaudo'=>$commandPR->id_recaudo)) )
				{
					$commandPR->id_proceso = $idProc;
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
				}

			}
			else
			{
				$result = array('success' => false, 'message' => '<p>No se pudo agregar el recaudo.</p><ul>'.$erroresIngreso.'</ul>');
			}
		}
		else
		{
			$result = array('success' => false, 'message' => 'No se pudo actualizar el recaudo.');

			$commandPR = ProcesoRecaudo::model()->findByAttributes(array('id_proceso'=>$idProc, 'id_recaudo'=>$id));
			//$commandPR->obligatorio = $obligatorio;
			
			if($commandPR->save())
			{
				$result = array('success' => true, 'message' => '<p>Recaudo actualizado satisfactoriamente.</p>');
			}

		}

		echo CJSON::encode($result);
	}

	public function actionObtenerDatos($id){

		$model = $this->loadModel($id);
		
		//if($model){

		$result = array('success' => true, 'nombre' => $model->nombreRecaudo, 'id' => $model->id_recaudo, /*'obligatorio'=>$model->obligatorio,*/ 'title'=>'Modificar');
		//}		

		echo CJSON::encode($result);
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProcesoRecaudo']))
		{
			$model->attributes=$_POST['ProcesoRecaudo'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success", "Recaudo actualizado satisfactoriamente.");
				$this->redirect(array('proceso/view/'.$model->id_proceso));
				//$this->redirect(array('view','id'=>$model->id_proceso_recaudo));
			}
		}

		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$model->id_proceso);

		$this->render('update',array(
			'model'=>$model,
			'idProceso'=>$model->id_proceso,
			'codigoProceso'=>$proc->codigo_proceso,
			'nombreProceso'=>$proc->nombre_proceso,
		));
	}*/


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $idProc)
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
		  		$this->redirect(array('proceso/view', "id"=>$idProc));
		  	}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Yii::app()->user->setFlash("success", "Recaudo eliminado satisfactoriamente.");
			$this->redirect(array('proceso/view', "id"=>$idProc));
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
			

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if(!isset($_GET['ajax']))
			//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
		$dataProvider=new CActiveDataProvider('ProcesoRecaudo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	public function actionAdmin($idProceso)
	{
		$model=new ProcesoRecaudo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProcesoRecaudo']))
			$model->attributes=$_GET['ProcesoRecaudo'];

		$procesoModel = Proceso::model(); 
		$proc = $procesoModel->find("id_proceso = ".$idProceso);

		if(isset($_POST['ProcesoRecaudo']))
		{
			$model->attributes=$_POST['ProcesoRecaudo'];
			
			if(($model->id_recaudo=="" || $model->id_recaudo==null) && $model->nombreRecaudo!="")
			{
				$command = new Recaudo();
				$command->nombre_recaudo = $model->nombreRecaudo;

				if($command->save())
				{
					$model->id_recaudo=$command->id_recaudo;
				}
			}

			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Recaudo agregado satisfactoriamente.');
				$this->redirect(array('admin','idProceso'=>$idProceso));
			}
		}

		if(isset($_GET['Recaudo'])){
			
			$model=new Recaudo('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['Recaudo'])){
				$model->attributes=$_GET['Recaudo'];
			}

			$this->renderPartial('grid_buscar_recaudo',array(
				'model'=>$model,
			));
		}
		else
		{
			$this->render('admin',array(
				'model'=>$model,
				'idProceso'=>$idProceso,
				'codigoProceso'=>$proc->codigo_proceso,
			));
		}
	}

	public function actionBuscarRecaudoPorID($ID){

		$result = array('success' => false, 'message' => 'No se agregó ningún recaudo.');			

		$model = Recaudo::model()->findByAttributes( array('id_recaudo' => $ID) );
		
		if($model){

			$result = array('success' => true, 'nombre' => $model->nombre_recaudo, 'id' => $model->id_recaudo, 'message' => 'Recaudo seleccionado satistactoriamente.');
		}		

		echo CJSON::encode($result);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ProcesoRecaudo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='proceso-recaudo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
