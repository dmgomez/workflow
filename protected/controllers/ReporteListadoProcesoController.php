<?php

class ReporteListadoProcesoController extends Controller
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

	//public function actionGenerarReporte(/*$organizacion,*/ $proceso, $actividad, $empleado)
	public function actionGenerarReporte($proceso, $actividad, $empleado)
	{
		$query = "";

		if($empleado != "")
		{
			$query .= "SELECT id_proceso, (codigo_proceso::text || ': '::text) || nombre_proceso::text AS nombre_proceso, id_actividad, (codigo_actividad::text || ': '::text) || nombre_actividad::text AS nombre_actividad, id_empleado, (nombre_empleado::text || ' ('::text) || nombre_rol::text || ') ('::text || nombre_cargo::text || ')' AS nombre_empleado
						FROM vis_proceso 
						WHERE id_proceso IN(".$empleado.") AND id_empleado IN(SELECT id_empleado FROM empleado WHERE id_empleado IN(SELECT id_empleado FROM empleado_rol WHERE id_rol IN(SELECT id_rol FROM actividad_rol WHERE id_actividad IN(SELECT id_actividad FROM actividad WHERE id_actividad IN(SELECT id_actividad FROM actividad WHERE id_proceso IN(".$empleado."))))))";

						/*WHERE id_organizacion = ".$organizacion." AND id_proceso IN(".$empleado.") AND id_empleado IN(SELECT id_empleado FROM empleado WHERE id_empleado IN(SELECT id_empleado FROM empleado_rol WHERE id_rol IN(SELECT id_rol FROM actividad_rol WHERE id_actividad IN(SELECT id_actividad FROM actividad WHERE id_actividad IN(SELECT id_actividad FROM actividad WHERE id_proceso IN(".$empleado."))))))";*/
		}
		//if($actividad != "")
		//{
		//print_r($empleado);exit();
		$actividad = array_diff(explode(",", $actividad), explode(",", $empleado)); 
		$actividad = implode(",", $actividad);
		//print_r($actividad);exit();

		if($actividad != "")
		{
			$sqlActvFin="SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'";
			$actividadFin= Yii::app()->db->createCommand($sqlActvFin)->queryRow();

			if($query != "")
			{
				$query .= " UNION";
			}

			$query .= " SELECT id_proceso, (codigo_proceso::text || ': '::text) || nombre_proceso::text AS nombre_proceso, id_actividad, (codigo_actividad::text || ': '::text) || nombre_actividad::text AS nombre_actividad, -1 AS id_empleado, '' AS nombre_empleado
						FROM vis_proceso 
						WHERE id_actividad IN(SELECT id_actividad FROM actividad WHERE id_proceso IN(".$actividad.")) AND codigo_actividad <> '".$actividadFin['valor']."'";
						/*--WHERE id_organizacion = ".//$organizacion." AND id_actividad IN(SELECT id_actividad FROM actividad WHERE id_proceso IN(".$actividad.")) AND codigo_actividad <> '".$actividadFin['valor']."'";*/
		}
			
		//}

		$proceso = array_diff(explode(",", $proceso), explode(",", $empleado));
		$proceso = array_diff($proceso, explode(",", $actividad));
		$proceso = implode(",", $proceso);

		if($proceso != "")
		{
			if($query != "")
			{
				$query .= " UNION";
			}

			$query .= " SELECT id_proceso, (codigo_proceso::text || ': '::text) || nombre_proceso::text AS nombre_proceso, -1 AS id_actividad, '' AS nombre_actividad, -1 AS id_empleado, '' AS nombre_empleado
						FROM vis_proceso 
						WHERE id_proceso IN(".$proceso.")";

						/*WHERE id_organizacion = ".$organizacion." AND id_proceso IN(".$proceso.")";*/
		}

		$query .= " ORDER BY nombre_proceso, nombre_actividad, nombre_empleado";

		//if($query != "")
		$reporte = Yii::app()->db->createCommand($query)->queryAll();
		

		/*$select = "(codigo_proceso::text || ': '::text) || nombre_proceso::text AS nombre_proceso";
		
		$datosProceso = Proceso::model()->find(array('select'=>, 'condition'=>'id_organizacion = '.$organizacion.' AND id_proceso = '.$proceso));
		$datosActividad = null;
		$datosEmpleado = null;

		$datosActividad=Actividad::model()->findAll(array('select'=>"*, lpad(split_part(codigo_actividad, '.', 1), 2, '0') AS _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') AS _codigo_2, lpad(split_part(codigo_actividad, '.', 3), 2, '0') AS _codigo_3", 
			'order'=>'_codigo_1, _codigo_2, _codigo_3', 'condition'=>"id_proceso IN(".$actividad.") AND codigo_actividad <> '".$actividadFin['valor']."'"));
*/

		$sqlDatosReporte="SELECT * from cabecera_reporte";
		$datosReportes = Yii::app()->db->createCommand($sqlDatosReporte)->queryRow();

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter','','',15,15,50,25,9,9,'P'); 
	 	$mPDF1->SetTitle("ListadoProceso");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('cabecera'=>$datosReportes, 'reporte'=>$reporte), true)); 
	 	$mPDF1->Output('Listado-Proceso'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}

	public function actionIndex()
	{
		$model=new ReporteListadoProceso;

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

		
		$modelProc=Proceso::model()->findAll(array('condition'=>'id_organizacion = '.$modelOrganizacion->id_organizacion/*$id_organizacion*/, 'order'=>'codigo_proceso'));

		$procesos[]="";
		if ($modelProc) 
		{
			foreach ($modelProc as $key => $value) 
			{
				$procesos[$key] = array('id'=>$value['id_proceso'],'nombre'=>$value->codigo_proceso.' - '.$value->nombre_proceso);
			}
		}

		$this->render('index',
			array(
				'procesos'=>$procesos, 
				'model'=>$model,
				'idOrganizacion'=>$modelOrganizacion->id_organizacion,
			)
		);
	}

	public function actionCargarTabla()
	{
		$result = array('success'=>false);

		$idOrganizacion = $_POST['idOrganizacion'];

		$modelProc=Proceso::model()->findAll(array('condition'=>'id_organizacion = '.$idOrganizacion, 'order'=>'codigo_proceso'));

		$procesos[]="";
		if ($modelProc) 
		{
			foreach ($modelProc as $key => $value) 
			{
				$procesos[$key] = array('id'=>$value['id_proceso'],'nombre'=>$value->codigo_proceso.' - '.$value->nombre_proceso);
			}
		}

		$tabla = '';

		foreach ($procesos as $key => $value) 
		{
			$tabla .= '
			<tr>
				<td>'
					. CHtml::checkBox('_procesos', '',
						array(//'separator'=>'',
							//'style'=>'float:left; margin-right: 5px;',
							'onClick'=>'seleccionarProceso($(this))',
							'value'=>$value['id'],
						)).
					' 
				</td>
				<td>' .
					$value['nombre'] .
				'</td>
			</tr>
			<tr id="'.$value['id'].'" style="display: none">
				<td></td>
				<td>'
				. $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'toggle' => 'checkbox',
				    'buttons' => array(
				        array(
				            'label' => 'Mostrar Actividades',
				            'type' => 'info',
				            //'url' => Yii::app()->createUrl('admin/news/publish', array('id' => $data->id)),
				            'htmlOptions' => array(
				                'id' => 'A' . $value['id'],
				                'class' => 'toggleStatus',
				                'onClick'=>'seleccionarActividad($(this).prop("id"))',
				            ),
				            //'active' => /*($data->isPublished()) ?*/ true /*: false*/,
				        ),
				        array(
				            'label' => 'Mostrar Empleados',
				            'type' => 'info',
				            //'url' => Yii::app()->createUrl('admin/news/archive', array('id' => $data->id)),
				            'htmlOptions' => array(
				                'id' => 'E' . $value['id'],
				                'class' => 'toggleStatus disabled',
				                'onClick'=>'seleccionarEmpleado($(this).prop("id"))',
				            ),
				            //'active' => /*($data->isArchived()) ? true :*/ false,
				        ),
				        
				    )
				), true).
				'</td>
			</tr>';
			
		}

		$result = array('success'=>true,
			'tabla' => $tabla
		);

		echo CJSON::encode($result);
	}

}