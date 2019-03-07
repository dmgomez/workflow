<?php

class ReporteProcesoController extends Controller
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

	public function actionBuscarActividades($proceso, $f_ini, $f_fin)
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
		

		$sqlReporte = "SELECT p.id_proceso, (p.codigo_proceso::text || '. ') || p.nombre_proceso AS proceso, (a.codigo_actividad::text || '. ') || a.nombre_actividad AS actividad, lpad(split_part(a.codigo_actividad, '.', 1), 2, '0') as codigo_1, 
		    lpad(split_part(a.codigo_actividad, '.', 2), 2, '0') as codigo_2, lpad(split_part(a.codigo_actividad, '.', 3), 2, '0') as codigo_3, ip.ejecutado,
		    mayor_tiempo_actividad_empleado(a.id_actividad, array_to_string(array_agg(ip.id_instancia_proceso), ',')) AS mayor_tiempo, menor_tiempo_actividad_empleado(a.id_actividad, array_to_string(array_agg(ip.id_instancia_proceso), ',')) AS menor_tiempo,
		    tiempo_promedio_actividad_empleado(a.id_actividad, array_to_string(array_agg(ip.id_instancia_proceso), ','), (SELECT COUNT(id_instancia_actividad) FROM instancia_actividad WHERE id_actividad=a.id_actividad AND id_instancia_proceso IN (SELECT id_instancia_proceso FROM instancia_proceso WHERE fecha_fin_proceso >='".$f_ini."' AND fecha_fin_proceso <= '".$f_fin."'))) AS tiempo_promedio, 
		    COUNT(ip.id_instancia_proceso) AS cant_tramites
		    FROM proceso p, actividad a, instancia_proceso ip WHERE p.id_proceso = a.id_proceso AND p.id_proceso = ip.id_proceso AND ip.ejecutado = 1 
		    AND ip.id_instancia_proceso IN (SELECT id_instancia_proceso FROM instancia_proceso WHERE fecha_fin_proceso >='".$f_ini."' AND fecha_fin_proceso <= '".$f_fin."') AND  p.id_proceso = ".$proceso." AND codigo_actividad <> '".$actividadFin['valor']."'
		    GROUP BY p.id_proceso, p.codigo_proceso, p.nombre_proceso, ip.ejecutado, a.id_actividad, a.codigo_actividad, a.nombre_actividad 
		    ORDER BY codigo_1, codigo_2, codigo_3";//COUNT(ip.id_instancia_proceso)

		$reporte = Yii::app()->db->createCommand($sqlReporte)->queryAll();


		$sqlDatosReporte="SELECT * from cabecera_reporte";
		$datosReportes = Yii::app()->db->createCommand($sqlDatosReporte)->queryRow();

		$f_ini = Funciones::invertirFecha($f_ini);
		$f_fin = Funciones::invertirFecha($f_fin);

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter-L','','',15,15,50,25,9,9,'L'); 
	 	$mPDF1->SetTitle("ReporteEjecucionProcesos");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('f_ini'=>$f_ini, 'f_fin'=>$f_fin, 'cabecera'=>$datosReportes, 'reporte'=>$reporte, 'horasDiaLaborable'=>$horasDiaLaborable), true)); 
	 	$mPDF1->Output('Reporte-Ejecucion-Procesos'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}

	public function actionIndex()
	{
		$model=new ReporteProceso;

		$idUser=Yii::app()->user->id_usuario;
		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));
		if($idEmpleado)
		{
			$departEmpleado = Departamento::model()->findByPk($idEmpleado->id_departamento);
			$idOrg = $departEmpleado->id_organizacion;

			//$modelProc=Proceso::model()->findAll(array('condition'=>'id_organizacion = '.$idOrg, 'order'=>'codigo_proceso'));
		}
		else
		{
			$org = Organizacion::model()->find(array('order' => 'nombre_organizacion'));
			$idOrg = $org->id_organizacion;

			//$modelProc=Proceso::model()->findAll(array('condition'=>'id_organizacion = '.$idOrg, 'order'=>'codigo_proceso'));
		}



		$modelProc=Proceso::model()->findAll(array('condition'=>'id_organizacion = '.$idOrg, 'order'=>'codigo_proceso'));
		//$modelProc=Proceso::model()->findAll(array('order'=>'codigo_proceso'));

		$procesos[]="";
		if ($modelProc) 
		{
			foreach ($modelProc as $key => $value) 
			{
				$procesos[$key] = array('id'=>$value['id_proceso'],'nombre'=>$value->codigo_proceso.' - '.$value->nombre_proceso);
			}
		}

		$this->render('index',
			array('idOrganizacion'=>$idOrg, 'procesos'=>$procesos, 'model'=>$model,
				
			)
		);
	}

	public function actionCargarProcesos()
	{
		$result = array('success'=>false);

		$idOrganizacion = $_POST['idOrganizacion'];

		$model = new ReporteProceso();

		$modelProc=Proceso::model()->findAll(array('condition'=>'id_organizacion = '.$idOrganizacion, 'order'=>'codigo_proceso'));

		$procesos[]="";
		if ($modelProc) 
		{
			foreach ($modelProc as $key => $value) 
			{
				$procesos[$key] = array('id'=>$value['id_proceso'],'nombre'=>$value->codigo_proceso.' - '.$value->nombre_proceso);
			}
		}



		$result = array('success'=>true,
			'proceso' => CHtml::activeDropDownList($model, '_proceso',
				CHtml::listData($procesos, 'id', 'nombre'),
				array('class'=>'span8')
					
			)
		);

		echo CJSON::encode($result);
	}

}