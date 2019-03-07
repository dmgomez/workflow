<?php
/* @var $this CabeceraReporteController */
/* @var $model CabeceraReporte */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cabecera-reporte-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>


	<?php
	 //if(Yii::app()->user->hasFlash("error_imagen"))
	 //{?>
		<!--<div class="errorForm"> <?php //echo Yii::app()->user->getFlash("error_imagen"); ?> </div>-->
	<?php //}
	?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->labelEx($model, '_imagenLogo'); ?>
	<?php echo $form->fileField($model, '_imagenLogo'); ?>
	<?php echo $form->error($model, '_imagenLogo'); ?>
	<div>&nbsp;</div>
		<?php echo $form->textFieldRow($model, 'titulo_reporte', array('class'=>'span5', 'maxlength'=>45)); ?>
		<?php echo $form->textFieldRow($model, 'subtitulo_1', array('class'=>'span5', 'maxlength'=>45)); ?>
		<?php echo $form->textFieldRow($model, 'subtitulo_2', array('class'=>'span5', 'maxlength'=>45)); ?>
		<?php echo $form->textFieldRow($model, 'subtitulo_3', array('class'=>'span5', 'maxlength'=>45)); ?>
		<?php echo $form->textFieldRow($model, 'subtitulo_4', array('class'=>'span5', 'maxlength'=>45)); ?>
		<?php echo $form->dropDownListRow($model,'alineacion_titulos', array('left' => 'Izquierda', 'center' => 'Centrada', 'right' => 'Derecha'), array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar')); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->