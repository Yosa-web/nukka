<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\JenisInovasiController;
use App\Models\UserModel;
use app\Database\Migrations\CreateJenisInovasi;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/jenis_inovasi', 'SuperAdminController::index');
$routes->get('/jenis_inovasi/create', 'SuperAdminController::create');
$routes->post('/jenis_inovasi/store', 'SuperAdminController::store');
$routes->get('/jenis_inovasi/edit/(:num)', 'SuperAdminController::edit/$1');
$routes->post('/jenis_inovasi/update/(:num)', 'SuperAdminController::update/$1');
$routes->get('/jenis_inovasi/delete/(:num)', 'SuperAdminController::delete/$1');



service('auth')->routes($routes);
