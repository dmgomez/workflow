<?php


class Tramite extends CFormModel
{
	public $_actividad;
	public $_check_actividad;


	public function rules()
	{
		return array(
			array('_actividad, _check_actividad', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_actividad' => 'Actividades',
			'_check_actividad' => 'Actividades',
	
		);
	}

}
