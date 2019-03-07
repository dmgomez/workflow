<?php
$this->breadcrumbs=array(
	'Reporte Consolidado de Procesos',
);


?>

<h1>Reporte Consolidado de Procesos</h1>

<?php $this->renderPartial('_form', array('procesos'=>$procesos, 'model'=>$model)); ?>