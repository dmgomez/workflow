<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Consulta de Trámites',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#instancia-proceso-grid2').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1> Consulta de Trámites </h1>

<p>Seleccione el tipo de búsqueda que desea realizar</p>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Búsqueda Simple', 'url'=>Yii::app()->createUrl("instanciaProceso/adminConsulta")),
        array('label'=>'Búsqueda Avanzada', 'url'=>'#', 'active'=>true),
    ),
)); ?>

<div class="search-form">
<?php $this->renderPartial('_formBusquedaAvanzada', array('model'=>$model, 'datos'=>$datos, 'datosProceso'=>$datosProceso)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'instancia-proceso-grid2',
	'template'=>"{summary}{items}{pager}{summary}",
	//'dataProvider'=>$model,
	'dataProvider'=> $model->searchBusquedaAvanzada($_datoAdicional, $_valorDatoAdicional),
	'enableSorting' => false,
	//'filter'=>$model,
	'columns'=>array(
		'codigo_instancia_proceso',
		'nombreProceso',
		'id_estado_instancia_proceso'=>array(
			'name'=>'id_estado_instancia_proceso',
			'value'=>'$data->nombreEstado',
			//'filter'=>CHtml::listData(EstadoInstanciaProceso::model()->findAll(), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso') ,
			'htmlOptions'=>array('style'=>'width: 115px;'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>


<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('instanciaProceso/busquedaAvanzada'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>



