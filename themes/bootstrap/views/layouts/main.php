<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/scripts/functions.js"></script>

	<title>Control de Flujo de Procesos</title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body class="backg">

<?php

	$menu = new BarraMenu(Yii::app()->user->getId());

	// Si uso acentos se friega. Tengo que revisar eso
	$this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>$menu->crearMenu(),
	));


?>

<div class="container" id="page">

	<div style="top: 60px; position: fixed; width: 1170px; z-index:1000;">
        <div id="flash" class="nodisplay"></div>
    </div>

    <?php
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'closeText'=>false,
            'htmlOptions'=>array('id'=>'info', 'style'=>'top: 60px; position: fixed; width: 1170px;'),
        )
        );
    ?>

  <?php
 /* $user=Yii::app()->user;
  if(!$user->getIsGuest())
  {
     $time= ($user->getState(CWebUser::AUTH_TIMEOUT_VAR) - time()+2)*1000;//converting to millisecs
     Yii::app()->clientScript->registerSCript('timeout','
       setTimeout(function(){
                    window.location="'.Yii::app()->createUrl("cruge/ui/login").'"  ;
                  },'.$time.')',CClientScript::POS_END);
  }*/
  ?>

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs --> 

	<?php endif?>


	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> CFP.<br/>
		Todos los Derechos Reservados.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>

<style type="text/css">
/**Secciones de Contenido**/
.data {
  margin: 40px auto;
  border: 1px solid #cdd3d7;
  border-radius: 8px;
  padding-left: 2em;
  padding-right: 2em;
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.data-title {
  line-height: inherit;
  font-size: 14px;
  font-weight: bold;
  position: relative;
  top: -2em;
  left: -1.5em;
}
.data-body{
	position: relative;
	top: -1.5em;
}

/**Estilo Configuración manual de erroes**/
div.errorForm
{
  padding:.8em;
  margin-bottom:1em;
  border:1px solid #ddd;
  border-radius: 0.3em;

  background:#FBE3E4;
  color:#8a1f11;
  border-color:#FBC2C4;
}

div.errorForm a
{
  color:#8a1f11;
}

/**Tooltip de especificaciones o ayuda**/
.itemAyuda label{ /*float:left;*/ /*padding-top: 5px;*/ display: block;}
.itemAyuda { /*padding-top: 6px;*/}
.itemLabel { float:left; }
.itemAyuda .tooltipAyuda{ float:left; top:2em; left:7px; position:relative; padding-top: 3px; }
.itemAyuda .tooltipAyuda:hover{ z-index:3; }
   .itemAyuda .tooltipAyuda > span{ display:inline-block; width:16px; height:16px; line-height:16px; font-size:0.9em; font-weight:bold; text-align:center; color:#FFF; cursor:help; background-color:#045FB4; position:relative; border-radius:10px;}
    .itemAyuda .tooltipAyuda .content{ opacity:0; width:200px; background-color:#333; color:#FFF; font-size:0.9em; position:absolute; top:0.3em; left:20px; padding:8px; border-radius:6px; pointer-events:none; transition:0.2s cubic-bezier(0.1, 0.1, 0.25, 2); -webkit-transition:0.3s cubic-bezier(0.1, 0.2, 0.5, 2.2); -moz-transition:0.3s cubic-bezier(0.1, 0.2, 0.5, 2.2); }
        .itemAyuda .tooltipAyuda p{ padding:0; z-index:3;}
   .itemAyuda .tooltipAyuda.down .content{ left:auto; right:0; top:30px; }
   .itemAyuda .tooltipAyuda:hover .content{ opacity:1; left:36px; }
      .itemAyuda .tooltipAyuda .content b{ height:0; width:0; border-color:#333 #333 transparent transparent; border-style:solid; border-width:9px 7px; position:absolute; left:-14px; top:8px; }
        .itemAyuda .tooltipAyuda.down .content b{ left:auto; right:6px; top:-10px; border-width:5px; border-color:transparent #333 #333 transparent; }

</style>