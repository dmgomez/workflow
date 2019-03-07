<?php

class EmpresaController extends Controller
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
				'actions'=>array('create','update', 'admin', 'delete', 'BuscarPersonaPorCedula', 'DeleteGrid', 'ValidarRif'),
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
		$model=new Empresa;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empresa']))
		{
			$model->attributes=$_POST['Empresa'];
			

			if($model->rif_empresa=="")
				$model->addError('rif_empresa','Rif no puede ser nulo.'); 
			else
			{ 
				if( !preg_match('/^[0-9]{9}$/', $model->rif_empresa))
					$model->addError('rif_empresa','Rif no válido. Debe tener una longitud de 9 caracteres numéricos.');

				$buscar =  Empresa::model()->findByAttributes( array('prefijo_rif'=>$model->prefijo_rif, 'rif_empresa'=>$model->rif_empresa) );
				if($buscar && $buscar->id_empresa!=$model->id_empresa)
					$model->addError('rif_empresa','El número de rif que ingresó ya se encuentra registrado.');
			}

			if($model->razon_social_empresa=="")
				$model->addError('razon_social_empresa','Razón Social no puede ser nulo.'); 
			else
			{
				if(!preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/´&,.:-\s]+$/', $model->razon_social_empresa))
					$model->addError('razon_social_empresa','Razón Social inválida. Sólo se permiten los siguientes caracteres espciales: ´ / & , . - :.');
			}

			if($model->nombre_comercial_empresa=="")
			$model->addError('nombre_comercial_empresa','Nombre Comercial no puede ser nulo.'); 
			else
			{
				if(!preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/´&,.:-\s]+$/', $model->nombre_comercial_empresa))
					$model->addError('nombre_comercial_empresa','Nombre Comercial inválido. Sólo se permiten los siguientes caracteres espciales: ´ / & , . - :.');
			}

			if(!preg_match('/(^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:-\s]*$)/', $model->direccion_empresa))
				$model->addError('direccion_empresa','Dirección Empresa inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :');

			if($model->telefono_hab_persona=="")
				$model->addError('telefono_hab_persona','Teléfono Oficina no puede ser nulo.');

			if( !preg_match('/(^[0-9]*$)/', $model->telefono_hab_persona)) 
				$model->addError('telefono_hab_persona','Teléfono Oficina debe ser de 11 caracteres numéricos.');

			if( !preg_match('/(^[0-9]*$)/', $model->telefono_aux_empresa)) 
				$model->addError('telefono_aux_empresa','Teléfono Auxiliar debe ser de 11 caracteres numéricos.');

			if($model->correo_empresa=="")
				$model->addError('correo_empresa','Correo Empresa no puede ser nulo.');
			elseif(!preg_match('/^[a-zA-Z0-9ñÑ_.@-]+$/', $model->correo_empresa))
				$model->addError('correo_empresa','Correo Empresa inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @');

			//if($model->cedulaPersona!="" || $model->nombrePersona!="" || $model->apellidoPersona!="" || $model->direccionPersona!="" || $model->telefonoHab!="" || $model->telefonoCel!="" || $model->telefonoAux!="" || $model->correoPersona!="") 
			//{
				if($model->cedulaPersona=="") 
					$model->addError('cedulaPersona','Cédula Representante no puede ser nulo.');
				else
				{
					if($model->nacionalidadPersona == "V")
					{
						if( !preg_match('/^[0-9]{6,8}$/', $model->cedulaPersona))
							$model->addError('cedulaPersona','Cédula Representante no válida. Mínimo 6 y máximo 8 caracteres numéricos para cédulas venezolanas.');
					}			
					elseif($model->nacionalidadPersona == "E")
					{	
						if( !preg_match('/^[0-9]{6,15}$/', $model->cedulaPersona))
							$model->addError('cedulaPersona','Cédula Representante no válida. Mínimo 6 y máximo 15 caracteres numéricos para cédulas extranjeras.');
					}
				}

				if($model->nombrePersona=="") 
					$model->addError('nombrePersona','Nombre Representante no puede ser nulo.');
				else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->nombrePersona))
					$model->addError('nombrePersona','Nombre Representante inválido. Sólo se permiten caracteres alfabétcos.');

				if($model->apellidoPersona=="") 
					$model->addError('apellidoPersona','Apellido Representante no puede ser nulo.');
				else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->apellidoPersona))
					$model->addError('apellidoPersona','Apellido Representante inválido. Sólo se permiten caracteres alfabétcos.');

				if(!preg_match('/(^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:-\s]*$)/', $model->direccionPersona))
					$model->addError('direccionPersona','Dirección Representante inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :');

				if( !preg_match('/(^[0-9]*$)/', $model->telefonoHab)) 
					$model->addError('telefonoHab','Teléfono Habitación Representante debe ser de 11 caracteres numéricos.');

				if($model->telefonoCel=="") 
					$model->addError('telefonoCel','Teléfono Celular no puede ser nulo.');
				elseif( !preg_match('/(^[0-9]*$)/', $model->telefonoCel)) 
					$model->addError('telefonoCel','Teléfono Celular Representante debe ser de 11 caracteres numéricos.');

				if( !preg_match('/(^[0-9]*$)/', $model->telefonoAux)) 
					$model->addError('telefonoAux','Teléfono Auxiliar Representante debe ser de 11 caracteres numéricos.');

				/*if($model->correoPersona=="") 
					$model->addError('correoPersona','Correo Representante no puede ser nulo.');
				if(!preg_match('/^[a-zA-Z0-9ñÑ_.@-]*$/', $model->correoPersona))
					$model->addError('correoPersona','Correo Representante inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @');*/

			//}

				//if( $model->cedulaPersona!="" )
				//{

					try
					{
						$command = new Persona();
						$command->nombre_persona = $model->nombrePersona;
						$command->apellido_persona = $model->apellidoPersona;
						$command->nacionalidad_persona = $model->nacionalidadPersona;
						$command->cedula_persona = $model->cedulaPersona;
						$command->direccion_persona = $model->direccionPersona;
						$command->telefono_hab_persona = $model->telefonoHab;
						$command->telefono_cel_persona = $model->telefonoCel;
						$command->telefono_aux_persona = $model->telefonoAux;
						$command->correo_persona = $model->correoPersona;

						if ($command->save()) 
						{
							$model->id_persona_representante=$command->id_persona;
						
							if($model->save())
							{
								Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
								$this->redirect(array('admin'));
							}
						}
					}
					catch (Exception $e)
					{
						if(strpos($e, 'Unique violation'))
					  	{
					  		$persona = Persona::model()->findByAttributes(array('cedula_persona'=>$model->cedulaPersona));
					  		
					  		$updateDatosPersonales = Persona::model()->updateByPk($persona->id_persona, array('nombre_persona' => $model->nombrePersona, 'apellido_persona' => $model->apellidoPersona, 'nacionalidad_persona' => $model->nacionalidadPersona, 'direccion_persona' => $model->direccionPersona, 'telefono_hab_persona' => $model->telefonoHab, 'telefono_cel_persona' => $model->telefonoCel, 'telefono_aux_persona' => $model->telefonoAux, 'correo_persona' => $model->correoPersona) );

							$model->id_persona_representante=$persona->id_persona;
							if($model->save())
							{
								Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
								$this->redirect(array('admin'));
							}	
					  	}
					}
				/*}
				else
				{
					if($model->save())
					{
						Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
						$this->redirect(array('admin'));
					}
				}*/


			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionValidarRif(){

		$result = array('success' => true);
		
		$rif = $_POST['rif'];
		$idEmp = $_POST['idEmp'];

		$model = Empresa::model()->findByAttributes( array('rif_empresa'=>$rif) );
		
		if($model && $model->id_empresa!=$idEmp)
		{

			$result = array('success' => false, 'message' => 'El número de rif que ingresó ya se encuentra registrado.');	
			
		}		

		echo CJSON::encode($result);
	}

	public function actionBuscarPersonaPorCedula(){

		$result = array('success' => false);
		
		$cedula = $_POST['cedula'];
		$nacionalidad = $_POST['nacionalidad'];

		$model = Persona::model()->findByAttributes( array('cedula_persona'=>$cedula, 'nacionalidad_persona'=>$nacionalidad) );
		
		if($model){

			$result = array('success' => true, 'nombre' => $model->nombre_persona, 'apellido' => $model->apellido_persona, 'id' => $model->id_persona, 'nacionalidad' => $model->nacionalidad_persona, 'direccon' => $model->direccion_persona, 'telefonoHab' => $model->telefono_hab_persona, 'telefonoCel' => $model->telefono_cel_persona, 'telefonoAux' => $model->telefono_aux_persona, 'correo' => $model->correo_persona);
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

		if(isset($_POST['Empresa']))
		{
			$model->attributes=$_POST['Empresa'];

			if($model->rif_empresa=="")
				$model->addError('rif_empresa','Rif no puede ser nulo.'); 
			else
			{ 
				if( !preg_match('/^[0-9]{9}$/', $model->rif_empresa))
					$model->addError('rif_empresa','Rif no válido. Debe tener una longitud de 9 caracteres numéricos.');

				$buscar =  Empresa::model()->findByAttributes( array('prefijo_rif'=>$model->prefijo_rif, 'rif_empresa'=>$model->rif_empresa) );
				if($buscar && $buscar->id_empresa!=$model->id_empresa)
					$model->addError('rif_empresa','El número de rif que ingresó ya se encuentra registrado.');
			}

			if($model->razon_social_empresa=="")
				$model->addError('razon_social_empresa','Razón Social no puede ser nulo.'); 
			else
			{
				if(!preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/´&,.:-\s]+$/', $model->razon_social_empresa))
					$model->addError('razon_social_empresa','Razón Social inválida. Sólo se permiten los siguientes caracteres espciales: ´ / & , . - :.');
			}

			if($model->nombre_comercial_empresa=="")
			$model->addError('nombre_comercial_empresa','Nombre Comercial no puede ser nulo.'); 
			else
			{
				if(!preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ\/´&,.:-\s]+$/', $model->nombre_comercial_empresa))
					$model->addError('nombre_comercial_empresa','Nombre Comercial inválido. Sólo se permiten los siguientes caracteres espciales: ´ / & , . - :.');
			}

			if(!preg_match('/(^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:-\s]*$)/', $model->direccion_empresa))
				$model->addError('direccion_empresa','Dirección Empresa inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :');

			if($model->telefono_hab_persona=="")
				$model->addError('telefono_hab_persona','Teléfono Oficina no puede ser nulo.');

			if( !preg_match('/(^[0-9]*$)/', $model->telefono_hab_persona)) 
				$model->addError('telefono_hab_persona','Teléfono Oficina debe ser de 11 caracteres numéricos.');

			if( !preg_match('/(^[0-9]*$)/', $model->telefono_aux_empresa)) 
				$model->addError('telefono_aux_empresa','Teléfono Auxiliar debe ser de 11 caracteres numéricos.');

			if($model->correo_empresa=="")
				$model->addError('correo_empresa','Correo Empresa no puede ser nulo.');
			elseif(!preg_match('/^[a-zA-Z0-9ñÑ_.@-]+$/', $model->correo_empresa))
				$model->addError('correo_empresa','Correo Empresa inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @');

			//if($model->cedulaPersona!="" || $model->nombrePersona!="" || $model->apellidoPersona!="" || $model->direccionPersona!="" || $model->telefonoHab!="" || $model->telefonoCel!="" || $model->telefonoAux!="" || $model->correoPersona!="") 
			//{
				if($model->cedulaPersona=="") 
					$model->addError('cedulaPersona','Cédula Representante no puede ser nulo.');
				else
				{
					if($model->nacionalidadPersona == "V")
					{
						if( !preg_match('/^[0-9]{6,8}$/', $model->cedulaPersona))
							$model->addError('cedulaPersona','Cédula Representante no válida. Mínimo 6 y máximo 8 caracteres numéricos para cédulas venezolanas.');
					}			
					elseif($model->nacionalidadPersona == "E")
					{	
						if( !preg_match('/^[0-9]{6,15}$/', $model->cedulaPersona))
							$model->addError('cedulaPersona','Cédula Representante no válida. Mínimo 6 y máximo 15 caracteres numéricos para cédulas extranjeras.');
					}
				}

				if($model->nombrePersona=="") 
					$model->addError('nombrePersona','Nombre Representante no puede ser nulo.');
				else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->nombrePersona))
					$model->addError('nombrePersona','Nombre Representante inválido. Sólo se permiten caracteres alfabétcos.');

				if($model->apellidoPersona=="") 
					$model->addError('apellidoPersona','Apellido Representante no puede ser nulo.');
				else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->apellidoPersona))
					$model->addError('apellidoPersona','Apellido Representante inválido. Sólo se permiten caracteres alfabétcos.');

				if(!preg_match('/(^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:-\s]*$)/', $model->direccionPersona))
					$model->addError('direccionPersona','Dirección Representante inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :');

				if( !preg_match('/(^[0-9]*$)/', $model->telefonoHab)) 
					$model->addError('telefonoHab','Teléfono Habitación Representante debe ser de 11 caracteres numéricos.');

				if($model->telefonoCel=="") 
					$model->addError('telefonoCel','Apellido Representante no puede ser nulo.');
				elseif( !preg_match('/(^[0-9]*$)/', $model->telefonoCel)) 
					$model->addError('telefonoCel','Teléfono Celular Representante debe ser de 11 caracteres numéricos.');

				if( !preg_match('/(^[0-9]*$)/', $model->telefonoAux)) 
					$model->addError('telefonoAux','Teléfono Auxiliar Representante debe ser de 11 caracteres numéricos.');

				if($model->correoPersona=="") 
					$model->addError('correoPersona','Correo Representante no puede ser nulo.');
				if(!preg_match('/^[a-zA-Z0-9ñÑ_.@-]*$/', $model->correoPersona))
					$model->addError('correoPersona','Correo Representante inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @');

			//}

			//if( $model->cedulaPersona!="" )
			//{
				try
				{
					$command = new Persona();
					$command->nombre_persona = $model->nombrePersona;
					$command->apellido_persona = $model->apellidoPersona;
					$command->nacionalidad_persona = $model->nacionalidadPersona;
					$command->cedula_persona = $model->cedulaPersona;
					$command->direccion_persona = $model->direccionPersona;
					$command->telefono_hab_persona = $model->telefonoHab;
					$command->telefono_cel_persona = $model->telefonoCel;
					$command->telefono_aux_persona = $model->telefonoAux;
					$command->correo_persona = $model->correoPersona;

					if ($command->save()) 
					{
						$model->id_persona_representante=$command->id_persona;
					
						if($model->save())
						{
							Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente.');
							$this->redirect(array('admin'));
						}
					}
				}
				catch (Exception $e)
				{
					if(strpos($e, 'Unique violation'))
				  	{
				  		$persona = Persona::model()->findByAttributes(array('cedula_persona'=>$model->cedulaPersona));
				  		
				  		$updateDatosPersonales = Persona::model()->updateByPk($persona->id_persona, array('nombre_persona' => $model->nombrePersona, 'apellido_persona' => $model->apellidoPersona, 'nacionalidad_persona' => $model->nacionalidadPersona, 'direccion_persona' => $model->direccionPersona, 'telefono_hab_persona' => $model->telefonoHab, 'telefono_cel_persona' => $model->telefonoCel, 'telefono_aux_persona' => $model->telefonoAux, 'correo_persona' => $model->correoPersona) );

						$model->id_persona_representante=$persona->id_persona;
						if($model->save())
						{
							Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente.');
							$this->redirect(array('admin'));
						}
							
				  	}
				}
			/*}
			else
			{
				if($model->save())
				{
					Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente.');
					$this->redirect(array('admin'));
				}
			}*/
		
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
		$dataProvider=new CActiveDataProvider('Empresa');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Empresa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empresa']))
			$model->attributes=$_GET['Empresa'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Empresa the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Empresa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Empresa $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='empresa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
