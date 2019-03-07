<script type="text/javascript">
$(document).ready(function(){
	$('#Proceso_codigo_proceso').blur(function(){

		$.ajax(
		{   

	        url: '<?php echo Yii::app()->createUrl("proceso/buscarCodigo"); ?>',
	        type: "POST",
	        data: {codigo: $("#Proceso_codigo_proceso").val(), idProc: $("#Proceso_id_proceso").val()},
	        dataType: 'json',
	        success: function(data)
	        {  

	          	if(!data.success)
	          	{
					$('#Proceso_codigo_proceso').val('');
					$('#Proceso_codigo_proceso').focus();
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }
	    }); 
	});
});
</script>
<?php
/* @var $this ProcesoController */
/* @var $model Proceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'proceso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_proceso'); ?>

	<!--<div class="row">-->
		<?php $organizacionModel = Organizacion::model();  ?>
		<?php //echo $form->labelEx($organizacionModel,'Nombre Organizacion'); ?>
		<?php echo $form->dropDownListRow($model,'id_organizacion', CHtml::listData($organizacionModel->findAll(),'id_organizacion','nombre_organizacion')); ?>

		<?php echo $form->textFieldRow($model, 'codigo_proceso', array('class'=>'span3', 'size'=>10,'maxlength'=>15)); ?>
		<?php echo $form->textAreaRow($model, 'nombre_proceso', array('class'=>'span10', 'maxlength'=>250)); ?>
		<?php echo $form->textAreaRow($model, 'descripcion_proceso', array('class'=>'span10', 'maxlength'=>250, 'rows'=>2)); ?>		
	<!--</div>-->
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->