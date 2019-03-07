<script type="text/javascript">
$(document).ready(function(){
	//$('#departamento-form').submit(function( e ) {
	$( "#btnSubmit" ).on( "click", function(e) 
	{
		e.preventDefault();
		
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("departamento/BuscarDepartamnento"); ?>',
	        type: "POST",
	        data: {departamento: $("#Departamento_nombre_departamento").val(), departamento_rel: $("#Departamento_id_departamento_rel").val(), organizacion: $("#Departamento_id_organizacion").val(), idDep: $("#departamentoAct").val()},
	        dataType: 'json',
	        success: function(datos){  
	        	
	          	if(!datos.success)
	          	{
	          		if (confirm('Nombre Departamento se duplicará. ¿Desea continuar?'))
					{
						$('#departamento-form').submit();
					}
	          	}
	          	else
	          		$('#departamento-form').submit();
	       }
	    }); 
	});
});

</script>
<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'departamento-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); 

if($model->isNewRecord)
{
	$id_organizacion = Organizacion::model()->find(array('order' => 'nombre_organizacion'));
	$id_organizacion = $id_organizacion->id_organizacion;

	$id_departamento = -1;
}
else 
{
	$id_organizacion = $model->id_organizacion;
	$id_departamento = $model->id_departamento;
}
?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php $organizacionModel = Organizacion::model();  ?>

		<div class="control-group">
			<?php //echo CHtml::activeLabel($model, 'id_organizacion', array('required' => true)); ?>
			<div class="controls">
				<?php echo $form->dropDownListRow($model, 'id_organizacion', CHtml::listData($organizacionModel->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion', 'nombre_organizacion'), 
					array('class'=>'span5',
						'ajax' => array(
							'type' => 'post',
							'dataType'=>'json',
							'data'=>array('idOrg'=> 'js:$("#Departamento_id_organizacion").val()', 'idDep'=> 'js:$("#departamentoAct").val()'),
							'url' => $this->createUrl('departamento/departamentosRelacionados'),
							'success' => 'js:function(data) {
								
								$("#Departamento_id_departamento_rel").replaceWith(data.departamentos);
							}'
						)
					)
				); ?>
			</div>
		</div>
		
		<?php echo $form->textFieldRow($model, 'nombre_departamento', array('class'=>'span5', 'maxlength'=>50)); ?>
		<?php echo $form->hiddenField($model, 'activo', array('class'=>'span3', 'size'=>10,'maxlength'=>10, 'value'=>1)); ?>

		<?php echo CHtml::hiddenField('departamento', $id_departamento, array('id'=>'departamentoAct')); ?>
		<div class="control-group">
			<?php echo CHtml::activeLabel($model, 'id_departamento_rel'); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'id_departamento_rel', CHtml::listData(Departamento::model()->findAll(array('condition' => 'id_organizacion = '.$id_organizacion.' AND id_departamento <> '.$id_departamento/*, 'order' => 'nombre_departamento'*/)), 'id_departamento', 'nombre_departamento'), 
					array('prompt'=>'--Seleccione--', 'class' => 'span5',
					)
				); ?>
				<?php echo $form->error($model, 'id_departamento_rel'); ?>
			</div>
		</div>

	<div class="form-actions">	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->