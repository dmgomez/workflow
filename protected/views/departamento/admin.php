<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos',
);

$model->tit = new Titulo("Departamento", "Departamentos", "m");

$this->menu=array(
	//array('label'=>'Listado de '.Departamento::getTitulo(false,false), 'url'=>array('admin')),
	array('label'=>'Agregar '.$model->tit->getTitulo(false,false), 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#departamento-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1> Registro de <?php echo $model->tit->getTitulo(false,true);  ?></h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'departamento-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{summary}{items}{pager}{summary}",
	'filter'=>$model,
	'columns'=>array(

		//array('name'=>'id_organizacion','value'=>'$data->organizacion->nombre_organizacion','type'=>'text',),
		//'nombre_departamento',
		array(
			'name' => 'id_organizacion',
			'value' => '$data->organizacion->nombre_organizacion',
			'htmlOptions'=>array('style' => 'width: 31%'),
		),
		array(
			'name' => 'nombre_departamento',
			'value' => '$data->nombre_departamento',
			'htmlOptions'=>array('style' => 'width: 31%'),
		),
		array(
            'name'=>'id_departamento_rel',
			'value' => '$data->getNombreDepartamentoRel()',
			'filter' => CHtml::dropDownList('Departamento[id_departamento_rel]', $model->id_departamento_rel, CHtml::listData(Departamento::model()->findAll(array('order'=>'nombre_departamento')),'id_departamento','nombre_departamento'), array('prompt'=>'-Seleccione-',)),
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'htmlOptions'=>array('style' => 'width: 7%'),
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar el registro?'),
					'url'=>'Yii::app()->createUrl("departamento/deleteGrid", array("id" => $data->id_departamento))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('departamento-grid');
								}

								showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
							}
						});

					}",
				),
			)
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	//'type'=>'inverse',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('departamento/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>