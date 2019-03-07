<?php

class ReporteEmpleadoController extends Controller
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

	public function actionBuscarActividades($departamento, $cargo, $rol, $rolSistema, $ordenar, $mostrar)
	{
		$condition="";

		$condition.=" AND (";
		$rolSistema = explode(',', $rolSistema);

		foreach ($rolSistema as $key => $value) 
		{
			$condition.=" itemname like '%".$value."%' OR";
		}
		$condition = substr($condition, 0, -2);
		$condition.=")";

		if($mostrar==1)
			$condition.=" AND estado = 1";
		if($mostrar==2)
			$condition.=" AND estado = 0";

		if($ordenar==1)
			$condition.=" ORDER BY cedula_persona";
		else
			$condition.=" ORDER BY nombre_persona";


		$sqlReporte="SELECT * FROM (SELECT (SELECT state FROM cruge_user WHERE iduser=id_usuario) AS estado, (SELECT array_to_string(array_agg(itemname), ', ') FROM cruge_authassignment WHERE userid=id_usuario) AS itemname, 
			nombre_persona, cedula_persona, nombre_cargo, nombre_departamento, rol_empleado(id_empleado, '".$rol."') AS rol_empleado 
			FROM vis_empleado WHERE id_departamento IN(".$departamento.") AND id_cargo IN(".$cargo.") ) as a where rol_empleado <> '' ".$condition;
		$reporte = Yii::app()->db->createCommand($sqlReporte)->queryAll();
		
		$sqlCabecera="SELECT * from cabecera_reporte";
		$cabecera = Yii::app()->db->createCommand($sqlCabecera)->queryRow();

	 	$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','Letter-L','','',15,15,50,25,9,9,'L'); 
	 	$mPDF1->SetTitle("Reporte");
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('pdfReport', array('reporte'=>$reporte, 'cabecera'=>$cabecera), true)); 
	 	$mPDF1->Output('Reporte-Empleados'.date('YmdHis').'.pdf','I');  //Nombre del pdf y parámetro para ver pdf o descargarlo directamente.

	}

	public function actionIndex()
	{
		$model=new ReporteEmpleado;

		$idUser=Yii::app()->user->id_usuario;
		$idEmpleado = Empleado::model()->findByAttributes(array('id_usuario'=>$idUser));
		if($idEmpleado)
		{
			$departEmpleado = Departamento::model()->findByPk($idEmpleado->id_departamento);
			
			$departamentos = Departamento::model()->findAllByAttributes(array('id_organizacion'=>$departEmpleado->id_organizacion), array('order'=>'nombre_departamento ASC'));
			$cargos = Cargo::model()->findAllByAttributes(array('id_organizacion'=>$departEmpleado->id_organizacion), array('order'=>'nombre_cargo ASC'));

			$idOrg = $departEmpleado->id_organizacion;
		}
		else
		{
			$org = Organizacion::model()->find(array('order' => 'nombre_organizacion'));
			$departamentos =  Departamento::model()->findAllByAttributes(array('id_organizacion'=>$org->id_organizacion), array('order'=>'nombre_departamento ASC'));
			$cargos = Cargo::model()->findAllByAttributes(array('id_organizacion'=>$org->id_organizacion), array('order'=>'nombre_cargo ASC'));

			$idOrg = $org->id_organizacion;
		}
		
		$roles = Rol::model()->findAll(array('order'=>'nombre_rol ASC'));

		$sqlRoles = "SELECT valor AS variable, replace(valor, '_', ' ') AS valor FROM configuracion WHERE variable  like '%cruge_itemname%' ORDER BY valor";
		$rolesSistema = Yii::app()->db->createCommand($sqlRoles)->queryAll();
		
		
		$this->render('index',
			array('model'=>$model,
				'idOrganizacion'=>$idOrg,
				'departamentos'=>$departamentos,
				'cargos'=>$cargos,
				'roles'=>$roles,
				'rolesSistema'=>$rolesSistema,
			)
		);
	}

	public function actionCargarCampos()
	{
		$result = array('success'=>false);

		$idOrganizacion = $_POST['idOrganizacion'];

		$model = new ReporteEmpleado();

		$departamentos =  Departamento::model()->findAllByAttributes(array('id_organizacion'=>$idOrganizacion));
		$cargos = Cargo::model()->findAllByAttributes(array('id_organizacion'=>$idOrganizacion));


		$result = array('success'=>true,
			'departamento' => CHtml::activeCheckBoxList($model, '_check_departamento',
				CHtml::listData($departamentos, 'id_departamento', 'nombre_departamento'),
				array('separator'=>'',
					'style'=>'float:left; margin-right: 5px;',
					'onChange'=>'seleccionadosDep()',
				)
					
			),
			'cargo' => CHtml::activeCheckBoxList($model, '_check_cargo',
				CHtml::listData($cargos,  'id_cargo', 'nombre_cargo'),
				array('separator'=>'',
					'style'=>'float:left; margin-right: 5px;',
					'onChange'=>'seleccionadosCargo()',
				)
					
			)
		);

		echo CJSON::encode($result);
	}

}