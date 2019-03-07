<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'instancia-proceso-anular-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textAreaRow($model, 'observacion_anulacion', array('class'=>'span10', 'rows'=>'9', 'maxlength'=>1000)); ?> 	


	<div class="form-actions">
		<?php	
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'size'=>'medium',
			'label'=>'Anular Proceso',
		));	
		?>
	</div>

<?php $this->endWidget(); ?>