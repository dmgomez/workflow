<?php
$this->breadcrumbs=array(
	'Listado de Proceso',
);


?>

<h1>Listado de Proceso</h1>

<?php $this->renderPartial('_form', array('procesos'=>$procesos, 'model'=>$model, 'idOrganizacion'=>$idOrganizacion)); ?>