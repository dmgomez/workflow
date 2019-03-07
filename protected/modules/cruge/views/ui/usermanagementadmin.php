<div class="form">
<h1><?php echo ucwords(CrugeTranslator::t('admin', 'Manage Users'));?></h1>
<?php 
/*
	para darle los atributos al CGridView de forma de ser consistente con el sistema Cruge
	es mejor preguntarle al Factory por los atributos disponibles, esto es porque si se decide
	cambiar la clase de CrugeStoredUser por otra entonces asi no haya dependenci directa a los
	campos.
*/
$cols = array();

// presenta los campos de ICrugeStoredUser
foreach(Yii::app()->user->um->getSortFieldNamesForICrugeStoredUser() as $key=>$fieldName){
	$value=null; // default
	$filter=null; // default, textbox
	$type='text';
	if($fieldName == 'state'){
		$value = '$data->getStateName()';
		$filter = Yii::app()->user->um->getUserStateOptions();
	}
	if($fieldName == 'logondate'){
		$type='datetime';
	}
	if($fieldName != 'iduser' && $fieldName != 'email'){
		$cols[] = array('name'=>$fieldName,'value'=>$value,'filter'=>$filter,'type'=>$type);
	}
}
	
$cols[] = array(
	//'class'=>'CButtonColumn',
	'class'=>'bootstrap.widgets.TbButtonColumn',
	
	//'template' => '{update} {delete}',
	'template' => '{update}',
	'deleteConfirmation'=>CrugeTranslator::t('admin', 'Are you sure you want to delete this user'),
	'buttons' => array(
			'update'=>array(
				'label'=>CrugeTranslator::t('admin', 'Update User'),
				'url'=>'array("usermanagementupdate","id"=>$data->getPrimaryKey())'
			),
			/*'delete'=>array(
				'label'=>CrugeTranslator::t('admin', 'Delete User'),
				//'imageUrl'=>Yii::app()->user->ui->getResource("delete.png"),
				'url'=>'array("usermanagementdelete","id"=>$data->getPrimaryKey())',
				'click' => "function(e){

					e.preventDefault();

					$.ajax({
						url: $(this).attr('href'),
						type: 'post',
						dataType: 'json',
						success: function(data) {

							if(data !=null && data.success){
								$.fn.yiiGridView.update('manage-users-grid');
							}

							showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
						}
					});

				}",
			),*/
		),	
);
//$this->widget(Yii::app()->user->ui->CGridViewClass, 
$this->widget('bootstrap.widgets.TbGridView',
	array(
		'type'=>'striped bordered condensed',
		'id'=>'manage-users-grid',
		'template'=>"{summary}{items}{pager}{summary}",
	    'dataProvider'=>$dataProvider,
	    'columns'=>$cols,
		'filter'=>$model,
	));
?>

</div>