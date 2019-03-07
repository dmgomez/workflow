<?php
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('admin'),
	$model->nacionalidad_persona."-".$model->cedula_persona=>array('view','id'=>$model->id_persona),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Ver Persona', 'url'=>array('view', 'id'=>$model->id_persona), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Persona <?php echo $model->nacionalidad_persona."-".$model->cedula_persona; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>