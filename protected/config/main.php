<?php


//===================================== X-EDITABLE =================================================
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');



//===================================== BOOTSTRAP =================================================
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CFP',
	'language' => 'es',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'editable.*', //easy include of editable classes
		'application.models.*',
		'application.components.*',
		'application.modules.cruge.components.*',
		'application.modules.cruge.extensions.crugemailer.*',
		'application.models.', 'application.components.', 'ext.yii-mail.YiiMailMessage',
		'ext.yii-mail.YiiMailMessage',		
	),
	'theme'=>'bootstrap', //ACTIVANDO EL TEMA DE BOOTSTRAP requires you to copy the theme under your themes directory
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'cruge'=>array(
				'tableprefix'=>'cruge_',

				// para que utilice a protected.modules.cruge.models.auth.CrugeAuthDefault.php
				//
				// en vez de 'default' pon 'authdemo' para que utilice el demo de autenticacion alterna
				// para saber mas lee documentacion de la clase modules/cruge/models/auth/AlternateAuthDemo.php
				//
				'availableAuthMethods'=>array('default'),

				'availableAuthModes'=>array('username','email'),

                                // url base para los links de activacion de cuenta de usuario
				'baseUrl'=>'http://coco.com/',

				 // NO OLVIDES PONER EN FALSE TRAS INSTALAR
				 'debug'=>true,
				 'rbacSetupEnabled'=>true,
				 'allowUserAlways'=>false,

				// MIENTRAS INSTALAS..PONLO EN: false
				// lee mas abajo respecto a 'Encriptando las claves'
				//
				'useEncryptedPassword' => false,

				// Algoritmo de la función hash que deseas usar
				// Los valores admitidos están en: http://www.php.net/manual/en/function.hash-algos.php
				'hash' => 'md5',

				// Estos tres atributos controlan la redirección del usuario. Solo serán son usados si no
				// hay un filtro de sesion definido (el componente MiSesionCruge), es mejor usar un filtro.
				//  lee en la wiki acerca de:
                                //   "CONTROL AVANZADO DE SESIONES Y EVENTOS DE AUTENTICACION Y SESION"
                                //
				// ejemplo:
				//		'afterLoginUrl'=>array('/site/welcome'),  ( !!! no olvidar el slash inicial / )
				//		'afterLogoutUrl'=>array('/site/page','view'=>'about'),
				//
				'afterLoginUrl'=>null,
				'afterLogoutUrl'=>null,
				//'afterSessionExpiredUrl'=>null,
				//'afterSessionExpiredUrl'=>array('/cruge/ui/login'),
				'afterSessionExpiredUrl'=>array('/site/sessionExpired'),

				// manejo del layout con cruge.
				//
				//'loginLayout'=>'//layouts/column2',
				'loginLayout'=>'//layouts/login',
				'registrationLayout'=>'//layouts/column2',
				'activateAccountLayout'=>'//layouts/column2',
				'editProfileLayout'=>'//layouts/column2',
				// en la siguiente puedes especificar el valor "ui" o "column2" para que use el layout
				// de fabrica, es basico pero funcional.  si pones otro valor considera que cruge
				// requerirá de un portlet para desplegar un menu con las opciones de administrador.
				//
				'generalUserManagementLayout'=>'ui',

				// permite indicar un array con los nombres de campos personalizados,
				// incluyendo username y/o email para personalizar la respuesta de una consulta a:
				// $usuario->getUserDescription();
				'userDescriptionFieldsArray'=>array('email'),

			),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),

	),

	// application components
	'components'=>array(
		
		 //X-editable config
        'editable' => array(
            'class'     => 'editable.EditableConfig',
            'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain'
            'mode'      => 'popup',            //mode: 'popup' or 'inline'
            'defaults'  => array(              //default settings for all editable elements
               'emptytext' => 'Click para cambiar'
            )
        ),


		//COMPONENTE DE BOTSTRAP
		'bootstrap'=>array(
		'class'=>'bootstrap.components.Bootstrap',
		),

			'user'=>array(
				'allowAutoLogin'=>true,
				//'authTimeout'=>3000, //50min
				'class' => 'application.modules.cruge.components.CrugeWebUser',
				'loginUrl' => array('/cruge/ui/login'),
			),
			'authManager' => array(
				'class' => 'application.modules.cruge.components.CrugeAuthManager',
			),
			'crugemailer'=>array(
				'class' => 'application.modules.cruge.components.CrugeMailer',
				'mailfrom' => 'email-desde-donde-quieres-enviar-los-mensajes@xxxx.com',
				'subjectprefix' => 'Tu Encabezado del asunto - ',
				'debug' => true,
			),
			'format' => array(
				'datetimeFormat'=>"d M, Y h:m:s a",
			),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'ePdf' => array(
			'class' => 'ext.yii-pdf.EYiiPdf',
			'params' => array(
				'mpdf' => array(
					'librarySourcePath' => 'application.vendor.mpdf.*',
					'constants' => array(
						'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
					 ),
					'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
				),
			),
		),

		'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType'=>'smtp',
            'transportOptions'=>array(
                    'host'=>'smtp.gmail.com',
                    'username'=>'pruebasistema@adamantium.com.ve',
                    'password'=>'5<8RBaCQ',
                    'port'=>'465',
                    'encryption'=>'ssl',                  
            ),
            'viewPath' => 'application.views.mail',
            //'logging' => true,
            //'dryRun' => false         
        ),

		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),

		'db'=>array(

		//'connectionString' => 'pgsql:host=192.168.100.254;port=5432;dbname=workflow',
	    //'username' => 'postgres',
        //'password' => 'j-297317961p',
		'connectionString' => 'pgsql:host=127.0.0.1;port=5432;dbname=workflow',
	    'username' => 'postgres',
        'password' => 'postgres',
        'charset' => 'utf8',
        ),

		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);

