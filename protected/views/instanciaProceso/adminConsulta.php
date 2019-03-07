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
	$('#instancia-proceso-consulta-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id='render'>

	<h1> Consulta de Trámites </h1>

	<p>Seleccione el tipo de búsqueda que desea realizar</p>

	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
	    'stacked'=>false, // whether this is a stacked menu
	    'items'=>array(
	        array('label'=>'Búsqueda Simple', 'url'=>'#', 'active'=>true),
	        array('label'=>'Búsqueda Avanzada', 'url'=>Yii::app()->createUrl("instanciaProceso/busquedaAvanzada")),
	    ),
	)); ?>

	<p>
		Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
	</p>

	<div id="instancia-proceso-grid-labels" class="grid-view">
		<table class="items table table-striped table-bordered table-condensed">
			<thead>
				<tr>
					<th id="instancia-proceso-grid_c0">Búsqueda</th>
					<th id="instancia-proceso-grid_c1">Estado</th>
				</tr>
				<tr class="filters">
					<td>
						<div class="filter-container">
							<?php
							if(isset($busqueda))
								$busq=$busqueda;
							else
								$busq="";
							?>
							<?php echo CHtml::textField('busq', $busq,
								array(//'id'=>'idTextField', 
							       'width'=>100, 
							       'onkeypress'=>'validar(event)')); ?> 
						</div>
					</td>
					<td>
						<div class="filter-container">
							<?php
							if(isset($estado))
								echo CHtml::dropDownList('id', 'id_estado_instancia_proceso', CHtml::listData(EstadoInstanciaProceso::model()->findAll(), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso'), array(/*'class'=>'span4',*/ 'prompt'=>'Todos', 'onChange'=>'estadoSelect()', 'options' => array($estado=>array('selected'=>true)))); 
							else
								echo CHtml::dropDownList('id', 'id_estado_instancia_proceso', CHtml::listData(EstadoInstanciaProceso::model()->findAll(), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso'), array(/*'class'=>'span4',*/ 'prompt'=>'Todos', 'onChange'=>'estadoSelect()'/*, 'options' => array($estado=>array('selected'=>true))*/)); 
							//	echo CHtml::dropDownList('id', 'id_estado_instancia_proceso', array(''=>'Todos', CHtml::listData(EstadoInstanciaProceso::model()->findAll(), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso') ), array(/*'class'=>'span4',*/ 'onChange'=>'estadoSelect()',/*, 'options' => array($estado=>array('selected'=>true))*/)); 
							?>
						</div>
					</td>
				</tr>
			</thead>
		</table>
	</div>

	<?php $this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped bordered condensed',
		'id'=>'instancia-proceso-grid',
		'template'=>"{summary}{items}{pager}{summary}",
		'dataProvider'=>$model,
		'enableSorting'=>false,
		'columns'=>array(
			'codigo_instancia_proceso',
			'nombreProceso',
			'id_estado_instancia_proceso'=>array(
				'name'=>'id_estado_instancia_proceso',
				'value'=>'$data->nombreEstado',
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
		'url'=>$this->createUrl('instanciaProceso/adminConsulta'),
		'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
	));?>

	<div>&nbsp;</div>
	<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
	); ?>


</div>


<script type="text/javascript">
function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
  {
  	$.ajax({
        url: '<?php echo Yii::app()->createUrl('instanciaProceso/renderizarGrid'); ?>',
        data: {busqueda: $('#busq').val(), estado: $('#id').val()},
        type: 'POST',
        success: function(data) {
            $('#render').html(data);
        }
    });
  }
}

function estadoSelect()
{
	$.ajax({
        url: '<?php echo Yii::app()->createUrl('instanciaProceso/renderizarGrid'); ?>',
        data: {busqueda: $('#busq').val(), estado: $('#id').val()},
        type: 'POST',
        success: function(data) {
            $('#render').html(data);
        }
    });
}
</script>
