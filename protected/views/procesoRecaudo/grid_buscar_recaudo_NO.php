<div>

    <div class="modal-header">
        <h2>Buscar Recaudo</h2>
    </div> 

	<div class="modal-body">

		<p>
			Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
		</p>

		<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'recaudo-grid',
			'dataProvider'=>$model->search(),
			'type'=>'striped',
			'template'=>'{summary}{items}{pager}{summary}',	
			'filter'=>$model,
			'columns'=>array(
				'nombre_recaudo',
				
				array(

					'class'=>'CButtonColumn',	
					'template' => '{select}',		
					'buttons' => array(
						'select' => array(
							'label' => 'Seleccionar', 
							'options' => array('title' => 'Selecciona el registro indicado.', 'class' => 'btn'),
							//'type' => 'inverse',
							'url'=>'Yii::app()->createUrl("procesoRecaudo/buscarrecaudoporid", array("ID"=>$data->id_recaudo))',
							'click' => "function(e){

								e.preventDefault();

								$.ajax({
									url: $(this).attr('href'), 
									type: 'post',
									dataType: 'json',
									success: function(data) { 						

										if(data.success){
											$('#ProcesoRecaudo_nombreRecaudo').val(data.nombre);
											$('#ProcesoRecaudo_id_recaudo').val(data.id);
											$('#ProcesoRecaudo_nombreRecaudo').attr('readonly', 'readonly');

										}
										else{
											$('#ProcesoRecaudo_nombreRecaudo').val('');
											$('#ProcesoRecaudo_id_recaudo').val('');
											$('#ProcesoRecaudo_nombreRecaudo').attr('readonly', '');
										}

										showAlertAnimatedToggled(data.success, '', data.message, 'Error', data.message);										
									}									
								});								

								$('#buscar-recaudo').modal('hide');								
							}",
						)
					),
				),
			),
		)); ?>

	</div>

    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cerrar</a>	
    </div>

</div>