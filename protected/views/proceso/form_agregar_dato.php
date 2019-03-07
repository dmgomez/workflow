<div>

    <div class="modal-header">
        <h2 id="title-form" style="float: left; margin-right: 0.3em;"></h2> <h2>Dato Adicional</h2>
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

		<?php echo $form->hiddenField($model, 'id_dato_adicional'); ?>

		<?php echo $form->textFieldRow($model, 'nombreDatoAdicional', array('class'=>'span6', 'size'=>10, 'maxlength'=>100)); ?>
		
		<?php echo $form->dropDownListRow($model,'tipoDatoAdicional', CHtml::listData(TipoDato::model()->findAll(array('order' => 'nombre_tipo_dato')), 'id_tipo_dato','nombre_tipo_dato'), array('prompt'=>'--Seleccione--' /*'class'=>'span12'*/)); ?> 

		<?php //echo $form->numberField($model,'orden', array('class'=>'span1')); ?> 

		<?php //echo $form->dropDownListRow($model,'obligatorio', array(1=>"Sí", 0=>"No")); ?> 


		<div class="form-actions">
			
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'url'=>$this->createUrl('proceso/agregarDatoAdicional'),
			'size'=>'medium',
			'label'=>'Guardar',
			'htmlOptions'=>array('title'=>'Agrega un dato adicional.'),
			'ajaxOptions'=>array(
				'type'=>'POST',
				'data'=>'js:{
					accion: $("#accion").val(), id: $("#ProcesoDatoAdicional_id_dato_adicional").val(), idProc: $("#ProcesoDatoAdicional_id_proceso").val(), nombre: $("#ProcesoDatoAdicional_nombreDatoAdicional").val(), tipo: $("#ProcesoDatoAdicional_tipoDatoAdicional").val()
				}',
				'dataType'=>'json',
				'success' => "js: function(data) {
					
					if(data.success)
					{
						refresh_grid_datoA();

						$('#agregar-dato-adicional').modal('hide');
					}
					else
					{
						$('#agregar-dato-adicional').modal('hide');
					}

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