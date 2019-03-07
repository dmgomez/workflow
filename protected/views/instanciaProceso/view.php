<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Consulta de Trámites'=>array('adminConsulta'),
	$model->codigo_instancia_proceso,
);

$this->menu=array(
	array('label'=>'Consulta de Trámites', 'url'=>array('adminConsulta'), 'icon' => 'icon-list'),
	
);
?>

<h1>Trámite: <?php echo $model->codigo_instancia_proceso; ?></h1>


<?php
$status = false;

if(Yii::app()->user->isSuperAdmin || Funciones::usuarioEsJefeDepartamento() || Funciones::usuarioEsDirector())
	$status = true;

$visible = false;

if($model->fecha_fin_proceso != '1900-01-01')
	$visible = true;

//EL CAMPO es_reconsideración no existe en este sistema / optimizacion
/*$reconsideracion = false;
if($model->es_reconsideracion == 1)
	$reconsideracion = true;*/
/*$reconsideracion = false;
if($model->fecha_ini_reconsideracion != null)
	$reconsideracion = true;

$finReconsideracion = false;
if($model->fecha_fin_reconsideracion != null)
	$finReconsideracion = true;
*/
$anulado = false;
if($model->fecha_anulacion != null)
	$anulado = true;
?>


<?php
/*if($reconsideracion)
	echo "<h2>(Recurso de Reconsideración)</h2>";*/
?>
<br>

<?php $detailProceso = $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo_instancia_proceso',
		'nombreProceso',
		array('name' => 'fecha_ini_proceso', 'value' => Funciones::invertirFecha($model->fecha_ini_proceso)),
		array('name' => 'fecha_fin_proceso', 'value' => Funciones::invertirFecha($model->fecha_fin_proceso), 'visible'=>$visible),
		array('name' => 'fecha_anulacion', 'value' => Funciones::invertirFecha($model->fecha_anulacion), 'visible'=>$anulado),
		array('name' => 'Estado del Trámite', 'value' => $model->nombreEstado),
		//array('name' => 'fecha_ini_reconsideracion', 'value' => Funciones::invertirFecha($model->fecha_ini_reconsideracion), 'visible'=>$reconsideracion),
		//array('name' => 'fecha_fin_reconsideracion', 'value' => Funciones::invertirFecha($model->fecha_fin_reconsideracion), 'visible'=>$finReconsideracion),
		//array('name' => 'Tipo de Solicitud', 'value' => $model->nombreTipoSolicitante()),
		//array('name' => 'Solicitante', 'value' => $model->nombre_solicitante),
		//array('name' => 'Cédula del Solicitante', 'value' => $model->cedula_solicitante), //NO EXISTE EL CAMPO, SI SE AGREGA, VALIDAR EN "INICIAR TRAMITES"
		//array('name' => 'Teléfono del Solicitante', 'value' => $model->telefono_solicitante),
		//array('name' => 'Correo Electrónico del Solicitante', 'value' => $model->correo_solicitante),
		//'correo_solicitante',
		//'direccionInmueble',
		//'parroquiaInmueble',
		array('name' => 'Actividad Actual', 'value' => $model->actividadesPendientes()),
		array('name' => 'Empleado Actividad Actual', 'value' => $model->empleadoActividad(), 'visible'=>$status),
	),
), true); ?>








<?php $gridObservaciones = $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'vis-observacion-grid',
	//'ajaxUpdate'=>'false',
	'dataProvider'=>$modelObsActs,
	'columns'=>array(
		'nombre',
		array(
			'name'=>'empleado', 
			'value'=>'$data->empleado',
			'visible'=>$status
		),
		'observacion',
		array(
			'name'=>'fecha',
			'value'=>'$data->fecha',
			'htmlOptions'=>array('style' => 'width: 10%'),
		),
		array(
			'name'=>'hora',
			'value'=>'$data->hora',
			'htmlOptions'=>array('style' => 'width: 8%'),
		),
	),
), true); ?>

<?php $gridDatos = $this->widget('bootstrap.widgets.TbGridView', array(
  	'type'=>'striped bordered condensed',
  	'id'=>'vis-dato-grid',
  	//'ajaxUpdate'=>'false',
  	'dataProvider'=>$modelHistDatos,
  	'columns'=>array(
    	'nombre_dato_adicional',
    	'valor_dato_adicional',
  	),
), true); ?>

<?php $gridArchivos = $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
  'id'=>'vis-dato-grid',
  'dataProvider'=>$modelHistArchivos,
  'columns'=>array(
    'nombre_dato_adicional',
    array(
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'template'=>'{link}',
      'buttons'=>array(

        'link'=>array(
          'label'=>'Enlace',
          'icon'=>'icon-file',
          'url'=>'Yii::app()->request->baseUrl."/files/$data->valor_dato_adicional"',
          'click' => "function(e){

            e.preventDefault();

            window.open($(this).attr('href'),'_blank');

          }",
        ),
      )
    ),


  ),
), true); ?>

<?php $this->widget("bootstrap.widgets.TbTabs", array(
    "id" => "tabs",
    "type" => "tabs",
    "tabs" => array(
        array("label" => "Ver Trámite", "content" => $detailProceso, "active" => true, "icon" => "icon-info-sign"),
        array("label" => "Observaciones", "content" => $gridObservaciones, "active" => false, "icon" => "icon-comment"),
        array("label" => "Datos Adicionales", "content" => $gridDatos, "active" => false, "icon" => "icon-plus-sign"),
        array("label" => "Archivos", "content" => $gridArchivos, "active" => false, "icon" => "icon-plus-sign")
    ),
 
)); ?>
 <br>
