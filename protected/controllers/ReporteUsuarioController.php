<?php

class ReporteUsuarioController extends Controller
{
	public $layout='//layouts/column1';

	public function filters()
	{
		return array(array('CrugeAccessControlFilter'));
	}

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
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'BuscarActividades', 'view', 'pdfConsulta', 'GenerarPdf'),
				'users'=>array('@'),
			),
			
		);
	}
	*/

/*	public function actionBuscarActividades($empleado, $f_ini, $f_fin)
	{
		$sqlActvFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
		$actividadFin= Yii::app()->db->createCommand($sqlActvFin)->queryRow();


		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);
		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);
		$horasDiaLaborable=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);

		$f_ini = Funciones::invertirFecha($f_ini);
		$f_fin = Funciones::invertirFecha($f_fin);
		

		$sqlReporte="SELECT (nombre_persona::text || ' ') || apellido_persona AS empleado, (codigo_proceso::text || '. ') || nombre_proceso AS proceso, id_actividad, (codigo_actividad::text || '. ') || nombre_actividad AS actividad, 
			lpad(split_part(codigo_actividad, '.', 1), 2, '0') as codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as codigo_2, lpad(split_part(codigo_actividad, '.', 3), 2, '0') as codigo_3, codigo_instancia_proceso, fecha_ini_actividad, 
			(fecha_ini_actividad_text::text || ' ') || hora_ini_actividad AS fecha_inicio, fecha_fin_actividad, (to_char(fecha_fin_actividad::timestamp with time zone, 'dd-mm-yyyy'::text) || ' ') || hora_fin_actividad AS fecha_fin, dias, horas, 
			(dias*7*60)+(horas*60) AS tiempo_estimado, tiempo_actividad(fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad) AS tiempo_ejecucion FROM vis_instancia_actividad where id_empleado = ".$empleado." 
			AND fecha_ini_actividad >= '".$f_ini."' AND fecha_fin_actividad <= '".$f_fin."' AND codigo_actividad <> '".$actividadFin['valor']."'  AND ejecutada = 1 ORDER BY proceso, codigo_1, codigo_2, codigo_3, codigo_instancia_proceso";


		$reporte = Yii::app()->db->createCommand($sqlReporte)->queryAll();
		
		$sqlCabecera="SELECT * from cabecera_reporte";
		$cabecera = Yii::app()->db->createCommand($sqlCabecera)->queryRow();

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter-L','','',15,15,50,25,9,9,'L'); 
	 	$mPDF1->SetTitle("ReporteActividades");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('reporte'=>$reporte, 'cabecera'=>$cabecera, 'horasDiaLaborable'=>$horasDiaLaborable), true)); 
	 	$mPDF1->Output('Reporte-Actividades-Usuario'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}*/

	public function actionGenerarReporte($tipo, $empleado, $f_ini, $f_fin)
	{
		set_time_limit (0);

		$sqlActvFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
		$actividadFin= Yii::app()->db->createCommand($sqlActvFin)->queryRow();

		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);
		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);
		$horasDiaLaborable=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);

		$sqlCabecera="SELECT * from cabecera_reporte";
		$cabecera = Yii::app()->db->createCommand($sqlCabecera)->queryRow();


		switch ($tipo) {
			case 1:
				/*$sqlReporte = "SELECT (nombre_persona::text || ' ') || apellido_persona AS empleado, 
								(codigo_proceso::text || ': ') || nombre_proceso AS proceso, 
								codigo_actividad, 
								nombre_actividad,
							FROM vis_instancia_actividad 
							where id_empleado IN(".$empleado.") AND 
								codigo_actividad <> '".$actividadFin['valor']."'
							GROUP BY empleado, proceso, codigo_actividad, nombre_actividad
							ORDER BY empleado, proceso, codigo_actividad";*/
				$sqlReporte = "SELECT id_empleado, 
								nombre_empleado, 
								id_proceso,
								(codigo_proceso::text || ': '::text) || nombre_proceso::text AS nombre_proceso, 
								id_actividad, 
								codigo_actividad,
								nombre_actividad 
							FROM vis_proceso
							WHERE id_empleado IN(".$empleado.") AND 
								codigo_actividad <> '".$actividadFin['valor']."'
							ORDER BY nombre_empleado, codigo_proceso, codigo_actividad";

				$tipoR = 'Listado';
				$orientacion = '';

				break;

			case 2:
				$f_ini = Funciones::invertirFecha($f_ini);
				$f_fin = Funciones::invertirFecha($f_fin);

				/*$sqlReporte = "SELECT (nombre_persona::text || ' ') || apellido_persona AS empleado, 
								(codigo_proceso::text || ': ') || nombre_proceso AS proceso, 
								codigo_actividad, 
								nombre_actividad,
								COUNT(id_instancia_actividad) AS cant_actividad,
								SUM(tiempo_actividad(fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad)) AS tiempo_ejecucion,
								SUM(tiempo_retraso_actividad(dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad, 7)) AS tiempo_reraso,
								COUNT(CASE WHEN (tiempo_retraso_actividad(dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad, 7) > 0) THEN 1 END) AS cant_retraso
							FROM vis_instancia_actividad 
							where id_empleado IN(".$empleado.") AND 
								fecha_ini_actividad BETWEEN '".$f_ini."' '".$f_fin."' 
								AND codigo_actividad <> '".$actividadFin['valor']."'  --AND ejecutada = 1 
							GROUP BY empleado, proceso, codigo_actividad, nombre_actividad
							ORDER BY empleado, proceso, codigo_actividad";*/

				$sqlReporte = "SELECT id_empleado,
								nombre_empleado,
								id_proceso,
								(codigo_proceso::text || ': ') || nombre_proceso AS proceso,
								codigo_actividad,
								nombre_actividad,
								descripcion_actividad,
								COUNT(id_instancia_actividad) AS cant_actividad,
								SUM(CASE WHEN (id_instancia_actividad IS NOT NULL) THEN tiempo_retraso_actividad(tiempo_ejecucion, dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad) END) AS tiempo_retraso,
								COUNT(CASE WHEN (tiempo_retraso_actividad(tiempo_ejecucion, dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad) > 0) THEN 1 END) AS cant_retraso
							FROM vis_actividad_empleado
							WHERE id_empleado IN(".$empleado.") AND 
								fecha_ini_actividad BETWEEN '".$f_ini."' AND '".$f_fin."' 
								AND codigo_actividad <> '".$actividadFin['valor']."'  --AND ejecutada = 1 
							GROUP BY id_empleado, nombre_empleado, id_proceso, proceso, codigo_actividad, nombre_actividad, descripcion_actividad
							ORDER BY nombre_empleado, proceso, codigo_actividad";

				$tipoR = 'Resumido';
				$orientacion = '';

				break;

			case 3:
				$f_ini = Funciones::invertirFecha($f_ini);
				$f_fin = Funciones::invertirFecha($f_fin);

				$sqlReporte = "SELECT id_empleado,
								nombre_empleado,
								id_proceso,
								(codigo_proceso::text || ': ') || nombre_proceso AS proceso,
								id_actividad,
								(codigo_actividad::text || ': ') || nombre_actividad AS actividad,
								codigo_instancia_proceso,
								nombre_estado_actividad,
								fecha_ini_actividad_text AS fecha_ini,
								(CASE WHEN fecha_fin_actividad <> '1900-01-01' THEN fecha_fin_actividad_text ELSE 'N/A' END) as fecha_fin,
								dias,
								horas,
								(CASE WHEN (id_instancia_actividad IS NOT NULL) THEN tiempo_retraso_actividad(tiempo_ejecucion, dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad) END) AS tiempo_retraso
							FROM vis_actividad_empleado
							WHERE id_empleado IN(".$empleado.") AND 
								fecha_ini_actividad BETWEEN '".$f_ini."' AND '".$f_fin."' 
								AND codigo_actividad <> '".$actividadFin['valor']."'  --AND ejecutada = 1 
							ORDER BY nombre_empleado, proceso, codigo_actividad";

				$tipoR = 'Detallado';
				$orientacion = '';

				break;
			
		}


		$reporte = Yii::app()->db->createCommand($sqlReporte)->queryAll();

		$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter'.$orientacion,'','',15,15,50,25,9,9,$orientacion); 
	 	$mPDF1->SetTitle("ReporteActividadesPorEmpleado");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdf'.$tipoR, array('reporte'=>$reporte, 'cabecera'=>$cabecera, 'horasDiaLaborable'=>$horasDiaLaborable, $orientacion), true)); 
	 	$mPDF1->Output('Reporte-Actividades-Empleado'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.
					
		
/*SELECT (nombre_persona::text || ' ') || apellido_persona AS empleado, 
	(codigo_proceso::text || ': ') || nombre_proceso AS proceso, 
	codigo_actividad, 
	nombre_actividad,
	COUNT(id_instancia_actividad) AS cant_actividad,
	SUM(tiempo_actividad(fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad)) AS tiempo_ejecucion,
	SUM(tiempo_retraso_actividad(dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad, 7)) AS tiempo_reraso,
	COUNT(CASE WHEN (tiempo_retraso_actividad(dias, horas, fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad, 7) > 0) THEN 1 END) AS cant_retraso
		
	
FROM vis_instancia_actividad 
where id_empleado = ".$empleado." AND 
	fecha_ini_actividad >= '2015-05-10' AND fecha_fin_actividad <= '2015-09-25' 
	AND codigo_actividad <> '".$actividadFin['valor']."'  AND ejecutada = 1 
GROUP BY empleado, proceso, codigo_actividad, nombre_actividad
ORDER BY empleado, proceso, codigo_actividad*/
	}

	public function actionIndex()
	{
		$model=new ReporteUsuario;

		/*$idUser=Yii::app()->user->id_usuario;
		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));
		if($idEmpleado)
		{
			$departEmpleado = Departamento::model()->findByPk($idEmpleado->id_departamento);
			
			$departamentos = Departamento::model()->findAllByAttributes(array('id_organizacion'=>$departEmpleado->id_organizacion), array('order'=>'nombre_departamento ASC'));
			$cargos = Cargo::model()->findAllByAttributes(array('id_organizacion'=>$departEmpleado->id_organizacion));

			$idOrg = $departEmpleado->id_organizacion;
		}
		else
		{
			$org = Organizacion::model()->find(array('order' => 'nombre_organizacion'));
			$departamentos =  Departamento::model()->findAllByAttributes(array('id_organizacion'=>$org->id_organizacion), array('order'=>'nombre_departamento ASC'));
			$cargos = Cargo::model()->findAllByAttributes(array('id_organizacion'=>$org->id_organizacion), array('order'=>'nombre_cargo ASC'));

			$idOrg = $org->id_organizacion;
		}*/

		if(Yii::app()->user->isSuperAdmin)
		{
			/*$modelOrganizacion = Organizacion::model()->findAll(array('order'=>'nombre_organizacion'));
			$id_organizacion = $modelOrganizacion[0]['id_organizacion'];*/
			$modelOrganizacion = Organizacion::model()->find(array('order'=>'nombre_organizacion'));
		}
		else
		{
			$empleado = VisEmpleado::model()->findByAttributes(array('id_usuario' => Yii::app()->user->id));

			$modelOrganizacion = Organizacion::model()->findByPk($empleado->id_organizacion);
			//$id_organizacion = $modelOrganizacion->id_organizacion;
		}

		$modelEmpleado=VisEmpleado::model()->findAll(array('condition'=>'id_organizacion = '.$modelOrganizacion->id_organizacion/*$id_organizacion*/, 'order'=>'nombre_persona'));

		$empleados[]="";
		if ($modelEmpleado) 
		{
			foreach ($modelEmpleado as $key => $value) 
			{
				$empleados[$key] = array('id'=>$value['id_empleado'],'nombre'=>$value->nombre_persona);
			}
		}

		$tipoReporte = array(1=>"Listado", 2=>"Evaluación Resumido", 3=>"Evaluación Detallado");

		$this->render('index',
			array('model'=>$model,
				'idOrganizacion'=>$modelOrganizacion->id_organizacion,
				'empleados'=>$empleados,
				'tipoReporte'=>$tipoReporte,
			)
		);
	}

