<?php 
session_start();

require '../lib/Slim/Slim.php';

Slim\Slim::registerAutoloader();
use Slim\Slim as Slim;

require '../lib/Slim/Extras/Views/Twig.php';
require '../lib/Twig/lib/Twig/Autoloader.php';
require '../lib/Paris/idiorm.php';
require '../lib/Paris/paris.php';
require '../lib/Admin_class.php';
require '../lib/functions.php';
require '../lib/PHPMailer/class.phpmailer.php';

require '../conf.php';

//Models

require '../models/City.php';
require '../models/CityName.php';
//require '../models/Site.php';
//require '../models/User.php';

use Slim\Extras\Views\Twig as Twig;
 
$app = new Slim(array(
    'log.enabled'    => true,
    'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(array(
        'path' => '../logs',
        'name_format' => 'Y-m-d',
        'message_format' => '%label% - %date% - %message%'
    )),
    'view' => new Twig,
    'templates.path' => './templates'
));

$admin = new Admin();
$admin->app=$app;

require '../app/routes/admin.php';
require '../app/routes/session.php';


$app->run();


?>

