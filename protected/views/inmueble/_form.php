<?php
/* @var $this InmuebleController */
/* @var $model Inmueble */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'inmueble-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textAreaRow($model, 'direccion_inmueble', array('class'=>'span10', 'size'=>10, 'maxlength'=>250)); ?>
		
		<div class="control-group">
			<?php echo CHtml::activeLabel($model, '_municipio'); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, '_municipio', CHtml::listData(Municipio::model()->findAll(array('order' => 'nombre_municipio')), 'id_municipio', 'nombre_municipio'), 
					array('class' => 'span4', 'options' => array($idMunicipio=>array('selected'=>true)),
						'ajax' => array(
							'type' => 'post',
							'dataType'=>'json',
							'data'=>array('municipio'=> 'js:$("#Inmueble__municipio").val()', 'parroquiaId'=>'Inmueble_id_parroquia', 'parroquiaName'=>'Inmueble[id_parroquia]', 'class' => 'span4'),
							'url' => $this->createUrl('inmueble/getParroquias'),
							'success' => 'js:function(data) {
								$("#Inmueble_id_parroquia").replaceWith(data.parroquia);
							}'
					))); ?> 
			</div>
		</div>
		<?php //echo $form->textFieldRow($model, 'id_parroquia', array('class'=>'span3', 'size'=>10)); ?>



		<div class="control-group">
		<?php echo $form->labelEx($model, 'id_parroquia'); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'id_parroquia', CHtml::listData(Parroquia::model()->findAllByAttributes(array('id_municipio' => $idMunicipio)), 'id_parroquia', 'nombre_parroquia'), 
						array('prompt'=>'Seleccione', 'class' => 'span4', 'options' => array($model->id_parroquia => array('selected' => true)))); ?>
				<?php echo $form->error($model, 'id_parroquia'); ?>
			</div>
		</div>

	<div class="form-actions">
	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar')); ?>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->