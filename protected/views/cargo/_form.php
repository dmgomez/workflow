<?php
/* @var $this CargoController */
/* @var $model Cargo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'cargo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php $organizacionModel = Organizacion::model();  ?>
	<?php echo $form->dropDownListRow($model,'id_organizacion', CHtml::listData($organizacionModel->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion','nombre_organizacion'), array('class' => 'span5')); ?>
	
	<?php echo $form->textFieldRow($model, 'nombre_cargo', array('class'=>'span5', 'maxlength'=>50)); ?>

	<?php echo $form->textAreaRow($model,'descripcion_cargo',array('class'=>'span10','maxlength'=>250, 'rows'=>2)); ?>

	<?php echo $form->hiddenField($model, 'activo', array('class'=>'span3', 'size'=>10,'maxlength'=>10, 'value'=>1)); ?>

	<div class="form-actions">	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->