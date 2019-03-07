<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'proceso-recaudo-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

	<?php //echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_proceso',array('class'=>'span5', 'value'=>$idProceso)); ?>

	<?php echo $form->hiddenField($model,'id_recaudo',array('class'=>'span5')); ?>

	<!--<p>Utilice el botón "Examinar" para buscar un recaudo en la lista.</p>-->
	<div class="control-group">
		<div class="controls">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'button',
				//'type'=>'inverse',
				//'size'=>'medium',
				'label'=>'Examinar',
				'htmlOptions'=>array('title'=>'Busca un recaudo en una tabla.', 'data-toggle' => 'modal', 'data-target' => '#buscar-recaudo'),
			)); ?>
			&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'button',
				//'type'=>'inverse',
				//'size'=>'medium',
				'label'=>'Restablecer',
				'htmlOptions'=>array('title'=>'Restablece el campo.', 'onclick'=>'restablecerCampos()'),
			)); ?>
		</div>
	</div>

	<?php echo $form->textAreaRow($model,'nombreRecaudo',array('class'=>'span8', 'rows'=>'3', 'maxlength'=>250, 'readonly'=>$model->isNewRecord ? '' : 'readonly')); ?>

	<div class="control-group">
		<div class="controls">
			<?php echo $form->checkBox($model, 'obligatorio', array('value'=>1))." Obligatorio."; ?>
		</div>
	</div>
	<?php //echo $form->textFieldRow($model,'obligatorio',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit')
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'buscar-recaudo', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('grid_buscar_recaudo', array('model' => new Recaudo())); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	function restablecerCampos()
	{
		$('#ProcesoRecaudo_nombreRecaudo').val('');
		$('#ProcesoRecaudo_id_recaudo').val('');
		$('#ProcesoRecaudo_nombreRecaudo').attr('readonly', false);
	}
</script>