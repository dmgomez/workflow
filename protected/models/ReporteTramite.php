<?php


class ReporteTramite extends CFormModel
{
	public $_codigo;



	public function rules()
	{
		return array(
			array('_codigo', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_codigo' => 'Código del Trámite',
		);
	}

}
