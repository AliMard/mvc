<?php


date_default_timezone_set('Asia/Tehran');
session_start();


require_once 'core/database.php';
require_once 'core/app.php';
require_once 'core/controller.php';
require_once 'core/model.php';



//require helper class
require_once 'helper/jdatetime.class.php';
require_once 'helper/validate.php';


//require lib

require_once 'lib/vendor/autoload.php';







define("ASSET_ROOT",'http://'.

    $_SERVER["HTTP_HOST"].

    str_replace(
        $_SERVER["DOCUMENT_ROOT"] ,
        '',
        str_replace('\\','/',dirname(__DIR__).'/public/')
    )
);



define("BASE_URL",'http://'.

    $_SERVER["HTTP_HOST"].

    str_replace(
        $_SERVER["DOCUMENT_ROOT"] ,
        '',
        str_replace('\\','/',dirname(__DIR__).'/')
    )
);




// jwt const variable



define('JWT_AUDIENCE','test');
define('JWT_ISSUER','test');

define('JWT_ALGORITHM_KEY','test');








?>