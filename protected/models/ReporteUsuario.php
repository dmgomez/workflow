<?php


class ReporteUsuario extends CFormModel
{
	public $_organizacion;
	/*public $_departamento;
	public $_cargo;*/
	public $_empleadosSeleccionados;
	public $_chequearEmpleados;
	public $_tipoReporte;
	public $_fechaIni;
	public $_fechaFin;

	public function rules()
	{
		return array(
			array('_organizacion, _empleadosSeleccionados, _tipoReporte', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_organizacion' => 'Organización',
			//'_cargo' => 'Cargo',
			//'_departamento' => 'Departamento',
			'_empleadosSeleccionados' => 'Empleados seleccionados',
			'_tipoReporte' => 'Tipo de reporte',
			'_fechaIni' => 'Desde',
			'_fechaFin' => 'Hasta',
		);
	}

}