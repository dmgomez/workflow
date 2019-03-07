<?php

class ReporteConsolidadoController extends Controller
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

	public function actionBuscarActividades($procesos, $f_ini, $f_fin)
	{
		$sqlJornada="SELECT valor FROM configuracion WHERE variable = 'jornada_laboral'";
		$jornada= Yii::app()->db->createCommand($sqlJornada)->queryRow();
		$jornada=explode(",", $jornada['valor']);
		$horarioMatutino=explode("-", $jornada[0]);
		$horarioVespertino=explode("-", $jornada[1]);
		$horasDiaLaborable=($horarioMatutino[1]-$horarioMatutino[0])+($horarioVespertino[1]-$horarioVespertino[0]);

		$procesos=explode(',', $procesos);

		for ($i=0; $i<count($procesos) ; $i++) 
		{ 
			$sqlIniciados = "SELECT count(*) AS cant_iniciados FROM instancia_proceso WHERE id_proceso = ".$procesos[$i]." AND fecha_ini_proceso BETWEEN '".$f_ini."' AND '".$f_fin."'";
			$iniciados = Yii::app()->db->createCommand($sqlIniciados)->queryRow();

			$queryid_inst_procs="SELECT count(*) as _cantidad, array_to_string(array_agg(id_instancia_proceso), ',') as id_instancia_proceso from instancia_proceso where id_proceso = ".$procesos[$i]." AND ejecutado = 1 AND fecha_fin_proceso BETWEEN '".$f_ini."' AND '".$f_fin."'";
			$id_inst_procs = Yii::app()->db->createCommand($queryid_inst_procs)->queryRow();


			if($iniciados && $iniciados['cant_iniciados']>0)
			{
				$array_proceso[$procesos[$i]]['iniciados']=$iniciados['cant_iniciados'];

				$proceso_act=Proceso::model()->findByPk($procesos[$i]);
				$nombre_proceso=$proceso_act->nombre_proceso;
				$codigo_proceso=$proceso_act->codigo_proceso;
				
				$array_proceso[$procesos[$i]]['codigo']=$codigo_proceso;
				$array_proceso[$procesos[$i]]['nombre']=$nombre_proceso;
			}

			if($id_inst_procs && $id_inst_procs['_cantidad']>0)
			{
				$proceso_act=Proceso::model()->findByPk($procesos[$i]);
				$nombre_proceso=$proceso_act->nombre_proceso;
				$codigo_proceso=$proceso_act->codigo_proceso;
			

				$inst_procs=$id_inst_procs['id_instancia_proceso'];

				$inst_acts=InstanciaActividad::model()->findAll(array('condition'=>'id_instancia_proceso IN('.$inst_procs.') AND ejecutada = 1 order by id_instancia_proceso asc, consecutivo_actividad asc'));	
			
				if($inst_acts)
				{
					$array_proceso[$procesos[$i]]['codigo']=$codigo_proceso;
					$array_proceso[$procesos[$i]]['nombre']=$nombre_proceso;
					$array_proceso[$procesos[$i]]['cant']=$id_inst_procs['_cantidad'];
					$array_proceso[$procesos[$i]]['tiempo']=0;
					$array_proceso[$procesos[$i]]['retrasado']=0;

					$id_instancia=-1;
					$tiempo_estimado=0;
					$tiempo_promedio=0;
					foreach ($inst_acts as $key => $value) 
					{
						if($id_instancia != $value['id_instancia_proceso'])
						{
							if($id_instancia==-1)
							{
								$id_instancia=$value['id_instancia_proceso'];
							}
							else
							{
								$queryTiempoProc = "SELECT (fecha_ini_proceso::date || ' '::text) || hora_ini_proceso::time AS inicio, (fecha_fin_proceso::date || ' '::text) || hora_fin_proceso::time AS fin FROM instancia_proceso WHERE id_instancia_proceso = ".$id_instancia;
								$tiempoProc = Yii::app()->db->createCommand($queryTiempoProc)->queryRow();
								
								$queryTiempoProcMin = "SELECT count(*) -1 AS tiempo_minutos FROM generate_series ('".$tiempoProc['inicio']."'::timestamp,'".$tiempoProc['fin']."'::timestamp, interval '1m') h WHERE EXTRACT(ISODOW FROM h) < 6 AND ((h::time >= '".$horarioMatutino[0].":00'::time AND h::time < '".$horarioMatutino[1].":00'::time) OR (h::time >= '".$horarioVespertino[0].":00'::time AND h::time < '".$horarioVespertino[1].":01'::time))";
								$tiempoProcMin = Yii::app()->db->createCommand($queryTiempoProcMin)->queryRow();

								$tiempo_proceso=$tiempoProcMin['tiempo_minutos'];
								if($tiempo_proceso<0)
									$tiempo_proceso=0;

								if($tiempo_proceso <= $tiempo_estimado)
								{
									$array_proceso[$procesos[$i]]['tiempo'] = $array_proceso[$procesos[$i]]['tiempo'] + 1;
								}
								else
								{
									$array_proceso[$procesos[$i]]['retrasado'] = $array_proceso[$procesos[$i]]['retrasado'] + 1;
								}

								$tiempo_promedio+=$tiempo_proceso;

								$id_instancia=$value['id_instancia_proceso'];
								//IF TIEMPO_PROCESO <= TIEMPO_ESTIMADO ? ARRAY[TIEMPO]++ : ARRAY[RETRASADO]++
								$tiempo_estimado=0;
							}

							//CALCULA TIEMPO ESTIMADO DE ACTIVIDAD
							//TIEMPO_ESTIMADO + = TIEMPO_ESTIMADO_ACTIVIDAD
						}

						$tiempoAct = Actividad::model()->findByPk($value['id_actividad']);
						$tiempo_estimado += ((($tiempoAct['dias'] * $horasDiaLaborable) + $tiempoAct['horas']) * 60);

						
					}

					$queryTiempoProc = "SELECT (fecha_ini_proceso::date || ' '::text) || hora_ini_proceso::time AS inicio, (fecha_fin_proceso::date || ' '::text) || hora_fin_proceso::time AS fin FROM instancia_proceso WHERE id_instancia_proceso = ".$id_instancia;
					$tiempoProc = Yii::app()->db->createCommand($queryTiempoProc)->queryRow();

					$queryTiempoProcMin = "SELECT count(*) -1 AS tiempo_minutos FROM generate_series ('".$tiempoProc['inicio']."'::timestamp,'".$tiempoProc['fin']."'::timestamp, interval '1m') h WHERE EXTRACT(ISODOW FROM h) < 6 AND ((h::time >= '".$horarioMatutino[0].":00'::time AND h::time < '".$horarioMatutino[1].":00'::time) OR (h::time >= '".$horarioVespertino[0].":00'::time AND h::time < '".$horarioVespertino[1].":01'::time))";
					$tiempoProcMin = Yii::app()->db->createCommand($queryTiempoProcMin)->queryRow();

					$tiempo_proceso=$tiempoProcMin['tiempo_minutos'];
					if($tiempo_proceso<0)
						$tiempo_proceso=0;

					if($tiempo_proceso <= $tiempo_estimado)
					{
						$array_proceso[$procesos[$i]]['tiempo'] = $array_proceso[$procesos[$i]]['tiempo'] + 1;
					}
					else
					{
						$array_proceso[$procesos[$i]]['retrasado'] = $array_proceso[$procesos[$i]]['retrasado'] + 1;
					}

					$tiempo_promedio=($tiempo_promedio + $tiempo_proceso) / $id_inst_procs['_cantidad'];
					//$tiempo_promedio+=$tiempoProcMin['tiempo_minutos'];
					//$tiempo_promedio=$tiempo_promedio
					
					$tiempo_promedio=($tiempo_promedio / 60) / $horasDiaLaborable;
					$dTemp= floor($tiempo_promedio);
					$tiempo_promedio=$tiempo_promedio-$dTemp;
					$tiempo_promedio=$tiempo_promedio*$horasDiaLaborable;
					//$hTemp= round($tiempo_promedio);
					$hTemp= floor($tiempo_promedio);
					$tiempo_promedio= $tiempo_promedio-$hTemp;
					$mTemp=floor($tiempo_promedio*60);
					$tiempo_promedio=$dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';

					$array_proceso[$procesos[$i]]['tpromedio']=$tiempo_promedio;
					
				}
			}
			
		}

		$sqlDatosReporte="SELECT * from cabecera_reporte";
		$datosReportes = Yii::app()->db->createCommand($sqlDatosReporte)->queryRow();

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter-L','','',15,15,50,25,9,9,'L'); 
	 	$mPDF1->SetTitle("ReporteConsolidado");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('procesos'=>$procesos, 'array_proceso'=>$array_proceso, 'cabecera'=>$datosReportes, 'f_ini'=>$f_ini, 'f_fin'=>$f_fin), true)); 
	 	$mPDF1->Output('Reporte-Consolidado'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}

	public function actionIndex()
	{
		$model=new ReporteConsolidado;

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