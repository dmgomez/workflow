<?php


class ReporteEmpleado extends CFormModel
{
	public $_organizacion;
	public $_departamento;
	public $_cargo;
	public $_rol;
	public $_rol_sistema;
	public $_check_departamento;
	public $_check_cargo;
	public $_check_rol;
	public $_check_rol_sistema;
	public $_ordenar;
	public $_mostrar;
	public $_radio_ordenar;
	public $_radio_mostrar;
	public $_chequearDep;
	public $_chequearCargo;
	public $_chequearRol;
	public $_chequearRolSistema;


	public function rules()
	{
		return array(
			array('_organizacion, _cargo, _departamento, _rol, _rol_sistema, _ordenar, _mostrar', 'required'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'_organizacion' => 'Organización',
			'_cargo' => 'Cargos',
			'_departamento' => 'Departamentos',
			'_rol' => 'Roles',
			'_rol_sistema' => 'Roles del Sistema',
			'_ordenar' => 'Ordenar por',
			'_mostrar' => 'Mostrar',
		);
	}

}
