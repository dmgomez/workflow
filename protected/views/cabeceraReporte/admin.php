<?php
/* @var $this CabeceraReporteController */
/* @var $model CabeceraReporte */

$this->breadcrumbs=array(
	'Cabecera Reportes',
);

$this->menu=array(
	//array('label'=>'Listado de '.CabeceraReporte::getTitulo(false,false), 'url'=>array('admin')),
	array('label'=>'Agregar '.CabeceraReporte::getTitulo(false,false), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cabecera-reporte-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>  <?php echo CabeceraReporte::getTitulo(false,true);  ?></h1>

<!--
<p>
Opcionalmente puede incluir operadores de comparación (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) al principio de las cajas de texto de búsqueda para especificar cómo debe hacerse la misma.
</p>
-->

<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'cabecera-reporte-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_cabecera_reporte',
		'ubicacion_logo',
		'titulo_reporte',
		'subtitulo_1',
		'subtitulo_2',
		'subtitulo_3',
		/*
		'subtitulo_4',
		'alineacion_titulos',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
