<?php
/* @var $this CabeceraReporteController */
/* @var $model CabeceraReporte */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_cabecera_reporte'); ?>
		<?php echo $form->textField($model,'id_cabecera_reporte'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ubicacion_logo'); ?>
		<?php echo $form->textField($model,'ubicacion_logo',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'titulo_reporte'); ?>
		<?php echo $form->textField($model,'titulo_reporte',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtitulo_1'); ?>
		<?php echo $form->textField($model,'subtitulo_1',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtitulo_2'); ?>
		<?php echo $form->textField($model,'subtitulo_2',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtitulo_3'); ?>
		<?php echo $form->textField($model,'subtitulo_3',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtitulo_4'); ?>
		<?php echo $form->textField($model,'subtitulo_4',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alineacion_titulos'); ?>
		<?php echo $form->textField($model,'alineacion_titulos',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->