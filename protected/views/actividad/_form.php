<script type="text/javascript">
$(document).ready(function(){
	$('#Actividad_codigo_actividad').blur(function(){

		$.ajax(
		{   

	        url: '<?php echo Yii::app()->createUrl("actividad/buscarCodigo"); ?>',
	        type: "POST",
	        data: {codigo: $("#Actividad_codigo_actividad").val(), idProceso: $("#Actividad_id_proceso").val(), idActividad: $("#Actividad_id_actividad").val()},
	        dataType: 'json',
	        success: function(data)
	        {  

	          	if(!data.success)
	          	{
					$('#Actividad_codigo_actividad').val('');
					$('#Actividad_codigo_actividad').focus();
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }
	    }); 
	});

	$( "#btnG" ).on( "click", function(e) 
	{
		e.preventDefault();

		$('#Actividad_btn').val(1);

		$('#actividad-form').submit();
	});

	$( "#btnGC" ).on( "click", function(e) 
	{
		e.preventDefault();
		$('#Actividad_btn').val(2);
		$('#actividad-form').submit();
	});
});
</script>


<?php
/* @var $this ActividadController */
/* @var $model Actividad */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'actividad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<!--<div class="row">	-->
		 <!--$this->form->hiddenField($this->model, $this->attribute, $this->htmlOptions);-->
		<?php echo $form->hiddenField($model, 'id_proceso', array('class'=>'span3', 'size'=>10,'maxlength'=>10, 'value'=>$idProceso)); ?>
		<?php echo $form->hiddenField($model,'id_actividad'); ?>
		<?php //echo $form->textFieldRow($model, 'id_proceso', array('class'=>'span3', 'size'=>10,'maxlength'=>10, 'value'=>$idProceso)); ?>
		<?php //echo $form->textFieldRow($model, 'id_empleado_asignacion', array('class'=>'span3', 'size'=>10,'maxlength'=>)); ?>
		<?php echo $form->textFieldRow($model, 'codigo_actividad', array('class'=>'span3', 'size'=>10,'maxlength'=>15)); ?>
		<?php echo $form->textAreaRow($model, 'nombre_actividad', array('class'=>'span10', 'maxlength'=>250)); ?>
		<?php echo $form->textAreaRow($model, 'descripcion_actividad', array('class'=>'span10', 'maxlength'=>250, 'rows'=>2)); ?>
		<?php echo $form->dropDownListRow($model,'id_departamento', CHtml::listData(Departamento::model()->findAll(array('order' => 'nombre_departamento', 'condition' => 'id_organizacion = '.$idOrganizacion)), 'id_departamento','nombre_departamento'), array('prompt'=>'--Seleccione--', 'class'=>'span4')); ?>
		<?php echo "<br><br>".$form->checkBox($model, 'es_inicial', array('value'=>1))." Es una actividad inicial."; ?>
		<?php echo $form->hiddenField($model, 'activo', array('class'=>'span3', 'size'=>10,'maxlength'=>10, 'value'=>1)); ?>

		<div class="data">
			<h2 class="data-title">Tiempo Estimado</h2>
			<div class="data-body">
				<table width="50%">
					<tr>
						<td>
							<?php //echo $form->labelEx($model, 'dias'); ?>
							<?php //echo $form->numberField($model, 'dias', array('class'=>'span1', 'onchange'=>'contar()'));?>

							 
							<div class="itemAyuda">
								<div class="itemLabel">
									<label>
										<?php echo $form->labelEx($model, 'dias'); ?> 
										<?php echo $form->numberField($model, 'dias', array('class'=>'span1', 'onchange'=>'contar()')); ?>
									</label>
									
								</div>
								<div class='tooltipAyuda help'>
				                    <span>?</span>
				                    <div class='content'>
					                    <b></b>
					                    <p>Representa la cantidad de días completos de jornada laboral.</p>
				                	</div>
				              	</div>
				            </div> 


							<br />
						</td>
						<td>
							<?php echo $form->labelEx($model, 'horas'); ?>
							<?php echo $form->numberField($model, 'horas', array('class'=>'span1', 'onchange'=>'contarH('.$horasLaborables.')'));?>
							<br />
						</td>
					</tr>
					<!--<tr><td><i>El campo "Días" representa la cantidad de días completos de jornada laboral</i></td></tr>-->
				</table>
			</div>
		</div>
		<?php echo $form->hiddenField($model, 'btn', array('class'=>'span3','maxlength'=>10)); ?>
	<!--</div>-->
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Guardar', array('id' => 'btnG', 'class'=>'btn-primary')); ?> &nbsp;&nbsp; <?php //echo CHtml::submitButton($model->isNewRecord ? 'Agregar y Configurar Actividad' : 'Guardar y Configurar Actividad', array('id' => 'btnGC', 'class'=>'btn-primary')); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
function contar() 
{
    var dias;
    dias = $('#Actividad_dias').val();
    
    if(dias>20)
    {
        $('#Actividad_dias').val(20);
    }
    else if(dias<0)
    {
        $('#Actividad_dias').val(0);
    }

}

function contarH(horasLaborables) 
{
    var horas;
    horas = $('#Actividad_horas').val();
    
    if(horas>horasLaborables)
    {
        $('#Actividad_horas').val(horasLaborables);
    }
    else if(horas<0)
    {
        $('#Actividad_horas').val(0);
    }

}
</script>

<style type="text/css">
input[type="number"]{
	height: auto;
	min-width: 3em;
}
input[type="text"]{
	height: auto;
} 
</style>
