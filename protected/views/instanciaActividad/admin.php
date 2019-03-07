<?php
/* @var $this InstanciaActividadController */
/* @var $model InstanciaActividad */

$this->breadcrumbs=array(
	'Actividades Pendientes',
);

$model->tit = new Titulo("Actividad en Ejecución", "Actividades Pendientes", "f");

/*
$this->menu=array(
	//array('label'=>'Listado de '.InstanciaActividad::getTitulo(false,false), 'url'=>array('admin')),
	array('label'=>'Agregar '.$model->tit->getTitulo(false,false), 'url'=>array('create')),
);
*/


?>

<h1> Registro de <?php echo $model->tit->getTitulo(false,true);  ?></h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php
$imgDir='/images/';
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'instancia-actividad-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>'function(id, data){configPopover();}',
	'columns'=>array(
		//'id_instancia_actividad',
		//'codigo_proceso',
		'codigo_instancia_proceso',
		'nombre_proceso',
		//'codigo_actividad',
		'nombre_actividad',
		'nombre_estado_actividad',
		'fecha_ini_estado_actividad_text',
	//	'inTime',
		//'hora_ini_estado_actividad_text',
		array(
            'name'=>'image',
            'type'=>'html',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'(!empty($data->image))?CHtml::image($data->image,"$data->observaciones",array("style"=>"width:18px;height:18px;cursor:pointer;", "class"=>"imgColum")):"no image"',

        ),

		/*
		'id_instancia_proceso',
		'observacion_instancia_proceso',
		'descripcion_proceso',
		'consecutivo_actividad',
		'fecha_fin_actividad',
		'hora_fin_actividad',
		'id_estado_actividad',
		'id_empleado',
		'id_persona',
		'cedula_persona',
		'nombre_persona',
		'apellido_persona',
		'id_actividad',
		'fecha_ini_estado_actividad',
		'hora_ini_estado_actividad',
		'observacion_instancia_actividad',
		'pendiente_asignacion',
		'ejecutada',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}',
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 5px;'),
				),
			)
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('instanciaActividad/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de búsqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>

<script type="text/javascript">
$( document ).ready(function() {

	//alert("hola");

	configPopover();

});

setTimeout('temporizador()', 15000);

function temporizador() {
	//$(document).ready(function()
	//{
		//configPopover();
		$('#instancia-actividad-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        setTimeout("temporizador()", 15000);
		//location.reload();
			//timer = setTimeout("temporizador()", 2000);

	//});
}

function ocultarPopover()
{
	$(".backg").click(function(){

		$(".imgColum").popover('hide');


	});
}

function configPopover()
{
	$('.imgColum').popover({
		placement: 'bottom',
		title: 'Tiempo Estimado Restante.',
		content: function(){ return $(this).attr("alt")}
	});



	$(".imgColum").click(function(){

	    $(".imgColum").not(this).popover('hide');
	    //$(this).popover('show');
	});



	$(".imgColum").mouseover(function(){

	    $(this).css('cursor', 'pointer');
	});
}


</script>