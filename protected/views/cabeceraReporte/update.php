<?php
/* @var $this CabeceraReporteController */
/* @var $model CabeceraReporte */

$this->breadcrumbs=array(
	'Cabecera Reportes'=>array('admin'),
	$model->id_cabecera_reporte=>array('view','id'=>$model->id_cabecera_reporte),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listado de CabeceraReporte', 'url'=>array('admin')),
	array('label'=>'Agregar CabeceraReporte', 'url'=>array('create')),
	array('label'=>'Ver CabeceraReporte', 'url'=>array('view', 'id'=>$model->id_cabecera_reporte)),
	//array('label'=>'Administrar CabeceraReporte', 'url'=>array('admin')),
);
?>

<h1>Modificar CabeceraReporte <?php echo $model->id_cabecera_reporte; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>