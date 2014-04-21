<?php 
session_start();

require '../lib/autoloader.php';

Slim\Slim::registerAutoloader();
use Slim\Slim as Slim;

require '../lib/Twig/lib/Twig/Autoloader.php';
require '../lib/Paris/idiorm.php';
require '../lib/Paris/paris.php';
require '../lib/functions.php';
require '../lib/PHPMailer/class.phpmailer.php';

require '../conf.php';


use Slim\Extras\Views\Twig as Twig;
use Slim\Http\Util as Util;
 
$app = new Slim(array(
    'debug' => true,
    'log.enabled'    => true,
    'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(array(
        'path' => '../logs',
        'name_format' => 'Y-m-d',
        'message_format' => '%label% - %date% - %message%'
    )),
    'view' => new Twig,
    'templates.path' => './templates'
));

$admin = new \Acme\Admin;
$admin->app=$app;

require '../app/routes/admin.php';
require '../app/routes/session.php';


$app->run();


?>


