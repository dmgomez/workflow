<?php

class ReporteController extends Controller
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

	public function actionBuscarActividades($procesos, $f_ini, $f_fin, $mostrar)
	{
		$sqlActvFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
		$actividadFin= Yii::app()->db->createCommand($sqlActvFin)->queryRow();


		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);
		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);
		$horasDiaLaborable=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);


		if($mostrar==1)
		{
			$condition = "ia.fecha_ini_actividad >= '".$f_ini."' AND ia.fecha_fin_actividad <= '".$f_fin."' AND ia.fecha_fin_actividad <> '1900-01-01'";
		}
		else
		{
			$condition = "ia.fecha_ini_actividad >= '".$f_ini."' AND ia.fecha_ini_actividad <= '".$f_fin."'";
		}

		$sqlReporte = "SELECT p.id_proceso, p.codigo_proceso, p.nombre_proceso, COUNT(ip.id_instancia_proceso) AS veces_proceso, a.id_actividad, a.codigo_actividad, lpad(split_part(a.codigo_actividad, '.', 1), 2, '0') as codigo_1, 
			lpad(split_part(a.codigo_actividad, '.', 2), 2, '0') as codigo_2, lpad(split_part(a.codigo_actividad, '.', 3), 2, '0') as codigo_3, a.nombre_actividad, ia.id_empleado, ve.nombre_persona, count(ia.id_instancia_actividad) AS veces_asignada,
			menor_tiempo_actividad(a.id_actividad, '$f_ini'::date, '$f_fin'::date, ia.id_empleado, $mostrar) AS menor_tiempo, mayor_tiempo_actividad(a.id_actividad, '$f_ini'::date, '$f_fin'::date, ia.id_empleado, $mostrar) AS mayor_tiempo,
			promedio_tiempo_actividad(a.id_actividad, '$f_ini'::date, '$f_fin'::date, ia.id_empleado, $mostrar, count(ia.id_instancia_actividad)) AS tiempo_promedio
			FROM proceso p, instancia_proceso ip, actividad a, instancia_actividad ia, vis_empleado ve
			WHERE p.id_proceso = ip.id_proceso AND p.id_proceso = a.id_proceso AND ip.id_instancia_proceso = ia.id_instancia_proceso AND a.id_actividad = ia.id_actividad AND ia.id_empleado = ve.id_empleado AND $condition --AND ia.ejecutada = 1
			AND ip.id_proceso IN($procesos) AND codigo_actividad <> '".$actividadFin['valor']."'
			GROUP BY p.id_proceso, p.codigo_proceso, p.nombre_proceso, a.id_actividad, ia.id_empleado, ve.nombre_persona
			ORDER BY p.codigo_proceso, codigo_1, codigo_2, codigo_3, ve. nombre_persona";

		$reporte = Yii::app()->db->createCommand($sqlReporte)->queryAll();

		$sqlCompletados = "SELECT count(*) AS cant, ia.id_proceso FROM instancia_proceso ia, proceso p WHERE ia.id_proceso=p.id_proceso AND ia.id_proceso IN($procesos) AND ia.ejecutado=1 group by ia.id_proceso, p.nombre_proceso order by p.nombre_proceso";
		$completados = Yii::app()->db->createCommand($sqlCompletados)->queryAll();

		$sqlIniciados = "SELECT count(*) AS cant, ia.id_proceso FROM instancia_proceso ia, proceso p WHERE ia.id_proceso=p.id_proceso AND ia.id_proceso IN($procesos) group by ia.id_proceso, p.nombre_proceso order by p.nombre_proceso";
		$iniciados = Yii::app()->db->createCommand($sqlIniciados)->queryAll();

		foreach ($completados as $key => $value) 
		{
			$array_completados[$value['id_proceso']]=$value['cant'];
		}

		foreach ($iniciados as $key => $value) 
		{
			$array_iniciados[$value['id_proceso']]=$value['cant'];
		}

		$sqlDatosReporte="SELECT * from cabecera_reporte";
		$datosReportes = Yii::app()->db->createCommand($sqlDatosReporte)->queryRow();

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter','','',15,15,65,25,9,9,'P'); 
	 	$mPDF1->SetTitle("Reporte");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('f_ini'=>$f_ini, 'f_fin'=>$f_fin, 'cabecera'=>$datosReportes, 'mostrar'=>$mostrar, 'reporte'=>$reporte, 'array_completados'=>$array_completados, 'array_iniciados'=>$array_iniciados, 'horasDiaLaborable'=>$horasDiaLaborable), true)); 
	 	$mPDF1->Output('Reporte-Actividades-Empleados'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}

	public function actionIndex()
	{
		$model=new Reporte;

		$modelProc=Proceso::model()->findAll(array('order'=>'codigo_proceso'));

		$procesos[]="";
		if ($modelProc) 
		{
			foreach ($modelProc as $key => $value) 
			{
				$procesos[$key] = array('id'=>$value['id_proceso'],'nombre'=>$value->codigo_proceso.' - '.$value->nombre_proceso);
			}
		}

		$this->render('index',
			array('procesos'=>$procesos, 'model'=>$model,
				
			)
		);
	}

	

}