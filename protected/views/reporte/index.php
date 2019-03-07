<?php
$this->breadcrumbs=array(
	'Reporte',
);


?>

<h1>Reporte de Ejecución de Actividades</h1>

<?php $this->renderPartial('_form', array('procesos'=>$procesos, 'model'=>$model)); ?>