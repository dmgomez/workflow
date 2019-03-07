<div>

    <div class="modal-header">
        <h2>Buscar Dato Adicional</h2>
    </div> 

	<div class="modal-body">

		<p>
			Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
		</p>

		<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'dato-grid',
			'dataProvider'=>$model->search(),
			'type'=>'striped',
			'template'=>'{summary}{items}{pager}{summary}',	
			'filter'=>$model,
			'columns'=>array(
				'nombre_dato_adicional',
				array('name'=>'tipo_dato_adicional', 'value'=>'$data->tipoDatoAdicional()'),
				array(

					'class'=>'CButtonColumn',	
					'template' => '{select}',		
					'buttons' => array(
						'select' => array(
							'label' => 'Seleccionar', 
							'options' => array('title' => 'Selecciona el registro indicado.', 'class' => 'btn'),
							//'type' => 'inverse',
							'url'=>'Yii::app()->createUrl("proceso/buscarDatoPorId", array("ID"=>$data->id_dato_adicional))',
							'click' => "function(e){

								e.preventDefault();

								$.ajax({
									url: $(this).attr('href'), 
									type: 'post',
									dataType: 'json',
									success: function(data) { 						

										if(data.success){
											$('#ProcesoDatoAdicional_nombreDatoAdicional').val(data.nombre);
											$('#ProcesoDatoAdicional_id_dato_adicional').val(data.id);
											$('#ProcesoDatoAdicional_tipoDatoAdicional').val(data.tipo);

											$('#ProcesoDatoAdicional_nombreDatoAdicional').attr('readonly', 'readonly');
											$('#ProcesoDatoAdicional_tipoDatoAdicional').attr('disabled', true); 

											$('#buscar-dato-adicional').modal('hide');	
											$('#agregar-dato-adicional').modal('show');	
										}
										else{
											$('#ProcesoDatoAdicional_nombreDatoAdicional').val('');
											$('#ProcesoDatoAdicional_id_dato_adicional').val('');
											$('#ProcesoDatoAdicional_tipoDatoAdicional').val('');

											$('#ProcesoDatoAdicional_nombreDatoAdicional').attr('readonly', false);
											$('#ProcesoDatoAdicional_tipoDatoAdicional').attr('disabled', false);

											$('#buscar-dato-adicional').modal('hide');	
										}

										showAlertAnimatedToggled(data.success, '', data.message, 'Error', data.message);										
									}									
								});								

															
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