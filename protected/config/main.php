<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Ivers Care Services',
    'theme' => 'ams',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.admin.models.*',
        'application.modules.srbac.*',
        'application.modules.srbac.controllers.SBaseController',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'admin', 'staff', 'finance',
        'srbac' => array(
            'userclass' => 'User', //default: User
            'userid' => 'id', //default: userid
            'username' => 'username', //default:username
            'delimeter' => '@', //default:-
            'debug' => true, //default :false
            'pageSize' => 10, // default : 15
            'superUser' => 'Authority', //default: Authorizer
            'css' => 'srbac.css', //default: srbac.css
            'layout' =>
            'application.views.layouts.main', //default: application.views.layouts.main,//must be an existing alias
            'notAuthorizedView' => 'srbac.views.authitem.unauthorized', // default:
//srbac.views.authitem.unauthorized, must be an existing alias
            'alwaysAllowed' => array(
//default: array()
                'SiteLogin', 'SiteLogout', 'SiteIndex', 'SiteAdmin',
                'SiteError', 'SiteContact'),
            'userActions' => array('Show', 'View', 'List'), //default: array()
            'listBoxNumberOfLines' => 15, //default : 10
            'imagesPath' => 'srbac.images', // default: srbac.images
            'imagesPack' => 'noia', //default: noia
            'iconText' => true, // default : false
            'header' => 'srbac.views.authitem.header', //default : srbac.views.authitem.header,
//must be an existing alias
            'footer' => 'srbac.views.authitem.footer', //default: srbac.views.authitem.footer,
//must be an existing alias
            'showHeader' => true, // default: false
            'showFooter' => true, // default: false
            'alwaysAllowedPath' => 'srbac.components', // default: srbac.components
// must be an existing alias
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */

        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'authManager' => array(
// Path to SDbAuthManager in srbac module if you want to use case insensitive
//access checking (or CDbAuthManager for case sensitive access checking)
            'class' => 'modules.srbac.components.SDbAuthManager',
// The database component used
            'connectionID' => 'db',
// The itemTable name (default:authitem)
            'itemTable' => 'items',
// The assignmentTable name (default:authassignment)
            'assignmentTable' => 'assignments',
// The itemChildTable name (default:authitemchild)
            'itemChildTable' => 'itemchildren',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
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
    'params' => array(
        'website' => 'http://localhost/hospital-shift-schedule/',
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'staffPassword' => '123',
        'staffStatus' => array(
            "D" => "Draft",
            "A" => "Active",
            "I" => "Inactive",
            "S" => "Suspended",
            "Ar" => "Archive"
        ),
        'shiftStatus' => array(
            "A" => "Active",
            "C" => "Confirmed",
            "R" => "Rejected"
        ),
        'profileImage' => array(
            "Male" => "1666-male.jpg",
            "Female" => "2043-female.png"
        ),
        'status' => array(
            "Y" => "Yes",
            "N" => "No"
        ),
        'staffType' => array(
            "A" => "Admin",
            "D" => "Director / Supervisor",
            "C" => "Co-ordinator",
            "M" => "Manager",
            "S" => "Staff himself / herself",
            "H" => "Hospital",
            "F" => "Finance",
            "NA" => "Not Applicable",
        ),
        'textLocal' => array(
            'username' => 'takunda@iverscareservices.co.uk',
            'hash' => '574c1124d1a41e3be91b2dbfc1658503394eba97'
        ),
        'timesheetEmail' => array(
            'email' => 'timesheets@iverscareservices.co.uk'
//            'email' => 'shinningtech@gmail.com'
//            'email' => 'idio.ibrahim@gmail.com'
        ),
    ),
);
