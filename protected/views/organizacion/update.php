<?php
/* @var $this OrganizacionController */
/* @var $model Organizacion */

$this->breadcrumbs=array(
	'Organizaciones'=>array('admin'),
	$model->nombre_organizacion=>array('view','id'=>$model->id_organizacion),
	'Modificar',
);

$this->menu=array(
	/*array('label'=>'Listado de Organizacion', 'url'=>array('admin')),
	array('label'=>'Agregar Organizacion', 'url'=>array('create')),*/
	array('label'=>'Ver Organización', 'url'=>array('view', 'id'=>$model->id_organizacion), 'icon'=>'icon-eye-open'),
	//array('label'=>'Administrar Organizacion', 'url'=>array('admin')),
);
?>

<h1>Modificar Organización: <?php echo $model->nombre_organizacion; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>