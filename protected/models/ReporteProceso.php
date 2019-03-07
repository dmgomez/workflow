<?php


class ReporteProceso extends CFormModel
{
	public $_proceso;
	public $_fechaIni;
	public $_fechaFin;
	public $_organizacion;
	

	public function rules()
	{
		return array(
			array('_procesoSeleccionado, _fechaIni, _fechaFin, _organizacion, _proceso', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_proceso' => 'Proceso',
			'_fechaIni' => 'Desde',
			'_fechaFin' => 'Hasta',
			'_organizacion' => 'Organización',
		);
	}

}
