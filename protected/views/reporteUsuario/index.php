<?php
$this->breadcrumbs=array(
	'Reporte de Actividades por Empleado',
);


?>

<h1>Reporte de Actividades por Empleado</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idOrganizacion'=>$idOrganizacion, 'empleados'=>$empleados, 'tipoReporte'=>$tipoReporte)); ?>