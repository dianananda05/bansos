<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/bansos_form', 'BansosController::index');
$routes->post('/bansos/submit', 'BansosController::submit');
$routes->get('/bansos_preview', 'BansosController::submit');


