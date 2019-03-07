<link href="<?= Yii::app()->request->baseUrl ?>/css/graph/jquery-ui-1.10.4.css" rel="stylesheet">
<link href="<?= Yii::app()->request->baseUrl ?>/css/graph/graph.css" rel="stylesheet">
<?php
/* @var $this ProcesoController */
/* @var $model Proceso */

$this->breadcrumbs=array(
	'Procesos'=>array('admin'),
	$model->codigo_proceso=>array('view', 'id'=>$model->id_proceso),
	'Modelado',
);

$this->menu=array(
	array('label'=>'Registro de Proceso', 'url'=>array('admin'), 'icon' => 'icon-list'),
	array('label'=>'Agregar Actividad', 'url'=>array('actividad/create', 'idProceso'=>$model->id_proceso, 'codigoProceso'=>$model->codigo_proceso, 'nombreProceso'=>$model->nombre_proceso), 'icon' => 'icon-plus'),
);
?>
<h1>Modelar Proceso: <?php echo $model->codigo_proceso." - ".$model->nombre_proceso ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo_proceso',
		'nombre_proceso',
		'descripcion_proceso',
	),
)); 
?>
Tamaño del Grid:
<?= CHtml::numberField('nombre', 500, ['id' => 'canvas-size']) ?>
<a href="#modal-actividad" role="button" class="btn" data-toggle="modal" style="float: right;">Agregar Actividad</a>

<?php $this->renderPartial('_seleccionarActividad', ['modeloEstadoActividadModel' => $modeloEstadoActividadModel, 'actividadOrigen' => $actividadOrigen, 'labelActividad' => $labelActividad]); ?>
<?php $this->renderPartial('_seleccionarEstados', ['estadoSalida' => $estadoSalida, 'estadoInicial' => $estadoInicial, 'labelEstadoSalida' => $labelEstadoSalida, 'labelEstadoInicio' => $labelEstadoInicio]); ?>
<?php $this->renderPartial('_cargando'); ?>


<div class="row-fluid">
    <div id="viewPort" class="control-group">
        <div id="canvas" class="diagramContainer">
            <div id="inicio" class="circleBase type2 arrastrable">
                <strong>INICIO</strong>
            </div>
            
            
            <div id="fin" class="circleBase type2 arrastrable" style="top: 200px;">
                <strong>FIN</strong>
            </div>
            
        </div>
    </div>
</div>
<div class="row-fluid" style="float: right;">
    <div class="slider slim sliderMax"></div>
	<div class="field_notice">Zoom: <span class="must sliderMaxLabel">100%</span></div>
</div>

<input id="Proceso_id_proceso" type="hidden" value="<?= $model->id_proceso ?>"/>
<input id="urlBuscarRecaudos" type="hidden" value="<?= Yii::app()->createUrl("proceso/BuscarRecaudos") ?>" />
<input id="urlBuscarDatosAdicionales" type="hidden" value="<?= Yii::app()->createUrl("proceso/BuscarDatosAdicionales") ?>" />
<input id="urlEliminarTransicionAjax" type="hidden" value="<?= Yii::app()->createUrl("proceso/EliminarTransicionAjax") ?>" />
<input id="urlModelarProcesoAjax" type="hidden" value="<?= Yii::app()->createUrl("proceso/ModelarProcesoAjax") ?>" />
<input id="urlAsignarActividadComoInicialAjax" type="hidden" value="<?= Yii::app()->createUrl("proceso/AsignarActividadComoInicialAjax") ?>" />
<input id="urlAsignarActividadComoNoInicialAjax" type="hidden" value="<?= Yii::app()->createUrl("proceso/AsignarActividadComoNoInicialAjax") ?>" />
<input id="ModeloEstadoActividad__idDatos" type="hidden"/>
<input type="hidden" id="actividad-inicial"/>
<input type="hidden" id="urlBuscarActividadesPorProceso" value="<?= Yii::app()->createUrl("proceso/GetModeloByProceso") ?>" />

<script src="<?= Yii::app()->request->baseUrl ?>/js/jsPlumb-2.0.4.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/js/graph.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/js/adicionales.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/js/jquery-ui-1.10.4.min.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/js/slider.js"></script>