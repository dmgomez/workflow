<?php
$this->breadcrumbs=array(
	'Cabecera de Reportes'=>array('index'),
);

$this->menu=array(
	array('label'=>'Modificar Configuración de Reportes','url'=>array('create')),
);
?>

<h1>Configuración de Reportes </h1><br>

<div width="100%">
<?php
$cabecera = Funciones::generarCabecera($model->ubicacion_logo, $model->titulo_reporte, $model->subtitulo_1, $model->subtitulo_2, $model->subtitulo_3, $model->subtitulo_4, $model->alineacion_titulos);
echo $cabecera;
?>
</div>
<br><br>

<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>