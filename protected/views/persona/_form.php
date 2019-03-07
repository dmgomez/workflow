<script type="text/javascript">
$(document).ready(function(){
	$('#Persona_cedula_persona').blur(function(){

		$.ajax(
		{   

	        url: '<?php echo Yii::app()->createUrl("persona/buscarCedula"); ?>',
	        type: "POST",
	        data: {cedula: $("#Persona_cedula_persona").val(), nacionalidad: $("#Persona_nacionalidad_persona").val()},
	        dataType: 'json',
	        success: function(data)
	        {  

	          	if(!data.success)
	          	{
					$('#Persona_cedula_persona').val('');
					$("#Persona_nacionalidad_persona").val('V');
					$('#Persona_cedula_persona').focus();
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }
	    }); 
	});
});
</script>
<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'persona-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldRow($model, 'nombre_persona', array('class'=>'span5', 'maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model, 'apellido_persona', array('class'=>'span5', 'maxlength'=>50)); ?>

		<?php echo $form->dropDownListRow($model,'nacionalidad_persona', array('V' => 'V', 'E' => 'E'), array('class'=>'span1')); ?>

		<?php echo $form->textFieldRow($model,'cedula_persona',array('class'=>'span2', 'maxlength'=>15)); ?>

		<?php echo $form->textAreaRow($model,'direccion_persona',array('class'=>'span10','maxlength'=>150, 'rows'=>2)); ?>

		<?php echo $form->textFieldRow($model,'telefono_hab_persona',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617000000')); ?>

		<?php echo $form->textFieldRow($model,'telefono_cel_persona',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 04149999999')); ?>

		<?php echo $form->textFieldRow($model,'telefono_aux_persona',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617111111')); ?>

		<?php echo $form->textFieldRow($model, 'correo_persona', array('class'=>'span5', 'maxlength'=>50, 'placeholder'=>'Ej: persona@ejemplo.com')); ?>

	<div class="form-actions">	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->