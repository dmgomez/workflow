<?php
$this->breadcrumbs=array(
	'ReporteEmpleados',
);

?>

<h1>Listado de Empleados</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idOrganizacion'=>$idOrganizacion, 'departamentos'=>$departamentos, 'cargos'=>$cargos, 'roles'=>$roles, 'rolesSistema'=>$rolesSistema)); ?>