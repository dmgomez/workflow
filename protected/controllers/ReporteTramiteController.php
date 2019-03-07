<?php

class ReporteTramiteController extends Controller
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

	public function actionBuscarTramite()
	{
		$result = array('success'=>false);

		$codigo = $_POST['codigo'];

		$tramite = InstanciaProceso::model()->find(array('condition'=>'lower(codigo_instancia_proceso) like \'%'.strtolower($codigo).'\''));
		if($tramite)
			$result = array('success'=>true, 'idTramite'=>$tramite->id_instancia_proceso);

		echo CJSON::encode($result);
	}

	public function actionCargarReporte($idTramite)
	{
		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);
		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);
		$horasDiaLaborable=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);

		$sqlActvFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
		$actividadFin= Yii::app()->db->createCommand($sqlActvFin)->queryRow();

		$sqlReporte = "SELECT id_instancia_proceso, codigo_instancia_proceso, (codigo_proceso::text || '. '::text) || nombre_proceso::text AS proceso, fecha_ini_actividad, hora_ini_actividad, fecha_fin_actividad, hora_fin_actividad, 
				tiempo_actividad(fecha_ini_actividad, fecha_fin_actividad, hora_ini_actividad, hora_fin_actividad) AS tiempo_empleado, (nombre_persona::text || ' '::text) || apellido_persona::text AS empleado, 
				codigo_actividad, (codigo_actividad::text || '. '::text) || nombre_actividad::text AS actividad, consecutivo_actividad, (dias*7*60)+(horas*60) AS tiempo, ejecutada from vis_instancia_actividad where ejecutada= 1 and 
				id_instancia_proceso = ".$idTramite." and codigo_actividad <> '".$actividadFin['valor']."' order by consecutivo_actividad";

		$reporte = Yii::app()->db->createCommand($sqlReporte)->queryAll();

		
		$sqlCabecera="SELECT * from cabecera_reporte";
		$cabecera = Yii::app()->db->createCommand($sqlCabecera)->queryRow();

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter-L','','',15,15,50,25,9,9,'L'); 
	 	$mPDF1->SetTitle("Reporte");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('reporte'=>$reporte, 'cabecera'=>$cabecera, 'horasDiaLaborable'=>$horasDiaLaborable), true)); 
	 	$mPDF1->Output('Reporte-Ejecucion-Tramite-'.$idTramite.''.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.
	}

	public function actionIndex()
	{
		$model=new ReporteTramite;

		$this->render('index',
			array('model'=>$model,
				
			)
		);
	}

	

}