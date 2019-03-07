<?php

class EmpleadoController extends Controller
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
				'actions'=>array('create','update', 'admin', 'delete', 'BuscarPersonaPorCedula', 'BuscarEmpleadoPorCedula', 'DeleteGrid'),
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
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Empleado;

		$empleadosE=Empleado::model()->findAll();
		$supervisor[]="";
		$idUsuariosAsig="";
		if ($empleadosE) 
		{
			foreach ($empleadosE as $key => $value) 
			{
				$nombre=Persona::model()->findByPk($value['id_persona']);
				$cargo=Cargo::model()->findByPk($value['id_cargo']);
				$supervisor[$key]=array('id'=>$value['id_empleado'],'nombre'=>$nombre->nombre_persona.' '.$nombre->apellido_persona.' - '.$cargo->nombre_cargo);
				if($value['id_usuario']!=null && $value['id_usuario']!="")
				{
					$idUsuariosAsig.=$value['id_usuario'].',';
				}
			}
		}

		if ($idUsuariosAsig!="") 
			$idUsuariosAsig=substr($idUsuariosAsig, 0, -1);
		else
			$idUsuariosAsig=0;

		$idOrganizacion = Organizacion::model()->find(array('order' => 'nombre_organizacion'));
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empleado']))
		{
			$model->attributes=$_POST['Empleado'];

			if($model->cedulaPersona=="") 
				$model->addError('cedulaPersona','Cédula no puede ser nulo.');
			else
			{
				if($model->nacionalidadPersona == "V")
				{
					if( !preg_match('/^[0-9]{6,8}$/', $model->cedulaPersona))
						$model->addError('cedulaPersona','Cédula no válida. Mínimo 6 y máximo 8 caracteres numéricos para cédulas venezolanas.');
				}			
				elseif($model->nacionalidadPersona == "E")
				{	
					if( !preg_match('/^[0-9]{6,15}$/', $model->cedulaPersona))
						$model->addError('cedulaPersona','Cédula no válida. Mínimo 6 y máximo 15 caracteres numéricos para cédulas extranjeras.');
				}
			}

			if($model->nombrePersona=="") 
				$model->addError('nombrePersona','Nombre no puede ser nulo.');
		
			else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->nombrePersona))
				$model->addError('nombrePersona','Nombre inválido. Sólo se permiten caracteres alfabéticos.');

			if($model->apellidoPersona=="") 
				$model->addError('apellidoPersona','Apellido no puede ser nulo.');
			else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->apellidoPersona))
				$model->addError('apellidoPersona','Apellido inválido. Sólo se permiten caracteres alfabétcos.');

			if(!preg_match('/(^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\- \s]+$)|(^$)/', $model->direccionPersona))
				$model->addError('direccionPersona','Dirección inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :');

			if($model->telefonoCel=="")
				$model->addError('telefonoCel','Teléfono Celular no puede ser nulo.');

			if( !preg_match('/(^[0-9]{11}$)|(^$)/', $model->telefonoHab)) 
				$model->addError('telefonoHab','Teléfono Habitación debe ser de 11 caracteres numéricos.');

			if( !preg_match('/(^[0-9]{11}$)|(^$)/', $model->telefonoCel)) 
				$model->addError('telefonoCel','Teléfono Celular debe ser de 11 caracteres numéricos.');

			if( !preg_match('/(^[0-9]{11}$)|(^$)/', $model->telefonoAux)) 
				$model->addError('telefonoAux','Teléfono Auxiliar debe ser de 11 caracteres numéricos.');

			/*if($model->correoPersona=="")
				$model->addError('correoPersona','Correo no puede ser nulo.');
			else*/if( !preg_match('/(^[a-zA-Z0-9ñÑ_.@-]+$)|(^$)/', $model->correoPersona)) 
				$model->addError('correoPersona','Correo inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @');

			if($model->id_departamento=="") 
				$model->addError('id_departamento','Departamento no puede ser nulo.');

			if($model->id_cargo=="") 
				$model->addError('id_cargo','Cargo no puede ser nulo.');

			if($model->username=="")
				$model->addError('username','Nombre de Usuario no puede ser nulo.');
			else if(!preg_match('/^[a-zA-Z0-9\_\-\.]{3,45}$/', $model->username))
				$model->addError('username','Nombre de Usuario inválido. Mínimo 3 y máximo 45 caracteres alfabéticos, numéricos y/o especiales: _ . -.');
			
			if($model->password=="")
				$model->addError('password','Clave de Acceso no puede ser nulo.');
			else if(!preg_match('/^[a-zA-Z0-9@#$%\_\-\.]{6,20}$/', $model->password))
				$model->addError('password','Clave de Acceso inválida. Mínimo 6 y máximo 20caracteres alfabéticos, numéricos y/o especiales: @ # $ %.');
						
			try
			{
				$transaction=Yii::app()->db->beginTransaction();

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
					$model->id_persona=$command->id_persona;

					$usuario=Cruge_User::model()->findByAttributes(array('username'=>$model->username));

					if($usuario)
					{
						$transaction->rollback();

						$model->addError('username','El Nombre de Usuario que ingresó ya se encuentra registrado.');
					}
					else
					{
						$commandCruge = new Cruge_User();
						$commandCruge->username = $model->username;
						$commandCruge->password = $model->password;
						$commandCruge->state = 1;

						if($commandCruge->save())
						{
							$model->id_usuario=$commandCruge->iduser;

							$sqlOperador = "SELECT valor FROM configuracion WHERE variable = 'cruge_itemname_operador'";
							$operador = Yii::app()->db->createCommand($sqlOperador)->queryRow();

							$sqlAuthassignment = "INSERT INTO cruge_authassignment (userid, data, itemname) VALUES ('".$model->id_usuario."', 'N;', '".$operador['valor']."')";

							if(Yii::app()->db->createCommand($sqlAuthassignment)->execute())
							{
								if($model->save())
								{
									$transaction->commit();

									Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
									$this->redirect(array('admin'));
								}
								else
								{
									$transaction->rollback();
								}
							}
							else
							{
								$transaction->rollback();
							}

						}
						else
						{
							$transaction->rollback();
						}
					}
					
				}
				else
				{
					$transaction->rollback();
				}
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				
				if(strpos($e, 'Unique violation'))
			  	{
			  		$transaction=Yii::app()->db->beginTransaction();

			  		$persona = Persona::model()->findByAttributes(array('cedula_persona'=>$model->cedulaPersona));

			  		$empleado = Empleado::model()->findByAttributes(array('id_persona'=>$persona['id_persona']));

			  		if ($empleado) 
			  		{
			  			$transaction->rollback();

			  			$model->addError('cedulaPersona','El número de cédula que ingresó ya se encuentra registrado.');
			  		}
			  		else
			  		{
			  			
						$updateDatosPersonales = Persona::model()->updateByPk($persona->id_persona, array('nombre_persona' => $model->nombrePersona, 'apellido_persona' => $model->apellidoPersona, 'nacionalidad_persona' => $model->nacionalidadPersona, 'direccion_persona' => $model->direccionPersona, 'telefono_hab_persona' => $model->telefonoHab, 'telefono_cel_persona' => $model->telefonoCel, 'telefono_aux_persona' => $model->telefonoAux, 'correo_persona' => $model->correoPersona) );

						$model->id_persona=$persona->id_persona;


						$usuario = Cruge_User::model()->findByAttributes(array('username'=>$model->username));

						if($usuario)
						{
							$transaction->rollback();

							$model->addError('username','El Nombre de Usuario que ingresó ya se encuentra registrado.');
						}
						else
						{
							$commandCruge = new Cruge_User();
							$commandCruge->username = $model->username;
							$commandCruge->password = $model->password;
							$commandCruge->state = 1;

							if($commandCruge->save())
							{
								$model->id_usuario=$commandCruge->iduser;

								$sqlOperador = "SELECT valor FROM configuracion WHERE variable = 'cruge_itemname_operador'";
								$operador = Yii::app()->db->createCommand($sqlOperador)->queryRow();

								$sqlAuthassignment = "INSERT INTO cruge_authassignment (userid, data, itemname) VALUES ('".$model->id_usuario."', 'N;', '".$operador['valor']."')";

								if(Yii::app()->db->createCommand($sqlAuthassignment)->execute())
								{
									if($model->save())
									{
										$transaction->commit();

										Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
										$this->redirect(array('admin'));
									}
									else
									{
										$transaction->rollback();
									}
								}
								else
								{
									$transaction->rollback();
								}

							}
							else
							{
								$transaction->rollback();
							}
						}
					
			  		}
			  	}
			}
			
		}

		$this->render('create',array(
			'model'=>$model,
			'supervisor'=>$supervisor,
			'idOrganizacion'=>$idOrganizacion->id_organizacion
		));
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

	public function actionBuscarEmpleadoPorCedula(){

		$result = array('success' => true);
		
		$cedula = $_POST['cedula'];

		$idEmpleado=-1;
		if(isset($_POST['empleado']))
			$idEmpleado = $_POST['empleado'];
		
		$model = Persona::model()->findByAttributes( array('cedula_persona'=>$cedula) );
		
		if($model)
		{

			$empleado = Empleado::model()->findByAttributes(array('id_persona'=>$model->id_persona));

			if($empleado && $empleado->id_empleado!=$idEmpleado) 
			{
				$result = array('success' => false, 'message' => 'El número de cédula que ingresó ya se encuentra registrado como empleado');	
			}

			
		}		

		echo CJSON::encode($result);
	}

	public function actionRevisarAsignacion()
	{
		$result = array('success' => false);

		$empleado = $_POST['empleado'];

		$asignacion = InstanciaActividad::model()->findByAttributes(array("ejecutada" => "0", "id_empleado" => $empleado));

		if($asignacion)
		{
			$result = array('success' => true);
		}

		echo CJSON::encode($result);
	}

	public function actionBuscarEmpleadoPorRol()
	{
		$result = array('success' => false, "message"=>"No se encontraron empleados con los mismos roles.");

		$empleado = $_POST['empleado'];

		$rolEmpleado = EmpleadoRol::model()->find(array("select"=>"array_to_string(array_agg(id_rol), ',') as id_rol", "condition"=>"id_empleado = ".$empleado));

		if($rolEmpleado && $rolEmpleado->id_rol != "")
		{
			$empleadoRol = EmpleadoRol::model()->find(array("select"=>"array_to_string(array_agg(id_empleado), ',') as id_empleado", "condition"=>"id_rol IN(".$rolEmpleado->id_rol.") AND id_empleado <> ".$empleado));
		
			if($empleadoRol && $empleadoRol->id_empleado!="")
			{
				$modelEmpleado = Empleado::model()->findAll(array("condition"=>"id_empleado IN(".$empleadoRol->id_empleado.") AND activo = 1"));

				if($modelEmpleado)
				{
					$empleadoM = Empleado::model();

					$result=array(
						'success' => true, 
						'dropDownEmpleado' => CHtml::activeDropDownList($empleadoM, '_empleadoAccion', 
									CHtml::listData($modelEmpleado, 'id_empleado', 'nombreEmpleado'), array('onChange'=>'actualizarEmpleado()', 'prompt'=>'--Seleccione--')) );
		
				}
			}

		}
		
		echo CJSON::encode($result);

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$empleadosE=Empleado::model()->findAll(array('condition' => 'id_empleado <> '.$id));
		$supervisor[]="";
		$idUsuariosAsig="";
		if ($empleadosE) 
		{
			foreach ($empleadosE as $key => $value) 
			{
				$nombre=Persona::model()->findByPk($value['id_persona']);
				$cargo=Cargo::model()->findByPk($value['id_cargo']);
				$supervisor[$key]=array('id'=>$value['id_empleado'],'nombre'=>$nombre->nombre_persona.' '.$nombre->apellido_persona.' - '.$cargo->nombre_cargo);
				if($value['id_usuario']!=null && $value['id_usuario']!="")
				{
					$idUsuariosAsig.=$value['id_usuario'].',';
				}
			}
		}

		if ($idUsuariosAsig!="") 
			$idUsuariosAsig=substr($idUsuariosAsig, 0, -1);
		else
			$idUsuariosAsig=0;

		$sqlUser="SELECT * from cruge_user  where iduser NOT IN($idUsuariosAsig)";
		$usuariosDisp = Yii::app()->db->createCommand($sqlUser)->queryAll();

		$usuarios[]="";
		if ($usuariosDisp) 
		{
			foreach ($usuariosDisp as $key => $value) 
			{
				$usuarios[$key]=array('id'=>$value['iduser'],'nombre'=>$value['username']);
			}
		}

		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Empleado']))
		{
			$model->attributes=$_POST['Empleado'];

			if($model->cedulaPersona=="") 
				$model->addError('cedulaPersona','Cédula no puede ser nulo.');
			else
			{
				if($model->nacionalidadPersona == "V")
				{
					if( !preg_match('/^[0-9]{6,8}$/', $model->cedulaPersona))
						$model->addError('cedulaPersona','Cédula no válida. Mínimo 6 y máximo 8 caracteres numéricos para cédulas venezolanas.');
				}			
				elseif($model->nacionalidadPersona == "E")
				{	
					if( !preg_match('/^[0-9]{6,15}$/', $model->cedulaPersona))
						$model->addError('cedulaPersona','Cédula no válida. Mínimo 6 y máximo 15 caracteres numéricos para cédulas extranjeras.');
				}
			}

			if($model->nombrePersona=="") 
				$model->addError('nombrePersona','Nombre no puede ser nulo.');
		
			else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->nombrePersona))
				$model->addError('nombrePersona','Nombre inválido. Sólo se permiten caracteres alfabéticos.');

			if($model->apellidoPersona=="") 
				$model->addError('apellidoPersona','Apellido no puede ser nulo.');
			else if(!preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/', $model->apellidoPersona))
				$model->addError('apellidoPersona','Apellido inválido. Sólo se permiten caracteres alfabétcos.');

			if(!preg_match('/(^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:\-\s]+$)|(^$)/', $model->direccionPersona))
				$model->addError('direccionPersona','Dirección inválida. Sólo se permiten los siguientes caracteres espciales: # , . - º :');

			if($model->telefonoCel=="")
				$model->addError('telefonoCel','Teléfono Celular no puede ser nulo.');

			if( !preg_match('/(^[0-9]{11}$)|(^$)/', $model->telefonoHab)) 
				$model->addError('telefonoHab','Teléfono Habitación debe ser de 11 caracteres numéricos.');

			if( !preg_match('/(^[0-9]{11}$)|(^$)/', $model->telefonoCel)) 
				$model->addError('telefonoCel','Teléfono Celular debe ser de 11 caracteres numéricos.');

			if( !preg_match('/(^[0-9]{11}$)|(^$)/', $model->telefonoAux)) 
				$model->addError('telefonoAux','Teléfono Auxiliar debe ser de 11 caracteres numéricos.');

			/*if($model->correoPersona=="")
				$model->addError('correoPersona','Correo no puede ser nulo.');
			else*/if( !preg_match('/(^[a-zA-Z0-9ñÑ_.@-]+$)|(^$)/', $model->correoPersona)) 
				$model->addError('correoPersona','Correo inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @');

			if($model->id_departamento=="") 
				$model->addError('id_departamento','Departamento no puede ser nulo.');

			if($model->id_cargo=="") 
				$model->addError('id_cargo','Cargo no puede ser nulo.');


			if($model->username=="")
				$model->addError('username','Nombre de Usuario no puede ser nulo.');
			else if(!preg_match('/^[a-zA-Z0-9\_\-\.]{3,45}$/', $model->username))
				$model->addError('username','Nombre de Usuario inválido. Mínimo 3 y máximo 45 caracteres alfabéticos, numéricos y/o especiales: _ . -.');
			
			if($model->password=="")
				$model->addError('password','Clave de Acceso no puede ser nulo.');
			else if(!preg_match('/^[a-zA-Z0-9@#$%\_\-\.]{6,20}$/', $model->password))
				$model->addError('password','Clave de Acceso inválida. Mínimo 6 y máximo 20caracteres alfabéticos, numéricos y/o especiales: @ # $ %.');

			$cruge_state=1;
			if($model->activo == 0)
			{
				$cruge_state = 2;
				$asignacion = InstanciaActividad::model()->findByAttributes(array("ejecutada" => "0", "id_empleado" => $model->id_empleado));

				if($asignacion)
				{
					if($model->_activoAccion == -1)
					{				
						$model->addError('_activoAccion','Debe seleccionar una opcion de reasignacion al desactivar el empleado.');
					}
					else if($model->_activoAccion == 2 && ($model->_empleadoAccion == "" || $model->_empleadoAccion == null))
					{
						$model->addError('_empleadoAccion','Debe seleccionar un empleado para la reasignacion de actividades.');	
					}
				}
			}

			if(!$model->getErrors())
			{
				try
				{
					$transaction=Yii::app()->db->beginTransaction();

					$actividad_sin_asignar = false;

					switch ($model->_activoAccion) {
						case 1:
							$idEmpleado="";

							$asignacion = InstanciaActividad::model()->findAllByAttributes(array("ejecutada" => "0", "id_empleado" => $model->id_empleado));

							foreach ($asignacion as $key => $value) 
							{
								$rolAct = ActividadRol::model()->find(array("select"=>"array_to_string(array_agg(id_rol), ',') as id_rol", "condition"=>"id_actividad =".$value['id_actividad']));

								if($rolAct && $rolAct->id_rol != "")
								{
									$empleadoRol = EmpleadoRol::model()->find(array("select"=>"array_to_string(array_agg(id_empleado), ',') as id_empleado", "condition"=>'id_rol in('.$rolAct->id_rol.') AND id_empleado <> '.$model->id_empleado));

									if($empleadoRol && $empleadoRol->id_empleado!="") 
									{
										$empleadoActivo = Empleado::model()->findAll(array('condition'=>'id_empleado in('.$empleadoRol->id_empleado.') AND activo = 1'));

										if($empleadoActivo)
										{
											$cargaEmpleado=-1;
											foreach ($empleadoActivo as $value2) 
											{
												$result = InstanciaActividad::model()->findAllByAttributes(array("ejecutada" => "0", "id_empleado" => $value2['id_empleado']/*, "empleado_activo" => 1*/));
												
												if ($result) 
												{
													$count=count($result);
												}
												else
												{
													$count=0;
												}

												$usuario = Empleado::model()->findByPk($value2['id_empleado']);

												if($usuario && $usuario->activo == 1)
												{
													$queryUsuarioActivo="SELECT state from cruge_user where iduser = ".$usuario->id_usuario;
													$usuarioActivo = Yii::app()->db->createCommand($queryUsuarioActivo)->queryRow();

													if(($cargaEmpleado>$count || $cargaEmpleado==-1) && ($usuarioActivo && $usuarioActivo['state']==1))
													{
														$cargaEmpleado=$count;
														$idEmpleado=$value2['id_empleado'];
													}
												}
											}
										}
									}

									if($idEmpleado=="")
									{
										$actividad_sin_asignar = true;
										InstanciaActividad::model()->updateAll(array('id_empleado'=>null, 'pendiente_asignacion'=>$actividad_sin_asignar), 'id_instancia_actividad ='.$value['id_instancia_actividad']);
									}
									else
									{
										InstanciaActividad::model()->updateAll(array('id_empleado'=>$idEmpleado), 'id_instancia_actividad ='.$value['id_instancia_actividad']);	
									}

								}

							}
								
							break;

						case 2:
							$idEmpleado = $model->_empleadoAccion;
							InstanciaActividad::model()->updateAll(array('id_empleado'=>$idEmpleado), 'ejecutada = 0 AND id_empleado ='.$model->id_empleado);
							break;

						case 3:
							$idEmpleado = null;
							InstanciaActividad::model()->updateAll(array('id_empleado'=>$idEmpleado, 'pendiente_asignacion'=>true), 'ejecutada = 0 AND id_empleado ='.$model->id_empleado);
							break;
						
						default:
							# code...
							break;
					}

					$command = Persona::model()->findByPk($model->id_persona);
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
						$model->id_persona=$command->id_persona;
					
						$usuario=Cruge_User::model()->findByAttributes(array('username'=>$model->username));

						if($usuario && $usuario->iduser!=$model->id_usuario)
						{
							$transaction->rollback();

							$model->addError('username','El Nombre de Usuario que ingresó ya se encuentra registrado.');
						}
						else
						{
							if(isset($model->id_usuario) && $model->id_usuario!="")
							{
								$commandCruge = Cruge_User::model()->findByAttributes(array('iduser'=>$model->id_usuario));
								$commandCruge->username = $model->username;
								$commandCruge->password = $model->password;
								$commandCruge->state = $cruge_state;

								if($commandCruge->save())
								{
									if($model->save())
									{
										$transaction->commit();

										//Yii::app()->user->setFlash('success', 'Registro creado satisfactoriamente.');
										if($actividad_sin_asignar)
										{
											Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente. Algunas actividades no se pudieron reasignar por falta de empleados disponible. Revise el módulo de reasignación.');
										}
										else
										{
											Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente.');
										}
										$this->redirect(array('admin'));
									}
									else
									{
										$transaction->rollback();
									}
									
								}
								else
								{
									$transaction->rollback();
								}
							}
							else
							{
								$commandCruge = new Cruge_User();
								$commandCruge->username = $model->username;
								$commandCruge->password = $model->password;
								$commandCruge->state = $cruge_state;

								if($commandCruge->save())
								{
									$model->id_usuario=$commandCruge->iduser;

									$sqlOperador = "SELECT valor FROM configuracion WHERE variable = 'cruge_itemname_operador'";
									$operador = Yii::app()->db->createCommand($sqlOperador)->queryRow();

									$sqlAuthassignment = "INSERT INTO cruge_authassignment (userid, data, itemname) VALUES ('".$model->id_usuario."', 'N;', '".$operador['valor']."')";

									if(Yii::app()->db->createCommand($sqlAuthassignment)->execute())
									{
										if($model->save())
										{
											$transaction->commit();

											
											if($actividad_sin_asignar)
											{
												Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente. Algunas actividades no se pudieron reasignar por falta de empleados disponible. Revise el módulo de reasignación.');
											}
											else
											{
												Yii::app()->user->setFlash('success', 'Registro actualizado satisfactoriamente.');
											}

											$this->redirect(array('admin'));
										}
										else
										{
											$transaction->rollback();
										}
									}
									else
									{
										$transaction->rollback();
									}

								}
								else
								{
									$transaction->rollback();
								}
							}
						}
						
					}
					else
					{
						$transaction->rollback();
					}
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					if(strpos($e, 'Unique violation'))
				  	{
				  		$model->addError('cedulaPersona','>El número de cédula que ingresó ya se encuentra registrado.');
				  	}
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'supervisor'=>$supervisor,
			'usuarios'=>$usuarios,
			'idOrganizacion'=>$model->idOrganizacion,
		));
	}

	public function actionGetDatosOrganizacion() 
	{
		$result = array('success' => false);

		$organizacion = $_POST['organizacion'];
		
		if($organizacion!="")
		{
			$departamentoOrg = Departamento::model()->findAllByAttributes(array('id_organizacion'=>$organizacion));
			$cargoOrg = Cargo::model()->findAllByAttributes(array('id_organizacion'=>$organizacion));

			$querySuperiorInmediato = "SELECT e.id_empleado, concat(p.nombre_persona,' ', p.apellido_persona, ' - ', c.nombre_cargo) as nombre_persona
							FROM persona AS p
								JOIN empleado AS e ON p.id_persona = e.id_persona
								JOIN cargo AS c ON e.id_cargo = c.id_cargo
								JOIN organizacion AS o ON c.id_organizacion = o.id_organizacion AND o.id_organizacion = :organizacionID
							ORDER BY p.nombre_persona ASC";

			$superiorOrg = Yii::app()->db->createCommand($querySuperiorInmediato)
					->bindValues(array(':organizacionID'=>$organizacion))
					->queryAll();

			$model = new Empleado();
			
			$result = array(
				'success' => true,
				'departamento' => CHtml::activeDropDownList($model, 'id_departamento',
						CHtml::listData($departamentoOrg, 'id_departamento', 'nombre_departamento'), 
						array('prompt' => 'Seleccione', 
							'class' => (isset($_POST['class'])? $_POST['class'] : 'span4'), 
							'id' => (isset($_POST['departamentoId'])? $_POST['departamentoId']: 'Empleado_id_departamento'), 
							'name' => (isset($_POST['departamentoName'])? $_POST['departamentoName']: 'Empleado[id_departamento]'))
				),
				'cargo' => CHtml::activeDropDownList($model, 'id_cargo',
						CHtml::listData($cargoOrg, 'id_cargo', 'nombre_cargo'), 
						array('prompt' => 'Seleccione', 
							'class' => (isset($_POST['class'])? $_POST['class'] : 'span4'), 
							'id' => (isset($_POST['cargoId'])? $_POST['cargoId']: 'Empleado_id_cargo'), 
							'name' => (isset($_POST['cargoName'])? $_POST['cargoName']: 'Empleado[id_cargo]'))
				),
				'superior' => CHtml::activeDropDownList($model, 'superior_inmediato',
						CHtml::listData($superiorOrg, 'id_empleado', 'nombre_persona'), 
						array('prompt' => 'Seleccione', 
							'class' => (isset($_POST['class'])? $_POST['class'] : 'span4'), 
							'id' => 'Empleado_superior_inmediato', 
							'name' => 'Empleado[superior_inmediato]')
				)

			);	
		}
		
		echo CJSON::encode($result);
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
			$empleado = Empleado::model()->findByPk($id);

//			$ejecuto_actividad = InstanciaActividad::model()->findByAttributes(array('idid_departamento'=>$id));
			$ejecuto_actividad = InstanciaActividad::model()->findByAttributes(array('id_empleado'=>$id));

			if(!$ejecuto_actividad)
			{
			
				try 
				{
					// we only allow deletion via POST request
					Yii::app()->db->createCommand("DELETE FROM empleado_rol WHERE id_empleado = ".$id)->execute();

					$this->loadModel($id)->delete();

					Yii::app()->db->createCommand("DELETE FROM cruge_authassignment WHERE userid = ".$empleado->id_usuario)->execute();
	        	
					Yii::app()->db->createCommand("DELETE FROM cruge_fieldvalue WHERE iduser = ".$empleado->id_usuario)->execute();

					Yii::app()->db->createCommand("DELETE FROM cruge_session WHERE iduser = ".$empleado->id_usuario)->execute();

					Yii::app()->db->createCommand("DELETE FROM cruge_user WHERE iduser = ".$empleado->id_usuario)->execute();
				
				} 
				catch (Exception $e) 
				{

					if(strpos($e, 'Foreign key violation'))
				  	{
				  		Yii::app()->user->setFlash("error", "No se puede eliminar. El registro está siendo utilizado.");
				  		$this->redirect(array('admin'));
				  	}
				}

			}
			else
			{
				Yii::app()->user->setFlash("error", "No se puede eliminar. El registro está siendo utilizado.");
				$this->redirect(array('admin'));
			}
			

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			{
				Yii::app()->user->setFlash("success", "Registro eliminado satisfactoriamente.");
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteGrid($id)
	{
		$result = array('success' => false);

		if(Yii::app()->request->isPostRequest)
		{
			$empleado = Empleado::model()->findByPk($id);

			$ejecuto_actividad = InstanciaActividad::model()->findByAttributes(array('id_empleado'=>$id));

			if(!$ejecuto_actividad)
			{
			
				try 
				{
					// we only allow deletion via POST request
					Yii::app()->db->createCommand("DELETE FROM empleado_rol WHERE id_empleado = ".$id)->execute();
					
					$this->loadModel($id)->delete();

					Yii::app()->db->createCommand("DELETE FROM cruge_authassignment WHERE userid = ".$empleado->id_usuario)->execute();
	        	
					Yii::app()->db->createCommand("DELETE FROM cruge_fieldvalue WHERE iduser = ".$empleado->id_usuario)->execute();

					Yii::app()->db->createCommand("DELETE FROM cruge_session WHERE iduser = ".$empleado->id_usuario)->execute();

					Yii::app()->db->createCommand("DELETE FROM cruge_user WHERE iduser = ".$empleado->id_usuario)->execute();
					//$delete=Yii::app()->db->createCommand('select delete_user('.$empleado->id_usuario.')')->query();

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
			{
				$result = array('success' => false, 'message' => 'No se puede eliminar. El registro está siendo utilizado.');
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
		$dataProvider=new CActiveDataProvider('Empleado');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	public function actionIndex()
	{
		$model=new Empleado('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empleado']))
			$model->attributes=$_GET['Empleado'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VisEmpleado('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VisEmpleado']))
			$model->attributes=$_GET['VisEmpleado'];

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
		$model=Empleado::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='empleado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
