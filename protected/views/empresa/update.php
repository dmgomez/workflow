<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	//$model->id_empresa=>array('view','id'=>$model->id_empresa),
	$model->razon_social_empresa=>array('view','id'=>$model->id_empresa),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Ver Empresa', 'url'=>array('view', 'id'=>$model->id_empresa), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Empresa <?php echo $model->razon_social_empresa; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>