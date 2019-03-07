<script type="text/javascript">

$( document ).ready(function() {

	var actIni = $("#InstanciaProceso__actInic").val();
	$("#"+actIni).css("display", "");
	$("#R"+actIni).css("display", "");

	$("#InstanciaProceso__actInicAnt").val($("#InstanciaProceso__actInic").val());

	$( "#InstanciaProceso__actInic" ).on( "change", function(e) 
	{
		var actInicAnt = $("#InstanciaProceso__actInicAnt").val();
		$("#"+actInicAnt).css("display", "none");
		$("#R"+actInicAnt).css("display", "none");

		$("#InstanciaProceso__actInicAnt").val($("#InstanciaProceso__actInic").val());

		actInic = $("#InstanciaProceso__actInic").val();
		$("#"+actInic).css("display", "");
		$("#R"+actInic).css("display", "");
	});
	

});

</script>

<style type="text/css">

/*div.flash-errorForm
{
	padding:.8em;
	margin-bottom:1em;
	border:1px solid #ddd;
	border-radius: 0.3em;

	background:#FBE3E4;
	color:#8a1f11;
	border-color:#FBC2C4;
}

div.flash-errorForm a
{
	color:#8a1f11;
}*/
</style>

<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'instancia-proceso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_proceso', array('value'=>$idProceso)); ?>

	<?php echo $form->hiddenField($model, 'id_usuario', array('value'=>Yii::app()->user->id_usuario)); ?>

	<?php echo $form->dropDownListRow($model,'_actInic', CHtml::listData(Actividad::model()->findAll('id_proceso = '.$idProceso.' AND es_inicial = 1'), 'id_actividad','nombre_actividad'), array('class'=>'span4')); ?>

	<?php echo $form->hiddenField($model,'_actInicAnt', array('value'=>$model->_actInic)); ?>

	<!-- HISTORIALES Y ACTUALIZACION DE RECAUDOS Y DATOS ADICIONALES -->
	<?php
	//$acordeon = 
	$this->widget('zii.widgets.jui.CJuiAccordion',array(
	    'panels'=>array(
	        'Recaudos'=>$this->renderPartial('_recaudosConsignados', array('form'=>$form, 'model'=>$model, 'recaudo'=>$recaudo), true),
	        'Datos Adicionales'=>$this->renderPartial('_datosAdicionales', array('form'=>$form, 'model'=>$model, 'datoAdicional'=>$datoAdicional), true),
	    ),
	    // additional javascript options for the accordion plugin
	    'options'=>array(
	        'collapsible'=> true,
	        'animated'=>'bounceslide',
	        'autoHeight'=>false,
	        'active'=>false,
	    ),
	)/*, true*/);
	?>
	<br>
	<?php echo $form->textFieldRow($model, 'codigo_instancia_proceso', array('class'=>'span4', 'size'=>10, 'maxlength'=>50, 'readonly'=>'readonly', 'value'=>$codProc)); ?>

	<?php //echo $form->dropDownListRow($model,'id_estado_instancia_proceso', CHtml::listData(EstadoInstanciaProceso::model()->findAll(/*array('order'=>'nombre_estado_instancia_proceso')*/), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso'), array('class'=>'span4', 'disable'=>'disable', 'options' => array($estado=>array('selected'=>true)))); ?>
	<?php echo CHtml::label('Estado del Trámite', ''); ?>
	<?php echo CHtml::telField('Estado Trámite', 'Pendiente', array('class'=>'span4', 'readonly'=>'readonly')); ?>
	<?php echo $form->hiddenField($model, 'id_estado_instancia_proceso', array('class'=>'span4', 'readonly'=>'readonly', 'value'=>$estado)); ?> 

		

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Iniciar' : 'Actualizar')); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->