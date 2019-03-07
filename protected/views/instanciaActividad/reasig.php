<?php
/* @var $this InstanciaActividadController */
/* @var $model InstanciaActividad */

$this->breadcrumbs=array(
	'Reasignación de Actividades',
);

$model->tit = new Titulo("Reasignación de Actividades", "Reasignación de Actividades", "f");

/*
$this->menu=array(
	//array('label'=>'Listado de '.InstanciaActividad::getTitulo(false,false), 'url'=>array('admin')),
	array('label'=>'Agregar '.$model->tit->getTitulo(false,false), 'url'=>array('create')),
);
*/

?>

<h1> Reasignación de Actividades</h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php
$imgDir='/images/';
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'instancia-actividad-grid',
	'dataProvider'=>$model->searchReasig(),
	'filter'=>$model,
	'afterAjaxUpdate'=>'function(id, data){configPopover();}',
	'columns'=>array(
		'codigo_instancia_proceso',
		'nombre_proceso',
		'nombre_actividad',
		'nombre_estado_actividad',
		//'nombre_parroquia',
		//'nombre_solicitante',
		'fecha_ini_estado_actividad_text',
		//'nombre_empleado',
		'id_persona'=>array(
			'name'=>'id_persona',
			'value'=>'$data->nombre_empleado',
			//'filter'=>CHtml::listData(Empleado::model()->findAll(array('condition' => 'superior_inmediato = '.$idEmpleado.' or id_empleado = '.$idEmpleado)), 'id_persona','nombreEmpleado')
			'filter'=>CHtml::listData($empleado, 'id_persona','nombreEmpleado')
		),
		 array( 
              'class' => 'editable.EditableColumn',
              'name' => 'id_empleado',
              'filter' => false,
              'headerHtmlOptions' => array('style' => 'width: 100px'),
              'editable' => array(
                  'type'     => 'select',
                  'url'      => $this->createUrl('instanciaActividad/updateRecord'),
                 //'source'    => $this->createUrl('instanciaActividad/getEmpleadoAsig'),
                 
                 //source url can depend on some parameters, then use js function:
                 
                 
                 'source' => 'js: function() {
                      var id = $(this).data("id_instancia_actividad");
                      return "?r=instanciaActividad/getEmpleadoAsig&id="+id;
                 }',
                 
                 'htmlOptions' => array(
                     'data-id_instancia_actividad' => '$data->id_instancia_actividad'
                 ),
                  //onsave event handler 
                 'onSave' => 'js: function(e, params) {
                      console && console.log("saved value: "+params.newValue);
                      	$("#instancia-actividad-grid").yiiGridView("update", {
				            data: $(this).serialize()
				        });
                 }',
                 
                                  
              )
         ),
		array(
            'name'=>'image',
            'type'=>'html',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'(!empty($data->image))?CHtml::image($data->image,"$data->observaciones",array("style"=>"width:18px;height:18px;cursor:pointer;", "class"=>"imgColum")):"no image"',

        ),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('instanciaActividad/reasig'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de búsqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(5000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>

<script type="text/javascript">
$( document ).ready(function() {

	//alert("hola");

	configPopover();

});


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