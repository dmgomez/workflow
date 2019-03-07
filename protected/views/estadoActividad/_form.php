<?php
/* @var $this EstadoActividadController */
/* @var $model EstadoActividad */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'estado-actividad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'nombre_estado_actividad', array('class'=>'span5', 'maxlength'=>50)); ?>

	<div class="form-actions">	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->