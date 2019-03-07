<?php
$this->breadcrumbs=array(
	'Reporte',
);


?>

<h1>Reporte de Tiempos de Ejecución de Procesos</h1>

<?php $this->renderPartial('_form', array('idOrganizacion'=>$idOrganizacion, 'procesos'=>$procesos, 'model'=>$model)); ?>