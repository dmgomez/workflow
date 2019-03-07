<div class="form">
<h1><?php echo ucwords(CrugeTranslator::t("sesiones de usuario"));?></h1>
<?php 
//$this->widget(Yii::app()->user->ui->CGridViewClass, array(
$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'template'=>"{summary}{items}{pager}{summary}",
    'dataProvider'=>$dataProvider,
    'filter'=>false,
    'columns'=>array(
		//'idsession',
		//array('name'=>'iduser','htmlOptions'=>array('width'=>'50px')),
		//array('name'=>'sessionname'/*,'filter'=>''*/),		
		array('name'=>'sessionname', 'htmlOptions'=>array('style' => 'width: 15%'),'filter'=>''),		
		array('name'=>'status'/*,'filter'=>array(1=>'Activa',0=>'Cerrada')*/
			,'value'=>'$data->status==1 ? \'activa\' : \'cerrada\' ','htmlOptions'=>array('style' => 'width: 10%'),'filter'=>''),
		array('name'=>'created','type'=>'datetime','htmlOptions'=>array('style' => 'width: 15%'),'filter'=>''),
		array('name'=>'lastusage','type'=>'datetime','htmlOptions'=>array('style' => 'width: 15%'),'filter'=>''),
		array('name'=>'usagecount','type'=>'number','htmlOptions'=>array('style' => 'width: 10%'),'filter'=>''),
		array('name'=>'expire','type'=>'datetime','htmlOptions'=>array('style' => 'width: 15%'),'filter'=>''),
		array('name'=>'ipaddress','htmlOptions'=>array('style' => 'width: 15%'),'filter'=>''),
		//'ipaddress',
		array(
			//'class'=>'CButtonColumn',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'deleteConfirmation'=>CrugeTranslator::t("Esta seguro de eliminar esta sesion ?"),
			'buttons' => array(
					'delete'=>array(
						'label'=>CrugeTranslator::t("eliminar sesion"),
						//'imageUrl'=>Yii::app()->user->ui->getResource("delete.png"),
						'url'=>'array("sessionadmindelete","id"=>$data->getPrimaryKey())'
					),
				),	
		)	
	),
	'filter'=>$model,
));
?>
</div>