<div>

    <div class="modal-header">
        <h2>Buscar Inmueble</h2>
    </div> 

	<div class="modal-body">

		<p>
			Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
		</p>

		<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'inmueble-grid',
			'dataProvider'=>$model->search(),
			'type'=>'striped',
			'template'=>'{summary}{items}{pager}{summary}',	
			'filter'=>$model,
			'columns'=>array(
				'direccion_inmueble',
				'nombreParroquia',
				//'id_parroquia',
				/*array(
					'name' => 'id_parroquia',
					'value' => '$data->idParroquia->nombre_parroquia',
				),*/
				array(

					'class'=>'CButtonColumn',	
					'template' => '{select}',		
					'buttons' => array(
						'select' => array(
							'label' => 'Seleccionar', 
							'options' => array('title' => 'Selecciona el registro indicado.', 'class' => 'btn'),
							//'type' => 'inverse',
							'url'=>'Yii::app()->createUrl("instanciaProceso/buscarinmuebleporid", array("ID"=>$data->id_inmueble))',
							'click' => "function(e){

								e.preventDefault();

								$.ajax({
									url: $(this).attr('href'), 
									type: 'post',
									dataType: 'json',
									success: function(data) { 						

										if(data.success){
											$('#InstanciaProceso__direccionInmueble').val(data.direccion);
											$('#InstanciaProceso__municipio').val(data.municipio);
											$('#InstanciaProceso__parroquia').val(data.parroquia);
											$('#InstanciaProceso_id_inmueble').val(data.id);

											obtenerGrid();

										}
										else{
											$('#InstanciaProceso__direccionInmueble').val('');
											$('#InstanciaProceso__municipio').val('');
											$('#InstanciaProceso__parroquia').val('');
											$('#InstanciaProceso_id_inmueble').val('');
										}

										showAlertAnimatedToggled(data.success, '', data.message, 'Error', data.message);										
									}									
								});								

								$('#buscar-inmueble').modal('hide');								
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