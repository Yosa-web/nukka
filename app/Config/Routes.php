<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\JenisInovasiController;
use App\Models\UserModel;
use app\Database\Migrations\CreateJenisInovasi;

use App\Controllers\SuperAdminController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/jenis_inovasi', 'Superadmin\KelolaJenisInovasi::index');
$routes->get('/jenis_inovasi/create', 'Superadmin\KelolaJenisInovasi::create');
$routes->post('/jenis_inovasi/store', 'Superadmin\KelolaJenisInovasi::store');
$routes->get('/jenis_inovasi/edit/(:num)', 'Superadmin\KelolaJenisInovasi::edit/$1');
$routes->post('/jenis_inovasi/update/(:num)', 'Superadmin\KelolaJenisInovasi::update/$1');
$routes->get('/jenis_inovasi/delete/(:num)', 'Superadmin\KelolaJenisInovasi::delete/$1');


service('auth')->routes($routes);



//Kelola Data OPD
$routes->group('', ['filter' => 'group:user'], function ($routes) {
    $routes->get('/superadmin/opd/create', 'Superadmin\KelolaOpd::createOpd');
    $routes->post('/superadmin/opd/store', 'Superadmin\KelolaOpd::storeOpd');
    $routes->get('/superadmin/opd', 'Superadmin\KelolaOpd::index');
    $routes->get('/superadmin/opd/(:num)/edit', 'Superadmin\KelolaOpd::editOpd/$1');
    $routes->put('/superadmin/opd/update/(:num)', 'Superadmin\KelolaOpd::updateOpd/$1');
    $routes->delete('/superadmin/opd/(:num)', 'Superadmin\KelolaOpd::deleteOpd/$1');
});
