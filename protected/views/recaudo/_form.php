<script type="text/javascript">
$(document).ready(function(){
	//$('#departamento-form').submit(function( e ) {
	$( "#btnSubmit" ).on( "click", function(e) 
	{
		e.preventDefault();
		
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("recaudo/recaudoEnUso"); ?>',
	        type: "POST",
	        data: {id: $("#Recaudo_id_recaudo").val()},
	        dataType: 'json',
	        success: function(datos){  
	        	
	          	if(datos.enUso)
	          	{
	          		if (confirm('El recaudo está en uso, se modificará para todos los procesos a los que está asociado. ¿Desea continuar?'))
					{
						$('#recaudo-form').submit();
					}
	          	}
	          	else
	          		$('#recaudo-form').submit();
	       }
	    }); 
	});
});

</script>
<?php
/* @var $this RecaudoController */
/* @var $model Recaudo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'recaudo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id_recaudo'); ?>

	<?php echo $form->textAreaRow($model, 'nombre_recaudo', array('class'=>'span10', 'maxlength'=>250)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->