/*	public function actionGetEmpleados() 
	{
		$result = array('success' => false);

		$departamento = $_POST['departamento'];
		//$cargo = $_POST['cargo'];

		if($departamento!="")
		{
			$empleados = VisEmpleado::model();
			$empleadosDep = $empleados->findAllByAttributes(array('id_departamento'=>$departamento));
			
			$result = array(
				'success' => true,
				'empleado' => CHtml::dropDownList('_empleado', '',
						CHtml::listData($empleadosDep, 'id_empleado', 'nombre_persona'), 
						array('prompt' => 'Seleccione', 
							'class' => (isset($_POST['class'])? $_POST['class'] : 'span4'), 
							'id' => (isset($_POST['empleadoId'])? $_POST['empleadoId']: 'ReporteUsuario__empleado'), 
							'name' => (isset($_POST['empleadoName'])? $_POST['empleadoName']: 'ReporteUsuario[_empleado]'))
				)
			);	
		}
		
		echo CJSON::encode($result);
	}*/

/*	public function actionGetDepartamentos() 
	{
		$result = array('success' => false);

		$organizacion = $_POST['organizacion'];

		if($organizacion!="")
		{
			//$empleados = VisEmpleado::model();
			$departamentosOrg = Departamento::model()->findAllByAttributes(array('id_organizacion'=>$organizacion));
			
			$result = array(
				'success' => true,
				'departamento' => CHtml::dropDownList('_departamento', '',
						CHtml::listData($departamentosOrg, 'id_departamento', 'nombre_departamento'), 
						array('prompt' => 'Seleccione', 
							'class' => (isset($_POST['class'])? $_POST['class'] : 'span4'), 
							'id' => (isset($_POST['departamentoId'])? $_POST['departamentoId']: 'ReporteUsuario__departamento'), 
							'name' => (isset($_POST['departamentoName'])? $_POST['departamentoName']: 'ReporteUsuario[_departamento]'))
				)
			);	
		}
		
		echo CJSON::encode($result);
	}*/

}