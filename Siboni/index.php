<?php

require 'vendor/autoload.php';
require 'lib/DB.php';
require 'lib/Garage.php';

$settings = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];

$app = new \Slim\App($settings);

$container = $app->getContainer();
$container['view'] = function ($c) {
	$view = new \Slim\Views\Twig('views');

// Instantiate and add Slim specific extension
	$basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
	$view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

	return $view;
};

require_once 'app/api/car.php';
require_once 'app/api/wheel.php';

$app->run();
