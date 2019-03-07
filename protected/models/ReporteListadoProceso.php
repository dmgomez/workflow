<?php


class ReporteListadoProceso extends CFormModel
{
	public $_procesosSeleccionados;
	public $_chequearProcesos;
	public $_organizacion;
	public $_mostrarActividades;
	public $_mostrarEmpleados;
	//public $_actividad;
	//public $_empleado;

	public function rules()
	{
		return array(
			array('_procesosSeleccionados', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_procesosSeleccionados' => 'Procesos Seleccionados',
			'_organizacion' => 'Organización'
		);
	}

}
