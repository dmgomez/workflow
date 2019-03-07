<script type="text/javascript">
$(document).ready(function(){
	//$('#departamento-form').submit(function( e ) {
	$( "#btnSubmit" ).on( "click", function(e) 
	{
		e.preventDefault();
		
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("datoAdicional/datoEnUso"); ?>',
	        type: "POST",
	        data: {id: $("#DatoAdicional_id_dato_adicional").val()},
	        dataType: 'json',
	        success: function(datos){  
	        	
	          	if(datos.enUso)
	          	{
	          		if (confirm('El dato adicional está en uso, se modificará para todos los procesos a los que está asociado. ¿Desea continuar?'))
					{
						$('#dato-adicional-form').submit();
					}
	          	}
	          	else
	          		$('#dato-adicional-form').submit();
	       }
	    }); 
	});
});

</script>
<?php
/* @var $this DatoAdicionalController */
/* @var $model DatoAdicional */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'dato-adicional-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id_dato_adicional'); ?>

	<?php echo $form->textFieldRow($model, 'nombre_dato_adicional', array('class'=>'span9', 'size'=>10, 'maxlength'=>100)); ?>
	
	<?php echo $form->dropDownListRow($model,'tipo_dato_adicional', CHtml::listData(TipoDato::model()->findAll(array('order' => 'nombre_tipo_dato')), 'id_tipo_dato','nombre_tipo_dato'), array('prompt'=>'--Seleccione--' /*'class'=>'span12'*/)); ?> 
	
	<?php //echo $form->dropDownListRow($model,'obligatorio', array('1' => 'Sí', '0' => 'No')); ?> 
	<?php //echo $form->textFieldRow($model, 'activo', array('class'=>'span3', 'size'=>10, 'maxlength'=>3)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->