<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-lista-form',
	'enableAjaxValidation'=>false,
)); 
if(isset($modelDato))
{
	$model->id_dato_adicional = $modelDato->id_dato_adicional;
}

?>

	<p class="help-block">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_dato_adicional',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre_item_lista',array('class'=>'span8','maxlength'=>100)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
