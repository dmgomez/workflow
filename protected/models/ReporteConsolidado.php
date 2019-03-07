<?php


class ReporteConsolidado extends CFormModel
{
	public $_procesosSeleccionados;
	public $_chequearProcesos;
	public $_fechaIni;
	public $_fechaFin;
	public $_tiempo;
	public $_mostrar;


	public function rules()
	{
		return array(
			array('_procesosSeleccionados, _fechaIni, _fechaFin', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_procesosSeleccionados' => 'Procesos Seleccionados',
			'_fechaIni' => 'Desde',
			'_fechaFin' => 'Hasta',
			'_tiempo' => 'Tiempo',
		);
	}

}
