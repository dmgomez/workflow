<div>

    <div class="modal-header">
        <h2 id="title-form" style="float: left; margin-right: 0.3em;"></h2> <h2>Recaudo</h2>
    </div> 

	<div class="modal-body">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'dato-adicional-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
		)); ?>

		<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

		<?php //echo $form->errorSummary($model); ?>

		<?php echo CHtml::hiddenField('accion', ''); ?>

		<?php echo $form->hiddenField($model, 'id_proceso', array('value'=>$idProc)); ?>

		<?php echo $form->hiddenField($model, 'id_recaudo'); ?>

		<?php echo $form->textAreaRow($model,'nombreRecaudo',array('class'=>'span6', 'rows'=>'4', 'maxlength'=>250)); ?>
		
		<?php //echo $form->dropDownListRow($model,'obligatorio', array(1=>"Sí", 0=>"No")); ?> 


		<div class="form-actions">
			
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'url'=>$this->createUrl('procesoRecaudo/agregarRecaudo'),
			'size'=>'medium',
			'label'=>'Guardar',
			'htmlOptions'=>array('title'=>'Agrega un recaudo.'),
			'ajaxOptions'=>array(
				'type'=>'POST',
				'data'=>'js:{
					accion: $("#accion").val(), id: $("#ProcesoRecaudo_id_recaudo").val(), idProc: $("#ProcesoRecaudo_id_proceso").val(), nombre: $("#ProcesoRecaudo_nombreRecaudo").val()
				}',
				'dataType'=>'json',
				'success' => "js: function(data) {
					
					if(data.success)
					{
						refresh_grid_recaudo();

					}
					
					$('#agregar-recaudo').modal('hide');

					showAlertAnimatedToggled(data.success, 'Registro agregado con éxito.', data.message, 'Error', data.message);
				}",
			),

		)); ?>

		</div>
			
		 
		<?php $this->endWidget(); ?>


	</div>

    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cerrar</a>	
    </div>

</div>