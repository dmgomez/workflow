<?php
/* @var $this RolController */
/* @var $model Rol */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'rol-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<!--<div class="row">	-->
		<?php echo $form->textFieldRow($model, 'nombre_rol', array('class'=>'span4', 'maxlength'=>50)); ?>
		<?php echo $form->textAreaRow($model, 'descripcion_rol', array('class'=>'span10', 'maxlength'=>250, 'rows'=>2)); ?>

		
	<!--</div>-->
	<div class="form-actions">
	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->