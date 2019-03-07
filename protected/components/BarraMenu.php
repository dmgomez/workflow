<?php

class BarraMenu
{

	private $_tipoUsuario;

	public function BarraMenu($id)
	{
		$this->_tipoUsuario = $id;
	}	

	public function get_tipoUsuario($value)
	{
		
		$this->_tipoUsuario = $valor;
	}

	public function set_tipoUsuario()
	{

		return $this->_tipoUsuario;
	}

	public function crearMenu()
	{					
		
		//DEVOLVIENDO EL MENU POR DEFECTO
		if (Yii::app()->user->isGuest)
		{
			$result = array(
				array(
					'class'=>'bootstrap.widgets.TbMenu',
					'items'=>array(
						array('template'=>'<img src="'.Yii::app()->request->baseUrl.'/images/logo_corto_2.png" style="margin-top:4px;">'),
						'---',
						array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon' => 'icon-home'),
						array('label'=>'Iniciar Sesión', 'icon' => 'icon-off', 'url'=>Yii::app()->user->ui->loginUrl, 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', 'icon' => 'icon-off', 'url'=>Yii::app()->user->ui->logoutUrl, 'visible'=>!Yii::app()->user->isGuest),

					),
				),
			);
		}
		elseif(Yii::app()->user->isSuperAdmin)
		{
			
			$result = array(
				array(
					'class'=>'bootstrap.widgets.TbMenu',
					'items'=>array(
						array('template'=>'<img src="'.Yii::app()->request->baseUrl.'/images/logo_corto_2.png" style="margin-top:4px;">'),
						'---',
						array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon' => 'icon-home'),
						array('label'=>'Mantenimiento', 'icon' => 'icon-cog', 'url'=>'#', 'items'=>array(
							array('label'=>'Organizaciones', 'url'=>array('/organizacion/admin')),
							array('label'=>'Departamentos', 'url'=>array('/departamento/admin')),
							array('label'=>'Cargos', 'url'=>array('/cargo/admin')),
							array('label'=>'Empleados', 'url'=>array('/empleado/admin')),
							'---',
							array('label'=>'Estados de Actividad', 'url'=>array('/estadoActividad/admin')),
							array('label'=>'Estados de Proceso', 'url'=>array('/estadoInstanciaProceso/admin')),
							array('label'=>'Roles', 'url'=>array('/rol/admin')),
							'---',
							array('label'=>'Recaudos', 'url'=>array('/recaudo/admin')),
							array('label'=>'Datos de Proceso', 'url'=>array('/datoAdicional/admin')),
						)),
						
						array('label'=>'Operaciones', 'icon' => 'icon-folder-open', 'url'=>'#', 'items'=>array(
							array('label'=>'Iniciar Trámite', 'url'=>array('/instanciaProceso/admin')),
							//array('label'=>'Iniciar Recurso Reconsideración', 'url'=>array('/instanciaProceso/adminRecursoReconsideracion')),
							array('label'=>'Actividades Pendientes', 'url'=>array('/instanciaActividad/admin')),
							array('label'=>'Reasignación de Actividades', 'url'=>array('/instanciaActividad/reasig')),
							'---',
							array('label'=>'Consulta de Trámite', 'url'=>array('/instanciaProceso/adminConsulta')),
							array('label'=>'Administración de Tramites', 'url'=>array('/instanciaProceso/adminTramite')),
							'---',
							array('label'=>'Modelado de Procesos', 'url'=>array('/proceso/admin')),
						)),

						array('label'=>'Reportes', 'icon' => 'icon-print', 'url'=>'#', 'items'=>array(
							array('label'=>'Cabecera Reportes', 'url'=>array('/cabeceraReporte/index')),
							'---',
							array('label'=>'Listado de Empleados', 'url'=>array('/reporteEmpleado/index')),
							array('label'=>'Listado de Proceso', 'url'=>array('/reporteListadoProceso/index')),
							array('label'=>'Actividades por Empleado', 'url'=>array('/reporteUsuario/index')),
							array('label'=>'Ejecución de Trámite', 'url'=>array('/reporteTramite/index')),
							array('label'=>'Ejecución de Procesos', 'url'=>array('/reporteProceso/index')),
							array('label'=>'Ejecución de Actividades', 'url'=>array('/reporte/index')),
							array('label'=>'Consolidado de Procesos', 'url'=>array('/reporteConsolidado/index')),
						)),
						
						array('label'=>'Administrar Usuarios', 'icon' => 'icon-user', 'url'=>Yii::app()->user->ui->userManagementAdminUrl, 'visible'=>!Yii::app()->user->isGuest),					
						array('label'=>'Iniciar Sesión', 'icon' => 'icon-off', 'url'=>Yii::app()->user->ui->loginUrl, 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', 'icon' => 'icon-off', 'url'=>Yii::app()->user->ui->logoutUrl, 'visible'=>!Yii::app()->user->isGuest),

					),
				),
			);
			
		}
		else 
		{
			if (Funciones::usuarioEsJefeDepartamento())
			{
				$result = array(
					array(
						'class'=>'bootstrap.widgets.TbMenu',
						'items'=>array(
							array('template'=>'<img src="'.Yii::app()->request->baseUrl.'/images/logo_corto_2.png" style="margin-top:4px;">'),
							'---',
							array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon' => 'icon-home'),							
							array('label'=>'Operaciones', 'icon' => 'icon-folder-open', 'url'=>'#', 'items'=>array(
								array('label'=>'Iniciar Trámite', 'url'=>array('/instanciaProceso/admin')),
								array('label'=>'Actividades Pendientes', 'url'=>array('/instanciaActividad/admin')),
								array('label'=>'Reasignación de Actividades', 'url'=>array('/instanciaActividad/reasig')),
								'---',
								array('label'=>'Consulta de Trámite', 'url'=>array('/instanciaProceso/adminConsulta')),
							)),

							array('label'=>'Reportes', 'icon' => 'icon-print', 'url'=>'#', 'items'=>array(
								array('label'=>'Cabecera Reportes', 'url'=>array('/cabeceraReporte/index')),
								'---',
								array('label'=>'Listado de Empleados', 'url'=>array('/reporteEmpleado/index')),
								array('label'=>'Listado de Proceso', 'url'=>array('/reporteListadoProceso/index')),
								array('label'=>'Actividades por Empleado', 'url'=>array('/reporteUsuario/index')),
								array('label'=>'Ejecución de Trámite', 'url'=>array('/reporteTramite/index')),
								array('label'=>'Ejecución de Procesos', 'url'=>array('/reporteProceso/index')),
								array('label'=>'Ejecución de Actividades', 'url'=>array('/reporte/index')),
								array('label'=>'Consolidado de Procesos', 'url'=>array('/reporteConsolidado/index')),
							)),
							
							array('label'=>'Sesión', 'icon' => 'icon-user', 'url'=>'#', 'items'=>array(
								array('label'=>'Iniciar Sesión', 'url'=>Yii::app()->user->ui->loginUrl, 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', 'url'=>Yii::app()->user->ui->logoutUrl, 'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Cambiar Contraseña', 'url'=>array('/cruge/ui/usermanagementupdate', 'id'=>Yii::app()->user->id)),

							)),
							
						),
					),
				);
			}
			elseif (Funciones::usuarioEsDirector())
			{
				$result = array(
					array(
						'class'=>'bootstrap.widgets.TbMenu',
						'items'=>array(
							array('template'=>'<img src="'.Yii::app()->request->baseUrl.'/images/logo_corto_2.png" style="margin-top:4px;">'),
							'---',
							array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon' => 'icon-home'),							
							array('label'=>'Operaciones', 'icon' => 'icon-folder-open', 'url'=>'#', 'items'=>array(
								array('label'=>'Iniciar Trámite', 'url'=>array('/instanciaProceso/admin')),
								array('label'=>'Actividades Pendientes', 'url'=>array('/instanciaActividad/admin')),
								array('label'=>'Reasignación de Actividades', 'url'=>array('/instanciaActividad/reasig')),
								'---',
								array('label'=>'Consulta de Trámite', 'url'=>array('/instanciaProceso/adminConsulta')),
							)),

							array('label'=>'Reportes', 'icon' => 'icon-print', 'url'=>'#', 'items'=>array(
								array('label'=>'Cabecera Reportes', 'url'=>array('/cabeceraReporte/index')),
								'---',
								array('label'=>'Listado de Empleados', 'url'=>array('/reporteEmpleado/index')),
								array('label'=>'Listado de Proceso', 'url'=>array('/reporteListadoProceso/index')),
								array('label'=>'Actividades por Empleado', 'url'=>array('/reporteUsuario/index')),
								array('label'=>'Ejecución de Trámite', 'url'=>array('/reporteTramite/index')),
								array('label'=>'Ejecución de Procesos', 'url'=>array('/reporteProceso/index')),
								array('label'=>'Ejecución de Actividades', 'url'=>array('/reporte/index')),
								array('label'=>'Consolidado de Procesos', 'url'=>array('/reporteConsolidado/index')),
							)),
							
							array('label'=>'Sesión', 'icon' => 'icon-user', 'url'=>'#', 'items'=>array(
								array('label'=>'Iniciar Sesión', 'url'=>Yii::app()->user->ui->loginUrl, 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', 'url'=>Yii::app()->user->ui->logoutUrl, 'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Cambiar Contraseña', 'url'=>array('/cruge/ui/usermanagementupdate', 'id'=>Yii::app()->user->id)),

							)),
							
						),
					),
				);
			}
			else 
			{
				$result = array(
					array(
						'class'=>'bootstrap.widgets.TbMenu',
						'items'=>array(
							array('template'=>'<img src="'.Yii::app()->request->baseUrl.'/images/logo_corto_2.png" style="margin-top:4px;">'),
							'---',
							array('label'=>'Inicio', 'url'=>array('/site/index'), 'icon' => 'icon-home'),
							
							array('label'=>'Operaciones', 'icon' => 'icon-folder-open', 'url'=>'#', 'items'=>array(
								array('label'=>'Iniciar Trámite', 'url'=>array('/instanciaProceso/admin')),
								array('label'=>'Actividades Pendientes', 'url'=>array('/instanciaActividad/admin')),
								'---',
								array('label'=>'Consulta de Trámite', 'url'=>array('/instanciaProceso/adminConsulta')),
							)),

							array('label'=>'Sesión', 'icon' => 'icon-user', 'url'=>'#', 'items'=>array(
								array('label'=>'Iniciar Sesión', /*'icon' => 'icon-off',*/ 'url'=>Yii::app()->user->ui->loginUrl, 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', /*'icon' => 'icon-off',*/ 'url'=>Yii::app()->user->ui->logoutUrl, 'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Cambiar Contraseña', /*'icon'=>'icon-edit',*/ 'url'=>array('/cruge/ui/usermanagementupdate', 'id'=>Yii::app()->user->id)),

							)),
						),
					),
				);				
			}	
		}									
				
		return $result;
	}
}

?>